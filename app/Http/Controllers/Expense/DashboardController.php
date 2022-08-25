<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EmployeeAttendance;
use App\Models\Expense\Category;
use App\Models\Expense\Beneficiary;
use App\Models\Expense\BankAccount;
use App\Models\Expense\Expense;
use Carbon\Carbon;
use App\Models\Resume\Resume;
use App\Models\Resume\ResumeCategory;
use App\Models\Business\Bid;
use App\Models\Business\BidProfile;
use App\Models\Business\Targets;
use App\Models\Business\Settings;
use App\Models\Hardware\Hardware;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
  
    public function index()
    {
        $data['categories']=Category::all()->count();
        $data['beneficiaries']=Beneficiary::all()->count();
        $data['bank_accounts']=BankAccount::all()->count();
        $data['expenses']=Expense::sum('amount');
        $data['resume_category']=ResumeCategory::all()->count();
        $data['resumes']=Resume::all()->count();
        $data['bid_profile']=BidProfile::all()->count();
        $data['all_targets']=Targets::sum('billing_amount');
        $data['my_targets']=Targets::where('user_id',auth()->user()->id)->sum('billing_amount');
        $data['team_targets']=Settings::sum('target_amount');
        $data['hardware']=Hardware::all()->count();
        if(auth()->user()->id == 1){
            $data['bids']=Bid::all()->count();
        }else{
            $data['bids']=Bid::all()->where('user_id',auth()->user()->id)->count();
        }
      
     

        
        $current_year=date("Y");
        $from = date("Y-m-d",strtotime('1-April-'.($current_year-1)));
        $to=    date("Y-m-d",strtotime('31-March-'.($current_year)));
        $data['current_year_expenses'] =Expense::whereBetween('transaction_date', [$from, $to])->sum('amount');
        $data['current_year_expenses_credit'] =Expense::whereBetween('transaction_date', [$from, $to])->where('type',2)->sum('amount');
        $data['current_year_expenses_debit'] =Expense::whereBetween('transaction_date', [$from, $to])->where('type',1)->sum('amount');

        $data['current_month_expenses'] =Expense::whereMonth('transaction_date', Carbon::now()->month)->whereYear('transaction_date',Carbon::now()->year)->sum('amount');
        $data['current_month_expenses_credit'] =Expense::whereMonth('transaction_date', Carbon::now()->month)->whereYear('transaction_date',Carbon::now()->year)->where('type',2)->sum('amount');
        $data['current_month_expenses_debit'] =Expense::whereMonth('transaction_date', Carbon::now()->month)->whereYear('transaction_date',Carbon::now()->year)->where('type',1)->sum('amount');
        
        $data['user_birthdays'] =User::where('status',1)
        ->where(function ($query) {
            $query->whereMonth('dob', Carbon::now()->month)
            ->whereDay('dob','>=', Carbon::now()->day)
                 ->orWhereMonth('dob', Carbon::now()->addMonth(1)->month);
        })->get();
        
        $data['user_work_anniversaries'] =User::where('status',1)
        ->where(function ($query) {
            $query->whereMonth('date_of_joining', Carbon::now()->month)
            ->whereDay('date_of_joining','>=', Carbon::now()->day)
                 ->orWhereMonth('date_of_joining', Carbon::now()->addMonth(1)->month);
        })->get();
       
        $punch_in_time = EmployeeAttendance::where('employee_id',auth()->user()->id)->whereDate('created_at', Carbon::today())->latest()->first();
        $timeInSec = $punch_in_time->total_attendance_time ?? 00;
        $d = (gmdate("d", $timeInSec)-1)*24 ?? 00;
        $hours = gmdate("H", $timeInSec) ?? 00;
        $daysHours = $d + $hours;
        $days = sprintf("%02d", $daysHours);
        $minutes = gmdate("i", $timeInSec) ?? 00;
        $seconds = gmdate("s", $timeInSec) ?? 00;
        $data['total_time'] = ['days' => $days, 'hours' => $hours,'minutes' => $minutes,'seconds' => $seconds];
        $data['opposite_attendance'] = $punch_in_time->total_break_time ?? 00;
        return view('expense.dashboard',compact('data'));
    }
}
