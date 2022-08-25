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
                            <h3 class="mb-0">Projects</h3>
                        </div>
                        <div class="col text-right"> 
                            <a href="{{route('projects.create')}}" class="btn btn-sm btn-primary">Add Project</a>
                        </div>
                       
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        @include('flash-message')

                      
                        <!-- Projects table -->
                        <div id="abc">
                        @if(count($projects) > 0)

                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name"> Client Name</th>
                                     <th scope="col" class="sort" data-sort="name"> Project Name</th>
                                    <th scope="col" class="sort" data-sort="name">Start Date</th>
                                    <th scope="col" class="sort" data-sort="name">End Date</th>
                                    <th scope="col" class="sort" data-sort="name">Payment Received</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($projects as $key => $project)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $project->client_name }}</td>
                                    <td>{{ $project->project_name }}</td>
                                    <td>{{ $project->start_date }}</td>
                                    <td>{{ $project->end_date }}</td>
                                    <td>{{ $project->payment_received }}</td>
                                    <td>
                                    
                                     <a href="{{route('projects.show',$project->id)}}" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>

                                     <a href="{{route('projects.edit',$project->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                   
                                   
                                    <a id="Are you sure, you want to delete this project?" data-toggle="tooltip" title="Delete" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('projects.delete',$project->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                   
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>
                         
                         @else
                           <div class="no-data-found"><h4>No Projects found</h4></div>
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