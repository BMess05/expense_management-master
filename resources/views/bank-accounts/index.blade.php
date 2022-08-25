
<table class="table table-sm table-striped table-hover no-footer">
                            <thead>
                                <tr>
                                    <th>Sr.no</th>
                                    <th>Bank Name</th>
                                    <th>Account Holder</th>
                                    <th>Account Number</th>
                                    <th>IFSC code</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                            @if(count($banks) > 0)
                                 @php {{$i=0;}} @endphp
                                @foreach ($banks as $key => $bank)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $bank->bank_name ?? ""}}</td>
                                    <td>{{ $bank->ac_holder ?? ""}}</td>
                                    <td>{{ $bank->account_no ?? ""}}</td>
                                    <td>{{ $bank->ifsc_code ?? ""}}</td>
                                    <td class="d-flex">
                                    @can('user-bank-ac-edit')
                                    <a data-id="{{$bank->id}}" class="btn btn-info btn-sm text-white edit-bank" data-toggle="modal"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('user-bank-ac-delete')
                                    <a data-id="{{$bank->id}}" class="btn btn-danger btn-sm text-white delete-bank"><i class="fas fa-trash"></i></a>
                                    @endcan
                                    </td>
                                </tr>
                               @endforeach
                               @else
                                <tr>
                                    <td colspan="6">
                                        <div class="no-data-found"><h4>No Data Available</h4></div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                           
                        </table>