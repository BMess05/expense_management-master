@extends('layouts.main')
@section('content')
<style>
  .toggle.ios, .toggle-on.ios, .toggle-off.ios { border-radius: 20rem; }
  .toggle.ios .toggle-handle { border-radius: 20rem; }
</style> 
<div class="">
    <div class="container-fluid mt-3">
        <div class="row" id="main_content">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-Banks-center">
                        <div class="col">
                            <h3 class="mb-0">Setting</h3>
                        </div>
                        <div class="col text-right">
                             <a href="{{ url('/') }}" class="btn btn-sm btn-primary">Back</a>
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
                
                           {!! Form::model($system_setting, ['method' => 'PATCH','route' => ['updateSetting'],'id'=>'addCategory']) !!}
                            @csrf
                          @php 
                          if($count == 0){
                              
                              $system_setting = 0;
                              $devicestatus = "checked";
                          }else{
                            if(isset($system_setting->system_maintanance) &&     $system_setting->system_maintanance == '0'){
                                $system_setting = 0; 
                                $devicestatus = "checked";
                            }else{
                             $system_setting = 1; 
                             $devicestatus = "checked";
                            }
                            

                          }
                         
                          @endphp
                          
                            <div class="form-group">
                            
                                <div class="input-group radio-butn input-group-merge input-group-alternative mb-3">
                                    <label class="label_class">System Maintenance</label>
                                    <div>

                                    <input type="checkbox" name="system_maintanance" data-toggle="toggle" class="toggle_system" data-style="ios" @if($system_setting) {{ 'checked' }} @endif value="1">
                              
                                    </div>
                                
                                </div>
                            </div> 
                            <div class="text-right">
                                <button type="submit" id="save_cat" class="btn btn-primary mt-3">Update Setting</button>
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

</script>
@endsection