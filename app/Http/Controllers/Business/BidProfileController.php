<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Business\Bid;
use App\Models\Business\BidProfile;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class BidProfileController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(){
        $this->middleware('permission:bid-profile-list|bid-profile-create|bid-profile-edit|bid-profile-delete', ['only' => ['index','save']]);
        $this->middleware('permission:bid-profile-create', ['only' => ['create','store']]);
        $this->middleware('permission:bid-profile-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bid-profile-delete', ['only' => ['show']]);
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $bidprofile = BidProfile::orderBy('id','ASC')->get();
        // echo "<pre>";print_r($bidprofile);die;
        return view('business.bidProfile.index',compact('bidprofile'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('business.bidProfile.create');
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
            'name' => 'required',
            'url' => 'required',
        ]);
        $data['user_id']=auth()->user()->id;
        $bid = BidProfile::create($data);
       
        return redirect()->route('bidprofile.index')->with(['success'=>'success','message'=>'Bid profile added successfully']);
    }
   
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bid = BidProfile::find($id);
        return view('business.bidProfile.edit',compact('bid'));
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
            'name' => 'required',
            'url' => 'required',
        ]);
    
        $data=$request->all();
        $data['user_id']=auth()->user()->id;
        $bid = BidProfile::find($id);
        $bid->fill($data)->save();
    
        return redirect()->route('bidprofile.index')->with(['success'=>'success','message'=>'Bid profile updated successfully']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $bid=BidProfile::find($id);
        $bid->delete();
        return redirect()->route('bidprofile.index')->with(['success'=>'success','message'=>'Bid profile deleted successfully']);
    }
}
