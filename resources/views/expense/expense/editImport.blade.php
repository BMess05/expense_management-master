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
                            <h3 class="mb-0">Edit Import Expense</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('importExpense')}}" class="btn btn-sm btn-primary">Back</a>
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
                        <form method="POST"  enctype="multipart/form-data" id="addCategory" action="{{route('updateDraftExpense',$draft_expenses->id)}}">
                            @csrf

                            

                             <div class="text-right">
                                <button type="submit" id="save_cat" class="btn btn-primary mb-3" name="action" value="Save" formnovalidate>Save</button>
                                <button type="submit" id="publish" class="btn btn-success mb-3" name="action" value="Publish">Publish</button>
                            </div>




                            <div class="form-group">
                                <div class="custom-control custom-checkbox mb-3">
                                  <input type="checkbox" class="custom-control-input selectall" id="customCheck" name="example1">
                                  <label class="custom-control-label" for="customCheck">Select All</label>
                                </div>
                            </div>

                        <div id="select_cat" style="display: none">
                            <div class="row pl-4">
                                 <div class="form-group col-md-3">
                                    <select class="form-control @error('category') is-invalid @enderror" name="allcategory" id="allcategory" >
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ ($category['id'])?? old('category') }}">{{$category['name']}}
                                        </option>
                                        @endforeach 
                                    </select>
                                    
                                   
                                    @error('allcategory')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                  </div>

                                <div class="form-group col-md-3">
                                    <select class="form-control @error('beneficiary') is-invalid @enderror" name="beneficiaryall" id="beneficiaryall" >
                                            <option value="">Select Beneficiary</option>
                                             @foreach($beneficiaries as $beneficiary)
                                            <option value="{{ $beneficiary['id'] }}">{{$beneficiary['name']}}
                                            </option>
                                            @endforeach 
                                        </select>
                                        
                                        @error('beneficiaryall')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                        </div>

                         

                         @if($draft_expenses)   
                         @foreach($draft_expenses['draft_records'] as $key=>$expense)
                         <div class="d-flex import-expense">
                         <div class="form-group" id="checkboxlist">
                                <div class="custom-control custom-checkbox">
                                  <input type="checkbox" class="custom-control-input single_check" id="customCheck{{$key}}" name="sample">
                                  <label class="custom-control-label" for="customCheck{{$key}}"></label>
                               </div>
                            </div>
                         <div class="row">

                                <div class="form-group col-md-3">
                                    
                                    <select class="form-control category @error('category') is-invalid @enderror" name="category[]" id="category{{$key}}" >
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ ($category['id'])?? old('category[]') }}" {{ $category['id']== $expense['category_id'] ? 'selected' : '' }}>{{$category['name']}}
                                        </option>
                                        @endforeach 
                                    </select>
                                    
                                   
                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                        
                              <div class="form-group col-md-3">
                                    
                                    <select class="form-control beneficiary @error('beneficiary') is-invalid @enderror" name="beneficiary[]" id="beneficiary{{$key}}" >
                                        <option value="">Select Beneficiary</option>
                                         @foreach($beneficiaries as $beneficiary)
                                        <option value="{{ $beneficiary['id'] }}" {{ $beneficiary['id']== $expense['beneficiary_id'] ? 'selected' : '' }}>{{$beneficiary['name']}}
                                        </option>
                                        @endforeach 
                                    </select>
                                    
                                    
                                    @error('beneficiary')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="form-group col-md-2">
                                    
                                    <select class="form-control @error('type') is-invalid @enderror" name="type[]" id="type">
                                        <option value="">Select Type</option>
                                         <option value="1" {{ $expense['type']== 1 ? 'selected' : '' }}>Debit</option>
                                        <option value="2" {{ $expense['type']== 2 ? 'selected' : '' }}>Credit</option>
                                    </select>
                                    
                                   
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>


                            
                             <div class="form-group col-md-2">
                                
                                <input id="amount{{$key}}" type="text" class="form-control @error('amount') is-invalid @enderror" name="amount[]" value="{{ old('amount[]')??$expense['amount'] }}"  autocomplete="amount" placeholder="Amount" autofocus>
                                
                               
                                @error('amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                             <div class="form-group col-md-2">
                                <input   type="text" class="form-control @error('transaction_date') is-invalid @enderror datepicker" name="transaction_date[]" value="{{ old('transaction_date[]')??$expense->transaction_date }}" required autocomplete="off" placeholder="Transaction date" id="transaction_date{$key}">
                  
                                @error('transaction_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>

                            <div class="form-group col-md-12">
                               
                                <textarea id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks[]"  placeholder="Remarks" autofocus>{{ old('remarks[]') ?? $expense->remarks }}</textarea>
                                
                               
                                @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                           
                           <input type="hidden" name="draft_id[]" value="{{$expense->id}}">
                           <input type="hidden" name="account_no" value="{{$draft_expenses->account_no}}">
                            </div>
                        </div>
                             @endforeach
                             @endif

                           
                            
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
        "category[]":{
            required:true,
        },
         "beneficiary[]":{
            required:true,
        },
         "amount[]":{
            required:true,
            number:true
        },
         "transaction_date[]":{
            required:true,
        },
       
    },messages: {
        "category[]": {
           required: "Please select category",
        },
        "beneficiary[]":{
          required: "Please select beneficiary",
        },
        "amount[]":{
          required: "Please add amount",
          number: "Only numbers allowed",
        },
         "transaction_date[]":{
          required: "Please select  date",
        },
       
    },
     submitHandler: function(form) {
        form.submit();

      }

    });


$('#publish').click(function(e){
     e.preventDefault()
      if($("#addCategory").valid()==true)
    {
  
    let title="Are you sure, you want to publish this expense?";
        swal({
            title: title,
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $('#addCategory').submit();
               
            }
        });
     }
})



/*$("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
     if($(this).is(':checked'))
       $("#select_cat").show();  // checked
     else
      $("#select_cat").hide();  // unchecked
 });

$(".single_check").click(function () {
     if($(this).is(':checked'))
       $("#select_cat").show();  // checked
    
      
     
     
 });*/

$('.selectall').on('change', function(e) {
    var $inputs = $('#checkboxlist input[type=checkbox]');
    var length=$('#checkboxlist input:checked').length
     if(length>=2)
        $("#select_cat").show();
     else
        $("#select_cat").hide();
    if(e.originalEvent === undefined) {
        var allChecked = true;
        $inputs.each(function(){
            allChecked = allChecked && this.checked;
        });
        this.checked = allChecked;
    } else {
          $inputs.prop('checked', this.checked);
          if($(this).is(':checked'))
            $("#select_cat").show();  // checked
         else
           $("#select_cat").hide();  // unchecked
        }

});

$('#checkboxlist input[type=checkbox]').on('change', function(){
    $('.selectall').trigger('change');
});

$('#allcategory').on('change', function(){
    var $category=this.value;
    var x = document.getElementsByClassName('category');
    for(i = 0; i < x.length; i++) {
        if($(`#customCheck${i}`).is(':checked'))
        {
          x[i].value = $category;
        }
    }

});

$('#beneficiaryall').on('change', function(){
    var $category=this.value;
    var x = document.getElementsByClassName('beneficiary');
    for(i = 0; i < x.length; i++) {
        if($(`#customCheck${i}`).is(':checked'))
        {
            x[i].value = $category;
        }
    }

});

</script>
@endsection