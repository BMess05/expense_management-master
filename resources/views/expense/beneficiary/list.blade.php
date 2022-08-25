@extends('layouts.main')
@section('content')
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-Beneficiaries-center">
                        <div class="col">
                            <h3 class="mb-0">Beneficiaries</h3>
                        </div>
                        @can('beneficiary-create')
                        <div class="col text-right"> 
                            <a href="{{route('addBeneficiary')}}" class="btn btn-sm btn-primary">Add Beneficiary</a>
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

                         <form method="post" id="category">
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="customCheck11" onclick="showArchived(event)">
                              <label class="custom-control-label" for="customCheck11">Show Archived Beneficiaries</label>
                           </div>
                         </form>

                        <div id="abc">
                        @if(count($beneficiaries) > 0)

                        <!-- Projects table -->
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Beneficiary name</th>
                                    <th scope="col" class="sort" data-sort="email">Notes</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                 @php {{$count=1;}} @endphp
                                @foreach($beneficiaries as $beneficiary)
                                <tr>
                                    <th>{{ $count++ }}</th>
                                    <th>{{ $beneficiary->name }}</th>
                                    <th>{{ $beneficiary->notes }}</th>
                                    <th>
                                    @can('beneficiary-edit')
                                    <a data-toggle="tooltip" title="Edit" href="{{route('editBeneficiary',$beneficiary->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('beneficiary-delete')
                                    <a id="Are you sure, you want to archive this Beneficiary ?" data-toggle="tooltip" title="Archive" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteBeneficiary',$beneficiary->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-arrow-down"></i></a>
                                    @endcan
                                    </th>
                                </tr>
                               @endforeach
                            </tbody>

                        </table>
                        <button class="btn btn-primary btn-sm mt-3" id="show_all_records">Show All</button>
                         @else
                           <div class="no-data-found"><h4>No Beneficiaries found</h4></div>
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