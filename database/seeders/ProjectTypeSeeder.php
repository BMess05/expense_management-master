<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Business\ProjectType;

class ProjectTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Web','Mobile','Design'];

         foreach ($types as $type) {
             ProjectType::create(['type' => $type]);
        }

    }
}
