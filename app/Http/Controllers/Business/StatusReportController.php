<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business\Bid;
use App\Models\Business\BidProfile;
use App\Models\Business\Project;
use App\Models\Business\ProjectType;
use App\Models\Business\ContractType;
use App\Models\Business\StatusReport;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
class StatusReportController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     function __construct()
    {
        /*$this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        $this->middleware('permission:role-create', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role-delete', ['only' => ['destroy']]);*/
    }



     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */public function index(Request $request)
    {
        $reports = StatusReport::orderBy('id','DESC')->get();
        return view('business.statusreport.index',compact('reports'))->with('i');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('business.statusreport.create');
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
            'date' => 'required',
            'title' => 'required',
        ]);
        $bid = StatusReport::create($data);
        return redirect()->route('statusreport.index')
                        ->with('success','Project added successfully');
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$report=StatusReport::find($id);

        return view('business.statusreport.edit',compact('report'));
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
            'date' => 'required',
            'title' => 'required',
        ]);
    
        $data=$request->all();
        $bid = StatusReport::find($id);
        $bid->fill($data)->save();
    
        return redirect()->route('statusreport.index')
                        ->with('success','Project updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project=StatusReport::find($id);
       $project->delete();
       return redirect()->back()->with('success','Project deleted successfully');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
       $project=StatusReport::find($id);
       $project->delete();
       return redirect()->back()->with('success','Project deleted successfully');
    }
}
