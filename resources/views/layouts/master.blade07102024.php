<!DOCTYPE html>
<html lang="en">


<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="keywords" content="#">
	<meta name="description" content="#">
	<title>@yield('title')</title>
	<!-- Fav and touch icons -->
	
	<!-- Bootstrap -->
	<link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<!-- Fontawesome -->
	<link href="{{ asset('assets/css/font-awesome.css')}}" rel="stylesheet">
	<!-- Flaticons -->
	<link href="{{ asset('assets/css/font/flaticon.css')}}" rel="stylesheet">
	<link href="{{ asset('assets/font/flaticon.css')}}" rel="stylesheet">
	<!-- Slick Slider -->
	<link href="{{ asset('assets/css/slick.css')}}" rel="stylesheet">
	<!-- Range Slider -->
	<link href="{{ asset('assets/css/ion.rangeSlider.min.css')}}" rel="stylesheet">
	<!-- Datepicker -->
	<link href="{{ asset('assets/css/datepicker.css')}}" rel="stylesheet">
	<!-- magnific popup -->
	<link href="{{ asset('assets/css/magnific-popup.css')}}" rel="stylesheet">
	<!-- Nice Select -->
	<link href="{{ asset('assets/css/nice-select.css')}}" rel="stylesheet">
	<!-- Animate -->
	<link href="{{ asset('assets/css/animate.css')}}" rel="stylesheet">
	<!-- Custom Stylesheet -->
	<link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
	<!-- Custom Responsive -->
	<link href="{{ asset('assets/css/responsive.css')}}" rel="stylesheet">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&amp;display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Merriweather:400,700&amp;display=swap" rel="stylesheet">
	<!-- HTML5 Shim and Respond.js')}} IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js')}} doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js')}}/1.4.2/respond.min.js')}}"></script>
    <![endif]-->
	<!-- place -->
    @stack('styles')
    <style>
        .dropdown-submenu {
            position: relative;
        }
        .dropdown-menu > a{
            display: block;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: 500;
  border-bottom: 1px solid #eee;
  transition: 0.5s;
  white-space: nowrap;
  text-transform: uppercase;
        }
        .dropdown-submenu > a{
            display: block;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: 500;
  border-bottom: 1px solid #eee;
  transition: 0.5s;
  white-space: nowrap;
  text-transform: uppercase;
        }
        .dropdown-menu > a:hover{
            background-color: #ff8214;
  padding-left: 35px;
  transition: 0.5s;
  color: #fff;
        }
        .dropdown-submenu > a:hover{
            background-color: #ff8214;
  padding-left: 35px;
  transition: 0.5s;
  color: #fff;
        }

        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: -100%;
            margin-top: -1px;

        }

    </style>
</head>

