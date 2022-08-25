<?php

namespace App\Models\Salary;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Salary\Salary;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryMonth extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "salary_months";
    protected $fillable = [
        'month', 'year'
    ];

    protected $appends = [
        'month_name'
    ];

    public function getMonthNameAttribute()
    {
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
        return $months[$this->attributes['month']];
    }

    public function salary() {
        return $this->hasMany(Salary::class, 'salary_month_id', 'id');
    }
}
