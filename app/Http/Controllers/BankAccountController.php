<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\userBankAccount;

class BankAccountController extends Controller
{
    public function fetchBankAccounts(Request $request){
        
        $banks = userBankAccount::where('employee_id',$request->employee_id)->get();
        return view('bank-accounts.index',compact('banks'))->render();
    }

    public function createBankAc(Request $request){
        $data = userBankAccount::create([
            'employee_id'  => $request->employee_id,
            'ac_holder'    => $request->ac_holder,
            'account_no'   => $request->account_no,
            'ifsc_code'    => $request->ifsc_code,
            'bank_name'    => $request->bank_name,
        ]);
        if($data){
        return response()->json(['data' => $data ,200]);
        }
    }

    public function deleteBankAc(Request $request){
        $data = userBankAccount::find($request->id)->delete();
        return response()->json(['data' => $data ,200]);
    }

    public function editBankAc(Request $request){
        $bank = userBankAccount::where('id',$request->id)->first();
        return view('bank-accounts.update',compact('bank'));
    }

    public function updateBankAc(Request $request){
        $data = userBankAccount::where('id',$request->id)->update([
            'ac_holder'    => $request->ac_holder,
            'account_no'   => $request->account_no,
            'ifsc_code'    => $request->ifsc_code,
            'bank_name'    => $request->bank_name,
        ]);
        if($data){
            return response()->json(['data' => $data ,200]);
            }
    }
}
