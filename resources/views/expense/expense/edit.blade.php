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
                            <h3 class="mb-0">Edit Expense</h3>
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
                        <form method="POST" action="{{ route('updateExpense',$expense->id) }}" enctype="multipart/form-data" id="addCategory">
                            @csrf
                           <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-satisfied"></i></span>
                                    </div> 
                                    <select class="form-control @error('category') is-invalid @enderror" name="category" id="category">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category['id'] }}" {{ $category['id']== $expense['category_id'] ? 'selected' : '' }}>{{$category['name']}}
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
                                        <span class="input-group-text"><i class="ni ni-shop"></i></span>
                                    </div> 
                                    <select class="form-control @error('account_no') is-invalid @enderror" name="account_no" id="account_no">
                                        <option value="">Select Bank Account</option>
                                        @foreach($banks as $bank)
                                         <option value="{{ $bank['account_no'] }}" {{ $bank['account_no']== $expense['account_no'] ? 'selected' : '' }}>{{$bank['account_no']}}
                                        </option>
                                        @endforeach 
                                    </select>
                                    
                                    </div>
                                    @error('account_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                                    </div> 
                                    <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
                                        <option value="">Select Transaction Type</option>
                                        <option value="1" {{ $expense['type']== 1 ? 'selected' : '' }}>Debit</option>
                                        <option value="2" {{ $expense['type']== 2 ? 'selected' : '' }}>Credit</option>
                                    </select>
                                </div>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                           

                              <div class="form-group">
                                    <div class="input-group input-group-merge input-group-alternative mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-satisfied"></i></span>
                                    </div> 
                                    <select class="form-control @error('beneficiary') is-invalid @enderror" name="beneficiary" id="beneficiary">
                                        <option value="">Select Beneficiary</option>
                                        @foreach($beneficiaries as $beneficiary)
                                        <option value="{{ $beneficiary['id'] }}" {{ $beneficiary['id']== $expense['beneficary_id'] ? 'selected' : '' }}>{{$beneficiary['name']}}
                                        </option>
                                        @endforeach 
                                    </select>
                                    
                                    </div>
                                    @error('beneficiary')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                             <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                                </div>
                                <input id="amount" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount')??$expense->amount }}"  autocomplete="amount" placeholder="Amount" autofocus>
                                
                                </div>
                                @error('amount')
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
                                    @php
                                        $transaction_date = old('transaction_date') ?? '';
                                    @endphp
                                    <input id="datepicker"  type="text" class="form-control @error('transaction_date') is-invalid @enderror" name="transaction_date" value="{{ old('transaction_date')??$expense->transaction_date }}" required autocomplete="off" placeholder="Transaction date">
                      
                                    @error('transaction_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="http://127.0.0.1:8000/assets/img/icons/remark.svg"></span>
                                </div>
                                <textarea id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks"  placeholder="Remarks" autofocus>{{ old('remarks') ?? $expense->remarks }}</textarea>
                                
                                </div>
                                @error('remarks')
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
    type:{
        required:true,
    },
    amount:{
        required:true,
        number:true,
    },
    transaction_date:{
        required:true,
    },
},messages: {
    category: {
       required: "Please select category",
    },
    amount: {
       required: "Please provide amount",
       number: "Only numbers allowed",
    },
    transaction_date : {
       required: "Please provide transaction date",
    },
    type : {
       required: "Please select transaction type",
    },
},
 submitHandler: function(form) {
    form.submit();
  }

});

    
    
</script>
@endsection