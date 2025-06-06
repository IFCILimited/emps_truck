@extends('layouts.master')
@section('title')
   Scheme Notifications - {{ env('APP_NAME')}}
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
                            <h1 class="text-custom-white lh-default fw-600">Scheme Notifications</h1>
                            <ul class="custom">
                                <li> <a href="/" class="text-custom-white">Home</a>
                                </li>
                                <li class="text-custom-white active">Scheme Notifications</li>
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
                    <h3 class="text-custom-black fw-700">Scheme Notifications
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
                                    <th>Document Name/Title</th>
                                    <th>Released On</th>
                                    <th>Download Document</th>

                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">1</td>
                                    <td class="lw-table-data-2">
                                       <strong>{{ env('APP_NAME')}} 2025 Notification (AMENDMENT)</strong>
                                    </td>
                                    <td style="text-align: center;" class="lw-table-data-3">
                                        <strong>3rd March, 2025</strong>
                                    </td>
                                    <td style="text-align: center;" class="lw-table-data-4">
                                        <strong><a href="/docs/policy_document/261454.pdf"
                                            target="_blank">
                                            <i class="nav-icon fa fa-download" title="Download"></i>
                                        </a></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">2</td>
                                    <td class="lw-table-data-2">
                                       <strong>{{ env('APP_NAME')}} 2024 Notification</strong>
                                    </td>
                                    <td style="text-align: center;" class="lw-table-data-3">
                                        <strong>29th September, 2024</strong>
                                    </td>
                                    <td style="text-align: center;" class="lw-table-data-4">
                                        <strong><a href="/docs/policy_document/257594.pdf"
                                            target="_blank">
                                            <i class="nav-icon fa fa-download" title="Download"></i>
                                        </a></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;" class="lw-table-data-1">3</td>
                                    <td class="lw-table-data-2">
                                        <strong>Amendment in PM E-DRIVE Scheme </strong>
                                     </td>
                                     <td style="text-align: center;" class="lw-table-data-3">
                                        <strong> 25th November, 2024 </strong>
                                     </td>
                                     <td style="text-align: center;" class="lw-table-data-4">
                                        <strong><a href="/docs/policy_document/Gazette_Notificatio_on_e-3W_L5.pdf"
                                            target="_blank">
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
