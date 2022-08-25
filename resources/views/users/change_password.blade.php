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
                            <h3 class="mb-0">Change Password</h3>
                        </div>
                        <div class="col text-right">
                             <a href="{{ url('/') }}" class="btn btn-sm btn-primary">Back</a>
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
                
                           {!! Form::model($user, ['method' => 'PATCH','route' => ['updatePassword', $user->id],'id'=>'addCategory']) !!}
                            @csrf
                          
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/password.svg') }}"></span>
                                </div>
                               {!! Form::password('current_password', array('placeholder' => 'Current Password','class' => 'form-control','id'=>'current_password')) !!}
                                
                                </div>
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/password.svg') }}"></span>
                                </div>
                               {!! Form::password('new_password', array('placeholder' => 'New Password','class' => 'form-control','id'=>'new_password')) !!}
                                
                                </div>
                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/password.svg') }}"></span>
                                </div>
                                {!! Form::password('password_confirmation', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                
                                </div>
                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                             
                 
                            <div class="text-right">
                                <button type="submit" id="save_cat" class="btn btn-primary mt-3">Update Password</button>
                            </div>
                       {!! Form::close() !!}
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
    name:{
        required:true,
        minlength: 2,
    },
    email:{
        required:true,
        email: true,
    },
   
},messages: {
    name: {
      required: "Please provide  name",
      minlength: jQuery.validator.format("At least {0} characters required!")
    },
    email: {
       required: "Please provide email",
       email:"Your email address must be in the format of name@domain.com"
    },
    
},
 submitHandler: function(form) {
    form.submit();
  }

});


    
</script>
@endsection