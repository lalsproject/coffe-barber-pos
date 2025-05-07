<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Capster;
use App\Models\DepositTransaction;
use App\Models\Service;
use App\Models\TransactionCapster;
use App\Models\TransactionCapsterDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionCapsterController extends Controller
{

    public function index(){
        $transactionDetails = [];
        $transactionCapsters = TransactionCapster::orderBy('created_at','desc')->get();
        $transactionDetailCapster = TransactionCapsterDetail::orderBy('created_at','desc')->get();

        foreach($transactionCapsters as  $transactionCapster){
            $serviceNames = [];
            $findCaspterServices = TransactionCapsterDetail::where('transaction_capster_id',$transactionCapster->id)->get();
            foreach($findCaspterServices as $service){
                $serviceName = Service::where('id', $service->service_id)->first();
                if ($serviceName) {
                    $serviceNames[] = $serviceName->name.',';
                }
            }
            $findNameCapster = Capster::where('id',$transactionCapster->capster_id)->first();
            $transactionDetails[] = [
                'capsterId' => $transactionCapster->id,
                'capsterName' => $findNameCapster,
                'serviceNames' => $serviceNames
            ];
        }
    

        return view('transaction.capster.index',[
            'transactionDetails' => $transactionDetails,
        ]);
    }

    public function create()
    {
        $capsters = Capster::get();
        $services = Service::get();
        return view('transaction.capster.create', [
            'capsters' => $capsters,
            'services' => $services
        ]);
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'capster_id' => 'required',
        //     'service_id' => 'required'
        // ]);

        $transaction_capster = TransactionCapster::create([
            'capster_id' => $request->capster_id,
            'total' => $request->total
        ]);

       foreach ($request->serviceInput as $key => $value)
       {
            TransactionCapsterDetail::create([
                'service_id' => $value['service_id'],
                'quantity' => $value['quantity'],
                'transaction_capster_id' => $transaction_capster->id
            ]);
       }

       return redirect()->back()->with('success', 'Transaction Capster success created');
    }


    public function onTransactionCapsterSubmited(Request $request){
        $transactionDetails = [];
        $transactions = $request->all();     
        $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . now()->format('His');
        $find_deposit_with_user = DepositTransaction::where('user_id',Auth::user()->id)->where('count',1)->first();
        $branch_id = $find_deposit_with_user->branch_id;
        $current_date = Carbon::now()->format('Y-m-d H:i:s');

        try{
            foreach ($transactions as $transaction) {
                if (!isset($transaction['total'])){
                    throw new \Exception('Service Tidak Boleh Kosong ');
                }else if (!isset($transaction['capsterId'])) {
                    throw new \Exception('Capster Tidak Boleh Kosong');
                }
                
                // Access individual transaction fields
                $productsPaymentsServices = $transaction['serviceIds'];
                $totalProductServices = $transaction['total'];
                $cashPay = $transaction['cash_pay'];
                $paymentMethod = $transaction['payment_method'];
                $capsterId = $transaction['capsterId'];
                $cash_integer = (int) str_replace('.', '', $cashPay);
    
    
                $transactionCapster = TransactionCapster::create([
                    'transaction_number' => $invoiceNumber,
                    'branch_id' => $branch_id,
                    'capster_id' => $capsterId,
                    'user_id' => Auth::user()->id,
                    'payment_method' => $paymentMethod,
                    'transaction_date_time' => $current_date,
                    'status' => TransactionCapster::UNPAID,
                    'money_received' => $cash_integer,
                    'total' => $totalProductServices
                ]);
    
                foreach($productsPaymentsServices as $service){
    
                    $transactionDetail = TransactionCapsterDetail::create([
                        'transaction_id' => $transactionCapster->id,
                        'service_id' => $service['service_id'],
                        'quantity' => $service['quantity'],
                        'transaction_capster_id' => $transactionCapster->capster_id
                    ]);
    
                    $serviceFind = Service::where('id',$service['service_id'])->first();
                    $total = intval($serviceFind->price) * intval($service['quantity']);
    
                    $transactionDetails[] =[
                        'transaction_id' => $transactionDetail->id,
                        'service_id' => $service['service_id'],
                        'service_name' => $serviceFind->name,
                        'service_price' => $serviceFind->price,
                        'quantity' => $service['quantity'],
                        'total' => $total,
                    ];
                }

                $cashierName = User::find($transactionCapster->user_id);
                $capster = Capster::find($transactionCapster->capster_id);
                $branch = Branch::find($transactionCapster->branch_id);
    
                return response()->json([
                    'message' => 'Transaction submitted successfully!',
                    'transactionCapster' => $transactionCapster,
                    'transactionDetails' => $transactionDetails,
                    'cashierName' => $cashierName->name,
                    'branchName' => $branch->branch,
                    'capsterName' => $capster->name
                ]);
            }
        }catch(\Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
       
    
       
    }


    public function edit($transactionCapsterId)
    {
        $transactionCaspter = TransactionCapster::find($transactionCapsterId);
        $transctionCapsterDetails = TransactionCapsterDetail::where('transaction_capster_id', $transactionCapsterId)->get();
        $capsters = Capster::get();
        $services = Service::get();
        return view('transaction.capster.edit', [
            'transactionCaspter' => $transactionCaspter,
            'transctionCapsterDetails' => $transctionCapsterDetails,
            'capsters' => $capsters,
            'services' => $services
        ]);
    }

    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'caspter_id' => 'required',
        //     'service_id' => 'required'
        // ]);

    

        $transactionCapster = TransactionCapster::find($id);
        $transactionCapster->update([
            'capster_id' => $request->capster_id,
            'total' => $request->total
        ]);

        TransactionCapsterDetail::where('transaction_capster_id', $transactionCapster->id)->delete();

        foreach($request->serviceInput as $key => $value)
        {
            TransactionCapsterDetail::create([
                'service_id' => $value['service_id'],
                'transaction_capster_id' => $transactionCapster->id,
                'quantity' => $value['quantity']
            ]);
        }

        return redirect()->back()->with('success', 'Transaction Capster  success updated');
    }

    public function onShowTransactionDetail(Request $request) {
        $param = $request->query('queryParam');
        $transaction_id = $param['transaction_id'] ?? null;
        $transaction = TransactionCapster::find($transaction_id);
        $transaction_details = TransactionCapsterDetail::orderBy('created_at','asc')->where('transaction_id',$transaction_id)->get();

        return view('dialog.capster.dialog-transaction',compact('transaction','transaction_details'));
    }



}
