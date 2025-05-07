<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\DepositTransaction;
use App\Models\Transaction;
use App\Models\TransactionCapster;
use App\Models\TransactionCapsterDetail;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $current_date = Carbon::now()->format('Y-m-d');
        $is_deposit = false;
        $is_btn_visible = false;
        $total_selling = 0;
        $total_selling_capster = 0;
        $total_transaction = 0;
        $total_product_selling= 0;

        $branches = Branch::orderBy('created_at','desc')->get();

        $find_deposit_with_user = DepositTransaction::where('user_id',Auth::user()->id)->where(function ($query) {
            $query->where('type', DepositTransaction::CASH_IN)
                    ->orWhere('type', DepositTransaction::CASH_OUT);
        })->whereDate('created_at',$current_date)->first();

        $findCashOut = DepositTransaction::where('user_id',Auth::user()->id)->where(function ($query) {
            $query->Where('type', DepositTransaction::CASH_OUT);
        })->whereDate('created_at',$current_date)->first();

        $transactions =  Transaction::whereBetween(DB::raw('DATE(created_at)'), [$current_date,$current_date])
        ->where('status', Transaction::PAID)->get();

        $transactionCapsters = TransactionCapster::whereBetween(DB::raw('DATE(created_at)'), [$current_date,$current_date])
        ->where('status', Transaction::PAID)->get();

        $transaction_details = TransactionDetail::where(DB::raw('DATE(created_at)'), [$current_date,$current_date])->get();   
        $transaction_capster_details = TransactionCapsterDetail::where(DB::raw('DATE(created_at)'), [$current_date,$current_date])->get();
       
        if($find_deposit_with_user != null){
            $date_cash_in = Carbon::parse($find_deposit_with_user->created_at)->format('Y-m-d');
            $is_deposit = $current_date === $date_cash_in; 
        }else {
            $is_deposit = false;
        }

        foreach($transactions as $transaction){
            $total_selling += $transaction->total_transaction;
        }
        foreach($transactionCapsters as $transactionCapster ){
            $total_selling_capster += $transactionCapster->total;
        }
        $total_transaction = count($transactions) + count($transactionCapsters);
        $total_product_selling = count($transaction_details) + count($transaction_capster_details);
        $total_selling = $total_selling + $total_selling_capster;
        $is_btn_visible = $findCashOut != null;

        return view('home', [
            'start_date' => $current_date,
            'end_date' => $current_date,
            'branches' => $branches,'is_deposit' => $is_deposit,
            'total_selling' => $total_selling,'total_transaction' => $total_transaction,
            'total_product_selling' => $total_product_selling,'is_btn_visible' => $is_btn_visible]);
    }


    function onFilterTransaction(Request $request){
        $current_date = Carbon::now()->format('Y-m-d');
        $is_deposit = false;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $branch_id = $request->branch;
        $total_selling = 0;
        $total_transaction = 0;
        $total_product_selling= 0;
        $total_selling_capster = 0;
        $is_btn_visible = false;

    
       $transactions =  Transaction::whereBetween(DB::raw('DATE(created_at)'), [$start_date,$end_date])
        ->where('status', Transaction::PAID)
        ->when($branch_id !== null, function ($query) use ($branch_id) {
            return $query->where('branch_id', $branch_id);
        })->get();

        $transactionCapsters = TransactionCapster::whereBetween(DB::raw('DATE(created_at)'), [$current_date,$current_date])
        ->where('status', Transaction::PAID)->get();


        $find_deposit_with_user = DepositTransaction::where('user_id',Auth::user()->id)->where(function ($query) {
            $query->where('type', DepositTransaction::CASH_IN)
                    ->orWhere('type', DepositTransaction::CASH_OUT);
        })->whereDate('created_at',$current_date)->first();

        $transaction_details = TransactionDetail::where(DB::raw('DATE(created_at)'), [$start_date,$end_date])->get();
        $transaction_capster_details = TransactionCapsterDetail::where(DB::raw('DATE(created_at)'), [$current_date,$current_date])->get();
        $findCashOut = DepositTransaction::where('user_id',Auth::user()->id)->where(function ($query) {
            $query->Where('type', DepositTransaction::CASH_OUT);
        })->whereDate('created_at',$current_date)->first();
        
        if($find_deposit_with_user != null){
            $date_cash_in = Carbon::parse($find_deposit_with_user->created_at)->format('Y-m-d');
            $is_deposit = $current_date === $date_cash_in; 
        }else {
            $is_deposit = false;
        }

        foreach($transactions as $transaction){
            $total_selling += $transaction->total_transaction;
        }
        foreach($transactionCapsters as $transactionCapster ){
            $total_selling_capster += $transactionCapster->total;
        }
        $total_transaction = count($transactions) + count($transactionCapsters);
        $total_product_selling = count($transaction_details) + count($transaction_capster_details);
        $total_selling = $total_selling + $total_selling_capster;
        $branches = Branch::orderBy('created_at','desc')->get(); 
        $is_btn_visible = $findCashOut != null;       
        $is_deposit = true;
        $is_btn_visible = true;

        return view('home', [
            'start_date' => $start_date,
            'end_date' => $end_date,'branch_id' => $branch_id,
            'branches' => $branches,'is_deposit' => $is_deposit,
            'total_selling' => $total_selling,'total_transaction' => $total_transaction,
            'total_product_selling' => $total_product_selling,'is_btn_visible' => $is_btn_visible]);
    }
}
