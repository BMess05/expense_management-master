<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'amount',
        'type',
        'transaction_date',
        'beneficary_id',
        'remarks',
        'account_no',
    ];

    protected $appends = ['category', 'beneficary'];


    public function getCategoryAttribute() {
        return Category::select(['id', 'name'])->withTrashed()->find($this->attributes['category_id']);
    }

    public function getBeneficaryAttribute() {
        return Beneficiary::select(['id', 'name'])->withTrashed()->find($this->attributes['beneficary_id']);
    }
    

    public function setTransactionDateAttribute($value)
    {
        $this->attributes['transaction_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getTransactionDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }
}
