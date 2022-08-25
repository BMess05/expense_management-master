<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Expense Management Admin Panel">
  <title>Expense Management</title>
  <!-- Favicon -->
  <link rel="icon" href="{{asset('assets/img/favicon.png')}}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->

  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

  <link rel="stylesheet" href="{{asset('assets/vendor/nucleo/css/nucleo.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/vendor/@fortawesome/fontawesome-free/css/all.min.css')}}" type="text/css">
  <!-- Page plugins -->
  <!-- Argon CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/argon.css?v=1.2.0')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" type="text/css">

  <link rel="stylesheet" href="{{asset('assets/css/bootstrap-timepicker.min.css')}}" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/css/toaster.css')}}" type="text/css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href="https://gitbrent.github.io/bootstrap4-toggle/css/bootstrap4-toggle.css" rel="stylesheet"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" type="text/css"> -->
</head>

<body>
  <!-- Sidenav -->
<nav class="bg-green-grediant sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
              <img src="{{asset('assets/img/soft-radix-logo-white.png')}}" class="navbar-brand-img" alt="...">

            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                      <a href="{{url('/')}}" class="nav-link {{ Request::segment(1)=='' ? 'active' : ''}}">
                          <i class="ni ni-tv-2 text-white"></i>
                          <span class="nav-link-text text-white">Dashboard</span>
                      </a>
                    </li>
                  
                    <li class="nav-item">
                    <a  href="{{route('attendance-index')}}" class="nav-link {{ Request::segment(1)=='attendance' ? 'active' : ''}}">
                        <i class="ni ni-bullet-list-67 text-white"></i>
                        <span class="nav-link-text text-white">Attendance</span>
                    </a>
                    </li>
                   
                    @if(Gate::check('user-list') || Gate::check('role-list'))

                     <li class="nav-item">
                      <a class="nav-link" href="#navbar-users" data-toggle="collapse" role="button"  aria-controls="navbar-users" aria-expanded=" ">
                         <i class="far fa-user text-white"></i>
                        <span class="nav-link-text text-white">Manage Employees</span>
                      </a>
                      <div class="collapse {{ Request::segment(1)=='users' ? 'show' : ''}}" id="navbar-users" style="">
                        <ul class="nav nav-sm flex-column">
                        @can('user-list')
                          <li class="nav-item">
                            <a href="{{route('users.index')}}" class="nav-link {{ Request::segment(2)=='users' ? 'active' : ''}}">
                              <i class="far fa-user text-white"></i>
                             <span class="nav-link-text text-white">Employees</span>
                            </a>
                          </li>
                        @endcan
                        @can('role-list')
                          <li class="nav-item">
                            <a href="{{route('roles.index')}}" class="nav-link {{ Request::segment(2)=='roles' ? 'active' : ''}}">
                              <i class="fas fa-genderless text-white"></i>
                              <span class="nav-link-text text-white">Roles</span>
                            </a>
                          </li>
                        @endcan
                        </ul>
                      </div>
                    </li>
                    @endif
                    @if(Gate::check('category-list') || Gate::check('beneficiary-list')  || Gate::check('bank-list')  || Gate::check('expense-list'))
                     <li class="nav-item">
                      <a class="nav-link" href="#navbar-expenses" data-toggle="collapse" role="button"  aria-controls="navbar-expenses" aria-expanded=" ">
                         <i class="ni ni-money-coins text-white"></i>
                        <span class="nav-link-text text-white">Manage Expenses</span>
                      </a>
                      <div class="collapse {{ Request::segment(1)=='expense' ? 'show' : ''}}" id="navbar-expenses" style="">
                        <ul class="nav nav-sm flex-column">
                          @can('category-list')
                           <li class="nav-item">
                            <a  href="{{route('categories')}}" class="nav-link {{ Request::segment(2)=='categories' ? 'active' : ''}}">
                              <i class="ni ni-bullet-list-67 text-white"></i>
                              <span class="nav-link-text text-white">Categories</span>
                            </a>
                          </li>
                          @endcan
                          @can('beneficiary-list')
                           <li class="nav-item">
                            <a  href="{{route('beneficiaries')}}" class="nav-link {{ Request::segment(2)=='beneficiary' ? 'active' : ''}}">
                              <i class="far fa-money-bill-alt text-white"></i>
                              <span class="nav-link-text text-white">Beneficiaries</span>
                            </a>
                          </li>
                          @endcan
                          @can('bank-list')
                          <li class="nav-item">
                            <a  href="{{route('bankaccounts')}}" class="nav-link {{ Request::segment(2)=='bank-account' ? 'active' : ''}}">
                              <i class="ni ni-shop  text-white"></i>
                              <span class="nav-link-text text-white">Bank Accounts</span>
                            </a>
                          </li>
                          @endcan
                          @can('expense-list')
                          <li class="nav-item">
                            <a  href="{{route('expenses')}}" class="nav-link {{ Request::segment(2)=='expenses' ? 'active' : ''}}">
                              <i class="ni ni-money-coins text-white"></i>
                              <span class="nav-link-text text-white">Expenses</span>
                            </a>
                          </li>
                          @endcan
                        </ul>
                      </div>
                    </li>
                    @endif
                    @if(Gate::check('resume-category-list') || Gate::check('resume-list'))
                    <li class="nav-item">
                      <a class="nav-link" href="#navbar-resume" data-toggle="collapse" role="button"  aria-controls="navbar-resume" aria-expanded=" ">
                       <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/resumecategory.svg') }}">
                        <span class="nav-link-text text-white">Manage Resumes</span>
                      </a>
                      <div class="collapse {{ Request::segment(1)=='resume' ? 'show' : ''}}" id="navbar-resume" style="">
                        <ul class="nav nav-sm flex-column">
                        @can('resume-category-list')
                           <li class="nav-item">
                            <a  href="{{route('resumeCategory')}}" class="nav-link {{ Request::segment(2)=='category' ? 'active' : ''}}
                              ">
                              <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/resumecategory.svg') }}">

                              <span class="nav-link-text text-white">Resume Category</span>
                            </a>
                          </li>
                        @endcan
                        @can('resume-list')
                        <li class="nav-item">
                          <a  href="{{route('resumes')}}" class="nav-link {{ Request::segment(2)=='resumes' ? 'active' : ''}}">
                            <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/resume.svg') }}">

                            <span class="nav-link-text text-white">Resume</span>
                          </a>
                        </li>
                        @endcan
                      </ul>
                      </div>
                    </li>
                    @endif
                    @if(Gate::check('bid-list') || Gate::check('bid-profile-list') || Gate::check('target-list') || Gate::check('settings-list'))

                    <li class="nav-item">
                      <a class="nav-link" href="#navbar-business" data-toggle="collapse" role="button"  aria-controls="navbar-business" aria-expanded=" ">
                         <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/business.svg') }}">
                        <span class="nav-link-text text-white">Manage Business</span>
                      </a>
                      <div class="collapse {{ Request::segment(1)=='business' ? 'show' : ''}}" id="navbar-business" style="">
                        <ul class="nav nav-sm flex-column">
                        @can('bid-profile-list')
                          <li class="nav-item">
                            <a href="{{route('bidprofile.index')}}" class="nav-link {{ Request::segment(2)=='bidprofile' ? 'active' : ''}}">
                              <span class="sidenav-mini-icon">
                              <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/bidsprofile.svg') }}">
                              </span>
                              <span class="sidenav-normal text-white">Bids Profile</span>
                            </a>
                          </li>
                          @endcan
                          @can('bid-list')
                          <li class="nav-item">
                            <a href="{{route('bids.index')}}" class="nav-link {{ Request::segment(2)=='bids' ? 'active' : ''}}">
                              <span class="sidenav-mini-icon">
                              <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/bids.svg') }}">
                              </span>
                              <span class="sidenav-normal text-white">Bids</span>
                            </a>
                          </li>
                          @endcan
                          @can('target-list')
                          <li class="nav-item">
                            <a href="{{route('targets.index')}}" class="nav-link {{ Request::segment(2)=='targets' ? 'active' : ''}}">
                              <span class="sidenav-mini-icon">

                              <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/target.svg') }}">
                              </span>
                              <span class="sidenav-normal text-white">Targets</span>
                            </a>
                          </li>
                          @endcan
                          @can('settings-list')
                          <li class="nav-item">
                            <a href="{{route('settings.index')}}" class="nav-link {{ Request::segment(2)=='settings' ? 'active' : ''}}">
                              <span class="sidenav-mini-icon">
                               <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/setting.svg') }}">
                              </span>
                              <span class="sidenav-normal text-white">Setting</span>
                            </a>
                          </li>
                          @endcan
                          {{--
                          <li class="nav-item">
                            <a href="{{route('projects.index')}}" class="nav-link {{ Request::segment(2)=='projects' ? 'active' : ''}}">
                              <span class="sidenav-mini-icon"><img class="svg_right_margin" src="{{asset('assets/img/business/bar-chart 1.png')}}" height="18px" class='mr-2'> </span>
                              <span class="sidenav-normal text-white">Project Status</span>
                            </a>
                          </li>
                          <li class="nav-item">
                            <a href="{{route('statusreport.index')}}" class="nav-link {{ Request::segment(2)=='statusreport' ? 'active' : ''}}">
                              <span class="sidenav-mini-icon">
                              <img src="{{asset('assets/img/business/icons8_document.png')}}" height="18px" class='mr-2'></span>&nbsp;
                              <span class="sidenav-normal text-white">Status Report</span>
                            </a>
                          </li>

                          <li class="nav-item">
                            <a href="{{route('exportExpense')}}" class="nav-link {{ request()->is('expense/export') ? 'active'  : '' }}">
                              <span class="sidenav-mini-icon"><img src="{{asset('assets/img/business/calendar 1.png')}}" height="18px" class='mr-2'></span>&nbsp;
                              <span class="sidenav-normal text-white">Project Estimator</span>
                            </a>
                          </li>--}}

                        </ul>
                      </div>
                    </li>
                    @endif
                    @if(Gate::check('hardware-list'))

                      <li class="nav-item">
                        <a class="nav-link" href="#navbar-hardware" data-toggle="collapse" role="button"  aria-controls="navbar-hardware" aria-expanded=" ">
                         <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/hardware.svg') }}">

                          <span class="nav-link-text text-white">Manage Hardware</span>
                        </a>
                        <div class="collapse {{ Request::segment(1)=='hardware' ? 'show' : ''}}" id="navbar-hardware" style="">
                          <ul class="nav nav-sm flex-column">
                          @can('hardware-list')
                            <li class="nav-item">
                              <a href="{{route('hardware.index')}}" class="nav-link {{ Request::segment(2)=='hardware' ? 'active' : ''}}">
                                <span class="sidenav-mini-icon">
                                <img class="svg_right_margin" width="17" height="20" src="{{ asset('assets/img/icons/hardware.svg') }}">
                                </span>
                                <span class="sidenav-normal text-white">Hardware</span>
                              </a>
                            </li>
                          @endcan
                          </ul>
                        </div>
                      </li>
                    @endif
                    @can('standard-deduction-list')
                    <li class="nav-item">
                    <a  href="{{route('standard-deduction-index')}}" class="nav-link {{ Request::segment(1)=='standard-deduction' ? 'active' : ''}}">
                        <i class="ni ni-bullet-list-67 text-white"></i>
                        <span class="nav-link-text text-white">Standard Deduction</span>
                    </a>
                    </li>
                    @endcan
                    @can('manage-salaries')
                    <li class="nav-item">
                    <a  href="{{route('manageSalaries')}}" class="nav-link {{ Request::segment(1)=='salaries' ? 'active' : ''}}">
                        <i class="ni ni-money-coins text-white"></i>
                        <span class="nav-link-text text-white">Manage Salaries</span>
                    </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </div>


    </div>
