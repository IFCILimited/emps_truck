<!-- Nav Bar Ends here -->
@php
    $layout = Auth::user()->hasRole('OEM-Truck')|| Auth::user()->hasRole('DEALER-Truck') ? 'layouts.e_truck_dashboard_master' : 'layouts.dashboard_master';
@endphp

@extends($layout)
@section('title')
    Admin - Dashboard
@endsection

@push('styles')
    <style>

    </style>`
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
                                Auth::user()->hasRole('PMA') || Auth::user()->hasRole('OEM')|| Auth::user()->hasRole('OEM-Truck') || Auth::user()->hasRole('MHI'))
                            {{-- 05-10-2024 --}}
                            <div class="col-sm-12 mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dt-ext table-responsive custom-scrollbar">
                                            <h1>Vehicle Sales Data</h1>
                                            
                                            <table id="custom-dashboard" class="table table-bordered table-striped" style="border: 1px solid #d3d3d3; border-collapse: collapse; width: 100%;">
                                                <thead>
                                                    <tr class="lw-table-row-1">
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;text-align: center;vertical-align: middle;">S.no.</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;text-align: center;vertical-align: middle;">Segment Name</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;text-align: center;vertical-align: middle;">Vehicle Category</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;text-align: center;vertical-align: middle;">Target Sales</th>

                                                        <!-- <th colspan="2" style="min-width: 15rem;text-align: center;">EVs registered from 1st April 2024 till 30/09/2024 (EMPS)</th> -->
                                                        <th colspan="2" style="min-width: 15rem;text-align: center;">EVs registered from 01/04/2024 till 30/09/2024 (EMPS)</th>
                                                        <th colspan="5" style="text-align: center;">EVs registered on or after <br>01/10/2024 onwards (PM-EDRIVE)</th>

                                                        <th colspan="2" style="border: 1px solid #d3d3d3;text-align: center;">Total Sales</th>
                                                        <th colspan="3" style="text-align: center;">Claims Uploaded under the scheme (number of vehicles)</th>

                                                        <th colspan="2" style="border: 1px solid #d3d3d3;text-align: center;">E-Voucher</th>

                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;text-align: center;">% <br>Buyer ID</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;text-align: center;">% <br>Face Scanned</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;text-align: center;">% <br>Voucher Generated</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;text-align: center;">% <br>Voucher Uploaded</th>
                                                        {{-- <th rowspan="2" style="border: 1px solid #d3d3d3;">% <br>Permanent No.</th> --}}

                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;text-align: center;">Action</th>
                                                    </tr>
                                                    <tr class="lw-table-row-1">
                                                        <th style="border: 1px solid #d3d3d3;text-align: center;">As per vahan</th>
                                                        {{-- <th style="border: 1px solid #d3d3d3;">As per Portal <br>(B)</th> --}}
                                                        <th style="border: 1px solid #d3d3d3;text-align: center;">Buyer ID generated</th>

                                                        <th style="border: 1px solid #d3d3d3;text-align: center;min-width: 6rem;">Approved As per vahan</th>
                                                        {{-- <th style="border: 1px solid #d3d3d3;">Pending for Approval As per vahan</th> --}}
                                                        <th style="border: 1px solid #d3d3d3;text-align: center;min-width: 6rem;">Un-Approved As per vahan</th>

                                                        <th style="border: 1px solid #d3d3d3;text-align: center;">Total As per vahan</th>
                                                        <th style="border: 1px solid #d3d3d3;text-align: center;">Buyer ID generated</th>
                                                        <th style="border: 1px solid #d3d3d3;text-align: center;">Face ID Successful</th>
                                                        <th style="border: 1px solid #d3d3d3;text-align: center;">As per vahan</th>
                                                        <th style="border: 1px solid #d3d3d3;text-align: center;">As per Portal</th>
                                                        <th style="text-align: center;">EMPS</th>
                                                        <th style="text-align: center;">PM-EDRIVE</th>
                                                        <th style="text-align: center;">Total</th>
                                                        <th style="border: 1px solid #d3d3d3;text-align: center;">Generated</th>
                                                        <th style="border: 1px solid #d3d3d3;text-align: center;">Uploaded</th>
                                                    </tr>
                                                    <tr class="lw-table-row-1">
                                                        <th colspan="4"></th>
                                                        <th style="text-align: center;">(A)</th>
                                                        <th style="text-align: center;">(B)</th>
                                                        <th style="text-align: center;">(C)</th>
                                                        <th style="text-align: center;">(D)</th>
                                                        <th style="min-width: 5rem;text-align: center;">(E) = (C+D)</th>
                                                        <th style="text-align: center;">(F)</th>
                                                        <th style="text-align: center;">(G)</th>
                                                        <th style="text-align: center;">(A+E)</th>
                                                        <th style="text-align: center;">(B+F)</th>
                                                        <th style="text-align: center;">(H)</th>
                                                        <th style="text-align: center;">(I)</th>
                                                        <th style="min-width: 5rem;text-align: center;">(J) = (H+I)</th>
                                                        <th style="text-align: center;">(K)</th>
                                                        <th style="text-align: center;">(L)</th>
                                                        <th style="text-align: center;">(F/E)</th>
                                                        <th style="text-align: center;">(G/F)</th>
                                                        <th style="text-align: center;">(K/G)</th>
                                                        <th style="text-align: center;">(L/K)</th>
                                                        <th></th>
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
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["target_sales"]) }}</b></td>

                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["emps_vahan"]) }}</b></td>
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["emps_portal"]) }}</b></td>

                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["drive_vahan_approved"]) }}</b></td>
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["drive_vahan_unapproved"]) }}</b></td>
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["drive_vahan_total"]) }}</b></td>
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["buyer_id_drive"]) }}</b></td>
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"> <b>{{ indian_format($sale["face_scans_count"]) }}</b> </td>
                                                        
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["total_vahan"]) }}</b></td>
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["total_portal"]) }}</b></td>
                                                        
                                                        
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["claim_emps"]) }}</b></td>
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"> <b>{{ indian_format($sale["claim_drive"]) }}</b> </td>
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"> <b>{{ indian_format($sale["claim_emps"] + $sale["claim_drive"]) }}</b> </td>

                                                       {{-- <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["drive_vahan"]) }}</b></td> --}}

                                                       {{-- <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"> <b>{{ indian_format($sale["perm_num_count_edrive"]) }}</b> </td> --}}
                                                        

                                                        
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["voucher_generated"]) }}</b></td>
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;"><b>{{ indian_format($sale["voucher_uploaded"]) }}</b></td>

                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;font-weight: 600;">
                                                            @if((int)$sale["drive_vahan_total"] > 0)
                                                                @php 
                                                                   $percentage = round(( (int)$sale["buyer_id_drive"] / (int)$sale["drive_vahan_total"] ) * 100);
                                                                @endphp
                                                                {{$percentage > 100 ? 100 : $percentage}}
                                                            @else
                                                            0
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;font-weight: 600;">
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
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;font-weight: 600;">
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
                                                        <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;font-weight: 600;">
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
                                                        {{-- <td class="text-center" style="border: 1px solid #d3d3d3;text-align: center;font-weight: 600;">
                                                            @if((int)$sale["drive_vahan_total"] > 0)
                                                                @php 
                                                                   $percentage = round(( (int)$sale["perm_num_count_edrive"] / (int)$sale["drive_vahan_total"] ) * 100);
                                                                @endphp
                                                                {{$percentage > 100 ? 100 : $percentage}}
                                                            @else
                                                            0
                                                            @endif
                                                        </td> --}}
                                                        <td>
                                                            @if(Auth::user()->hasRole('OEM'))
                                                                <a href="{{route('dashboard.dealer.segment', urlencode($sale["categroy_name"]))}}" target="_blank" class="btn btn-primary">View</a>
                                                            @else
                                                                <a href="{{route('dashboardNew.segment', urlencode($sale["categroy_name"]))}}" target="_blank" class="btn btn-primary">View</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                                
                                            </table>
                                        </div>
                                        <span></span><br>
                                    <span>The details given are for digitized vehicle records as per centralized Vahan 4.</span><br>
                                    <span>Data for Telangana, and some RTO's of Lakshadweep has not been provided as they are not in centralized Vahan 4.</span>
                                    </div>
                                </div>
                            </div>
                            
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
<script>
$("#custom-dashboard").DataTable({
    // scrollY: 300,
    paging: false,
    keys: true,
    ordering: false,
    dom: 'Bfrtip', // Enables Buttons
        buttons: [
            {
                extend: 'csv',
                text: 'Export CSV', // Button text
                className: 'btn btn-primary' // Optional: Bootstrap styling
            }
        ]
  });
</script>
@endpush
