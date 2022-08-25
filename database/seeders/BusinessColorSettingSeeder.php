<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class BusinessColorSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now('utc')->toDateTimeString();
        DB::table('business_settings_colors')->insert(array(
            array(
                'key' => '0',
                'value' => '#8898aa',
                'created_at'=> $now,
                'updated_at'=> $now
            ),
            array(
                'key' => '1',
                'value' => '#FFA500',
                'created_at'=> $now,
                'updated_at'=> $now
            ),
            array(
                'key' => '2',
                'value' => '#EE4B2B',
                'created_at'=> $now,
                'updated_at'=> $now
            ),
            array(
                'key' => '3',
                'value' => '#009933',
                'created_at'=> $now,
                'updated_at'=> $now
            ),
            array(
                'key' => '4',
                'value' => '#0000FF',
                'created_at'=> $now,
                'updated_at'=> $now
            ),
        ));
    }
}
