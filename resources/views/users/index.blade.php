@extends('layouts.main')
@section('content')
<style>
    label {display: none;}
</style>
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-banks-center">
                        <div class="col">
                            <h3 class="mb-0">Employees</h3>
                        </div>    
                        <div class="col text-right">
                        @can('user-create')
                            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Add Employee</a>
                            @endcan
                            @can('users-export')
                            <a href="{{ route('users-export') }}" class="btn btn-sm btn-primary">Export Employees</a>
                            @endcan
                            @can('users-bank-details-export')
                            <a href="{{ route('users-bankDetails-export') }}" class="btn btn-sm btn-primary">Export Bank Details</a>
                           @endcan
                        </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="row">
                            <div class="col-10">
                                <h4>Search By :</h4>
                            </div>
                            <div class="col-2">
                                <h4>Search:</h4>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-3">
                                {!! Form::select('department', $departments, old('department'), array('class' => 'edepartment form-control' ,'placeholder' => 'Departments')) !!}
                                @error('department')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                {!! Form::select('roles', $roles,[], array('class' => 'erole form-control' ,'placeholder' => 'Roles')) !!}
                                @error('roles')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-3">
                                {!! Form::select('position', $positions, old('position'), array('class' => 'eposition form-control' ,'placeholder' => 'Positions')) !!}
                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-sm btn-primary reset-filter mt-2">Reset</button>
                            </div>
                            <div class="col-2">
                                <input type="text" name="search" class="form-control" id="search_users">
                            </div>
                        </div>


                        @if(session('success'))
                            <div class="alert alert-{{ Session::get('success') }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ Session::get('message') }}
                            </div>
                            <?php session()->forget('success'); ?>
                        @endif


                        <!-- Projects table -->
                        <div id="abc">
                        @if(count($data) > 0)

                        <!-- Projects table -->
                        <div id="users-list">
                            @include('users/searchList')
                        </div>
                         <button class="btn btn-primary btn-sm mt-3 show_all_records" id="show_all_records">Show All</button>
                         @else
                        <tr>
                            <td colspan="6">
                                <div class="no-data-found"><h4>No Data Available</h4></div>
                            </td>
                        </tr>
                        @endif
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
$(document).on('click', '.reset-filter', function(e) {
    e.preventDefault();
    $('.edepartment').val("");
    $('.erole').val("");
    $('.eposition').val("");
    $('#search_users').val("");

    $.ajax({
        url: "{{ url('users/get_positions_and_roles') }}/"+0,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            $('.eposition').html(res.positions)
            $('.erole').html(res.roles)
        }
    });

    fetch_employees();
});
function fetch_employees() {
    let dep = $('.edepartment').val();
    let role = $('.erole').val();
    let position = $('.eposition').val();
    let search_string = $('#search_users').val();
    // $value = $(this).val();
    $.ajax({
        type : 'post',
        url : "{{ route('search-users') }}",
        dataType: 'html',
        data:{
            "_token": "{{ csrf_token() }}",
            'search':search_string,
            'position':position,
            'role':role,
            'department':dep
        },
        success:function(table_html){
            $('#users-list').html('');

            $('#users-list').html(table_html);
            $('#dataTable').dataTable( {
                language: {
                    paginate: {
                      next: '<i class="fas fa-angle-right"></i>',
                      previous: '<i class="fas fa-angle-left"></i>'
                    }

                },
                "pageLength": 20
            });
        }
    });
}

$(document).on('change', '.edepartment', function() {
    let dep = $(this).val();
    $.ajax({
        url: "{{ url('users/get_positions_and_roles') }}/"+dep,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            $('.eposition').html(res.positions)
            $('.erole').html(res.roles)
        }
    });

    fetch_employees();
});

$(".erole").click(function(event){
    var dataTable = $('#dataTable').dataTable();
    var selectedRole= $(".erole option:selected").text();
    dataTable.fnFilter(selectedRole);
});

$(".eposition").click(function(event){
    fetch_employees();
});

$(document).on('keyup', '#search_users',function(){
    fetch_employees();
});

$(document).on('click', '.changeStatus',function(event){
    event.preventDefault();
    var user_id = $(this).attr('user-id');
    var status = $(this).attr('status');
    if(status == 1){
        var message = "Are you sure you want to Activate this user?";
    }else{
        var message = "Are you sure you want to Deactivate this user?";
    }
    swal.fire({
        title: message,
        showCancelButton: true,
        confirmButtonColor: '#3085D6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
    }).then(function(value) {
        if (value.isConfirmed) {
            $('.loader').show();
            $.ajax({
                url: "{{ route('change-user-status') }}",
                type: 'get',
                data: {
                    'user_id': user_id,
                    'status': status,
                },
                success: function(data) {
                    $('.loader').hide()
                    if(status == 1){
                        $(`.status-${user_id}`).removeClass('btn btn-danger');
                        $(`.status-${user_id}`).addClass('btn btn-success');
                        $(`.status-${user_id}`).attr('status', 0);
                        $(`.status-${user_id}`).val('Activated');
                    }else{
                        $(`.status-${user_id}`).removeClass('btn btn-success');
                        $(`.status-${user_id}`).addClass('btn btn-danger');
                        $(`.status-${user_id}`).attr('status', 1);
                        $(`.status-${user_id}`).val('Deactivated');
                    }
                },
            })
        } else {
            // window.location.href = window.location.href;
        }
    });
});

$('body').on('click', '.delete-confirm', function(e) {
    e.preventDefault();
    var url = $(this).attr('href');
    var message = "Are you sure you want to remove this user?";
    swal.fire({
            title: message,
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
    }).then(function(value) {
        console.log(value);
        if (value.isConfirmed) {
            window.location.href = url;
        }
        if (value == true) {
            window.location.href = url;
        }
    });
});
</script>
@include('layouts.common_js')
@endsection
