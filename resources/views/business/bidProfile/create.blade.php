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
                            <h3 class="mb-0">Add Bid Profile</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('bidprofile.index')}}" class="btn btn-sm btn-primary">Back</a>
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
                
                            {!! Form::open(array('route' => 'bidprofile.store','method'=>'POST','id'=>'addCategory')) !!}
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/wpf_name.svg') }}"></span>
                                    </div>
                                    {!! Form::text('name', null, array('placeholder' => 'Profile Name','class' => 'form-control')) !!}
                                
                                </div>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/il_url.svg') }}"></span>
                                    </div>
                                     {!! Form::text('url', null, array('placeholder' => 'Profile Url','class' => 'form-control')) !!}
                            
                                </div>
                                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
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
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/wpf_username.svg') }}"></span>
                                    </div>
                                     {!! Form::text('username', null, array('placeholder' => 'Username','class' => 'form-control')) !!}
                                
                                </div>
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/password.svg') }}"></span>
                                    </div>
                                     {!! Form::text('password', null, array('placeholder' => 'Password','class' => 'form-control')) !!}
                                
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/question.svg') }}"></span>
                                    </div>
                                     {!! Form::text('security_question', null, array('placeholder' => 'Security Question','class' => 'form-control')) !!}
                                
                                </div>
                                @error('security_question')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/answer.svg') }}"></span>
                                    </div>
                                     {!! Form::text('security_answer', null, array('placeholder' => 'Security Answer','class' => 'form-control')) !!}
                                
                                </div>
                                @error('security_answer')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                 
                            <div class="text-right">
                                <button type="submit" id="save_cat" class="btn btn-primary mt-3">Save</button>
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
    jQuery.validator.addMethod("validate_email", function(value, element) {
    if (value.length > 1) {
        value = $.trim(value);
        if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
            return true;
        } else {
            return false;
        }
    }
    else {
        return true;
    }
}, "Please enter a valid Email.");
$("#addCategory").validate({
    errorElement: 'div',
rules: {
    name:{
        required:true,
    },
    url:{
        required:true,
    },
    email:{
        // required: {
        //     depends:function(){
        //         $(this).val($.trim($(this).val()));
        //         return true;
        //     }
        // },
        // email: true,
        validate_email:true,
    },
},messages: {
    name: {
      required: "Please enter your profile name",
    },
    url: {
       required: "Please enter your profile url",
    },
    email: {
       email:"Your email address must be in the format of name@domain.com"
    },
},
 submitHandler: function(form) {
    form.submit();
  }

});


    
</script>
@endsection