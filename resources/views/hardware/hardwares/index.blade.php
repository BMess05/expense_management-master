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
                            <h3 class="mb-0">Hardware</h3>
                        </div>
                        @can('hardware-create')
                            <div class="col text-right"> 
                                <a href="{{route('hardware.create')}}" class="btn btn-sm btn-primary">Add Hardware</a>
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
                        @if(count($hardwares) > 0)

                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">User</th>
                                    <th scope="col" class="sort" data-sort="name">System No</th>
                                    <th scope="col" class="sort" data-sort="name">Seat No</th>
                                    <th scope="col" class="sort" data-sort="name">Assigned To</th>
                                    <th scope="col" class="sort" data-sort="name">Type</th>
                                    <!-- <th scope="col" class="sort" data-sort="name">Operating System</th>
                                    <th scope="col" class="sort" data-sort="name">UPS</th>
                                    <th scope="col" class="sort" data-sort="name">Screen</th>
                                    <th scope="col" class="sort" data-sort="name">Keyboard</th>
                                    <th scope="col" class="sort" data-sort="name">Mouse</th>
                                    <th scope="col" class="sort" data-sort="name">Mouse Type</th>
                                    <th scope="col" class="sort" data-sort="name">Comment</th> -->
                                   <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($hardwares as $key => $hardware)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{($hardware->hardwareuser()->exists())?$hardware->hardwareuser->name:''}}</td>

                                    <td>{{ $hardware->system_no }}</td>
                                    <td>{{ $hardware->seat_no }}</td>
                                    <td>{{ $hardware->assigned_to }}</td>
                                    <td>
                                        @if($hardware->type == 1)
                                          Desktop
                                        @elseif($hardware->type == 2)
                                          Laptop
                                        @elseif($hardware->type == 3)
                                          Mobile
                                        @elseif($hardware->type == 4)
                                          Tablet
                                        @endif
                                    </td>
                                    {{--<td>
                                        @if($hardware->operating_system == 0)
                                          Ubuntu
                                        @elseif($hardware->operating_system == 1)
                                          Windows
                                        @elseif($hardware->operating_system == 2)
                                          Mac
                                        @elseif($hardware->operating_system == 3)
                                          Android
                                        @elseif($hardware->operating_system == 4)
                                          IOS
                                        @endif
                                    </td>
                                    <td>
                                    @if($hardware->ups == 0)
                                        <span style="font-size:20px;">&#10005;</span>
                                    @else
                                    <span style="font-size:20px;">&#10004;</span>
                                    @endif
                                   </td>
                                    
                                    <td>
                                    @if($hardware->screen == 0)
                                        <span style="font-size:20px;">&#10005;</span>
                                    @else
                                    <span style="font-size:20px;">&#10004;</span>
                                    @endif
                                   </td>
                                    <td>
                                    @if($hardware->keyboard == 0)
                                        <span style="font-size:20px;">&#10005;</span>
                                    @else
                                    <span style="font-size:20px;">&#10004;</span>
                                    @endif
                                   </td>
                                   <td>
                                    @if($hardware->mouse == 0)
                                        <span style="font-size:20px;">&#10005;</span>
                                    @else
                                    <span style="font-size:20px;">&#10004;</span>
                                    @endif
                                   </td>
                                    <td>{{ $hardware->mouse_type }}</td>
                                    <td>{{ $hardware->comment }}</td>--}}
                                   
                                    <td>
                                    <a href="{{route('hardware.view',$hardware->id)}}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                     
                                   @can('hardware-edit')
                                    <a href="{{route('hardware.edit',$hardware->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('hardware-delete')
                                    <a id="Are you sure,you want to delete this hardware?" data-toggle="tooltip" title="Delete" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('hardware.destroy',$hardware->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    @endcan
                                   
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>
                         
                         @else
                           <div class="no-data-found"><h4>No hardware found</h4></div>
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