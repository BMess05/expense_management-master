<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business\BidProfile;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DateTime;
use App\Models\User;
use App\Models\Business\Targets;
use Carbon\Carbon;
class TargetAchievedController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('permission:target-list|target-create|target-edit|target-delete', ['only' => ['index','save']]);
        $this->middleware('permission:target-create', ['only' => ['create','store']]);
        $this->middleware('permission:target-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:target-delete', ['only' => ['show']]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $targets = Targets::orderBy('id','DESC')->get();
        return view('business.targets.index',compact('targets'))->with('i', ($request->input('page', 1) - 1) * 5);
       
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bidProfile = BidProfile::pluck('name','id');
        $months = [];
        for ($m=4; $m<=15; $m++) {
            $i = Carbon::create()->startOfMonth()->month($m)->startOfMonth()->format('M');
            $months[$i]= Carbon::create()->startOfMonth()->month($m)->startOfMonth()->format('M');
        }
        $date = \Carbon\Carbon::now();
        $lastMonth =  $date->subMonth()->format('M');
        $minutes = array("10"=>10, "20"=>20, "30"=>30,"40"=>40,"50"=>50);

        return view('business.targets.create',compact('bidProfile','months','lastMonth','minutes'));
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
        // echo "<pre>";print_r($data);die;
        $this->validate($request, [
            'client_name' => 'required',
            'profile_id' => 'required',
            'billing_amount' => 'required',
            'type' => 'required',
        ]);
        $data['user_id']=auth()->user()->id;
        $targets = Targets::create($data);
        return redirect()->route('targets.index')->with(['success'=>'success','message'=>'Target added successfully']);
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	
        $target = Targets::find($id);
        // echo "<pre>";print_r($target->type);die;
        $bidProfile = BidProfile::pluck('name','id');
        $months = [];
        for ($m=4; $m<=15; $m++) {
            $i = Carbon::create()->startOfMonth()->month($m)->startOfMonth()->format('M');
            $months[$i]= Carbon::create()->startOfMonth()->month($m)->startOfMonth()->format('M');
        }
        $date = \Carbon\Carbon::now();
        $lastMonth =  $date->subMonth()->format('M');
        if(isset( $target->target_month) && !empty($target->target_month))
        $lastMonth = $target->target_month;
        $minutes = array("10"=>10, "20"=>20, "30"=>30,"40"=>40,"50"=>50);

        return view('business.targets.edit',compact('target','bidProfile','months','lastMonth','minutes'));
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
            'profile_id' => 'required',
            'billing_amount' => 'required',
            'type' => 'required',
        ]);
    
        $data=$request->all();
        $data['user_id']=auth()->user()->id;
        $target = Targets::find($id);
        $target->fill($data)->save();
    
        return redirect()->route('targets.index')->with(['success'=>'success','message'=>'Target updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $target=Targets::find($id);
        $target->delete();
        return redirect()->route('targets.index')->with(['success'=>'success','message'=>'Target deleted successfully']);
    }
}
