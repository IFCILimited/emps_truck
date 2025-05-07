@extends('layouts.master')
@section('title')
   EVPCS Guidelines - {{ env('APP_NAME')}}
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
                            <h1 class="text-custom-white lh-default fw-600">EVPCS Guidelines</h1>
                            <ul class="custom">
                                <li> <a href="/" class="text-custom-white">Home</a>
                                </li>
                                <li class="text-custom-white active">EVPCS Guidelines</li>
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
                                        <strong>Draft EVPCS Guidelines</strong>
                                    </td>
                                    <td style="text-align: center;"class="lw-table-data-3">
                                        <strong>27th December 2024</strong>
                                    </td>
                                    <td style="text-align: center;" class="lw-table-data-4">
                                        <strong><a href="/docs/policy_document/Draft EVPCS guidelines.pdf" target="_blank">
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
