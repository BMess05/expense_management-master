@extends('layouts.main')
@section('content')
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-banks-center">
                        <div class="col">
                            <h3 class="mb-0">Manage Salaries</h3>
                        </div>
                        @can('manage-salaries')
                        <div class="col text-right">
                            <a href="#" class="btn btn-sm btn-primary add-month-btn">Add Salary Month</a>
                        </div>
                        @endcan
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="success-msg"></div>
                        <div id="salary-months-listing">
                            @if(count($data) > 0)
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

                                @include('salaries/list_salary_months')

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')


        <div class="modal fade" id="addDateModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Add Salary Month</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-1"></div>
                                <div class="col-11">
                                    <div class="err_msg error">

                                    </div>
                                </div>
                                <div class="col-1"></div>
                                <div class="col-4">
                                    <select name="month" id="salary_month" class="form-control">
                                        <option value="">Select Month</option>
                                        @foreach($months as $key => $name)
                                        <option value="{{$key}}" {{ ($key == date('m')) ? 'selected' : '' }}>{{$name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="year" id="salary_year" class="form-control">
                                        @for($year = 2020;$year <= now()->year; $year++)
                                        <option value="{{$year}}" {{ ($year == date('Y')) ? 'selected' : '' }}>{{$year}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-3">
                                    <button type="button" class="btn btn-sm btn-primary add-salary-btn mt-2">Add Salary Month</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {
    $(document).on('click', '.add-month-btn', function(e) {
        e.preventDefault();
        $('#addDateModal').modal({
            backdrop: 'static',
            keyboard: false
        });
    });

    $(document).on('click', '.add-salary-btn', function(e) {
        e.preventDefault();
        let month = $('#salary_month').val();
        if(month == "") {
            $('.err_msg').html("Please select month.");
            setTimeout(function() {
                $('.err_msg').html("");
            }, 3000);
            return false;
        }
        let year = $('#salary_year').val();
        if(year == "") {
            return false;
        }
        $.ajax({
            type : 'post',
            url : "{{ route('saveSalaryMonth') }}",
            dataType: 'html',
            data:{
                "_token": "{{ csrf_token() }}",
                'month':month,
                'year':year,
            },
            success:function(table_html){

                if(table_html == "") {
                    let smonth = document.getElementById("salary_month");
                    let m_name = smonth.options[smonth.selectedIndex].text;
                    let msg = `${m_name} salary already added.`;
                    $('.err_msg').html(msg);
                    setTimeout(function() {
                        $('.err_msg').html("");
                    }, 3000);
                }   else {
                    $('#salary_month').prop('selectedIndex',0);
                    $('#salary_year').prop('selectedIndex',0);
                    $('.err_msg').html('');
                    $('#addDateModal').modal('hide');
                    $('#salary-months-listing').html('');
                    $('#salary-months-listing').html(table_html);
                    $('#dataTable').dataTable( {
                        language: {
                            paginate: {
                                next: '<i class="fas fa-angle-right"></i>',
                                previous: '<i class="fas fa-angle-left"></i>'
                            }
                        },
                        "pageLength": 20
                    });
                    let success_msg = `<div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    Salary month added successfully.
                                </div>`;

                    $('.success-msg').html(success_msg);
                    setTimeout(() => {
                        $('.success-msg').html('');
                    }, 2000);
                }
            }
        });
    });

    $('body').on('click', '.delete-confirm', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var message = "Are you sure you want to remove this salary month?";
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
});

</script>
@include('layouts.common_js')
@endsection
