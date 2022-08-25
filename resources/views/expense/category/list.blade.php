@extends('layouts.main')
@section('content')
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0">Categories</h3>
                            </div>
                            @can('category-create')
                            <div class="col text-right"> 
                                <a href="{{route('addCategory')}}" class="btn btn-sm btn-primary">Add Category</a>
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

                        

                         <form method="post" id="category" action="{{route('archiveCategory')}}">
                          <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="customCheck1" onclick="showArchived(event)">
                              <label class="custom-control-label" for="customCheck1">Show Archived Categories</label>
                           </div>
                         </form>
                        
                      
                        <!-- Projects table -->
                        <div id="abc">
                        
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                 @php {{$count=1;}} @endphp
                                @foreach($categories as $category)
                                <tr>
                                    <th class="number">{{ $count++ }}</th>
                                    <th>{{ $category->name }}</th>
                                    <th>
                                    @can('category-edit')
                                    <a href="{{route('editCategory',$category->id)}}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('category-delete')
                                    <a id="Are you sure, you want to archive this category?" data-toggle="tooltip" title="Archive"onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteCategory',$category->id)}}/1" class="btn btn-danger btn-sm"><i class="fas fa-arrow-down"></i></a>
                                    @endcan
                                   
                                    </th>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                          <button class="btn btn-primary btn-sm mt-3 show_all_records" id="show_all_records">Show All</button>
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

    function confirmation(anchor) {
        let block=anchor.attr("id");
        let title=(block==1)?"Are you sure want to unpublish this Category?":"Are you sure want to publish this Category?"
        
        swal({
            title: title,
           // text: "Once deleted, you will not be able to recover this data!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                window.location = anchor.attr("href");
            }
        });
    }


    // function myFunction(item, index) {
    //     console.log('called');
    //     var myRow=`<tr>
    //                 <th class="number">0</th>
    //                 <th>${item.name}</th>
    //                 <th>
    //                 <a href="{{url('categories/edit') }}/${item.id}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                   
    //                 <a data-toggle="tooltip" title="Unarchive" onclick="javascript:confirmationDelete($(this));return false;" href="{{url('categories/delete') }}/${item.id}/2" class="btn btn-success btn-sm" id=2><i class="fas fa-arrow-up"></i></a>
                                   
    //                 </th>
    //               </tr>`;
    //    // $('#dataTable').find('tbody').append(myRow);

    //     var table = $('#dataTable').DataTable();
      
    //     table.on('order.dt search.dt', function () {
    //          table.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
    //              cell.innerHTML = i + 1;
            
    //          });
    //     }).draw();
        
    //     var rowNode =  table.row.add($(myRow)).draw().order([0, 'desc']).node();
    //     $( rowNode )
    //       .css( 'color', 'red' )
    //       .animate( { color: 'black' } );
    // }

    
 
</script>
@endsection