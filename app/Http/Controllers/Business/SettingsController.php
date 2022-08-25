<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business\Settings;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class SettingsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(){
        $this->middleware('permission:settings-list|settings-create|settings-edit|settings-delete', ['only' => ['index','save']]);
        $this->middleware('permission:settings-create', ['only' => ['create','store']]);
        $this->middleware('permission:settings-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:settings-delete', ['only' => ['show']]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $settings = Settings::orderBy('id','DESC')->get();
        return view('business.settings.index',compact('settings'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $year_arr = [];
        if (date('m') > 3 ){
            $year_arr[date('Y')."-".(date('Y') +1)] = date('Y')."-".(date('Y') +1);
            $j=2;
            for($i=1;$i<5;$i++){
                $year_arr[(date('Y')+$i)."-".(date('Y') +$j)] = (date('Y')+$i)."-".(date('Y') +$j);
                $j++;
            }
        }
        else{
            $year_arr[(date('Y')-1)."-".date('Y')] = (date('Y')-1)."-".date('Y');
            $j=1;
            for($i=0;$i<4;$i++){
                $year_arr[(date('Y')+$i)."-".(date('Y') +$j)] = (date('Y')+$i)."-".(date('Y') +$j);
                $j++;
            }

        }
        return view('business.settings.create',compact('year_arr'));
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
            'financial_year' => 'required',
            'target_amount' => 'required',
        ]);
        // $data['user_id']=auth()->user()->id;
        $bid = Settings::create($data);
        return redirect()->route('settings.index')->with(['success'=>'success','message'=>'Settings added successfully']);
    }
   
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $setting = Settings::find($id);
        $year_arr = [];
        if (date('m') > 3 ){
            $year_arr[date('Y')."-".(date('Y') +1)] = date('Y')."-".(date('Y') +1);
            $j=2;
            for($i=1;$i<5;$i++){
                $year_arr[(date('Y')+$i)."-".(date('Y') +$j)] = (date('Y')+$i)."-".(date('Y') +$j);
                $j++;
            }
        }
        else{
            $year_arr[(date('Y')-1)."-".date('Y')] = (date('Y')-1)."-".date('Y');
            $j=1;
            for($i=0;$i<4;$i++){
                $year_arr[(date('Y')+$i)."-".(date('Y') +$j)] = (date('Y')+$i)."-".(date('Y') +$j);
                $j++;
            }

        }
        return view('business.settings.edit',compact('setting','year_arr'));
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
            'financial_year' => 'required',
            'target_amount' => 'required',
        ]);
    
        $data=$request->all();
        // $data['user_id']=auth()->user()->id;
        $setting = Settings::find($id);
        $setting->fill($data)->save();
    
        return redirect()->route('settings.index')->with(['success'=>'success','message'=>'Settings updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $setting=Settings::find($id);
        $setting->delete();
        return redirect()->route('settings.index')->with(['success'=>'success','message'=>'Settings deleted successfully']);
    }
}
