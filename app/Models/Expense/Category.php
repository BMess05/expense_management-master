<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status'
    ];

    public function getNameAttribute($value)
    {
    	
        return ucfirst($value);
    }

}
