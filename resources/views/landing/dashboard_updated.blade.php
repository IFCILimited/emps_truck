<!-- Nav Bar Ends here -->
@extends('layouts.master')
@section('title')
    Dashboard - PM E-DRIVE
@endsection
@push('styles')
    <style>
        .table-bordered th,
        .table-bordered td {
            border: 1px solid #000 !important;
        }

        .table-container {
            width: 80%;
            margin: 0 auto;
            padding-left: 10%;
            padding-right: 10%;
        }
        .card-wrapper {
            border: 1px solid #007bff;
            border-radius: 56px;
            padding: 12px;
            margin: 20px 89px;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/style1.css') }}">
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
                            <h1 class="text-custom-white lh-default fw-600">Sales Dashboard</h1>
                            <ul class="custom">
                                <li> <a href="/" class="text-custom-white">Home</a>
                                </li>
                                <li class="text-custom-white active">Sales Segment Wise </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class=" parallax mt-20 mb-xl-30">
    <div class="card-wrapper">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <h5 class="text-center"> <b>As on date {{ date('d-m-Y',strtotime("-1 days")) }} </b></h5>
                </div>
                <div class="col-xl-6">
                    <h5 class="text-center"> </h5>
                </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="card o-hidden bg-secondary-light small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-18">Fuel saving per day (In Litres) </span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h6 class="f-w-600">{{ indian_format($carbonData->total_fuelsaved_perday) }}</h6><span
                                            class="f-12 f-w-400"></span>
 
                                    </div>
                                    <div class="product-sub bg-secondary-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-social') }}"></use>
                                        </svg>
                                    </div>
                                </div>
 
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="card o-hidden bg-warning-light small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-18">Saved fuel <br>(In Litres) </span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h6 class="f-w-600">{{ indian_format($carbonData->total_fuel_saved) }}</h6><span
                                            class="f-12 f-w-400"></span>
 
                                    </div>
                                    <div class="product-sub bg-warning-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-social') }}"></use>
                                        </svg>
                                    </div>
                                </div>
 
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="card o-hidden bg-danger-light small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-18">CO2 Reduction per day (In Kg.) </span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h6 class="f-w-600">{{ indian_format($carbonData->co2perday) }}</h6><span
                                            class="f-12 f-w-400"></span>
 
                                    </div>
                                    <div class="product-sub bg-danger-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-animation') }}"></use>
                                        </svg>
                                    </div>
                                </div>
 
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6">
                        <div class="card o-hidden bg-success-light small-widget">
                            <div class="card-body total-project border-b-primary border-2"><span
                                    class="f-light f-w-500 f-18">
                                    CO2<br> Reduction </span>
                                <div class="project-details">
                                    <div class="project-counter">
                                        <h6 class="f-w-600">{{ indian_format($carbonData->co2total) }}</h6><span
                                            class="f-12 f-w-400"></span>
 
                                    </div>
                                    <div class="product-sub bg-success-light">
                                        <svg class="invoice-icon">
                                            <use href="{{ asset('admin/svg/icon-sprite.svg#fill-animation') }}"></use>
                                        </svg>
                                    </div>
                                </div>
 
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="container-fluid mb-xl-15" style="max-width: 92%;margin:0 auto;">
            {{-- <div class="row"> --}}
                {{-- <div class="col-lg-12"> --}}
                    <div class="table-responsive">
                        <table class="lw-tab-table" style="border: 1px solid #d3d3d3; border-collapse: collapse; width: 100%;">
                            <thead>
                                <tr class="lw-table-row-1">
                                    <th colspan="13" style="border: 1px solid #d3d3d3; text-align: center;">Consolidated Sales of 2024-25</th>
                                </tr>
                                <tr class="lw-table-row-1">
                                    <th rowspan="4" style="border: 1px solid #d3d3d3;">SN</th>
                                    <th rowspan="4" style="border: 1px solid #d3d3d3;">Segment Name</th>
                                    <th rowspan="4" style="border: 1px solid #d3d3d3;">Vehicle Category</th>
                                    <th rowspan="4" style="border: 1px solid #d3d3d3;">Target Sales</th>
                                    {{-- <th colspan="2" class="text-center" style="border: 1px solid #d3d3d3;">Sales As Per Portal</th> --}}
                                    <th colspan="7" class="text-center" style="border: 1px solid #d3d3d3;">Sales</th>
                                    {{-- <th rowspan="3" style="border: 1px solid #d3d3d3;">Sales Reported by OEM (EMPS + PM EDRIVE)</th> --}}
                                    <th rowspan="2" colspan="2" style="border: 1px solid #d3d3d3;">Total Sales</th>
                                    
                                </tr>
                                <tr class="lw-table-row-1">
                                    {{-- <th rowspan="2" style="border: 1px solid #d3d3d3;">Sales As Per E-Voucher</th>
                                    <th rowspan="2" style="border: 1px solid #d3d3d3;">Sales As per Voucher Upload</th> --}}
                                    <th style="border: 1px solid #d3d3d3;" colspan="2">EMPS</th>
                                    <th style="border: 1px solid #d3d3d3;" colspan="5">PM-EDRIVE</th>
                                </tr>
                                <tr class="lw-table-row-1">
                                    {{-- <th colspan=6></th> --}}
                                    <th rowspan="2" style="border: 1px solid #d3d3d3;">As Per Vahan (A)</th>
                                    <th rowspan="2" style="border: 1px solid #d3d3d3;">As Per Portal (C)</th>
                                    <th colspan="3" style="border: 1px solid #d3d3d3;">As Per vahan*</th>
                                    <th rowspan="2" style="border: 1px solid #d3d3d3;">Buyer ID generated (D)</th>
                                    <th rowspan="2" style="border: 1px solid #d3d3d3;">Face ID Successful</th>
                                    <th rowspan="2" style="border: 1px solid #d3d3d3;">As Per vahan* (A+B)</th>
                                    <th rowspan="2" style="border: 1px solid #d3d3d3;">As Per Portal (C+D)</th>
                                </tr>
                                <tr class="lw-table-row-1">
                                    <th style="border: 1px solid #d3d3d3;">Approved* (X)</th>
                                    <th style="border: 1px solid #d3d3d3;">Pending for Approval* (Y)</th>
                                    <th style="border: 1px solid #d3d3d3;">Total* (B) = (X+Y)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $sn = 1;
                                    $totalVahanCat1 = 0;
                                    $totalVahanCat2 = 0;
                                    $totalVahanCat3 = 0;
                                    $totalPortalCat1 = 0;
                                    $totalPortalCat2 = 0;
                                    $totalPortalCat3 = 0;
                                @endphp
                                @foreach ($fomated as $sale)
                                <tr>
                                    <td class="text-center" style="border: 1px solid #d3d3d3;">{{ $sn++ }}</td>
                                    <td class="text-left" style="border: 1px solid #d3d3d3;"><b>{{ $sale["segment_name"] }}</b></td>
                                    <td class="text-left" style="border: 1px solid #d3d3d3;"><b>{{ $sale["categroy_name"] }}</b></td>
                                    <td class="text-right" style="border: 1px solid #d3d3d3;">
                                        <b>{{ indian_format($sale["target_sales"]) }}</b>
                                    </td>
                                    {{-- <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["voucher_generated"]) }}</b></td>
                                    <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["voucher_uploaded"]) }}</b></td> --}}
                                    <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["emps_vahan"]) }}</b></td>
                                    <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["emps_portal"]) }}</b></td>
                                    <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["drive_vahan_approved"]) }}</b></td>
                                    <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["drive_vahan_unapproved"]) }}</b></td>
                                    <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["drive_vahan_total"]) }}</b></td>
                                    <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["buyer_id_drive"]) }}</b></td>
                                    <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["face_scans_count"]) }}</b></td>
                                    <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["drive_vahan_total"] + $sale["emps_vahan"]) }}</b></td>
                                    <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["total_portal"]) }}</b></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <span>*As per vahan as of {{ \Carbon\Carbon::parse($maxDateOfVahan)->format('d-m-Y') }}</span><br>
                    <span>The details given are for digitized vehicle records as per centralized Vahan 4.</span><br>
                    <span>Data for Telangana, and some RTO's of Lakshadweep has not been provided as they are not in centralized Vahan 4.</span>
                {{-- </div> --}}
            {{-- </div> --}}
        </div>

       

        
    @endsection
