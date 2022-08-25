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
                            <h3 id="month-label">Attendance {{ date('F Y') }}</h3>
                                Select By Date : <input type="text" name="datefilter" value="" />
                                <button type="button" class="btn btn-sm btn-primary ml-3" onclick="$(reset());">Reset</button>
                            </div>
                        </div>

                    </div>


                    <div class="card-body table-responsive">
                        <div id="attendance-list">
                        @if(count($attendance) > 0)
                            @include('attendance.datepickerEmployee')
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
    var start_date;
    var end_date;

    $(function() {
        $('input[name="datefilter"]').daterangepicker({
            maxDate : new Date(),
            locale: {
                cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            start_date = picker.startDate.format('YYYY-MM-DD');;
            end_date = picker.endDate.format('YYYY-MM-DD');;
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

    });

    $(document).on('click', '.applyBtn', function() {
        $.ajax({
            type: 'get',
            url: "{{ route('attendance-index') }}",
            dataType: 'html',
            data: {
                'start_date': start_date,
                'end_date': end_date,
            },
            success: function(table_html) {
                $('#month-label').text('');
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