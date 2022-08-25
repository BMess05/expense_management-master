<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class IssuedDocument extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'issued_documents';
    protected $fillable = ['employee_id','doc_name','issued_date','document'];

    public function user(){
        return $this->belongsTo(User::class,'employee_id');
    }
}
