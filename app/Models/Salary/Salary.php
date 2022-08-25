<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Salary\SalaryMonth;
use App\Models\Salary\SalaryLeave;
use App\Models\Salary\SalaryDeduction;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
class Salary extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "salaries";
    protected $fillable = [
        'salary_month_id',
        'employee_id',
        'working_days',
        'no_of_days_worked',
        'ctc',
        'pf',
        'hi',
        'pt',
        'salary'
    ];

    public function salary_month() {
        return $this->belongsTo(SalaryMonth::class, 'salary_month_id', 'id');
    }

    public function salary_leaves() {
        return $this->hasMany(SalaryLeave::class, 'salary_id', 'id');
    }

    public function salary_deductions() {
        return $this->hasMany(SalaryDeduction::class, 'salary_id', 'id');
    }

    public function salary_incentives() {
        return $this->hasMany(SalaryIncentive::class, 'salary_id', 'id');
    }

    public function employee() {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
