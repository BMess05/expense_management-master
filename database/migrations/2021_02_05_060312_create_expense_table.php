<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id');
            $table->decimal('amount',10,2)->default(0.00);
            $table->smallInteger('type')->comment('1 = Debit, 2=Credit');
            $table->date('transaction_date');
            $table->integer('beneficary_id')->nullable();
            $table->string('remarks');
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
        Schema::dropIfExists('expense');
    }
}
