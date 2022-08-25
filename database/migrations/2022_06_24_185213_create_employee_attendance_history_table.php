<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\EmployeeAttendance;
use App\Models\EmployeeAttendanceHistory;

class CreateEmployeeAttendanceHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_attendance_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->foreignId('attendance_id');
            $table->datetime('start_time');
            $table->datetime('end_time')->nullable();
            $table->string('latitude', 45);
            $table->string('longitude', 45);
            $table->string('device');
            $table->string('browser');
            $table->string('ip_address', 45);
            $table->string('type')->comment('Attendance,Break');
            $table->string('timer')->comment('Running,Stopped')->default('Running');
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
        Schema::dropIfExists('employee_attendance_history');
    }
}
