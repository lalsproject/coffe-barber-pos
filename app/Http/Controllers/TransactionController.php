<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DepositTransaction;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    function index(){

        $products = Cache::remember('products', 60, function () {
            return Product::select('id', 'name', 'description', 'stock','price','image', 'brand_id', 'created_at')->where('stock','!=','0')->with('brand')->latest()->get();
        });

        $is_product_available = count($products) != 0;

        return view('transaction.index', ['products' => $products,'is_product_available' => $is_product_available]);
    }

    public function productFilter(Request $request)
    {
        $request->validate(['queryParam.productName' => 'nullable|string|max:255', ]);
        $param = $request->query('queryParam');
        $productName = $param['productName'] ?? null;
        $productsQuery = Product::query();

        if (filled($productName)) {
            $productsQuery->where('name', 'LIKE', "%$productName%");
        }
        $products = $productsQuery->select('id', 'name', 'price', 'image','stock')->get();

        $productData = $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->getImage(),
                'stock' => $product->stock,
            ];
        });

        return response()->json(['result' => 'success', 'data' => $productData]);
    }

    public function onTransactionSubmited(Request $request){
        $transactionDetails = [];
        $transactions = $request->all();
        $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . now()->format('His');
        $find_deposit_with_user = DepositTransaction::where('user_id',Auth::user()->id)->where('count',1)->first();
        $branch_id = $find_deposit_with_user->branch_id;
        $current_date = Carbon::now()->format('Y-m-d H:i:s');

    
        foreach ($transactions as $transaction) {
            // Access individual transaction fields
            $productsPayments = $transaction['products_payment'];
            $totalProduct = $transaction['total_product'];
            $cashPay = $transaction['cash_pay'];
            $paymentMethod = $transaction['payment_method'];
            $cash_integer = (int) str_replace('.', '', $cashPay);

            $transaction = Transaction::create([
                'transaction_number' => $invoiceNumber,
                'branch_id' => $branch_id,
                'user_id' => Auth::user()->id,
                'payment_method' => $paymentMethod,
                'transaction_date_time' => $current_date,
                'status' => Transaction::UNPAID,
                'money_received' => $cash_integer,
                'total_transaction' => $totalProduct,
            ]);

            foreach($productsPayments as $product){
                $transactionDetail = TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity']
                ]);

                $product_stock = Product::where('id',$product['id'])->first();
                $total = intval($product_stock->price) * intval($product['quantity']);

                $transactionDetails[] =[
                    'transaction_id' => $transactionDetail->id,
                    'product_id' => $product['id'],
                    'product_name' => $product_stock->name,
                    'product_price' => $product_stock->price,
                    'quantity' => $product['quantity'],
                    'total' => $total,
                ];

                $product_stock = Product::where('id',$product['id'])->first();
                $quantity_stock = $product_stock->stock - $product['quantity'];

                $product_stock->update([
                    'stock' => $quantity_stock
                ]);
            }
        }

        $cashier_name = User::find($transaction->user_id);
        $branch = Branch::find($transaction->branch_id);

        return response()->json([
            'message' => 'Transaction submitted successfully!',
            'transaction' => $transaction,
            'transaction_details' => $transactionDetails,
            'branch_name' => $branch->branch,
            'cashier_name' =>  $cashier_name->name,
        ]);
    }


    public function onTransactionShown(Request $request){
        $id_transaction = $request->input('id_transaction');
        $transaction_details = TransactionDetail::where('transaction_id',$id_transaction)->get();

        return response()->json(['result' => 'success', 'data' => $transaction_details]);
    }


    public function onDepositSubmit(Request $request) {

        $data = $request->json()->all();
        foreach ($data as $deposit) {
            $branchId = $deposit['id_branch'] ?? null;
            $amount = $deposit['amount'] ?? 0;
            $type = $deposit['type'] ?? '';

            DepositTransaction::create([
                'amount' => $amount,
                'revenue' => 0,
                'user_id' =>  Auth::user()->id,
                'branch_id' => $branchId,
                'type' => $type,
                'count' => 1,
            ]);
        }

        return response()->json([
            'message' => 'Transaction submitted successfully!'
        ]);

    }

    public function onCloseStoreSubmit(Request $request) {

        $currencyClosing = $request->all()[0];
        $now_date = Carbon::now()->toDateString();
        $deposit_transaction = DepositTransaction::where(DB::raw('DATE(created_at)'),$now_date)->where('user_id',Auth::user()->id)->first();
        

        $deposit_transaction->update([
            'revenue' => $currencyClosing,
            'type' => DepositTransaction::CASH_OUT,
            'count' => 0
        ]);

        return response()->json([
            'message' => 'Transaction submitted successfully!'
        ]);
    }


    public function onShowTransactionDetail(Request $request) {
        $param = $request->query('queryParam');
        $transaction_id = $param['transaction_id'] ?? null;
        $transaction = Transaction::find($transaction_id);
        $transaction_details = TransactionDetail::orderBy('created_at','asc')->where('transaction_id',$transaction_id)->get();

        return view('dialog.dialog-transaction',compact('transaction','transaction_details'));
    }
}
