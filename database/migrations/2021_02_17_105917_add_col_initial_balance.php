<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColInitialBalance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->decimal('initial_balance',10,2)->default(0.00)->after('account_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('initial_balance');
        });
    }
}
