<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Targets extends Model
{
    use HasFactory;
    protected $table = "Targets";
    protected $fillable = [
        'client_name',
        'profile_id',
        'billing_amount',
        'target_month',
        'hire_date',
        'type',
        'job_id',
        'user_id',
        'hours',
        'minutes',
        'hourly_price',
    ];
    public function setHireDateAttribute($value)
    {
        $this->attributes['hire_date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getHireDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }

    public function bidprofile() {
        return $this->belongsTo('App\Models\Business\BidProfile', 'profile_id', 'id');
    }
}
