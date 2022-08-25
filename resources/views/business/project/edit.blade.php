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
                            <h3 class="mb-0">Add Project</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('projects.index')}}" class="btn btn-sm btn-primary">Back</a>
                        </div>
                        </div>
                    </div>
                    <div class="card-body">
                       @include('flash-message')
                
                            {!! Form::model($project, ['method' => 'PATCH','route' => ['projects.update', $project->id],'id'=>'addCategory']) !!}
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                {!! Form::text('client_name', null, array('placeholder' => 'Client Name','class' => 'form-control')) !!}
                                
                                </div>
                                @error('client_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                             <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                {!! Form::text('project_name', null, array('placeholder' => 'Project Name','class' => 'form-control')) !!}
                                
                                </div>
                                @error('project_name')
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
                
                                {!! Form::select('contract_type',$contact_types,$usercontract, array('class' => 'form-control','placeholder' => 'Contract type')) !!}
                                
                                </div>
                                @error('contract_type')
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
                
                                {!! Form::select('project_type',$project_types,$userproject, array('class' => 'form-control','placeholder' => 'Project type')) !!}
                                
                                </div>
                                @error('project_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                             <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                {!! Form::text('start_date', null, array('placeholder' => 'Start Date','class' => 'form-control','id'=>'datepicker','autocomplete'=>'off')) !!}
                                
                                </div>
                                @error('start_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                             <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                {!! Form::text('end_date', null, array('placeholder' => 'End Date','class' => 'form-control','id'=>'datepicker2' ,'autocomplete'=>'off')) !!}
                                
                                </div>
                                @error('end_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            

                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                {!! Form::text('job_posting_url', null, array('placeholder' => 'Job Posting Url','class' => 'form-control')) !!}
                                
                                </div>
                                @error('job_posting_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                {!! Form::text('total_price', null, array('placeholder' => 'Total Price','class' => 'form-control')) !!}
                                
                                </div>
                                @error('total_price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                </div>
                                {!! Form::text('payment_received', null, array('placeholder' => 'Payment Received','class' => 'form-control')) !!}
                                
                                </div>
                                @error('payment_received')
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
    client_name:{
        required:true,
    },
    contract_type:{
        required:true,
    },
    project_type:{
        required:true,
    },
    start_date:{
        required:true,
    },
    end_date:{
        required:true,
    },
    job_posting_url:{
        required:true,
    },
    total_price:{
        required:true,
    },
    payment_received:{
        required:true,
    },
},messages: {
    client_name: {
      required: "Please provide  client name",
    },
    contract_type: {
       required: "Please provide contract type",
    },
    start_date: {
      required: "Please provide  start date",
    },
    end_date: {
       required: "Please provide end date",
    },
    project_type: {
      required: "Please select  project type",
    },
    total_price: {
       required: "Please provide total price",
    },
    job_posting_url: {
      required: "Please provide job posting url",
    },
    payment_received: {
       required: "Please add payment",
    },
},
 submitHandler: function(form) {
    form.submit();
  }

});


    
</script>
@endsection