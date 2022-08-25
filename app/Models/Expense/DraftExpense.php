<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftExpense extends Model
{
    use HasFactory;
     protected $fillable = [
        'user_id',
        'account_no',
        'title'
    ];



    public function draft_records() {
        return $this->hasMany('App\Models\Expense\DraftExpenseRecords','draft_id','id');

        
    }



}
