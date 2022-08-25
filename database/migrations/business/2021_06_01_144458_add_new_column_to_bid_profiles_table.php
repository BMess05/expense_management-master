<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToBidProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bid_profiles', function (Blueprint $table) {
            $table->string('email')->nullable()->after('url');
            $table->string('username')->nullable()->after('email');
            $table->string('password')->nullable()->after('username');
            $table->text('security_question')->nullable()->after('password');
            $table->text('security_answer')->nullable()->after('security_question');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bid_profiles', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('username');
            $table->dropColumn('password');
            $table->dropColumn('security_question');
            $table->dropColumn('security_answer');
        });
    }
}
