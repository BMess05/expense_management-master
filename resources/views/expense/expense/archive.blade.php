<table class="table table-sm table-striped table-hover dataTable no-footer mt-0" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Category</th>
                                    <th scope="col" class="sort" data-sort="email">Amount</th>
                                    <th scope="col" class="sort" data-sort="email">Transaction Date</th>
                                    <th scope="col" class="sort" data-sort="email">Beneficiary</th>
                                    <th scope="col" class="sort" data-sort="email">Remarks</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                 @php {{$count=1;}} @endphp
                                @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ ($expense->category)?$expense->category->name:'' }}</td>
                                    @if($expense->type==2)
                                    <td class="text-success" data-toggle="tooltip" title="Credit">{{ $expense->amount}}</td>
                                    @else
                                    <td class="text-danger" data-toggle="tooltip" title="Debit">{{ $expense->amount}}</td>
                                    @endif

                                    <td>{{$expense->transaction_date}}</td>
                                    <td>{{ ($expense->beneficary->name)??'' }}</td>
                                    <td>{{ $expense->remarks }}</td>
                                    <th>
                                    <a data-toggle="tooltip" title="Edit" href="{{route('editExpense',$expense->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>

                                   @if($expense->deleted_at==null)
                                    <a id="Are you sure, you want to archive this bank account?" data-toggle="tooltip" title="Archive"onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteExpense',$expense->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-arrow-down"></i></a>
                                    @else
                                    <a id="Are you sure, you want to unarchive this bank account?" data-toggle="tooltip" title="Unarchive"onclick="javascript:confirmationDelete($(this));return false;" href="{{route('unArchiveExpense',$expense->id)}}" class="btn btn-success btn-sm"><i class="fas fa-arrow-up"></i></a>

                                    @endif
                                   
                                    </th>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary btn-sm mt-3" id="show_all_records">Show All</button>