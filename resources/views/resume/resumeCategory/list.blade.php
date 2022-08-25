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
                            <h3 class="mb-0">Resume Categories</h3>
                        </div>
                        @can('resume-category-create')
                        <div class="col text-right"> 
                            <a href="{{route('addResumeCategory')}}" class="btn btn-sm btn-primary">Add  Category</a>
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
                                    <th scope="col" class="sort" data-sort="name">Category name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php {{$count=1;}} @endphp
                                @foreach($resumes as $resume)
                                <tr>
                                    <th>{{ $count++ }}</th>
                                    <th>{{ $resume->category_name }}</th>
                                    <th>
                                    @can('resume-category-edit')
                                    <a href="{{route('editResumeCategory',$resume->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                   
                                    @endcan
                                    @can('resume-category-delete')
                                    <a id="Are you sure want to delete this category?" data-toggle="tooltip" title="delete" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteResumeCategory',$resume->id)}}/1" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                    @endcan
                                    </th>
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