<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\User;

class DepartmentPosition extends Model
{
    use HasFactory;
    protected $table = 'department_positions';
    protected $fillable = ['name', 'department_id'];

    public function department(){
        // return $this->belongsTo(Department::class);
        return $this->belongsToMany(Department::class, 'department_department_position', 'department_position_id', 'department_id');
    }

    public function users(){
        return $this->hasMany(User::class, 'position');
    }


}
