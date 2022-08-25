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
                            <h3 class="mb-0">Edit Role</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('roles.index')}}" class="btn btn-sm btn-primary">Back</a>
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
                
                            {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id],'id'=>'addCategory']) !!}
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/role.svg') }}"></span>
                                </div>
                                {!! Form::text('name', null, array('placeholder' => 'Role Name','class' => 'form-control')) !!}
                                
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
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/role.svg') }}"></span>
                                </div>
                
                                {!! Form::select('department_id', $departments,$roleDept, array('class' => 'form-control')) !!}
                                
                                </div>
                                @error('department_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Permissions</label>
                                <div class="input-group input-group-merge input-group-alternative">
                                
                                   @foreach($permission as $value)
                                    <label class="form-control-label pl-2" >{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                    {{ $value->name }}</label>
                                <br/><br/>
                                @endforeach
                                                    
                                </div>
                                @error('permission')
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
    permission:{
        required:true,
    },
},messages: {
    name: {
      required: "Please provide name",
      minlength: jQuery.validator.format("At least {0} characters required!")
    },
    permission: {
      required: "Please provide permission",
      minlength: jQuery.validator.format("At least {0} characters required!")
    },
},
 submitHandler: function(form) {
    form.submit();
  }

});


    
</script>
@endsection