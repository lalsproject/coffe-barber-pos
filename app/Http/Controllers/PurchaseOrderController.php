<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class PurchaseOrderController extends Controller
{
    public function listApproval()
    {
        $purchaseOrders = DB::table('purchase_orders')
                        ->join('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
                        ->select('purchase_orders.id', 'purchase_orders.po_number',
                                'suppliers.name AS supplierName', 'suppliers.id AS supplierId',
                                'purchase_orders.status')
                        ->orderBy('purchase_orders.created_at', 'desc')
                        ->get();

        return view('transaction.purchase-order.listApproval', [
            'purchaseOrders' => $purchaseOrders
        ]);
    }

    public function showApproval(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $purchaseOrders = DB::table('purchase_orders')
                        ->join('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
                        ->select('purchase_orders.id', 'purchase_orders.po_number',
                                'suppliers.name AS supplierName', 'purchase_orders.status')
                        ->whereBetween(DB::raw('DATE(purchase_orders.created_at)'), [$request->start_date, $request->end_date])
                        ->get();

        return view('transaction.purchase-order.listApproval', [
            'purchaseOrders' => $purchaseOrders
        ]);
    }

    public function addInventory($purchaseOrderId)
    {
        $purchaseOrderItem = PurchaseOrderItem::find($purchaseOrderId);
        $purchaseOrderItem->update([
            'status' => PurchaseOrderItem::APPROVED
        ]);

        $product = Product::find($purchaseOrderItem->product_id);
        $product->update([
            'stock' => $product->stock + $purchaseOrderItem->qty
        ]);

        return redirect()->back()->with('success', 'Approval Purchase Order success!');
    }

    public function detailApproval($purchaseOrderId)
    {
        $purchaseOrder = PurchaseOrder::where('id', $purchaseOrderId)->first();
        $purchaseOrderItems = DB::table('purchase_order_items')
                        ->join('products', 'purchase_order_items.product_id', '=', 'products.id')
                        ->select('purchase_order_items.id', 'products.name AS productName', 'purchase_order_items.qty', 'purchase_order_items.status')
                        ->where('purchase_order_items.purchase_order_id', $purchaseOrderId)
                        ->get();

        return view('transaction.purchase-order.detailApproval', [
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderItems' => $purchaseOrderItems,
            'purchaseOrderId' => $purchaseOrderId
        ]);
    }

    public function approvalForm($purchaseOrderId)
    {
        $purchaseOrder = PurchaseOrder::find($purchaseOrderId);
        return view('transaction.purchase-order.approved', [
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderId' => $purchaseOrderId
        ]);
    }

    public function approved(Request $request, $purchaseOrderId)
    {
        $purchaseOrderItemPendingExist = PurchaseOrderItem::where('status', PurchaseOrderItem::PENDING)->exists();

        if ($purchaseOrderItemPendingExist)
        {
            return redirect()->back()->with('error', 'For Approved all Product must be add stock!');
        }

        $request->validate([
            'status' => 'required'
        ]);

        $purchaseOrder = PurchaseOrder::find($purchaseOrderId);
        $purchaseOrder->update([
            'status' => $request->status,
            'notes' => $request->status == PurchaseOrder::COMPLETED ? PurchaseOrder::COMPLETED : $request->notes
        ]);

        return redirect()->route('purchase-orders.list-approval')->with('success', 'Approval Purchase Order success!');
    }

    public function create()
    {
        $suppliers = Supplier::get();
        $products = Product::get();
        return view('transaction.purchase-order.create', [
            'suppliers' => $suppliers,
            'products' => $products
        ]);
    }

    public function edit($purchaseOrderId)
    {
        $purchaseOrder = PurchaseOrder::find($purchaseOrderId);
        $purchaseOrderItems = PurchaseOrderItem::where('purchase_order_id', $purchaseOrderId)->get();
        $nettPrice = $purchaseOrder->total;
        $suppliers = Supplier::get();
        $products = Product::get();
        return view('transaction.purchase-order.edit', [
            'purchaseOrder' => $purchaseOrder,
            'purchaseOrderItems' => $purchaseOrderItems,
            'products' => $products,
            'suppliers' => $suppliers,
            'nettPrice' => $nettPrice
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_id' => 'required',
            'delivery_date' => 'required',
            'shipping_address' => 'required'
        ]);

        $priceWithoutDiscount = $request->nettPrice;
        $discount = $request->discount * $request->nettPrice / 100;
        $grandTotal = $request->nettPrice - $discount;

        $purchaseOrder = PurchaseOrder::find($id);
        $purchaseOrder->update([
            'supplier_id' => $request->supplier_id,
            'delivery_date' => $request->delivery_date,
            'shipping_address' => $request->shipping_address,
            'discount' => $request->discount,
            'consigned_to' => $request->consigned_to,
            'subtotal' => $priceWithoutDiscount,
            'grand_total' => $grandTotal,
            'total' => $grandTotal,
            'status' => PurchaseOrder::PENDING,
            'user_id' => Auth::user()->id
        ]);

        PurchaseOrderItem::where('purchase_order_id', $purchaseOrder->id)->delete();
        $purchaseOrderSum = 0;
        foreach($request->purchaseOrderInput as $key => $value)
        {
            PurchaseOrderItem::create([
                'product_id' => $value['product_id'],
                'price' => $value['price'],
                'qty' => $value['qty'],
                'purchase_order_id' => $purchaseOrder->id,
                'total_amount' => $value['total_amount'],
                'status' => PurchaseOrder::PENDING,
                'user_id' => Auth::user()->id,
            ]);

            $purchaseOrderSum += $value['qty'];
        }

        return redirect()->back()->with('success', 'Purchase Order success updated');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'delivery_date' => 'required',
            'shipping_address' => 'required'
        ]);

        $priceWithoutDiscount = $request->nettPrice;
        $discount = $request->discount * $request->nettPrice / 100;
        $grandTotal = $request->nettPrice - $discount;


        $purchaseOrder = PurchaseOrder::create([
            'supplier_id' => $request->supplier_id,
            'delivery_date' => $request->delivery_date,
            'shipping_address' => $request->shipping_address,
            'discount' => $request->discount,
            'subtotal' => $priceWithoutDiscount,
            'grand_total' => $grandTotal,
            'total' => $grandTotal,
            'status' => PurchaseOrder::PENDING,
            'user_id' => Auth::user()->id
        ]);

       foreach ($request->purchaseOrderInput as $key => $value)
       {
            PurchaseOrderItem::create([
                'product_id' => $value['product_id'],
                'price' => $value['price'],
                'qty' => $value['qty'],
                'purchase_order_id' => $purchaseOrder->id,
                'total_amount' => $value['total_amount'],
                'status' => PurchaseOrder::PENDING,
                'user_id' => Auth::user()->id
            ]);
       }

       return redirect()->back()->with('success', 'Purchase Order success created');
    }

    public function createApprovalWithSoNumber($id, $supplierId)
    {
        $purchaseOrder = PurchaseOrder::find($id);
        return view('transaction.purchase-order.approval', [
            'purchaseOrder' => $purchaseOrder,
            'supplierId' => $supplierId
        ]);
    }

    public function approvedWithSoNumber(Request $request, $id)
    {
        $purchaseOrder = PurchaseOrder::find($id);
        $purchaseOrder->update([
            'status' => PurchaseOrder::APPROVED,
            'so_number' => $request->so_number
        ]);

        return redirect()->route('purchase-orders.list-approval')->with('success', 'Approved success');
    }

    public function exportPurchaseOrder($id)
    {
        $purchaseOrders = DB::table('purchase_orders')
            ->join('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
            ->join('users', 'purchase_orders.user_id', '=', 'users.id')
            ->select('purchase_orders.*', 'users.name AS userName',
                'suppliers.name AS supplierName', 'suppliers.email AS supplierEmail', 'suppliers.contact_person AS supplierContact',
                'suppliers.phone AS supplierPhone', 'suppliers.type AS supplierType', 'suppliers.currency_code AS supplierCurrencyCode',
                'suppliers.free_ppn AS supplierFreePPN')
            ->where('purchase_orders.id', $id)
            ->first();

        $purchaseOrderItems = DB::table('purchase_order_items')
            ->join('products', 'purchase_order_items.product_id', '=', 'products.id')
            ->join('units', 'products.unit_id', '=', 'units.id')
            ->select('purchase_order_items.id', 'products.name AS productName', 'products.description AS description',
                'purchase_order_items.qty', 'purchase_order_items.status', 'units.name AS unitName', 'purchase_order_items.price',)
            ->where('purchase_order_items.purchase_order_id', $purchaseOrders->id)
            ->get();

        $discount = $purchaseOrders->discount * $purchaseOrders->subtotal / 100;
        $totalNett = $purchaseOrders->subtotal - $discount;

        $supplier = Supplier::find($purchaseOrders->supplier_id);
        $company = Company::where('code', $purchaseOrders->supplierType)->first();
        $pdf = PDF::loadView("report.purchase-order.pdf", [
            'purchaseOrders' => $purchaseOrders,
            'discount' => $discount,
            'totalNett' => $totalNett,
            'company' => $company,
            'supplier' => $supplier,
            'purchaseOrderItems' => $purchaseOrderItems
        ]);

        return $pdf->stream('report-purchase-order.pdf');
    }
}
