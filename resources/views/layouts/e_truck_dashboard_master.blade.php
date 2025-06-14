<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="{{ asset('admin/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" type="image/x-icon">
    <title>Dasboard</title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="{{ asset('admin/css2?family=Montserrat:wght@200;300;400;500;600;700;800&amp;display=swap') }}"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/font-awesome.css') }}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/icofont.css') }}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/themify.css') }}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/flag-icon.css') }}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/feather-icon.css') }}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/datatable-extension.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/echart.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/date-picker.css') }}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/bootstrap.css') }}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/style.css') }}">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/responsive.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    @stack('styles')
</head>

<body>
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader4"></div>
        </div>
    </div>

    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"> <a href="#"><img class="img-fluid for-light"
                                src="{{ asset('admin/images/logo/logo_dark.png') }}" alt="logo-light"><img
                                class="img-fluid for-dark" src="{{ asset('admin/images/logo/logo.png') }}"
                                alt="logo-dark"></a></div>
                    <div class="toggle-sidebar"> <i class="status_toggle middle sidebar-toggle"
                            data-feather="align-center"></i></div>
                </div>
                <div class="left-header col-xxl-5 col-xl-6 col-lg-5 col-md-4 col-sm-3 p-0">
                    <div> <a class="toggle-sidebar" href="#"> <i class="iconly-Category icli"> </i></a>
                        <div class="d-flex align-items-center gap-2 ">
                            <h4 class="f-w-600">Welcome <img class="mt-0" src="{{ asset('admin/images/hand.gif') }}"
                                    alt="hand-gif">
                                <span class="text-primary fw-bold">{{ Auth::user()->auth_name }}</span>, <span
                                    class="text-danger fw-bold">{{ Auth::user()->name }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="nav-right col-xxl-7 col-xl-6 col-md-7 col-8 pull-right right-header p-0 ms-auto">
                    <ul class="nav-menus">

                        <li>
                            <span class="text-danger p-3"><b>PM E-DRIVE</b></span>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-pill btn-sm"><i
                                    class="fa fa-home"></i>
                                {{ __('Home') }}
                            </a>
                            @guest
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            @else
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"
                                    class="btn btn-pill btn-outline-primary btn-sm"><i class="fa fa-power-off"></i>
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            @endguest
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Page Header Ends-->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper" data-layout="stroke-svg" {{--
                style="background-image: url({{ asset('images/bg2.jpg') }});"> --}}>
                {{-- <div class="sidebar-wrapper" data-layout="stroke-svg" style=" background: #129707;"> --}}
                <div class="logo-wrapper"><a href="#"><img class="img-fluid"
                            src="{{ asset('admin/images/logo/logo.png') }}" alt=""></a>
                    <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
                </div>
                <div class="logo-icon-wrapper"><a href="#"><img class="img-fluid"
                            src="{{ asset('admin/images/logo/logo-icon.png') }}" alt=""></a></div>
                <nav class="sidebar-main">
                    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                    <div id="sidebar-menu">
                        <ul class="sidebar-links" id="simple-bar">
                            <li class="back-btn"><a href="#"><img class="img-fluid"
                                        src="{{ asset('admin/images/logo/logo-icon.png') }}" alt=""></a>
                                <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2"
                                        aria-hidden="true"></i></div>
                            </li>
                            <li class="pin-title sidebar-main-title">
                            </li>
                            <li class="sidebar-main-title">
                                <div>
                                    <h6 class="lan-1">PM E-DRIVE</h6>
                                </div>
                            </li>
                            {{-- <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                    class="sidebar-link sidebar-title link-nav" href="{{ route('e-trucks.dashboard') }}">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg>
                                    <svg class="fill-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#fill-home') }}"></use>
                                    </svg><span>Dashboard</span>
                                    <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                </a></li> --}}

                            @if (Auth::user()->hasRole('OEM-Truck'))
                                @if (getParentId() == Auth::user()->id)
                                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                            class="sidebar-link sidebar-title link-nav"
                                            href="{{ route('e-trucks.manageCompanyDetails.index') }}">
                                            <svg class="stroke-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                                </use>
                                            </svg>
                                            <svg class="fill-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                                </use>
                                            </svg><span>Manage Profile Details</span>
                                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                        </a>
                                    </li>

                                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                            class="sidebar-link sidebar-title link-nav"
                                            href="{{ route('e-trucks.xEVPlants.index') }}">
                                            <svg class="stroke-icon">
                                                <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-project') }}">
                                                </use>
                                            </svg>
                                            <svg class="fill-icon">
                                                <use href="{{ asset('admin/svg/icon-sprite.svg#fill-project') }}">
                                                </use>
                                            </svg><span>Manage Plants</span>
                                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                        </a></li>
                                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                            class="sidebar-link sidebar-title link-nav"
                                            href="{{ route('e-trucks.bankDetails.index') }}">
                                            <svg class="stroke-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#stroke-landing-page') }}">
                                                </use>
                                            </svg>
                                            <svg class="fill-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#fill-landing-page') }}">
                                                </use>
                                            </svg><span>Manage Bank Details</span>
                                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                        </a></li>

                                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                            class="sidebar-link sidebar-title link-nav"
                                            href="{{ route('e-trucks.manageUser.index') }}">
                                            <svg class="stroke-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                                </use>
                                            </svg>
                                            <svg class="fill-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                                </use>
                                            </svg><span>Manage Users</span>
                                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                        </a>
                                    </li>
                                @endif

                                <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a
                                        class="sidebar-link sidebar-title" href="#">
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-sample-page') }}">
                                            </use>
                                        </svg><span>Manage Dealer </span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('e-trucks.manageDealer.index') }}">Dealer Details</a>
                                        </li>
                                        <li><a href="{{ route('e-trucks.manageDealer.operator') }}">
                                                Operator Details</a></li>
                                    </ul>
                                </li>
                                {{-- <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title link-nav"
                                        href="{{ route('e-trucks.unactiveUser') }}">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <span>Manage Dealer Devices</span>
                                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                    </a>
                                </li> --}}

                                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                        class="sidebar-link sidebar-title link-nav"
                                        href="{{ route('e-trucks.oemModel.index') }}">
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-home') }}"></use>
                                        </svg><span>Manage Model</span>
                                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                    </a></li>
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                        class="sidebar-link sidebar-title link-nav"
                                        href="{{ route('e-trucks.manageProductionData.index') }}">
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg><span>Manage Production Data</span>
                                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                    </a>
                                </li>

                                <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a
                                        class="sidebar-link sidebar-title" href="#">
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-sample-page') }}">
                                            </use>
                                        </svg><span>Manage Customer Details </span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('e-trucks.manageBuyerDetails.index', 'P') }}">Pending
                                                Customer
                                                Details</a></li>
                                        <li><a href="{{ route('e-trucks.manageBuyerDetails.index', 'A') }}">Approved
                                                Customer
                                                Details</a></li>
                                        <li><a href="{{ route('e-trucks.manageBuyerDetails.returnToDealer', 'R') }}">Return
                                                to
                                                Dealer</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a
                                        class="sidebar-link sidebar-title" href="#">
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-sample-page') }}">
                                            </use>
                                        </svg><span>Manage Bulk Customer Details </span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('e-trucks.manageBulkBuyerDetails.index', 'P') }}">Pending
                                                Customer
                                                Details</a></li>
                                        <li><a href="{{ route('e-trucks.manageBulkBuyerDetails.index', 'A') }}">Approved
                                                Customer
                                                Details</a></li>
                                        <li><a href="{{ route('e-trucks.manageBulkBuyerDetails.index', 'R') }}">Return
                                                to
                                                Dealer</a></li>
                                    </ul>
                                </li>
                                {{-- <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a
                                        class="sidebar-link sidebar-title" href="#">
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-sample-page') }}">
                                            </use>
                                        </svg><span>Manage Claim </span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('e-trucks.claimGenerate.index') }}">Generate Claim</a>
                                        </li>
                                        <li><a href="{{ route('e-trucks.claimToMhi.index') }}">Send Claim to MHI</a>
                                        </li>
                                        <li><a href="{{ route('e-trucks.claimSubmitted') }}">Claim Submitted</a></li>
                                    </ul>
                                </li> --}}
                                <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title link-nav"
                                        href="{{ route('e-trucks.VinChassis.index') }}">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <span>Vin-Chassis Search</span>
                                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                    </a>
                                </li>
                                {{-- <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title link-nav"
                                        href="{{ route('e-trucks.vinExcel.index') }}">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <span>Claim Generation validity</span>
                                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                    </a>
                                </li> --}}

                                {{-- <li class="sidebar-list">
                                    <a class="sidebar-link sidebar-title link-nav"
                                        href="{{ route('e-trucks.authenticationReport.index') }}">
                                        <i class="fa fa-thumb-tack"></i>
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <span> EMPS Authentication Report</span>
                                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                    </a>
                                </li> --}}
                                @php
                                    $vinCheck = DB::table('vin_chassis_edit')
                                        ->where('oem_id', Auth::user()->id)
                                        ->where('valid_from', '<=', now())
                                        ->where('valid_to', '>=', now())
                                        ->first();
                                @endphp
                                @if (isset($vinCheck) && $vinCheck->valid_from <= now() && $vinCheck->valid_to >= now())
                                    <li class="sidebar-list">
                                        <a class="sidebar-link sidebar-title link-nav"
                                            href="{{ route('e-trucks.editVin.index') }}">
                                            <i class="fa fa-thumb-tack"></i>
                                            <svg class="stroke-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                                </use>
                                            </svg>
                                            <svg class="fill-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                                </use>
                                            </svg>
                                            <span>Vin Edit</span>
                                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                        </a>
                                    </li>
                                @endif
                            @elseif(Auth::user()->hasRole('DEALER-Truck'))
                                @if (getParentId() == Auth::user()->id)
                                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                            class="sidebar-link sidebar-title link-nav"
                                            href="{{ route('e-trucks.manageOperator.index') }}">
                                            <svg class="stroke-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                                </use>
                                            </svg>
                                            <svg class="fill-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                                </use>
                                            </svg><span>Manage Operator</span>
                                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                        </a>
                                    </li>
                                    <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                            style="white-space: nowrap;" class="sidebar-link sidebar-title link-nav"
                                            href="{{ route('e-trucks.manage_vin_number.index') }}">
                                            <svg class="stroke-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#stroke-knowledgebase') }}">
                                                </use>
                                            </svg>
                                            <svg class="fill-icon">
                                                <use
                                                    href="{{ asset('admin/svg/icon-sprite.svg#fill-stroke-knowledgebase') }}">
                                                </use>
                                            </svg><span>Release Vin.</span>
                                            <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                        </a></li>
                                @endif
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                        style="white-space: nowrap;" class="sidebar-link sidebar-title link-nav"
                                        href="{{ route('e-trucks.checkEligibility.index') }}">
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-knowledgebase') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use
                                                href="{{ asset('admin/svg/icon-sprite.svg#fill-stroke-knowledgebase') }}">
                                            </use>
                                        </svg><span>Check Eligibility</span>
                                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                    </a></li>
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a
                                        class="sidebar-link sidebar-title" href="#">
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-sample-page') }}">
                                            </use>
                                        </svg><span>Customer Information </span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('e-trucks.buyerdetail.index') }}">Individual Customer
                                            </a></li>
                                        <li><a href="{{ route('e-trucks.buyerdetail.multi_buyers') }}">Bulk
                                                Customer</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i><a
                                        class="sidebar-link sidebar-title" href="#">
                                        <svg class="stroke-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-sample-page') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-sample-page') }}">
                                            </use>
                                        </svg><span>Return By OEM </span></a>
                                    <ul class="sidebar-submenu">
                                        <li><a href="{{ route('e-trucks.buyer.oemreturn') }}">Individual</a></li>
                                        <li><a href="{{ route('e-trucks.buyerbulk.oemreturn') }}">Bulk</a></li>
                                    </ul>
                                </li>
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                        style="white-space: nowrap;" class="sidebar-link sidebar-title link-nav"
                                        href="{{ route('e-trucks.Evoucher.index') }}">
                                        <svg class="stroke-icon">
                                            <use
                                                href="{{ asset('admin/svg/icon-sprite.svg#stroke-knowledgebase') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use
                                                href="{{ asset('admin/svg/icon-sprite.svg#fill-stroke-knowledgebase') }}">
                                            </use>
                                        </svg><span>Print E-Voucher</span>
                                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                    </a></li>
                                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a
                                        style="white-space: nowrap;" class="sidebar-link sidebar-title link-nav"
                                        href="{{ route('e-trucks.RCReport.index') }}">
                                        <svg class="stroke-icon">
                                            <use
                                                href="{{ asset('admin/svg/icon-sprite.svg#stroke-knowledgebase') }}">
                                            </use>
                                        </svg>
                                        <svg class="fill-icon">
                                            <use
                                                href="{{ asset('admin/svg/icon-sprite.svg#fill-stroke-knowledgebase') }}">
                                            </use>
                                        </svg><span>RC Report</span>
                                        <div class="according-menu"><i class="fa fa-angle-right"></i></div>
                                    </a></li>
                            @endif

                        </ul>
                        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                    </div>
                </nav>
            </div>
            <!-- Page Sidebar Ends-->
            @yield('content')
            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">&#169; Copyright © 2024 Ministry of Heavy Industries, Government of
                                India. All rights reserved
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- latest jquery-->
    <script src="{{ asset('admin/js/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/js/validation.js') }}"></script>
    <!-- Bootstrap js-->
    <script src="{{ asset('admin/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- feather icon js-->
    <script src="{{ asset('admin/js/icons/feather-icon/feather.min.js') }}"></script>
    <script src="{{ asset('admin/js/icons/feather-icon/feather-icon.js') }}"></script>
    <!-- scrollbar js-->
    <script src="{{ asset('admin/js/scrollbar/simplebar.js') }}"></script>
    <script src="{{ asset('admin/js/scrollbar/custom.js') }}"></script>
    <!-- Sidebar jquery-->
    <script src="{{ asset('admin/js/config.js') }}"></script>
    <!-- Plugins JS start-->
    <script src="{{ asset('admin/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('admin/js/sidebar-pin.js') }}"></script>
    <script src="{{ asset('admin/js/slick/slick.min.js') }}"></script>
    <script src="{{ asset('admin/js/slick/slick.js') }}"></script>
    <script src="{{ asset('admin/js/header-slick.js') }}"></script>
    <!-- calendar js-->
    <script src="{{ asset('admin/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('admin/js/datatable/datatable-extension/custom.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @stack('scripts')
    @include('sweetalert::alert')
    <script src="{{ asset('admin/js/script.js') }}"></script>
</body>

</html>
