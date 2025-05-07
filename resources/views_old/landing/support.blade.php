@extends('layouts.master')
@section('title')
Support - {{ env('APP_NAME')}}
@endsection
@push('styles')
@endpush
@section('content')
        <div class="sub-header p-relative">
            <div class="overlay overlay-bg-black"></div>
            <div class="pattern"></div>
            <div class="section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <div class="sub-header-content p-relative">
                                <h1 class="text-custom-white lh-default fw-600">Contact Us</h1>
                                <ul class="custom">
                                    <li> <a href="/" class="text-custom-white">Home</a>
                                    </li>
                                    <li class="text-custom-white active">Contact Us</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Subheader -->
       
        <!-- Start Contact Bottom -->
        <section class="section-padding bg-gray contact-bottom">
            <div class="container">
                <div class="section-header">
                    <div class="section-heading">
                        <h3 class="text-custom-black fw-700">For Support 
                        </h3>
                        <div class="section-description">
                            <p class="text-light-white">Office Timings – 09:45 AM – 05:45 PM (on Working Days) </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-sm-6">
                        <div class="contact-info bx-wrapper bg-custom-white text-center mb-md-40">
                            <div class="contact-info-wrapper">
                                <div class="icon mb-xl-20"> <i class="flaticon-telephone"></i>
                                </div>
                                <h5 class="text-custom-black fw-600">Phone</h5>
                                <p class="text-light-white">+91 9319019073</p> <strong>[Only Office Hours]</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="contact-info bx-wrapper bg-custom-white text-center mb-md-40">
                            <div class="contact-info-wrapper">
                                <div class="icon mb-xl-20"> <i class="flaticon-email"></i>
                                </div>
                                <h5 class="text-custom-black fw-600">For technical support kindly contact on: </h5>
                                <p class="text-light-white">advisory[dot]support[at]ifciltd[dot]com </p> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6">
                        <div class="contact-info bx-wrapper bg-custom-white text-center">
                            <div class="contact-info-wrapper">
                                <div class="icon mb-xl-20"> <i class="flaticon-pin"></i>
                                </div>
                                <h5 class="text-custom-black fw-600">IFCI Limited
                                    </h5>
                                <p class="text-light-white"> IFCI Tower,61 Nehru Place,
                                    New Delhi-110 019.</p> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Contact Bottom -->
    