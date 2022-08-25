<form method="post" id="documentEditForm" enctype="multipart/form-data">
    <input type="hidden" name="id" value="{{$document->id}}" />
    <div class="form-group">
        <label for="doc_name">Document Name :</label>
        <input type="text" class="form-control" id="doc_name" name="doc_name" placeholder="Document Name" value="{{$document->doc_name}}" />
        @error('doc_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="dob">Issued Date :</label>
        <input type="date" class="form-control" name="issued_date" max="<?php echo date("Y-m-d"); ?>" id="issued_date" value="{{ old('issued_date') ?? $document->issued_date }}">
        @error('dob')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <div class="image-upload">
            <label for="document">
                Upload Document :
                <br><br>
                <img id="uDocument-preview" src="{{ asset('assets/img/document.png') }}" width="20%" alt="Wrong Format">
                <h5 id="uDocument-name"></h5>
            </label><br>
            <input type="file" class="hide-file" name="document" id="document" />
            <div class="upload_uDocument h5" style="color:#b74747"></div>
            @error('document')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" value="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<script>
    $("#documentEditForm").validate({
        errorElement: 'strong',
        rules: {
            doc_name: {
                required: true,
            },
            issued_date: {
                required: true,
            },
            document: {
                extension: "jpg|jpeg|png|ico|bmp|webp|docx|doc|pdf|xml|ppt|xls",
            },
        },
        messages: {
            doc_name: {
                required: "Please enter document name."
            },
            issued_date: {
                required: "Please enter issued date.",
            },
            document: {
                extension: "Please upload file in these formats only (jpg, jpeg, png, docx, doc, pdf, xml, ppt, xls).",
            },
        },
    });

    $('#document').change(function() {
        $(".upload_uDocument").html("");
        $("#document-error").html("");
        $('#uDocument-preview').attr('src', '');
        $('#uDocument-name').text('');
        let reader = new FileReader();
        reader.readAsDataURL(this.files[0]);
        var type = /[^/]*$/.exec(this.files[0].type)[0];
        var fileName = this.files[0].name;
        reader.onload = (e) => {
            var file = e.target.result;
            if (type == 'png' || type == 'jpeg' || type == 'webp' || type == 'jpg') {
                $('#uDocument-preview').attr('src', e.target.result);
                images_validate();
            } else if (type == 'pdf') {
                $('#uDocument-preview').attr('src', "{{asset('assets/img/pdf.png')}}");
                $('#uDocument-preview').attr('width', '90px');
                $('#uDocument-name').text(fileName);
                images_validate();
            } else {
                var myarray = [];
                myarray.push('msword','ico','bmp','docx','doc','xml','ppt','xls');
                if (myarray.includes(type)) {
                    $('#uDocument-preview').attr('src', "{{asset('assets/img/docs.png')}}");
                    $('#uDocument-preview').attr('width', '70px');
                    $('#uDocument-name').text(fileName);
                    images_validate();
                }else{

                    $('#uDocument-preview').attr('src', e.target.result);
                    $(".upload_uDocument").html("Please upload file in these formats only (jpg, jpeg, png, docx, doc, pdf, xml, ppt, xls).");
                }
                
            }
        }
    });

    function images_validate() {
        $(".upload_uDocument").html("");
        if ($('#document').val() != "") {
            var file_size_pp = $('#document')[0].files[0].size;
            if (file_size_pp > 5242880) {
                $('#document-error').text('');
                $(".upload_uDocument").html("File size should not be greater than 5 MB.");
                return false;
            }
        }  
    }

    $("#documentEditForm").submit(function(e) {
        e.preventDefault();
        var formData = new FormData($("#documentEditForm")[0]);
        if( document.getElementById("document").files.length > 0 ){
        let file = $('input[type=file]')[0].files[0];
        formData.append('document', file, file.document);
        }
        $.ajax({
            url: "{{ route('documents-update') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                $('#editdocument').modal('hide');
                fetch_issued_documents();
                $('#uDocument-preview').attr('src', "{{ asset('assets/img/document.png') }}");
                $('#uDocument-preview').attr('width', "20%");
                $('#uDocument-name').text('');
                Swal.fire({
                    position: 'top-end',
                    width: '400px',
                    icon: 'success',
                    title: 'Document Updated Successfully',
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error: function(errors) {
                console.log(errors);

            }
        });
    });
</script>