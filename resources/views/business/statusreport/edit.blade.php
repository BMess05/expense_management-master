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
                            <h3 class="mb-0">Add Report</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('statusreport.index')}}" class="btn btn-sm btn-primary">Back</a>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('flash-message')

                            {!! Form::model($report, ['method' => 'PATCH','route' => ['statusreport.update', $report->id],'id'=>'addCategory']) !!}
                            @csrf
                            

                             <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                                
                                </div>
                                @error('title')
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
                                {!! Form::text('date', null, array('placeholder' => 'Start Date','class' => 'form-control','id'=>'datepicker' ,'autocomplete'=>'off')) !!}
                                
                                </div>
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                             <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                
                                {!! Form::textarea('report', null, array('placeholder' => 'Report','class' => 'form-control' ,'rows' => 4, 'cols' => 4)) !!}
                                
                                </div>
                                @error('title')
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
    title:{
        required:true,
    },
    date:{
        required:true,
    },
    report:{
        required:true,
    },
},messages: {
    title: {
      required: "Please provide  title",
    },
    date: {
      required: "Please select date",
    },
    report: {
       required: "Please provide report description",
    },
},
 submitHandler: function(form) {
    form.submit();
  }

});


    
</script>
@endsection