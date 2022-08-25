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
                            <h3 class="mb-0">Import Expenses</h3>

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
                        <form method="POST" action="{{ route('importExcelSheet') }}" enctype="multipart/form-data" id="addCategory" autocomplete="off">
                         @csrf
                            <div class="form-row">
                            <div class="form-group col-md-6">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-shop"></i></span>
                                    </div> 
                                    <select class="form-control @error('bank') is-invalid @enderror" name="bank" id="bank">
                                        <option value="">Select Bank</option>
                                        @foreach($banks as $bank)
                                        <option value="{{ $bank['account_no'] }}">{{$bank['bank_name']}} - {{$bank['account_no']}}
                                        </option>
                                        @endforeach 
                                    </select>
                                    
                                    </div>
                                    @error('bank')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>


                             <div class="form-group col-md-6 pb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-hat-3"></i></span>
                                        </div>
                                        <input id="title"  type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}"   placeholder="Title">
                                    </div>
                                    @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
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

                            <div class="text-right">
                                <button type="submit" id="save_cat" class="btn btn-primary ">Import</button>
                            </div>
                        </div>
                        </form>
                       
                        @include('expense.expense.draftList')
                       
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
</div>
@endsection

@section('script')
@include('layouts.common_js')
<script type="text/javascript">
$("#addCategory").validate({
    errorElement: 'div',
rules: {
    bank:{
        required:true,
    },
    title:{
        required:true,
    },
    select_file:{
        required:true,
    },
},messages: {
    bank: {
       required: "Please select bank",
    },
    title: {
       required: "Please provide title",
    },
    select_file : {
       required: "Please select file to upload",
    },
},
 submitHandler: function(form) {
    form.submit();
  }

});
</script>
@endsection