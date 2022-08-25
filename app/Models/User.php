<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Role;
use App\Models\Department;
use App\Models\DepartmentPosition;
use App\Models\EmployeeLeavesYearly;
use App\Models\StandardDeduction;
use App\Models\userBankAccount;
use App\Models\IssuedDocument;

use App\Models\Salary\Salary;
class User extends Authenticatable
{
    use HasFactory, Notifiable,HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'image',
        'personal_email',
        'dob',
        'personal_phone',
        'personal_phone_alt',
        'gender',
        'current_address',
        'permanent_address',
        'adhar_card_front',
        'adhar_card_back',
        'pan_card',
        'employee_id',
        'total_experience_till_joining',
        'date_of_joining',
        'ctc',
        'department',
        'position',
        'pf_number',
        'on_probation',
        'experience_certificate_picture',
        'probation_complete_date',
        'expected_probation_complete_date',
        'emergency_person_name',
        'emergency_phone',
        'alt_emergency_person_name',
        'alt_emergency_phone',
        'emergency_person_relation',
        'alt_emergency_person_relation',
        'aadhar_no',
        'pan_no'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




     public function hasAccess(array $permissions)
    {
       foreach($permissions as $permission){
            if($this->hasPermission($permission)){
                return true;
            }
       }
       return false;
    }

    protected function hasPermission(string $permission)
    {
        $permissions= json_decode($this->permissions,true);
        return $permissions[$permission]??false;
    }

    public function inRole($roleSlug)
    {
        return $this->roles()->where('slug',$roleSlug)->count()==1;
    }

    public function bids() {
        return $this->hasMany('App\Models\Business\Bid', 'user_id', 'id');
    }
    public function department_data() {
        return $this->belongsTo(Department::class, 'department');
    }
    public function position_data() {
        return $this->belongsTo(DepartmentPosition::class, 'position');
    }
    public function role_data() {
        return $this->belongsTo(Role::class, 'department');
    }
    public function employee_leaves_yearly() {
        return $this->hasOne(EmployeeLeavesYearly::class, 'employee_id', 'id');
    }

    public function standard_deductions(){
        return $this->hasMany(StandardDeduction::class,'employee_id');
    }

    public function user_bank_accounts(){
        return $this->hasMany(userBankAccount::class,'employee_id');
    }
    public function issued_documents(){
        return $this->hasMany(IssuedDocument::class,'employee_id');
    }
    public function salary() {
        return $this->hasMany(Salary::class, 'employee_id', 'id');
    }
}
