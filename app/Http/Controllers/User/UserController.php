<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Mail;
use URL;
use Auth;
use App\Models\SystemSetting;
use App\Models\Department;
use App\Models\DepartmentPosition;
use App\Models\EmployeeLeavesYearly;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Exports\UserBankDetailsExport;
use App\Models\IssuedDocument;
use App\Models\userBankAccount;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
        $this->middleware('permission:system-setting-list', ['only' => ['edit_setting', 'update_setting']]);
        $this->middleware('permission:user-detail', ['only' => ['user-detail']]);
        $this->middleware('permission:user-change-status', ['only' => ['change-user-status']]);
    }
    public function index(Request $request)
    {
        $departments = Department::orderBy('name', 'DESC')->pluck('name', 'id')->all();
        $positions = DepartmentPosition::orderBy('name', 'DESC')->pluck('name', 'id')->all();
        $roles = Role::orderBy('name', 'DESC')->pluck('name', 'id')->all();
        $data = User::orderBy('id', 'DESC')->get();
        return view('users.index', compact('data', 'departments', 'positions', 'roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function search(Request $request)
    {
        $req = $request->all();
        $query = User::query();
        if (isset($req['department']) && ($req['department'] != "") && ($req['department'] != null)) {
            $query->where('department', $req['department']);
        }
        if (isset($req['position']) && ($req['position'] != "") && ($req['position'] != null)) {
            $query->where('position', $req['position']);
        }
        if (isset($req['search']) && (trim($req['search']) != "") && (trim($req['search']) != null)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $data = $query->orderBy('id', 'DESC')->get();
        return view('users.searchList', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5)->render();
    }

    public function roleDropdown(Request $request)
    {
        $roles = Role::where('department_id', $request->department_id)->orderBy('name', 'DESC')->select('id', 'name')->get();
        $positions = DepartmentPosition::where('department_id', $request->department_id)->orderBy('name', 'DESC')->select('id', 'name')->get();
        return response()->json(['roles' => $roles, 'positions' => $positions]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = ['' => 'Select Department'];
        $departments += Department::orderBy('name', 'DESC')->pluck('name', 'id')->all();

        $positions = ['' => 'Select Position'];
        $roles = ['' => 'Select Role'];
        $relations = [
            '' => 'Select Relation',
            'Father' => 'Father',
            'Mother' => 'Mother',
            'Brother' => 'Brother',
            'Sister' => 'Sister',
            'Friend' => 'Friend',
            'Relative' => 'Relative',
        ];
        return view('users.create_employee', compact(['roles', 'departments', 'positions', 'relations']));
    }

    public function validateUserEmail(Request $request)
   {
    $user = User::where('email', $request->official_email)->first('email');
       if($user){
         $return =  false;
        } 
        else{
         $return= true;
        }
        echo json_encode($return);
        exit;
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'official_email' => 'required|email|unique:users,email',
            'roles' => 'nullable',
            'personal_email' => 'required',
            'dob' => 'required',
            'personal_phone' => 'required',
            'alt_phone' => 'nullable',
            'profile_picture' => 'required|mimes:jpg,bmp,png,webp', //
            'gender' => 'required',
            'current_address' => 'required',
            'permanent_address' => 'required',
            'aadhar_no' => 'required',
            'pan_no' => 'required',
            'adhar_card_front' => 'required|mimes:jpg,bmp,png,webp',
            'adhar_card_back' => 'required|mimes:jpg,bmp,png,webp',
            'pan_card' => 'required|mimes:jpg,bmp,png,webp',
            'employee_id' => 'required',
            'total_experience_till_joining' => 'required',
            'date_of_joining' => 'required',
            'ctc' => 'required',
            'department' => 'required',
            'position' => 'nullable',
            'pf_number' => 'nullable',
            'on_probation' => 'required|in:0,1',
            'experience_certificate_picture' => 'sometimes|mimes:jpg,bmp,png,webp',
            'probation_complete_date' => 'required_if:on_probation,0',
            'expected_probation_complete_date' => 'required_if:on_probation,1',
            'allowed_leaves' => 'required_if:on_probation,0',
            'pending_leaves' => 'required_if:on_probation,0',
            'emergency_person_name' => 'required',
            'emergency_phone' => 'required',
            "emergency_person_relation" => 'required',
            'alt_emergency_person_name' => 'sometimes',
            'alt_emergency_phone' => 'sometimes',
            "alt_emergency_person_relation" => 'nullable',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()
                ->withErrors($validator);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $profile_pic = '';
        if (isset($input['profile_picture']) && !is_null($input['profile_picture'])) {
            $folderPath = public_path('uploads/profilepic/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $profile_pic = time() . "-" . $request->profile_picture->getClientOriginalExtension() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move($folderPath, $profile_pic);
        }

        $adhar_front = '';
        if (isset($input['adhar_card_front']) && !is_null($input['adhar_card_front'])) {
            $folderPath = public_path('uploads/adhar/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $adhar_front = time() . "-adharfront-" . "-" . $request->adhar_card_front->getClientOriginalExtension() . '.' . $request->adhar_card_front->extension();
            $request->adhar_card_front->move($folderPath, $adhar_front);
        }

        $adhar_back = '';
        if (isset($input['adhar_card_back']) && !is_null($input['adhar_card_back'])) {
            $folderPath = public_path('uploads/adhar/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $adhar_back = time() . "-adharback-" . "-" . $request->adhar_card_back->getClientOriginalExtension() . '.' . $request->adhar_card_back->extension();
            $request->adhar_card_back->move($folderPath, $adhar_back);
        }

        $pan_card = '';
        if (isset($input['pan_card']) && !is_null($input['pan_card'])) {
            $folderPath = public_path('uploads/pan/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $pan_card = time() . "-pan-" . "-" . $request->pan_card->getClientOriginalExtension() . '.' . $request->pan_card->extension();
            $request->pan_card->move($folderPath, $pan_card);
        }

        $experience_certificate_picture = '';
        if (isset($input['experience_certificate_picture']) && !is_null($input['experience_certificate_picture'])) {
            $folderPath = public_path('uploads/experience/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $experience_certificate_picture = time() . "-pan-" . "-" . $request->experience_certificate_picture->getClientOriginalExtension() . '.' . $request->experience_certificate_picture->extension();
            $request->experience_certificate_picture->move($folderPath, $experience_certificate_picture);
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['official_email'],
            'password' => $input['password'],
            'personal_email' => $input['personal_email'] ?? '',
            'dob' => $input['dob'] ?? '',
            'personal_phone' => $input['personal_phone'] ?? '',
            'personal_phone_alt' => $input['alt_phone'] ?? '',
            'gender' => $input['gender'] ?? '',
            'current_address' => $input['current_address'] ?? '',
            'permanent_address' => $input['permanent_address'] ?? '',
            'aadhar_no' => $input['aadhar_no'] ?? '',
            'pan_no' => $input['pan_no'] ?? '',
            'adhar_card_front' => $adhar_front,
            'adhar_card_back' => $adhar_back,
            'pan_card' => $pan_card,
            'employee_id' => $input['employee_id'] ?? '',
            'total_experience_till_joining' => $input['total_experience_till_joining'] ?? 0,
            'date_of_joining' => $input['date_of_joining'] ? date('Y-m-d H:i:s', strtotime($input['date_of_joining'])) : '',
            'ctc' => $input['ctc'] ?? '',
            'department' => $input['department'] ?? 0,
            'position' => $input['position'] ?? 0,
            'pf_number' => $input['pf_number'] ?? '',
            'on_probation' => $input['on_probation'] ?? '',
            'experience_certificate_picture' => $experience_certificate_picture,
            'probation_complete_date' => $input['probation_complete_date'] ? date('Y-m-d H:i:s', strtotime($input['probation_complete_date'])) : NULL,
            'expected_probation_complete_date' => $input['expected_probation_complete_date'] ? date('Y-m-d H:i:s', strtotime($input['expected_probation_complete_date'])) : NULL,
            'emergency_person_name' => $input['emergency_person_name'] ?? '',
            'emergency_phone' => $input['emergency_phone'] ?? '',
            'emergency_person_relation' => $input['emergency_person_relation'] ?? '',
            'alt_emergency_person_name' => $input['alt_emergency_person_name'] ?? '',
            'alt_emergency_phone' => $input['alt_emergency_phone'] ?? '',
            'alt_emergency_person_relation' => $input['alt_emergency_person_relation'] ?? '',
            'image' => $profile_pic
        ]);
        $user->assignRole($request->input('roles'));
        if ($user) {

            $user_id = User::latest('id')->first();
            $joining_date = strtotime($request->date_of_joining);
            $year = date('Y', $joining_date);
            $leaves = EmployeeLeavesYearly::create([
                'employee_id' => $user_id->id,
                'joining_year' => $year,
                'allowed_leaves' => $input['allowed_leaves'] ?? 0,
                'pending_leaves' => $input['pending_leaves'] ?? 0,
            ]);
        }

        $details = [
            'name' => $user['name'],
            'link' =>  URL::route('login'),
            'email' => $input['official_email'],
            'password' => $request->password,
        ];

        \Mail::to($input['official_email'])->send(new \App\Mail\NewUserEmail($details));
        if ($user) {
        return redirect()->route('users.index')->with(['success' => 'success', 'message' => 'User created successfully']);
        }else{
            return redirect()->route('users.index')->with(['success' => 'danger', 'message' => 'Oops! Something went wrong']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with(['success' => 'success', 'message' => 'User deleted successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $departments = ['' => 'Select Department'];
        $departments += Department::orderBy('name', 'DESC')->pluck('name', 'id')->all();

        $positions = ['' => 'Select Position'];
        $dep = Department::find($user->department ?? 0);
        if (!$dep) {
            $positions += DepartmentPosition::pluck('name', 'id')->all();
        } else {
            $positions += $dep->departmentPositions ? $dep->departmentPositions->pluck('name', 'id')->all() : [];
        }

        $roles = ['' => 'Select Role'];
        $roles += Role::where('department_id', $user->department)->pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        $relations = [
            '' => 'Select Relation',
            'Father' => 'Father',
            'Mother' => 'Mother',
            'Brother' => 'Brother',
            'Sister' => 'Sister',
            'Friend' => 'Friend',
            'Relative' => 'Relative',
        ];
        return view('users.edit_employee', compact('user', 'roles', 'userRole', 'departments', 'positions', 'relations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'official_email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'nullable',
            'personal_email' => 'required',
            'dob' => 'required',
            'personal_phone' => 'required',
            'alt_phone' => 'nullable',
            'profile_picture' => 'nullable|mimes:jpg,bmp,png,webp', //
            'gender' => 'required',
            'current_address' => 'required',
            'permanent_address' => 'required',
            'aadhar_no' => 'required',
            'pan_no' => 'required',
            'adhar_card_front' => 'nullable|mimes:jpg,bmp,png,webp',
            'adhar_card_back' => 'nullable|mimes:jpg,bmp,png,webp',
            'pan_card' => 'nullable|mimes:jpg,bmp,png,webp',
            'employee_id' => 'required',
            'total_experience_till_joining' => 'required',
            'date_of_joining' => 'required',
            'ctc' => 'required',
            'department' => 'required',
            'position' => 'nullable',
            'pf_number' => 'nullable',
            'on_probation' => 'required|in:0,1',
            'experience_certificate_picture' => 'nullable|mimes:jpg,bmp,png,webp',
            'expected_probation_complete_date' => 'required_if:on_probation,1',
            'probation_complete_date' => 'required_if:on_probation,0',
            'allowed_leaves' => 'required_if:on_probation,0',
            'pending_leaves' => 'required_if:on_probation,0',
            'emergency_person_name' => 'required',
            'emergency_phone' => 'required',
            "emergency_person_relation" => 'required',
            'alt_emergency_person_name' => 'sometimes',
            'alt_emergency_phone' => 'sometimes',
            "alt_emergency_person_relation" => 'nullable',
            'password' => 'sometimes|confirmed'
        ]);

        if ($validator->fails()) {
            // dd($validator->messages());
            return redirect()->back()->withInput()
                ->withErrors($validator);
        }
        $input = $request->all();

        $user = User::find($id);
        if (trim($input['password']) != "") {
            $user->password = Hash::make($input['password']);
        }

        if (isset($input['profile_picture']) && !is_null($input['profile_picture'])) {
            $folderPath = public_path('uploads/profilepic/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $profile_pic = time() . "-" . $request->profile_picture->getClientOriginalExtension() . '.' . $request->profile_picture->extension();
            $request->profile_picture->move($folderPath, $profile_pic);
            $user->image = $profile_pic;
        }

        if (isset($input['adhar_card_front']) && !is_null($input['adhar_card_front'])) {
            $folderPath = public_path('uploads/adhar/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $adhar_front = time() . "-adharfront-" . "-" . $request->adhar_card_front->getClientOriginalExtension() . '.' . $request->adhar_card_front->extension();
            $request->adhar_card_front->move($folderPath, $adhar_front);
            $user->adhar_card_front = $adhar_front;
        }

        if (isset($input['adhar_card_back']) && !is_null($input['adhar_card_back'])) {
            $folderPath = public_path('uploads/adhar/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $adhar_back = time() . "-adharback-" . "-" . $request->adhar_card_back->getClientOriginalExtension() . '.' . $request->adhar_card_back->extension();
            $request->adhar_card_back->move($folderPath, $adhar_back);
            $user->adhar_card_back = $adhar_back;
        }

        if (isset($input['pan_card']) && !is_null($input['pan_card'])) {
            $folderPath = public_path('uploads/pan/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $pan_card = time() . "-pan-" . "-" . $request->pan_card->getClientOriginalExtension() . '.' . $request->pan_card->extension();
            $request->pan_card->move($folderPath, $pan_card);
            $user->pan_card = $pan_card;
        }

        if (isset($input['experience_certificate_picture']) && !is_null($input['experience_certificate_picture'])) {
            $folderPath = public_path('uploads/experience/');
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }
            $experience_certificate_picture = time() . "-pan-" . "-" . $request->experience_certificate_picture->getClientOriginalExtension() . '.' . $request->experience_certificate_picture->extension();
            $request->experience_certificate_picture->move($folderPath, $experience_certificate_picture);
            $user->experience_certificate_picture = $experience_certificate_picture;
        }

        $user->name = $input['name'];
        $user->email = $input['official_email'];
        $user->personal_email = $input['personal_email'];
        $user->dob = $input['dob'];
        $user->personal_phone = $input['personal_phone'];
        $user->personal_phone_alt = $input['alt_phone'];
        $user->gender = $input['gender'];
        $user->current_address = $input['current_address'];
        $user->permanent_address = $input['permanent_address'];
        $user->aadhar_no = $input['aadhar_no'];
        $user->pan_no = $input['pan_no'];
        $user->employee_id = $input['employee_id'];
        $user->total_experience_till_joining = $input['total_experience_till_joining'];
        $user->date_of_joining = $input['date_of_joining'];
        $user->ctc = $input['ctc'];
        $user->department = $input['department'];
        $user->position = $input['position'] ?? 0;
        $user->pf_number = $input['pf_number'];
        $user->on_probation = $input['on_probation'];
        $user->expected_probation_complete_date = $input['expected_probation_complete_date'];
        if ($request->on_probation == 1) {
            $user->probation_complete_date = null;
        } else {
            $user->probation_complete_date = $input['probation_complete_date'];
        }
        $user->emergency_person_name = $input['emergency_person_name'];
        $user->emergency_phone = $input['emergency_phone'];
        $user->alt_emergency_person_name = $input['alt_emergency_person_name'];
        $user->alt_emergency_phone = $input['alt_emergency_phone'];
        $user->emergency_person_relation = $input['emergency_person_relation'] ?? '';
        $user->alt_emergency_person_relation = $input['alt_emergency_person_relation'] ?? '';
        $user->save();

        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        $joining_date = strtotime($request->date_of_joining);
        $year = date('Y', $joining_date);
        $leaves = EmployeeLeavesYearly::where('employee_id', $id)->first();
        if (!$leaves) {
            $leaves = new EmployeeLeavesYearly();
            $leaves->employee_id = $id;
        }
        $leaves->joining_year = $year;
        if ($request->on_probation == 1) {
            $leaves->allowed_leaves = 0;
            $leaves->pending_leaves = 0;
        } else {
            $leaves->allowed_leaves = $request->allowed_leaves ?? 0;
            $leaves->pending_leaves = $request->pending_leaves ?? 0;
        }
        $leaves->save();
        return redirect()->route('users.index')->with(['success' => 'success', 'message' => 'User updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')->with(['success' => 'success', 'message' => 'User deleted successfully']);
    }
    public function edit_profile()
    {
        $user = Auth::user();
        return view('users.edit_profile', compact('user'));
    }
    public function change_password()
    {
        $user = Auth::user();
        return view('users.change_password', compact('user'));
    }
    public function edit_setting()
    {
        $system_setting = SystemSetting::where('id', 1)->first();
        $count = SystemSetting::count();
        return view('setting.sys_setting', compact('system_setting', 'count'));
    }
    public function update_setting(Request $request)
    {

        $data = $request->all();
        // echo "<pre>";print_r($data);die;
        if (empty($data['system_maintanance'])) {
            $data['system_maintanance'] = 0;
        }
        $system_setting = SystemSetting::updateOrCreate(
            ['id' => 1],
            ['system_maintanance' => $data['system_maintanance']]
        );
        if ($system_setting->save()) {
            return redirect()->route('editSetting')->with(['status' => 'success', 'message' => 'Setting updated successfully']);
        } else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }
    public function update_password(Request $request)
    {
        $this->validate($request, [
            'current_password' => 'required',
            'new_password' => 'required|min:8|different:current_password|required_with:password_confirmation|same:password_confirmation',

        ]);

        $data = $request->all();
        $user = User::find(auth()->user()->id);
        $result = \Hash::check($data['current_password'], $user->password);
        if (!$result) {
            return redirect()->route('changePassword')->with(['status' => 'danger', 'message' => 'Current password does not match']);
        }
        $user->password = bcrypt($data['new_password']);

        if ($user->save()) {
            return redirect()->route('changePassword')->with(['status' => 'success', 'message' => 'Password updated successfully']);
        } else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }


    public function update_profile(Request $request)
    {
        if (Auth::user()->id == null) {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'User not found']);
        }
        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        $data = $request->all();

        $user = User::find(Auth::user()->id);
        if ($request->hasFile('image')) {

            $extension = $request->file('image')->getClientOriginalExtension();
            if (!in_array($extension, ['png', 'jpg', 'jpeg'])) {
                return redirect()->back()->with(['status' => 'danger', 'message' => 'Only jpg,png Images allowed'])->withInput();
            }

            $file = $request->file('image');
            $name = time() . '-image.' . $file->getClientOriginalExtension();
            $path = public_path('/uploads/profile');
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            $file_r = $file->move($path, $name);
            if (isset($user['image']) && !empty($user['image'])) {
                $usersImage = public_path("uploads/profile/{$user['image']}");
                if (\File::exists($usersImage)) { // unlink or remove previous image from folder
                    unlink($usersImage);
                }
            }
            $user->image = $name;
        }
        $user->name = $data['name'];

        if ($user->save()) {
            return redirect()->route('editProfile')->with(['status' => 'success', 'message' => 'Profile updated successfully']);
        } else {
            return redirect()->back()->with(['status' => 'danger', 'message' => 'Something went wrong.'])->withInput();
        }
    }

    public function get_positions_and_roles($dep_id = 0)
    {
        if (($dep_id == 0) || ($dep_id == "")) {
            $positions = DepartmentPosition::orderBy('name', 'DESC')->select(['name', 'id'])->get()->toArray();
            $roles = Role::orderBy('name', 'DESC')->pluck('name', 'id')->all();
        } else {
            $department = Department::find($dep_id);
            if (!$department) {
                return response()->json([
                    'positions' => '',
                    'roles' => ''
                ]);
            }
            $positions = $department->departmentPositions ? $department->departmentPositions->toArray() : [];

            $roles = Role::where('department_id', $dep_id)->pluck('name', 'name')->all();
        }

        $pos_html = '<option value="">Select Position</option>';
        foreach ($positions as $pos) {
            $pos_html .= '<option value="' . $pos['id'] . '">' . $pos['name'] . '</option>';
        }

        $roles_html = '<option value="">Select Role</option>';
        foreach ($roles as $rid => $rname) {
            $roles_html .= '<option value="' . $rid . '">' . $rname . '</option>';
        }
        return response()->json([
            'positions' => $pos_html,
            'roles' => $roles_html
        ]);
    }

    public function userDetailView(Request $request)
    {
        $data = User::find($request->id);
        $banks = userBankAccount::where('employee_id', $request->id)->get();
        $documents = IssuedDocument::where('employee_id', $request->id)->orderBy('id', 'DESC')->get();
        return view('users.detail_view', compact('data', 'banks','documents'));
    }

    public function changeStatus(Request $r)
    {
        $data = User::where('id', $r->user_id)->first();
        $data->status = $r->status;
        $data->save();
        return response()->json(['data' => $data, 200]);
    }

    public function userExport()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function userBankDetailsExport()
    {
        return Excel::download(new UserBankDetailsExport, 'user-bank-details.xlsx');
    }
}
