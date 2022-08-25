<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->bigInteger('total_attendance_time')->comment('in seconds')->nullable();
            $table->bigInteger('total_break_time')->comment('in seconds')->nullable();
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
        Schema::dropIfExists('employee_attendance');
    }
}
