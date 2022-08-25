<table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name">Bank name</th>
                                    <th scope="col" class="sort" data-sort="name">Company Name</th>
                                    <th scope="col" class="sort" data-sort="email">Account No.</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                 @php {{$count=1;}} @endphp
                                @foreach($banks as $bank)
                                <tr>
                                    <th>{{ $count++ }}</th>
                                    <th>{{ $bank->bank_name }}</th>
                                    <th>{{ $bank->company_name }}</th>
                                    <th>{{ $bank->account_no }}</th>
                                    <th>
                                    <a href="{{route('editBankAccount',$bank->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                   
                                    @if($bank->deleted_at==null)
                                    <a id="Are you sure, you want to archive this bank account?" data-toggle="tooltip" title="Archive" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteBankAccount',$bank->id)}}/1" class="btn btn-danger btn-sm"><i class="fas fa-arrow-down"></i></a>
                                     @else
                                     <a id="Are you sure, you want to unarchive this bank account?" data-toggle="tooltip" title="Unarchive" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteBankAccount',$bank->id)}}/2" class="btn btn-success btn-sm"><i class="fas fa-arrow-up"></i></a>
                                     @endif
                                   
                                    </th>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary btn-sm mt-3" id="show_all_records">Show All</button>