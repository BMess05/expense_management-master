<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business\Bid;
use App\Models\Business\BidProfile;
use App\Models\Business\Project;
use App\Models\Business\ProjectType;
use App\Models\Business\ContractType;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
class ProjectController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        // $this->middleware('permission:profile-status-list|profile-status-create|profile-status-edit|profile-status-delete', ['only' => ['index','save']]);
        // $this->middleware('permission:profile-status-create', ['only' => ['create','store']]);
        // $this->middleware('permission:profile-statuse-edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:profile-status-delete', ['only' => ['delete']]);
    }



     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */public function index(Request $request)
    {
        $projects = Project::orderBy('id','DESC')->get();
        return view('business.project.index',compact('projects'))->with('i');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contact_types = ContractType::pluck('type','id');
        $project_types = ProjectType::pluck('type','id');
        return view('business.project.create',compact('contact_types','project_types'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$data=$request->except('_token');
        $this->validate($request, [
            'client_name' => 'required',
            'contract_type' => 'required',
        ]);
        $data['user_id']=auth()->user()->id;
        $bid = Project::create($data);
        return redirect()->route('projects.index')->with('success','Project added successfully');
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$project=Project::find($id);
        $contact_types = ContractType::pluck('type','id');
        $project_types = ProjectType::pluck('type','id');
        $usercontract = $project->contract_type->id;
        $userproject = $project->project_type->id;
       
        return view('business.project.edit',compact('project','contact_types','project_types','usercontract','userproject'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'client_name' => 'required',
            'contract_type' => 'required',
        ]);
    
        $data=$request->all();
        $data['user_id']=auth()->user()->id;
        $bid = Project::find($id);
        $bid->fill($data)->save();
    
        return redirect()->route('projects.index')->with('success','Project updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project=Project::find($id);
        return view('business.project.show',compact('project'));
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
       $project=Project::find($id);
       $project->delete();
       return redirect()->back()->with('success','Project deleted successfully');
    }
}
