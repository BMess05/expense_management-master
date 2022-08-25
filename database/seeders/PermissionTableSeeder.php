<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\Schema;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // clear cache before running this seeder
         $permissions = [
           'dashboard',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',
           'expense-list',
           'expense-create',
           'expense-edit',
           'expense-delete',
           'bank-list',
           'bank-create',
           'bank-edit',
           'bank-delete',
           'resume-list',
           'resume-create',
           'resume-edit',
           'resume-delete',
           'resume-category-list',
           'resume-category-create',
           'resume-category-edit',
           'resume-category-delete',
           'standard-deduction-list',
           'standard-deduction-create',
           'standard-deduction-delete',
            'user-detail',
            'user-change-status',
            'manage-salaries',
            'salary-month-delete',
            'salary-month-detail',
            'user-bank-ac-list',
            'user-bank-ac-create',
            'user-bank-ac-edit',
            'user-bank-ac-delete',
            'users-export',
            'users-bank-details-export',
            'user-documents-list',
            'user-documents-create',
            'user-documents-edit',
            'user-documents-delete',
            'user-documents-view'
        ];

        Schema::disableForeignKeyConstraints();
        DB::table('permissions')->truncate();
        Schema::enableForeignKeyConstraints();
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
