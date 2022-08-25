<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [
           'system-setting-list'
        ];
    
    
 
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
