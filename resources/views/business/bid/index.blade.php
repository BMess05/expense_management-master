@extends('layouts.main')
@section('content')
<style>
.bid_dropdown_status .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover{
    border: none !important;
    background: transparent !important;
}
.cmnts-count{
    font-size: 10px;
}
.filled-star{
    color:#f5e31c;
}
</style>
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-banks-center">
                        <div class="col">
                            <h3 class="mb-0">Bids</h3>
                        </div>
                        @can('bid-create')
                        <div class="col text-right">
                            <a href="{{route('bids.create')}}" class="btn btn-sm btn-primary">Add Bid</a>
                        </div>
                        @endcan

                        </div>
                    </div>
                    <div class="card-body table-responsive">
                      @if(session('success'))
                            <div class="alert alert-{{ Session::get('success') }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        @if(session('status'))
                            <div class="alert alert-{{ Session::get('status') }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        @include('business.bid.filter')

                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" data-id="1" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true">My Bids</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" data-id="2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">Other Bids</a>
                                </li>

                            </ul>
                        </div>
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">

                                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                        <div id="abc22">
                                            @if(count($mybids) > 0)
                                            <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable11">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="sort" data-sort="name" style="width: 7% !important;">Sr.no</th>
                                                        <th scope="col" class="sort" data-sort="name">Profile</th>
                                                        <th scope="col" class="sort" data-sort="name">Job ID</th>
                                                        <th scope="col" class="sort" data-sort="name">Job Type</th>
                                                        <th scope="col" class="sort" data-sort="name">Bid Amount</th>
                                                        <th scope="col" class="sort" data-sort="name" style="width: 200px;">Bid Status</th>
                                                        <th scope="col" class="sort" data-sort="name">Created Date</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    @foreach ($mybids as $key => $bid) @php $url = $bid->bid_url; if (!preg_match("~^(?:f|ht)tps?://~i", $url)) { $url = "http://" . $url; } @endphp
                                                    <tr>
                                                        <td class="dt_th_width">{{ ++$i }}</td>
                                                        <td>{{($bid->bidprofile()->exists())?$bid->bidprofile->name:''}}</td>
                                                        <td>{{ $bid->job_id }}</td>
                                                        {{--
                                                        <td>{{ ucfirst($bid->biduser->name) }}</td>
                                                        --}}
                                                        @if($bid->job_type == 1)
                                                        <td>Hourly</td>
                                                        @else
                                                        <td>Fixed</td>
                                                        @endif
                                                        <td>{{ $bid->bid_amount }}</td><td>
                                                            <select  class="form-control form-control-sm bid_status_dropdown" data-native-menu="false" name="bid_status" data-tab="mybids" data-id="{{$bid->id}}">
                                                                @php $option_value ='';@endphp
                                                                @foreach($business_color_setting as $colors)

                                                                    @if($colors['key'] == 0)
                                                                       @php $option_value = 'No Response';@endphp
                                                                    @endif
                                                                    @if($colors['key'] == 1)
                                                                       @php $option_value = "Client Responded";@endphp
                                                                    @endif
                                                                    @if($colors['key'] == 2)
                                                                        @php $option_value = "Declined";@endphp
                                                                    @endif
                                                                    @if($colors['key'] == 3)
                                                                        @php $option_value = "Project Hired";@endphp
                                                                    @endif
                                                                    @if($colors['key'] == 4)
                                                                        @php $option_value = "Hot Lead";@endphp
                                                                    @endif
                                                                    <option value="{{ $colors['key']}}" rgb="{{ $colors['value']}}"  @if($bid->bid_status == $colors["key"]) selected @endif> {{$option_value}}</option>

                                                                @endforeach

                                                                 </select>
                                                        </td>
                                                        <td>{{ date('d-m-Y', strtotime($bid->created_at)) }}</td>

                                                        <td>
                                                            @can('bid-edit')
                                                            @if($bid->user_id == auth()->user()->id)
                                                            <a href="{{route('bids.edit',$bid->id)}}" class="btn btn-info btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                                           @endif
                                                            @endcan 
                                                            @can('bid-delete')
                                                            @if($bid->user_id == auth()->user()->id)
                                                            <a
                                                                id="Are you sure, you want to delete this bid?"
                                                                data-toggle="tooltip"
                                                                title="Delete"
                                                                onclick="javascript:confirmationDelete($(this));return false;"
                                                                href="{{route('bids.destroy',$bid->id)}}"
                                                                class="btn btn-danger btn-sm"
                                                            >
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                            @endif
                                                            @endcan
                                                            @if($bid->user_id != auth()->user()->id)
                                                            <a class="btn btn-success btn-sm favourite bid_id-{{$bid->id}}" id="favourite" title="Remove Favourite" data-id="{{$bid->id}}" data-status="0"><i class="fas fa-star filled-star"></i></i></a>
                                                            @endif
                                                            <a target="_blank" class="btn btn-sm btn-default" href="{{ $url }}">Open Link</a>
                                                            <a class="btn btn-success btn-sm" id="{{$bid->id}}" title="Copy Link" onclick="copyLink('{{$bid->id}}','{{$bid->bid_url}}')"><i class="fas fa-clipboard"></i></a>
                                                            <a href="{{route('bid-comments',$bid->id)}}" class="btn btn-info btn-sm">Comments <span class="badge bg-danger text-white cmnts-count"><b>{{$bid->is_read_bid_comments->count()}}</b></span></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            @else
                                            <div class="no-data-found"><h4>No bids found</h4></div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                        <div id="abc2">
                                            @if(count($otherbids) > 0 )

                                            <table class="table table-sm table-striped table-hover dataTable no-footer" id="dataTable2">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="sort" data-sort="name" style="width: 7% !important;">Sr.no</th>
                                                        <th scope="col" class="sort" data-sort="name">Profile</th>
                                                        <th scope="col" class="sort" data-sort="name">Bid Owner</th>
                                                        <th scope="col" class="sort" data-sort="name">Job ID</th>
                                                        <th scope="col" class="sort" data-sort="name">Created Date</th>
                                                        <th scope="col" class="sort" data-sort="name">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="list">
                                                    @foreach ($otherbids as $key => $bid) @php $url = $bid->bid_url; if (!preg_match("~^(?:f|ht)tps?://~i", $url)) { $url = "http://" . $url; } @endphp
                                                    <tr>
                                                        <td>{{ ++$i }}</td>
                                                        <td>{{($bid->bidprofile()->exists())?$bid->bidprofile->name:''}}</td>
                                                        <td>{{($bid->biduser()->exists())?ucfirst($bid->biduser->name):''}}</td>
                                                        <td>{{ $bid->job_id }}</td>
                                                        <td>
                                                            {{ date('d-m-Y', strtotime($bid->created_at)) }}
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-success btn-sm text-white favourite bid_id-{{$bid->id}}" title="Favourite Bid" id="favourite" data-id="{{$bid->id}}" data-status="1"><i class="fas fa-star"></i></i></a>
                                                            <a target="_blank" class="btn btn-sm btn-default" href="{{ $url }}">Open Link</a>
                                                            <a class="btn btn-success btn-sm" id="{{$bid->id}}" title="Copy Link" onclick="copyLink('{{$bid->id}}','{{$bid->bid_url}}')"><i class="fas fa-clipboard"></i></a>
                                                            <a href="{{route('bid-comments',$bid->id)}}" class="btn btn-info btn-sm">Comments <span class="badge bg-danger text-white cmnts-count"><b>{{$bid->is_read_bid_comments->count()}}</b></span></i></a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            @else
                                            <div class="no-data-found"><h4>No bids found</h4></div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
