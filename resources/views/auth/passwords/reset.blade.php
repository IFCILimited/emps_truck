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
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('assets/images/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="#">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <!-- Bootstrap -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Fontawesome -->
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet">
    <!-- Flaticons -->
    <link href="{{ asset('assets/css/font/flaticon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/font/flaticon.css') }}" rel="stylesheet">
    <!-- Slick Slider -->
    <link href="{{ asset('assets/css/slick.css') }}" rel="stylesheet">
    <!-- Range Slider -->
    <link href="{{ asset('assets/css/ion.rangeSlider.min.css') }}" rel="stylesheet">
    <!-- Datepicker -->
    <link href="{{ asset('assets/css/datepicker.css') }}" rel="stylesheet">
    <!-- magnific popup -->
    <link href="{{ asset('assets/css/magnific-popup.css') }}" rel="stylesheet">
    <!-- Nice Select -->
    <link href="{{ asset('assets/css/nice-select.css') }}" rel="stylesheet">
    <!-- Animate -->
    <link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- Custom Responsive -->
    <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,700&amp;display=swap" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- place -->
    @stack('styles')
    <style>
        body {
            background: none; /* Remove any background */
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-menu > a {
            display: block;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border-bottom: 1px solid #eee;
            transition: 0.5s;
            white-space: nowrap;
            text-transform: uppercase;
        }

        .dropdown-submenu > a {
            display: block;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border-bottom: 1px solid #eee;
            transition: 0.5s;
            white-space: nowrap;
            text-transform: uppercase;
        }

        .dropdown-menu > a:hover {
            background-color: #0070ba;
            padding-left: 35px;
            transition: 0.5s;
            color: #fff;
        }

        .dropdown-submenu > a:hover {
            background-color: #0070ba;
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

<body>

    <div class="row justify-content-center login-card">
        <div class="col-md-6">
            <div class="card" style="margin-top: 10rem;margin-bottom: 5rem;">
                <div class="card-header">
                    <b>Reset Password</b>
                    <span class="float-right"><a href="/"><b>Home</b></a></span>
                </div>
                <div class="card-body">
                    @if($userid == null)
                    <form method="POST" action="{{route('password.passwordUpdate')}}" id="passwordReq">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right"><strong> E-Mail Address</strong></label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="" required autocomplete="email" autofocus>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 mt-3 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>

                    @elseif($userid != null)
                    <form method="POST" action="{{route('password.updatePassword')}}" id="passwordReq">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                            <div class="col-md-6">
                                <input id="email" readonly type="email" class="form-control readonly" value="{{$user->email}}" name="email" required autocomplete="email" autofocus>
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autocomplete="password" autofocus>
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <label for="cpassword" class="col-md-4 col-form-label text-md-right">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="cpassword" type="password" class="form-control" name="cpassword" required autocomplete="cpassword" autofocus>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 mt-3 text-center">
                                <button type="submit" class="btn btn-primary">
                                    Update Password
                                </button>
                            </div>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Popper -->
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- Range Slider -->
    <script src="{{ asset('assets/js/ion.rangeSlider.min.js') }}"></script>
    <!-- Slick Slider -->
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
    <!-- Datepicker -->
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.en.js') }}"></script>
    <!-- Nice Select -->
    <script src="{{ asset('assets/js/jquery.nice-select.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('assets/js/jquery-steps.js') }}"></script>
    <!-- Nice Select -->
    <script src="{{ asset('assets/js/particles.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnd9JwZvXty-1gHZihMoFhJtCXmHfeRQg"></script>
    <!-- Isotope Gallery -->
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <!-- Wow js -->
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    @include('sweetalert::alert')
    <!-- /Place all Scripts Here -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.dropdown-submenu').forEach(function (element) {
                element.addEventListener('mouseover', function (e) {
                    const submenu = this.querySelector('.dropdown-menu');
                    if (submenu) {
                        submenu.classList.add('show');
                    }
                });

                element.addEventListener('mouseout', function (e) {
                    const submenu = this.querySelector('.dropdown-menu');
                    if (submenu) {
                        submenu.classList.remove('show');
                    }
                });
            });
        });
        $(document).ready(function () {
            $('.sub-menu-HS').hide();
            $('.dropdown-submenu').on("mouseenter", function () {
                var $submenu = $(this).children('.dropdown-menu');
                $submenu.addClass('show');
                $('.sub-menu-HS').show();
            }).on("mouseleave", function () {
                $('.sub-menu-HS').hide();
                var $submenu = $(this).children('.dropdown-menu');
                $submenu.removeClass('show');
            });

            $(document).on('click', function (e) {
                if (!$(e.target).closest('.dropdown-menu').length) {
                    $('.dropdown-menu.show').removeClass('show');
                }
            });
        });
    </script>
    @stack('scripts');
</body>

</html>
