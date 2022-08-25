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
                                <h3 class="mb-0">Standard Deduction</h3>
                            </div>
                            @can('standard-deduction-create')
                            <div class="col text-right">
                                <a class="btn btn-sm btn-primary text-white" data-toggle="modal" data-target="#createDeduction">Add Standard Deduction</a>
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body table-responsive">

                        @if(session('success'))
                        <div class="alert alert-{{ Session::get('success') }}" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('message') }}
                        </div>
                        @endif
                        <table class="table table-sm table-striped table-hover no-footer dataTable" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name"> Name</th>
                                    <th scope="col" class="sort" data-sort="name">EPF</th>
                                    <th scope="col" class="sort" data-sort="name">Health Insurance</th>
                                    <th scope="col" class="sort" data-sort="name">Professional Tax</th>
                                    @can('standard-deduction-delete')
                                    <th scope="col">Actions</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php {{$i=0;}} @endphp
                                @foreach ($datas as $key => $data)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $data->user->name ?? ""}}</td>
                                    <td>{{ $data->epf ?? ""}}</td>
                                    <td>{{ $data->health_insurance ?? ""}}</td>
                                    <td>{{ $data->professional_tax ?? ""}}</td>
                                    <td class="d-flex">
                                        @can('standard-deduction-delete')
                                        <a href="{{ route('standard-deduction-delete', $data->id) }}" class="btn btn-danger btn-sm delete-confirm" data-form="deleteForm-{{ $data->id }}"><i class="fas fa-trash"></i></a>
                                        <a href="#">
                                            <form id="deleteForm-{{ $data->id }}" action="{{ route('standard-deduction-delete', $data->id) }}" method="post">
                                                @csrf @method('DELETE')
                                            </form>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
        <div class="modal fade" id="createDeduction" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="createDeductionModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Employee Standard Deduction</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="standardDeductionForm">
                            @csrf
                            <div class="form-group">
                                <label for="employee_id">Employee:</label>
                                <select name="employee_id" class="form-control" id="employee_id">
                                    <option value="none" selected disabled>Select an Employee</option>
                                    @foreach($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('employee_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="epf">EPF:</label>
                                <input type="text" class="form-control" id="epf" name="epf" placeholder="EPF" />
                                @error('epf')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="health_insurance">Health Insurance:</label>
                                <input type="text" class="form-control" id="health_insurance" name="health_insurance" placeholder="Health Insurance" />
                                @error('health_insurance')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="professional_tax">Professional Tax:</label>
                                <input type="text" class="form-control" id="professional_tax" name="professional_tax" placeholder="Professional Tax" />
                                @error('professional_tax')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="text-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" value="submit" class="btn btn-primary">Save</button>
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
<script>
    $('#createDeduction').on('hide.bs.modal', function(e) {
        $(this)
            .find("input,textarea,select")
            .val('')
            .end()
        $('.error').empty();
    });
    $("#standardDeductionForm").validate({
        errorElement: 'strong',
        rules: {
            employee_id: {
                required: true,
                digits: true,
            },
            epf: {
                required: true,
                number: true,
            },
            health_insurance: {
                required: true,
                number: true,
            },
            professional_tax: {
                required: true,
                number: true,
            },
        },
        messages: {
            employee_id: {
                required: "Please select employee name."
            },
            epf: {
                required: "Please enter EPF amount.",
                number: "Only numeric input allowed."
            },
            health_insurance: {
                required: "Please enter health insurance amount.",
                number: "Only numeric input allowed."
            },
            professional_tax: {
                required: "Please enter professional tax amount.",
                number: "Only numeric input allowed."
            },
        },
    });

    $("#standardDeductionForm").submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: "{{ route('standard-deduction-create') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: data,
            success: function(data) {
                $('#createDeduction').modal('hide');
                if(data.data == ''){
                swal.fire('Standard deduction is already added for the selected user. If You want to update then you need to delete the previous deduction.');
              }else{
                Swal.fire({
                    position: 'top-end',
                    width:'400px',
                    icon: 'success',
                    title: 'Standard Deduction Created Successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
                setTimeout(function() {
                    location.reload();
                }, 1400);
            }
            },
            error: function(errors) {
                console.log(errors);

            }
        });
    });

    $('body').on('click', '.delete-confirm', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var message = "Are you sure you want to remove standard deduction of this employee?";
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