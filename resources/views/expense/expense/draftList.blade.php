@if(count($drafts)>0)
    <table class="table table-sm table-striped table-hover dataTable no-footer mt-0" id="dataTable">
        <thead>
            <tr>
                <th scope="col" class="sort" data-sort="name">Sr.no</th>
                <th scope="col" class="sort" data-sort="email">Account No</th>
                <th scope="col" class="sort" data-sort="email">Title</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="list">
            @php {{$count=1;}} @endphp
            @foreach($drafts as  $expense)
                <tr>
                    <td>{{ $count++ }}</td>
                    <td>{{ $expense->account_no }}</td>
                    <td>{{ $expense->title }}</td>
                    <th>
                        <a data-toggle="tooltip" title="View" href="{{route('editImport',$expense->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                        <a data-toggle="tooltip" title="Download" href="{{route('download',$expense->id)}}" class="btn btn-sm btn-primary "><i class="fa fa-download"> </i> </a>

                        <a id="Are you sure, you want to delete this record?" data-toggle="tooltip" title="Delete" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteDraft',$expense->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif