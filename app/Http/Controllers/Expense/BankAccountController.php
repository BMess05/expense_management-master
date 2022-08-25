<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense\BankAccount;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class BankAccountController extends Controller
{
     function __construct()
    {
        $this->middleware('permission:bank-list|bank-create|bank-edit|bank-delete', ['only' => ['index','save']]);
        $this->middleware('permission:bank-create', ['only' => ['add','save']]);
        $this->middleware('permission:bank-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bank-delete', ['only' => ['delete']]);
    }

    function index(Request $request) {
        $banks = BankAccount::orderBy('id', 'Desc')->get();
        if($request->ajax()){
        $returnHTML = view('expense.bank.archive', compact('banks'))->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
      }
        return view('expense.bank.list', compact(['banks']));
    } 

    function add() {
        return view('expense.bank.add');
    }
    function Check_account_no(Request $request){
        if ($request->input('account_no') !== '') {
            if ($request->input('account_no')) {
                $rule = array('account_no' => 'Required|unique:bank_accounts');
                $validator = Validator::make($request->all(), $rule);
            }
            if (!$validator->fails()) {
                die('true');
            }
        }
        die('false');

    }
    function save(Request $request) { 

        $validatedData = $request->validate([
            'bank_name' => 'required',
            'company_name' => 'required',
            'account_no' => 'required|unique:bank_accounts',
        ]);

        $data = $request->all();

        $bank = new BankAccount();
        if($bank->fill($data)->save()) {
            return redirect()->route('bankaccounts')->with(['status' => 'success', 'message' => 'Bank account saved successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }
       

    function edit($id = null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid bank id']);
        }
        $bank = BankAccount::where('id', $id)->first();
        if(!$bank) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid bank id']);
        }
        return view('expense.bank.edit', compact(['bank']));
    }

    function update($id = null, Request $request){
    	if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a bank.']);
        }
       $validatedData = $request->validate([
            'bank_name' => 'required',
            'company_name' => 'required',
            'account_no' => ['required', Rule::unique('bank_accounts')->ignore($id)],
        ]);
        
        $data = $request->all();
        $bank = BankAccount::find($id);
        if(!$bank) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid bank id']);
        }
        if($bank->fill($data)->save()) {
            return redirect()->route('bankaccounts')->with(['status' => 'success', 'message' => 'Bank account updated successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    	
    }

    function delete($id = null,$type=null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a bank.']);
        }
        $bank=BankAccount::withTrashed()->find($id);
        if($type==1)
        {
          //archive (delete)
            $bank->delete();
             return redirect()->back()->with(['status' => 'success', 'message' => 'Bank Account archived successfully']);

        }else{
            //unarchive (show)
            $bank->deleted_at=null;
            $bank->save();
            return redirect()->back()->with(['status' => 'success', 'message' => 'Bank Account unarchived successfully']);

        }
       
    }

      function archive(Request $request){
        $data=$request->all();
        $banks = BankAccount::onlyTrashed()->orderBy('deleted_at', 'Asc')->get();
        $returnHTML = view('expense.bank.archive', compact('banks'))->render();
        return response()->json(array('success' => true, 'data' =>$banks,'html'=>$returnHTML));
        }
}
