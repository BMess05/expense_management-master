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
                                    <a href="{{route('editCategory',$category->id)}}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit"><i class="fas fa-user-edit"></i></a>
                                   
                                   @if($category->deleted_at==null)
                                    <a id="Are you sure, you want to archive this category?" data-toggle="tooltip" title="Archive"onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteCategory',$category->id)}}/1" class="btn btn-danger btn-sm"><i class="fas fa-arrow-down"></i></a>
                                    @else
                                    <a id="Are you sure, you want to Unarchive this category?" data-toggle="tooltip" title="Unarchive"onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteCategory',$category->id)}}/2" class="btn btn-success btn-sm"><i class="fas fa-arrow-up"></i></a>
                                     @endif
                                   
                                    </th>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary btn-sm mt-3 show_all_records" id="show_all_records">Show All</button>
