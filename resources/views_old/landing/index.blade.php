@extends('layouts.master')

@section('title')
    {{-- Home - {{ env('APP_NAME')}} --}}
    Home - PM E-DRIVE
@endsection
@push('styles')
    <style>


    </style>
@endpush
@section('content')
    <div class="slider parallax overlay-bg" id="banner-animation">

        <div class="container-fluid">

            <div class="side-lines"> <span class="box"></span>
                <span class="text">{{ env('APP_NAME') }}</span>
                <span class="line"></span>
            </div>

            <div class="leader-div">
                <div class="leader_div1">
                    <img class="leader_img img-fluid" src="/assets/images/Shri H. D. Kumaraswamy.png"
                        alt="Shri H. D. Kumaraswamy">
                    <p><strong>Shri H. D. Kumaraswamy</strong></p>
                    <p>Hon'ble Minister</p>
                </div>

                <div class="leader_div2">
                    <img class="leader_img img-fluid" src="/assets/images/Shri Bhupathiraju Srinivasa Varma.png"
                        alt="Shri Bhupathiraju Srinivasa Varma">
                    <p><strong>Shri Bhupathiraju Srinivasa Varma</strong></p>
                    <p>Hon'ble Minister of State</p>
                </div>
            </div>



            <div class="transform-center home-slider">
                {{-- <div class="row image-row" style="border-top-right-radius: 26px; border-bottom-right-radius: 54px; margin-top:-2%">
                        <div class="col-12 col-lg-12" style="margin-top: 7%;">
                            <div class="leader_div" style="padding: 0 !important;margin-bottom: 20%;">
                                <p style="margin: 3%;">
                                    <img class="leader_img" src="/assets/images/Shri H. D. Kumaraswamy.png" alt="Shri H. D. Kumaraswamy">
                                    <p class="text-left">Shri H. D. Kumaraswamy<br>  Hon'ble Minister</p>
                                    
                                </p>
                            </div>
                            <div class="leader_div" style="padding: 0 !important;margin-top: -8%;">
                                <p style="margin: 3%;margin-bottom: 28%;">
                                    <img class="leader_img" src="/assets/images/Shri Bhupathiraju Srinivasa Varma.png" alt="Shri Bhupathiraju Srinivasa Varma">
                                    <p class="text-left">Shri Bhupathiraju Srinivasa Varma<br>  Hon'ble Minister</p>
                                </p>
                            </div>
                        </div>
                    </div> --}}




                {{-- <div class="transform-center home-slider">
                    <div class="row image-row" style="background-color: white; border-top-right-radius: 26px; border-bottom-right-radius: 54px;">
                        <div class="col-12 col-lg-12" style="margin-top: 7%;">
                            <div class="leader_div" style="padding: 0 !important;margin-bottom: 20%;">
                                <p style="margin: 3%;">
                                    <img class="leader_img" src="/assets/images/Shri H. D. Kumaraswamy.png" alt="Shri H. D. Kumaraswamy">
                                    Hon'ble Minister
                                </p>
                            </div>
                            <div class="leader_div" style="padding: 0 !important;margin-top: -8%;">
                                <p style="margin: 3%;margin-bottom: 28%;">
                                    <img class="leader_img" src="/assets/images/Shri Bhupathiraju Srinivasa Varma.png" alt="Shri Bhupathiraju Srinivasa Varma">
                                    Hon'ble MOS
                                </p>
                            </div>
                        </div>
                    </div> --}}

                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="banner-slider">
                                <div class="slide-item">
                                    <div class="banner-text">
                                        <span class="slider-heading">PM E-DRIVE</span>
                                        <h1 class="text-custom-white fw-700">PM Electric Drive Revolution in Innovative
                                            Vehicle Enhancement.</h1>
                                    </div>
                                </div>
                                <div class="slide-item">
                                    <div class="banner-text">
                                        <span class="slider-heading">PM E-DRIVE</span>
                                        <h1 class="text-custom-white fw-700">PM Electric Drive Revolution in Innovative
                                            Vehicle Enhancement.</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <div class="cube">
                                <div class="cube-face front"></div>
                                <div class="cube-face back"></div>
                                <div class="cube-face right"></div>
                                <div class="cube-face left"></div>
                                <div class="cube-face top"></div>
                                <div class="cube-face bottom"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- End Slider -->
    <!-- Start Intro -->
    <section class="service-box">
        <div class="container-fluid">
            <div class="category">
                <div class="row">

                    <div class="col-lg-12">
                        <div class="grid">
                            <ul id="hexGrid">
                                <li class="hex" data-aos="fade-down" data-aos-delay="100">
                                    <div class="hexIn">
                                        <a class="hexLink" href="javascript:void(0)" data-toggle="modal"
                                            data-target="#exampleModal">
                                            <div class='img'
                                                style='background-image:url(../../assets/images/services/1.jpeg);'>
                                            </div>
                                            <h1 id="demo1">Two Wheelers </h1>
                                        </a>
                                    </div>
                                </li>

                                <li class="hex" data-aos="fade-down" data-aos-delay="300">
                                    <div class="hexIn">
                                        <a class="hexLink" href="javascript:void(0)" data-toggle="modal"
                                            data-target="#exampleModal-a">
                                            <div class='img'
                                                style='background-image:url(../../assets/images/services/2.jpg);'>
                                            </div>
                                            <h1 id="demo1">Three-wheelers </h1>
                                        </a>
                                    </div>
                                </li>

                                <li class="hex" data-aos="fade-down" data-aos-delay="500">
                                    <div class="hexIn">
                                        <a class="hexLink" href="javascript:void(0)" data-toggle="modal"
                                            data-target="#exampleModal-b">
                                            <div class='img'
                                                style='background-image:url(../../assets/images/services/3.jpg);'>
                                            </div>
                                            <h1 id="demo1">e-Ambulances</h1>
                                        </a>
                                    </div>
                                </li>
                                <li class="hex" data-aos="fade-down" data-aos-delay="700">
                                    <div class="hexIn">
                                        <a class="hexLink" href="javascript:void(0)" data-toggle="modal"
                                            data-target="#exampleModal-c">
                                            <div class='img'
                                                style='background-image:url(../../assets/images/services/4.jpg);'>
                                            </div>
                                            <h1 id="demo1">e-Trucks</h1>
                                        </a>
                                    </div>
                                </li>

                                <li class="hex" data-aos="fade-down" data-aos-delay="500">
                                    <div class="hexIn">
                                        <a class="hexLink" href="javascript:void(0)" data-toggle="modal"
                                            data-target="#exampleModal-d">
                                            <div class='img'
                                                style='background-image:url(../../assets/images/services/5.jpg);'>
                                            </div>
                                            <h1 id="demo1">e-Buses </h1>
                                        </a>
                                    </div>
                                </li>
                                <li class="hex" data-aos="fade-down" data-aos-delay="300">
                                    <div class="hexIn">
                                        <a class="hexLink" href="javascript:void(0)" data-toggle="modal"
                                            data-target="#exampleModal-e">
                                            <div class='img'
                                                style='background-image:url(../../assets/images/services/6.jpg);'>
                                            </div>
                                            <h1 id="demo1">Charging infra</h1>
                                        </a>
                                    </div>
                                </li>
                                <li class="hex" data-aos="fade-up" data-aos-delay="100">
                                    <div class="hexIn">
                                        <a class="hexLink" href="javascript:void(0)" data-toggle="modal"
                                            data-target="#exampleModal-f">
                                            <div class='img'
                                                style='background-image:url(../../assets/images/services/7.jpg);'>
                                            </div>
                                            <h1 id="demo1">Testing agencies upgradation</h1>
                                        </a>
                                    </div>
                                </li>

                            </ul>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- service box end -->








    <!-- services Modal -->


    <!-- Modal services 1 -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Two Wheelers </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="../../assets/images/services/1.jpeg" alt="">
                    <p>The Scheme aims to incentivize ~24.79 lakh electric two-wheelers (e-2Ws). Only e-2Ws equipped with
                        advanced batteries will qualify for the demand incentive. Both commercial and privately or
                        corporately owned registered e-2Ws will be eligible for the scheme.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 1 end -->


    <!-- Modal services 2 -->
    <div class="modal fade" id="exampleModal-a" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Three-wheeler</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="../../assets/images/services/2.jpg" alt="">
                    <p>The Scheme aims to incentivize around 3.2 lakh electric three-wheelers (e-3Ws) across two categories
                        viz. registered e-rickshaws/e-carts or L5. Only those e-3Ws equipped with advanced batteries will
                        qualify for the demand incentive. The scheme is applicable solely to e-3Ws registered for commercial
                        use.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 2 end -->


    <!-- Modal services 3 -->
    <div class="modal fade" id="exampleModal-b" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">e-Ambulance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="../../assets/images/services/3.jpg" alt="">
                    <p>The eligibility criteria for e-ambulances are currently being developed consultations with the
                        Ministry of Health and Family Welfare (MoHFW) and will be announced shortly.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 3 end -->


    <!-- Modal services 4 -->
    <div class="modal fade" id="exampleModal-c" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">e-Trucks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="../../assets/images/services/4.jpg" alt="">
                    <p>The scheme aims to encourage the adoption of e-trucks to cut CO2 emissions and establish them as a
                        popular logistics solution in the future. The eligibility criteria for e-trucks are being finalized
                        and will be announced soon.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 4 end -->

    <!-- Modal services 5 -->
    <div class="modal fade" id="exampleModal-d" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">e-Buses</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="../../assets/images/services/5.jpg" alt="">
                    <p>The scheme aims to incentivize over 14,000 e-buses across nine major cities with populations
                        exceeding 4 million, with the goal of making e-buses a widely adopted mode of electric vehicle
                        transportation.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 5 end -->

    <!-- Modal services 6 -->
    <div class="modal fade" id="exampleModal-e" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Charging infra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="../../assets/images/services/6.jpg" alt="">
                    <p>The scheme envisages to install ample public charging infrastructure for various vehicle categories,
                        including over 22,000 EV chargers for e-4Ws and 1,800 chargers for e-buses, to boost confidence
                        among EV users. Besides this provision for establishing charging infrastructure for light electric
                        vehicles, such as e-2Ws and e-3Ws has also been made under the scheme.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 6 end -->


    <!-- Modal services 7 -->
    <div class="modal fade" id="exampleModal-f" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Testing agencies upgradation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="../../assets/images/services/7.jpg" alt="">
                    <p>The scheme aims to upgrade and modernize testing agencies under the Ministry of Heavy Industries
                        (MHI) to equip them with new and emerging technologies, thereby promoting green mobility.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 7 end -->

    <!-- Modal services 8 -->
    <div class="modal fade" id="exampleModal-g" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Regulatory Reports</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="img/services/Regulatory-Reports2.jpg" alt="">
                    <p>Regulatory reporting are practices to disclose the sustainability and ethical performance of your
                        entity. These reports help your investors understand the ESG strategy and performance, which can
                        help them make informed investment decisions. We provide assistance for preparing regulatory reports
                        as per national and international standards.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 8 end -->

    <!-- Modal services 9 -->
    <div class="modal fade" id="exampleModal-h" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sustainability Reports</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="img/services/Sustainability-Report2.jpg" alt="">
                    <p>Our Sustainability Reporting services help you communicate your ESG initiatives and achievements to
                        stakeholders. We create clear, comprehensive, and engaging reports that highlight your commitment to
                        sustainability and responsible business practices.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 9 end -->

    <!-- Modal services 10 -->
    <div class="modal fade" id="exampleModal-i" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ESG Assurance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="img/services/ESG-Assurance2.jpg" alt="">
                    <p>SEBI has mandated assurance for the reported data in BRSRs of top 150 companies in FY2024 with
                        incremental companies in the assurance purview from FY2024-25 onwards. We provide limited and
                        reasonable assurance as per SEBI guidelines. </p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 10 end -->

    <!-- Modal services 11 -->
    <div class="modal fade" id="exampleModal-j" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">UN SDG Mapping</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="img/services/UN-SDG-Mapping.jpg" alt="">
                    <p>Our UN SDG Mapping services align your business activities with the United Nations Sustainable
                        Development Goals (SDGs). We help you identify key areas of impact and integrate SDG targets into
                        your strategic planning.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 11 end -->

    <!-- Modal services 12 -->
    <div class="modal fade" id="exampleModal-k" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ESG Strategy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="img/services/ESG-Strategy.jpg" alt="">
                    <p>Our ESG Strategy services develop and implement comprehensive strategies to integrate environmental,
                        social, and governance principles into your business operations. We help you achieve sustainable
                        growth and long-term value creation.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 12 end -->

    <!-- Modal services 13 -->
    <div class="modal fade" id="exampleModal-l" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Net Zero Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="img/services/NetZero-Plan.jpg" alt="">
                    <p>Our Net Zero Plan services assist you in developing and implementing strategies to achieve net zero
                        carbon emissions. We provide tailored solutions to help you minimize your carbon footprint and
                        contribute to global climate goals.</p>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal services 13 end -->

    <!-- Modal services 14 -->
    <div class="modal fade" id="exampleModal-m" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Carbon Credits</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <img src="img/services/Carbon-Credits.jpg" alt="">
                    <p>Carbon credits are a unit of measurement that represent a reduction of one metric ton in greenhouse
                        gas emissions. They are also known as carbon offsets or carbon allowances. We are qualified and
                        seasoned in carbon credit measurement and facilitate carbon credit development and supply. </p>
                </div>

            </div>
        </div>
    </div>

    <!---Modal popup --->
    <div class="modal" id="showOnLoad" tabindex="-1" aria-labelledby="showOnLoad" aria-hidden="true" style="background: transparent;">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 544px;">
            <div class="modal-content">
                <div class="modal-header" style="padding: 0.6rem 0.7rem;background: #6bcfe6e5;">
                    <h5 class="modal-title" id="showOnLoad"><b>Attention</b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>79,974 e-3W (L5) sales reported by OEMs till 7th November, 2024. A total 80,546 e-3W (l5) will be incentivized in the current FY 2024-25. The vehicles sold and registered beyond the targeted number of 80,546 will not be eligible for incentive in FY 24-25</p>
                </div>
  
                <div class="modal-footer" style="background: #6bcfe6e5;padding: 0.6rem 0.7rem;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" style="background: #fb9439;border: none;">Close</button>
                  </div>
            </div>
            
        </div>
    </div>
    <!-- End Intro -->
    <!-- Start About -->
    <!-- start aboutus-2 -->
    <section class="section-padding lw-about-section p-relative">
        <!-- <div class="side-lines right-side"> <span class="box"></span>
                <span class="text">PM E-DRIVE </span>
                <span class="line"></span>
            </div> -->

        <div class="about-the-scheme">
            <div class="container">
                <div class="row">
                    {{-- <div class="col-lg-12">
                        <div class="lw-about-section-right">
                            <h3 class="p-relative about-the-scheme-heading"> About the Scheme</h3>
                        </div>
                    </div> --}}

                    <div class="col-lg-12">
                        <div class="lw-about-section-right">
                            <div class="about-the-scheme-content">
                                <h3 class="p-relative about-the-scheme-heading"> About the Scheme</h3>

                                <p>The Ministry of Heavy Industry, Govt. of India, with the approval of Union Cabinet, Chaired by Hon’ble Prime Minister Shri Narender Modi has launched scheme titled ‘ PM Electric Drive Revolution in Innovative Vehicle Enhancement (PM E-DRIVE) Scheme vide Gazette notification S.O. 4259 (E) on September 29, 2024.  The scheme will be implemented from 1st October, 2024 till 31st March, 2026. Further, EMPS-2024, the number of vehicles and the expenditure under EMPS-2024 for e-2w and e-3w being implemented for the period from 1st April 2024 to 30th September 2024 is being subsumed under PM E-DRIVE Scheme, therefore, effective period for the scheme will be two years.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="eligible-categories">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="lw-about-section-right">
                            <h3 class="p-relative eligible-categories-heading">Eligible Categories</h3>
                            <div class="lw-about-right-content">
                                <div class="lw-about-right-list">
                                    <ul style="display: grid;">
                                        <li> <i class="fas fa-check"></i>
                                            e-2 Wheelers (e-2Ws)</li>
                                        <li> <i class="fas fa-check"></i>
                                            e-3 Wheelers (e-3Ws) including registered e-rickshaws & e-carts and L5 </li>
                                        <li> <i class="fas fa-check"></i>
                                            e-Ambulances </li>
                                        <li> <i class="fas fa-check"></i>
                                            e-Trucks </li>
                                        <li> <i class="fas fa-check"></i>
                                            e-Buses </li>
                                        <li> <i class="fas fa-check"></i>
                                            Charging infra
                                        </li>
                                        <li> <i class="fas fa-check"></i>
                                            Upgradation of Testing Agencies 
                                        </li>
                                    </ul>
                                </div>
                                <p>With greater emphasis on providing affordable and environment friendly public transportation options for the masses, scheme will be applicable mainly to those e-2Ws and e-3Ws registered for commercial purposes. Further, in addition to commercial use, privately or corporate owned registered e-2Ws will also be eligible under the scheme. To encourage advance technologies, the benefits of incentives, will be extended to only those EVs which are fitted with advanced battery.
                                </p>


                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="ln-about-left-side p-relative full-height">
                            <div class="lw-mega-tab">

                                <div class="tab-content lw-tab-content-wrapper">
                                    <div class="tab-pane container active" id="LOANLY-1">
                                        <div class="table-responsive">
                                            <table class="lw-tab-table table-bordered double-line-table">
                                                <tr class="lw-table-row-1">
                                                    <th>Vehicle Segment</th>
                                                    <th>Maximum No. of Vehicles to be Supported</th>
                                                    <th>Total fund support from MHI (Cr.)</th>

                                                </tr>
                                                <tr>
                                                    <th class="lw-table-data-1">e-2 wheelers</th>
                                                    <th class="lw-table-data-1 text-right"> 24,79,120</th>
                                                    <th class="lw-table-data-1 text-right"> 1,772</th>
                                                </tr>
                                                <tr>
                                                    <th class="lw-table-data-1">e-Rickshaws & e-cart</th>
                                                    <th class="lw-table-data-1 text-right"> 1,10,596</th>
                                                    <th class="lw-table-data-1 text-right">192</th>
                                                </tr>
                                                <tr>
                                                    <th class="lw-table-data-1">e-3 wheelers L5</th>
                                                    <th class="lw-table-data-1 text-right"> 2,05,392</th>
                                                    <th class="lw-table-data-1 text-right">715</th>
                                                </tr>
                                                <tr>
                                                    <th class="lw-table-data-1">e-Ambulances</th>
                                                    <th class="lw-table-data-3 text-right">To be notified separately</th>
                                                    <th class="lw-table-data-1 text-right">500</th>
                                                </tr>
                                                <tr>
                                                    <th class="lw-table-data-1">e-Trucks</th>
                                                    <th class="lw-table-data-3 text-right"> To be notified separately</th>
                                                    <th class="lw-table-data-1 text-right">500</th>
                                                </tr>
                                                <tr>
                                                    <th class="lw-table-data-1">e-Buses</th>
                                                    <th class="lw-table-data-1 text-right"> 14,028</th>
                                                    <th class="lw-table-data-1 text-right">4,391</th>
                                                </tr>
                                                <tr>
                                                    <th class="lw-table-data-1">
                                                        EV PCS</th>
                                                    <th class="lw-table-data-1 text-right"> 72,300</th>
                                                    <th class="lw-table-data-1 text-right">2,000</th>
                                                </tr>
                                                <tr>
                                                    <th class="lw-table-data-1">Testing agencies upgradation</th>
                                                    <th class="lw-table-data-1 text-right"> -</th>
                                                    <th class="lw-table-data-1 text-right">780</th>
                                                </tr>
                                                <tr>
                                                    <th class="lw-table-data-1">Admin Expenses</th>
                                                    <th class="lw-table-data-1 text-right"> -</th>
                                                    <th class="lw-table-data-1 text-right">50</th>
                                                </tr>
                                                <tr class="lw-table-row-1">
                                                    <th>Total</th>
                                                    <th class="text-right">28,81,436</th>
                                                    <th class="text-right">10,900</th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="e-voucher">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="lw-about-section-right e-voucher">
                            <h3 class="p-relative e-voucher-heading">PM E-DRIVE e-Voucher</h3>
                            <div class="lw-about-right-content">
                                <p>The Ministry of Heavy Industry (MHI) is introducing e-Vouchers for EV customers to avail the demand incentive under the scheme. The scheme portal will generate an e-KYC Aadhaar FACE authenticated e-Voucher for the customer at the time of purchase. A link to download the e-Voucher shall be sent on the registered mobile number of the customer.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        $(window).on("load" ,function(){
            $('#showOnLoad').modal({
                show:true
            });
        });
    </script>
@endpush
