@extends('layouts.main')
@section('content')
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                            <h3 class="mb-0">Attendance {{$date->format('d-m-y')}}</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{route('attendance-index')}}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>

                    </div>


                    <div class="card-body table-responsive">
                        
                        <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable">
                        <thead>
                                <tr>
                                    <th>Sr.no</th>
                                    <th>Punch In Time</th>
                                    <th>Punch Out Time</th>
                                    <th>Attendance Type</th>
                                    <th>Ip Address</th>
                                    <th>Device Type</th>
                                    <th>Browser</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                            @if(count($attendanceDetail) > 0)
                               @foreach ($attendanceDetail as $key => $atte)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $atte->created_at->format('H:i:s') ?? ''}}</td>
                                    <td>
                                       @if($loop->last && $atte->timer == 'Running')
                                       Timer Running
                                       @else
                                        {{ date('H:i:s', strtotime($atte->end_time)) ?? ''}}
                                        @endif
                                    </td>
                                    <td>
                                    @if($atte->type == 'Attendance')
                                    <span class="badge badge-success">Attendance</span>
                                    @elseif($atte->type == 'Break')
                                    <span class="badge badge-info">Break</span>
                                    @endif
                                    </td>
                                    <td>{{ $atte->ip_address ?? ''}}</td>
                                    <td>{{ $atte->device ?? ''}}</td>
                                    <td>{{ $atte->browser ?? ''}}</td>
                                </tr>
                               @endforeach
                            </tbody>
                           
                        </table>
                        @else
                                <tr>
                                    <td colspan="7">
                                        <div class="no-data-found"><h4>No Data Available</h4></div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
</div>
@endsection

@section('script')
@include('layouts.common_js')
@endsection