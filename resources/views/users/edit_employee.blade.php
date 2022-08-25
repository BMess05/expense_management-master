@extends('layouts.main')
@section('content')
<style>
    label {
        font-size: 13px;
        font-weight: bold;
    }

    ul#progressbar li {font-size: 18px;}

    .btn-group .btn, .input-group .btn {
    margin-right: 15px;
    padding:9px 35px;
}
.btn-outline-primary:not(:disabled):not(.disabled).active, .show > .btn-outline-primary.dropdown-toggle {
    background: linear-gradient(87deg, #415ea7 0, #419de0 100%) !important;;
}
.hide-file, .hide-gender{
    visibility:hidden;
    position: absolute;
}
</style>
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-Banks-center">
                            <div class="col">
                                <h3 class="mb-0">Edit Employee</h3>
                            </div>
                            <div class="col text-right">
                                <a class="btn btn-sm btn-primary text-white" onclick="Previous()">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('status'))
                        <div class="alert alert-{{ Session::get('status') }}" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('message') }}
                        </div>
                        @endif
                        <!-- MultiStep Form -->
                        <div class="" id="grad1">
                            <div class="row justify-content-center mt-0">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0">
                                    <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-12 mx-0">
                                                <form method="POST" action="{{ route("updateUser", $user->id) }}" id="msform" enctype="multipart/form-data">
                                                    @csrf
                                                    <!-- progressbar -->
                                                    <ul id="progressbar">
                                                        <li class="active" id="personal"><strong>Personal Details</strong></li>
                                                        <li id="prefessional"><strong>Professional Details</strong></li>
                                                        <li id="emergency"><strong>Emergency Contact Details</strong></li>
                                                        <li id="set-password"><strong>Set Password</strong></li>
                                                    </ul>
                                                    <!-- fieldsets -->
                                                    <fieldset class="personal_step">
                                                        <div class="form-card">
                                                            <div class="row">
                                                                <div class="col-11">
                                                                    <div class="row">
                                                                        <div class="col-2">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="image-upload">
                                                                                        <label for="profile_picture">
                                                                                            Profile Picture
                                                                                            <br><br>
                                                                                            @if(file_exists( public_path().'/uploads/profilepic/'.$user->image) && !empty($user->image))
                                                                                            <img id="profile-preview" class="img img-thumbnail" src="{{ url('uploads/profilepic') }}/{{$user->image}}" alt="Profile picture">
                                                                                            @else
                                                                                            <img id="profile-preview" src="{{ asset('assets/img/uploads.jpeg') }}" width="70%" alt="Wrong Format">
                                                                                            @endif
                                                                                        </label>
                                                                                        <input type="file" class="hide-file" name="profile_picture" id="profile_picture" />
                                                                                        <div class="image_size_error_pp h5" style="color:#b74747"></div>
                                                                                        @error('profile_picture')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-10">
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <label for="name">Name</label>
                                                                                    <input type="text" name="name" id="emp_name" value="{{ old('name') ?? $user->name }}">
                                                                                    @error('name')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label for="personal_email">Personal Email Id</label>
                                                                                    <input type="email" name="personal_email" id="personal_email" value="{{ old('personal_email') ?? $user->personal_email }}" />
                                                                                    @error('personal_email')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label for="personal_phone">Personal Phone</label>
                                                                                    <input type="text" name="personal_phone" value="{{ old('personal_phone') ?? $user->personal_phone }}" />
                                                                                    @error('personal_phone')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>


                                                                                <div class="col-6">
                                                                                    <label for="alt_phone">Alternate Phone (Optional)</label>
                                                                                    <input type="text" name="alt_phone" value="{{ old('alt_phone') ?? $user->personal_phone_alt }}">
                                                                                    @error('alt_phone')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-2">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="image-upload">
                                                                                        <label for="pan_card">
                                                                                            Pan Card
                                                                                            <br><br>
                                                                                            @if(file_exists( public_path().'/uploads/pan/'.$user->pan_card) && !empty($user->pan_card))
                                                                                            <img id="pan-preview" class="img img-thumbnail" src="{{ url('uploads/pan') }}/{{$user->pan_card}}" alt="Pan">
                                                                                            @else
                                                                                            <img id="pan-preview" src="{{ asset('assets/img/uploads.jpeg') }}" width="70%" alt="Wrong Format">
                                                                                            @endif
                                                                                        </label>
                                                                                        <input type="file" class="hide-file" name="pan_card" id="pan_card" />
                                                                                        <div class="image_size_error_pc h5" style="color:#b74747"></div>
                                                                                        @error('pan_card')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-10">
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <label for="dob">Date of birth</label>
                                                                                    <input type="date" name="dob" id="dob" value="{{ old('dob') ?? $user->dob }}">
                                                                                    @error('dob')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <div><label for="gender">Gender:</label></div>
                                                                                        <div class="btn-group" data-toggle="buttons">
                                                                                            <label class="btn btn-outline-primary active">
                                                                                                <input type="radio" class="hide-gender" name="gender" id="Male" value="Male" {{ ((old('gender') ?? $user->gender) == 'Male') ? 'checked' : '' }}>Male
                                                                                            </label>
                                                                                            <label class="btn btn-outline-primary">
                                                                                                <input type="radio" class="hide-gender" name="gender" id="Female" value="Female" {{ ((old('gender') ?? $user->gender) == 'Female') ? 'checked' : '' }}>Female
                                                                                            </label>
                                                                                            <label class="btn btn-outline-primary">
                                                                                                <input type="radio" class="hide-gender" name="gender" id="Others" value="Others" {{ ((old('gender') ?? $user->gender) == 'Others') ? 'checked' : '' }}>Others
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <div class="gender-error"></div>
                                                                                            @error('gender')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                            @enderror
                                                                                        </div>
                                                                                </div>
                                                                                <!-- <div class="col-6">
                                                                                    <div class="row">
                                                                                        <div class="col-12">
                                                                                            <label for="gender">Gender:</label><br>
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                            <label for="gender">
                                                                                                <input class="" type="radio" name="gender" value="Male" {{ ((old('gender') ?? $user->gender) == 'Male') ? 'checked' : '' }}> &nbsp; Male
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                            <label for="gender">
                                                                                                <input class="" type="radio" name="gender" value="Female" {{ ((old('gender') ?? $user->gender) == 'Female') ? 'checked' : '' }}> &nbsp; Female
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-4">
                                                                                            <label for="gender">
                                                                                                <input class="" type="radio" name="gender" value="Others" {{ ((old('gender') ?? $user->gender) == 'Others') ? 'checked' : '' }}> &nbsp; Others
                                                                                            </label>
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <div class="gender-error"></div>
                                                                                            @error('gender')
                                                                                            <span class="invalid-feedback" role="alert">
                                                                                                <strong>{{ $message }}</strong>
                                                                                            </span>
                                                                                            @enderror
                                                                                        </div>
                                                                                    </div>
                                                                                </div> -->
                                                                                <div class="col-6">
                                                                                    <label for="current_address">Current Address</label>
                                                                                    <textarea name="current_address" class="form-control ">{{ old('current_address') ?? $user->current_address }}</textarea>
                                                                                    @error('current_address')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label for="permanent_address">Permanent Address</label>
                                                                                    <textarea name="permanent_address" class="form-control ">{{ old('permanent_address') ?? $user->permanent_address }}</textarea>
                                                                                    @error('permanent_address')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="col-2">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="image-upload">
                                                                                        <label for="adhar_card_front">
                                                                                            Adhar Card (Front)
                                                                                            <br><br>
                                                                                            @if(file_exists( public_path().'/uploads/adhar/'.$user->adhar_card_front) && !empty($user->adhar_card_front))
                                                                                            <img id="adhar-front-preview" class="img img-thumbnail" src="{{ url('uploads/adhar') }}/{{$user->adhar_card_front}}" alt="Adhar">
                                                                                            @else
                                                                                            <img id="adhar-front-preview" src="{{ asset('assets/img/uploads.jpeg') }}" width="70%" alt="Wrong Format">
                                                                                            @endif
                                                                                        </label>
                                                                                        <input type="file" class="hide-file" name="adhar_card_front" id="adhar_card_front" />
                                                                                        <div class="image_size_error_acf h5" style="color:#b74747"></div>
                                                                                        @error('adhar_card_front')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12"><br>
                                                                                    <div class="image-upload">
                                                                                        <label for="adhar_card_back">
                                                                                            Adhar Card (Back)
                                                                                            <br><br>
                                                                                            @if(file_exists( public_path().'/uploads/adhar/'.$user->adhar_card_back) && !empty($user->adhar_card_back))
                                                                                            <img id="adhar-back-preview" class="img img-thumbnail" src="{{ url('uploads/adhar') }}/{{$user->adhar_card_back}}" alt="Adhar">
                                                                                            @else
                                                                                            <img id="adhar-back-preview" src="{{ asset('assets/img/uploads.jpeg') }}" width="70%" alt="Wrong Format">
                                                                                            @endif
                                                                                        </label>
                                                                                        <input type="file" class="hide-file" name="adhar_card_back" id="adhar_card_back" />
                                                                                        <div class="image_size_error_acb h5" style="color:#b74747"></div>
                                                                                        @error('adhar_card_back')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-10">
                                                                            <div class="row">
                                                                                <div class="col-6">
                                                                                    <label for="aadhar_no">Aadhar Card Number</label>
                                                                                    <input type="text" name="aadhar_no" value="{{ old('aadhar_no') ?? $user->aadhar_no ?? ''}}" />
                                                                                    @error('aadhar_no')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-6">
                                                                                    <label for="pan_no">Pan Card Number</label>
                                                                                    <input type="text" name="pan_no" value="{{ old('pan_no') ?? $user->pan_no ?? ''}}" autocomplete="false" readonly onfocus="this.removeAttribute('readonly');" />
                                                                                    @error('pan_no')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="button" name="next" class="next action-button" value="Next Step" data-step="personal" />
                                                    </fieldset>

                                                    <fieldset class="professional_step">
                                                        <div class="form-card">
                                                            <div class="row">
                                                                <div class="col-11">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <label for="employee_id">Employee Id </label>
                                                                            <input type="text" name="employee_id" placeholder="Employee ID" value="{{ old('employee_id') ?? $user->employee_id }}">
                                                                            @error('employee_id')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="official_email">Official Email Id</label>
                                                                            <input type="email" name="official_email" placeholder="Official Email Id" id="official_email" value="{{ old('official_email') ?? $user->email }}" />
                                                                            @error('official_email')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="date_of_joining">Date of Joining: </label>
                                                                            <input type="date" name="date_of_joining" id="date_of_joining" value="{{ old('date_of_joining') ?? date('Y-m-d', strtotime($user->date_of_joining)) }}">
                                                                            @error('date_of_joining')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <label for="total_experience_till_joining">Total Experience Till Joining </label>
                                                                            <input type="text" name="total_experience_till_joining" id="total_experience_till_joining" placeholder="Total Experience Till Joining" value="{{ old('total_experience_till_joining') ?? $user->total_experience_till_joining }}">
                                                                            @error('total_experience_till_joining')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="ctc">CTC</label>
                                                                            <input type="text" name="ctc" placeholder="CTC" value="{{ old('ctc') ?? $user->ctc }}">
                                                                            @error('ctc')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="pf_number">PF Number (Optional)</label>
                                                                            <input type="text" name="pf_number" placeholder="PF Number (optional)" value="{{ old('pf_number') ?? $user->pf_number }}">
                                                                            @error('pf_number')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <label for="department">Department </label>
                                                                            {!! Form::select('department', $departments, old('department') ?? $user->department, array('class' => 'edepartment')) !!}
                                                                            @error('department')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="position">Position: </label>
                                                                            {!! Form::select('position', $positions, old('position') ?? $user->position, array('class' => 'eposition')) !!}
                                                                            @error('position')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="roles">Role</label>
                                                                            {!! Form::select('roles', $roles,$userRole, array('class' => 'erole')) !!}
                                                                            @error('roles')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <label for="on_probation">On Probation?</label><br />
                                                                                    <input type="radio" name="on_probation" value="1" class="on_probation" {{ ((old('on_probation') ?? $user->on_probation) == 1) ? 'checked' : '' }}> &nbsp; Yes
                                                                                    &nbsp; &nbsp; &nbsp;
                                                                                    <input type="radio" name="on_probation" value="0" class="on_probation" {{ ((old('on_probation') ?? $user->on_probation) == 0) ? 'checked' : '' }}> &nbsp; No
                                                                                    &nbsp; &nbsp; &nbsp;
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="on-probation-error"></div>
                                                                                    @error('on_probation')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <div class="image-upload">
                                                                                        <label for="experience_certificate_picture">
                                                                                            Experience Certificate Picture
                                                                                            <br><br>
                                                                                            @if(file_exists( public_path().'/uploads/experience/'.$user->experience_certificate_picture) && !empty($user->experience_certificate_picture))
                                                                                            <img id="experience-preview" class="img img-thumbnail" src="{{ url('uploads/experience') }}/{{$user->experience_certificate_picture}}" alt="Experience">
                                                                                            @else
                                                                                            <img id="experience-preview" src="{{ asset('assets/img/uploads.jpeg') }}" width="40%" alt="Wrong Format">
                                                                                            @endif
                                                                                        </label>
                                                                                        <input type="file" class="hide-file" name="experience_certificate_picture" id="experience_certificate_picture" />
                                                                                        <div class="image_size_error_ec h5" style="color:#b74747"></div>
                                                                                        @error('experience_certificate_picture')
                                                                                        <span class="invalid-feedback" role="alert">
                                                                                            <strong>{{ $message }}</strong>
                                                                                        </span>
                                                                                        @enderror
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="if-on-probation {{ ($user->on_probation == 0) ? 'hide' : '' }}">
                                                                                <label for="probation_complete_date">Expected Probation Complete Date: </label>
                                                                                <input type="date" name="expected_probation_complete_date" id="expected_probation_complete_date" value="{{ old('expected_probation_complete_date') ?? $user->expected_probation_complete_date ? date('Y-m-d', strtotime($user->expected_probation_complete_date)) : '' }}">
                                                                                @error('expected_probation_complete_date')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="if-not-on-probation {{ ($user->on_probation == 1) ? 'hide' : '' }}">
                                                                                <label for="probation_complete_date">Probation Complete Date: </label>
                                                                                <input type="date" name="probation_complete_date" id="probation_complete_date" value="{{ old('probation_complete_date') ?? $user->probation_complete_date ? date('Y-m-d', strtotime($user->probation_complete_date)) : '' }}">
                                                                                @error('probation_complete_date')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="if-not-on-probation {{ ($user->on_probation == 1) ? 'hide' : '' }}">
                                                                                <label for="allowed_leaves">Allowed Leaves</label>
                                                                                <input type="text" id="allowed_leaves" name="allowed_leaves" placeholder="Allowed Leaves" value="{{ old('allowed_leaves') ?? $user->employee_leaves_yearly ? $user->employee_leaves_yearly->allowed_leaves : '0' }}">
                                                                                @error('allowed_leaves')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="if-not-on-probation {{ ($user->on_probation == 1) ? 'hide' : '' }}">
                                                                                <label for="pending_leaves">Pending Leaves</label>
                                                                                <input type="text" name="pending_leaves" id="pending_leaves" placeholder="Pending Leaves" value="{{ old('pending_leaves') ?? $user->employee_leaves_yearly ? $user->employee_leaves_yearly->pending_leaves : '0' }}">
                                                                                @error('pending_leaves')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                                        <input type="button" name="next" class="next action-button" value="Next Step" data-step="professional" />
                                                    </fieldset>
                                                    <fieldset class="emergency_step">
                                                        <div class="form-card">
                                                            <div class="row">
                                                                <div class="col-11">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <label for="emergency_person_name">Name Of The Person</label>
                                                                            <input type="text" name="emergency_person_name" placeholder="Name of the Person" value="{{ old('emergency_person_name') ?? $user->emergency_person_name }}" />
                                                                            @error('emergency_person_name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="emergency_phone">Phone Number</label>
                                                                            <input type="text" name="emergency_phone" placeholder="Phone Number" value="{{ old('emergency_phone') ?? $user->emergency_phone }}" />
                                                                            @error('emergency_phone')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="alt_emergency_phone">Select Relation</label>
                                                                            {!! Form::select('emergency_person_relation', $relations, old('emergency_person_relation') ?? $user->emergency_person_relation, array('class' => '')) !!}
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <label for="alt_emergency_person_name">Name Of The Person (Optional)</label>
                                                                            <input type="text" name="alt_emergency_person_name" placeholder="Name of the Person (Optional)" value="{{ old('alt_emergency_person_name') ?? $user->alt_emergency_person_name }}" id="alt_emergency_person_name" />
                                                                            @error('alt_emergency_person_name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="alt_emergency_phone">Phone Number (Optional)</label>
                                                                            <input type="text" name="alt_emergency_phone" placeholder="Phone Number (Optional)" value="{{ old('alt_emergency_phone') ?? $user->alt_emergency_phone }}" />
                                                                            @error('alt_emergency_phone')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <label for="alt_emergency_phone">Select Relation (Optional)</label>
                                                                            {!! Form::select('alt_emergency_person_relation', $relations, old('alt_emergency_person_relation') ?? $user->alt_emergency_person_relation, array('class' => 'eposition')) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                                        <input type="button" name="make_payment" class="next action-button" value="Next" data-step="emergency" />
                                                    </fieldset>
                                                    <fieldset class="set_password_step">
                                                        <div class="form-card">
                                                            <div class="row">
                                                                <div class="col-11">
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="row">
                                                                                <div class="col-12">
                                                                                    <label for="password">Password</label>
                                                                                    <input type="password" name="password" id="password" placeholder="Password" value="" />
                                                                                    @error('password')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <label for="password_confirmation">Confirm Password</label>
                                                                                    <input type="password" name="password_confirmation" placeholder="Confirm Password" />
                                                                                    @error('password_confirmation')
                                                                                    <span class="invalid-feedback" role="alert">
                                                                                        <strong>{{ $message }}</strong>
                                                                                    </span>
                                                                                    @enderror
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                                                        <input type="button" name="make_payment" class="next action-button" value="Confirm" data-step="set_password" />
                                                    </fieldset>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
</div>
@endsection

@section('script')
<script>
    function Previous() {
        window.history.back()
    }

    $(document).on('change', '.edepartment', function() {
        let dep = $(this).val();

        $.ajax({
            url: "{{ url('users/get_positions_and_roles') }}/" + dep,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                $('.eposition').html(res.positions)
                $('.erole').html(res.roles)

            }
        });
    });

    $(document).on('change', '.on_probation', function() {
        if ($(this).val() == 0) {
            var joining_date = new Date($('#date_of_joining').val());
            joining_date.setMonth(joining_date.getMonth() + 3);
            var day = ("0" + joining_date.getDate()).slice(-2);
            var month = ("0" + (joining_date.getMonth() + 1)).slice(-2);
            var expected_date = joining_date.getFullYear() + "-" + (month) + "-" + (day);
            var edate = new Date(expected_date);
            $('#probation_complete_date').val(expected_date);

            var joining_date = new Date($('#date_of_joining').val());
            var newdate = joining_date.getDate();

            if (newdate >= 15) {
                $('#allowed_leaves').val('2');
                $('#pending_leaves').val('2');
            } else {
                $('#allowed_leaves').val('3');
                $('#pending_leaves').val('3');
            }
            $('.if-not-on-probation').removeClass('hide');
        } else {
            $('.if-not-on-probation').addClass('hide');
        }
        if ($(this).val() == 1) {
            var joining_date = new Date($('#date_of_joining').val());
            joining_date.setMonth(joining_date.getMonth() + 3);
            var day = ("0" + joining_date.getDate()).slice(-2);
            var month = ("0" + (joining_date.getMonth() + 1)).slice(-2);
            var expected_date = joining_date.getFullYear() + "-" + (month) + "-" + (day);
            var edate = new Date(expected_date);
            $('#expected_probation_complete_date').val(expected_date);
            $('.if-on-probation').removeClass('hide');
        } else {
            $('.if-on-probation').addClass('hide');
        }
    });



    $("#msform").validate({
        rules: {
            name: "required",
            personal_email: {
                required: true,
                email: true
            },
            dob: {
                required: true
            },
            personal_phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            alt_phone: {
                required: false,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            profile_picture: {
                required: false,
                extension: "jpg|jpeg|png|ico|bmp|webp"
            },
            gender: {
                required: true
            },
            current_address: {
                required: true,
                minlength: 10,
                maxlength: 150
            },
            permanent_address: {
                required: true,
                minlength: 10,
                maxlength: 150
            },
            aadhar_no: {
                required: true,
                digits: true,
                minlength: 12,
                maxlength: 12
            },
            pan_no: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            adhar_card_front: {
                required: false,
                extension: "jpg|jpeg|png|ico|bmp|webp"
            },
            adhar_card_back: {
                required: false,
                extension: "jpg|jpeg|png|ico|bmp|webp"
            },
            pan_card: {
                required: false,
                extension: "jpg|jpeg|png|ico|bmp|webp"
            },
            employee_id: {
                required: true,
                digits: true
            },
            official_email: {
                required: true,
                email: true
            },
            total_experience_till_joining: {
                required: true,
                number: true
            },
            date_of_joining: {
                required: true
            },
            ctc: {
                required: true,
                number: true
            },
            roles: {
                required: true
            },
            department: {
                required: true
            },
            position: {
                required: true
            },
            pf_number: {
                required: false,
                minlength: 10,
                maxlength: 150
            },
            on_probation: {
                required: true
            },
            probation_complete_date: {
                required: function(element) {
                    return '.on_probation[value="0"]:checked'
                }
            },
            experience_certificate_picture: {
                required: false,
                extension: "jpg|jpeg|png|ico|bmp|webp"
            },
            allowed_leaves: {
                required: function(element) {
                    return '.on_probation[value="0"]:checked'
                }
            },
            pending_leaves: {
                required: function(element) {
                    return '.on_probation[value="0"]:checked'
                }
            },
            expected_probation_complete_date: {
                required: function(element) {
                    return '.on_probation[value="1"]:checked'
                }
            },
            emergency_person_name: {
                required: true,
                minlength: 2,
                maxlength: 15
            },
            emergency_phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            emergency_person_relation: {
                required: true
            },
            alt_emergency_person_name: {
                required: false,
                minlength: 2,
                maxlength: 15
            },
            alt_emergency_phone: {
                required: function(element) {
                    return $("#alt_emergency_person_name").val() != "";
                },
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            alt_emergency_person_relation: {
                required: function(element) {
                    return $("#alt_emergency_person_name").val() != "";
                }
            },
            password: {
                required: false,
                minlength: 6
            },
            password_confirmation: {
                equalTo: "#password"
            }
        },
        messages: {
            name: "Please enter employee name",
            personal_email: {
                required: "Please enter personal email",
                email: "Invalid email format."
            },
            dob: {
                required: "Please enter Date of birth."
            },
            personal_phone: {
                required: "Please enter personal phone.",
                digits: "Only numeric input allowed.",
                minlength: 'Please enter a valid 10-digit phone number.',
                maxlength: 'Please enter a valid 10-digit phone number.',
            },
            alt_phone: {
                digits: "Only numeric input allowed.",
                minlength: 'Please enter a valid 10-digit phone number.',
                maxlength: 'Please enter a valid 10-digit phone number.',
            },
            profile_picture: {
                required: "Please upload profile picture.",
                extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp).",
                filesize: " file size must be less than 200 KB.",
            },
            gender: {
                required: "Please select a gender."
            },
            current_address: {
                required: "Plase enter current address.",
                minlength:"Current Address should not be less than 10 characters.",
                maxlength:"Current Address should not be more than 150 characters."
            },
            permanent_address: {
                required: "Please enter permanent address.",
                minlength:"Permanent Address should not be less than 10 characters.",
                maxlength:"Permanent Address should not be more than 150 characters."
            },
            aadhar_no: {
                required: "Please enter aadhar card number.",
                digits: "Only numeric input allowed.",
                minlength: "Aadhar number must have 12 digits",
                maxlength: "Aadhar number should not be greater than 12 digits",
            },
            pan_no: {
                required: "Please enter pan card number.",
                minlength: "Pan number must have 10 characters",
                maxlength: "Pan number should not be greater than 10 characters",
            },
            adhar_card_front: {
                required: "Please upload front side image of Adhar card.",
                extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp)."
            },
            adhar_card_back: {
                required: "Please upload back side image of Adhar card.",
                extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp)."
            },
            pan_card: {
                required: "Please upload PAN card image.",
                extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp)."
            },
            employee_id: {
                required: "Please enter Employee ID.",
                digits: "Only numeric input allowed."
            },
            official_email: {
                required: "Please enter official email.",
                email: "Invalid email format."
            },
            total_experience_till_joining: {
                required: "Please enter total work experience till joining.",
                digits: "Only numeric input allowed."
            },
            date_of_joining: {
                required: "Please enter date of joining."
            },
            ctc: {
                required: "Please enter CTC.",
                digits: "Please add numeric values only."
            },
            roles: {
                required: "Please select a role."
            },
            department: {
                required: "Please select a department."
            },
            position: {
                required: "Please select a position."
            },
            on_probation: {
                required: "Please select if employee is on probation period."
            },
            probation_complete_date: {
                required: "Please select probation complete date."
            },
            expected_probation_complete_date: {
                required: "Please select expected probation complete date."
            },
            experience_certificate_picture: {
                extension: "Please upload file in these format only (jpg, jpeg, png, ico, bmp)."
            },
            allowed_leaves: {
                required: "Please enter allowed leaves."
            },
            pending_leaves: {
                required: "Please enter pending leaves."
            },
            emergency_person_name: {
                required: "Please add person name to contact in case of emergency."
            },
            emergency_phone: {
                required: "Please add phone number to contact in case of emergency.",
                digits: "Only numeric input allowed.",
                minlength: 'Please enter a valid 10-digit phone number.',
                maxlength: 'Please enter a valid 10-digit phone number.',
            },
            alt_emergency_phone: {
                digits: "Only numeric input allowed.",
                minlength: 'Please enter a valid 10-digit phone number.',
                maxlength: 'Please enter a valid 10-digit phone number.',
            },
            emergency_person_relation: {
                required: "Please select relation with the person."
            },
            alt_emergency_person_relation: {
                required: "Please select relation with the person."
            },
            password: {
                required: "Please enter password.",
                minlength: "Password must be atleast of 6 characters."
            },
            password_confirmation: {
                equalTo: "Password and confirm password should be same."
            }
        },

        submitHandler: function(form) {
            return true;
        },

        errorPlacement: function(error, element) {
            if (element.attr("name") == "gender") {
                error.insertAfter(".gender-error");
            } else if (element.attr("name") == "on_probation") {
                error.insertAfter(".on-probation-error");
            } else {
                error.insertAfter(element);
            }
        }
    });

    function validate_step(step = 'personal') {
        if (!images_validate()) {
            return false;
        }
        if (step == 'personal') {
            if (!$('#msform').valid()) {
                return false;
            } else {
                return true;
            }
        } else if (step == 'professional') {
            if (!$('#msform').valid()) {
                return false;
            } else {
                return true;
            }
        } else if (step == 'emergency') {
            if (!$('#msform').valid()) {
                return false;
            } else {
                return true;
            }
        } else if (step == 'set_password') {
            if (!$('#msform').valid()) {
                return false;
            } else {
                $('#msform').submit();
            }
        }
    }

    function images_validate() {
        $(".image_size_error_pp").html("");
        $(".image_size_error_acf").html("");
        $(".image_size_error_acb").html("");
        $(".image_size_error_pc").html("");
        $(".image_size_error_ec").html("");
        if ($('#profile_picture').val() != "") {
            var file_size_pp = $('#profile_picture')[0].files[0].size;
            if (file_size_pp > 5242880) {
                $('#profile_picture-error').text('');
                $(".image_size_error_pp").html("File size should not be greater than 5 MB.");
                return false;
            }
        }

        if ($('#adhar_card_front').val() != "") {
            var file_size_acf = $('#adhar_card_front')[0].files[0].size;
            if (file_size_acf > 5242880) {
                $('#adhar_card_front-error').text('');
                $(".image_size_error_acf").html("File size should not be greater than 5 MB.");
                return false;
            }
        }

        if ($('#adhar_card_back').val() != "") {
            var file_size_acb = $('#adhar_card_back')[0].files[0].size;
            if (file_size_acb > 5242880) {
                $('#adhar_card_back-error').text('');
                $(".image_size_error_acb").html("File size should not be greater than 5 MB.");
                return false;
            }
        }

        if ($('#pan_card').val() != "") {
            var file_size_pc = $('#pan_card')[0].files[0].size;
            if (file_size_pc > 5242880) {
                $('#pan_card-error').text('');
                $(".image_size_error_pc").html("File size should not be greater than 5 MB.");
                return false;
            }
        }

        if ($('#experience_certificate_picture').val() != "") {
            var file_size_ec = $('#experience_certificate_picture')[0].files[0].size;
            if (file_size_ec > 5242880) {
                $('#experience_certificate_picture-error').text('');
                $(".image_size_error_ec").html("File size should not be greater than 5 MB.");
                return false;
            }
        }
        return true;
    }
    $(document).ready(function() {
        $('#profile_picture').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#profile-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
           });

           $('#pan_card').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#pan-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
           });

           $('#adhar_card_front').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#adhar-front-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
           });

           $('#adhar_card_back').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#adhar-back-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
           });

           $('#experience_certificate_picture').change(function(){
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#experience-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
           });

        var current_fs, next_fs, previous_fs; // fieldsets
        var opacity;

        $(".next").click(function() {
            let step = $(this).data('step');

            let valid = validate_step(step);
            if (!valid) {
                return false;
            }
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });

        $(".previous").click(function() {

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //Remove class active
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();

            //hide the current fieldset with style
            current_fs.animate({
                opacity: 0
            }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    previous_fs.css({
                        'opacity': opacity
                    });
                },
                duration: 600
            });
        });

        $('.radio-group .radio').click(function() {
            $(this).parent().find('.radio').removeClass('selected');
            $(this).addClass('selected');
        });

        $(".submit").click(function() {
            return false;
        })

    });
</script>
@endsection