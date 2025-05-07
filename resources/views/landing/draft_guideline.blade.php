@extends('layouts.master')
@section('title')
   Draft PMP Guidelines - {{ env('APP_NAME')}}
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
                            <h1 class="text-custom-white lh-default fw-600">Draft PMP Guidelines</h1>
                            <ul class="custom">
                                <li> <a href="/" class="text-custom-white">Home</a>
                                </li>
                                <li class="text-custom-white active">Draft PMP Guidelines</li>
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
            <div class="row">

                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="lw-tab-table">
                            <tbody>
                                <tr class="lw-table-row-1">
                                    <th>S.No.</th>
                                    <th>Document Name/Title</th>
                                    <th>Released On</th>
                                    <th>Download Document</th>
                                    
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">2</td>
                                    <td class="lw-table-data-2">
                                        <strong>Letter of Ministry of Heavy Industries in the matter</strong>
                                    </td>
                                    <td style="text-align: center;"class="lw-table-data-3">
                                        <strong>11th October 2024</strong>
                                    </td>
                                    <td style="text-align: center;" class="lw-table-data-4">
                                        <strong><a href="/docs/policy_document/Letter dated 11.10.2024.pdf" target="_blank">
                                            <i class="nav-icon fa fa-download" title="Download"></i>
                                        </a></strong>
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;"  class="lw-table-data-1">3</td>
                                    <td class="lw-table-data-2">
                                        <strong>PMP PM E-DRIVE for e-2Ws and e-3Ws</strong>
                                    </td>
                                    <td style="text-align: center;"class="lw-table-data-3">
                                        <strong>11th October 2024</strong>
                                    </td>
                                    <td  style="text-align: center;"class="lw-table-data-4">
                                        <strong> <a href="/docs/policy_document/PMP PM E-DRIVE - e2W and e3W V9.pdf" target="_blank">
                                            <i class="nav-icon fa fa-download" title="Download"></i>
                                        </a></strong>
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;"  class="lw-table-data-1">4</td>
                                    <td class="lw-table-data-2">
                                        <strong>PMP PM E-DRIVE on e-buses</strong>
                                    </td>
                                    <td style="text-align: center;"class="lw-table-data-3">
                                        <strong>11th October 2024</strong>
                                    </td>
                                    <td  style="text-align: center;"class="lw-table-data-4">
                                        <strong> <a href="/docs/policy_document/PMP PM E-DRIVE - eBuses V9.pdf" target="_blank">
                                            <i class="nav-icon fa fa-download" title="Download"></i>
                                        </a></strong>
                                    </td>
                                   
                                </tr>
                                <tr>
                                    <td style="width: 25%;"  class="lw-table-data-1">5</td>
                                    <td class="lw-table-data-2">
                                        <strong>PMP PM E-DRIVE for Chargers (EVPS)</strong>
                                    </td>
                                    <td style="text-align: center;"class="lw-table-data-3">
                                        <strong>11th October 2024</strong>
                                    </td>
                                    <td  style="text-align: center;"class="lw-table-data-4">
                                        <strong> <a href="/docs/policy_document/PMP Charger (EVPCS) V9.pdf" target="_blank">
                                            <i class="nav-icon fa fa-download" title="Download"></i>
                                        </a></strong>
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
