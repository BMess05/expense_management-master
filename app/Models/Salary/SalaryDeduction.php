<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Salary\Salary;

class SalaryDeduction extends Model
{
    use HasFactory;
    protected $table = 'salary_deductions';
    protected $fillable = [
        'salary_id',
        'employee_id',
        'name',
        'amount',
        'description',
        'date'
    ];

    public function salary() {
        return $this->belongsTo(Salary::class, 'salary_id', 'id');
    }
}
