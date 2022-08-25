<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Targets', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->integer('profile_id');
            $table->string('job_id');
            $table->string('target_month');
            $table->date('hire_date');
            $table->string('type');
            $table->integer('hours')->nullable();
            $table->integer('minutes')->nullable();
            $table->decimal('hourly_price',8,2)->default(0.00)->nullable();
            $table->decimal('billing_amount',8,2)->default(0.00);
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
        Schema::dropIfExists('Targets');
    }
}
