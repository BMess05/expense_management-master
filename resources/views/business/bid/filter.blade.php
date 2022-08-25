<div class="col-md-12 text-right pb-2">
  <div class="user-search-form">
    <form method="GET" action="{{route('bids.index')}}" enctype="multipart/form-data" id="filterbids">
     @csrf
 
     <div class="form-row">
      
        <div class="form-group mb-0 col-md-2">
          <input type="text" class="form-control form-control-sm datepicker-one @error('from_date') is-invalid @enderror" value="{{ isset($data['from_date'])?$data['from_date']:'' }}" id="datepickerbid" name="from_date" placeholder="From Date" autocomplete="off">
           <p class="err_filter"></p>
           @error('from_date')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>

        <div class="form-group mb-0 col-md-2">
          <input type="text" class="form-control form-control-sm datepicker-two @error('to_date') is-invalid @enderror" value="{{ isset($data['to_date'])?$data['to_date']:''}}" id="datepickerbid2" name="to_date" placeholder="To Date" autocomplete="off">
           @error('to_date')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group mb-0 col-md-2 ">
          <input type="text" class="form-control form-control-sm @error('job_id') is-invalid @enderror" value="{{ isset($data['job_id'])?$data['job_id']:''}}"  name="job_id" placeholder="Job ID" autocomplete="off">
           @error('job_id')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <div class="form-group mb-0 col-md-2">
         <select class="form-control form-control-sm" name="filter_bid_status" id="filter_bid_status">
              <option  value="">Bid Status</option>
              
              <option value="0" @if(isset($data['filter_bid_status'])) {{0 == $data['filter_bid_status']  ? 'selected' : ''}} @endif  >No Response</option>
              <option value="1" @if(isset($data['filter_bid_status'])) {{1 == $data['filter_bid_status']  ? 'selected' : ''}} @endif >Client Responded</option>
              <option value="2" @if(isset($data['filter_bid_status'])) {{2 == $data['filter_bid_status']  ? 'selected' : ''}} @endif >Declined</option>
              <option value="3" @if(isset($data['filter_bid_status'])) {{3 == $data['filter_bid_status']  ? 'selected' : ''}} @endif >Project Hired</option>
              <option value="4" @if(isset($data['filter_bid_status'])) {{4 == $data['filter_bid_status']  ? 'selected' : ''}} @endif >Hot Lead</option>
          </select>
        
        </div>
        <div class="form-group mb-0 col-md-2 ">
          <div class="user_div">
            <select class="form-control form-control-sm send" name="user_id" id="user_id">
                <option  value="">Bid Owner</option>
                @foreach($users as $user)
                    <option value="{{$user['id']}}" @if(isset($data['user_id'])) {{$user['id'] == $data['user_id']  ? 'selected' : ''}} @endif>{{$user['name']}}</option>
                @endforeach
                
            </select>
          </div>
        </div>

        <input type="hidden" name="tab_value" id="tab_value">
       <div class="form-group mb-0 col-md-1 danger ">
     
         <button id="search" class="btn mr-2 btn-primary btn-sm float-right">Search</button>
                
        </div>

      </div>
  </form>
  <form method="get" action="{{route('bids.index')}}">
   <input type="hidden" name="bid_page" id="bid_page">
  <div class="col-md-1 reset_button"> <button  id="reset" class="btn btn-danger btn-sm float-right" name="reset" value="reset">Reset</button></div>
   </form>
</div>
</div>
<script type="text/javascript">
function reset(value)
{

  if(value=='otherbids'){
     $('#bid_page').val('otherbids');
  }

  var bid_page = $('#bid_page').val();
  // if(bid_page !=''){  
  //       console.log('bidpage',bid_page);

  //       $.ajax({
  //        
  //         method:"POST",
  //         data:{_token:"{{ csrf_token() }}", bid_page:bid_page},
  //         success:function(data){ 
          
  //           // window.location.href = "bids";
  //           //   var url= document.location.href;
  //           //   window.history.pushState({}, "", url.split("?")[0]);
  //           // // if (undValue != null) {
  //           //   var tab = 'tabs-icons-text-2'; 
  //           //   $('.nav-pills a[href="#' + tab + '"]').trigger('click');
  //       }
  //       });
  // }else{
  //   window.location.href = "bids";
  // }
}


</script>


