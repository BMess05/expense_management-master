<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\LeaveType;
use App\Models\ClType;

class LeaveTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $leave_types = [
            'Casual Leave',
            'Paid Leave',
            'Medical Leave',
            'Others'
        ];
        $cl_leaves = [
            'Full-day Leave' => 1,
            'Half-day Leave' => 0.5,
            'Short Leave' => 0.25
        ];
        LeaveType::truncate();
        ClType::truncate();
        foreach($leave_types as $leave) {
            $lv = new LeaveType();
            $lv->name = $leave;
            $lv->save();
        }

        foreach($cl_leaves as $leave => $value) {
            $lv = new ClType();
            $lv->name = $leave;
            $lv->value = $value;
            $lv->save();
        }
    }
}
