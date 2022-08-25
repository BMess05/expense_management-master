@extends('layouts.main')
@section('content')
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-Expenses-center">
                        <div class="col">
                            <h3 class="mb-0">Export Expenses</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('expenses')}}" class="btn btn-sm btn-primary">Back</a>
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
                        <form method="POST" action="{{ route('exportingExpense') }}" enctype="multipart/form-data" id="addCategory" autocomplete="off">
                         @csrf
                            <div class="form-row">
                             <div class="form-group col-md-6 pb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                       
                                        <input id="datepicker"  type="text" class="form-control  @error('from_date') is-invalid @enderror" name="from_date" value="{{ old('from_date') }}" required placeholder="From date">
                          
                                        @error('from_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>


                             <div class="form-group col-md-6 pb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        @php
                                            $transaction_date = old('transaction_date') ?? '';
                                        @endphp
                                        <input id="datepicker2"  type="text" class="form-control @error('to_date') is-invalid @enderror" name="to_date" value="{{ old('to_date') }}" required  placeholder="To date">
                          
                                        @error('to_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>

                            <div class="form-group col-md-6 pb-3">
                                <div class="input-group input-group-merge input-group-alternative cards-options">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="trans_type" name="trans_type" class="custom-control-input" checked value="0">
                                  <label class="custom-control-label" for="trans_type">All</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="trans_type2" name="trans_type" class="custom-control-input" value="1">
                                  <label class="custom-control-label" for="trans_type2">Debit</label>
                                </div>

                                 <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="trans_type3" name="trans_type" class="custom-control-input" value="2">
                                  <label class="custom-control-label" for="trans_type3">Credit</label>
                                </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6 pb-3">
                                <div class="input-group input-group-merge input-group-alternative cards-options">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-send"></i></span>
                                        </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="file_type1" name="file_type" class="custom-control-input" checked value="pdf">
                                  <label class="custom-control-label" for="file_type1">PDF</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                  <input type="radio" id="file_type2" name="file_type" class="custom-control-input" value="csv">
                                  <label class="custom-control-label" for="file_type2">CSV</label>
                                </div>
                                </div>
                            </div>
                 
                            <div class="text-right">
                                <button type="submit" id="save_cat" class="btn btn-primary ">Export</button>
                            </div>
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
<script type="text/javascript">

$(function() {
    $( "#datepicker" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd-mm-yy',
      maxDate:new Date(),
      //numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#datepicker2" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#datepicker2" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      changeYear: true,
      dateFormat: 'dd-mm-yy',
      maxDate:new Date(),
      //numberOfMonths: 3,
      onClose: function( selectedDate ) {
        $( "#datepicker" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });

$("#addCategory").validate({
    errorElement: 'div',
rules: {
    from_date:{
        required:true,
    },
    to_date:{
        required:true,
    },
},messages: {
    from_date: {
       required: "Please select from date",
    },
    to_date: {
       required: "Please select to date",
    },
},
 submitHandler: function(form) {
    form.submit();
  }

});



</script>
@endsection