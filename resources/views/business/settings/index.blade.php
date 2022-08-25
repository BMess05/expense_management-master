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
                            <h3 class="mb-0">Settings</h3>
                        </div>
                        @can('settings-create')
                        <div class="col text-right"> 
                            <a href="{{route('settings.create')}}" class="btn btn-sm btn-primary">Add Setting</a>
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
                        @if(count($settings) > 0)

                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Financial year</th>
                                    <th scope="col" class="sort" data-sort="name">Amount</th>
                                   <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($settings as $key => $setting)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $setting->financial_year }}</td>
                                    <td>${{ number_format($setting->target_amount, 2) }}</td>
                                   
                                    <td>
                                    
                                    @can('settings-edit')
                                     <a href="{{route('settings.edit',$setting->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                    @endcan 
                                    @can('settings-delete')
                                     <a id="Are you sure,you want to delete this setting?" data-toggle="tooltip" title="Delete" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('settings.destroy',$setting->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    @endcan
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>
                         
                         @else
                           <div class="no-data-found"><h4>No settings found</h4></div>
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