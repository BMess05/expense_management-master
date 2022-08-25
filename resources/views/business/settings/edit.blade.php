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
                            <h3 class="mb-0">Edit Setting</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('settings.index')}}" class="btn btn-sm btn-primary">Back</a>
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
                        {!! Form::model($setting, ['method' => 'PATCH','route' => ['settings.update', $setting->id],'id'=>'addCategory']) !!}
                          
                            @csrf
                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    @if (date('m') > 3 )
                                        @php $year = date('Y')."-".(date('Y') +1);@endphp
                                    @else
                                        @php $year = (date('Y')-1)."-".date('Y'); @endphp
                                    @endif

                                    {!! Form::select('financial_year',$year_arr,$setting->financial_year, array('class' => 'form-control','placeholder' => 'Financial Year')) !!}
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
                                        <span class="input-group-text">  
                                            <img width="15" height="20" src="{{ asset('assets/img/icons/dollar.svg') }}">&nbsp;
                                        </span>
                                    </div>
                                     {!! Form::text('target_amount', null, array('placeholder' => 'Target Amount','class' => 'form-control target_amount')) !!}
                                     
                                
                                </div>
                                @error('target_amount')
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
$("#addCategory").validate({
    errorElement: 'div',
rules: {
    financial_year:{
        required:true,
    },
    target_amount:{
        required: true,
        number:true,
    },
},messages: {
    financial_year: {
       required: "Please provide financial year",
    },
    target_amount: {
       required: "Please provide amount",
       number: "Only numbers allowed",
    }
},
 submitHandler: function(form) {
    form.submit();
  }

});


    
</script>
@endsection