<body class="animated-banner">
	<!-- Start Main Body -->
	<div class="main-body">
        <header class="header-style-1">
            <!-- Start Topbar -->
            {{-- <div class="topbar-style-1">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="left-side">
                                <div class="language-box">
                                    <div class="language p-relative">
                                        <img src="assets/images/flag.png" alt="flag">
                                        <select>
                                            <option>English</option>
                                            <option>German</option>
                                            <option>Japanese</option>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-custom-black no-margin">9000 Regency Parkway, Suite 400 Cary</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="right-side">
                                <ul class="custom">
                                    <li><a href="#" class="text-custom-black fs-14"><i class="fab fa-facebook-f"></i></a>
                                    </li>
                                    <li><a href="#" class="text-custom-black fs-14"><i class="fab fa-twitter"></i></a>
                                    </li>
                                    <li><a href="#" class="text-custom-black fs-14"><i class="fab fa-linkedin"></i></a>
                                    </li>
                                    <li><a href="#" class="text-custom-black fs-14"><i class="fab fa-youtube"></i></a>
                                    </li>
                                    <li class="search"><a href="javascript:void(0)" class="text-custom-black fs-14"><i class="fas fa-search"></i></a>
                                    </li>
                                    <li class="topbar-search">
                                        <form method="get">
                                            <input type="search" class="form-control form-control-custom" name="search" placeholder="Search..." value="">
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- End Topbar -->
            <!-- Start Navigation -->
            <div class="main-navigation-style-1">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="navigation">
                                <div class="logo">
                                    <a href="/">
                                        <img src="{{ asset('assets/images/MHI-logo.png') }}" class="img-fluid image-fit" style="width: 100%; " alt="Logo">
                                    </a>
                                </div>
                                <div class="main-menu">
                                    <div class="mobile-logo">
                                        <a href="/">
                                            <img src="{{ asset('assets/images/MHI-logo.png') }}" class="img-fluid image-fit" style="width: 100%; " alt="Logo">
                                        </a>
                                    </div>
                                    <nav>
                                        <ul class="custom">
                                            <li class="menu-item "> <a href="/" class="text-custom-black">Home</a>
                                            </li>
                                            <li class="menu-item menu-item-has-children"> <a href="#" class="text-custom-black">About Us</a>
                                                <ul class="custom sub-menu">
                                                    <li class="menu-item"> <a href="{{ route('about-us') }}" class="text-light-grey">Brief</a>
                                                    </li>
                                                    <li class="menu-item"> <a href="{{ route('who') }}" class="text-light-grey">Who's who</a>
                                                    </li>
                                                </ul>
                                            </li>
                                           
                                            <li class="menu-item  menu-item-has-children"> <a href="#" class="text-custom-black">Scheme</a>
                                                <ul class="custom sub-menu">
                                                    <li class="menu-item"> <a href="{{ route('policy_document') }}" class="text-light-grey">Notifications</a>
                                                    </li>
                                                    <li class="menu-item"> <a href="{{ route('policy_procedure') }}" class="text-light-grey">Guidelines</a>
                                                    </li>
                                                    
                                                </ul>
                                            </li>
                                            <li class="menu-item   menu-item-has-children"> <a href="#" class="text-custom-black">Announcements</a>
                                                <ul class="custom sub-menu">
                                                    <li class="menu-item"> <a href="{{ route('press_release') }}" class="text-light-grey">Press Release</a>
                                                    </li>
                                                    {{-- <li class="menu-item"> <a href="{{ route('Claim_submission') }}" class="text-light-grey">Claim submission</a>
                                                    </li> --}}
                                                   
                                                </ul>
                                            </li>
                                            <li class="menu-item  "> <a href="{{ route('impotrant-links') }}" class="text-custom-black">Important Links</a>
                                            </li>
                                            <li class="menu-item   menu-item-has-children"> <a href="#" class="text-custom-black">Contact Us</a>
                                                <ul class="custom sub-menu">
                                                    <li class="menu-item"> <a href="{{ route('support') }}" class="text-light-grey">Support</a>
                                                    </li>
                                                    <li class="menu-item"> <a href="{{ route('contact-us') }}" class="text-light-grey">Contact Detail</a>
                                                    {{-- <li class="menu-item"> <a href="{{ route('FAQs') }}" class="text-light-grey">FAQ's</a>
                                                    </li> --}}
                                                </ul>
                                            </li>
                                            
                                        </ul>
                                    </nav>
                                    <div class="right-side">

                                        <div class="cta-btn">
                                            <button class="btn-first btn-submit dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                LogIn
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <div class="dropdown-submenu">
                                                    <a class="dropdown-item dropdown-toggle" href="#">MHI</a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('signin', encrypt(10)) }}">MHI AS</a>
                                                        <a class="dropdown-item" href="{{ route('signin', encrypt(11)) }}">MHI DS</a>
                                                        <a class="dropdown-item" href="{{ route('signin', encrypt(12)) }}">MHI View Only</a>
                                                    </div>
                                                </div>
                                                <a class="dropdown-item" href="{{ route('signin', encrypt(2)) }}">OEM</a>
                                                <a class="dropdown-item" href="{{ route('signin', encrypt(3)) }}">Dealers</a>
                                                <a class="dropdown-item" href="{{ route('signin', encrypt(4)) }}">Testing Agency</a>
                                                <a class="dropdown-item" href="{{ route('signin', encrypt(5)) }}">PMA</a>
                                                <a class="dropdown-item" href="{{ route('signin', encrypt(6)) }}">Auditor</a>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="hamburger-menu">
                                    <div class="menu-btn"> <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Navigation -->
        </header>
        @yield('content')
    </div>
    <footer class="bg-black section-padding footer">
        <div class="overlay" style="
    background: #000;
    opacity: 0.5;
