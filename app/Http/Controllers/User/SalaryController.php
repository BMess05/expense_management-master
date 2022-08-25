<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salary\SalaryMonth;
use App\Models\User;
use App\Models\EmployeeLeavesYearly;
use App\Models\StandardDeduction;
use App\Models\LeaveType;
use App\Models\ClType;
use App\Models\Salary\Salary;
use App\Models\Salary\SalaryIncentive;
use App\Http\Requests\AddSalaryRequest;
use App\Models\Salary\SalaryDeduction;
use App\Models\Salary\SalaryLeave;

// use Spatie\Permission\Models\Role;
// use DB;
// use Hash;
// use Illuminate\Support\Arr;
// use Mail;
// use URL;
// use Auth;
// use App\Models\SystemSetting;
// use App\Models\Department;
// use App\Models\DepartmentPosition;
// use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:manage-salaries|user-create|user-edit|user-delete', ['only' => ['manageSalaries', 'store']]);
        // $this->middleware('permission:user-create', ['only' => ['add', 'store']]);
        // $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        // $this->middleware('permission:system-setting-list', ['only' => ['edit_setting', 'update_setting']]);
    }

    public function manageSalaries() {
        $months = [ 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December' ];
        $data = SalaryMonth::orderBy('id', 'DESC')->get();
        return view('salaries.manage_salaries', compact('months', 'data'));
    }

    public function saveSalaryMonth(Request $request) {
        $data = $request->all();

        $sal_month = SalaryMonth::where(['month' => $data['month'], 'year' => $data['year']])->first();
        if($sal_month) {
            return "";
        }   else {
            $sal_month = SalaryMonth::where(['month' => $data['month'], 'year' => $data['year']])->withTrashed()->first();
            if($sal_month) {
                $res = SalaryMonth::where(['month' => $data['month'], 'year' => $data['year']])->withTrashed()->update(['deleted_at' => null]);
            }   else {
                $res = SalaryMonth::updateOrCreate([
                    'month' => $data['month'],
                    'year' => $data['year']
                ], []);
            }

            if($res) {
                $data = SalaryMonth::orderBy('id', 'DESC')->get();
                return view('salaries.list_salary_months', compact('data'))->render();
                // ->with('i', ($request->input('page', 1) - 1) * 5)
            }   else {
                return "";
            }
        }
    }

    public function delete($id) {
        $sal_month = SalaryMonth::find($id);
        if($sal_month) {
            $sal_month->delete();
            return redirect()->route('manageSalaries')->with(['success' => 'success', 'message' => 'Salary month deleted successfully.']);
        }   else {
            return redirect()->route('manageSalaries')->with(['success' => 'danger', 'message' => 'Invalid ID.']);
        }
    }

    public function listSalaries($salary_month_id) {
        $salary_month = SalaryMonth::find($salary_month_id);

        if(!$salary_month) {
            return redirect()->route('manageSalaries')->with(['success' => 'danger', 'message' => 'Invalid ID.']);
        }
        $salaries = Salary::with('employee')->where('salary_month_id', $salary_month_id)->get();
        // dd($salaries);
        return view('salaries.list_salaries')->with(['salary_month_id' => $salary_month_id, 'salaries' => $salaries]);
    }

    public function addSalary($salary_month_id) {
        $salary_month = SalaryMonth::find($salary_month_id);
        if(!$salary_month) {
            return redirect()->route('manageSalaries')->with(['success' => 'danger', 'message' => 'Invalid ID.']);
        }
        $month = $salary_month->month;
        $year = $salary_month->year;
        $employees = User::where('department', '!=', 0)->pluck('name', 'id')->all();
        $leave_types = LeaveType::pluck('name', 'id')->all();
        $cl_leave_type = ClType::pluck('name', 'id')->all();
        return view('salaries.add_salary', compact(['salary_month_id', 'employees', 'month', 'year', 'leave_types', 'cl_leave_type']));
    }

    public function saveSalary($salary_month_id, AddSalaryRequest $request) {
        $data = $request->all();
        // dd($data);
        $employee = User::find($data['employee']);
        if(!$employee) {
            return redirect()->back()->with(['success' => 'danger', 'message' => 'Invalid employee ID.'])->withInput();
        }
        // echo "...here...";
        // dd($data);
        $salary = new Salary();
        $salary->salary_month_id = $salary_month_id;
        $salary->employee_id = $data['employee'];
        $salary->working_days = $data['working_days'];
        $salary->no_of_days_worked = $data['no_of_days_worked'];
        $salary->ctc = $employee->ctc;
        $salary->pf = $employee->sd_pf ?? 0;
        $salary->hi = $employee->sd_i ?? 0;
        $salary->pt = $employee->sd_pt ?? 0;
        if($salary->save()) {

            if(count($data['deduction_name']) > 0) {
                foreach($data['deduction_name'] as $index => $d_name) {
                    $s_deduction = new SalaryDeduction();
                    $s_deduction->salary_id = $salary->id;
                    $s_deduction->employee_id = $data['employee'];
                    $s_deduction->name = $d_name;
                    $s_deduction->amount = $data['deduction_amount'][$index] ?? 0;
                    $s_deduction->description = $data['deduction_description'][$index] ?? '';
                    $s_deduction->date = isset($data['deduction_date'][$index]) ? date('Y-m-d', strtotime($data['deduction_date'][$index])) : '';
                    $s_deduction->save();
                }

            }

            $cl_taken = 0;
            if(count($data['leave_type']) > 0) {
                foreach($data['leave_type'] as $l_index => $leave) {
                    $lv = new SalaryLeave();
                    $lv->salary_id = $salary->id;
                    $lv->employee_id = $data['employee'];
                    $lv->date = $data['leave_date'][$l_index] ? date('Y-m-d', strtotime($data['leave_date'][$l_index])) : '';
                    $lv->leave_type = $leave;
                    $lv->cl_type = $data['cl_leave_type'][$l_index];
                    $lv->description = $data['leave_description'][$l_index];
                    $lv->save();
                    if($leave == 1) {
                        $cl = ClType::find($data['cl_leave_type'][$l_index]);
                        $cl_taken = $cl_taken + $cl->value;
                    }
                }
            }

            if(count($data['incentive_date']) > 0) {
                foreach($data['incentive_date'] as $i_index => $i_date) {
                    $inc = new SalaryIncentive();
                    $inc->salary_id = $salary->id;
                    $inc->employee_id = $data['employee'];
                    $inc->date = $i_date ? date('Y-m-d', strtotime($i_date)) : '';
                    $inc->amount = $data['incentive_amount'][$i_index];
                    $inc->description = $data['incentive_description'][$i_index];
                    $inc->save();
                }
            }

            if($cl_taken > 0) {
                $pending_leaves = EmployeeLeavesYearly::where('employee_id', $data['employee'])->first();
                $pending_count_old = $pending_leaves->pending_leaves;
                $pending_count_new = $pending_count_old - $cl_taken;
                $pending_leaves->pending_leaves = $pending_count_new;
                $pending_leaves->save();
            }

            $net_salary = $this->getNetSalary($employee->ctc, $data, $employee);
            $salary->salary = $net_salary;
            if($salary->save()) {
                return redirect()->route('listSalaries', $salary_month_id)->with(['success' => 'success', 'message' => 'Invalid employee ID.'])->withInput();

            }
        }
        return redirect()->back()->with(['success' => 'danger', 'message' => 'Something went wrong, please try again.'])->withInput();
    }


    public function getNetSalary($yearly_ctc, $data, $employee) {
        $monthly_ctc = $yearly_ctc / 12;
        $daily_wage = $monthly_ctc / $data['working_days'];
        $monthly_cost = $daily_wage * $data['no_of_days_worked'];
        $deductions = 0;
        $incentives = 0;
        $leave_deductions = 0;
        if(count($data['deduction_amount']) > 0) {
            foreach($data['deduction_amount'] as $d_amount) {
                if(is_numeric($d_amount)) {
                    $deductions = $deductions + $d_amount;
                }
            }
        }

        if(count($data['incentive_amount']) > 0) {
            foreach($data['incentive_amount'] as $i_amount) {
                if(is_numeric($i_amount)) {
                    $incentives = $incentives + $i_amount;
                }
            }
        }

        if(count($data['leave_type']) > 0) {
            /**
             * 1 => Casual Leave (No deduction)
             * 2 => Paid Leave
             * 3 => Medical Leave (No deduction) (doubt)
             * 4 => Other
            */
            foreach($data['leave_type'] as $l_index => $l_type) {
                if($l_type == 2 || $l_type == 4) {
                    $deduction_amount = 0;
                    if($data['cl_leave_type'][$l_index]) {
                        $cl = ClType::find($data['cl_leave_type'][$l_index]);
                        if($cl) {
                            $deduction_amount = $daily_wage * $cl->value;
                        }
                    }
                    $leave_deductions = $leave_deductions + $deduction_amount;
                }
            }
        }

        $pf = $employee->sd_pf ?? 0;
        $hi = $employee->sd_i ?? 0;
        $pt = $employee->sd_pt ?? 0;

        $net_salary = $monthly_cost - ($pf + $hi + $pt + $deductions + $leave_deductions) + $incentives;
        return $net_salary;
    }

    public function getEmployeeDetails($employee_id) {
        $employee = User::find($employee_id);
        if(!$employee) {
            return response()->json([
                'status' => 0,
                'message' => 'Invalid employee ID'
            ]);
        }
        $employee_leaves_yearly = EmployeeLeavesYearly::where('employee_id', $employee_id)->first();
        $medical_leaves_availed = 0;
        if($employee_leaves_yearly) {
            $pending_leaves = $employee_leaves_yearly->pending_leaves;
        }   else {
            $pending_leaves = 0;
        }
        $standard_deductions = StandardDeduction::where('employee_id', $employee_id)->orderBy('id', 'DESC')->first();
        if($standard_deductions) {
            $sds['pf'] = $standard_deductions->epf;
            $sds['hi'] = $standard_deductions->health_insurance;
            $sds['pt'] = $standard_deductions->professional_tax;
        }   else {
            $sds['pf'] = 0;
            $sds['hi'] = 0;
            $sds['pt'] = 0;
        }
        $monthly_ctc = round($employee->ctc / 12, 2);
        return response()->json([
            'status' => 1,
            'data' => [
                'medical_leaves_availed' => $medical_leaves_availed,
                'pending_leaves' => $pending_leaves,
                'monthly_ctc' => $monthly_ctc,
                'standard_deductions' => $sds
            ]
        ]);
    }

    public function deleteSalary($id) {
        Salary::whereId($id)->delete();
        return redirect()->back()->with(['success' => 'success', 'message' => 'Salary seleted successfully.']);
    }
}
