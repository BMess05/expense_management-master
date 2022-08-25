<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeAttendanceHistory;
use Carbon\Carbon;
use Auth;
use Carbon\Doctrine\CarbonDoctrineType;

class AttendanceController extends Controller
{
  public function punchIn(Request $request)
  {
    $yesterdayAttendance = EmployeeAttendanceHistory::where('employee_id', auth()->user()->id)->whereDate('created_at','!=', Carbon::today())->where('timer','Running')->latest()->first();
    $todayAttendance = EmployeeAttendance::where('employee_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->latest()->first();
    if (!isset($todayAttendance) && empty($yesterdayAttendance)) {
      $attendance = new EmployeeAttendance;
      $attendance->employee_id = auth()->user()->id;
      $attendance->save();
    }
    $attendance_id = EmployeeAttendance::where('employee_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->latest()->first();
    $agent = new Agent;
    if ($agent->isMobile()) {
      $device = 'Mobile';
    } else if ($agent->isDesktop()) {
      $device = 'Desktop';
    } else if ($agent->isTablet()) {
      $device = 'Tablet';
    } else {
      $device = 'Unknown';
    }
    $attedanceHist = new EmployeeAttendanceHistory;
    $attedanceHist->employee_id = auth()->user()->id;
    if(!empty($yesterdayAttendance)){
      $attedanceHist->attendance_id = $yesterdayAttendance->attendance_id;
      $attedanceHist->start_time = $yesterdayAttendance->start_time;
    }else{
    $attedanceHist->attendance_id = $attendance_id->id;
    $attedanceHist->start_time = Carbon::now();
    }
    $attedanceHist->latitude = $request->latitude;
    $attedanceHist->longitude = $request->longitude;
    $attedanceHist->device = $device;
    $attedanceHist->browser = $agent->browser();
    $attedanceHist->ip_address = $request->ip();
    $attedanceHist->type = $request->type;
    $attedanceHist->save();
  }

  public function punchOut(Request $request)
  {
    $yesterdayAttendance = EmployeeAttendanceHistory::where('employee_id', auth()->user()->id)->whereDate('start_time','!=', Carbon::today())->where('timer','Running')->latest()->first();
    if (!empty($yesterdayAttendance) && $yesterdayAttendance->timer == "Running") {
      $last_time = $yesterdayAttendance->updated_at;
      $attendance_id=$yesterdayAttendance->attendance_id;
      $id = $yesterdayAttendance->id;
      if ($request->refresh == 'true') {
        $yesterdayAttendance->end_time = Carbon::now();
        $yesterdayAttendance->timer = 'Running';
        $yesterdayAttendance->save();
      } else if ($request->refresh == 'false') {
        $yesterdayAttendance->end_time = Carbon::now();
        $yesterdayAttendance->save();
        $stopTimer = EmployeeAttendanceHistory::where('attendance_id', $attendance_id)->update(['timer'=>'Stopped']);
      }
      $attedanceHist = EmployeeAttendanceHistory::where('id', $id)->first();
      $start_time = $last_time;
      $end_time = $attedanceHist->end_time;
      $new_time = $start_time->diffInSeconds($end_time);
      $attendance = EmployeeAttendance::where('id', $attendance_id)->first();
      if ($yesterdayAttendance->type == 'Attendance') {
        $attendance->total_attendance_time += $new_time;
        $attendance->save();
        return response()->json(['type' => $yesterdayAttendance->type]);
      } else if ($yesterdayAttendance->type == 'Break') {
        $attendance->total_break_time += $new_time;
        $attendance->save();
        return response()->json(['type' => $yesterdayAttendance->type]);
      }
    } else {
    $attedanceHist = EmployeeAttendanceHistory::where('employee_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->where('timer','Running')->latest()->first();
    if (!empty($attedanceHist) && $attedanceHist->timer == "Running") {
      $last_time = $attedanceHist->updated_at;
      $end_time = $attedanceHist->end_time;
      $attendance_id=$attedanceHist->attendance_id;
      $id = $attedanceHist->id;
      if ($request->refresh == 'true') {
        $attedanceHist->end_time = Carbon::now();
        $attedanceHist->timer = 'Running';
        $attedanceHist->save();
      } else if ($request->refresh == 'false') {
        $attedanceHist->end_time = Carbon::now();
        $attedanceHist->save();
        $stopTimer = EmployeeAttendanceHistory::where('attendance_id', $attendance_id)->update(['timer'=>'Stopped']);
      }
      $attedanceHist = EmployeeAttendanceHistory::where('id', $id)->first();
      $start_time = $last_time;
      $end_time = $attedanceHist->end_time;
      $new_time = $start_time->diffInSeconds($end_time);
      $attendance = EmployeeAttendance::where('id', $attendance_id)->first();
      if ($attedanceHist->type == 'Attendance') {
        $attendance->total_attendance_time += $new_time;
        $attendance->save();
        return response()->json(['type' => $attedanceHist->type]);
      } else if ($attedanceHist->type == 'Break') {
        $attendance->total_break_time += $new_time;
        $attendance->save();
        return response()->json(['type' => $attedanceHist->type]);
      }
    } else {
      return response()->json(['type' => 'empty']);
    }
  }
  }
  public function index(Request $request)
  {
    if(Auth::user()->hasRole('Admin')){
      if($request->has('date')){
        $date = date('Y-m-d',strtotime($request->date));
        $attendance = EmployeeAttendance::whereDate('created_at',$date)->get();
        return view('attendance.datepickerAdmin',compact('attendance'))->render();
      }else{
      $date = Carbon::today();
      $attendance = EmployeeAttendance::whereDate('created_at',Carbon::today())->get();
      return view('attendance.index',compact('attendance','date'));
      }
    }else{
      if($request->has('start_date') && $request->has('end_date')){
        $start_date = $request->start_date;
        $end_date = Carbon::parse($request->end_date)->addDays(1);
        $attendance = EmployeeAttendance::whereBetween('created_at', [$start_date, $end_date])->where('employee_id', Auth::user()->id)->orderBy('created_at','DESC')->get();
        return view('attendance.datepickerEmployee',compact('attendance'))->render();
      }else{
      $attendance = EmployeeAttendance::where('employee_id', Auth::user()->id)->whereMonth('created_at', Carbon::now()->month)->orderBy('created_at','DESC')->get();
      return view('attendance.employeeAttendance',compact('attendance'));
      }
    }
  }

  public function attendanceDetail(Request $request){
    $attendanceDetail = EmployeeAttendanceHistory::where('attendance_id',$request->attendance_id)->get();
    $firstAttendance = EmployeeAttendance::where('id',$request->attendance_id)->first();
    $date = $firstAttendance->created_at;
    return view('attendance.attendanceDetail',compact('attendanceDetail','date'));
  }

  public function getTotalTime(Request $request)
  {
    $yesterdayAttendance = EmployeeAttendanceHistory::where('employee_id', auth()->user()->id)->whereDate('created_at','!=', Carbon::today())->where('timer','Running')->latest()->first();
    if(!empty($yesterdayAttendance)){
      $attendance_id=$yesterdayAttendance->attendance_id;
      if ($request->type == "Attendance") {
        $punch_in_time = EmployeeAttendance::where('id', $attendance_id)->first();
        $timeInSec = $punch_in_time->total_attendance_time ?? 00;
        $d = (gmdate("d", $timeInSec)-1)*24 ?? 00;
        $hours = gmdate("H", $timeInSec) ?? 00;
        $daysHours = $d + $hours;
        $days = sprintf("%02d", $daysHours);
        $minutes = gmdate("i", $timeInSec) ?? 00;
        $seconds = gmdate("s", $timeInSec) ?? 00;
        $opposite_attendance = $punch_in_time->total_break_time ?? 00;
        return response()->json(['days' => $days, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds, 'opposite_attendance' => $opposite_attendance]);
      } else if ($request->type == "Break") {
        $punch_in_time = EmployeeAttendance::where('id', $attendance_id)->first();
        $timeInSec = $punch_in_time->total_break_time ?? 00;
        $d = (gmdate("d", $timeInSec)-1)*24 ?? 00;
        $hours = gmdate("H", $timeInSec) ?? 00;
        $daysHours = $d + $hours;
        $days = sprintf("%02d", $daysHours);
        $minutes = gmdate("i", $timeInSec) ?? 00;
        $seconds = gmdate("s", $timeInSec) ?? 00;
        $opposite_attendance = $punch_in_time->total_attendance_time ?? 00;
        return response()->json(['days' => $days, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds, 'opposite_attendance' => $opposite_attendance]);
      }
    }else{
    if ($request->type == "Attendance") {
      $punch_in_time = EmployeeAttendance::where('employee_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->latest()->first();
      $timeInSec = $punch_in_time->total_attendance_time ?? 00;
      $d = (gmdate("d", $timeInSec)-1)*24 ?? 00;
      $hours = gmdate("H", $timeInSec) ?? 00;
      $daysHours = $d + $hours;
      $days = sprintf("%02d", $daysHours);
      $minutes = gmdate("i", $timeInSec) ?? 00;
      $seconds = gmdate("s", $timeInSec) ?? 00;
      $opposite_attendance = $punch_in_time->total_break_time ?? 00;
      return response()->json(['days' => $days, 'hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds, 'opposite_attendance' => $opposite_attendance]);
    } else if ($request->type == "Break") {
      $punch_in_time = EmployeeAttendance::where('employee_id', auth()->user()->id)->whereDate('created_at', Carbon::today())->latest()->first();
      $timeInSec = $punch_in_time->total_break_time ?? 00;
      $d = (gmdate("d", $timeInSec)-1)*24 ?? 00;
      $hours = gmdate("H", $timeInSec) ?? 00;
      $daysHours = $d + $hours;
      $days = sprintf("%02d", $daysHours);
      $minutes = gmdate("i", $timeInSec) ?? 00;
      $seconds = gmdate("s", $timeInSec) ?? 00;
      $opposite_attendance = $punch_in_time->total_attendance_time ?? 00;
      return response()->json(['days' => $days,'hours' => $hours, 'minutes' => $minutes, 'seconds' => $seconds, 'opposite_attendance' => $opposite_attendance]);
    }
  }
}
}
