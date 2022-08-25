<?php

namespace App\Http\Controllers\Hardware;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hardware\Hardware;
use App\Models\Hardware\HardwareHistory;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DateTime;
use App\Models\User;

class HardwareController extends Controller
{
    function __construct() {
        $this->middleware('permission:hardware-list|hardware-create|hardware-edit|hardware-delete', ['only' => ['index','save']]);
        $this->middleware('permission:hardware-create', ['only' => ['create','store']]);
        $this->middleware('permission:hardware-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:hardware-delete', ['only' => ['show']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $data['type'] = array('1'=>'Desktop','2'=>'Laptop','3'=>'Mobile','4'=>'Tablet');
        return view('hardware.hardwares.create',compact('data'));
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
            'system_no' => 'required',
            'seat_no' => 'required',
            'assigned_to' => 'required',
            'type' => 'required',
            'operating_system' => 'required',
        ]);
        $data['user_id']=auth()->user()->id;
        $hardware = Hardware::create($data);

        $data['hardware_id'] =$hardware->id;
        $hardwarehistory = HardwareHistory::create($data);

        return redirect()->route('hardware.index')->with(['success'=>'success','message'=>'Hardware added successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hardware=Hardware::find($id);
        $hardware->delete();
        return redirect()->route('hardware.index')->with(['success'=>'success','message'=>'Hardware deleted successfully']);
    }
    public function view($id){
        $hardware_info = Hardware::find($id);
        $hardware_history = HardwareHistory::where('hardware_id',$id)->get();
        // echo "<pre>";print_r($hardware_history);die;
        return view('hardware.hardwares.view',compact('hardware_info','hardware_history'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['type'] = array('1'=>'Desktop','2'=>'Laptop','3'=>'Mobile','4'=>'Tablet');

        $hardware = Hardware::find($id);

        return view('hardware.hardwares.edit',compact('hardware','data'));
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
            'system_no' => 'required',
            'seat_no' => 'required',
            'assigned_to' => 'required',
            'type' => 'required',
            'operating_system' => 'required',
        ]);

        $data=$request->all();
        $data['user_id']=auth()->user()->id;
        $hardware = Hardware::find($id);


        $hardware->fill($data);
        if ($hardware->isDirty()) {
            $hardware->save();
            $data['hardware_id'] =$id;
            $hardwarehistory = HardwareHistory::create($data);
        }
        return redirect()->route('hardware.index')->with(['success'=>'success','message'=>'Hardware updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $hardware=Hardware::find($id);
        $hardware->delete();
        return redirect()->route('hardware.index')->with(['success'=>'success','message'=>'Hardware deleted successfully']);

    }
}
