<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class userBankAccount extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="user_bank_accounts";
    protected $fillable=['employee_id','ac_holder','account_no','ifsc_code','bank_name'];

    public function user(){
        return $this->belongsTo(User::class,'employee_id');
    }
}
