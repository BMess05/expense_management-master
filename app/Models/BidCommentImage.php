<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BidComment;

class BidCommentImage extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $table = 'bid_comment_images';
    protected $fillable = ['bid_comment_id','file_name'];

    public function bid_comment(){
        return $this->belongsTo(BidComment::class,'bid_comment_id', 'id');
    }
}