</nav>
<!-- Main content -->
<div class="main-content" id="panel">
  <!-- Topnav -->
  @include('layouts.top_nav')
  <!-- Header -->
  <!-- Header -->
  @yield('content')
</div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{asset('assets/vendor/jquery/dist/jquery.min.js')}}"></script>
  <!-- <script src="{{asset('assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://gitbrent.github.io/bootstrap4-toggle/js/bootstrap4-toggle.js"></script>
  <script src="{{asset('assets/vendor/js-cookie/js.cookie.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
  <script src="{{asset('assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
  <!-- Optional JS -->
  <script src="{{asset('assets/vendor/chart.js/dist/Chart.min.js')}}"></script>
  <script src="{{asset('assets/vendor/chart.js/dist/Chart.extension.js')}}"></script>
  <!-- Argon JS -->
  <script src="{{asset('assets/js/argon.js?v=1.2.0')}}"></script>
  <script src="{{asset('assets/js/bootstrap-timepicker.min.js')}}"></script>

  <!-- Page level plugins -->
  <script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>

  <script src="{{ asset('assets/vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

  <script src="{{asset('assets/js/sweetalert.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.validate.min.js')}}"></script>
  <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
 <script>

    $(document).ready(function() {
        setTimeout(function() {
          $('.alert').remove();
        }, 3000);


        oTable=  $('#dataTable').DataTable({
              language: {
              paginate: {
                next: '<i class="fas fa-angle-right"></i>',
                previous: '<i class="fas fa-angle-left"></i>'
              }

            },
            "pageLength": 20
          });

          oSettings = oTable.settings();

          $("#show_all_records").on('click',function(){
              oSettings[0]._iDisplayLength = oSettings[0].fnRecordsTotal();
              oTable.draw();
          });

          $(function() {
              $( "#datepicker" ).datepicker({  maxDate: new Date(), dateFormat: 'dd-mm-yy' });
              $( "#datepicker2" ).datepicker({  maxDate: new Date(),dateFormat: 'dd-mm-yy'});
              $(function() {
                 $(".datepicker" ).datepicker({  maxDate: new Date(), dateFormat: 'dd-mm-yy' });
              });
              $('.fa-calendar-alt').click(function() {
                  $("#datepicker").focus();
              });
          });



    });
  </script>
  @yield('script')
</body>

</html>
