<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
class TargetandSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      
          
        $permissions = [
           'target-list',
           'target-create',
           'target-edit',
           'target-delete',
           'settings-list',
           'settings-create',
           'settings-edit',
           'settings-delete',
        ];
    
    
 
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
    }
    
}
