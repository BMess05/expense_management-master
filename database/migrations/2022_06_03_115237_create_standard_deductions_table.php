<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandardDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('standard_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->float('epf');
            $table->float('health_insurance');
            $table->float('professional_tax');
            $table->integer('status')->default(1);
            $table->integer('type')->default(0);
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
        Schema::dropIfExists('standard_deductions');
    }
}
