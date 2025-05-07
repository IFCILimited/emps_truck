@extends('layouts.master')
@section('title')
Login - PM E-Drive
@endsection
@push('styles')
@push('styles')
    <style>
        
        .invalid-feedback{
            width: 100%;
            margin-top: .25rem;
            font-size: 80%;
            color: #dc3545;
            display: block;
        }
        .full-screen-loader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            /* Semi-transparent white background */
            z-index: 9999;
            /* Ensure it appears above other content */
        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        .loading-text {
            position: absolute;
            top: calc(50% + 30px);
            left: 50%;
            transform: translate(-50%, -50%);
            color: #333;
            font-size: 14px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush
@endpush
@section('content')

@php
if (session('role_id') == 1) {
   $utype = 'MHI';
} elseif (session('role_id') == 2) {
   $utype = 'OEM';
} elseif (session('role_id') == 3) {
   $utype = 'DEALER';
} elseif (session('role_id') == 4) {
   $utype = 'TESTINGAGENCY';
} elseif (session('role_id') == 5) {
   $utype = 'PMA';
} elseif (session('role_id') == 6) {
   $utype = 'AUDITOR';
} 
elseif (session('role_id') == 10) {
   $utype = 'MHI-AS';
} 
elseif (session('role_id') == 11) {
   $utype = 'MHI-DS';
} 
elseif (session('role_id') == 12) {
   $utype = 'MHI-OnlyView';
} 

else {
   $utype = null;
}
//  $permittedip = "59.145.23.38";
// $ipaddress = getenv("REMOTE_ADDR") ;
@endphp
        <div class="sub-header p-relative">
            <div class="overlay overlay-bg-black"></div>
            <div class="pattern"></div>
            <div class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="sub-header-content p-relative">
                                <h1 class="text-custom-white lh-default fw-600">Login</h1>
                                <ul class="custom">
                                    <li> <a href="/" class="text-custom-white">Home</a>
                                    </li>
                                    <li class="text-custom-white active">Login</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Subheader -->
        <div class="full-screen-loader">
            <div class="loader"></div>
            <div class="loading-text">Please wait...</div>
        </div>
        <!-- Start Contact Bottom -->
        <section class="section-padding-bottom user-info-details">
            <div class="container">
                <div class="row">
                    <div class="offset-lg-3 col-lg-6">
                        <div class="user-info-tabs">
                            <div id="add-user-tab" class="step-app">
                                
                                <div class="row">
                                    <div class="col-12" id="step-1">
                                        <div class="step-tab-inner">
                                            <div class="heading text-center">
                                                <h4 class="text-custom-black fw-600">Log in to account</h4>
                                            </div>
                                            <form class="theme-form" method="POST" action="{{ route('login') }}" id="loginForm">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <input class="form-control" type="hidden" value="{{ $utype }}" readonly name="usertype">
                                                            <input class="form-control" type="hidden" value="{{ $utype }}" readonly name="usertype">
                                                            <input class="form-control readonly" type="text"
                                                                placeholder=" @if ($utype == 'TESTINGAGENCY') Testing Agency @elseif($utype == 'DEALER') Dealer @else {{ $utype }} @endif"
                                                                readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-custom-black fs-14 fw-600"> Username </label>
                                                            <input class="form-control @error('username') is-invalid @enderror" type="text"
                                name="identity" id="identity" required="" placeholder="Username">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="text-custom-black fs-14 fw-600"> Password </label>
                                                            <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    name="password" id="password" required="" placeholder="Password">
                                <div class="show-hide"> <span class="show"></span></div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                           
                                                            <div class="captcha d-flex" >
                                                                <span>{!! Captcha::img() !!}</span>
                                                            <button type="button" class="btn" style="color: #000000" id="refresh-captcha" >
                                                                <i class="fa fa-refresh" aria-hidden="true"></i>
                                                            </button>
                                                            <input type="text" class="form-control mt-2 " name="captcha" id="captcha">
                                                            </div>
                                                            @error('captcha')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group mb-0">
                                                            <div class="checkbox p-0">
                                                                <input id="checkbox1" type="checkbox">
                                                                <label class="text-muted" for="checkbox1">Remember password</label>
                                                            </div>
                                                            <div class="text-end mt-3">
                                                                <button class="btn btn-primary btn-block w-100" id="signin-btn" type="submit"
                                                                style="border-radius: 20px;">Sign in</button>
                                                            </div>
                                                        </div>
                                                        <div class="text-center mt-3">
                                                            @if (Route::has('password.forgot'))
                                                                <a class="btn btn-link" href="{{ route('password.forgot') }}">
                                                                    <span>Forgot Your Password?</span>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        @if (session('role_id') == 2)
                                                            <p class="m-1 text-center">Don't have an account? <a class="ms-2"
                                                                    href="{{ route('register') }}" style="color: blue;">Register</a></p>
                                                        @endif

                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- End Contact Bottom -->
    @endsection
    @push('scripts')
    <script src="{{ asset('assets/js/landing/crypto-js.min.js') }}"></script>
    <script src="{{ asset('assets/js/landing/aes.min.js') }}"></script>
    <script>
        $('#refresh-captcha').click(function() {
       $.ajax({
           type: 'GET',
           url: '{{ route('refresh.captcha') }}',
           success: function(data) {
               $('.captcha span').html(data.captcha);
           }
       });
   });
       document.querySelector('#loginForm').addEventListener('submit', (e) => {
           e.preventDefault();
           var id = document.getElementById("identity");
           var pwd = document.getElementById("password");
           var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
           var iv = CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");
           var encId = CryptoJS.AES.encrypt(id.value, key, {
               iv,
               padding: CryptoJS.pad.ZeroPadding,
           });
           var encPwd = CryptoJS.AES.encrypt(pwd.value, key, {
               iv,
               padding: CryptoJS.pad.ZeroPadding,
           });
           id.value = encId.toString();
           pwd.value = encPwd.toString();
           var loginForm = document.getElementById("loginForm");
           loginForm.submit();
       });
  
       document.getElementById('loginForm').addEventListener('submit', function(event) {
           event.preventDefault(); // Prevent form submission
           var loader = document.querySelector('.full-screen-loader');
           loader.style.display = 'block'; // Display loader
           var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
           document.querySelector('input[name="_token"]').value = token;
           setTimeout(function() {
               document.getElementById('loginForm').submit();
           }, 2000);
       });
   </script>
    @endpush