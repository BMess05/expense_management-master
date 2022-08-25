<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusReport extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'title',
        'report',
    ];

   public function setDateAttribute($value)
    {
        $this->attributes['date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }

    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    }
}
