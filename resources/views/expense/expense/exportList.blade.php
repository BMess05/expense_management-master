                        <!-- Projects table -->
                        <table class="table table-bordered" width="100%">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Category</th>
                                    <th scope="col" class="sort" data-sort="email">Amount</th>
                                    <th scope="col" class="sort" data-sort="email">Transaction Type</th>
                                    <th scope="col" class="sort" data-sort="email">Transaction Date</th>
                                    <th scope="col" class="sort" data-sort="email">Beneficiary</th>
                                    <th scope="col" class="sort" data-sort="email">Remarks</th>
                                   
                                </tr>
                            </thead>
                            <tbody class="list">
                                 @php {{$count=1;}} @endphp
                                @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $count++ }}</td>
                                    <td>{{ ($expense->category->name)??'' }}</td>
                                    @if($expense->type==2)
                                    <td class="text-success">{{ $expense->amount}}</td>
                                    @else
                                    <td class="text-danger">{{ $expense->amount}}</td>
                                    @endif

                                    <td>{{($expense->type==1)?'Debit':'Credit'}}</td>

                                    <td>{{ $expense->transaction_date }}</td>
                                    <td>{{ ($expense->beneficary->name)??'' }}</td>
                                    <td>{{ $expense->remarks }}</td>
                                    
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        