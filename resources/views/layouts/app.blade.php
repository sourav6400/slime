<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="loading dark-layout" data-layout="dark-layout" data-textdirection="ltr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!--<title>Dashboard -Slimedb</title>-->
    <title>Slimedb - @yield('title')</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/calendars/fullcalendar.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-calendar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/form-validation.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
</head>

<style>
    .fav-btn {
        cursor: pointer;
    }
    
    /*.dataTables_filter {*/
    /*    display: none !important;*/
    /*}*/
    
    #myTable_wrapper {
        padding-right: 2rem;
        padding-left: 2rem;
    }
    /*#example_wrapper {*/
    /*    padding-right: 2rem;*/
    /*    padding-left: 2rem;*/
    /*}*/
    /*.card-datatable {*/
    /*    padding-right: 2rem;*/
    /*    padding-left: 2rem;*/
    /*}*/
</style>

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-dark navbar-shadow container-xxl">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <input type="search" class="form-control" name="" id="" placeholder="🔎︎ Search">
                    </li>
                </ul>
            </div>
            <ul class="nav navbar-nav align-items-center ms-auto">
                <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        @php
                            if(Auth::user()->role == 'Client')
                                $role_name = 'Client';
                            else
                            {
                                $role_id = Auth::user()->role;
                                $role = DB::table('roles')->where('id', $role_id)->first();
                                $role_name = $role->role;
                            }
                        @endphp
                        <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder">{{ Auth::user()->name }}</span>
                            <span class="user-status">{{ $role_name }}</span>
                        </div>
                        <span class="avatar">
                            <img class="round" src="{{ asset('images/profile.png') }}" alt="avatar" height="40" width="40">
                            <span class="avatar-status-online"></span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                        <!--<a class="dropdown-item" href="#"><i class="me-50" data-feather="user"></i> Profile</a>-->
                        <!--<a class="dropdown-item" href="#"><i class="me-50" data-feather="mail"></i> Inbox</a>-->
                        <!--<a class="dropdown-item" href="#"><i class="me-50" data-feather="check-square"></i> Task</a>-->
                        <!--<a class="dropdown-item" href="#"><i class="me-50" data-feather="message-square"></i> Chats</a>-->
                        <!--<div class="dropdown-divider"></div>-->
                        <!--<a class="dropdown-item" href="#"><i class="me-50" data-feather="settings"></i> Settings</a>-->
                        <!--<a class="dropdown-item" href="#"><i class="me-50" data-feather="credit-card"></i> Pricing</a>-->
                        <!--<a class="dropdown-item" href="#"><i class="me-50" data-feather="help-circle"></i> FAQ</a>-->
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="me-50" data-feather="power"></i> Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    
    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <!-- navbar logo  -->
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto">
                    <a class="navbar-brand" href="{{ route('dashboard') }}">
                        <span class="brand-logo">
                            <img src="{{ asset('images/logo.png') }}" alt="">
                        </span>
                    </a>
                </li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('dashboard') }}"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>
                </li>
                @php
                $role_id = Auth::user()->role;
                $client_permission = DB::table('client_permission')->where('role_id', $role_id)->first();
                @endphp

                @if(($client_permission != null) && ($client_permission->view == 1 || $client_permission->edit == 1 || $client_permission->create == 1))
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Chat">Clients</span></a>
                    <ul class="menu-content">
                        @if($client_permission->create != null && $client_permission->create == 1)
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('add_new_client_view') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Add New</span></a>
                        </li>
                        @endif
                        @if(($client_permission->view != null && $client_permission->view == 1) || ($client_permission->edit != null && $client_permission->edit == 1))
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('all_clients') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">All Clients</span></a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('all_fav_clients') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Favourite Client</span></a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @php
                $influencer_permission = DB::table('influencer_permission')->where('role_id', $role_id)->first();
                @endphp

                @if(($influencer_permission != null) && ($influencer_permission->view == 1 || $influencer_permission->edit == 1 || $influencer_permission->create == 1))
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="check-square"></i><span class="menu-title text-truncate" data-i18n="Todo">Influencers</span></a>
                    <ul class="menu-content">
                        @if(($influencer_permission->view != null && $influencer_permission->view == 1) || ($influencer_permission->edit != null && $influencer_permission->edit == 1))
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('all_influencers') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">All Influencers</span></a>
                        </li>
                        @endif
                        @if($influencer_permission->create != null && $influencer_permission->create == 1)
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('add_new_influencer') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Add New</span></a>
                        </li>
                        @endif
                        @if(($influencer_permission->view != null && $influencer_permission->view == 1) || ($influencer_permission->edit != null && $influencer_permission->edit == 1))
                        <!--<li>-->
                        <!--    <a class="d-flex align-items-center" href="{{ route('favourite_influencers') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Favourite Influencer</span></a>-->
                        <!--</li>-->
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('influencer_template') }}">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Influencer Template</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('influencer_packages') }}">
                                <i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Influencer Packages</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif

                @php
                $campaign_permission = DB::table('campaign_permission')->where('role_id', $role_id)->first();
                @endphp

                @if(($campaign_permission != null) && ($campaign_permission->view == 1 || $campaign_permission->edit == 1 || $campaign_permission->create == 1))
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="grid"></i><span class="menu-title text-truncate" data-i18n="Kanban">Campaigns</span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('new_campaign') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Add New</span></a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('ongoing_campaigns') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Ongoing Campaign</span></a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('draft_campaigns') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Draft Campaign</span></a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('all_campaign') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">All campaign</span></a>
                        </li>
                    </ul>
                </li>
                @endif

                @php
                $payment_permission = DB::table('payment_permission')->where('role_id', $role_id)->first();
                @endphp

                @if(($payment_permission != null) && ($payment_permission->view == 1 || $payment_permission->edit == 1 || $payment_permission->create == 1))
                <!--<li class=" nav-item">-->
                <!--    <a class="d-flex align-items-center" href="#">-->
                <!--        <i data-feather="credit-card"></i><span class="menu-title text-truncate" data-i18n="Invoice">Payment</span></a>-->
                <!--    <ul class="menu-content">-->
                <!--        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Invoice</span></a>-->
                <!--            <ul class="menu-content">-->
                <!--                <li><a class="d-flex align-items-center" href="#"><span class="menu-item text-truncate" data-i18n="Account">List</span></a>-->
                <!--                </li>-->
                <!--                <li><a class="d-flex align-items-center" href="#"><span class="menu-item text-truncate" data-i18n="Security">Add</span></a>-->
                <!--                </li>-->
                <!--            </ul>-->
                <!--        </li>-->
                <!--        <li><a class="d-flex align-items-center" href="#"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Quatation</span></a>-->
                <!--        </li>-->
                <!--    </ul>-->
                <!--</li>-->
                @endif


                @php
                $user_management_permission = DB::table('user_management_permission')->where('role_id', $role_id)->first();
                @endphp

                @if(($user_management_permission != null) && ($user_management_permission->view == 1 || $user_management_permission->edit == 1 || $user_management_permission->create == 1))
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="File Manager">User Management</span></a>
                    <ul class="menu-content">
                        <li><a class="d-flex align-items-center" href="{{ route('user-list') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">User</span></a>
                        </li>
                        <li><a class="d-flex align-items-center" href="{{ route('roles') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Roles</span></a>
                        </li>
                        @if (Auth::user()->role == '6')
                        <li><a class="d-flex align-items-center" href="{{ route('approval_requests') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Approval Requests</span></a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                </li>
                <li class=" nav-item">
                    <a class="d-flex align-items-center" href="#"><i data-feather="settings"></i><span class="menu-title text-truncate" data-i18n="File Manager">Business Setting</span></a>
                    <ul class="menu-content">
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('tag') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Tags</span></a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('region') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="List">Region</span></a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('content') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Content</span></a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('social') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Social</span></a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('wallet') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">Wallet</span></a>
                        </li>
                        <li>
                            <a class="d-flex align-items-center" href="{{ route('api_integrate') }}"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Preview">API Integration</span></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        @yield('content')
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">COPYRIGHT &copy; 2023<a class="ms-25 link-clr" href="#" target="_blank">TR DIGITAL SOLUTION</a><span class="d-none d-sm-inline-block">, All rights Reserved</span></span></p>
    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('app-assets/vendors/js/calendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/extensions/moment.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>

    <script src="{{ asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>

    <script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Page Vendor: Form Repeater  JS-->
    <script src="{{ asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js') }}"></script>
    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page: Form Repeater JS-->
    <script src="{{ asset('app-assets/js/scripts/forms/form-repeater.js') }}"></script>
    <!-- END: Page JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('app-assets/js/scripts/pages/app-calendar-events.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/app-calendar.js') }}"></script>

    <!--JS For Role-->
    <script src="{{ asset('app-assets/js/scripts/pages/modal-add-role.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/pages/app-access-roles.js') }}"></script>
    <!--JS For Role-->
    <!-- END: Page JS-->

    @yield('js')
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>

</html>
