<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClType extends Model
{
    use HasFactory;
    protected $table = 'cl_type';
    protected $fillable = ['name'];
}
