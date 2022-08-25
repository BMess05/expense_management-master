<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BidCommentImage;

class BidComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bid_comments';
    protected $fillable = ['user_id','bid_id','comment'];

    public function bid_comment_images(){
        return $this->hasMany(BidCommentImage::class,'bid_comment_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
