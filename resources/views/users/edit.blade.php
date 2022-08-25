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
                            <h3 class="mb-0">Edit User</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('users.index')}}" class="btn btn-sm btn-primary">Back</a>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('flash-message')
                
                           {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id],'id'=>'addCategory']) !!}
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/wpf_name.svg') }}"></span>
                                </div>
                                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                                
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                         

                            
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/email.svg') }}"></span>
                                </div>
                                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                                
                                </div>
                                @error('email')
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
                               {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control','id'=>'password')) !!}
                                
                                </div>
                                @error('password')
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
                                {!! Form::password('confirmpassword', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                                
                                </div>
                                @error('confirmpassword')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                             <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/role.svg') }}"></span>
                                </div>
                
                                {!! Form::select('roles', $roles,$userRole, array('class' => 'form-control')) !!}
                                
                                </div>
                                @error('roles')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                             
                 
                            <div class="text-right">
                                <button type="submit" id="save_cat" class="btn btn-primary mt-3">Update</button>
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