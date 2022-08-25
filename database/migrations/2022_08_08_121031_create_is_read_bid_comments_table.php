<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsReadBidCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('is_read_bid_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid_id');
            $table->unsignedBigInteger('bid_comment_id');
            $table->unsignedBigInteger('assign_to');
            $table->integer('is_read')->default(0)->comments('0=unread, 1=read');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('is_read_bid_comments');
    }
}
