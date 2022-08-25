<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use DB;
use App\Models\User;
use Spatie\Permission\Models\Role;
class BusinessPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          
        $permissions = [
           'bid-list',
           'bid-create',
           'bid-edit',
           'bid-delete',
           'bid-profile-list',
           'bid-profile-create',
           'bid-profile-edit',
           'bid-profile-delete',
        //    'profile-status-list',
        //    'profile-status-create',
        //    'profile-status-edit',
        //    'profile-status-delete',
            
 
         ];
    
    
 
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        
    }
}
