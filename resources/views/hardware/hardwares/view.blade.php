@extends('layouts.main')
@section('content')
<style>
.hardware_history_table{
    table-layout: auto !important;
}
.info_table td{
width:50%
}
.history_table{
    margin-top: 2rem;
}
</style>
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-banks-center">
                        <div class="col">
                            <h3 class="mb-0">Hardware Info</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('hardware.index')}}" class="btn btn-sm btn-primary">Back</a>
                        </div>
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
                        <div class="col-md-12">
                        <table class="table table-bordered table-hover info_table">
                           
                            <tbody>
                                <tr>
                                    <th>User</th>
                                    <td>{{($hardware_info->hardwareuser()->exists())?$hardware_info->hardwareuser->name:''}}</td>
                                </tr>
                                <tr>
                                    <th> System No</th>
                                    <td>{{$hardware_info->system_no}}</td>
                                </tr>
                                <tr>
                                    <th>Seat No</th>
                                    <td>{{$hardware_info->seat_no}}</td>
                                </tr>
                                <tr>
                                    <th>Assigned To</th>
                                    <td>{{$hardware_info->assigned_to}}</td>
                            
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>
                                    @if($hardware_info->type == 1)
                                        Desktop
                                    @elseif($hardware_info->type == 2)
                                        Laptop
                                    @elseif($hardware_info->type == 3)
                                        Mobile
                                    @elseif($hardware_info->type == 4)
                                        Tablet
                                    @endif
                                    </td>
                            
                                </tr>
                                <tr>
                                    <th>Operating System</th>
                                    <td>
                                    @if($hardware_info->operating_system == 0)
                                        Ubuntu
                                    @elseif($hardware_info->operating_system == 1)
                                        Windows
                                    @elseif($hardware_info->operating_system == 2)
                                        Mac
                                    @elseif($hardware_info->operating_system == 3)
                                        Android
                                    @elseif($hardware_info->operating_system == 4)
                                        IOS
                                    @endif
                                    </td>
                            
                                </tr>
                                <tr>
                                    <th>UPS</th>
                                    <td>
                                    @if($hardware_info->ups == 0)
                                        <span style="font-size:20px;">&#10005;</span>
                                    @else
                                        <span style="font-size:20px;">&#10004;</span>
                                    @endif
                                    </td>
                            
                                </tr>
                                <tr>
                                    <th>Screen</th>
                                    <td>
                                    @if($hardware_info->screen == 0)
                                        <span style="font-size:20px;">&#10005;</span>
                                    @else
                                        <span style="font-size:20px;">&#10004;</span>
                                    @endif
                                    </td>
                            
                                </tr>
                                <tr>
                                    <th>Keyboard</th>
                                    <td>
                                    @if($hardware_info->keyboard == 0)
                                        <span style="font-size:20px;">&#10005;</span>
                                    @else
                                        <span style="font-size:20px;">&#10004;</span>
                                    @endif
                                    </td>
                            
                                </tr>
                                <tr>
                                    <th>Mouse</th>
                                    <td>
                                    @if($hardware_info->mouse == 0)
                                        <span style="font-size:20px;">&#10005;</span>
                                    @else
                                        <span style="font-size:20px;">&#10004;</span>
                                    @endif
                                    </td>
                            
                                </tr>
                                <tr>
                                    <th>Mouse Type</th>
                                    <td>{{$hardware_info->mouse_type}}</td>
                            
                                </tr>
                                 <tr>
                                    <th>Comment</th>
                                    <td>{{$hardware_info->comment}}</td>
                            
                                </tr>
                            </tbody>
                        </table>
                        </div>
                            
                            
                      
                        <!-- Projects table -->
                        <div id="abc" class="history_table">
                        @if(count($hardware_history) > 0)

                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer hardware_history_table" id="dataTable_hardwarehistory">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Update Time</th>
                                    <th scope="col" class="sort" data-sort="name">User</th>
                                    <th scope="col" class="sort" data-sort="name">System No</th>
                                    <th scope="col" class="sort" data-sort="name">Seat No</th>
                                    <th scope="col" class="sort" data-sort="name">Assigned To</th>
                                    <th scope="col" class="sort" data-sort="name">Type</th>
                                    <th scope="col" class="sort" data-sort="name">Operating System</th>
                                    <th scope="col" class="sort" data-sort="name">UPS</th>
                                    <th scope="col" class="sort" data-sort="name">Screen</th>
                                    <th scope="col" class="sort" data-sort="name">Keyboard</th>
                                    <th scope="col" class="sort" data-sort="name">Mouse</th>
                                    <th scope="col" class="sort" data-sort="name">Mouse Type</th>
                                    <th scope="col" class="sort" data-sort="name">Comment</th>
                                   
                                    <!-- <th scope="col">Action</th> -->
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($hardware_history as $key => $hardware)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $hardware->created_at }}</td>
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
                                    
                                   
                                  <td>
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
                                    <td>{{ $hardware->comment }}</td>
                                   
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>
                         
                         @else
                           <div class="no-data-found"><h4>No hardware history found</h4></div>
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
<script>
$('#dataTable_hardwarehistory').DataTable({
        language: {
        paginate: {
            next: '<i class="fas fa-angle-right"></i>',
            previous: '<i class="fas fa-angle-left"></i>'  
        }
        
        },
        searching: false,
        "pageLength": 20
        
});
</script>

@endsection