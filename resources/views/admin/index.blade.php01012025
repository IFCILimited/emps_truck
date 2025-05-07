<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Admin - Dashboard
@endsection

@push('styles')
    <style>

    </style>
@endpush
{{-- @php 
$filteredModels = $models->filter(function ($model) {
    return $model->mhi_flag === 'R' || $model->testing_flag === 'R';
});
$countRejMod = $filteredModels->count();
@endphp --}}
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Dashboard</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg class="stroke-icon">
                                        <use href="admin/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            {{-- <li class="breadcrumb-item">Dashboard</li> --}}
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row size-column">
                <div class="col-xxl-12 box-col-12">
                    <div class="row">
                        @if (Auth::user()->hasRole('MHI-AS') ||
                                Auth::user()->hasRole('MHI-DS') ||
                                Auth::user()->hasRole('MHI-OnlyView') ||
                                Auth::user()->hasRole('PMA') || Auth::user()->hasRole('OEM'))
                            {{-- 05-10-2024 --}}
                            <div class="col-sm-12 mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dt-ext table-responsive custom-scrollbar">
                                            <h1>Vehicle Sales Data</h1>
                                            {{-- <table class="display table-bordered table-striped" id="export-button">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">SN</th>
                                                        <th>Segment Name</th>
                                                        <th>Vehicle Category</th>
                                                        <th>OEM Name</th>
                                                        <th>Sales</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sn = 1;
                                                        $totalCount = 0;
                                                    @endphp
                                                    @foreach ($vehicleSales as $sale)
                                                        @php
                                                            $totalCount += $sale->count;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $sn++ }}</td>
                                                            <td>{{ $sale->segment_name }}</td>
                                                            <td>{{ $sale->vehicle_cat }}</td>
                                                            <td>{{ $sale->oem_name }}</td>
                                                            <td class="text-end">{{ indian_format($sale->count) }}</td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-left" colspan="4">Total</th>
                                                        <th class="text-end">{{ indian_format($totalCount) }}</th>
                                                    </tr>
                                                </tfoot>

                                            </table> --}}
                                            {{-- <table class="display table-bordered table-striped" id="export-button">
                                                <thead>
                                                    <tr>
                                                        <th rowspan="3" class="text-center">SN</th>
                                                        <th rowspan="3">Category Name</th>
                                                        <th rowspan="3">Segment Name</th>
                                                        <th rowspan="3">Target Sales</th>
                                                        <th colspan="2" class="text-center">Sales As Per Portal</th>
                                                        <th colspan="4" class="text-center">Sales</th>
                                                        <th rowspan="2" colspan="2">Total Sales</th>
                                                        <th rowspan="3">Action</th>
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2">Sales As Per E-Voucher</th>
                                                        <th rowspan="2">Sales As per Voucher Upload</th>
                                                        <th colspan="2">PM-EDRIVE</th>
                                                        <th colspan="2">EMPS</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="1">As Per vahan</th>
                                                        <th colspan="1">As Per portal</th>
                                                        <th colspan="1">As Per vahan</th>
                                                        <th colspan="1">As Per portal</th>
                                                        <th colspan="1">As Per vahan</th>
                                                        <th colspan="1">As Per portal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sn = 1;
                                                        $totalCount = 0;
                                                    @endphp
                                                    @foreach ($salesSum as $sale)
                                                        @php
                                                            $totalCount += $sale->targetsalessum;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $sn++ }}</td>
                                                            <td>{{ $sale->vehicle_cat }}</td>
                                                            <td>{{ $sale->segment_name }}</td>
                                                            <td class="text-end">{{ indian_format($sale->targetsalessum) }}</td>
                                                            <td class="text-end">{{ indian_format($sale->evouchersalessum) }}</td>
                                                            <td class="text-end">{{ indian_format($sale->voucherupload) }}</td>
                                                            <td>
                                                                @if($sale->vehicle_cat == "L1+L2")
                                                                    @php $totalVahanl1l2 = 0; @endphp
                                                                    @foreach($vahan_summary as $vahan_data)
                                                                        @if($vahan_data->cat_nm == "L1" || $vahan_data->cat_nm == "L2")
                                                                            @php $totalVahanl1l2 += $vahan_data->count; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                     {{indian_format($totalVahanl1l2)}} 
									
                                                                @elseif($sale->vehicle_cat == "L5")
                                                                    @php $totalVahanCount = $vahan_summary->where('cat_nm', 'L5')->first(); @endphp

                                                                   @if($totalVahanCount){{indian_format($totalVahanCount->count) }} @else 0 @endif
									
                                                                @else
                                                                    @php $totalVahanCount = $vahan_summary->where('cat_nm', 'e-rickshaw & e-cart')->first(); @endphp
                                                                   @if($totalVahanCount){{indian_format($totalVahanCount->count) }} @else 0 @endif
									
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($sale->vehicle_cat == "L1+L2")
                                                                    @php $totalVahanl1l2 = 0; @endphp
                                                                    @foreach($portal_summary_edrive as $portal_edrive_count)
                                                                        @if($portal_edrive_count->cat_nm == "L1" || $portal_edrive_count->cat_nm == "L2")
                                                                            @php $totalVahanl1l2 += $portal_edrive_count->count; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                    {{indian_format($totalVahanl1l2)}}
                                                                @elseif($sale->vehicle_cat == "L5")
                                                                    @php $totalVahanCount = $portal_summary_edrive->where('cat_nm', 'L5')->first(); @endphp
                                                                    @if($totalVahanCount){{indian_format($totalVahanCount->count) }} @else 0 @endif

                                                                @else
                                                                    @php $totalVahanCount = $portal_summary_edrive->where('cat_nm', 'e-rickshaw & e-cart')->first(); @endphp
                                                                     @if($totalVahanCount){{indian_format($totalVahanCount->count) }} @else 0 @endif
                                                                    
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($sale->vehicle_cat == "L1+L2")
                                                                    @php $totalVahanl1l2 = 0; @endphp
                                                                    @foreach($emps_summary as $vahan_data)
                                                                        @if($vahan_data->cat_nm == "L1" || $vahan_data->cat_nm == "L2")
                                                                            @php $totalVahanl1l2 += $vahan_data->count; @endphp
                                                                        @endif
                                                                    @endforeach
                                                                    {{indian_format($totalVahanl1l2)}}
                                                                @elseif($sale->vehicle_cat == "L5")
                                                                    @php $totalVahanCount = $emps_summary->where('cat_nm', 'L5')->first(); @endphp

                                                                   @if($totalVahanCount){{indian_format($totalVahanCount->count) }} @else 0 @endif

                                                                @else
                                                                    @php $totalVahanCount = $emps_summary->where('cat_nm', 'e-rickshaw & e-cart')->first(); @endphp
                                                                   @if($totalVahanCount){{indian_format($totalVahanCount->count) }} @else 0 @endif

                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{indian_format($emps_buyer_summary_total[$sale->vehicle_cat])}}
                                                            </td>
                                                            <td>
                                                                {{ indian_format($totals[$sale->vehicle_cat]['vahan']) }}
                                                            </td>
                                                            <td>
                                                                {{ indian_format($totals[$sale->vehicle_cat]['portal']) }}
                                                            </td>
                                                            <td colspan="2">
                                                                @if(Auth::user()->hasRole('OEM'))
                                                                    <a href="{{route('dashboard.dealer.segment', urlencode($sale->vehicle_cat))}}" target="_blank" class="btn btn-primary">View</a>
                                                                @else
                                                                    <a href="{{route('dashboard.segment', urlencode($sale->vehicle_cat))}}" target="_blank" class="btn btn-primary">View</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                

                                            </table> --}}
                                            {{-- <table id="export-button" class="display table-bordered table-striped" style="border: 1px solid #d3d3d3; border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr class="lw-table-row-1">
                                                        <th rowspan="3" style="border: 1px solid #d3d3d3;">SN</th>
                                                        <th rowspan="3" style="border: 1px solid #d3d3d3;">Segment Name</th>
                                                        <th rowspan="3" style="border: 1px solid #d3d3d3;">Vehicle Category</th>
                                                        <th rowspan="3" style="border: 1px solid #d3d3d3;">Target Sales</th>
                                                        <th colspan="2" class="text-center" style="border: 1px solid #d3d3d3;">Sales As Per Portal</th>
                                                        <th colspan="4" class="text-center" style="border: 1px solid #d3d3d3;">Sales</th>
                                                        
                                                        <th rowspan="2" colspan="2" style="border: 1px solid #d3d3d3;">Total Sales</th>
                                                        <th style="border: 1px solid #d3d3d3;">Action</th>
                                                        
                                                    </tr>
                                                    <tr class="lw-table-row-1">
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">Sales As Per E-Voucher</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">Sales As per Voucher Upload</th>
                                                        <th style="border: 1px solid #d3d3d3;" colspan="2">PM-EDRIVE</th>
                                                        <th style="border: 1px solid #d3d3d3;" colspan="2">EMPS</th>
                                                    </tr>
                                                    <tr class="lw-table-row-1">
                                                        
                                                        <th style="border: 1px solid #d3d3d3;">As Per vahan*</th>
                                                        <th style="border: 1px solid #d3d3d3;">As Per Portal</th>
                                                        <th style="border: 1px solid #d3d3d3;">As Per vahan*</th>
                                                        <th style="border: 1px solid #d3d3d3;">As Per Portal</th>
                                                        <th style="border: 1px solid #d3d3d3;">As Per vahan*</th>
                                                        <th style="border: 1px solid #d3d3d3;">As Per Portal</th>
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
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["voucher_generated"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["voucher_uploaded"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["drive_vahan"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["drive_portal"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["emps_vahan"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["emps_portal"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["total_vahan"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;"><b>{{ indian_format($sale["total_portal"]) }}</b></td>
                                                        <td>
                                                            @if(Auth::user()->hasRole('OEM'))
                                                                <a href="{{route('dashboard.dealer.segment', urlencode($sale["categroy_name"]))}}" target="_blank" class="btn btn-primary">View</a>
                                                            @else
                                                                <a href="{{route('dashboard.segment', urlencode($sale["categroy_name"]))}}" target="_blank" class="btn btn-primary">View</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table> --}}


                                            <table id="basic-12" class="display table-bordered table-striped" style="border: 1px solid #d3d3d3; border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr class="lw-table-row-1">
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">SN</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">Segment Name</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">Vehicle Category</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">Target Sales</th>
                                                        <th colspan="3" style="border: 1px solid #d3d3d3;">Sales under EMPS</th>
                                                        <th colspan="5" style="border: 1px solid #d3d3d3;">Sales under PM-EDRIVE</th>
                                                        <th colspan="2" style="border: 1px solid #d3d3d3;">Total Sales</th>
                                                        <th colspan="2" style="border: 1px solid #d3d3d3;">E-Voucher</th>

                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">% Buyer ID</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">% Face Scanned</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">% Voucher Generated</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">% Voucher Uploaded</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">% Permanent No.</th>

                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">Action</th>
                                                    </tr>
                                                    <tr class="lw-table-row-1">
                                                        <th style="border: 1px solid #d3d3d3;">As per vahan* (A)</th>
                                                        <th style="border: 1px solid #d3d3d3;">As per Portal (C)</th>
                                                        <th style="border: 1px solid #d3d3d3;">Claims Uploaded</th>

                                                        <th style="border: 1px solid #d3d3d3;">As per vahan* (B)</th>
                                                        <th style="border: 1px solid #d3d3d3;">Buyer ID generated (D)</th>
                                                        <th style="border: 1px solid #d3d3d3;">Face ID Successful</th>
                                                        <th style="border: 1px solid #d3d3d3;">Claims Uploaded</th>
                                                        <th style="border: 1px solid #d3d3d3;">Permanent Regn. No. recd</th>
                                                        <th style="border: 1px solid #d3d3d3;">As per vahan* (A+B)</th>
                                                        <th style="border: 1px solid #d3d3d3;">As per Portal (C+D)</th>
                                                        <th style="border: 1px solid #d3d3d3;">Generated</th>
                                                        <th style="border: 1px solid #d3d3d3;">Uploaded</th>
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
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>{{ indian_format($sale["target_sales"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>{{ indian_format($sale["emps_vahan"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>{{ indian_format($sale["emps_portal"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>{{ indian_format($sale["claim_emps"]) }}</b></td>

                                                       <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>{{ indian_format($sale["drive_vahan"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>{{ indian_format($sale["buyer_id_drive"]) }}</b></td>
                                                       <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"> <b>{{ indian_format($sale["face_scans_count"]) }}</b> </td>
                                                       <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"> <b>{{ indian_format($sale["claim_drive"]) }}</b> </td>
                                                       <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"> <b>{{ indian_format($sale["perm_num_count_edrive"]) }}</b> </td>
                                                        

                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>{{ indian_format($sale["total_vahan"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>{{ indian_format($sale["total_portal"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>{{ indian_format($sale["voucher_generated"]) }}</b></td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>{{ indian_format($sale["voucher_uploaded"]) }}</b></td>

                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;"><b>
                                                            {{-- {{ indian_format($sale["percent_buyer_id"]) }}</b> --}}
                                                            @if((int)$sale["drive_vahan"] > 0)
                                                                @php 
                                                                   $percentage = round(( (int)$sale["buyer_id_drive"] / (int)$sale["drive_vahan"] ) * 100);
                                                                @endphp
                                                                {{$percentage > 100 ? 100 : $percentage}}
                                                            @else
                                                            0
                                                            @endif
                                                        </td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;">
                                                             {{-- <b>{{ indian_format($sale["percent_face_scanned"]) }}</b> --}}
                                                            @if((int)$sale["buyer_id_drive"] > 0)
                                                                @php 
                                                                   $percentage = round(( (int)$sale["face_scans_count"] / (int)$sale["buyer_id_drive"] ) * 100);
                                                                @endphp
                                                                {{$percentage > 100 ? 100 : $percentage}}
                                                            @else
                                                            0
                                                            @endif 
                                                        </td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;">
                                                            {{-- <b>{{ indian_format($sale["percentVoucherGenerated"]) }}</b> --}}
                                                            @if((int)$sale["face_scans_count"] > 0)
                                                                @php 
                                                                   $percentage = round(( (int)$sale["voucher_generated"] / (int)$sale["face_scans_count"] ) * 100);
                                                                @endphp
                                                                {{$percentage > 100 ? 100 : $percentage}}
                                                            @else
                                                            0
                                                            @endif
                                                        </td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;">
                                                            {{-- <b>{{ indian_format($sale["percentVoucherUploaded"]) }}</b> --}}
                                                            @if((int)$sale["voucher_generated"] > 0)
                                                                @php 
                                                                   $percentage = round(( (int)$sale["voucher_uploaded"] / (int)$sale["voucher_generated"] ) * 100);
                                                                @endphp
                                                                {{$percentage > 100 ? 100 : $percentage}}
                                                            @else
                                                            0
                                                            @endif
                                                        </td>
                                                        <td class="text-right" style="border: 1px solid #d3d3d3;text-align: right;">
                                                            {{-- <b>{{ indian_format($sale["percentPermanentNumber"]) }}</b> --}}
                                                            @if((int)$sale["drive_vahan"] > 0)
                                                                @php 
                                                                   $percentage = round(( (int)$sale["perm_num_count_edrive"] / (int)$sale["drive_vahan"] ) * 100);
                                                                @endphp
                                                                {{$percentage > 100 ? 100 : $percentage}}
                                                            @else
                                                            0
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(Auth::user()->hasRole('OEM'))
                                                                <a href="{{route('dashboard.dealer.segment', urlencode($sale["categroy_name"]))}}" target="_blank" class="btn btn-primary">View</a>
                                                            @else
                                                                <a href="{{route('dashboard.segment', urlencode($sale["categroy_name"]))}}" target="_blank" class="btn btn-primary">View</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @if (Auth::user()->hasRole('MHI-DS'))
                                <div class="col-lg-4 col-sm-6">
                                    <div class="card o-hidden small-widget">
                                        <div class="card-body total-Progress border-b-warning border-2"> <span
                                                class="f-light f-w-500 f-14">OEM Pre-Register</span>
                                            <div class="project-details">
                                                <div class="project-counter">
                                                    <h6 class="f-w-600 pb-2 pt-2"><a
                                                            href="{{ route('preRegister', 'P') }}">Pending With DS:-
                                                            {{ $dashboard->pending_with_ds }}</a>
                                                    </h6><span class="f-12 f-w-400"> </span>
                                                    <h6 class="f-w-600 pb-2"><a
                                                            href="{{ route('preRegister', 'A') }}">Approved
                                                            By DS:-
                                                            {{ $dashboard->approved_by_ds }}</a>
                                                    </h6><span class="f-12 f-w-400"> </span>
                                                    <h6 class="f-w-600"><a href="{{ route('preRegister', 'R') }}">Rejected
                                                            By
                                                            DS:-
                                                            {{ $dashboard->rejected_by_ds }}</a>
                                                    </h6><span class="f-12 f-w-400"> </span>
                                                </div>
                                                <div class="product-sub bg-warning-light">
                                                    <svg class="invoice-icon">
                                                        <use href="{{ asset('admin/svg/icon-sprite.svg#fill-task') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                            </div>
                                            <ul class="bubbles">
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="col-lg-4 col-sm-6">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-Complete border-b-secondary border-2"><span
                                            class="f-light f-w-500 f-14">OEM Registration</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h6 class="f-w-600 pb-2 pt-2"><a
                                                        href="{{ route('postRegister', 'P') }}">Pending With DS:-
                                                        {{ $PostData->pending_with_ds }}</a>
                                                </h6><span class="f-12 f-w-400"></span>
                                                <h6 class="f-w-600 pb-2"><a
                                                        href="{{ route('postRegister', 'R') }}">Recommended By
                                                        DS:-{{ $PostData->recommended_by_ds }}</a>
                                                </h6><span class="f-12 f-w-400"></span>
                                                <h6 class="f-w-600 pb-2"><a href="{{ route('postRegister', 'C') }}">To Be
                                                        Approved By
                                                        AS:-{{ $PostData->to_be_approved_by_as }}</a>
                                                </h6><span class="f-12 f-w-400"></span>
                                                <h6 class="f-w-600 "><a href="{{ route('postRegister', 'A') }}">Approved by
                                                        AS:-{{ $PostData->approved_by_as }}</a>
                                                </h6><span class="f-12 f-w-400"></span>

                                            </div>
                                            <div class="product-sub bg-secondary-light">
                                                <svg class="invoice-icon">
                                                    <use href="{{ asset('admin/svg/icon-sprite.svg#fill-form') }}"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <ul class="bubbles">
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-Complete border-b-secondary border-2"><span
                                            class="f-light f-w-500 f-14">Models Data</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h6 class="f-w-600 pb-2 "><a href="{{ route('modelsView', 'P') }}">Pending
                                                        at MHI:-
                                                        {{ $models->pending_at_mhi }}</a>
                                                </h6><span class="f-12 f-w-400"></span>
                                                <h6 class="f-w-600 pb-2"><a href="{{ route('modelsView', 'A') }}">Approved
                                                        by MHI:-{{ $models->approved_by_mhi }}</a></h6>
                                                <span class="f-12 f-w-400"></span>
                                                <h6 class="f-w-600"><a href="{{ route('modelsView', 'R') }}">Rejected by
                                                        MHI:-{{ $models->rejected_by_mhi }}</a></h6><span
                                                    class="f-12 f-w-400"></span>
                                            </div>
                                            <div class="product-sub bg-secondary-light">
                                                <svg class="invoice-icon">
                                                    <use href="{{ asset('admin/svg/icon-sprite.svg#fill-form') }}"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <ul class="bubbles">
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body OEM-data border-b-primary border-2">
                                        <span class="f-light f-w-500 f-14">Sale Details (EVs) (Nos.)</span>
                                      
                                        <div class="OEM-data-details">
                                            <div class="OEM-data-counter">
                                                <div class="d-flex align-items-center justify-content-between pb-2">
                                                    <div>
                                                        <h6 class="f-w-600">
                                                            <a href="{{ route('claimDetails', 'AS') }}">
                                                                Sales Submitted By Dealer:
                                                                {{ $claimData->sales_submitted_by_dealer }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('claimDetails.download', 'AS') }}"><i
                                                                class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between pb-2">
                                                    <div>
                                                        <h6 class="f-w-600">
                                                            <a href="{{ route('claimDetails', 'AV') }}">
                                                                Vehicle Approved by OEM:
                                                                {{ $claimData->vehicle_approved_by_oem }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('claimDetails.download', 'AV') }}"><i
                                                                class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between pb-2">
                                                    <div>
                                                        <h6 class="f-w-600">
                                                            <a href="{{ route('claimDetails', 'CG') }}">
                                                                Claim Generated by OEM:
                                                                {{ $claimData->claim_generated_by_oem }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('claimDetails.download', 'CG') }}"><i
                                                                class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <h6 class="f-w-600">
                                                            <a href="{{ route('claimDetails', 'CS') }}">
                                                                Claim Submitted by OEM:
                                                                {{ $claimData->claim_submitted_by_oem }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('claimDetails.download', 'CS') }}"><i
                                                                class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="bubbles">
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dt-ext table-responsive custom-scrollbar">
                                            <h1>OEM EV Summary</h1>
                                           

                                            <table class="display table-bordered table-striped" id="export-button">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">SN</th>
                                                        <th>Vehicle Type</th>
                                                        <th>Total Production Count</th>
                                                        <th>Total Sold by Dealer</th>
                                                        <th>Total Approved by OEM</th>
                                                        <th>Total Claims Submitted</th>
                                                        <th>Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalProductionCount = 0;
                                                        $totalSoldByDealer = 0;
                                                        $totalApprovedByOem = 0;
                                                        $totalClaimSubmitted = 0;
                                                        $sn = 1;
                                                    @endphp
                                                    @foreach ($oem_summary as $row)
                                                        @php
                                                            $totalProductionCount += $row->total_production_count;
                                                            $totalSoldByDealer += $row->total_sold_by_dealer;
                                                            $totalApprovedByOem += $row->total_approved_by_oem;
                                                            $totalClaimSubmitted += $row->total_claim_submitted;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $sn++ }}</td>
                                                            <td>{{ $row->vehicle_type }}</td>
                                                            <td class="text-end">
                                                                {{ number_format($row->total_production_count) }}</td>
                                                            <td class="text-end">
                                                                {{ number_format($row->total_sold_by_dealer) }}</td>
                                                            <td class="text-end">
                                                                {{ number_format($row->total_approved_by_oem) }}</td>
                                                            <td class="text-end">
                                                                {{ number_format($row->total_claim_submitted) }}</td>
                                                            <td>
                                                                <a href="{{ route('OEMSummaryShow', ['vehicle_type' => $row->vehicle_type]) }}"
                                                                    class="btn btn-primary">
                                                                    View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2">Total</th>
                                                        <th class="text-end">{{ number_format($totalProductionCount) }}
                                                        </th>
                                                        <th class="text-end">{{ number_format($totalSoldByDealer) }}</th>
                                                        <th class="text-end">{{ number_format($totalApprovedByOem) }}</th>
                                                        <th class="text-end">{{ number_format($totalClaimSubmitted) }}
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif(Auth::user()->hasRole('OEM'))
                            <div class="col-xl-3 col-sm-6">
                                <a href="{{ route('manageDealer.index') }}">
                                    <div class="card o-hidden small-widget">
                                        <div class="card-body total-project border-b-primary border-2"><span
                                                class="f-light f-w-500 f-14">No. Of Dealers</span>
                                            <div class="project-details">
                                                <div class="project-counter">
                                                    <span class="f-12 f-w-400"></span>

                                                </div>
                                                <div class="product-sub bg-primary-light">
                                                    <svg class="invoice-icon">
                                                        <use href="{{ asset('admin/svg/icon-sprite.svg#fill-user') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                            </div>
                                            <ul class="bubbles">
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                                <li class="bubble"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @if (isset($authApi))
                                <div class="col-xl-6 col-sm-6">
                                    <div class="card o-hidden small-widget">
                                        <div class="card-body total-project border-b-primary border-2"><span
                                                class="f-light f-w-500 f-14">Sales API Detail</span>
                                            <div class="project-details">
                                                <div class="project-counter">
                                                    <h6 class="f-w-600 pb-2">OEM Code:-{{ $authApi->oem_code }}</h6>
                                                    <span class="f-12 f-w-400"></span>
                                                    <h6 class="f-w-600">API Key:-{{ $authApi->key }}</h6><span
                                                        class="f-12 f-w-400 "></span>

                                                </div>
                                                <div class="product-sub bg-primary-light">
                                                    <svg class="invoice-icon">
                                                        <use href="{{ asset('admin/svg/icon-sprite.svg#fill-user') }}">
                                                        </use>
                                                    </svg>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endif
                        @elseif(Auth::user()->hasRole('PMA'))
                            <div class="col-xl-4 col-sm-6">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-Complete border-b-secondary border-2"><span
                                            class="f-light f-w-500 f-14">Models Data</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h6 class="f-w-600 pb-2 "><a
                                                        href="{{ route('modelsView', 'P') }}">Pending
                                                        at MHI:-
                                                        {{ $models->pending_at_mhi }}</a>
                                                </h6><span class="f-12 f-w-400"></span>
                                                <h6 class="f-w-600 pb-2"><a
                                                        href="{{ route('modelsView', 'A') }}">Approved
                                                        by MHI:-{{ $models->approved_by_mhi }}</a></h6>
                                                <span class="f-12 f-w-400"></span>
                                                <h6 class="f-w-600"><a href="{{ route('modelsView', 'R') }}">Rejected by
                                                        MHI:-{{ $models->rejected_by_mhi }}</a></h6><span
                                                    class="f-12 f-w-400"></span>
                                            </div>
                                            <div class="product-sub bg-secondary-light">
                                                <svg class="invoice-icon">
                                                    <use href="{{ asset('admin/svg/icon-sprite.svg#fill-form') }}"></use>
                                                </svg>
                                            </div>
                                        </div>
                                        <ul class="bubbles">
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-6">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body OEM-data border-b-primary border-2">
                                        <span class="f-light f-w-500 f-14">Sale Details (EVs) (Nos.)</span>
                                        <div class="OEM-data-details">
                                            <div class="OEM-data-counter">
                                                <div class="d-flex align-items-center justify-content-between pb-2">
                                                    <div>
                                                        <h6 class="f-w-600">
                                                            <a href="{{ route('claimDetails', 'AS') }}">
                                                                Sales Submitted By Dealer:
                                                                {{ $claimData->sales_submitted_by_dealer }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('claimDetails.download', 'AS') }}"><i
                                                                class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between pb-2">
                                                    <div>
                                                        <h6 class="f-w-600">
                                                            <a href="{{ route('claimDetails', 'AV') }}">
                                                                Vehicle Approved by OEM:
                                                                {{ $claimData->vehicle_approved_by_oem }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('claimDetails.download', 'AV') }}"><i
                                                                class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between pb-2">
                                                    <div>
                                                        <h6 class="f-w-600">
                                                            <a href="{{ route('claimDetails', 'CG') }}">
                                                                Claim Generated by OEM:
                                                                {{ $claimData->claim_generated_by_oem }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('claimDetails.download', 'CG') }}"><i
                                                                class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <h6 class="f-w-600">
                                                            <a href="{{ route('claimDetails', 'CS') }}">
                                                                Claim Submitted by OEM:
                                                                {{ $claimData->claim_submitted_by_oem }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('claimDetails.download', 'CS') }}"><i
                                                                class="fa fa-download"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <ul class="bubbles">
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dt-ext table-responsive custom-scrollbar">
                                            <h1>OEM EV Summary</h1>
                                           
                                            <table class="display table-bordered table-striped" id="export-button">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">SN</th>
                                                        <th>Vehicle Type</th>
                                                        <th>Total Production Count</th>
                                                        <th>Total Sold by Dealer</th>
                                                        <th>Total Approved by OEM</th>
                                                        <th>Total Claims Submitted</th>
                                                        <th>Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $totalProductionCount = 0;
                                                        $totalSoldByDealer = 0;
                                                        $totalApprovedByOem = 0;
                                                        $totalClaimSubmitted = 0;
                                                        $sn = 1;
                                                    @endphp
                                                    @foreach ($oem_summary as $row)
                                                        @php
                                                            $totalProductionCount += $row->total_production_count;
                                                            $totalSoldByDealer += $row->total_sold_by_dealer;
                                                            $totalApprovedByOem += $row->total_approved_by_oem;
                                                            $totalClaimSubmitted += $row->total_claim_submitted;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $sn++ }}</td>
                                                            <td>{{ $row->vehicle_type }}</td>
                                                            <td class="text-end">
                                                                {{ number_format($row->total_production_count) }}</td>
                                                            <td class="text-end">
                                                                {{ number_format($row->total_sold_by_dealer) }}</td>
                                                            <td class="text-end">
                                                                {{ number_format($row->total_approved_by_oem) }}</td>
                                                            <td class="text-end">
                                                                {{ number_format($row->total_claim_submitted) }}</td>
                                                            <td>
                                                                <a href="{{ route('OEMSummaryShow', ['vehicle_type' => $row->vehicle_type]) }}"
                                                                    class="btn btn-primary">
                                                                    View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2">Total</th>
                                                        <th class="text-end">{{ number_format($totalProductionCount) }}
                                                        </th>
                                                        <th class="text-end">{{ number_format($totalSoldByDealer) }}</th>
                                                        <th class="text-end">{{ number_format($totalApprovedByOem) }}</th>
                                                        <th class="text-end">{{ number_format($totalClaimSubmitted) }}
                                                        </th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        @elseif(Auth::user()->hasRole('DEALER'))
                            <div class="card mt-4" style="width: 80%;margin: 0 auto;">
                                <div class="card-body">
                                    <div class="container centered-container">
                                        <h2 class="text-center">Download Applications</h2>
                                        <a href="{{ asset('docs/dealer/app-release.apk') }}" class="btn btn-primary mt-2"
                                            download>PM E-DRIVE</a>
                                        <a href="https://play.google.com/store/apps/details?id=in.gov.uidai.facerd"
                                            class="btn btn-secondary mt-2" target="_blank">AadhaarFaceRD (UIDAI)</a>
                                        <div class="disclaimer text-danger">
                                            <p><strong>NOTE:</strong> Please ensure that you have deleted the existing
                                                applications (AadhaarFaceRD, PM E-DRIVE UAT version) before installing the
                                                applications above.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
@endpush
