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
use Illuminate\Support\Facades\DB;
use PDF;

class ReportCapsterController extends Controller
{
    function generateTransactionPdf($transaction_id){
        $transaction =  TransactionCapster::find($transaction_id);
        $transaction_details = TransactionCapsterDetail::where('transaction_id',$transaction_id)->get();
        $cashback = intval($transaction->money_received) - intval($transaction->total);
 
        $transaction->update(['status' => TransactionCapster::PAID]);
 
        $pdf = PDF::loadView('report.capster.pdf', [
         'transaction' => $transaction,
         'transaction_details' => $transaction_details,
         'cashback' => $cashback
        ]);
        //  Set custom paper size (80mm x auto height)
        $pdf->setPaper('A8', 'portrait')
        ->setOption('margin-top', 0)
        ->setOption('margin-right', 0)
        ->setOption('margin-bottom', 0)
        ->setOption('margin-left', 0);
        
        return response($pdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="preview.pdf"',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    //    return $pdf->stream('report.capster.pdf');
 
     }
 
     function search(Request $request){
         $start_date = $request->start_date;
         $end_date = $request->end_date;
         $user_id = $request->user;
         $branch_id = $request->branch;
         $capster_id = $request->capster;
         $type_transaction = $request->type_transaction;
         $revenue = 0;
         $cash_in = 0;
         $total = 0;
         $difference_receipt = 0;
         $deposit_transaction = null;
         $total_product = 0;
         
        $transactions =  TransactionCapster::whereBetween(DB::raw('DATE(created_at)'), [$start_date,$end_date])
         ->when($user_id !== null, function ($query) use ($user_id) {
             return $query->where('user_id', $user_id);
         })
         ->when($branch_id !== null, function ($query) use ($branch_id) {
             return $query->where('branch_id', $branch_id);
         })->when($capster_id !== null, function ($query) use ($capster_id) {
            return $query->where('capster_id', $capster_id);
        })->get();
 
         $deposit_transactions =  DepositTransaction::whereBetween(DB::raw('DATE(created_at)'), [$start_date,$end_date])
         ->where('type', DepositTransaction::CASH_OUT)
         ->when($user_id !== null, function ($query) use ($user_id) {
             return $query->where('user_id', $user_id);
         })
         ->when($branch_id !== null, function ($query) use ($branch_id) {
             return $query->where('branch_id', $branch_id);
         })->get();
     
         $transaction_details = TransactionCapsterDetail::whereBetween(DB::raw('DATE(created_at)'), [$start_date,$end_date])->get();
         $users = User::orderBy('created_at','desc')->where('role','cashier')->get();
         $branches = Branch::orderBy('created_at','desc')->get();
         $capsters = Capster::orderBy('created_at','desc')->get();
 
         if($request->action == 'export-pdf'){
             if(count($deposit_transactions) === 0){
                return  redirect()->route('capster.report.index')->with('error', 'Please close your store for get daily report');
             }
 
             foreach($transactions as $transaction){
                 $total_product += intval($transaction->total);
             }
             
             foreach($deposit_transactions as $deposit_transaction){
                 $revenue = $revenue + intval($deposit_transaction->revenue);
                 $cash_in = $cash_in + intval($deposit_transaction->amount);
                 $total =  $total + (intval($total_product) + intval($cash_in));
                 $difference_receipt = $difference_receipt + ($revenue - $total);
                 $deposit_transaction = $deposit_transaction;
             }
 
             $formatted_total = $this->formatToIDR($total);
             $formatted_difference_receipt = $this->formatToIDR($difference_receipt);
             $formatted_revenue = $this->formatToIDR($revenue);
             $formatted_cash_in = $this->formatToIDR($cash_in);
 
             $pdf = PDF::loadView('report.capster.recap-pdf', [
                 'revenue' => $formatted_revenue,
                 'cash_in' => $formatted_cash_in,
                 'total' => $formatted_total,
                 'difference_receipt' => $formatted_difference_receipt,
                 'deposit_transaction' => $deposit_transaction,
                 'start_date' => $start_date,
                 'end_date' => $end_date
                ]);
 
            return $pdf->stream('report.capster.recap-pdf');
         }
         
        
         return view($type_transaction == "daily_revenue" ? 'report.capster.index' : 'report.capster.list',compact(
             'transactions','transaction_details',
             'users','branches','capsters',
             'start_date',
             'end_date',
             'user_id','branch_id','capster_id'));
     }
 
     function index() {
       $transactionDetails = [];
       $counter = 0; // Initialize a counter
       $current_date = Carbon::now()->format('Y-m-d');
       $transactions = TransactionCapster::orderBy('created_at','desc')->whereDate('created_at',$current_date)->get();
       $transaction_details = TransactionCapsterDetail::orderBy('created_at','desc')->whereDate('created_at',$current_date)->get();
       $totalServices = count($transaction_details); 
       $users = User::orderBy('created_at','desc')->where('role','cashier')->get();
       $branches = Branch::orderBy('created_at','desc')->get();
       $capsters = Capster::orderBy('created_at','desc')->get();
       foreach($transactions as  $transactionCapster){
            $serviceNames = [];
            $findCaspterServices = TransactionCapsterDetail::where('transaction_capster_id',$transactionCapster->id)->get();
            foreach($transaction_details as $service){
                $serviceName = Service::where('id', $service->service_id)->first();
                if ($serviceName) {
                    $counter++; 
                    if ($counter == $totalServices) {
                        $serviceNames[] = $serviceName->name;
                    } else {
                        $serviceNames[] = $serviceName->name . ',';
                    }
                }
            }
            $findNameCapster = Capster::where('id',$transactionCapster->capster_id)->first();
            
            $transactionDetails[] = [
                'capsterId' => $transactionCapster->id,
                'capsterName' => $findNameCapster,
                'serviceNames' => $serviceNames
            ];
        }
       return view('report.capster.index',compact(
         'transactions',
         'transaction_details',
         'users','branches','capsters','transactionDetails'));
     }
 
     function list() {
         $transactionDetails = [];
         $counter = 0; // Initialize a counter
         $current_date = Carbon::now()->format('Y-m-d');
         $transactions = TransactionCapster::orderBy('created_at','desc')->whereDate('created_at',$current_date)->get();
         $transaction_details = TransactionCapsterDetail::orderBy('created_at','desc')->whereDate('created_at',$current_date)->get();
         $totalServices = count($transaction_details); 
         $users = User::orderBy('created_at','desc')->where('role','cashier')->get();
         $branches = Branch::orderBy('created_at','desc')->get();
         $capsters = Capster::orderBy('created_at','desc')->get();
         foreach($transactions as  $transactionCapster){
            $serviceNames = [];
            $findCaspterServices = TransactionCapsterDetail::where('transaction_capster_id',$transactionCapster->id)->get();
            foreach($transaction_details as $service){
                $serviceName = Service::where('id', $service->service_id)->first();
                if ($serviceName) {
                    $counter++; 
                    if ($counter == $totalServices) {
                        $serviceNames[] = $serviceName->name;
                    } else {
                        $serviceNames[] = $serviceName->name . ',';
                    }
                }
            }
            $finalServiceNames = implode(',', $serviceNames);
            $findNameCapster = Capster::where('id',$transactionCapster->capster_id)->first();
            $transactionDetails[] = [
                'capsterId' => $transactionCapster->id,
                'capsterName' => $findNameCapster,
                'serviceNames' => $serviceNames
            ];
        }
   
         return view('report.capster.list',compact(
           'transactions',
           'transaction_details',
           'users','branches','capsters','transactionDetails'));
       }
 
     public function todayReport()
     {
         $start_date = Carbon::today();
         $user_id = null;
         $branch_id =null;
         $end_date= null;
         $revenue = 0;
         $cash_in = 0;
         $total = 0;
         $difference_receipt = 0;
         $total_product = 0;
         $deposit_transaction = null;
 
     
        $transactions =  TransactionCapster::where(DB::raw('DATE(created_at)'), $start_date)
         ->where('status', TransactionCapster::PAID)
         ->when($user_id !== null, function ($query) use ($user_id) {
             return $query->where('user_id', $user_id);
         })
         ->when($branch_id !== null, function ($query) use ($branch_id) {
             return $query->where('branch_id', $branch_id);
         })->get();
 
         $deposit_transactions =  DepositTransaction::where(DB::raw('DATE(created_at)'), $start_date)
         ->where('type', DepositTransaction::CASH_OUT)
         ->when($user_id !== null, function ($query) use ($user_id) {
             return $query->where('user_id', $user_id);
         })
         ->when($branch_id !== null, function ($query) use ($branch_id) {
             return $query->where('branch_id', $branch_id);
         })->get();
 
         foreach($transactions as $transaction){
             $total_product += intval($transaction->total);
         }
 
         if(count($deposit_transactions) === 0){
             return  redirect()->route('capster.report.index')->with('error', 'Please close your store for get daily report');
          }
          foreach($deposit_transactions as $deposit_transaction){
              $revenue = $revenue + intval($deposit_transaction->revenue);
              $cash_in = $cash_in + intval($deposit_transaction->amount);
              $total =  $total + (intval($total_product) + intval($cash_in));
              $difference_receipt = $difference_receipt + (intval($total_product ) - intval($cash_in));
              $deposit_transaction = $deposit_transaction;
          }
 
          $formatted_total = $this->formatToIDR($total);
          $formatted_difference_receipt = $this->formatToIDR($difference_receipt);
          $formatted_revenue = $this->formatToIDR($revenue);
          $formatted_cash_in = $this->formatToIDR($cash_in);
 
          $pdf = PDF::loadView('report.capster.recap-pdf', [
              'revenue' => $formatted_revenue,
              'cash_in' => $formatted_cash_in,
              'total' => $formatted_total,
              'difference_receipt' => $formatted_difference_receipt,
              'deposit_transaction' => $deposit_transaction,
              'start_date' => $start_date,
              'end_date' => $end_date
             ]);
 
         return $pdf->stream('report.capster.recap-pdf');
         
 
     }
 
     public function weeklyReport()
     {
         $start_date = Carbon::today()->subDays(6)->toDateString();
         $end_date = Carbon::now()->toDateString();
         $user_id = null;
         $branch_id = null;
         $revenue = 0;
         $cash_in = 0;
         $total = 0;
         $difference_receipt = 0;
         $deposit_transaction = null;
         $total_product = 0;
     
        $transactions =  TransactionCapster::whereBetween(DB::raw('DATE(created_at)'), [$start_date,$end_date])
         ->where('status', TransactionCapster::PAID)
         ->when($user_id !== null, function ($query) use ($user_id) {
             return $query->where('user_id', $user_id);
         })
         ->when($branch_id !== null, function ($query) use ($branch_id) {
             return $query->where('branch_id', $branch_id);
         })->get();
 
         $deposit_transactions =  DepositTransaction::whereBetween(DB::raw('DATE(created_at)'), [$start_date,$end_date])
         ->where('type', DepositTransaction::CASH_OUT)
         ->when($user_id !== null, function ($query) use ($user_id) {
             return $query->where('user_id', $user_id);
         })
         ->when($branch_id !== null, function ($query) use ($branch_id) {
             return $query->where('branch_id', $branch_id);
         })->get();
     
         $transaction_details = TransactionCapsterDetail::whereBetween(DB::raw('DATE(created_at)'), [$start_date,$end_date])->get();
         $users = User::orderBy('created_at','desc')->where('role','cashier')->get();
         $branches = Branch::orderBy('created_at','desc')->get();
 
         if(count($deposit_transactions) === 0){
             return  redirect()->route('capster.report.index')->with('error', 'Please close your store for get daily report');
          }

          foreach($transactions as $transaction){
            $total_product += intval($transaction->total);
        }
    
          foreach($deposit_transactions as $deposit_transaction){
            $revenue = $revenue + intval($deposit_transaction->revenue);
            $cash_in = $cash_in + intval($deposit_transaction->amount);
            $total =  $total + (intval($total_product) + intval($cash_in));
            $difference_receipt = $difference_receipt + (intval($total_product ) - intval($cash_in));
            $deposit_transaction = $deposit_transaction;
          }
 
          $formatted_total = $this->formatToIDR($total);
          $formatted_difference_receipt = $this->formatToIDR($difference_receipt);
          $formatted_revenue = $this->formatToIDR($revenue);
          $formatted_cash_in = $this->formatToIDR($cash_in);
 
          $pdf = PDF::loadView('report.capster.recap-pdf', [
              'revenue' => $formatted_revenue,
              'cash_in' => $formatted_cash_in,
              'total' => $formatted_total,
              'difference_receipt' => $formatted_difference_receipt,
              'deposit_transaction' => $deposit_transaction,
              'start_date' => $start_date,
              'end_date' => $end_date
             ]);
 
         return $pdf->stream('report.capster.recap-pdf');
     }
 
     public function monthlyReport()
     {
         $start_date =  Carbon::today()->subDays(29)->toDateString();
         $end_date = Carbon::now()->toDateString();
         $user_id = null;
         $branch_id = null;
         $revenue = 0;
         $cash_in = 0;
         $total = 0;
         $difference_receipt = 0;
         $deposit_transaction = null;
         $total_product = 0;
 
     
        $transactions =  TransactionCapster::whereBetween(DB::raw('DATE(created_at)'), [$start_date,$end_date])
         ->where('status', TransactionCapster::PAID)
         ->when($user_id !== null, function ($query) use ($user_id) {
             return $query->where('user_id', $user_id);
         })
         ->when($branch_id !== null, function ($query) use ($branch_id) {
             return $query->where('branch_id', $branch_id);
         })->get();
 
         $deposit_transactions =  DepositTransaction::whereBetween(DB::raw('DATE(created_at)'), [$start_date,$end_date])
         ->where('type', DepositTransaction::CASH_OUT)
         ->when($user_id !== null, function ($query) use ($user_id) {
             return $query->where('user_id', $user_id);
         })
         ->when($branch_id !== null, function ($query) use ($branch_id) {
             return $query->where('branch_id', $branch_id);
         })->get();
     
         $transaction_details = TransactionCapsterDetail::whereBetween(DB::raw('DATE(created_at)'), [$start_date,$end_date])->get();
         $users = User::orderBy('created_at','desc')->where('role','cashier')->get();
         $branches = Branch::orderBy('created_at','desc')->get();


       
         if(count($deposit_transactions) === 0){
             return  redirect()->route('capster.report.index')->with('error', 'Please close your store for get daily report');
          }
          foreach($deposit_transactions as $deposit_transaction){
            $revenue = $revenue + intval($deposit_transaction->revenue);
            $cash_in = $cash_in + intval($deposit_transaction->amount);
            $total =  $total + (intval($total_product) + intval($cash_in));
            $difference_receipt = $difference_receipt + (intval($total_product ) - intval($cash_in));
            $deposit_transaction = $deposit_transaction;
          }
 
          $formatted_total = $this->formatToIDR($total);
          $formatted_difference_receipt = $this->formatToIDR($difference_receipt);
          $formatted_revenue = $this->formatToIDR($revenue);
          $formatted_cash_in = $this->formatToIDR($cash_in);
 
          $pdf = PDF::loadView('report.capster.recap-pdf', [
              'revenue' => $formatted_revenue,
              'cash_in' => $formatted_cash_in,
              'total' => $formatted_total,
              'difference_receipt' => $formatted_difference_receipt,
              'deposit_transaction' => $deposit_transaction,
              'start_date' => $start_date,
              'end_date' => $end_date
             ]);
 
         return $pdf->stream('report.capster.recap-pdf');
     }
     
 
     private function formatToIDR($amount) {
         return "Rp " . number_format($amount, 0, ',', '.');
     }
}