"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="footer-box mb-md-80">
                        <div class="footer-heading">
                            <h4 class="text-custom-white no-margin">Useful Links</h4>
                        </div>
                        <ul class="custom links" style="column-count: 2;">
                            <li> <a href="{{ route('about-us') }}" class="text-custom-white">About Us</a>
                            </li>
                            <li> <a href="{{ route('who') }}" class="text-custom-white">Who's who</a>
                            </li>
                            <li> <a href="{{ route('policy_document') }}" class="text-custom-white">Notifications</a>
                            </li>
                            <li> <a href="{{ route('policy_procedure') }}" class="text-custom-white">Guidelines</a>
                            </li>
                            <li> <a href="{{ route('press_release') }}" class="text-custom-white">Press Release</a>
                            </li>
                       
                            <li> <a href="{{ route('impotrant-links') }}" class="text-custom-white">Important Links</a>
                            </li>
                            <li> <a href="{{ route('support') }}" class="text-custom-white">Support</a>
                            </li>
                            <li> <a href="{{ route('contact-us') }}" class="text-custom-white">Contact Detail</a>
                            </li>
                            <li> <a href="{{ route('FAQs') }}" class="text-custom-white">FAQ's</a>
                            </li>
                           

                            
                        </ul>
                    </div>
                </div>
                {{-- <div class="col-lg-3 col-sm-6">
                    
                </div> --}}
                <div class="col-lg-1 col-md-1 col-sm-1">
                    
                </div>
                <div class="col-lg-5 col-md-5 col-sm-12">
                    <div class="footer-box footer-developed-By">
                        <div class="footer-heading mt-60">
                            <h4 class="mt-3 text-left text-custom-white">Portal Designed and Developed By <a href="https://www.ifciltd.com/?q=en/content/what-we-are" target="_blank"> IFCI Ltd.</a></h4>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyright">
        <div class="container">
            <div class="row">
              
                <div class="col-lg-12">
                    <p class="text-custom-white no-margin text-center">Copyright &#169; 2024 Ministry of Heavy Industries, Government of India. All rights reserved.</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer -->
    <div id="back-top" class="back-top"> <a href="#top"><i class="flaticon-up-arrow"></i></a>
    </div>
	
	<!-- End Main Body -->
	<!-- Place all Scripts Here -->
	<!-- jQuery -->
	<script src="{{ asset('assets/js/jquery.min.js')}}"></script>
	<!-- Popper -->
	<script src="{{ asset('assets/js/popper.min.js')}}"></script>
	<!-- Bootstrap -->
	<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
	<!-- Range Slider -->
	<script src="{{ asset('assets/js/ion.rangeSlider.min.js')}}"></script>
	<!-- Slick Slider -->
	<script src="{{ asset('assets/js/slick.min.js')}}"></script>
	<!-- Datepicker -->
	<script src="{{ asset('assets/js/datepicker.js')}}"></script>
	<script src="{{ asset('assets/js/datepicker.en.js')}}"></script>
	<!-- Nice Select -->
	<script src="{{ asset('assets/js/jquery.nice-select.js')}}"></script>
    <!-- Steps -->
    <script src="{{ asset('assets/js/jquery-steps.js')}}"></script>
	<!-- Nice Select -->
	<script src="{{ asset('assets/js/particles.js')}}"></script>
	<!-- Magnific Popup -->
	<script src="{{ asset('assets/js/jquery.magnific-popup.min.js')}}"></script>
	<!-- Google Map -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnd9JwZvXty-1gHZihMoFhJtCXmHfeRQg"></script>
	<!-- Isotope Gallery -->
	<script src="{{ asset('assets/js/isotope.pkgd.min.js')}}"></script>
	<!-- Wow js -->
	<script src="{{ asset('assets/js/wow.min.js')}}"></script>
	<!-- Custom Js -->
	<script src="{{ asset('assets/js/custom.js')}}"></script>
	<!-- /Place all Scripts Here -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.dropdown-submenu').forEach(function(element) {
                element.addEventListener('mouseover', function(e) {
                    const submenu = this.querySelector('.dropdown-menu');
                    if (submenu) {
                        submenu.classList.add('show');
                    }
                });
    
                element.addEventListener('mouseout', function(e) {
                    const submenu = this.querySelector('.dropdown-menu');
                    if (submenu) {
                        submenu.classList.remove('show');
                    }
                });
            });
        });
        $(document).ready(function() {
                $('.sub-menu-HS').hide();
            $('.dropdown-submenu').on("mouseenter", function() {
                var $submenu = $(this).children('.dropdown-menu');
                $submenu.addClass('show');
                $('.sub-menu-HS').show();
            }).on("mouseleave", function() {
                $('.sub-menu-HS').hide();
                var $submenu = $(this).children('.dropdown-menu');
                $submenu.removeClass('show');
            });
    
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.dropdown-menu').length) {
                    $('.dropdown-menu.show').removeClass('show');
                }
            });
        });
    </script>
    @stack('scripts')
</body>


</html>
