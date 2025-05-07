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
                        @if ( Auth::user()->hasRole('OEM'))
                            {{-- 05-10-2024 --}}
                            <div class="col-sm-12 mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dt-ext table-responsive custom-scrollbar">
                                            <h1>Vehicle Sales Data </h1>
                                            <table class="display table-bordered table-striped" id="export-button-dealer">

                                                <thead>
                                                    <tr>
                                                        <th class="text-center">SN</th>
                                                        <th class="text-center">Dealer Code</th>
                                                        <th class="text-center">Dealer Name</th>
                                                        <th class="text-center">Category Name</th>
                                                        <th class="text-center">Segment Name</th>
                                                        <th class="text-center">Face ID Successful</th>
                                                        <th class="text-center">Permanent Regn. No. recd</th>
                                                        <th class="text-center">E-Voucher Generated</th>
                                                        <th class="text-center">E-Voucher Uploaded</th>
<th class="text-center">Pending At Dealer</th>
                                                        <th class="text-center">OEM Submitted</th>
                                                        <th class="text-center">OEM Approved</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sn = 1;
                                                        $totalCount = 0;
                                                    @endphp
                                                        @php
                                                            $totalVoucherGenerated = 0;
                                                            $totalVoucherUploaded = 0;
                                                            $totalCountFaceScanned = 0;
                                                            $totalCountPerm = 0;
                                                            $totalOemSubmitted = 0;
                                                            $totalOemApproved = 0;
$totalDraft = 0;
                                                        @endphp
                                                    @foreach ($summary as $sum)
                                                        <tr>
                                                            <td>{{ $sn++ }}</td>
                                                            <td>{{ $sum->dealer_code }}</td>
                                                            <td>{{ $sum->dealer_name }}</td>
                                                            <td>
                                                                {{implode('+',$toViewSegment)}}
                                                            </td>
                                                            <td>
                                                                @if(count($toViewSegment) == 2)
                                                                    e-2w
                                                                @else
                                                                   e-3w 
                                                                @endif
                                                            </td>
                                                            <td>{{ indian_format($sum->face_scanned) }}
                                                                @php $totalCountFaceScanned += $sum->face_scanned @endphp
                                                            </td>
                                                            <td>{{ indian_format($sum->pem_record_count) }}
                                                                @php $totalCountPerm += $sum->pem_record_count @endphp
                                                            </td>
                                                            
                                                            <td>{{ indian_format($sum->voucher_generated) }}
                                                                @php $totalVoucherGenerated += $sum->voucher_generated @endphp
                                                            </td>
                                                            <td>{{ indian_format($sum->voucher_uploaded) }}
                                                                @php $totalVoucherUploaded += $sum->voucher_uploaded @endphp
                                                            </td>
<td>{{ indian_format($sum->draft_count) }}
  @php $totalDraft += $sum->draft_count @endphp
</td>
                                                            <td>{{ indian_format($sum->oem_submitted) }}
                                                                @php $totalOemSubmitted += $sum->oem_submitted @endphp
                                                            </td>
                                                            <td>{{ indian_format($sum->oem_approved) }}
                                                                @php $totalOemApproved += $sum->oem_approved @endphp
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-right" colspan="5">Total</th>
                                                        <th class="text-end">{{indian_format($totalCountFaceScanned)}}</th>
                                                        <th class="text-end">{{indian_format($totalCountPerm)}}</th>
                                                        <th class="text-end">{{indian_format($totalVoucherGenerated)}}</th>
                                                        <th class="text-end">{{indian_format($totalVoucherUploaded)}}</th>
                                                        <th class="text-end">{{indian_format($totalDraft)}}</th>
 <th class="text-end">{{indian_format($totalOemSubmitted)}}</th>
                                                        <th class="text-end">{{indian_format($totalOemApproved)}}</th>
                                                    </tr>
                                                </tfoot> 
                                               

                                            </table>
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
    $("#export-button-dealer").DataTable({
      dom: "Bfrtip",
      buttons: ["csvHtml5"],
      pageLength: 50,
      order: [], // Disable initial sorting
    });
</script>
@endpush
