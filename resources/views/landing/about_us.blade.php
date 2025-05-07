@extends('layouts.master')
@section('title')
    About Us - {{ env('APP_NAME')}}
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
                                <h1 class="text-custom-white lh-default fw-600">Brief</h1>
                                <ul class="custom">
                                    <li> <a href="/" class="text-custom-white">Home</a>
                                    </li>
                                    <li class="text-custom-white active">About Us</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section class="section-padding about-us-sec p-relative">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 align-self-center">
                        <div class="about-left-side mb-md-40 ">
                            <p class="text-light-white"><b>PM Electric Drive Revolution in Innovative Vehicle Enhancement (PM E-DRIVE) Scheme - Cabinet approves PM – E -Drive for promotion of electric mobility in the country with outlay of Rs.10,900 crore for 2 years.</b></p>
                            <p class="text-light-white">Component of the Scheme:</p>
                            {{-- <p> </p> --}}
                                <ul>
                                    <li>Subsidies / Demand incentives worth Rs.3,679 to incentivize  e- 2Ws, e-3Ws, e-ambulance, e- trucks and other emerging EVs.</li>
                                    <li>E- Voucher for EV buyers to avail demand incentive under the scheme.</li>
                                    <li>Allocation of Rs.500 crore for the deployment  for e- ambulances.</li>
                                    <li class="about-left-side-pr-0">Provision for Rs. 4,391 crore for procurement of 14,028 e buses by STU / public transport agencies.</li>
                                    <li class="about-left-side-pr-0">Proposal  for 22,100 fast chargers for e- 4 Ws, 1800 fast chargers for e-buses and 48,400 fast chargers for e- 2W/3Ws.</li>
                                </ul>
                           
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class=" p-relative">
                            <div class="first-img p-relative">
                                <img src="assets/images/aboutus.jpg" class="img-fluid full-width" alt="about us">
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-light-white-skew-2 bg-custom-black"></div>
        </section>
        @endsection