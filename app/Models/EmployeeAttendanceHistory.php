<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendanceHistory extends Model
{
    use HasFactory;
    protected $table = "employee_attendance_history";
    protected $fillable = ['employee_id','attendance_id','start_time','end_time','latitude','longitude','device','browser','ip_address','type','timer'];
}
