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
                            <h3 class="mb-0">Edit Bank Account</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('bankaccounts')}}" class="btn btn-sm btn-primary">Back</a>
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
                        <form method="POST" action="{{ route('updateBankAccount',$bank->id) }}" enctype="multipart/form-data" id="addCategory">
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                <input id="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror" name="bank_name" value="{{ old('bank_name')??$bank->bank_name }}"  autocomplete="bank_name" placeholder="Bank Name" autofocus>
                                
                                </div>
                                @error('bank_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                         

                            
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') ?? $bank->company_name}}"  autocomplete="company_name" placeholder="Company Name" autofocus>
                                
                                </div>
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>

                             <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                <input id="account_no" type="text" class="form-control @error('account_no') is-invalid @enderror" name="account_no" value="{{ old('account_no') ?? $bank->account_no }}"  autocomplete="account_no" placeholder="Account Number" autofocus>
                                
                                </div>
                                @error('account_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                </div>
                                <input id="initial_balance" type="text" class="form-control @error('initial_balance') is-invalid @enderror" name="initial_balance" value="{{ old('initial_balance') ?? $bank->initial_balance}}"  autocomplete="account_no" placeholder="Initial Balance" autofocus>
                                
                                </div>
                                @error('initial_balance')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                             
                 
                            <div class="text-right">
                                <button type="submit" id="save_cat" class="btn btn-primary mt-3">Update</button>
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
<script>
$("#addCategory").validate({
    errorElement: 'div',
rules: {
    bank_name:{
        required:true,
        minlength: 4
    },
    company_name:{
        required:true,
        minlength: 4,
    },
    account_no:{
        required:true,
        minlength: 4,
        maxlength: 12,
    },
    initial_balance:{
        required:true,
        number:true,
    },
},messages: {
    bank_name: {
      required: "Please provide bank name",
      minlength: jQuery.validator.format("At least {0} characters required!"),
    },
    company_name: {
       required: "Please provide company name",
       minlength: jQuery.validator.format("At least {0} characters required!"),
    },
    account_no: {
       required: "Please provide account number",
       minlength: jQuery.validator.format("At least {0} characters required!"),
       maxlength: jQuery.validator.format("{0} characters allowed!"),
    },
    initial_balance: {
      required: "Please provide initial balance",
       number: "Only numbers are allowed",
    },
},
 submitHandler: function(form) {
    form.submit();
  }


});


    
</script>
@endsection