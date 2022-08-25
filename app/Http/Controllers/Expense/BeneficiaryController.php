<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense\Beneficiary;

class BeneficiaryController extends Controller
{
    function __construct() {
        $this->middleware('permission:beneficiary-list|beneficiary-create|beneficiary-edit|beneficiary-delete', ['only' => ['index','save']]);
        $this->middleware('permission:beneficiary-create', ['only' => ['add','save']]);
        $this->middleware('permission:beneficiary-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:beneficiary-delete', ['only' => ['delete']]);
    }
    function index(Request $request) {
        $beneficiaries = Beneficiary::orderBy('id', 'Desc')->get();
        if($request->ajax()){
        $returnHTML = view('expense.beneficiary.archive', compact('beneficiaries'))->render();
         return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
        return view('expense.beneficiary.list', compact(['beneficiaries']));
    } 

     function archive(Request $request){
        $data=$request->all();
        $beneficiaries = Beneficiary::onlyTrashed()->orderBy('deleted_at', 'Asc')->get();
        $returnHTML = view('expense.beneficiary.archive', compact('beneficiaries'))->render();
        return response()->json(array('success' => true, 'data' =>$beneficiaries,'html'=>$returnHTML));
    }


    function add() {
        return view('expense.beneficiary.add');
    }

    function save(Request $request) { 

        $validatedData = $request->validate([
            'name' => 'required'
        ]);

         $data = $request->all();

        $beneficiary = new Beneficiary();
        if($beneficiary->fill($data)->save()) {
            return redirect()->route('beneficiaries')->with(['status' => 'success', 'message' => 'Beneficiary saved successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }
       
    
    

    function edit($id = null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid Beneficiary id']);
        }
        $beneficiary = Beneficiary::where('id', $id)->first();
        if(!$beneficiary) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid Beneficiary id']);
        }
        return view('expense.beneficiary.edit', compact(['beneficiary']));
    }

    function update($id = null, Request $request){
    	if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a Beneficiary.']);
        }
        $validatedData = $request->validate([
            'name' => 'required'
        ]);
        
        $data = $request->all();
        $beneficiary = Beneficiary::find($id);
        if(!$beneficiary) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid Beneficiary id']);
        }
        if($beneficiary->fill($data)->save()) {
            return redirect()->route('beneficiaries')->with(['status' => 'success', 'message' => 'Beneficiary updated successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    	
    }

    function delete($id = null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a Beneficiary.']);
        }
        
        if(Beneficiary::withTrashed()->where('id', $id)->delete()) {
            return redirect()->back()->with(['status' => 'success', 'message' => 'Beneficiary archived successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.']);
        }
    }

    function unarchive($id = null){
        
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a beneficiary.']);
        }
       
        $beneficiary = Beneficiary::withTrashed()->find($id);
        if(!$beneficiary) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid beneficiary id']);
        }
        $beneficiary->deleted_at=null;
        if($beneficiary->save()) {
            return redirect()->back()->with(['status' => 'success', 'message' => 'Beneficiary unarchived successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }

}
