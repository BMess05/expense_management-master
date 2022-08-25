<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColCategoryId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('draft_expense_records', function (Blueprint $table) {
            $table->Integer('category_id')->nullable()->after('draft_id');
            $table->Integer('beneficiary_id')->nullable()->after('category_id');
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
            $table->dropColumn(['category_id','beneficiary_id']);
        });
    }
}
