<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Business\ContractType;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractType::create([
            'type'        => 'Fixed',
        ]);
        ContractType::create([
            'type'        => 'Hourly',
        ]);

    }
}
