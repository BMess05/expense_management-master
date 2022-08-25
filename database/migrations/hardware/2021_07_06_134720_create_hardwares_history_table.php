<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwaresHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardwares_history', function (Blueprint $table) {
            $table->id();
            $table->integer('hardware_id');
            $table->integer('user_id');
            $table->string('system_no',100)->nullable();
            $table->string('seat_no',100)->nullable();
            $table->string('assigned_to',255)->nullable();
            $table->tinyinteger('type')->nullable();
            $table->tinyinteger('operating_system')->nullable();
            $table->tinyinteger('ups')->default(1)->comment('0=No,1=Yes');
            $table->tinyinteger('screen')->default(1)->comment('0=No,1=Yes');
            $table->tinyinteger('keyboard')->default(1)->comment('0=No,1=Yes');
            $table->tinyinteger('mouse')->default(1)->comment('0=No,1=Yes');
            $table->string('mouse_type',100)->nullable();
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('hardwares_history');
    }
}
