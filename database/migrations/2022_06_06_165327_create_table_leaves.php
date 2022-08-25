<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLeaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salary_id');
            $table->foreignId('employee_id');
            $table->date('date');
            $table->foreignId('leave_type');
            $table->foreignId('cl_type');
            $table->string('description', 500)->nullable();
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
        Schema::dropIfExists('salary_leaves');
    }
}
