<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use App\Http\Requests\CreateUserRequest;
use App\Services\UserService;
use App\Enum\UserStatus;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;
use App\Models\ApiSetting;
use App\Models\Transaction;
use App\Services\PaystackService;


class TransactionController extends Controller
{


    protected $paystackService;
    public function __construct(PaystackService $paystackService){

       $this->paystackService = $paystackService;
    }


    public function transactions(Request $request){
        
        $get_transactions = Transaction::with(['user','subscription'])
                                         ->orderBy('id','desc')
                                         ->paginate(10);

        if ($request->ajax()) {
            $viewTransaction = view('dashboard.pages.tranxdata', compact('get_transactions'))->render();
            
            return response()->json([
                'newhtmltransaction' => $viewTransaction
            ]);
        }                                 
        return view('dashboard.pages.transaction',compact('get_transactions'));
    }

    public function resolveAccount(Request $request){

        $bank_code = $request->bank_code;
        $account_number = $request->account_number;
        $result = $this->paystackService->resolve_bank($account_number,$bank_code);
        // Paystack validation error
        if (!$result || $result->status === false) {
            return response()->json([
                'success' => false,
                'message' => $result->message ?? 'Account could not be resolved'
            ]);
        }
        return response([
            'success' => true,
            'data' => $result,
        ]);
    }

    

}
