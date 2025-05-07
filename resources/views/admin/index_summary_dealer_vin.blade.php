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
        @if (Auth::user()->hasRole('DEALER'))
            <div class="card mt-4" style="width: 80%;margin: 0 auto;">
                <div class="card-body">
                    <div class="container centered-container">
                        <h2 class="text-center">Download Applications</h2>
                        <a href="{{ asset('docs/dealer/app-release.apk') }}" class="btn btn-primary mt-2" download>PM
                            E-DRIVE</a>
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
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row size-column">
                <div class="col-xxl-12 box-col-12">
                    <div class="row">
                        {{-- 05-10-2024 --}}
                        <div class="col-sm-12 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dt-ext table-responsive custom-scrollbar mt-2">
                                        <h1>Vehicle Sales Data </h1>
                                        <table class="table table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>Dealer Name:</th>
                                                    <td>
                                                        @if (Auth::user()->hasRole('DEALER'))
                                                            {{ Auth::user()->name }}
                                                        @else
                                                            {{ $details[0]->dealer_name }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Dealer Code:</th>
                                                    <td>
                                                        @if (Auth::user()->hasRole('DEALER'))
                                                            {{ Auth::user()->dealer_code }}
                                                        @else
                                                            {{ $details[0]->dealer_code }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                @if (!Auth::user()->hasRole('DEALER'))
                                                    <tr>
                                                        <th>Segment:</th>
                                                        <td>
                                                            @if (count($toViewSegment) == 2)
                                                                e-2w
                                                            @else
                                                                e-3w
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Category:</th>
                                                        <td>{{ implode('+', $toViewSegment) }}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <div class="dt-ext table-responsive custom-scrollbar">
                                        <table class="display table-bordered table-striped" id="export-button-dealer">

                                            <thead>
                                                <tr>
                                                    <th class="text-center">SN</th>
                                                    @if (Auth::user()->hasRole('DEALER'))
                                                        <th class="text-center">Segment Name</th>
                                                        <th class="text-center">Category Name</th>
                                                    @endif
                                                    <th class="text-center">VIN Number</th>
                                                    <th class="text-center">Customer Name</th>
                                                    <th class="text-center">Customer Type</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">E-Voucher Generated</th>
                                                    <th class="text-center">E-Voucher uploaded</th>
                                                    <th class="text-center">Vahan Available</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $sn = 1;
                                                    $totalCount = 0;
                                                @endphp
                                                @php
                                                    // $totalVoucherGenerated = 0;
                                                    // $totalVoucherUploaded = 0;
                                                    // $totalCountFaceScanned = 0;
                                                @endphp
                                                @foreach ($details as $det)
                                                    <tr>
                                                        <td>{{ $sn++ }}</td>
                                                        @if (Auth::user()->hasRole('DEALER'))
                                                            <td>{{ $det->segment_name }}</td>
                                                            <td>{{ $det->vehicle_cat }}</td>
                                                        @endif
                                                        <td>{{ $det->vin_chassis_no }}</td>
                                                        <td>{{ $det->custmr_name }}</td>
                                                        <td>
                                                            @if ($det->custmr_typ == 1)
                                                                Individual
                                                            @else
                                                                Bulk
                                                            @endif
                                                        </td>
                                                        <td {{-- class="@if ($det->adh_verify == 'N') bg-danger @else 
                                                                 @if ($det->status == 'D')
                                                                        bg-warning
                                                                    @elseif($det->status=='S')
                                                                        bg-primary
                                                                    @elseif($det->status=='A')
                                                                        bg-success
                                                                    @elseif($det->status=='P')
                                                                        bg-info
                                                                    @endif
                                                                @endif" --}}>
                                                            @if ($det->adh_verify == 'N')
                                                                <span>Face Authentication Pending</span>
                                                            @else
                                                                @if ($det->status == 'D')
                                                                    Pending
                                                                @elseif($det->status == 'S')
                                                                    Document Pending
                                                                @elseif($det->status == 'A')
                                                                    Submitted
                                                                @elseif($det->status == 'P')
                                                                    RC Pending
                                                                @endif
                                                            @endif
                                                        </td>
                                                        <td {{-- class="@if (isset($det->vhcl_regis_no) || isset($det->temp_reg_no)) bg-success @else bg-danger @endif" --}}>
                                                            @if ((isset($det->vhcl_regis_no) || isset($det->temp_reg_no)) && $det->adh_verify == 'Y')
                                                                <span>YES</span>
                                                            @else
                                                                <span>NO</span>
                                                            @endif
                                                        </td>
                                                        <td {{-- class="@if ($det->evoucher_copy_id) bg-success @else bg-danger @endif" --}}>
                                                            @if ($det->evoucher_copy_id)
                                                                YES
                                                            @else
                                                                NO
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($det->vahanavailable == 'Y')
                                                                YES
                                                            @else
                                                                NO
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                {{-- <tr>
                                                        <th class="text-right" colspan="5">Total</th>
                                                        <th class="text-end">{{indian_format($totalCountFaceScanned)}}</th>
                                                        <th class="text-end">{{indian_format($totalCountPerm)}}</th>
                                                        <th class="text-end">{{indian_format($totalVoucherGenerated)}}</th>
                                                        <th class="text-end">{{indian_format($totalVoucherUploaded)}}</th>
                                                        <th class="text-end">{{indian_format($totalDraft)}}</th>
                                                        <th class="text-end">{{indian_format($totalOemSubmitted)}}</th>
                                                        <th class="text-end">{{indian_format($totalOemApproved)}}</th>
                                                    </tr> --}}
                                            </tfoot>


                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
    <script>
        $("#export-button-dealer").DataTable({
            dom: "Bfrtip",
            buttons: ["csvHtml5"],
            pageLength: 50,
            order: [], // Disable initial sorting
        });
    </script>
@endpush