@endsection
@section('script')
@include('layouts.common_js')
<script type="text/javascript">
    function copyLink(button_id,bid_url){

       var inputc = document.body.appendChild(document.createElement("input"));
        inputc.value =  bid_url;
        inputc.focus();
        inputc.select();
        document.execCommand('copy');
        inputc.parentNode.removeChild(inputc);
        console.log(button_id,'button');
        var x = document.getElementById(button_id);
        $('#'+button_id).html('Copied.');
        setTimeout(function(){ $('#'+button_id).html('<i class="fas fa-clipboard"></i>'); }, 2000);
    }
    $(document).ready(function(){
        $.widget("custom.colorselectmenu", $.ui.selectmenu, {
              _renderButtonItem: function(item) {
                    var rgb = item.element.attr("rgb");
                    var bgColorStyle = 'color: ' + rgb;
                    var fullStyle = "  margin-right: 7px;font-weight: 500;" + bgColorStyle + " !important;";
                    return $('<span>', {

                    text: item.label,
                    style: fullStyle
                    }).prepend();
                },

            _renderItem: function( ul, item ) {
                var li = $("<li>");
                var rgb = item.element.attr("rgb");
                var bgColorStyle = 'color: ' + rgb;
                var fullStyle = "  margin-right: 7px;font-weight: 500;" + bgColorStyle + " !important;";
                $( "<div>", {
                style: fullStyle,
                text: item.label
                })
                .appendTo( li );
                return li.appendTo( ul );

            }



        });

        activaTab();
        $('#dataTable11').DataTable().state.clear();
        var resetValue = '<?= \Auth::user()->reset ?>';
        if (resetValue == 'true') {
          var url= document.location.href;
          window.history.pushState({}, "", url.split("?")[0]);
        }
        function activaTab(){
            var tab_val = '<?= Session::get('tab')?>';
            if (tab_val == 'otherbids') {
                var tab = 'tabs-icons-text-2';
                $('.nav-pills a[href="#' + tab + '"]').trigger('click');
            }
        };
        $('.user_div').css('display','none');

        $('.nav-pills a').click(function(){
            $(this).tab('show');
        });

        $('.nav-pills a').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("data-id") // activated tab
        if(target == 2){ // second tab
            $('#bid_page').val('otherbids');
            $('#tab_value').val('otherbids');
            $('.user_div').css('display','block');

        }else{
            $('#bid_page').val('mybids');
            $('#tab_value').val('mybids');
            $('.user_div').css('display','none');
            $('#user_id').val('');
        }
        });
         $(".bid_status_dropdown").colorselectmenu({ change: function( event, ui ) {

            var bid_id =$(this).data('id');
            var bid_value = $(this).val();
            var bid_page =$(this).data('tab');

            swal.fire({
                title: "Are you sure,you want to change the bid status??",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                        $.ajax({
                            method: 'POST',
                            url: 'bid/status',
                            data: {'bid_page':bid_page,'id' : bid_id, 'bid_status' : bid_value,"_token": "{{ csrf_token() }}"},
                            success: function(response){

                                console.log(response.success);
                                if(response.success == true){
                                    window.location.href = "bids";
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {

                            }
                        });
                }else {
                    return false;
                }
            });
        }}).colorselectmenu();

    });


    $(function() {


        $( "#datepickerbid" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            onClose: function( selectedDate ) {
                $( "#datepickerbid2" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#datepickerbid2" ).datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
            onClose: function( selectedDate ) {
                $( "#datepickerbid" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
    });
   
    var table11 = $('#dataTable11').DataTable({
        language: {
        paginate: {
            next: '<i class="fas fa-angle-right"></i>',
            previous: '<i class="fas fa-angle-left"></i>'
        }

        },
        searching: false,
        "pageLength": 20,
        "bStateSave": true,

    });
    $('#dataTable2').DataTable({
        language: {
        paginate: {
            next: '<i class="fas fa-angle-right"></i>',
            previous: '<i class="fas fa-angle-left"></i>'
        }

        },
        searching: false,
        "pageLength": 20

    });

$(document).on('click', '.favourite',function(event){
    event.preventDefault();
    var bid_id = $(this).attr("data-id");
    var status = $(this).attr("data-status");
    if(status == 1){
        var message = "Are you sure you want to favourite this bid?";
    }else{
        var message = "Are you sure you want to remove this bid from favourites?";
    }
    swal.fire({
        title: message,
        showCancelButton: true,
        confirmButtonColor: '#3085D6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
    }).then(function(value) {
        if (value.isConfirmed) {
            $('.loader').show();
            $.ajax({
                url: "{{ route('favourite-bids') }}",
                type: 'get',
                data: {
                    'bid_id': bid_id,
                    'status': status,
                },
                success: function(data) {
                    $('.loader').hide()
                    if(status == 1){
                        $(`.bid_id-${bid_id}`).attr('data-status', 0);
                        $(`.bid_id-${bid_id}`).html('<i class="fas fa-star filled-star">');
                        $(`.bid_id-${bid_id}`).attr('title', 'Remove Favourite');
                    }else{
                        $(`.bid_id-${bid_id}`).attr('data-status', 1);
                        $(`.bid_id-${bid_id}`).html('<i class="fas fa-star text-white">');
                        $(`.bid_id-${bid_id}`).attr('title', 'Favourite Bid');
                    }
                },
            })
        } else {
            // window.location.href = window.location.href;
        }
    });
});
</script>
@endsection
