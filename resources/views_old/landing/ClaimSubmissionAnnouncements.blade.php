@extends('layouts.master')
@section('title')
Claim Submission - {{ env('APP_NAME')}}
@endsection
@push('styles')
@endpush
@section('content')
    <!-- Start Subheader -->
    <div class="sub-header p-relative">
        <div class="overlay overlay-bg-black"></div>
        <div class="pattern"></div>
        <div class="section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="sub-header-content p-relative">
                            <h1 class="text-custom-white lh-default fw-600">Claim Submission</h1>
                            <ul class="custom">
                                <li> <a href="/" class="text-custom-white">Home</a>
                                </li>
                                <li class="text-custom-white active">Claim Submission</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Subheader -->
    <!-- start aboutus -->
    <section class=" parallax mt-20 mb-xl-30">
      
        <div class="container">
            {{-- <div class="section-header">
                <div class="section-heading">
                    <h3 class="text-custom-black fw-700">Claim Submissions</h3>
                </div>
            </div> --}}
            <div class="row">

                <div class="col-lg-12">
                    <div class="table-responsive">
                        <p>1.OTP exemption for Aadhar Authentication is made available for sales which took place during April 1, 2024 till June 20, 2024. However, Aadhar authentication is mandatory for sales w.e.f. June 21, 2024 onwards.</p>
                    <p>2.PAN card submission has been allowed as identity proof as an option, in addition to Aadhar Card for the state of Assam as in case of FAME-II.</p>
                    <p>3.OEMs are hereby allowed to submit claims twice a month.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--About-two-section-end-->
@endsection
