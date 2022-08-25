<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class EmployeeLeavesYearly extends Model
{
    use HasFactory;
    protected $table = 'employee_leaves_yearly';
    protected $fillable = [
        'employee_id',
        'joining_year',
        'allowed_leaves',
        'pending_leaves'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'employee_id', 'id');
    }
}
