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
                            <h3 class="mb-0">Status Report</h3>
                        </div>
                        <div class="col text-right"> 
                            <a href="{{route('statusreport.create')}}" class="btn btn-sm btn-primary">Add Report</a>
                        </div>
                       
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        @include('flash-message')

                      
                        <!-- Projects table -->
                        <div id="abc">
                        @if(count($reports) > 0)

                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name"> Title</th>
                                    <th scope="col" class="sort" data-sort="name">Report</th>
                                    <th scope="col" class="sort" data-sort="name"> Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($reports as $key => $report)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $report->title }}</td>
                                    <td style="white-space: inherit;">{{ $report->report }}</td>
                                    <td>{{ $report->date }}</td>
                                    <td>
                                    
                                     <a href="{{route('statusreport.edit',$report->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                   
                                   
                                    <a id="Are you sure, you want to delete this project?" data-toggle="tooltip" title="Delete" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('statusreport.destroy',$report->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                   
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>
                         
                         @else
                           <div class="no-data-found"><h4>No Reports found</h4></div>
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