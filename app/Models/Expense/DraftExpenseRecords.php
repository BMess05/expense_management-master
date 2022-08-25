<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DraftExpenseRecords extends Model
{
    use HasFactory;
    protected $fillable = [
        'amount',
        'type',
        'transaction_date',
        'remarks',
        'category_id',
        'beneficiary_id',
    ];


     public function setTransactionDateAttribute($value)
    {
    	
        $this->attributes['transaction_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getTransactionDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }
}
