<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
class BeneficiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $permissions = [
            'beneficiary-list',
            'beneficiary-create',
            'beneficiary-edit',
            'beneficiary-delete',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
