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
                            <h3 class="mb-0">Edit Profile</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary">Back</a>
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
                
                           {!! Form::model($user, 
                            ['method' => 'PATCH','enctype' => 'multipart/form-data','route' => ['updateProfile'],'id'=>'addCategory']) !!}
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
                                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control','readonly' => 'true')) !!}
                                
                                </div>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>

                           
                            
                             <div class="form-group avatar-upload blog_image">
                              <label class="label_class">Image</label>
                                <div class="input-group input-group-merge input-group-alternative">
                               
                                    <div class="blog_image">
                                        <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file'  name="image" id="image" accept=".png, .jpg, .jpeg, .gif"/>
                                                <input type="hidden"  name="{{ old("image") }}" value=""/>
                                                <label for="image" id="cat_img"><i class="fas fa-edit"></i></label>
                                            </div>
                                            <div class="avatar-preview">
                                                @if(isset($user->image) && !empty($user->image))
                                               
                                                <div id="image_preview"  style="background-image: url({{URL::asset('uploads/profile/'.$user->image)}});">
                                                </div>
                                                @else
                                                 <div id="image_preview" style="background-image: url({{URL::asset('assets/img/avatar.png')}});">
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                

                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                                </div>
                                <div class="error_img" id="empty_img"></div>
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
    
   
},messages: {
    name: {
      required: "Please provide  name",
      minlength: jQuery.validator.format("At least {0} characters required!")
    }
   
    
},
 submitHandler: function(form) {
    form.submit();
  }

});

 var _URL = window.URL;
    function readURLTwo(input) {
        var file, img;
        if ((file = input.files[0])) {
            img = new Image();
            img.onload = function () {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image_preview').css('background-image', 'url('+e.target.result +')');
                        $('#image_preview').hide();
                        $('#image_preview').fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                    return true;
                
            };
            img.src = _URL.createObjectURL(file);
        }
    }

    $("#image").change(function() {
        if($('input[name="image"]').get(0).files.length!=0){  
            var fileExtension = ['jpeg', 'jpg','png', 'gif', 'bmp'];
            $("#empty_img").html("");

            if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
                $('<small>Only formats are allowed :'+fileExtension.join(', ')+' </small>').appendTo('#empty_img');
                return
            }
        }

        $("#empty_img").html("");
        $("#image-error").html("");
        readURLTwo(this);
    });
    
</script>
@endsection