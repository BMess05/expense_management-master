<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Salary\Salary;

class SalaryLeave extends Model
{
    use HasFactory;
    protected $table = 'salary_leaves';
    protected $fillable = [
        'salary_id',
        'employee_id',
        'date',
        'leave_type',
        'cl_type',
        'description'
    ];

    public function salary() {
        return $this->belongsTo(Salary::class, 'salary_id', 'id');
    }
}
