<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColDraftId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('draft_expense_records', function (Blueprint $table) {
            $table->Integer('draft_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('draft_expense_records', function (Blueprint $table) {
           $table->dropColumn('draft_id');
        });
    }
}
