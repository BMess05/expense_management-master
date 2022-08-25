<table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
    <thead>
        <tr>
            <th scope="col" class="sort" data-sort="name">Sr.no</th>
            <th scope="col" class="sort" data-sort="name"> Month</th>
            <th scope="col" class="sort" data-sort="name">Year</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody class="list">
         @php {{$count=0;}} @endphp
        @foreach ($data as $key => $row)
        <tr>
            <td>{{ ++$count }}</td>
            <td>{{ $row->month_name ?? ""}}</td>
            <td>{{ $row->year ?? ""}}</td>
            <td class="d-flex">
            @can('salary-month-delete')
            <a href="{{ route('deleteSalaryMonth', $row->id) }}" class="btn btn-danger btn-sm delete-confirm" data-form="deleteForm-{{ $row->id }}"><i class="fas fa-trash"></i></a>
            @endcan
            @can('salary-month-detail')
            <a href="{{route('listSalaries',$row->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
            @endcan
            </td>
        </tr>
       @endforeach
    </tbody>

</table>
