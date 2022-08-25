<?php

namespace App\Models\Business;

use App\Models\IsReadBidComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bid extends Model
{
    use HasFactory, SoftDeletes;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bid_id',
        'job_id',
        'client_name',
        'bid_url',
        'perposal',
        'comment',
        'user_id',
        'job_type',
        'bid_amount'
    ];

    /*protected $appends = ['bid_profile'];

    public function getBidProfileAttribute() {
        return BidProfile::select(['id', 'name','url'])->find($this->attributes['bid_id']);
    }*/

    public function bidprofile() {
        return $this->belongsTo('App\Models\Business\BidProfile', 'bid_id', 'id');
    }
    public function biduser() {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function is_read_bid_comments(){
        return $this->hasMany(IsReadBidComment::class,'bid_id')->where('assign_to',auth()->user()->id)->where('is_read',0);
    }
}
