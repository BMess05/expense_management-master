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
                            <h3 class="mb-0">Salaries</h3>
                        </div>
                        @can('manage-salaries')
                        <div class="col text-right">
                            <a href="{{ route('addSalary', $salary_month_id) }}" class="btn btn-sm btn-primary add-month-btn">Add New Salary</a>
                        </div>
                        @endcan
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <div id="salary-months-listing">
                        @if($salaries->count() > 0)
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
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Employee</th>
                                    <th scope="col" class="sort" data-sort="name"> Working days</th>
                                    <th scope="col" class="sort" data-sort="name">No of days worked</th>
                                    <th scope="col" class="sort" data-sort="name">CTC</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                 @php {{$count=0;}} @endphp
                                @foreach ($salaries as $key => $row)
                                <tr>
                                    <td>{{ ++$count }}</td>
                                    <td>{{ $row->employee->name ?? ""}}</td>
                                    <td>{{ $row->working_days ?? ""}}</td>
                                    <td>{{ $row->no_of_days_worked ?? ""}}</td>
                                    <td>{{ $row->ctc ?? ""}}</td>
                                    <td class="d-flex">
                                    @can('user-delete')
                                    <a href="{{ route('deleteSalary', $row->id) }}" class="btn btn-danger btn-sm delete-confirm" data-form="deleteForm-{{ $row->id }}"><i class="fas fa-trash"></i></a>
                                    @endcan
                                    @can('user-edit')
                                    <a href="#" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {
    $('body').on('click', '.delete-confirm', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var message = "Are you sure you want to remove this employee's salary?";
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
