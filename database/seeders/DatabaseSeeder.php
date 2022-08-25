<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //********resume seeder**********//
    //    $this->call(ExperienceSeeder::class);

        // //******business seeder******//
        // $this->call(ContractSeeder::class);
        // $this->call(ProjectTypeSeeder::class);
        //******/business seeder******//

        // $this->call(PermissionTableSeeder::class);
        // $this->call(AdminUserSeeder::class);

        // business module permission //
        // $this->call(BusinessPermissionSeeder::class);
        // $this->call(TargetandSettingSeeder::class);

        // Expense  module permission //
        // $this->call(BeneficiarySeeder::class);
        //dashboard module permission //
        // $this->call(DashboardSeeder::class);

        // Hardware Module Permission //
        //  $this->call(HardwareSeeder::class);
        // $this->call(SystemSettingSeeder::class);
        // $this->call(HardwareDashboardSeeder::class);
        // $this->call(AddingRoleSeeder::class);
        // $this->call(BusinessColorSettingSeeder::class);

        //Department Role Positions//
        // $this->call(DepartmentSeeder::class);

        // Leave types seeder
        // $this->call(LeaveTypesSeeder::class);
    }
}
