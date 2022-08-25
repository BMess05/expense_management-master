<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSalaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salary_month_id');
            $table->foreignId('employee_id');
            $table->integer('working_days')->default(0);
            $table->integer('no_of_days_worked')->default(0);
            $table->double('ctc', 10, 2)->default(0);
            $table->double('pf', 10, 2)->default(0)->comment="Provident Fund";
            $table->double('hi', 10, 2)->default(0)->comment="Health Insurance";
            $table->double('pt', 10, 2)->default(0)->comment="Professional Tax";
            $table->double('salary', 10, 2)->default(0)->comment="Final salary after deductions.";
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
        Schema::dropIfExists('salaries');
    }
}
