@if (date('m') > 3 )
    @php $year = date('Y')."-".(date('Y') +1);@endphp
@else
    @php $year = (date('Y')-1)."-".date('Y'); @endphp
@endif

<nav class="navbar navbar-top navbar-expand navbar-dark bg-green-grediant border-bottom">

    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Search form -->
        <!-- <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
            <div class="form-group mb-0">
            <div class="input-group input-group-alternative input-group-merge">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input class="form-control" placeholder="Search" type="text">
            </div>
            </div>
            <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </form> -->

        
        
        
        <!-- Navbar links -->
        <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
            <!-- Sidenav toggler -->
            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                </div>
            </div>
            </li>
            <li class="nav-item d-sm-none">
                <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                    <i class="ni ni-zoom-split-in"></i>
                </a>
            </li>
        </ul>
        <div class="upper-head pl-xs-3"><h3 class="text-white">Financial Year {{$year}}</h3></div>
        <ul class="navbar-nav align-items-center  ml-auto ml-md-0 top_menu_dropdown">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                    <span class="avatar avatar-sm rounded-circle profile_pic">
                    @if(file_exists( public_path().'/uploads/profilepic/'.Auth::user()->image) && !empty(Auth::user()->image))
                                            <img src="{{ asset('uploads/profilepic/' . Auth::user()->image) }}" width="100%" alt="alt text">
                                            @else
                                            <img src="{{ asset('assets/img/avatar.png') }}" width="100%" alt="alt text">
                                            @endif
                    </span>

                    <div class="media-body  ml-2  d-none d-lg-block">
                        <span class="mb-0 text-sm  font-weight-bold">{{Auth::user()->name}}</span>
                    </div>
                    </div>
                </a>
                <div class="dropdown-menu  dropdown-menu-right ">
                    <div class="dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Welcome!</h6>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{route('users.edit',auth()->user()->id)}}" class="dropdown-item">
                    <i class="far fa-user"></i>
                    <span>Edit profile</span>
                    </a>
                    <a href="{{url('change/password')}}" class="dropdown-item">
                    <img class="svg_right_margin" src="{{ asset('assets/img/icons/change-password.svg') }}"><span>Change Password</span>
                    </a>
                    @can('system-setting-list')
                    <a href="{{url('setting/edit')}}" class="dropdown-item">
                    <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/top_setting.svg') }}"><span>Settings</span>

                    </a>
                    @endcan
                    
                    <a href="{{url('logout')}}" class="dropdown-item">
                    <i class="ni ni-user-run"></i>
                    <span>Logout</span>
                    </a>
                </div>
            </li>
        </ul>
        </div>
    </div>
</nav>
@section('script')
<script>
   
        // $(document).on('click', '.top_menu_dropdown', function() {
    
        //     console.log('ttes');

        //     $('.top_menu_dropdown').addClass('show');
        //     $('div.dropdown-menu-right').addClass('show');
        // })

  
</script>
@endsection