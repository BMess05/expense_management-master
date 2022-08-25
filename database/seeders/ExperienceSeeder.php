<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('experiences')->insert([
            'experience' => 'Fresher'
        ]);

        DB::table('experiences')->insert([
            'experience' => 'Less than 1 Year'
        ]);

         DB::table('experiences')->insert([
            'experience' => '1-2 Years'
        ]);
          DB::table('experiences')->insert([
            'experience' => '2-3 Years'
        ]);
         DB::table('experiences')->insert([
            'experience' => 'Beginner'
        ]);

        DB::table('experiences')->insert([
            'experience' => '3-4 Years'
        ]);

        DB::table('experiences')->insert([
            'experience' => '4-5 Years'
        ]);

         DB::table('experiences')->insert([
            'experience' => '5-6 Years'
        ]);
          DB::table('experiences')->insert([
            'experience' => '6-7 Years'
        ]);
         DB::table('experiences')->insert([
            'experience' => '7-8 Years'
        ]); 
         DB::table('experiences')->insert([
            'experience' => '8-9 Years'
        ]);
          DB::table('experiences')->insert([
            'experience' => '9-10 Years'
        ]);
         DB::table('experiences')->insert([
            'experience' => 'More than 10 Years'
        ]); 
        

    }
}
