<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('contract_type');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('project_type');
            $table->decimal('total_price')->default(0.00);
            $table->string('job_posting_url')->nullable();
            $table->decimal('payment_received')->default(0.00);
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
        Schema::dropIfExists('projects');
    }
}
