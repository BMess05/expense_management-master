@extends('layouts.main')
@section('content')
<style>
    a.btn.btn-outline-primary.mr-1.active {
        background: linear-gradient(87deg, #415ea7 0, #419de0 100%) !important;
    }

    .hide-file {
        visibility: hidden;
        position: absolute;
    }
</style>
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb bg-white">
                                <li class="breadcrumb-item"><a href="{{route('users.index')}}">Employees</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$data->name}}</li>
                            </ol>
                        </nav>
                        <div class="col text-right">
                            @can('user-edit')
                            <a href="{{route('users.edit',$data->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                            @endcan
                            @can('user-delete')
                            @if($data->id != auth()->user()->id)
                            <a href="{{ route('users.destroy', $data->id) }}" class="btn btn-danger btn-sm delete-confirm" data-form="deleteForm-{{ $data->id }}"><i class="fas fa-trash"></i></a>
                            <form id="deleteForm-{{ $data->id }}" action="{{ route('users.destroy', $data->id) }}" method="post">
                                @csrf @method('DELETE')
                            </form>
                            @endif
                            @endcan
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav">
                            <li><a class="btn btn-outline-primary  mr-1 active" href="#personal_details" data-toggle="tab">Personal Details</a></li>
                            <li><a class="btn btn-outline-primary mr-1" href="#professional_details" data-toggle="tab">Professional Details</a></li>
                            <li><a class="btn btn-outline-primary mr-1" href="#emergency_details" data-toggle="tab">Emergency Contact Details</a></li>
                            <li><a class="btn btn-outline-primary mr-1" href="#bank_details" data-toggle="tab">Bank Details</a></li>
                            <li><a class="btn btn-outline-primary mr-1" href="#issued-documents" data-toggle="tab">Documents</a></li>
                        </ul><br><br>

                        <div class="tab-content">
                            <div class="tab-pane active" id="personal_details">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Name</strong>
                                        <p>{{$data->name ?? ""}}</p>
                                        <hr>
                                        <strong>Personal Phone</strong>
                                        <p>{{$data->personal_phone ?? ""}}</p>
                                        <hr>
                                        <strong>Gender</strong>
                                        <p>{{$data->gender ?? ""}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Email</strong>
                                        <p>{{$data->personal_email ?? ""}}</p>
                                        <hr>
                                        @if(!empty($data->personal_phone_alt))
                                        <strong>Alternate Phone</strong>
                                        <p>{{$data->personal_phone_alt ?? ""}}</p>
                                        <hr>
                                        @endif
                                        <strong>Date Of Birth</strong>
                                        <p>{{date('d-m-Y', strtotime($data->dob ?? ""))}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-md-1">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="profile">
                                            @if(file_exists( public_path().'/uploads/profilepic/'.$data->image) && !empty($data->image))
                                            <img src="{{ asset('uploads/profilepic/' . $data->image) }}" width="100%" alt="alt text">
                                            @else
                                            <img src="{{ asset('assets/img/avatar.png') }}" width="100%" alt="alt text">
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Aadhar Card Number</strong>
                                        <p>{{$data->aadhar_no ?? ""}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Pan Card Number</strong>
                                        <p>{{$data->pan_no ?? ""}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Current Address</strong>
                                        <p>{{$data->current_address ?? ""}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Permanent Address</strong>
                                        <p>{{$data->permanent_address ?? ""}}</p>
                                        <hr>
                                    </div>
                                </div>
                                <div class="documents">
                                    <h3>Documents</h3><br>
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            @if(file_exists( public_path().'/uploads/adhar/'.$data->adhar_card_front) && !empty($data->adhar_card_front))
                                            <img src="{{ asset('uploads/adhar/' . $data->adhar_card_front) }}" width="100%" height="180px" alt="alt text">
                                            @else
                                            <img src="{{ asset('assets/img/default.jpeg') }}" width="100%" height="180px" alt="alt text">
                                            @endif
                                            <p><i><strong>Aadhar Card Front</i></strong></p>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            @if(file_exists( public_path().'/uploads/adhar/'.$data->adhar_card_back) && !empty($data->adhar_card_back))
                                            <img src="{{ asset('uploads/adhar/' . $data->adhar_card_back) }}" width="100%" height="180px" alt="alt text">
                                            @else
                                            <img src="{{ asset('assets/img/default.jpeg') }}" width="100%" height="180px" alt="alt text">
                                            @endif
                                            <p><i><strong>Aadhar Card Back</i></strong></p>
                                        </div>
                                        <div class="col-md-3 text-center">
                                            @if(file_exists( public_path().'/uploads/pan/'.$data->pan_card) && !empty($data->pan_card))
                                            <img src="{{ asset('uploads/pan/' . $data->pan_card) }}" width="100%" height="180px" alt="alt text">
                                            @else
                                            <img src="{{ asset('assets/img/default.jpeg') }}" width="100%" height="180px" alt="alt text">
                                            @endif
                                            <p><i><strong>Pan Card</i></strong></p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane" id="professional_details">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Employee ID</strong>
                                        <p>{{$data->employee_id ?? ""}}</p>
                                        <hr>
                                        <strong>Department</strong>
                                        <p>{{$data->department_data->name ?? ""}}</p>
                                        <hr>
                                        <strong>On Probation ?</strong>
                                        @if($data->on_probation == 1)
                                        <p>Yes</p>
                                        @else
                                        <p>No</p>
                                        @endif
                                        <hr>
                                        <strong>CTC</strong>
                                        <p>{{$data->ctc ?? ""}}</p>
                                        <hr>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Official Email</strong>
                                        <p>{{$data->email ?? ""}}</p>
                                        <hr>
                                        <strong>Role</strong>
                                        @foreach($data->getRoleNames() as $v)
                                        <p>{{ $v ?? ""}}</p>
                                        @endforeach
                                        <hr>
                                        @if($data->on_probation == 0)
                                        <strong>Probation Complete Date</strong>
                                        <p>{{date('d-m-Y', strtotime($data->probation_complete_date)) ?? ""}}</p>
                                        @else
                                        <strong>Expected Probation Complete Date</strong>
                                        <p>{{date('d-m-Y', strtotime($data->expected_probation_complete_date)) ?? ""}}</p>
                                        @endif
                                        <hr>
                                        @if(!empty($data->pf_number))
                                        <strong>PF Number</strong>
                                        <p>{{$data->pf_number ?? ""}}</p>
                                        <hr>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Date of Joining</strong>
                                        <p>{{date('d-m-Y', strtotime($data->date_of_joining)) ?? ""}}</p>
                                        <hr>
                                        <strong>Position</strong>
                                        <p>{{$data->position_data->name ?? ""}}</p>
                                        <hr>
                                        <strong>Total Experience till Joining</strong>
                                        <p>{{$data->total_experience_till_joining ?? ""}}</p>
                                        <hr>
                                        <strong>Allowed Leaves </strong>
                                        <p>{{$data->employee_leaves_yearly->allowed_leaves ?? ""}}</p>
                                        <hr>
                                    </div>
                                </div>
                                @if($data->experience_certificate_picture)
                                <div class="documents">
                                    <h3>Documents</h3><br>
                                    <div class="row">
                                        <div class="col-md-3 text-center">
                                            @if(file_exists( public_path().'/uploads/experience/'.$data->experience_certificate_picture) && !empty($data->experience_certificate_picture))
                                            <img src="{{ asset('uploads/experience/' . $data->experience_certificate_picture) }}" width="100%" height="180px" alt="alt text">
                                            @else
                                            <img src="{{ asset('assets/img/default.jpeg') }}" width="100%" height="180px" alt="alt text">
                                            @endif
                                            <p><i><strong>Experience Certificate</i></strong></p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="tab-pane" id="emergency_details">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>Name</strong>
                                                <p>{{$data->emergency_person_name ?? ""}}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Phone</strong>
                                                <p>{{$data->emergency_phone ?? ""}}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Relation</strong>
                                                <p>{{$data->emergency_person_relation ?? ""}}</p>
                                            </div>
                                        </div>
                                        @if(!empty($data->alt_emergency_person_name) || !empty($data->alt_emergency_phone) || !empty($data->alt_emergency_person_relation))
                                        <hr>
                                        @endif
                                        <div class="row">
                                            @if(!empty($data->alt_emergency_person_name))
                                            <div class="col-md-4">
                                                <strong>Name</strong>
                                                <p>{{$data->alt_emergency_person_name ?? ""}}</p>
                                            </div>
                                            @endif
                                            @if(!empty($data->alt_emergency_phone))
                                            <div class="col-md-4">
                                                <strong>Phone</strong>
                                                <p>{{$data->alt_emergency_phone ?? ""}}</p>
                                            </div>
                                            @endif
                                            @if(!empty($data->alt_emergency_person_relation))
                                            <div class="col-md-4">
                                                <strong>Relation</strong>
                                                <p>{{$data->alt_emergency_person_relation ?? ""}}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="bank_details">
                                <div class="card-header border-0">
                                    <div class="row align-banks-center">
                                        <div class="col">
                                            <h3 class="mb-0">Bank Details</h3>
                                        </div>
                                        @can('user-bank-ac-create')
                                        <div class="col text-right">
                                            <a class="btn btn-sm btn-primary text-white" data-toggle="modal" data-target="#createBankAc">Add Bank Account</a>
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="bank-accounts-list">
                                        @include('bank-accounts.index')
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="issued-documents">
                                <div class="card-header border-0">
                                    <div class="row align-banks-center">
                                        <div class="col">
                                            <h3 class="mb-0">Documents</h3>
                                        </div>
                                        @can('user-documents-create')
                                        <div class="col text-right">
                                            <a class="btn btn-sm btn-primary text-white" data-toggle="modal" data-target="#createDocuments">Add Document</a>
                                        </div>
                                        @endcan
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="documents-list">
                                        @include('issued-documents.index')
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
    <div class="modal fade" id="createBankAc" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="createDeductionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Bank Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="bankAcForm">
                        <input type="hidden" id="employee_id" name="employee_id" value="{{$data->id}}" />
                        <div class="form-group">
                            <label for="ac_holder">Account Holder Name :</label>
                            <input type="text" class="form-control" id="ac_holder" name="ac_holder" placeholder="Account Holder Name" />
                            @error('ac_holder')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="account_no">Account Number :</label>
                            <input type="text" class="form-control" id="account_no" name="account_no" placeholder="Account Number" />
                            @error('account_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="ifsc_code">IFSC Code :</label>
                            <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" />
                            @error('ifsc_code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="bank_name">Bank Name :</label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" />
                            @error('bank_name')
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
    <div class="modal fade" id="editBankAc" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="createDeductionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Bank Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="bank-edit">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createDocuments" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="createDeductionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Documents</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="issuedDocumentsForm" enctype="multipart/form-data">
                        <input type="hidden" id="doc_employee_id" name="employee_id" value="{{$data->id}}" />
                        <div class="form-group">
                            <label for="doc_name">Document Name :</label>
                            <input type="text" class="form-control" id="doc_name" name="doc_name" placeholder="Document Name" />
                            @error('doc_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="dob">Issued Date :</label>
                            <input type="date" class="form-control" name="issued_date" max="<?php echo date("Y-m-d"); ?>" id="issued_date" value="{{ old('issued_date') }}">
                            @error('dob')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="image-upload">
                                <label for="document">
                                    Upload Document :
                                    <br><br>
                                    <img id="document-preview" src="{{ asset('assets/img/document.png') }}" width="20%" alt="Wrong Format">
                                    <h5 id="document-name"></h5>
                                </label><br>
                                <input type="file" class="hide-file" name="document" id="document">
                                <div class="upload_document h5" style="color:#b74747"></div>
                                @error('document')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
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
    <div class="modal fade" id="editdocument" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="createDeductionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="documents-edit">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('script')
<script>
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

    function fetch_bank_accounts() {
        let employee_id = '{{$data->id}}';
        $.ajax({
            url: "{{ route('fetch-bank-accounts') }}",
            type: "get",
            data: {
                employee_id: employee_id
            },
            success: function(data) {

                console.log(data);
                $('#bank-accounts-list').html('');
                $('#bank-accounts-list').html(data);
            },
            error: function(errors) {
                console.log(errors);

            }
        });

    }
    $('#createBankAc').on('hide.bs.modal', function(e) {
        let employee_id = "{{$data->id}}";
        $(this).find("input,textarea,select")
            .val('')
            .end()
        $('.error').empty();
        $('#employee_id').val(employee_id);
    });
    $("#bankAcForm").validate({
        errorElement: 'strong',
        rules: {
            ac_holder: {
                required: true,
            },
            account_no: {
                required: true,
            },
            ifsc_code: {
                required: true,
            },
            bank_name: {
                required: true,
            },
        },
        messages: {
            ac_holder: {
                required: "Please enter account holder name."
            },
            account_no: {
                required: "Please enter account number.",
            },
            ifsc_code: {
                required: "Please enter IFSC code.",
            },
            bank_name: {
                required: "Please enter bank name.",
            },
        },
    });

    $("#bankAcForm").submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: "{{ route('bank-account-create') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: data,
            success: function(data) {
                $('#createBankAc').modal('hide');
                fetch_bank_accounts();
                Swal.fire({
                    position: 'top-end',
                    width: '400px',
                    icon: 'success',
                    title: 'Bank Account Created Successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error: function(errors) {
                console.log(errors);

            }
        });
    });

    $('body').on('click', '.delete-bank', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var message = "Are you sure you want to remove this bank account?";
        swal.fire({
            title: message,
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then(function(value) {
            console.log(value);
            if (value.isConfirmed) {
                $.ajax({
                    url: "{{ route('bank-ac-delete') }}",
                    type: 'get',
                    data: {
                        'id': id,
                    },
                    success: function(data) {
                        fetch_bank_accounts();
                        Swal.fire({
                            position: 'top-end',
                            width: '400px',
                            icon: 'success',
                            title: 'Bank Account Deleted Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    error: function(errors) {
                        console.log(errors);

                    }
                });
            }
        });
    });

    $('body').on('click', '.edit-bank', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $.ajax({
            url: "{{ route('bank-ac-edit') }}",
            type: 'get',
            data: {
                'id': id,
            },
            success: function(data) {
                $('#bank-edit').html(data);
                $('#editBankAc').modal('show');
            },
            error: function(errors) {
                console.log(errors);

            }
        });
    });

    function fetch_issued_documents() {
        let employee_id = '{{$data->id}}';
        $.ajax({
            url: "{{ route('fetch-documents') }}",
            type: "get",
            data: {
                employee_id: employee_id
            },
            success: function(data) {

                console.log(data);
                $('#documents-list').html('');
                $('#documents-list').html(data);
            },
            error: function(errors) {
                console.log(errors);

            }
        });

    }

    $('#createDocuments').on('hide.bs.modal', function(e) {
        let employee_id = "{{$data->id}}";
        $(this).find("input,textarea,select")
            .val('')
            .end()
        $('.error').empty();
        $('#doc_employee_id').val(employee_id);
    });

    $("#issuedDocumentsForm").validate({
        errorElement: 'strong',
        rules: {
            doc_name: {
                required: true,
            },
            issued_date: {
                required: true,
            },
            document: {
                required: true,
                extension: "jpg|jpeg|png|ico|bmp|webp|docx|doc|pdf|xml|ppt|xls",
            },
        },
        messages: {
            doc_name: {
                required: "Please enter document name."
            },
            issued_date: {
                required: "Please enter issued date.",
            },
            document: {
                required: "Please select document.",
                extension: "Please upload file in these formats only (jpg, jpeg, png, docx, doc, pdf, xml, ppt, xls).",
            },
        },
    });

    $('#document').change(function() {
        $(".upload_document").html("");
        $("#document-error").html("");
        $('#document-preview').attr('src', '');
        $('#document-name').text('');
        let reader = new FileReader();
        reader.readAsDataURL(this.files[0]);
        var type = /[^/]*$/.exec(this.files[0].type)[0];
        var fileName = this.files[0].name;
        reader.onload = (e) => {
            var file = e.target.result;
            if (type == 'png' || type == 'jpeg' || type == 'webp' || type == 'jpg') {
                $('#document-preview').attr('src', e.target.result);
                images_validate();
            } else if (type == 'pdf') {
                $('#document-preview').attr('src', "{{asset('assets/img/pdf.png')}}");
                $('#document-preview').attr('width', '90px');
                $('#document-name').text(fileName);
                images_validate();
            } else {
                var myarray = [];
                myarray.push('msword','ico','bmp','docx','doc','xml','ppt','xls');
                if (myarray.includes(type)) {
                    $('#document-preview').attr('src', "{{asset('assets/img/docs.png')}}");
                    $('#document-preview').attr('width', '70px');
                    $('#document-name').text(fileName);
                    images_validate();
                }else{
                    $('#document-preview').attr('src', e.target.result);
                }
                
            }
        }
    });

    function images_validate() {
        $(".upload_document").html("");
        if ($('#document').val() != "") {
            var file_size_pp = $('#document')[0].files[0].size;
            if (file_size_pp > 5242880) {
                $('#document-error').text('');
                $(".upload_document").html("File size should not be greater than 5 MB.");
                return false;
            }
        }  
    }
    
    $("#issuedDocumentsForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($("#issuedDocumentsForm")[0]);
        $.ajax({
            url: "{{ route('documents-create') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#createDocuments').modal('hide');
                fetch_issued_documents();
                $('#document-preview').attr('src', "{{ asset('assets/img/document.png') }}");
                $('#document-preview').attr('width', "20%");
                $('#document-name').text('');
                Swal.fire({
                    position: 'top-end',
                    width: '400px',
                    icon: 'success',
                    title: 'Document Added Successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error: function(errors) {
                console.log(errors);

            }
        });
    });

    $('body').on('click', '.delete-document', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var message = "Are you sure you want to remove this document?";
        swal.fire({
            title: message,
            showCancelButton: true,
            confirmButtonColor: '#3085D6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
        }).then(function(value) {
            console.log(value);
            if (value.isConfirmed) {
                $.ajax({
                    url: "{{ route('documents-delete') }}",
                    type: 'get',
                    data: {
                        'id': id,
                    },
                    success: function(data) {
                        fetch_issued_documents();
                        Swal.fire({
                            position: 'top-end',
                            width: '400px',
                            icon: 'success',
                            title: 'Document Deleted Successfully',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    },
                    error: function(errors) {
                        console.log(errors);

                    }
                });
            }
        });
    });

    $('body').on('click', '.edit-document', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $.ajax({
            url: "{{ route('documents-edit') }}",
            type: 'get',
            data: {
                'id': id,
            },
            success: function(data) {
                $('#documents-edit').html(data);
                $('#editdocument').modal('show');
            },
            error: function(errors) {
                console.log(errors);

            }
        });
    });
</script>
@endsection