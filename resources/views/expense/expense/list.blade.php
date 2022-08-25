@extends('layouts.main')
@section('content')
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-Expense-center">
                        <div class="col-3 expense-heading">
                            <h3 class="mb-0">Expenses</h3>
                        </div>
                        <div class="col left-btn text-right"> 
                           @can('expense-create')
                            <a href="{{route('addExpense')}}" class="btn btn-sm btn-primary">Add Expense</a>
                            @endcan
                            <a href="{{route('importExpense')}}" class="btn btn-sm btn-primary">Import</a>
                            <a href="{{route('exportExpense')}}" class="btn btn-sm btn-primary">Export</a>
                        </div>
                       
                        </div>
                    </div>
                     @include('expense.expense.filter')
                    <div class="card-body table-responsive">
                        @if(session('status'))
                            <div class="alert alert-{{ Session::get('status') }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ Session::get('message') }}
                            </div>
                        @endif

                         <form method="post" id="category">
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="customCheck1234" onclick="showArchived(event)">
                              <label class="custom-control-label" for="customCheck1234">Show Archived Expenses</label>
                           </div>
                         </form>

                        <div id="abc">
                        @if(count($expenses) > 0)
                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer mt-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Category</th>
                                    <th scope="col" class="sort" data-sort="email">Amount</th>
                                    <th scope="col" class="sort" data-sort="email">Transaction Date</th>
                                    <th scope="col" class="sort" data-sort="email">Beneficiary</th>
                                    <th scope="col" class="sort" data-sort="email">Remarks</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php {{$count=1;}} @endphp
                                @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ ($expense->category)?$expense->category->name:'' }}</td>
                                    @if($expense->type==2)
                                    <td class="text-success" data-toggle="tooltip" title="Credit">{{ $expense->amount}}</td>
                                    @else
                                    <td class="text-danger" data-toggle="tooltip" title="Debit">{{ $expense->amount}}</td>
                                    @endif

                                    <td>{{$expense->transaction_date}}</td>
                                    <td>{{ ($expense->beneficary->name)??'' }}</td>
                                    <td>{{ $expense->remarks }}</td>
                                    <th>
                                    @can('expense-edit')
                                    <a data-toggle="tooltip" title="Edit" href="{{route('editExpense',$expense->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('expense-delete')
                                    <a id="Are you sure, you want to archive this expense?" data-toggle="tooltip" title="Archive"onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteExpense',$expense->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-arrow-down"></i></a>
                                    @endcan
                                   
                                    </th>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary btn-sm mt-3" id="show_all_records">Show All</button>
                         @else
                           <div class="no-data-found"><h4>No Expenses found</h4></div>
                        @endif
                    </div>
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
/*$('#generateQuote').validate({ // initialize the plugin
        rules: {
            from_date: {
                
                required: true
            },
            to_date: {
            
                required: true
            }
        },
        submitHandler: function (form) { 
            form.submit();
        }
    });*/

  /*$('#generateQuote').validate({ // initialize the plugin
        groups: {
            names: "type category"
        },
        rules: {
            type: {
                require_from_group: [1, ".send"]
            },
            category: {
                require_from_group: [1, ".send"]
            }
        },
        submitHandler: function (form) { // for demo
           form.submit();
        }
    });*/




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
    
</script>
@endsection