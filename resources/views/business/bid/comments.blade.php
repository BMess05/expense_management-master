@extends('layouts.main')
@section('content')
<style>
    .card-footer.text-muted.d-flex.justify-content-start.align-items-center.p-0 {
        border-radius: 7px;
    }
    .image-upload{
        position:relative;
    }
    .hide-file {
        visibility: hidden;
        position: absolute;
    }

    .image-list {
        list-style: none;
    }

    .image-list p {
        font-size: 13px;
        font-weight: bold;
        cursor: pointer;
    }

    .image-list li {
        width: 90px;
    }

    .fixed {
        width: 100%;
        border: 2px solid #ccc;
    }
    .info p{
        margin-right: 30px;
    }
    .preserveLines {
    white-space: pre-wrap;
}
.card{
    margin-bottom: 15px;
}
</style>
<section class="pt-3">
    <div class="container w-75 d-flex info">
    <p><b>Profile Name :</b> {{$bid->bidprofile->name}}</p>
    <p><b>Job Id :</b> {{$bid->job_id}}</p>
    <p><b>Bid Owner :</b> {{$bid->biduser->name}}</p>
    </div>
    <div class="pt-5" id="chat" style="background-color: #f8f9fe; height:65vh; overflow-y: auto; overflow-x:hidden">

        <div class="row">
            <div class="col-md-12 px-0">
                <div class="px-4">
                    <ul class="list-unstyled">
                        @foreach($bidCmnts as $cmnts)
                        @if($cmnts->user_id == auth()->user()->id)
                        <li class="d-flex justify-content-end">
                            <div class="card" style="max-width:75%; box-shadow: 0px 0px 6px 0px darkgrey">
                                <div class="card-header d-flex justify-content-between p-1">
                                    <p class="mr-5 mb-0" style="font-weight:600">{{$cmnts->user->name}}</p>
                                    <p class="text-muted mb-0"><i class="far fa-clock"></i>&nbsp;<b>{{$cmnts->created_at->format('d-m-Y H:i:s')}}</b></p>
                                </div>
                                <div class="card-body p-2">
                                    <p class="mb-0">
                                    <b>{!! nl2br(e($cmnts->comment))!!}</b>
                                    </p><br>
                                    <div>
                                        @foreach ($cmnts->bid_comment_images as $images)
                                        @if (pathinfo($images->file_name, PATHINFO_EXTENSION) == 'pdf')
                                        @if(!empty($data->image))
                                        <a href="{{ asset('uploads/business/bid-comments/' . $images->file_name) }}" target="_blank"><img src="{{asset('assets/img/pdf.png')}}" width="100px" title="{{$images->file_name}}" alt="Pdf not found" class="mr-2"></a>
                                        @else
                                        <a href="{{ asset('uploads/business/bid-comments/' . $images->file_name) }}" target="_blank"><img src="" width="100px" title="{{$images->file_name}}" alt="Pdf not found" class="mr-2"></a>
                                        @endif
                                        @else
                                        <a href="{{ asset('uploads/business/bid-comments/' . $images->file_name) }}" target="_blank"><img src="{{ asset('uploads/business/bid-comments/' . $images->file_name) }}" width="100px" alt="Image not found" class="mr-2"></a>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                        @else
                        <li class="d-flex justify-content-between">
                            <div class="card" style="max-width:75%; box-shadow: 0px 0px 6px 0px darkgrey">
                                <div class="card-header d-flex justify-content-between p-1">
                                    <p class="mr-5 mb-0" style="font-weight:600">{{$cmnts->user->name}}</p>
                                    <p class="text-muted mb-0"><i class="far fa-clock"></i>&nbsp;<b>{{$cmnts->created_at->format('d-m-Y H:i:s')}}</b></p>
                                </div>
                                <div class="card-body p-2">
                                    <p class="mb-0">
                                        <b>{!! nl2br(e($cmnts->comment))!!}</b>
                                    </p><br>
                                    <div>
                                        @foreach ($cmnts->bid_comment_images as $images)
                                        @if (pathinfo($images->file_name, PATHINFO_EXTENSION) == 'pdf')
                                        @if(!empty($data->image))
                                        <a href="{{ asset('uploads/business/bid-comments/' . $images->file_name) }}" target="_blank"><img src="{{asset('assets/img/pdf.png')}}" width="100px" title="{{$images->file_name}}" alt="Pdf not found" class="mr-2"></a>
                                        @else
                                        <a href="{{ asset('uploads/business/bid-comments/' . $images->file_name) }}" target="_blank"><img src="" width="100px" title="{{$images->file_name}}" alt="Pdf not found" class="mr-2"></a>
                                        @endif
                                        @else
                                        <a href="{{ asset('uploads/business/bid-comments/' . $images->file_name) }}" target="_blank"><img src="{{ asset('uploads/business/bid-comments/' . $images->file_name) }}" width="100px" alt="Image not found" class="mr-2"></a>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>

            </div>
        </div>

    </div>
    <div class="px-0">
    <div class="card-footer fixed text-muted px-0 py-0">
        <div id="display_product_list">
            <ul class="image-list d-flex"></ul>
        </div>
        <form action="method" name="bidComment" id="bidComment" enctype="multipart/form-data">
            @csrf
            <div class="d-flex justify-content-start align-items-center">
                <input type="hidden" name="bid_id" value="{{$bid->id}}">
                <textarea type="text" class="form-control form-control-lg border-0 preserveLines" style="color:#5f5e5e;" id="comment" name="comment" placeholder="Type message"></textarea>
                <div class="image-upload">
                    <label for="products_uploaded" class="m-1 text-muted">
                        <i class="fas fa-paperclip"></i>
                    </label>
                    <input type="file" class="hide-file" name="products_uploaded[]" id="products_uploaded" value="Upload" multiple="multiple">
                </div>
                <span class="input-group-btn">
                    <button type="submit" name="submit" id="submit" class="btn" type="button"><i class="fas fa-paper-plane"></i></button>
                </span>
            </div>
        </form>
    </div>
