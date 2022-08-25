<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftExpenseRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_expense_records', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount',10,2)->default(0.00);
            $table->date('transaction_date');
            $table->smallInteger('type')->comment('1 = Debit, 2=Credit');
            $table->text('remarks');
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
        Schema::dropIfExists('draft_expense_records');
    }
}
