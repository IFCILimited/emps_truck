@extends('layouts.master')
@section('title')
Important-links - {{ env('APP_NAME')}}
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
                            <h1 class="text-custom-white lh-default fw-600">Important-links </h1>
                            <ul class="custom">
                                <li> <a href="/" class="text-custom-white">Home</a>
                                </li>
                                <li class="text-custom-white active">Important-links </li>
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
                    <h3 class="text-custom-black fw-700">Important-links
                    </h3>
                </div>
            </div> --}}
            <div class="row">

                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="lw-tab-table">
                            <tbody>
                                <tr class="lw-table-row-1">
                                    <th>S.No.</th>
                                    <th>Website Links</th>
                                  
                                    
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">1</td>
                                    <td class="lw-table-data-2">
                                       <strong><a target="_blank" href="https://heavyindustries.gov.in/"
                                        target="_blank">Ministry of Heavy Industry</a> </strong>
                                    </td>
                                    
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">2</td>
                                    <td class="lw-table-data-2">
                                       <strong><a target="_blank" href="http://www.siam.in/" target="_blank">SIAM (Society
                                        of Indian Automobile Manufacturers)</a></strong>
                                    </td>
                                    
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">3</td>
                                    <td class="lw-table-data-2">
                                       <strong>  <a target="_blank" href="https://dbtbharat.gov.in/" target="_blank">DBT
                                        Portal</a></strong>
                                    </td>
                                    
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">4</td>
                                    <td class="lw-table-data-2">
                                       <strong> <a target="_blank" href="https://union.openbudgetsindia.org/en/schemes/"
                                        target="_blank">Central Schemes Website</a></strong>
                                    </td>
                                    
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">5</td>
                                    <td class="lw-table-data-2">
                                       <strong> <a target="_blank" href="https://www.nic.in/">National Informatics
                                        Centre</a> </strong>
                                    </td>
                                    
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">6</td>
                                    <td class="lw-table-data-2">
                                       <strong><a target="_blank" href="https://www.icat.in/">International Centre for
                                        Automotive Technology (ICAT)</a> </strong>
                                    </td>
                                    
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">7</td>
                                    <td class="lw-table-data-2">
                                       <strong><a target="_blank" href="https://www.araiindia.com/home">Automotive Research
                                        Association of India(ARAI)</a> </strong>
                                    </td>
                                    
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">8</td>
                                    <td class="lw-table-data-2">
                                       <strong><a target="_blank" href="https://www.garc.co.in/vision-mission/">Global
                                        Automotive Research Center (GARC)</a> </strong>
                                    </td>
                                    
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">9</td>
                                    <td class="lw-table-data-2">
                                       <strong><a target="_blank" href="https://www.natrax.in/">National Automotive Test
                                        Tracks (NATRAX)</a> </strong>
                                    </td>
                                    
                                   
                                </tr>

                               
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--About-two-section-end-->
@endsection
