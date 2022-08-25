<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryIncentive extends Model
{
    use HasFactory;
    protected $table = 'salary_incentives';
    protected $fillable = [ 'salary_id', 'employee_id', 'date', 'amount', 'description' ];

    public function salary() {
        return $this->belongsTo(Salary::class, 'salary_id', 'id');
    }
}
