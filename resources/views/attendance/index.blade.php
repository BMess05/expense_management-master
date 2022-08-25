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
                                <label><b>Attendance of : </b></label>
                                <input type="text" id="attendance_date" name="attendance_date" value="{{$date->format('m-d-y')}}" />
                                <button type="button" class="btn btn-sm btn-primary ml-3" onclick="$(reset());">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <div id="attendance-list">
                            @if(count($attendance) > 0)
                            @include('attendance.datepickerAdmin')
                            @else
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
                                    <tr>
                                        <td colspan="5">
                                            <div class="no-data-found">
                                                <h4>No Data Available</h4>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
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
<script>
    $(function() {
        $('input[name="attendance_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            maxDate: new Date(),
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'), 10)
        });
    });

    $(document).on('click', '.applyBtn', function() {
        var date = $('#attendance_date').val();
        $.ajax({
            type: 'get',
            url: "{{ route('attendance-index') }}",
            dataType: 'html',
            data: {
                'date': date
            },
            success: function(table_html) {
                $('#attendance-list').html('');

                $('#attendance-list').html(table_html);
                $('#dataTable').dataTable({
                    language: {
                        paginate: {
                            next: '<i class="fas fa-angle-right"></i>',
                            previous: '<i class="fas fa-angle-left"></i>'
                        }

                    },
                    "pageLength": 20
                });
            }
        })
    });

    function reset(){
    location.reload();
   }
</script>
@endsection