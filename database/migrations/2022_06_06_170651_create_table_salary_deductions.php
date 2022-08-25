<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSalaryDeductions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salary_id');
            $table->foreignId('employee_id');
            $table->string('name');
            $table->integer('amount')->default(0);
            $table->string('description', 500)->nullable();
            $table->date('date');
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
        Schema::dropIfExists('salary_deductions');
    }
}
