<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DepartmentPosition;
use App\Models\Role;
use App\Models\User;

class Department extends Model
{
    use HasFactory;

    protected $table='departments';
    protected $fillable = ['name'];
    protected $guarded=['id'];

    public function roles(){
        return $this->hasMany(Role::class);
    }

    public function departmentPositions(){
        // return $this->hasMany(DepartmentPosition::class);
        return $this->belongsToMany(DepartmentPosition::class, 'department_department_position', 'department_id', 'department_position_id');
    }
    public function users(){
        return $this->hasMany(User::class,'department');
    }
}
