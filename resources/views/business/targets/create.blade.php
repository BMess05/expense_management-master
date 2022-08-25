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
                            <h3 class="mb-0">Add Targets</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('targets.index')}}" class="btn btn-sm btn-primary">Back</a>
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
                
                            {!! Form::open(array('route' => 'targets.store','method'=>'POST','id'=>'addCategory')) !!}
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/wpf_name.svg') }}"></span>
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
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/wpf_name.svg') }}"></span>
                                    </div>
                                    {!! Form::select('profile_id',$bidProfile,[], array('class' => 'form-control','placeholder' => 'Profile Id')) !!}
                                
                                </div>
                                @error('profile_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/businessform.svg') }}"></span>
                                    </div>
                                     {!! Form::text('job_id', null, array('placeholder' => 'Job Id','class' => 'form-control')) !!}
                                
                                </div>
                                @error('job_id')
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
                                    {!! Form::select('target_month',$months,$lastMonth, array('class' => 'form-control','placeholder' => 'Target Month')) !!}

                                   
                                
                                </div>
                                @error('target_month')
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
                                    {!! Form::text('hire_date', null, array('placeholder' => 'Hire Date','class' => 'form-control','id'=>'datepicker')) !!}

                                
                                </div>
                                @error('hire_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/time.svg') }}"></span>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="type" name="type" class="custom-control-input" checked value="Fixed">
                                  <label class="custom-control-label" for="type">Fixed</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="type2" name="type" class="custom-control-input" value="Hourly">
                                  <label class="custom-control-label" for="type2">Hourly</label>
                                </div>

                                </div>
                            </div>
                            <div class="show_types">
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/time.svg') }}"></span>
                                        </div>
                                        {!! Form::text('hours', null, array('placeholder' => 'Hours','class' => 'hours form-control')) !!}
                                    
                                    </div>
                                    @error('hours')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/time.svg') }}"></span>
                                        </div>
                                        {!! Form::select('minutes',$minutes,[], array('class' => 'form-control minutes','placeholder' => 'Minutes')) !!}
                                    
                                    </div>
                                    @error('hourly_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">   
                                              <img width="15" height="20" src="{{ asset('assets/img/icons/dollar.svg') }}">&nbsp;
                                            </span>
                                        </div>
                                        {!! Form::text('hourly_price', null, array('placeholder' => 'Hourly Price','class' => 'form-control hourly_price')) !!}
                                    
                                    </div>
                                    @error('hourly_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                             <img width="15" height="20" src="{{ asset('assets/img/icons/dollar.svg') }}">&nbsp;
                                        </span>
                                    </div>
                                

                                     {!! Form::text('billing_amount', null, array('placeholder' => 'Billing Amount','class' => 'form-control billing_amount')) !!}
                                     
                             
                                </div>
                                @error('billing_amount')
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
$(document).ready(function(){
    $('.show_types').css('display','none');
    $("input[name$='type']").click(function() {
        
        var test = $(this).val();
        if(test == 'Hourly'){
         
            $(".billing_amount").val('');
           
            $(".billing_amount").prop("readonly", true);
            $(".show_types").css('display','block');
        }else{
            $(".billing_amount").val('');
            $('.show_types').css('display','none');
            $(".billing_amount").prop("readonly", false);
        }
        
    });

});
$(document).on('keyup change', '.hours , .minutes, .hourly_price', function() {
  var hours = $('.hours').val();
  var price = $('.hourly_price').val();
  var min =  $(".minutes :selected").val();
  console.log(hours,'hours');
  console.log(price,'price');
 
  if(hours !='' && price !=''){
    var billing_amount =0;
    if(min !=''){
        var ten_minutes = price / 6;  //price % 6
        ten_minutes = ten_minutes.toPrecision(3);
        console.log(ten_minutes);
        if(min =='10'){
            billing_amount = (price * hours) + 1*ten_minutes;
        }
        if(min =='20'){
            billing_amount = (price * hours) + 2*ten_minutes;
        }
        if(min =='30'){
            billing_amount = (price * hours) + 3*ten_minutes;
        }
        if(min =='40'){
            billing_amount = (price * hours) + 4*ten_minutes;
        }
        if(min =='50'){
            billing_amount = (price * hours) + 5*ten_minutes;
        }
      
    }
    else{
        billing_amount = price * hours;
    }
    $('.billing_amount').val(billing_amount);
  }
  

});


$("#addCategory").validate({
    errorElement: 'div',
rules: {
    client_name:{
        required:true,
    },
    profile_id:{
        required:true,
    },
    billing_amount :{
        required:true,
        number:true,
    },
    hours:{
       number:true,
    },
    hourly_price:{
        number:true,
    },
},messages: {
    client_name: {
      required: "Please provide  client name",
    },
    profile_id: {
       required: "Please provide profile id",
    },
    billing_amount: {
       required: "Please provide billing amount",
       number: "Only numbers allowed",
    },
    hours:{
       number: "Only numbers allowed",
    },
    hourly_price:{
       number: "Only numbers allowed",
    },
},
 submitHandler: function(form) {
    form.submit();
  }

});


    
</script>
@endsection