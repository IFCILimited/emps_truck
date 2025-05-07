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
                                Auth::user()->hasRole('PMA'))
                            {{-- 05-10-2024 --}}
                            <div class="col-sm-12 mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dt-ext table-responsive custom-scrollbar">
                                            <h1>Vehicle Sales Data</h1>
                                            <table class="display table-bordered table-striped" id="export-button">

                                                <thead>
                                                    <tr>
                                                        <th class="text-center">SN</th>
                                                        <th>OEM Name</th>
                                                        <th>Segment Name</th>
                                                        <th>Category Name</th>
                                                        <th colspan="5" class="text-center">Sales</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4"></th>
                                                        <th colspan="2">PM-EDRIVE</th>
                                                        <th colspan="2">EMPS</th>
                                                        {{-- <th></th> --}}
                                                    </tr>
                                                    <tr>
                                                        <th colspan="4"></th>
                                                        <th>As Per vahan</th>
                                                        <th>As Per portal</th>
                                                        <th>As Per vahan</th>
                                                        <th>As Per portal</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sn = 1;
                                                        $totalCount = 0;
                                                    @endphp
                                                        @php
                                                            $totalCountVahan = 0;
                                                            $totalPortalCountVahan = 0;
                                                            $totalCountEmps = 0;
                                                            $totalCountEmpsPortal = 0;
                                                        @endphp
                                                    @foreach ($oems as $oem)
                                                        <tr>
                                                            <td>{{ $sn++ }}</td>
                                                            <td>{{ $oem->oem_name }}</td>
                                                            <td>
                                                                @if(count($toViewSegment) == 2)
                                                                    e-2w
                                                                @else
                                                                   e-3w 
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{implode('+',$toViewSegment)}}
                                                            </td>
                                                            <td>
                                                                @if(isset($vahan_summary[$oem->oem_name]))
                                                                    {{indian_format($vahan_summary[$oem->oem_name]) }}
                                                                    @php $totalCountVahan += $vahan_summary[$oem->oem_name]; @endphp
                                                                @else
                                                                    0
                                                                @endif
                                                                {{-- {{$oemCount[$oem->oem_id] ? $oemCount[$oem->oem_id] : 0}} --}}
                                                            </td>
                                                            <td>
                                                                @if(isset($vahan_portal_summary[$oem->oem_id]))
                                                                    {{indian_format($vahan_portal_summary[$oem->oem_id]) }}
                                                                    @php $totalPortalCountVahan += $vahan_portal_summary[$oem->oem_id]; @endphp
                                                                @else
                                                                    0
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if(isset($emps_summary[$oem->oem_name]))
                                                                    {{indian_format($emps_summary[$oem->oem_name]) }}
                                                                    @php $totalCountEmps += $emps_summary[$oem->oem_name]; @endphp
                                                                @else
                                                                    0
                                                                @endif
                                                                {{-- {{$view_oem_wise_data[$oem->oem_id] ? $view_oem_wise_data[$oem->oem_id] : 0}} --}}
                                                            </td>
                                                            <td>
                                                                @if(isset($emps_buyer_summary_total[$oem->oem_name]))
                                                                    {{indian_format($emps_buyer_summary_total[$oem->oem_name]) }}
                                                                    @php $totalCountEmpsPortal += $emps_buyer_summary_total[$oem->oem_name]; @endphp
                                                                @else
                                                                    0
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-left" colspan="4">Total</th>
                                                        <th class="text-end">{{indian_format($totalCountVahan)}}</th>
                                                        <th class="text-end">{{indian_format($totalPortalCountVahan)}}</th>
                                                        <th class="text-end">{{indian_format($totalCountEmps)}}</th>
                                                        <th class="text-end">{{indian_format($totalCountEmpsPortal)}}</th>
                                                    </tr>
                                                </tfoot> 
                                               

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        {{-- @elseif(Auth::user()->hasRole('DEALER'))
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
                            </div> --}}
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
