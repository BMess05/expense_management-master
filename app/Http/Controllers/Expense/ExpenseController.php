<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\User;
use App\Models\Expense\Category;
use App\Models\Expense\Expense;
use App\Models\Expense\Beneficiary;
use App\Models\Expense\BankAccount;
use App\Exports\ExpenseExport;
use App\Imports\ExpensesImport;
use App\Imports\DraftExpensesImport;
use App\Models\Expense\DraftExpense;
use App\Models\Expense\DraftExpenseRecords;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use PDF;
use Gate;

class ExpenseController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:expense-list|expense-create|expense-edit|expense-delete', ['only' => ['index','save']]);
        $this->middleware('permission:expense-create', ['only' => ['add','save']]);
        $this->middleware('permission:expense-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:expense-delete', ['only' => ['delete']]);
    }

    function index(Request $request) {

       $data=$request->all();


       //dd($data);
      /* if(isset($data['from_date']))
       {
	       	$validatedData = $request->validate([
	            'to_date' => Rule::requiredIf($data['from_date']),

	        ]);
       }*/
       
		 $expense=Expense::query();
	     if (isset($data['type'])) {
	        $expense=$expense->where('type',$data['type']);
	     }
	     if (isset($data['category'])) {
	        $expense=$expense->where('category_id',$data['category']);
	     }
	     if (isset($data['beneficiary'])) {
	        $expense=$expense->where('beneficary_id',$data['beneficiary']);
	     }
	     if (isset($data['from_date']) && isset($data['to_date'])) {
            $from_date=\Carbon\Carbon::parse($data['from_date'])->format('Y-m-d');
            $to_date=\Carbon\Carbon::parse($data['to_date'])->format('Y-m-d');

	        $expense=$expense->whereBetween('transaction_date',[$from_date, $to_date]);
	     }
	    $month=date("m");
		$current_year=date("Y");

		if($month <= 03){
		  $from = date("Y-m-d",strtotime('1-April-'.($current_year-1)));//1 april 2020
		  //$to=date("Y-m-d"); //currnt date(5 feb-2021)
          $to = date("Y-m-d",strtotime('31-March-'.($current_year)));
		}else{
		 // $from = date("Y-m-d"); //will be currnt date after 3 month
          $from = date("Y-m-d",strtotime('1-April-'.($current_year)));//1-april-2021
		  $to   =   date("Y-m-d",strtotime('31-March-'.($current_year+1))); //31 march 2022
		} 


        // $expenses=$expense->whereBetween('transaction_date', [$from, $to])->orderBy('id', 'Desc')->get();
        // echo "<pre>";print_r($expenses);die;
        $expenses=$expense->orderBy('id', 'DESC')->get();
        // echo "<pre>";print_r($expenses);die;

        $categories = Category::where('status',1)->get();
		$beneficiaries = Beneficiary::all();
        if($request->ajax()){
        $returnHTML = view('expense.expense.archive', compact('expenses'))->render();
         return response()->json(array('success' => true, 'html'=>$returnHTML));
        }
        return view('expense.expense.list', compact(['expenses','categories','beneficiaries','data']));

        
    } 

     function archive(Request $request){
        $data=$request->all();
        $month=date("m");
        $current_year=date("Y");

        if($month <= 03){
          $from = date("Y-m-d",strtotime('1-April-'.($current_year-1)));//1 april 2020
          //$to=date("Y-m-d"); //currnt date(5 feb-2021)
          $to = date("Y-m-d",strtotime('31-March-'.($current_year)));
        }else{
          //$from = date("Y-m-d"); //will be currnt date after 3 month
          $from = date("Y-m-d",strtotime('1-April-'.($current_year)));
          $to   =   date("Y-m-d",strtotime('31-March-'.($current_year+1))); //31 march 2022
        } 
        $expenses=Expense::onlyTrashed()->whereBetween('transaction_date', [$from, $to])->orderBy('deleted_at', 'Asc')->get();
        
        $returnHTML = view('expense.expense.archive', compact('expenses'))->render();
        return response()->json(array('success' => true, 'data' =>$expenses,'html'=>$returnHTML));
    }

    function filter(Request $request){
        $data=$request->all();

		 $expense=Expense::query();
	     if (isset($data['type'])) {
	        $expense=$expense->where('type',$data['type']);
	     }
	     if (isset($data['category'])) {
	        $expense=$expense->where('category_id',$data['category']);
	     }
	     if (isset($data['Expense'])) {
	        $expense=$expense->where('beneficary_id',$data['Expense']);
	     }
	     if (isset($data['from_date']) && isset($data['to_date'])) {
	        $expense=$expense->whereBetween('transaction_date',[$data['from_date'], $data['to_date']]);
	     }
	    $month=date("m");
		$current_year=date("Y");

		if($month <= 03){
		  $from = date("Y-m-d",strtotime('1-April-'.($current_year-1)));//1 april 2020
		  $to=date("Y-m-d"); //currnt date(5 feb-2021)
		}else{
		  $from = date("Y-m-d"); //will be currnt date after 3 month
		  $to   =   date("Y-m-d",strtotime('31-March-'.($current_year+1))); //31 march 2022
		} 
        $expenses=$expense->whereBetween('transaction_date', [$from, $to])->orderBy('id', 'DESC')->get();
        
        // dd($expenses);
        $categories = Category::where('status',1)->get();
		$beneficiaries = Beneficiary::all();
        return view('expense.expense.list', compact(['expenses','categories','beneficiaries','data']));
       
    }

    function add() {
    	$categories = Category::all();
    	$beneficiaries = Beneficiary::all();
        $banks = BankAccount::all();
        return view('expense.expense.add',compact(['categories','beneficiaries','banks']));
    }

    function save(Request $request) { 

        $validatedData = $request->validate([
            'category' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'transaction_date' => 'required',
        ]);

         $data = $request->all();
        // dd($data);
         //$transaction_date=date('Y-m-d', strtotime($data['transaction_date']));
         $data=array_merge($data, ['category_id' => $data['category'],'beneficary_id'=>$data['beneficiary']]);

        $expense = new Expense();
        if($expense->fill($data)->save()) {
            return redirect()->route('expenses')->with(['status' => 'success', 'message' => 'Expense saved successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }
      
    function edit($id = null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid expense id']);
        }
        $expense = Expense::where('id', $id)->first();
        $categories = Category::all();
    	$beneficiaries = Beneficiary::all();
        $banks = BankAccount::all();
        if(!$expense) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid expense id']);
        }
        return view('expense.expense.edit', compact(['expense','categories','beneficiaries','banks']));
    }

    function update($id = null, Request $request){
    	if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a expense.']);
        }
        $validatedData = $request->validate([
            'category' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'transaction_date' => 'required',
        ]);
        
        $data = $request->all();
        $data=array_merge($data, ['category_id' => $data['category'],'beneficary_id'=>$data['beneficiary']]);
       // dd($data);
        $expense= Expense::find($id);
        if(!$expense) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid expense id']);
        }
        if($expense->fill($data)->save()) {
            return redirect()->route('expenses')->with(['status' => 'success', 'message' => 'Expense updated successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    	
    }

    function delete($id = null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a expense.']);
        }
        
        if(Expense::where('id', $id)->delete()) {
            return redirect()->back()->with(['status' => 'success', 'message' => 'Expense archived successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.']);
        }
    }

    function deleteDraft($id = null) {
        //dd($id);
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select record.']);
        }
        
        if(DraftExpense::where('id', $id)->delete()) {
            DraftExpenseRecords::where('draft_id', $id)->delete();
            return redirect()->back()->with(['status' => 'success', 'message' => 'Record deleted successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.']);
        }
    }

    function unarchive($id = null){
        
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a Expense.']);
        }
       
        $expense = Expense::withTrashed()->find($id);
        if(!$expense) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid expense id']);
        }
        $expense->deleted_at=null;
        if($expense->save()) {
            return redirect()->back()->with(['status' => 'success', 'message' => 'Expense unarchived successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }

    function export(Request $request){

    	return view('expense.expense.export');
    }

    function exportingExpense(Request $request){
       $data=$request->all();

       $expenses=$this->getExpenseData($data);
       if(count($expenses)>0)
       	{
       		if($data['file_type']=='csv')
	       {
	       	return Excel::download(new ExpenseExport($expenses), 'expenses.csv');
	       }else{

	       	  $pdf = PDF::loadView('expense.expense.exportList', compact('expenses'));
	            return $pdf->download('expenses.pdf');
	       }

       	}else{
       		return redirect()->back()->with(['status' => 'danger', 'message' => 'No data found']);
       	}
       
    }

    function getExpenseData($data)
    {
    	$from_date=date('Y-m-d', strtotime($data['from_date']));
        $to_date=date('Y-m-d', strtotime($data['to_date']));

        if($data['trans_type']==0)
        {
        	$trans_type=[1,2];
        }else{
        	$trans_type=[$data['trans_type']];
        }
        $expense=Expense::query();
        $expenses=$expense->whereBetween('transaction_date', [$from_date, $to_date])->whereIn('type',$trans_type)->orderBy('id', 'DESC')->get();
        return $expenses;

    }


    function import($value='')
    {

       $banks=BankAccount::orderBy('id','desc')->get();
       $drafts=DraftExpense::orderBy('id','desc')->get();
       return view('expense.expense.import',compact('banks','drafts'));
    }

    function SaveFile($file,$id)
    {
        $ext = $file->getClientOriginalExtension();
        $filename=$id.'.'.$ext;
        $path = public_path('/uploads/expenses/bank_statements');
         if(!is_dir($path))
        {
          mkdir($path,0777,true);
        }

        $file_r = $file->move($path, $filename);

        return $filename;
    }
    function importExcelSheet(Request $request)
    {
        if ($request->hasFile('select_file')) {
            $extension = $request->file('select_file')->getClientOriginalExtension();
          
            if(!in_array($extension, ['xls', 'xlsx','csv','png'])) {
                return redirect()->back()->with(['status' => 'danger', 'message' => 'Only xls or csv files are  allowed'])->withInput();
            }

            $path = $request->file('select_file')->getRealPath();
           
            //Log::info('storeFile');
        }
       \DB::beginTransaction();
        try {

            $import = new DraftExpensesImport($request->all());
            Excel::import($import, request()->file('select_file'));
            $rows=$import->rows->toArray();
            if(count($rows)==0)
            {
                return redirect()->back()->with(['status' => 'danger', 'message' => 'Empty File not allowed'])->withInput();
            }
            $draft_expense=  DraftExpense::create([
                'user_id' => \Auth::id(),
                'account_no' =>$request->bank,
                'title' => $request->title,

            ]);
    
            $data = [];
            foreach ($rows as $row){
                
               $now = \Carbon\Carbon::now('utc')->toDateTimeString();
               $dt_obj = new \DateTime($row['date']);
               $transaction_date = $dt_obj->format('Y-m-d');
               $data[]=[
                    'transaction_date'    => $transaction_date, 
                    'draft_id'    => $draft_expense->id, 
                    'remarks' => $row['description'],
                    'type' => is_numeric($row['debit'])?1:2,
                    'amount' => is_numeric($row['debit'])?$row['debit']:$row['credit'],
                    'created_at'=> $now,
                    'updated_at'=> $now
                   
                ];
            }
            
            $draft=DraftExpenseRecords::insert($data);
            \DB::commit();

            //call view file
            $categories = Category::all();
            $beneficiaries = Beneficiary::all();
            $draft_expenses=DraftExpense::with('draft_records')->where('id',$draft_expense->id)->first();

            $storeFile=$this->SaveFile($request->file('select_file'),$draft_expense->id);
            
            
            // return redirect()->route('importExpense')->with(['status' => 'success', 'message' => 'Import Done Successfully']);
             

            return view('expense.expense.editImport',compact('draft_expenses','categories','beneficiaries'));

        } catch (\Exception $e) {
            \DB::rollback();
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong'])->withInput();
        }


       
    }

    public function download($id=null){
        $filename="$id.csv";
        $file= public_path(). "/uploads/expenses/bank_statements/$filename";
        if(is_file($file)){
            $headers = [
                'Content-Type' => 'application/vnd.ms-excel',
            ];
    
            return response()->download($file, $filename, $headers);
        }else{
            return redirect()->back()->with(['status' => 'danger', 'message' => 'File does not exist']);
        }

        
    }


    function editImport($id=null)
    {
        //dd($id);
        $categories = Category::all();
        $beneficiaries = Beneficiary::all();
        $draft_expenses=DraftExpense::with('draft_records')->where('id',$id)->first();
        return view('expense.expense.editImport',compact('draft_expenses','categories','beneficiaries'));
    }

    function updateDraftExpense(Request $request,$id)
    {
       $data=$request->all();
        //dd($data);

       for ($i=0; $i < count($data['amount']) ; $i++) { 

        if($data['action']=='Publish'){
            //add records in expense table

            $expense=Expense::create([
                'category_id'=>$data['category'][$i],
                'beneficary_id'=>$data['beneficiary'][$i],
                'amount'=>$data['amount'][$i],
                'transaction_date'=>$data['transaction_date'][$i],
                'transaction_date'=>$data['transaction_date'][$i],
                'type'=>$data['type'][$i],
                'remarks'=>$data['remarks'][$i],
                'account_no'=>$data['account_no'],

            ]);

            //delete data from draft records
            //$ids = explode(",", $data['draft_id'][$i]);
            $records=DraftExpenseRecords::where('draft_id',$id)->delete();
            $records=DraftExpense::where('id',$id)->delete();

             //unlink old file
            $usersImage = public_path("uploads/bank_statements/$id.csv");

            if (\File::exists($usersImage)) { // unlink or remove previous image from folder
                unlink($usersImage);
            }
            $message='Expenses publish successfully';

        }else{
            //save(update) in draft records
            $records=DraftExpenseRecords::find($data['draft_id'][$i]);
            $records->category_id=$data['category'][$i];
            $records->beneficiary_id=$data['beneficiary'][$i];
            $records->amount=$data['amount'][$i];
            $records->transaction_date=$data['transaction_date'][$i];
            $records->type=$data['type'][$i];
            $records->remarks=$data['remarks'][$i];
            $records->save();
            $message='Data saved successfully';

        }
       }
        if($data['action']=='Publish')
        {
           return redirect()->route('expenses')->with(['status' => 'success', 'message' => $message]);
        }else{
            return redirect()->back()->with(['status' => 'success', 'message' => $message]);
        }



    }

    function publish(Request $request,$draft_id)
    {
        $data=$request->all();
        dd($draft_id);


    }

    function editDraftExpense(Request $request,$id=null)
    {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid expense id']);
        }
        $expense=DraftExpenseRecords::where('id',$id)->first();
        $categories = Category::all();
        $beneficiaries = Beneficiary::all();
        $banks = BankAccount::all();
        if(!$expense) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid expense id']);
        }
        return view('expense.expense.edit', compact(['expense','categories','beneficiaries','banks']));
        
    }
}
