<?php

namespace App\Models\Resume;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResumeCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'category_name'
    ];

}
