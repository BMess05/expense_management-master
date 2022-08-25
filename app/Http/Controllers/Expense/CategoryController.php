<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Expense\Category;

class CategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:category-list|category-create|category-edit|category-delete', ['only' => ['index','save']]);
        $this->middleware('permission:category-create', ['only' => ['add','save']]);
        $this->middleware('permission:category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:category-delete', ['only' => ['delete']]);
    }

    function index(Request $request) {
      $categories = Category::orderBy('id', 'Desc')->get();
      if($request->ajax()){
        $returnHTML = view('expense.category.archive', compact('categories'))->render();
        return response()->json(array('success' => true, 'data' =>$categories,'html'=>$returnHTML));
      }
      return view('expense.category.list', compact(['categories']));
    } 

    function archive(Request $request){
        $data=$request->all();
        $categories = Category::onlyTrashed()->orderBy('deleted_at','Asc')->get();
       
        if($request->ajax()){
        $returnHTML = view('expense.category.archive', compact('categories'))->render();
           return response()->json(array('success' => true, 'data' =>$categories,'html'=>$returnHTML));
         }
         return view('expense.category.list', compact(['categories']));
    }

    function add() {
        return view('expense.category.add');
    }

    function save(Request $request) { 
        $validatedData = $request->validate([
            'name' => 'required'
        ]);
        $data = $request->all();
        $category = new Category();
        if($category->fill($data)->save()) {
            return redirect()->route('categories')->with(['status' => 'success', 'message' => 'Category saved successfully']);
        }else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }      
    function edit($id = null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid category id']);
        }
        $category = Category::where('id', $id)->first();
        if(!$category) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid category id']);
        }
        return view('expense.category.edit', compact(['category']));
    }

    function update($id = null, Request $request){
    	if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a category.']);
        }
        $validatedData = $request->validate([
            'name' => 'required'
        ]);
        
        $data = $request->all();
        $category = Category::find($id);
        if(!$category) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid category id']);
        }
        if($category->fill($data)->save()) {
            return redirect()->route('categories')->with(['status' => 'success', 'message' => 'Category updated successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    	
    }

    function delete($id = null,$type=null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a category.']);
        }
        $category=Category::withTrashed()->find($id);
        if($type==1)
        {
          //archive (delete)
            $category->delete();
            return redirect()->back()->with(['status' => 'success', 'message' => 'Category archived successfully']);

        }else{
            //unarchive (show)
            $category->deleted_at=null;
            $category->save();
            return redirect()->back()->with(['status' => 'success', 'message' => 'Category unarchived successfully']);

        }
        
    }

    

   
    function unarchive($id = null){
        
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a category.']);
        }
       
        $category = Category::find($id);
        if(!$category) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid category id']);
        }
        $category->deleted_at=null;
        if($category->save()) {
            return redirect()->back()->with(['status' => 'success', 'message' => 'Category unarchived successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }

    
    
}
