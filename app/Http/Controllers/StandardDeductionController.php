<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StandardDeduction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StandardDeductionController extends Controller
{
    public function index(){
        $users = User::where('status',1)->get();
        $datas = StandardDeduction::select("*")
                            ->orderBy('created_at', 'desc')
                            ->get()
                            ->unique('employee_id');
        return view('standard-deduction.index',compact('users','datas'));
    }

    public function createStandardDeduction(Request $request){
        $previous = StandardDeduction::where('employee_id',$request->employee_id)->first();
        if($previous){
            return response()->json(['data' => '' ,200]);
        }
        $data = StandardDeduction::create([
            'employee_id'      => $request->employee_id,
            'epf'              => $request->epf,
            'health_insurance' => $request->health_insurance,
            'professional_tax' => $request->professional_tax,
        ]);
        if($data){
        return response()->json(['data' => $data ,200]);
        }
    }

    public function deleteStandardDeduction(Request $request){
        $data=StandardDeduction::where('id',$request->id)->delete();
        return redirect()->route('standard-deduction-index')->with(['success' => 'success', 'message' => 'Standard Deduction deleted successfully']);
    }
}
