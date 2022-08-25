@extends('layouts.main')
@section('content')
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-Banks-center">
                            <div class="col">
                                <h3 class="mb-0">Edit Bid</h3>
                            </div>
                            <div class="col text-right">
                                <a href="{{route('bids.index')}}" class="btn btn-sm btn-primary">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('status'))
                        <div class="alert alert-{{ Session::get('status') }}" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                            {{ Session::get('message') }}
                        </div>
                        @endif

                        {!! Form::model($bid, ['method' => 'PATCH','route' => ['bids.update', $bid->id],'id'=>'addCategory']) !!}
                        @csrf
                        <input type="hidden" id="bid_id" value="{{ $bid->id}}">
                        <div class="form-group">
                            <h5 class="ml-3">Bid Url</h5>
                            <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/il_url.svg') }}"></span>
                                </div>
                                {!! Form::text('bid_url', null, array('placeholder' => 'Bid Url','class' => 'form-control')) !!}

                            </div>
                            @error('bid_url')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                        <h5 class="ml-3">Job Id</h5>
                            <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/il_url.svg') }}"></span>
                                </div>
                                {!! Form::text('job_id', null, array('placeholder' => 'Job ID','class' => 'form-control')) !!}

                            </div>
                            @error('job_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                        <h5 class="ml-3">Profile</h5>
                            <div class="input-group input-group-merge input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/wpf_name.svg') }}"></span>
                                </div>

                                {!! Form::select('bid_id',$bids,$bid->bid_id, array('class' => 'form-control')) !!}

                            </div>
                            @error('roles')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                        <h5 class="ml-3">Client Name</h5>
                            <div class="input-group input-group-merge input-group-alternative mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/wpf_name.svg') }}"></span>
                                </div>
                                {!! Form::text('client_name', null, array('placeholder' => 'Client Name','class' => 'form-control')) !!}

                            </div>
                            @error('client_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        {{-- <div class="form-group">
                                <div class="input-group input-group-merge input-group-alternative">

                                {!! Form::textarea('perposal', null, array('placeholder' => 'Proposal','class' => 'form-control')) !!}

                                </div>
                                @error('perposal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div>--}}

                    <div class="form-group">
                    <h5 class="ml-3">Job Type</h5>
                        <div class="input-group input-group-merge input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/il_url.svg') }}"></span>
                            </div>
                            <select name="job_type" class="form-control" id="job_type">
                                <option value="none" selected disabled>Select Job Type</option>
                                <option value="1" {{ ($bid->job_type == 1) ? 'selected' : '' }}>Hourly</option>
                                <option value="2" {{ ($bid->job_type == 2) ? 'selected' : '' }}>Fixed</option>
                            </select>
                        </div>
                        @error('job_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                    <h5 class="ml-3">Bid Amount</h5>
                        <div class="input-group input-group-merge input-group-alternative mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><img width="17" height="20" src="{{ asset('assets/img/icons/il_url.svg') }}"></span>
                            </div>
                            <input class="form-control" type="text" name="bid_amount" placeholder="Bid Amount" value="{{$bid->bid_amount}}">
                        </div>
                        @error('bid_amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- <div class="form-group">
                    <h5 class="ml-3">Comment</h5>
                        <div class="input-group input-group-merge input-group-alternative">

                            {!! Form::textarea('comment', null, array('placeholder' => 'Comment','class' => 'form-control')) !!}

                        </div>
                        @error('comment')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                    </div> -->

                    <div class="text-right">
                        <button type="submit" id="save_cat" class="btn btn-primary mt-3">Update</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
</div>
@endsection

@section('script')
<script>
    $("#addCategory").validate({
        errorElement: 'div',
        rules: {
            bid_id: {
                required: true,
            },
            bid_url: {
                required: true,
                remote: {
                    url: '{{route("validateBidUrl")}}',
                    type: "post",
                    data: {
                        'id': $('#bid_id').val(),
                        "_token": "{{ csrf_token() }}"
                    },

                }
            },
            job_id: {
                required: true
            },
            job_type: {
                required: true
            },
            bid_amount: {
                required: true,
                number: true
            },
        },
        messages: {
            bid_id: {
                required: "Please provide  bid id",
            },
            bid_url: {
                required: "Please provide bid url",
                remote: "The url has already been taken."
            },
            job_id: {
                required: "Please provide a Job ID."
            },
            job_type: {
                required: "Please select a job type."
            },
            bid_amount: {
                required: "Please provide bid amount.",
                number: "Bid amount should be in digits.",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }

    });
</script>
@endsection