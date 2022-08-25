<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resume\Resume;
use App\Models\Resume\ResumeCategory;
use App\Models\Resume\Experience;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ResumeCategoryController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:resume-category-list|resume-category-create|resume-category-edit|resume-category-delete', ['only' => ['index','save']]);
        $this->middleware('permission:resume-category-create', ['only' => ['add','save']]);
        $this->middleware('permission:resume-category-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:resume-category-delete', ['only' => ['delete']]);
    }

    function index(Request $request) {
        $resumes = ResumeCategory::orderBy('id', 'Desc')->get();
        return view('resume.resumeCategory.list', compact(['resumes']));
    } 

    function add() {
        $categories = ResumeCategory::all();
        return view('resume.resumeCategory.add',compact(['categories']));
    }

    function save(Request $request) { 

        $validatedData = $request->validate([
            'category_name' => 'required|unique:resume_categories'
        ]);

        $data = $request->all();
        $resume = new ResumeCategory();
        if($resume->fill($data)->save()) {
            return redirect()->route('resumeCategory')->with(['status' => 'success', 'message' => 'Resume Category saved successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }

    function SaveFile($file)
    {
        $ext = $file->getClientOriginalExtension();
        $filename=time().'.'.$ext;
        $path = public_path('/uploads/resumes');
         if(!is_dir($path))
        {
          mkdir($path,0777,true);
        }

        $file_r = $file->move($path, $filename);

        return $filename;
    }
       

    function edit($id = null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid category id']);
        }
        $resume = ResumeCategory::where('id', $id)->first();
        if(!$resume ) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid category  id']);
        }
        return view('resume.resumeCategory.edit', compact(['resume']));
    }

    function update($id = null, Request $request){
    	if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select category.']);
        }
       $validatedData = $request->validate([
            'category_name' => ['required', Rule::unique('resume_categories')->ignore($id)]
        ]);
        
        $data = $request->all();
        $bank = ResumeCategory::find($id);
        if(!$bank) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid category id']);
        }
        if($bank->fill($data)->save()) {
            return redirect()->route('resumeCategory')->with(['status' => 'success', 'message' => 'Category updated successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    	
    }

    function delete($id = null,$type=null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a bank.']);
        }
        $bank=ResumeCategory::find($id);
        if($type==1)
        {
          //archive (delete)
            $bank->delete();
             return redirect()->back()->with(['status' => 'success', 'message' => 'Category deleted successfully']);

        }else{
            //unarchive (show)
            $bank->deleted_at=null;
            $bank->save();
            return redirect()->back()->with(['status' => 'success', 'message' => 'Bank Account unarchived successfully']);

        }
       
    }

      function archive(Request $request){
        $data=$request->all();
        $resumes = Resume::withTrashed()->orderBy('deleted_at', 'Asc')->get();
        $returnHTML = view('resume.resume.archive', compact('resumes'))->render();
        return response()->json(array('success' => true, 'data' =>$resumes,'html'=>$returnHTML));
        }
}
