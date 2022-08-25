<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('personal_email')->nullable();
            $table->date('dob')->nullable();
            $table->string('personal_phone')->nullable();
            $table->string('personal_phone_alt')->nullable();
            $table->string('gender')->nullable();
            $table->string('current_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('adhar_card_front')->nullable();
            $table->string('adhar_card_back')->nullable();
            $table->string('pan_card')->nullable();
            $table->string('employee_id')->nullable();
            $table->float('total_experience_till_joining')->default(0);
            $table->dateTime('date_of_joining')->nullable();
            $table->float('ctc',10,2)->default(0.0);

            $table->integer('department')->default(0);
            $table->integer('position')->default(0);

            $table->string('pf_number')->nullable();
            $table->tinyInteger('on_probation')->default(0);
            $table->string('experience_certificate_picture')->nullable();
            $table->dateTime('probation_complete_date')->nullable();
            $table->integer('allowed_leaves')->default(0);
            $table->string('emergency_person_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('alt_emergency_person_name')->nullable();
            $table->string('alt_emergency_phone')->nullable();
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
            $table->dropColumn([
                'personal_email',
                'dob',
                'personal_phone',
                'personal_phone_alt',
                'gender',
                'current_address',
                'permanent_address',
                'adhar_card_front',
                'adhar_card_back',
                'pan_card',
                'employee_id',
                'total_experience_till_joining',
                'date_of_joining',
                'ctc',
                'department',
                'position',
                'pf_number',
                'on_probation',
                'experience_certificate_picture',
                'probation_complete_date',
                'allowed_leaves',
                'emergency_person_name',
                'emergency_phone',
                'alt_emergency_person_name',
                'alt_emergency_phone'
            ]);
        });
    }
}
