<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;
    protected $table="employee_attendance";
    protected $fillable = ['employee_id','date','total_time','total_break_time'];

    public function user(){
        return $this->belongsTo(User::class,'employee_id');
    }
}
