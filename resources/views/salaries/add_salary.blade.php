@extends('layouts.main')
@section('content')
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-Banks-center">
                        <div class="col">
                            <h3 class="mb-0">Add Salary</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('manageSalaries')}}" class="btn btn-sm btn-primary">Back</a>
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
                        <form action="{{ route('saveSalary', $salary_month_id) }}" method="POST" id="salarySaveForm">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-single-02"></i></span>
                                                </div>
                                                <select name="employee" id="employee" class="form-control">
                                                    <option value="">Select Employee</option>
                                                    @foreach($employees as $id => $name)
                                                    <option value="{{$id}}" {{ (old('employee') == $id) ? 'selected' : '' }}>{{$name}}</option>
                                                    @endforeach
                                                </select>

                                                </div>
                                                @error('employee')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="working_days">Working Days: </label>
                                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-laptop"></i></span>
                                                </div>
                                                <input type="text" name="working_days" id="working_days" class="form-control" value="{{ old('working_days') }}">

                                                </div>
                                                @error('working_days')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="no_of_days_worked">Number of Days Worked: </label>
                                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                                </div>
                                                <input type="text" name="no_of_days_worked" id="no_of_days_worked" class="form-control" value="{{ old('no_of_days_worked') }}">

                                                </div>
                                                @error('no_of_days_worked')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card static-info-card">
                                                <div class="card-body static-block">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label for="">Pending leaves: </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="pending_leaves_label">{{ old('pending_leaves_label') ?? 0}}</label>
                                                            <input type="hidden" name="pending_leaves_label" value="{{ old('pending_leaves_label') }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="">Medical leaves (availed): </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="medical_leaves_availed_label">{{ old('medical_leaves_availed_label') ?? 0 }}</label>
                                                            <input type="hidden" name="medical_leaves_availed_label" value="{{ old('medical_leaves_availed_label') }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="">Mothly CTC: </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="monthly_ctc_label">{{ old('monthly_ctc_label') ?? 0.00 }}</label>
                                                            <input type="hidden" name="monthly_ctc_label" value="{{ old('monthly_ctc_label') }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="">Daily Rate: </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="daily_rate_label">{{ old('daily_rate_label') ?? 0.00 }}</label>
                                                            <input type="hidden" name="daily_rate_label" value="{{ old('daily_rate_label') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                {{-- Standard deductions block --}}
                                <div class="col-12">
                                    <div class="form-group standard_deductions_block">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="standard_deductions">Standard deductions: </label>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <input type="checkbox" name="sd_pf" class="standard_deductions" value="{{ old('sd_pf') }}" checked> PF
                                                    <label class="calc_sds calculated_pf">{{ old('sd_pf') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <input type="checkbox" name="sd_i" class="standard_deductions" value="{{ old('sd_i') }}" checked> Insurance
                                                    <label class="calc_sds calculated_insurance">{{ old('sd_i') }}</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="checkbox" name="sd_pt" class="standard_deductions" value="{{ old('sd_pt') }}" checked> Professional Tax
                                                    <label class="calc_sds calculated_pt">{{ old('sd_pt') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {{-- Deductions block --}}
                                <div class="col-12">
                                    <div class="deductions_block">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="deductions">Deductions: </label>
                                            </div>
                                            <div class="col-6 text-right">
                                                <button type="button" href="#" class="btn btn-primary btn-sm btn-add-deductions">Add More Deductions</button>
                                            </div>
                                        </div>
                                        @if(old('deduction_name') && count(old('deduction_name')) > 0)

                                        @foreach(old('deduction_name') as $index => $d_name)
                                        <div class="card deductions_block_card">
                                            <span class="close_deduction">×</span>
                                            <div class="card-body">
                                                <div class="row add-deduction">
                                                    <div class="col-4">
                                                        <label for="deduction_name">Deduction name:</label>
                                                        <input type="text" class="form-control" name="deduction_name[]" maxLength="80" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" value="{{$d_name}}">

                                                        @error('deduction_name.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                    <div class="col-4">
                                                        <label for="deduction_date">Deduction date:</label>
                                                        <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" name="deduction_date[]" value="{{ old('deduction_date')[$index] }}">

                                                        @error('deduction_date.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                    <div class="col-4">
                                                        <label for="deduction_amount">Deduction amount:</label>
                                                        <input type="text" class="form-control" name="deduction_amount[]" value="{{ old('deduction_amount')[$index] }}">
                                                        @error('deduction_amount.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="deduction_description">Deduction description:</label>
                                                        <textarea class="form-control" name="deduction_description[]" maxLength="250" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">{{ old('deduction_description')[$index] }}</textarea>
                                                        @error('deduction_description.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                        @else
                                        <div class="card deductions_block_card">
                                            <span class="close_deduction">×</span>
                                            <div class="card-body">
                                                <div class="row add-deduction">
                                                    <div class="col-4">
                                                        <label for="deduction_name">Deduction name:</label>
                                                        <input type="text" class="form-control" name="deduction_name[]" maxLength="80" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="deduction_date">Deduction date:</label>
                                                        <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" name="deduction_date[]">
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="deduction_amount">Deduction amount:</label>
                                                        <input type="text" class="form-control" name="deduction_amount[]">
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="deduction_description">Deduction description:</label>
                                                        <textarea class="form-control" name="deduction_description[]" maxLength="250" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Leaves Block --}}
                                <div class="col-12">
                                    <div class="leaves_block">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="leaves">Leaves: </label>
                                            </div>
                                            <div class="col-6 text-right">
                                                <button type="button" href="#" class="btn btn-primary btn-sm btn-add-leaves">Add More Leaves</button>
                                            </div>
                                        </div>
                                        @if(old('leave_type') && count(old('leave_type')) > 0)
                                        @foreach(old('leave_type') as $index => $lv_type)

                                        <div class="card leaves_block_card">
                                            <span class="close_leave">×</span>
                                            <div class="card-body">
                                                <div class="row add-leave">
                                                    <div class="col-4">
                                                        <label for="leave_type">Leave Type:</label>
                                                        <select name="leave_type[]" id="leave_type" class="form-control">
                                                            <option value=""></option>
                                                            @foreach($leave_types as $id => $lv)
                                                            <option value="{{$id}}" {{ ($lv_type == $id) ? 'selected' : '' }}>{{$lv}}</option>
                                                            @endforeach
                                                        </select>

                                                        @error('leave_type.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                    <div class="col-4">
                                                        <label for="leave_date">Leave Duration:</label>
                                                        <select name="cl_leave_type[]" id="cl_leave_type" class="form-control">
                                                            <option value=""></option>
                                                            @foreach($cl_leave_type as $id => $lv)
                                                            <option value="{{$id}}" {{ (old('cl_leave_type')[$index] == $id) ? 'selected' : '' }}>{{$lv}}</option>
                                                            @endforeach
                                                        </select>

                                                        @error('cl_leave_type.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                    <div class="col-4">
                                                        <label for="leave_date">Leave Date:</label>
                                                        <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" name="leave_date[]" value="{{ old('leave_date')[$index] }}">

                                                        @error('leave_date.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>

                                                    <div class="col-12">
                                                        <label for="leave_description">Leave description:</label>
                                                        <textarea class="form-control" name="leave_description[]" maxLength="250" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">{{ old('leave_description')[$index] }}</textarea>
                                                        @error('leave_description.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                        @else
                                        <div class="card leaves_block_card">
                                            <span class="close_leave">×</span>
                                            <div class="card-body">
                                                <div class="row add-leave">
                                                    <div class="col-4">
                                                        <label for="leave_name">Leave Type:</label>
                                                        <select name="leave_type[]" id="leave_type" class="form-control">
                                                            <option value=""></option>
                                                            @foreach($leave_types as $id => $lv)
                                                            <option value="{{$id}}">{{$lv}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="leave_date">Leave Duration:</label>
                                                        <select name="cl_leave_type[]" id="cl_leave_type" class="form-control">
                                                            <option value=""></option>
                                                            @foreach($cl_leave_type as $id => $lv)
                                                            <option value="{{$id}}">{{$lv}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="leave_date">Leave Date:</label>
                                                        <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" name="leave_date[]">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="leave_description">Leave description:</label>
                                                        <textarea class="form-control" name="leave_description[]" maxLength="250" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Incentives Block --}}
                                <div class="col-12">
                                    <div class="incentives_block">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="incentives">Incentives: </label>
                                            </div>
                                            <div class="col-6 text-right">
                                                <button type="button" href="#" class="btn btn-primary btn-sm btn-add-incentives">Add More Incentives</button>
                                            </div>
                                        </div>

                                        @if(old('incentive_date') && count(old('incentive_date')) > 0)
                                        @foreach(old('incentive_date') as $index => $i_date)

                                        <div class="card incentives_block_card">
                                            <span class="close_incentive">×</span>
                                            <div class="card-body">
                                                <div class="row add-incentive">
                                                    <div class="col-6">
                                                        <label for="leave_date">Date:</label>
                                                        <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" name="incentive_date[]" value="{{ $i_date }}">

                                                        @error('incentive_date.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                    <div class="col-6">
                                                        <label for="incentive_date">Incentive amount:</label>
                                                        <input type="text" name="incentive_amount[]" class="form-control" value="{{ old('incentive_amount')[$index] }}">

                                                        @error('incentive_amount.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>

                                                    <div class="col-12">
                                                        <label for="incentive_description">Description:</label>
                                                        <textarea class="form-control" name="incentive_description[]" maxLength="250" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">{{ old('incentive_description')[$index] }}</textarea>

                                                        @error('incentive_description.*')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach
                                        @else
                                        <div class="card incentives_block_card">
                                            <span class="close_incentive">×</span>
                                            <div class="card-body">
                                                <div class="row add-incentive">
                                                    <div class="col-6">
                                                        <label for="leave_date">Date:</label>
                                                        <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" name="incentive_date[]">
                                                    </div>
                                                    <div class="col-6">
                                                        <label for="incentive_date">Incentive amount:</label>
                                                        <input type="text" name="incentive_amount[]" class="form-control">
                                                    </div>

                                                    <div class="col-12">
                                                        <label for="incentive_description">Description:</label>
                                                        <textarea class="form-control" name="incentive_description[]" maxLength="250" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                {{-- <button class="btn btn-primary calculate_salary">Calculate Salary</button> --}}
                                <button type="submit" class="btn btn-primary mt-3 save_salary_btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
</div>
@endsection

@section('script')


<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\AddSalaryRequest', '#salarySaveForm'); !!}

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>

<script>
function getDaysInMonth(month, year) {
    month--; // lets fix the month once, here and be done with it
    var date = new Date(year, month, 1);
    var days = [];
    while (date.getMonth() === month) {

        // Exclude weekends
        var tmpDate = new Date(date);
        var weekDay = tmpDate.getDay(); // week day
        var day = tmpDate.getDate(); // day

        // alert(weekDay + " ----- " + day);
        if (weekDay%6) { // exclude 0=Sunday and 6=Saturday
            days.push(day);
        }

        date.setDate(date.getDate() + 1);
    }

    return days;
}

$(document).ready(function() {
    let month = "{{$month}}";
    let year = "{{$year}}";
    let working_days = getDaysInMonth(month, year);
    let working_days_count = working_days.length;
    $('#working_days').val(working_days_count);
    $('#no_of_days_worked').val(working_days_count);
    let employee = $('#employee').val();
    if(employee != "") {
        $('#employee').trigger('change');
    }
    $('#employee').on('change', function() {
        let emp = $(this).val();
        // alert(emp);
        $.ajax({
            url: `{{ url('salaries/employee_details') }}/${emp}`,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if(res.status == 1) {
                    $('.pending_leaves_label').html(res.data.pending_leaves);
                    $('input[name=pending_leaves_label]').val(res.data.pending_leaves);
                    $('.medical_leaves_availed_label').html(res.data.medical_leaves_availed);
                    $('input[name=medical_leaves_availed_label]').val(res.data.medical_leaves_availed);
                    $('.monthly_ctc_label').html(res.data.monthly_ctc);
                    $('input[name=monthly_ctc_label]').val(res.data.monthly_ctc);
                    let daily_rate = res.data.monthly_ctc / working_days_count;
                    $('.daily_rate_label').html(daily_rate.toFixed(2));
                    $('input[name=daily_rate_label]').val(daily_rate.toFixed(2));

                    $('input[name=sd_pf').val(res.data.standard_deductions.pf);
                    $('.calculated_pf').text(res.data.standard_deductions.pf);

                    $('input[name=sd_i').val(res.data.standard_deductions.hi);
                    $('.calculated_insurance').text(res.data.standard_deductions.hi);

                    $('input[name=sd_pt').val(res.data.standard_deductions.pt);
                    $('.calculated_pt').text(res.data.standard_deductions.pt);

                }
            }
        });
    });
});


$(document).on('input', '#working_days', function() {
    let working_days = $(this).val();
    let ctc = $('.monthly_ctc_label').text();
    let daily_rate = ctc / working_days;
    $('.daily_rate_label').html(daily_rate.toFixed(2));
});


$(document).on('click', '.btn-add-deductions', function() {
    let block = getDeductionBlock();
    $(block).appendTo('.deductions_block');
    // $('.deductions_block_card:first').clone().appendTo('.deductions_block');
});

$(document).on('click', '.close_deduction', function() {
    let length = $('.close_deduction').length;
    if(length == 1) {
        return false;
    }
    let index = $('.close_deduction').index(this);
    $('.deductions_block_card')[index].remove();
});

$(document).on('click', '.btn-add-leaves', function() {
    let block = getLeavesBlock();
    $(block).appendTo('.leaves_block');
    // $('.leaves_block_card:first').clone().appendTo('.leaves_block');
});

$(document).on('click', '.close_leave', function() {
    let length = $('.close_leave').length;
    if(length == 1) {
        return false;
    }
    let index = $('.close_leave').index(this);
    $('.leaves_block_card')[index].remove();
});


$(document).on('click', '.btn-add-incentives', function() {
    let block = getIncentivesBlock();
    $(block).appendTo('.incentives_block');
    // $('.incentives_block_card:first').clone().appendTo('.incentives_block');
});

$(document).on('click', '.close_incentive', function() {
    let length = $('.close_incentive').length;
    if(length == 1) {
        return false;
    }
    let index = $('.close_incentive').index(this);
    $('.incentives_block_card')[index].remove();
});

function getDeductionBlock() {
    return `<div class="card deductions_block_card">
                <span class="close_deduction">×</span>
                <div class="card-body">
                    <div class="row add-deduction">
                        <div class="col-4">
                            <label for="deduction_name">Deduction name:</label>
                            <input type="text" class="form-control" name="deduction_name[]" maxLength="80" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                        </div>
                        <div class="col-4">
                            <label for="deduction_date">Deduction date:</label>
                            <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" name="deduction_date[]">
                        </div>
                        <div class="col-4">
                            <label for="deduction_amount">Deduction amount:</label>
                            <input type="text" class="form-control" name="deduction_amount[]">
                        </div>
                        <div class="col-12">
                            <label for="deduction_description">Deduction description:</label>
                            <textarea class="form-control" name="deduction_description[]" maxLength="250" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                        </div>
                    </div>
                </div>
            </div>`;
}

function getLeavesBlock() {
    return `<div class="card leaves_block_card">
                <span class="close_leave">×</span>
                <div class="card-body">
                    <div class="row add-leave">
                        <div class="col-4">
                            <label for="leave_name">Leave Type:</label>
                            <select name="leave_type[]" id="leave_type" class="form-control">
                                <option value=""></option>
                                @foreach($leave_types as $id => $lv)
                                <option value="{{$id}}">{{$lv}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="leave_date">Leave Duration:</label>
                            <select name="cl_leave_type[]" id="cl_leave_type" class="form-control">
                                <option value=""></option>
                                @foreach($cl_leave_type as $id => $lv)
                                <option value="{{$id}}">{{$lv}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="leave_date">Leave Date:</label>
                            <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" name="leave_date[]">
                        </div>

                        <div class="col-12">
                            <label for="leave_description">Leave description:</label>
                            <textarea class="form-control" name="leave_description[]" maxLength="250" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                        </div>
                    </div>
                </div>
            </div>`;
}

function getIncentivesBlock() {
    return `<div class="card incentives_block_card">
                <span class="close_incentive">×</span>
                <div class="card-body">
                    <div class="row add-incentive">
                        <div class="col-6">
                            <label for="leave_date">Date:</label>
                            <input type="date" class="form-control" max="<?php echo date("Y-m-d"); ?>" name="incentive_date[]">
                        </div>
                        <div class="col-6">
                            <label for="incentive_date">Incentive amount:</label>
                            <input type="text" name="incentive_amount[]" class="form-control">
                        </div>

                        <div class="col-12">
                            <label for="incentive_description">Description:</label>
                            <textarea class="form-control" name="incentive_description[]" maxLength="250" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"></textarea>
                        </div>
                    </div>
                </div>
            </div>`;
}
</script>
@endsection
