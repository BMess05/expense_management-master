<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FavouriteBid extends Model
{
    use HasFactory ,SoftDeletes;
    protected $table = 'favourite_bids';
    protected $fillable = ['user_id','bid_id'];
}
