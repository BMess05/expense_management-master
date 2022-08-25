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
                            <h3 class="mb-0">Edit Resume</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('resumes')}}" class="btn btn-sm btn-primary">Back</a>
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
                        <form method="POST" action="{{ route('updateResume',$resume->id) }}" enctype="multipart/form-data" id="addCategory" autocomplete="off">
                            @csrf
                            
                           
                           <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-bullet-list-67"></i></span>
                                    </div> 
                                    <select class="form-control @error('category') is-invalid @enderror" name="category" id="category">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category['id'] }}" {{((old('category'))??$resume['category']==$category['id'])? "selected":''}}>{{$category['category_name']}}
                                        </option>
                                        @endforeach 
                                    </select>
                                    
                                    </div>
                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                             <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-tie-bow"></i></span>
                                    </div> 
                                    <select class="form-control @error('experience') is-invalid @enderror" name="experience" id="experience">
                                        <option value="">Select Experience</option>
                                        @foreach($experiences as $experience)
                                        <option value="{{ $experience['id'] }}" {{ $experience['id']== $resume['experience']['id'] ? 'selected' : '' }}>{{$experience['experience']}}
                                        </option>
                                        @endforeach 
                                    </select>
                                    
                                    </div>
                                    @error('experience')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            

                             <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ (old('name'))??$resume->name }}"  placeholder="Candidate Name" autofocus>
                                
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
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                       
                                        <input id="datepicker"  type="text" class="form-control @error('interview_date') is-invalid @enderror" name="interview_date" value="{{ (old('interview_date'))??$resume->interview_date }}" required autocomplete="off" placeholder="Interview Date">
                          
                                        @error('interview_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>

                            <div class="form-group col-md-12 pb-3">
                              <input type="file" class="custom-file-input @error('title') is-invalid @enderror" id="customFileLang" lang="en" name="select_file">
                                <label class="custom-file-label" for="customFileLang">Select file</label>
                                @error('select_file')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                             
                               <span class="text-danger text-muted text-right">.xls, .xslx,.csv</span>
                            </div>




                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                <textarea  id="remarksreason_for_rejection" type="text" class="form-control @error('reason_for_rejection') is-invalid @enderror" name="reason_for_rejection"  placeholder="Reason For Rejection" autofocus>{{ (old('reason_for_rejection'))??$resume->reason_for_rejection }}</textarea>
                                </div>
                                @error('reason_for_rejection')
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
    category:{
        required:true,
    },
    experience:{
        required:true,
    },
    name:{
        required:true,
    },
    interview_date:{
        required:true,
    },
    /*select_file:{
        required:true,
    },*/
    reason_for_rejection:{
        required:true,
        maxlength: 255
    },
},messages: {
    category: {
       required: "Please select category",
    },
    experience: {
       required: "Please select experience",
    },
    interview_date : {
       required: "Please provide interview date",
    },
    name : {
       required: "Please provide candidate name",
    },
   /* select_file : {
       required: "Please select resume to upload",
    },*/
    reason_for_rejection : {
       required: "Please select reason",
    },
},
 submitHandler: function(form) {
    form.submit();
  }

});

    
    
</script>
@endsection