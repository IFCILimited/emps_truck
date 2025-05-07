@extends('layouts.master')
@section('title')
FAQ's - {{ env('APP_NAME')}}
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
                                <h1 class="text-custom-white lh-default fw-600">FAQ's</h1>
                                <ul class="custom">
                                    <li> <a href="/" class="text-custom-white">Home</a>
                                    </li>
                                    <li class="text-custom-white active">FAQ's</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Subheader -->
       
        <!-- Start Contact Bottom -->
        <section class="section-padding loan-faqs-sec bg-light-white findrate-top">
			
			<div class="container">
				<div class="row">
					
					<div class="col-xl-12 col-lg-6 align-self-center">
						<div id="accordion" class="faqs-accordion">
							<div class="card">
								<div class="card-header" id="headingOne">
									<button class="collapsebtn collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false">Applicability of the Scheme </button>
								</div>
								<div id="collapseOne" class="collapse" data-parent="#accordion" style="">
									<div class="card-body">
                                        <p>Electric Two-Wheelers (e-2w): In addition to commercial use, privately or corporate-owned registered e-2ws are also eligible.</p>
                            
                                        <p>Electric Three -Wheelers (e-3w): Only eligible for commercial use.</p>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingTwo">
									<button class="collapsebtn collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false">Manufacturing and Registration Period</button>
								</div>
								<div id="collapseTwo" class="collapse" data-parent="#accordion" style="">
									<div class="card-body">
                                        <p>All EVs must be manufactured and registered within the validity period of the {{ env('APP_NAME')}}-2024 certificate.</p>
                                        <p>EVs registered after the scheme's terminal date (currently 31st September 2024) are not eligible for incentives.</p>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingThree">
									<button class="collapsebtn collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false">Beneficiaries of the Scheme</button>
								</div>
								<div id="collapseThree" class="collapse" data-parent="#accordion" style="">
									<div class="card-body">
                                        <p>Individual Beneficiaries: Only one electric vehicle (EV) of a specific category per individual will qualify for incentives.</p>
                                        <p>Individuals must validate Aadhar authentication linked to their mobile number to be eligible for incentives.</p>
                                        <p>Each mobile number can only be used once for incentive purposes, preventing multiple claims by the same individual.</p>
                                        <p>Government Departments/Agencies: EVs purchased by any Central/State Government department or government agency are not eligible for demand incentives.</p>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingFour">
									<button class="collapsebtn collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false">Eligibility of EVs Manufactured under FAME-3.0</button>
								</div>
								<div id="collapseFour" class="collapse" data-parent="#accordion" style="">
									<div class="card-body">
										<p>EVs manufactured under the FAME-II Scheme are not eligible for incentives under the {{ env('APP_NAME')}}-2024 scheme.</p>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingFive">
									<button class="collapsebtn collapsed" data-toggle="collapse" data-target="#collapseFive"> Claim Submission Frequency for OEMs </button>
								</div>
								<div id="collapseFive" class="collapse" data-parent="#accordion">
									<div class="card-body">
                                        <p>OEMs can upload claims to the {{ env('APP_NAME')}}-2024 portal once a month.</p>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingsix">
									<button class="collapsebtn collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="false">Claim Submission Deadline for OEMs</button>
								</div>
								<div id="collapsesix" class="collapse" data-parent="#accordion" style="">
									<div class="card-body">
										<p>OEMs must submit claims within 120 days of the sale of the EV.</p>
                            <p>Claims submitted after 120 days will not be accepted on the portal.</p>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingseven">
									<button class="collapsebtn collapsed" data-toggle="collapse" data-target="#collapseseven">Incentives for Resold EVs</button>
								</div>
								<div id="collapseseven" class="collapse" data-parent="#accordion">
									<div class="card-body">
										<p>Resold EVs are not eligible for incentives. Only the original purchase qualifies for incentives.</p>
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