</div>
</section>

@endsection
@section('script')
<script>
$("#comment").keypress(function (e) {
    if(e.which === 13 && !e.shiftKey) {
        e.preventDefault();
        document.getElementById('submit').click();
    }
});
    $(document).ready(function() {
        $("#chat").animate({
            scrollTop: $('#chat').prop("scrollHeight")
        }, 0);
    });
    $(function() {
        var input_file = document.getElementById('products_uploaded');
        var remove_products_ids = [];
        var product_dynamic_id = 0;
        $("#products_uploaded").change(function(event) {
            var len = input_file.files.length;
            remove_products_ids = [];
            $('#display_product_list ul').html("");

            for (var j = 0; j < len; j++) {
                var src = "";
                var name = event.target.files[j].name;
                var mime_type = event.target.files[j].type.split("/");
                if (mime_type == 'application,pdf') {
                    src = "{{asset('assets/img/pdf.png')}}";
                } else {
                    src = URL.createObjectURL(event.target.files[j]);
                }
                $('#display_product_list ul').append("<li id='" + product_dynamic_id + "'><div class='ic-sing-file d-flex'><img id='" + product_dynamic_id + "' src='" + src + "' alt =wrong-format '" + "' width =80% '" + "' title='" + name + "'><p class='close' id='" + product_dynamic_id + "'>X</p></div></li>");
                product_dynamic_id++;
            }
        });
        $(document).on('click', 'p.close', function() {
            var id = $(this).attr('id');
            remove_products_ids.push(id);
            $('li#' + id).remove();
            if (("li").length == 0) document.getElementById('products_uploaded').value = "";
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("form#bidComment").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("remove_products_ids", remove_products_ids);
            $.ajax({
                url: "{{ route('store-comments')}}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,

                success: function(data) {
                    location.reload();
                    $('#products_uploaded').val("");
                },
                error: function(data) {
                    var errors = data.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        alert(value[0]);
                    });
                }
            });
        });
    });
</script>
@endsection