<table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Sr.no</th>
                                    <th>Employee</th>
                                    <th>Attendance Time</th>
                                    <th>Break Time</th>
                                    <th>Detail</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($attendance as $key => $atte)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $atte->user->name }}</td>
                                    @if($atte->total_attendance_time < 28800) <td class="text-danger">{{ totalTime($atte->total_attendance_time) }}</td>
                                        @else
                                        <td>{{ totalTime($atte->total_attendance_time) }}</td>
                                        @endif
                                        <td>{{ totalTime($atte->total_break_time) }}</td>
                                        <td><a href="{{route('attendance-detail',$atte->id)}}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>