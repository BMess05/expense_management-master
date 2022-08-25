<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSalaryIncentives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_incentives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salary_id');
            $table->foreignId('employee_id');
            $table->date('date')->nullable();
            $table->double('amount', 8, 2)->default(0.0);
            $table->string('description', 1200)->nullable();
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
        Schema::dropIfExists('salary_incentives');
    }
}
