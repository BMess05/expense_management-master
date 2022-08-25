<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Resume\Resume;
use App\Models\Resume\ResumeCategory;
use App\Models\Resume\Experience;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;


class ResumeController extends Controller
{

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     function __construct()
    {
        $this->middleware('permission:resume-list|resume-create|resume-edit|resume-delete', ['only' => ['index','save']]);
        $this->middleware('permission:resume-create', ['only' => ['add','save']]);
        $this->middleware('permission:resume-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:resume-delete', ['only' => ['delete']]);
    }
    function index(Request $request) {
        $resumes = Resume::with('categories')->orderBy('id', 'Desc')->get();
       // dd($resumes);
        return view('resume.resume.list', compact(['resumes']));
    } 

    function add() {
        $experiences = Experience::all();
        $categories = ResumeCategory::all();
        return view('resume.resume.add',compact(['experiences','categories']));
    }

    function save(Request $request) { 

        $validatedData = $request->validate([
            'name' => 'required',
            'category' => 'required',
            'experience' => 'required',
            'interview_date' => 'required',
            //'select_file' => 'required|mimes:pdf,docs',
        ]);

        $data = $request->all();
        if ($request->hasFile('select_file')) {
            $allowed_extensions = ['pdf', 'docs'];
            
            $filename=$this->SaveFile($request->file('select_file'),$allowed_extensions);
            if($filename==false)
            {
              return redirect()->back()->with(['status' => 'danger', 'message' => 'Only pdf or docs files are  allowed'])->withInput();
            }
             
            $data=array_merge($data, ['resume' => $filename]);
        }



        $resume = new Resume();
        if($resume->fill($data)->save()) {
            return redirect()->route('resumes')->with(['status' => 'success', 'message' => 'Resume saved successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }

    function SaveFile($file,$allowed_extensions)
    {
        $ext = $file->getClientOriginalExtension();
        if(!in_array($ext, $allowed_extensions)) {
            return false;
        }
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
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid resume id']);
        }
        $resume = Resume::where('id', $id)->first();

        $categories = ResumeCategory::all();
        $experiences = Experience::all();
        if(!$resume) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid resume id']);
        }
        return view('resume.resume.edit', compact(['resume','categories','experiences']));
    }

    function update($id = null, Request $request){
    	if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a resume.']);
        }
       $validatedData = $request->validate([
            'category' => 'required',
            'experience' => 'required',
            'name' => 'required',
            'interview_date' => 'required',
            'reason_for_rejection' => 'required',
        ]);

        $data = $request->all();
        $resume = Resume::find($id);

        if ($request->hasFile('select_file')) {
            $allowed_extensions=['pdf','docs'];
            $filename=$this->SaveFile($request->file('select_file'),$allowed_extensions);
             if($filename==false){
                return redirect()->back()->with(['status' => 'danger', 'message' => 'Only pdf or docs files are  allowed'])->withInput();
             }
            $data=array_merge($data, ['resume' => $filename]);
            //unlink old 
            $path = public_path("uploads/resumes/$resume->resume");
            $this->unlinkImage($path);
        }
       
        if(!$resume) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Invalid resume id']);
        }
        if($resume->fill($data)->save()) {
            return redirect()->route('resumes')->with(['status' => 'success', 'message' => 'Resume updated successfully']);
        }   else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    	
    }

    function delete($id = null,$type=null) {
        if($id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Please select a resume.']);
        }
        $resume=Resume::find($id);
        if($type==1)
        {
            //archive (delete)
            $path = public_path("uploads/resumes/$resume->resume");
            $this->unlinkImage($path);
            $resume->delete();
            return redirect()->back()->with(['status' => 'success', 'message' => 'Resume deleted successfully']);

        }else{
            //unarchive (show)
            $resume->deleted_at=null;
            $resume->save();
            return redirect()->back()->with(['status' => 'success', 'message' => 'resume Account unarchived successfully']);

        }
       
    }

    function unlinkImage($path)
    {
        if (\File::exists($path)) { // unlink or remove previous image from folder
            unlink($path);
            return true;
        }
        return false;

    }

  function archive(Request $request){
    $data=$request->all();
    $resumes = Resume::withTrashed()->orderBy('deleted_at', 'Asc')->get();
    $returnHTML = view('resume.resume.archive', compact('resumes'))->render();
    return response()->json(array('success' => true, 'data' =>$resumes,'html'=>$returnHTML));
    }

     public function download($id=null)
    {
        $resume=Resume::find($id);
        $filename=$resume->resume;
        $file= public_path(). "/uploads/resumes/$filename";

        $headers = [
              'Content-Type' => 'application/vnd.ms-excel',
           ];

         return response()->download($file, $filename, $headers);
    }

}
