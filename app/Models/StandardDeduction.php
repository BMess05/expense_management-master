<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class StandardDeduction extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table="standard_deductions";
    protected $fillable =['employee_id','epf','health_insurance','professional_tax'];

    public function user(){
        return $this->belongsTo(User::class,'employee_id');
    }
}
