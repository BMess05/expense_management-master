<?php

namespace App\Models\Hardware;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    use HasFactory;
    protected $table = "hardwares";
    protected $fillable = [
        'system_no',
        'seat_no',
        'assigned_to',
        'type',
        'operating_system',
        'ups',
        'screen',
        'keyboard',
        'mouse',
        'mouse_type',
        'comment',
        'user_id'
    ];
    public function hardwareuser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    
}
