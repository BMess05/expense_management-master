<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEmployeeLeavesYearly extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leaves_yearly', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->integer('joining_year');
            $table->float('allowed_leaves')->default(0);
            $table->float('pending_leaves')->default(0);
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
        Schema::dropIfExists('employee_leaves_yearly');
    }
}
