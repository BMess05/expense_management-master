<table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Sr.no</th>
                                    <th scope="col" class="sort" data-sort="name"> Name</th>
                                    <th scope="col" class="sort" data-sort="name">Department</th>
                                    <th scope="col" class="sort d-none" data-sort="name">Position</th>
                                    <th scope="col" class="sort" data-sort="name">Role</th>
                                    <th scope="col">Actions</th>
                                    @can('user-change-status')
                                    <th scope="col">Status</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody class="list">
                                 @php {{$count=1;}} @endphp
                                @foreach ($data as $key => $user)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $user->name ?? ""}}</td>
                                    <td>{{ $user->department_data->name ?? ""}}</td>
                                    <td class="d-none">{{ $user->position_data->name ?? ""}}</td>
                                    <td>
                                      @if(!empty($user->getRoleNames()))
                                        @foreach($user->getRoleNames() as $v)
                                           <label class="badge badge-success">{{ $v ?? ""}}</label>
                                        @endforeach
                                      @endif
                                    </td>
                                    <td class="d-flex">
                                    @can('user-edit')
                                    <a href="{{route('users.edit',$user->id)}}" class="btn btn-info btn-sm"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('user-delete')
                                    @if($user->id != auth()->user()->id)
                                    <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm delete-confirm"
                                                data-form="deleteForm-{{ $user->id }}"><i class="fas fa-trash"></i></a>
                                           <a href="#">
                                           <form id="deleteForm-{{ $user->id }}"
                                                action="{{ route('users.destroy', $user->id) }}"
                                                method="post">
                                                @csrf @method('DELETE')
                                            </form>
                                           </a>
                                   @endif
                                    @endcan
                                    @can('user-detail')
                                    <a href="{{route('user-detail',$user->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                    @endcan
                                    </td>
                                    <td>
                                    @can('user-change-status')
                                    <input type="button" user-id="{{ $user->id }}"
                                                status="{{ $user->status == 1 ? 0 : 1 }}"
                                                value="{{ $user->status == 1 ? 'Activated' : 'Deactivated' }}"
                                                class="changeStatus status-{{$user->id}} btn btn-{{ $user->status == 1 ? 'success' : 'danger' }} btn-sm">
                                    @endcan
                                    </td>
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>