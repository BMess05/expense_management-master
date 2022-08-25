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
                            <h3 class="mb-0">Resumes</h3>
                        </div>
                        @can('resume-create')
                        <div class="col text-right"> 
                            <a href="{{route('addResume')}}" class="btn btn-sm btn-primary">Add Resume</a>
                        </div>
                        @endcan
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        @if(session('status'))
                            <div class="alert alert-{{ Session::get('status') }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ Session::get('message') }}
                            </div>
                        @endif

                        <!-- Projects table -->
                        <div id="abc">
                        @if(count($resumes) > 0)

                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Candidate name</th>
                                    <th scope="col" class="sort" data-sort="name">Experience</th>
                                    <th scope="col" class="sort" data-sort="email">Category</th>
                                    <th scope="col" class="sort" data-sort="email">Interview Date</th>
                                    <th scope="col" class="sort" data-sort="email">Reason For Rejection</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                 @php {{$count=1;}} @endphp
                                @foreach($resumes as $resume)
                                <tr>
                                   <td>{{ $count++ }}</td>
                                   <td>{{ $resume->name }}</td>
                                   <td>{{ $resume->experience->experience }}</td>
                                     @forelse($resume['categories'] as $cat)
                                   <td>{{ ($cat->category_name)}}</td>
                                    @empty
                                    <td></td>
                                    @endforelse
                                   <td>{{ $resume->interview_date }}</td>
                                    <td class="reason_for_rejection">{{ $resume->reason_for_rejection }}</td>
                                    <td>
                                    @can('resume-edit')
                                    <a href="{{route('editResume',$resume->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    <a data-toggle="tooltip" title="Download" href="{{route('downloadResume',$resume->id)}}" class="btn btn-sm btn-primary "><i class="fa fa-download"> </i> </a>
                                    @can('resume-delete')
                                    <a id="Are you sure want to delete this Resume?" data-toggle="tooltip" title="Delete" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteResume',$resume->id)}}/1" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    @endcan
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>
                        
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