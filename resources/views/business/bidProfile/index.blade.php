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
                            <h3 class="mb-0">Bid Profiles</h3>
                        </div>
                        @can('bid-profile-create')
                        <div class="col text-right"> 
                            <a href="{{route('bidprofile.create')}}" class="btn btn-sm btn-primary">Add Profile</a>
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
                        @if(count($bidprofile) > 0)

                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Profile Name</th>
                                    <th scope="col" class="sort" data-sort="name">Profile Email</th>
                                    <th scope="col" class="sort" data-sort="name">Profile Url</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($bidprofile as $key => $bid)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $bid->name }}</td>
                                    <td>{{ $bid->email }}</td>
                                    @php
                                        $url = $bid->url;
                                        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                                            $url = "http://" . $url;
                                        }

                                    @endphp
                                    <td><a target="_blank" href="{{ $url }}">{{ $bid->url}}</a></td>
                                    <td>
                                    <button data-toggle="modal" data-target="#view_{{$bid->id}}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></button>
                                        <div class="modal fade" data-backdrop="" id="view_{{$bid->id}}"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Profile Info</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">
                                                                <h3 class="panel-title"></h3>
                                                            </div>
                                                            <div class="panel-body">
                                                            <div class="col-sm-12">
                                                                    <div class="row">
                                                                        <div class="col-sm-5"><p> Profile Name</p></div>
                                                                        <div class="col-sm-7"><p>{{$bid->name}}</p></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-5"><p>Profile Url</p></div>
                                                                        <div class="col-sm-7"><p>{{$bid->url}}</p></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-5"><p> Email</p></div>
                                                                        <div class="col-sm-7"><p>{{$bid->email}}</p></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-5"><p>Username</p></div>         
                                                                        <div class="col-sm-7"><p>{{$bid->username}}
                                                                        </p></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-5"><p>Password</p> </div>    
                                                                        <div class="col-sm-7"><p>{{$bid->password}}</p></div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-sm-5"><p>Security Question </p></div>    
                                                                        <div class="col-sm-7"><p>{{$bid->password}}</p></div>
                                                                    </div>
                                                                    <div class="row">
                                                                    <div class="col-sm-5"><p>Security Answer</p></div>
                                                                        <div class="col-sm-7"><p>
                                                                        {{$bid->security_answer}}</p> </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">OK</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @can('bid-profile-edit')
                                    <a href="{{route('bidprofile.edit',$bid->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('bid-profile-delete')
                                    <a id="Are you sure,you want to delete this bid?" data-toggle="tooltip" title="Delete" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('bidprofile.destroy',$bid->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    @endcan
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>
                         
                         @else
                           <div class="no-data-found"><h4>No bid profile found</h4></div>
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