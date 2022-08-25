<?php

namespace App\Models;

use App\Models\Business\Bid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IsReadBidComment extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'is_read_bid_comments';
    protected $fillable = ['bid_id','bid_comment_id','assign_to','is_read'];

    public function bids(){
        return $this->belongsTo(Bid::class,'bid_id');
    }
}
