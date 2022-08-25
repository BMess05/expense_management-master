

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
                                    <a href="{{route('editBeneficiary',$beneficiary->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                   
                                     @if($beneficiary->deleted_at==null)
                                    <a id="Are you sure, you want to archive this Beneficiary?" data-toggle="tooltip" title="Archive" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('deleteBeneficiary',$beneficiary->id)}}" class="btn btn-danger btn-sm"><i class="fas fa-arrow-down"></i></a>
                                    @else
                                     <a id="Are you sure, you want to Unarchive this Beneficiary?" data-toggle="tooltip" title="Unarchive" onclick="javascript:confirmationDelete($(this));return false;" href="{{route('unArchiveBeneficiary',$beneficiary->id)}}" class="btn btn-success btn-sm"><i class="fas fa-arrow-up"></i></a>

                                     @endif
                                   
                                    </th>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                        <button class="btn btn-primary btn-sm mt-3" id="show_all_records">Show All</button>
                       