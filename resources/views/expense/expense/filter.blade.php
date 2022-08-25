  <div class="col-md-12 text-right pb-2">
          <div class="user-search-form">
    <form method="GET" action="{{route('filterExpense')}}" enctype="multipart/form-data" id="generateQuote">
     @csrf
     <div class="form-row">
         <div class="form-group mb-0 col-md-2">
          <select class="form-control form-control-sm send" name="type" id="type">
            <option value="">Select Type</option>
           <option value="1" @if(isset($data['type'])) {{$data['type'] == 1  ? 'selected' : ''}} @endif>Debit
           <option value="2"  @if(isset($data['type'])) {{$data['type'] == 2  ? 'selected' : ''}} @endif>Credit</option>
          </select>
        </div>

        <div class="form-group mb-0 col-md-2">
          <select class="form-control form-control-sm send" name="category" id="category">
           <option  value="">Select Category</option>
           @foreach($categories as $category)
              <option value="{{$category['id']}}" @if(isset($data['category'])) {{$category['id'] == $data['category']  ? 'selected' : ''}} @endif>{{$category['name']}}</option>
            @endforeach
           
         </select>
       </div>

       <div class="form-group mb-0 col-md-2">
         <select class="form-control form-control-sm send" name="beneficiary" id="beneficiary">
           <option  value="">Select Beneficiary</option>
           @foreach($beneficiaries as $beneficiary)
              <option value="{{$beneficiary['id']}}" @if(isset($data['beneficiary'])) {{$beneficiary['id'] == $data['beneficiary']  ? 'selected' : ''}} @endif>{{$beneficiary['name']}}</option>
            @endforeach
         </select>
        </div>

        <div class="form-group mb-0 col-md-2">
          <input type="text" class="form-control form-control-sm datepicker-one @error('from_date') is-invalid @enderror" value="{{ isset($data['from_date'])?$data['from_date']:'' }}" id="datepicker" name="from_date" placeholder="From Date" autocomplete="off">
           <p class="err_filter"></p>
           @error('from_date')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="form-group mb-0 col-md-2">
          <input type="text" class="form-control form-control-sm datepicker-two @error('to_date') is-invalid @enderror" value="{{ isset($data['to_date'])?$data['to_date']:''}}" id="datepicker2" name="to_date" placeholder="To Date" autocomplete="off">
           @error('to_date')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

       <div class="form-group mb-0 col-md-2  danger ">
         <a href="{{route('expenses')}}" class="btn btn-danger btn-sm float-right">Reset</a>
         <button id="search" class="btn mr-2 btn-primary btn-sm float-right">Search</button>
                
        </div>


      </div>
  </form>
</div>
</div>


