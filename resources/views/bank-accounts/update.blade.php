<form method="post" id="bankAcEditForm">
    <input type="hidden" name="id" value="{{$bank->id}}" />
    <div class="form-group">
        <label for="ac_holder">Account Holder Name :</label>
        <input type="text" class="form-control" id="ac_holder" name="ac_holder" value="{{$bank->ac_holder}}" placeholder="Name On Bank Account" />
        @error('ac_holder')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="account_no">Account Number :</label>
        <input type="text" class="form-control" id="account_no" name="account_no" value="{{$bank->account_no}}" placeholder="Account Number" />
        @error('account_no')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="ifsc_code">IFSC Code :</label>
        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="{{$bank->ifsc_code}}" placeholder="IFSC Code" />
        @error('ifsc_code')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="form-group">
        <label for="bank_name">Bank Name :</label>
        <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{$bank->bank_name}}" placeholder="Bank Name" />
        @error('bank_name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="text-right">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" value="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<script>
     $("#bankAcEditForm").validate({
        errorElement: 'strong',
        rules: {
            ac_holder: {
                required: true,
            },
            account_no: {
                required: true,
            },
            ifsc_code: {
                required: true,
            },
            bank_name: {
                required: true,
            },
        },
        messages: {
            ac_holder: {
                required: "Please enter account holder name."
            },
            account_no: {
                required: "Please enter account number.",
            },
            ifsc_code: {
                required: "Please enter IFSC code.",
            },
            bank_name: {
                required: "Please enter bank name.",
            },
        },
    });
    $("#bankAcEditForm").submit(function(e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: "{{ route('bank-ac-update') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
            },
            data: data,
            success: function(data) {
                $('#editBankAc').modal('hide');
                fetch_bank_accounts();
                Swal.fire({
                    position: 'top-end',
                    width: '400px',
                    icon: 'success',
                    title: 'Bank Account Updated Successfully',
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