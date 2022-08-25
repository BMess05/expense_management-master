@extends('layouts.main')
@section('content')
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-Resumes-center">
                        <div class="col">
                            <h3 class="mb-0">Edit Resume Category</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('resumeCategory')}}" class="btn btn-sm btn-primary">Back</a>
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
                        <form method="POST" action="{{ route('updateResumeCategory',$resume->id) }}" enctype="multipart/form-data" id="addCategory" autocomplete="off">
                            @csrf

                             <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-bullet-list-67"></i></span>
                                </div>
                                <input id="category_name" type="text" class="form-control @error('category_name') is-invalid @enderror" name="category_name" value="{{ ($resume->category_name)??old('category_name') }}"  placeholder="Category Name" autofocus>
                                
                                </div>
                                @error('category_name')
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
    category_name:{
        required:true,
    },
},messages: {
    category_name: {
       required: "Please provide category name",
    },
},
 submitHandler: function(form) {
    form.submit();
  }

});

    
    
</script>
@endsection