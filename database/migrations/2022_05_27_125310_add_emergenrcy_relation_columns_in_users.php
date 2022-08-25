<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmergenrcyRelationColumnsInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('emergency_person_relation')->nullable()->after('emergency_phone');
            $table->string('alt_emergency_person_relation')->nullable()->after('alt_emergency_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['emergency_person_relation', 'alt_emergency_person_relation']);
        });
    }
}
