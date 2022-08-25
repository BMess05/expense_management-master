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
                            <h3 class="mb-0">Roles</h3>
                        </div>
                        @can('role-create')
                        <div class="col text-right"> 
                            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">Add Role</a>
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
                        @if(count($roles) > 0)

                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Role</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                        
                               @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                     
                                    @can('role-edit')
                                    <a href="{{route('roles.edit',$role->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                     
                                    @can('role-delete')
                                    <a id="Are you sure,you want to delete this role?" data-toggle="tooltip" title="Delete" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('roles.destroy',$role->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    @endcan
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>
                         <button class="btn btn-primary btn-sm mt-3 show_all_records" id="show_all_records">Show All</button>
                         @else
                           <div class="no-data-found"><h4>No data found</h4></div>
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
@endsection