@extends('layouts.main')
@section('content')
<style>
    .blinking {
        animation: blinkingText 1.2s infinite;

    }

    .punch-time {
        font-size: 40px;
    }

    .birthdays,
    .anniversaries {
        color: #415ea9;
    }

    .punch-button {
        height: 95px;
        width: 100px;
        border: none;
        border-radius: 20px;
        margin: 15px 5px;

    }

    #controls {
        display: flex;
    }

    hr {
        margin-bottom: 1rem !important;
        margin-top: 1rem !important;
    }
    .skip_btn{
        border: 0px;
    background: transparent;
    font-size: 12px;
    color: #000000c7;
    }

    @keyframes blinkingText {
        0% {
            color: #f5365c;
        }

        49% {
            color: #f5365c;
        }

        60% {
            color: transparent;
        }

        99% {
            color: transparent;
        }

        100% {
            color: #f5365c;
        }
    }
</style>
<div class="header pb-6 mt-6" id="main_content">
    <div class="container-fluid">
        @if(!Auth::user()->hasRole('Admin'))
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="card card-stats">
                    <div class="card-body">
                        <h3 id="total-hours">Attendance Hours</h3>
                        <div id="timer">
                            @if($data['total_time']['days'] == 00)
                            <span class="punch-time" id="hours">{{$data['total_time']['hours'] ?? 00}}</span><span class="punch-time">:</span>
                            @else
                            <span class="punch-time" id="hours">{{$data['total_time']['days'] ?? 00}}</span><span class="punch-time">:</span>
                            @endif
                            <span class="punch-time" id="mins">{{$data['total_time']['minutes'] ?? 00}}</span><span class="punch-time">:</span>
                            <span class="punch-time" id="seconds">{{$data['total_time']['seconds'] ?? 00}}</span>
                        </div> 
                        <div id="controls">
                            <button class="btn-success punch-button" data-timestarted="0" id="start"><b>Punch In</b></button>
                            <button class="btn-info punch-button hide" data-timestarted="0" id="break"><b>Break</b></button>
                            <button class="btn-success punch-button hide" data-timestarted="0" id="back"><b>Back</b></button>
                            <button class="btn-danger punch-button hide" data-timestarted="1" id="stop" onclick="punchOut(false)"><b>Punch Out</b></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 hide break_col">
                <div class="card card-stats">
                    <div class="card-body">
                        <h3 id="opposite-hours">Break Hours</h3>
                        <div id="opposite-attendance" class="punch-time">
                            {{ totalTime($data['opposite_attendance']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="header-body">
            <!-- Card stats -->
            @can('expense-dashboard')
            <div class="row align-items-center py-4">

                <div class="col-xl-12 col-md-12">
                    <h5>Expense Dashboard</h5>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <a href="{{ route('categories') }}">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title  text-muted mb-0">Categories</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $data['categories'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <i class="ni ni-bullet-list-67 text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <a href="{{ route('beneficiaries') }}">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title  text-muted mb-0">Beneficiaries</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $data['beneficiaries'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <i class="far fa-money-bill-alt text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <a href="{{ route('bankaccounts') }}">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title  text-muted mb-0">Bank Accounts</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $data['bank_accounts'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <i class="ni ni-shop text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>



                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <a href="{{ route('expenses') }}">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title  text-muted mb-0">Current Financial Year Expenses Credit</h5>
                                        <span class="h2 font-weight-bold mb-0">Rs. {{ $data['current_year_expenses_credit'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <img src="{{asset('assets/img/icons/credit.png')}}">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <a href="{{ route('expenses') }}">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title  text-muted mb-0">Current Financial Year Expenses Debit</h5>
                                        <span class="h2 font-weight-bold mb-0">Rs. {{ $data['current_year_expenses_debit'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <img src="{{asset('assets/img/icons/debit.png')}}">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <a href="{{ route('expenses') }}">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title  text-muted mb-0">Current Month Expenses Credit</h5>
                                        <span class="h2 font-weight-bold mb-0">Rs. {{ $data['current_month_expenses_credit'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <img src="{{asset('assets/img/icons/credit.png')}}">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <a href="{{ route('expenses') }}">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title  text-muted mb-0">Current Month Expenses Debit</h5>
                                        <span class="h2 font-weight-bold mb-0">Rs. {{ $data['current_month_expenses_debit'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <img src="{{asset('assets/img/icons/debit.png')}}">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            @endcan
            @can('resumes-dashboard')
            <div class="row align-items-center py-4">
                <div class="col-xl-12 col-md-12">
                    <h5>Resumes Dashboard</h5>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <a href="{{ route('resumeCategory') }}">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title  text-muted mb-0">Resume Category</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $data['resume_category'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <img width="24" height="38" src="{{ asset('assets/img/icons/resumecategory.svg') }}">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <a href="{{ route('resumes') }}">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title  text-muted mb-0">Resume</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $data['resumes'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <img width="24" height="38" src="{{ asset('assets/img/icons/resume.svg') }}">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endcan
            @can('business-dashboard')
            <div class="row align-items-center py-4">
                <div class="col-xl-12 col-md-12">
                    <h5>Business Dashboard</h5>
                </div>

                <div class="col-xl-6 col-md-6">

                    <h3>Team Target : ${{ number_format($data['team_targets'], 2) }}</h3>
                    <div class="row">
                        <div class="col-xl-6 col-md-6">

                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <a href="{{ route('bidprofile.index') }}">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title  text-muted mb-0">Bids Profile</h5>
                                                <span class="h2 font-weight-bold mb-0">{{ $data['bid_profile'] }}</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                                    <img width="24" height="38" src="{{ asset('assets/img/icons/bidsprofile.svg') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="card card-stats">
                                <!-- Card body -->
                                <div class="card-body">
                                    <a href="{{ route('bids.index') }}">
                                        <div class="row">
                                            <div class="col">
                                                <h5 class="card-title  text-muted mb-0">Bids</h5>
                                                <span class="h2 font-weight-bold mb-0">{{ $data['bids'] }}</span>
                                            </div>
                                            <div class="col-auto">
                                                <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                                    <img width="24" height="38" src="{{ asset('assets/img/icons/bids.svg') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    @php if($data['all_targets'] < $data['team_targets']) $class="blinking" ; else $class="text-success" ; @endphp <h3>Target Achieved : <span class="{{$class}}">${{ number_format($data['all_targets'], 2) }}</span></h3>
                        <div class="row">
                            <div class="col-xl-6 col-md-6">
                                <div class="card card-stats">
                                    <!-- Card body -->
                                    <div class="card-body">
                                        <a href="{{ route('targets.index') }}">
                                            <div class="row">
                                                <div class="col">
                                                    <h5 class="card-title  text-muted mb-0">My Targets Achieved</h5>

                                                    <span class="h2 font-weight-bold mb-0">${{ number_format($data['my_targets'], 2) }}</span>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                                        <img width="24" height="38" src="{{ asset('assets/img/icons/target.svg') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                </div>
            </div>
            @endcan
            @can('hardware-dashboard')
            <div class="row align-items-center py-4">
                <div class="col-xl-12 col-md-12">
                    <h5>Hardware Dashboard</h5>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card card-stats">
                        <!-- Card body -->
                        <div class="card-body">
                            <a href="{{ route('hardware.index') }}">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title  text-muted mb-0">Hardware</h5>
                                        <span class="h2 font-weight-bold mb-0">{{ $data['hardware'] }}</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow">
                                            <img width="24" height="38" src="{{ asset('assets/img/icons/hardware.svg') }}">
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            @endcan
            <div class="row">
                <div class="col-md-5 col-sm-12">
                    <h5>Upcoming Birthdays</h5>
                    <div class="card card-stats">
                        <div class="card-body">
                            @if(count($data['user_birthdays']) > 0)
                            @foreach($data['user_birthdays'] as $user)
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0 birthdays">{{ $user->name}}</h5>
                                    <h5 class="card-title  text-muted mb-0">{{ $user->department_data->name ?? ''}}</h5>
                                    <h5 class="card-title  text-muted mb-0">{{ $user->position_data->name ?? ''}}</h5>
                                </div>
                                <div class="col-4 d-flex">
                                    <h5 class="card-title text-muted mb-0">{{ date('d-m-Y',strtotime($user->dob))}}</h5>
                                    @can('user-detail')
                                    <div>
                                        <a href="{{route('user-detail',$user->id)}}" class="btn btn-primary btn-sm ml-3"><i class="fas fa-eye"></i></a>
                                    </div>
                                    @endcan
                                </div>
                            </div>
                            <hr>
                            @endforeach
                            @else
                            <tr>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="mb-0 birthdays text-center">No Data Available</h5>
                                    </div>
                                </div>
                            </tr>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-5 col-sm-12">
                    <h5>Upcoming Work Anniverseries</h5>
                    <div class="card card-stats">
                        <div class="card-body">
                            @if(count($data['user_work_anniversaries']) > 0)
                            @foreach($data['user_work_anniversaries'] as $user)
                            <div class="row">
                                <div class="col-8">
                                    <h5 class="mb-0 anniversaries">{{ $user->name}}</h5>
                                    @if(!empty($user->department_data->name) || !empty($user->position_data->name))
                                    <h5 class="card-title  text-muted mb-0">{{ $user->department_data->name ?? ''}}</h5>
                                    <h5 class="card-title  text-muted mb-0">{{ $user->position_data->name ?? ''}}</h5>
                                    @endif
                                </div>
                                <div class="col-4 d-flex">
                                    <h5 class="card-title text-muted mb-0">{{ date('d-m-Y',strtotime($user->date_of_joining))}}</h5>
                                    @can('user-detail')
                                    <div>
                                        <a href="{{route('user-detail',$user->id)}}" class="btn btn-primary btn-sm ml-3"><i class="fas fa-eye"></i></a>
                                    </div>
                                    @endcan
                                </div>
                            </div>
                            <hr>
                            @endforeach
                            @else
                            <tr>
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="mb-0 birthdays text-center">No Data Available</h5>
                                    </div>
                                </div>
                            </tr>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content -->
<div class="modal fade" id="punch_popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body pb-0">
        <h4 style="font-size:16px;">Whoops! Looks like you denied access</h4>
        <p style="font-size:14px;">Allow access to your location by adjusting your location settings in the URL bar.</p>
        <img src="{{ asset('assets/img/crome.png') }}" style="border:1px solid #00000026" width="100%" alt="image"/>
      </div>
      <div class="modal-footer pt-0 justify-content-center">
        <button type="button" class="skip_btn" onclick="$(location.reload());" data-dismiss="modal">Okay</button>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid ">
    <!-- Footer -->
    @include('layouts.footer')
</div>
@endsection
@section('script')
<script>
    let oppo_hours = 00;
    let oppo_mins = 00;
    let oppo_secs = 00;

    $(document).ready(function() {
        $.ajax({
            url: "{{ route('employee-punch-out') }}",
            type: 'get',
            data: {
                refresh: true,
            },
            success: function(data) {
                refreshTimer(data.type);
            },
            error: function(errors) {
                console.log(errors);
            }
        });
    });

    function refreshTimer(type) {
        var opposite_time = "{{$data['opposite_attendance']}}";
        if (opposite_time > 0) {
            $(".break_col").removeClass('hide');
        }
        if (type == "Break") {
            event.preventDefault();
            $('#total-hours').text('Break Hours');
            $('#opposite-hours').text('Attendance Hours');
            getTime("Break",true);
            startTimer();
            $("#break").addClass('hide');
            $("#start").addClass('hide');
            $("#back").removeClass('hide');
            $("#stop").removeClass('hide');
        } else if (type == "Attendance") {
            event.preventDefault();
            $('#total-hours').text('Attendance Hours');
            $('#opposite-hours').text('Break Hours');
            getTime("Attendance",true);
            startTimer();
            $("#start").addClass('hide');
            $("#back").addClass('hide');
            $("#break").removeClass('hide');
            $("#stop").removeClass('hide');
        } else {
            '';
        }
    }

    $(document).on("click", '#start',async function(event) {
        event.preventDefault();
        $('#total-hours').text('Attendance Hours');
        $('#opposite-hours').text('Break Hours');
        await getTime("Attendance",false);
        await getLocation1('Attendance');
        $("#start").addClass('hide');
        $("#back").addClass('hide');
        $("#break").removeClass('hide');
        $("#stop").removeClass('hide');
    });

    $(document).on("click", '#break',async function(event) {
        event.preventDefault();
        oppo_hours = $('#hours').text();
          oppo_mins = $('#mins').text();
          oppo_secs = $('#seconds').text();
          $('#opposite-attendance').text(oppo_hours+':'+oppo_mins+':'+oppo_secs);
        $('#total-hours').text('Break Hours');
        $('#opposite-hours').text('Attendance Hours');
        punchOut(true);
        await getTime("Break",false);
        await getLocation1('Break');
        $("#break").addClass('hide');
        $("#start").addClass('hide');
        $("#back").removeClass('hide');
        $("#stop").removeClass('hide');
    });

    $(document).on("click", '#back',async function(event) {
        event.preventDefault();
        oppo_hours = $('#hours').text();
          oppo_mins = $('#mins').text();
          oppo_secs = $('#seconds').text();
          $('#opposite-attendance').text(oppo_hours+':'+oppo_mins+':'+oppo_secs);
        $('#total-hours').text('Attendance Hours');
        $('#opposite-hours').text('Break Hours');
        punchOut(true);
        await getTime("Attendance",false);
        await getLocation1('Attendance');
        $("#start").addClass('hide');
        $("#back").addClass('hide');
        $("#break").removeClass('hide');
        $("#stop").removeClass('hide');
    });

    function punchOut(refresh) {
        event.preventDefault();
        var refresh = refresh;
        clearTimeout(timex);
        $("#stop").addClass('hide');
        $("#back").addClass('hide');
        $("#break").addClass('hide');
        $("#start").removeClass('hide');
        $.ajax({
            url: "{{ route('employee-punch-out') }}",
            type: 'get',
            data: {
                refresh: refresh,
            },
            success: function(data) {},
            error: function(errors) {
                console.log(errors);
            }
        });

    }

    function getTime(type,getTime) {
        var type = type;
        var getTime = getTime;
        $.ajax({
            url: "{{ route('get-total-time') }}",
            type: 'get',
            data: {
                'type': type,
            },
            success: function(data) {
                days = data.days;
                hours = data.hours;
                mins = data.minutes;
                seconds = data.seconds;
                opposite_attendance = data.opposite_attendance;
                if (data.days < 23) {
                    $('#hours').text(data.hours);
                } else {
                    $('#hours').text(data.days);
                }
                $('#seconds').text(data.seconds);
                $('#mins').text(data.minutes);
                if (opposite_attendance > 0) {
                    $('.break_col').removeClass('hide');
                }
                if(getTime === true){
                $('#opposite-attendance').text(secondsToDhms(opposite_attendance));
                }
            },
            error: function(errors) {
                console.log(errors);

            }
        });
    }

    function secondsToDhms(seconds) {
        var day = Math.floor(seconds / (3600 * 24));
        var hour = Math.floor(seconds % (3600 * 24) / 3600);
        var min = Math.floor(seconds % 3600 / 60);
        var sec = Math.floor(seconds % 60);
        if (day > 0) {
            var dayHour = day * 24;
        } else {
            var dayHour = hour;
        }
        return dayHour.toString().padStart(2, '0') + ':' + ('0' + min).slice(-2) + ':' + ('0' + sec).slice(-2);
    }

    function startTimer() {
        timex = setTimeout(function() {
            seconds++;
            if (seconds > 59) {
                seconds = 0;
                mins++;
                if (mins > 59) {
                    mins = 0;
                    hours++;
                    if (hours < 10) {
                        $("#hours").text('0' + hours)
                    } else $("#hours").text(hours);
                }
                if (mins < 10) {
                    $("#mins").text('0' + mins);
                } else $("#mins").text(mins);
            }
            if (seconds < 10) {
                $("#seconds").text('0' + seconds);
            } else {
                $("#seconds").text(seconds);
            }
            startTimer();
        }, 1000);
    }

    function getLocation1(type) {
        var type = type;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                    var latitude = position.coords.latitude;
                    var longitude = position.coords.longitude;
                    $.ajax({
                        url: "{{ route('employee-punch-in') }}",
                        type: 'get',
                        data: {
                            'type': type,
                            'latitude': latitude,
                            'longitude': longitude,
                        },
                        success: function(data) {
                            startTimer();
                        },
                        error: function(errors) {
                            console.log(errors);

                        }
                    });
                },
                function(error) {
                    if (error.code == error.PERMISSION_DENIED)
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var latitude = position.coords.latitude;
                            var longitude = position.coords.longitude;
                        })
                        $("#punch_popup").modal('show');
                });
        } else {}
    }
</script>
@endsection