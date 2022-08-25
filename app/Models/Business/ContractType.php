<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type'
    ];

    /*protected $appends = ['bid_profile'];

    public function getBidProfileAttribute() {
        return BidProfile::select(['id', 'name','url'])->find($this->attributes['bid_id']);
    }*/

    public function bidprofile() {
        return $this->belongsTo('App\Models\Business\BidProfile', 'bid_id', 'id');
    }

}
