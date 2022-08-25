<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Role;
use DB;
use App\Models\DepartmentPosition;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Department::truncate();
        Role::truncate();
        DepartmentPosition::truncate();
        DB::table('department_department_position')->truncate();

        $departments = [
            [
                'name' => 'Admin',
                'roles' => [
                    ['name' => 'Admin'],
                ],
                'positions' => [
                    ['name' => 'Admin'],
                ],
            ],
            [
                'name' => 'Human Resource',
                'roles' => [
                    ['name' => 'Recruiter'],
                ],
                'positions' => [
                    ['name' => 'Trainee'],
                    ['name' => 'Human Resource Manager'],
                    ['name' => 'Human Resource Executive']
                ],
            ],
            [
                'name' => 'Mobile Development',
                'roles' => [
                    ['name' => 'IOS Developer'],
                    ['name' => 'Android Developer '],
                    ['name' => 'Flutter Developer '],
                    ['name' => 'React Native Developer '],
                ],
                'positions' => [
                    ['name' => 'Trainee'],
                    ['name' => 'Junior Developer'],
                    ['name' => 'Software Developer'],
                    ['name' => 'Senior Software Developer'],
                    ['name' => 'Team Lead'],
                    ['name' => 'Project Manager'],
                    ['name' => 'Business Analyst'],
                ],
            ],
            [
                'name' => 'Web Development',
                'roles' => [
                    ['name' => 'PHP Developer'],
                    ['name' => 'Node JS Developer'],
                    ['name' => 'Angular Developer'],
                    ['name' => 'React Developer'],
                    ['name' => 'Wordpress Developer'],
                    ['name' => 'Blockchain Developer'],
                    ['name' => 'Full stack Developer'],
                ],
                'positions' => [
                    ['name' => 'Trainee'],
                    ['name' => 'Junior Developer'],
                    ['name' => 'Software Developer'],
                    ['name' => 'Senior Software Developer'],
                    ['name' => 'Team Lead'],
                    ['name' => 'Project Manager'],
                    ['name' => 'Business Analyst'],
                ],
            ],
            [
                'name' => 'Designer',
                'roles' => [
                    ['name' => 'UI/UX Designer'],
                    ['name' => 'Web Designer'],
                ],
                'positions' => [
                    ['name' => 'Trainee']
                ],
            ],
            [
                'name' => 'Business Developer',
                'roles' => [
                    ['name' => 'Sales'],
                ],
                'positions' => [
                    ['name' => 'Trainee'],
                    ['name' => 'Business Manager'],
                    ['name' => 'Business Manager'],
                    ['name' => 'Senior Business Executive'],
                ],
            ],
            [
                'name' => 'Quality Analyst',
                'roles' => [
                    ['name' => 'Manual Tester'],
                    ['name' => 'Automation Tester'],
                ],
                'positions' => [
                    ['name' => 'Trainee'],
                    ['name' => 'QA Manager'],
                    ['name' => 'Junior QA'],
                    ['name' => 'Senior QA'],
                ],
            ],
            [
                'name' => 'Digital Marketing',
                'roles' => [
                    ['name' => 'SEO'],
                    ['name' => 'Social Media Marketing'],
                ],
                'positions' => [
                    ['name' => 'Trainee'],
                    ['name' => 'Marketing Manager'],
                    ['name' => 'Marketing Executive'],
                    ['name' => 'Senior Marketing Executive'],
                ],
            ],
            [
                'name' => 'Market Researcher',
                'roles' => [
                    ['name' => 'Market Researcher']
                ],
                'positions' => [
                    ['name' => 'Trainee']
                ],
            ],
            [
                'name' => 'Content Writer',
                'roles' => [
                    ['name' => 'Content Writer'],
                ],
                'positions' => [
                    ['name' => 'Trainee'],
                    ['name' => 'Junior Content Writer'],
                    ['name' => 'Senior Content Writer'],
                ],
            ],
        ];

        foreach ($departments as $department) {
            $dep = new Department();
            $dep->name = $department['name'];
            if ($dep->save()) {
                if (isset($department['roles']) && !empty($department['roles'])) {
                    foreach ($department['roles'] as $drole) {
                        $role = new Role();
                        $role->guard_name = 'web';
                        $role->name = $drole['name'];
                        $role->department_id = $dep->id;
                        $role->save();
                    }
                }
                if (isset($department['positions']) && !empty($department['positions'])) {
                    foreach ($department['positions'] as $dposition) {
                        $position = DepartmentPosition::where('name', $dposition['name'])->first();
                        if(!$position) {
                            $position = new DepartmentPosition();
                            $position->name = $dposition['name'];
                            $position->department_id = $dep->id;
                            $position->save();
                        }
                        $position->department()->attach($dep->id);

                    }
                }
            }
        }
        Schema::enableForeignKeyConstraints();
    }
}
