@extends('layouts.main')
@section('content')
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-banks-center">
                        <div class="col">
                            <h3 class="mb-0">Targets Achieved</h3>
                        </div>
                        @can('target-create')
                        <div class="col text-right"> 
                            <a href="{{route('targets.create')}}" class="btn btn-sm btn-primary">Add Targets</a>
                        </div>
                        @endcan
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        @if(session('success'))
                            <div class="alert alert-{{ Session::get('success') }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ Session::get('message') }}
                            </div>
                        @endif

                      
                        <!-- Projects table -->
                        <div id="abc">
                        @if(count($targets) > 0)

                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Client Name</th>
                                    <th scope="col" class="sort" data-sort="name">Profile Name</th>
                                    <th scope="col" class="sort" data-sort="name">Job Id</th>
                                    <th scope="col" class="sort" data-sort="name">Target Month</th>
                                    <th scope="col" class="sort" data-sort="name">Hire Date</th>
                                    <th scope="col" class="sort" data-sort="name">Type</th>
                                    <th scope="col" class="sort" data-sort="name">Hours</th>
                                    <th scope="col" class="sort" data-sort="name">Minutes</th>
                                    <th scope="col" class="sort" data-sort="name">Hourly Price</th>
                                    <th scope="col" class="sort" data-sort="name">Billing Amount</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($targets as $key => $target)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $target->client_name }}</td>
                                    <td>{{($target->bidprofile()->exists())?$target->bidprofile->name:''}}</td>
                                   
                                    <td>{{ $target->job_id }}</td>
                                    <td>{{ $target->target_month }}</td>
                                    <td>{{ $target->hire_date }}</td>
                                    <td>{{ $target->type }}</td>
                                    <td>{{ $target->hours }}</td>
                                    <td>{{ $target->minutes }}</td>
                                    <td>{{ $target->hourly_price }}</td>
                                    <td>${{ number_format($target->billing_amount, 2) }}</td>
                                    
                                    <td>
                                    
                                    @can('target-edit')
                                    <a href="{{route('targets.edit',$target->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('target-delete')
                                    <a id="Are you sure,you want to delete this target?" data-toggle="tooltip" title="Delete" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('targets.destroy',$target->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    @endcan
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>
                         
                         @else
                           <div class="no-data-found"><h4>No targets found</h4></div>
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
<script type="text/javascript">
    
$('form').submit(function(e){
   e.preventDefault();
   let title=$('form').attr('id');
   swal({
            title: title,
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                $('form').submit();
               
            }
        });
             
});
</script>
@endsection