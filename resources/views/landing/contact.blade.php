@extends('layouts.master')
@section('title')
Contact Us - {{ env('APP_NAME')}}
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
                {{-- <div class="section-header">
                    <div class="section-heading">
                        <h3 class="text-custom-black fw-700">Contact Details
                        </h3>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="contact-info bx-wrapper bg-custom-white text-center mb-md-40">
                            <div class="contact-info-wrapper">
                                <div class="icon mb-xl-20"> <i class="flaticon-user"></i>
                                </div>
                                <p>Dr. Hanif Qureshi, IPS</p>
                                <p>Additional Secretary</p>
                                <p><i class="fa fa-phone"></i> 011-23062365</p>
                                <p><i class="fa fa-envelope"></i> jsauto[at]gov[dot]in</p>
                                <p><i class="fa fa-map-marker"></i> MHI, Udyog Bhawan, Rafi Marg <br>New Delhi-110011</br></p>
                                <p>Room No: 126-C</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="contact-info bx-wrapper bg-custom-white text-center mb-md-40">
                            <div class="contact-info-wrapper">
                                <div class="icon mb-xl-20"> <i class="flaticon-user"></i>
                                </div>
                                <p>Shri Amrendra Kishore Singh, IOFS</p>
                                <p>Deputy Secretary</p>
                                <p><i class="fa fa-phone"></i> 011- 23061745</p>
                                <p><i class="fa fa-envelope"></i> dsem-mhi[at]gov[dot]in</p>
                                <p><i class="fa fa-map-marker"></i> MHI, Udyog Bhawan, Rafi Marg <br>New Delhi-110011</br></p>
                                <p>Room No: 275-E</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="contact-info bx-wrapper bg-custom-white text-center mb-md-40">
                            <div class="contact-info-wrapper">
                                <div class="icon mb-xl-20"> <i class="flaticon-user"></i>
                                </div>
                                <p>Shri Sumit Kumar</p>
                                <p>Deputy Secretary</p>
                                <p><i class="fa fa-phone"></i> 011-23061845</p>
                                <p><i class="fa fa-envelope"></i> sumit[dot]kr88[at]gov[dot]in</p>
                                <p><i class="fa fa-map-marker"></i> MHI, Udyog Bhawan, Rafi Marg <br>New Delhi-110011</br></p>
                                <p>Room No: 216-A</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="contact-info bx-wrapper bg-custom-white text-center mb-md-40">
                            <div class="contact-info-wrapper">
                                <div class="icon mb-xl-20"> <i class="flaticon-user"></i>
                                </div>
                                <p>Shri Ajay Kumar</p>
                                <p>Under Secretary</p>
                                <p><i class="fa fa-phone"></i> 011- 23061340</p>
                                <p><i class="fa fa-envelope"></i> ajay[dot]kumar03[at]gov[dot]in</p>
                                <p><i class="fa fa-map-marker"></i> MHI, Udyog Bhawan, Rafi Marg <br>New Delhi-110011</br></p>
                                <p>Room No: 387</p>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="col-lg-4 col-sm-6">
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
                    </div> --}}
                </div>
            </div>
        </section>
        <!-- End Contact Bottom -->
    @endsection