<table class="table table-sm table-striped table-hover no-footer">
    <thead>
        <tr>
            <th>Sr.no</th>
            <th>Document Name</th>
            <th>Issued Date</th>
            <th>Document</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="list">
        @if($documents->count() > 0)
        @php {{$i=0;}} @endphp
        @foreach ($documents as $key => $document)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $document->doc_name ?? ""}}</td>
            <td>{{ date('d-m-Y',strtotime($document->issued_date)) ?? ""}}</td>
            <td>
                @can('user-documents-view')
                <a class="btn btn-primary btn-sm text-white" href="{{ asset('uploads/issued-documents/' . $document->document) }}" target="_blank">View Document</a>
                @endcan
            </td>
            <td class="d-flex">
                @can('user-documents-edit')
                <a data-id="{{$document->id}}" class="btn btn-info btn-sm text-white edit-document" data-toggle="modal"><i class="fas fa-user-edit"></i></a>
                @endcan
                @can('user-documents-delete')
                <a data-id="{{$document->id}}" class="btn btn-danger btn-sm text-white delete-document"><i class="fas fa-trash"></i></a>
                @endcan
            </td>
        </tr>
        @endforeach
        @else
        <tr>
            <td colspan="6">
                <div class="no-data-found">
                    <h4>No Data Available</h4>
                </div>
            </td>
        </tr>
        @endif
    </tbody>

</table>