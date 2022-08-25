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
                            <h3 class="mb-0">Add Hardware</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('hardware.index')}}" class="btn btn-sm btn-primary">Back</a>
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
                
                            {!! Form::open(array('route' => 'hardware.store','method'=>'POST','id'=>'addCategory')) !!}
                            @csrf
                             <div class="form-group">
                                <label class="label_class">System No</label>
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/system.svg') }}"></span>
                                    </div>
                                   
                                 
                                     {!! Form::text('system_no', null, array('placeholder' => 'System No','class' => 'form-control system_no')) !!}

                                
                                </div>
                                @error('system_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="label_class">Seat No</label>
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/seatno.svg') }}"></span>
                                    </div>
                                   {!! Form::text('seat_no', null, array('placeholder' => 'Seat No','class' => 'form-control seat_no')) !!}

                                
                                </div>
                                @error('seat_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="label_class">Assigned To</label>
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                       <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/assign.svg') }}"></span>
                                    </div>
                                     {!! Form::text('assigned_to', null, array('placeholder' => 'Assigned To','class' => 'form-control assigned_to')) !!}
                                     
                                
                                </div>
                                @error('assigned_to')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="label_class">Type</label>
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/desktop.svg') }}"></span>
                                    </div>
                                   
                                    {!! Form::select('type',$data['type'],'1', array('class' => 'form-control type','placeholder' => 'Type')) !!}

                                
                                </div>
                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                              
                           
                            <div class="form-group laptop_desktop">
                             
                                <div class="input-group radio-butn input-group-merge input-group-alternative mb-3">
                                <label class="label_class">Operating System</label>
                                    <div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="os" name="operating_system" class="custom-control-input" checked value="0">
                                        <label class="custom-control-label" for="os">Ubuntu</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="os1" name="operating_system" class="custom-control-input" value="1">
                                        <label class="custom-control-label" for="os1">Windows</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="os2" name="operating_system" class="custom-control-input" value="2">
                                        <label class="custom-control-label" for="os2">Mac</label>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mobile_tablet">
                             
                                <div class="input-group radio-butn input-group-merge input-group-alternative mb-3">
                                    <label class="label_class">Operating System</label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="os3" name="operating_system" class="custom-control-input" value="3">
                                            <label class="custom-control-label" for="os3">Android</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" name="operating_system" id="os4" class="custom-control-input" value="4">
                                            <label class="custom-control-label" for="os4">IOS</label>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="form-group">
                            
                                <div class="input-group radio-butn input-group-merge input-group-alternative mb-3">
                                     <label class="label_class">UPS</label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" name="ups" id="ups" class="custom-control-input" checked value="1">
                                            <label class="custom-control-label" for="ups">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" name="ups" id="ups2" class="custom-control-input" value="0">
                                            <label class="custom-control-label" for="ups2">No</label>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="form-group">
                             
                                <div class="input-group radio-butn input-group-merge input-group-alternative mb-3">
                                    <label class="label_class">Screen</label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" name="screen" id="screen" class="custom-control-input" checked value="1">
                                            <label class="custom-control-label" for="screen">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" name="screen" id="screen2" class="custom-control-input" value="0">
                                            <label class="custom-control-label" for="screen2">No</label>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="form-group">
                            
                                <div class="input-group radio-butn input-group-merge input-group-alternative mb-3">
                                    <label class="label_class">Keyboard</label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="keyboard" name="keyboard" class="custom-control-input" checked value="1">
                                            <label class="custom-control-label" for="keyboard">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="keyboard2" name="keyboard" class="custom-control-input" value="0">
                                            <label class="custom-control-label" for="keyboard2">No</label>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="form-group">
                            
                                <div class="input-group radio-butn input-group-merge input-group-alternative mb-3">
                                    <label class="label_class">Mouse</label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="mouse" name="mouse" class="custom-control-input" checked value="1">
                                            <label class="custom-control-label" for="mouse">Yes</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="mouse2" name="mouse" class="custom-control-input" value="0">
                                            <label class="custom-control-label" for="mouse2">No</label>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="form-group mouse_type_div">
                            
                                <div class="input-group radio-butn input-group-merge input-group-alternative mb-3">
                                    <label class="label_class">Mouse Type</label>
                                    <div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="mouse_type" name="mouse_type" class="custom-control-input" checked value="USB">
                                            <label class="custom-control-label" for="mouse_type">USB</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="mouse_type2" name="mouse_type" class="custom-control-input" value="Wireless">
                                            <label class="custom-control-label" for="mouse_type2">Wireless</label>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="label_class">Comment</label>
                                <div class="input-group input-group-merge input-group-alternative">
                        
                                {!! Form::textarea('comment', null, array('placeholder' => 'Comment','class' => 'form-control')) !!}
                                
                                </div>
                                @error('comment')
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
// 
$(document).ready(function(){
    $('.mobile_tablet').css('display','none');
    
    $("input[name$='mouse']").click(function() {
        
        var test = $(this).val();
        if(test == '0'){
            $(".mouse_type_div").css('display','none');
        }else{
            $(".mouse_type_div").css('display','block');
        }
        
    });    
    $(".type").change('on', function() {
        
        var test =  $(".type :selected").val();
        if(test == '3' || test == '4'){
            $("#os3").prop("checked", true);
            
            $(".laptop_desktop").css('display','none');
            $(".mobile_tablet").css('display','block');
        }else{
            $("#os").prop("checked", true);
            $(".laptop_desktop").css('display','block');
            $('.mobile_tablet').css('display','none');
        }
        
    });

});
$("#addCategory").validate({
    errorElement: 'div',
rules: {
    system_no:{
        required:true,
        number:true,
    },
    seat_no:{
        required: true,
        number:true,
    },
    assigned_to:{
        required:true,
    },
    type:{
        required: true,
    },
    operating_system:{
        required:true,
    },
    
},messages: {
    system_no: {
       required: "Please provide system no",
       number: "Only numbers allowed",
    },
    seat_no: {
       required: "Please provide seat no",
       number: "Only numbers allowed",
    },
    assigned_to: {
       required: "Please provide assigned name",
    },
    type: {
       required: "Please provide type",
    },
    operating_system: {
       required: "Please provide operating system",
    },
  
},
 submitHandler: function(form) {
    form.submit();
  }

});


    
</script>
@endsection
