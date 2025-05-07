<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Admin - Dashboard
@endsection

@push('styles')
    <style>
     

    .fixed-columns {
      position: sticky;
      left: 0;
      z-index: 2;
      background-color: white;
    }

   
    </style>
@endpush

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
                                            <h1>Vehicle Sales Data for segment : 
                                                @if(count($toViewSegment) == 2)
                                                    e-2w
                                                @else
                                                    e-3w 
                                                @endif
                                                , category: 
                                                {{implode('+',$toViewSegment)}}
                                                </h1>
                                            <table class="display table-bordered table-striped" id="export-button-dealer">

                                                <thead class="fixed-header">
                                                    <tr class="lw-table-row-1">
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;">SN</th>
                                                        <th rowspan="2" style="border: 1px solid #d3d3d3;white-space: nowrap; ">Oem Name</th>
                                                        <th colspan="3" style="border: 1px solid #d3d3d3;">Sales under EMPS</th>
                                                        <th colspan="7" style="border: 1px solid #d3d3d3;">Sales under PM-EDRIVE</th>
                                                        <th colspan="2" style="border: 1px solid #d3d3d3;">Total Sales</th>
                                                        <th colspan="2" style="border: 1px solid #d3d3d3;">E-Voucher</th>
                                                    </tr>
                                                    <tr class="lw-table-row-1">
                                                        
                                                        <th style="border: 1px solid #d3d3d3;">As per Vahan <br>(A)</th>
                                                        <th style="border: 1px solid #d3d3d3;">Buyer ID generated <br>(B)</th>
                                                        {{-- <th style="border: 1px solid #d3d3d3;">As per Portal (C)</th> --}}
                                                        <th style="border: 1px solid #d3d3d3;">Claims Uploaded</th>
                                                        {{-- <th style="border: 1px solid #d3d3d3;">As per vahan* (B)</th>
                                                         --}}
                                                         <th style="border: 1px solid #d3d3d3;">As per vahan Approved* <br>(C)</th>
                                                        <th style="border: 1px solid #d3d3d3;">As per vahan UnApproved* <br>(D)</th>
                                                        <th style="border: 1px solid #d3d3d3;">As per vahan Total* <br>(E) = (C+D)</th>

                                                        <th style="border: 1px solid #d3d3d3;">Buyer ID generated (F)</th>
                                                        <th style="border: 1px solid #d3d3d3;">Face ID Successful (G)</th>
                                                        <th style="border: 1px solid #d3d3d3;">Claims Uploaded</th>
                                                        <th style="border: 1px solid #d3d3d3;">Permanent Regn. No. recd <br>(K)</th>

                                                        <th style="border: 1px solid #d3d3d3;">As per vahan* <br>(A+B)</th>
                                                        <th style="border: 1px solid #d3d3d3;">As per Portal <br>(C+D)</th>

                                                        <th style="border: 1px solid #d3d3d3;">Generated <br>(H)</th>
                                                        <th style="border: 1px solid #d3d3d3;">Uploaded <br>(I)</th>
                                                        <th style="border: 1px solid #d3d3d3;">% <br>Buyer ID <br>(F/E)</th>
                                                        <th style="border: 1px solid #d3d3d3;">% <br>Face Scanned <br> (G/F)</th>
                                                        <th style="border: 1px solid #d3d3d3;">% <br>Voucher Generated <br> (H/G)</th>
                                                        <th style="border: 1px solid #d3d3d3;">% <br>Voucher Uploaded <br>(I/H)</th>
                                                        <th style="border: 1px solid #d3d3d3;">% <br>Permanent No. <br>(K/E)</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $sn = 1;
                                                        $totalCount = 0;
                                                    @endphp
                                                        @php
                                                            $totalCountVahanAppr = 0;
                                                            $totalCountVahanUnAppr = 0;
                                                            $totalCountVahanTotal = 0;

                                                            $totalCountEmps = 0;
                                                            $totalCountEmpsPortal = 0;
                                                            $totalCountEmpsClaim = 0;
                                                            $totalCountFaceScanned = 0;
                                                            $totalCountRegNo = 0;
                                                            $totalVoucherGenerated = 0;
                                                            $totalVoucherUploaded = 0;
                                                            $totalCountBuyerId = 0;
                                                            $totalCountEdriveClaim = 0;
                                                            $totalVahanCountConsolidate = 0;
                                                            $totalPortalCountConsolidate = 0;
                                                        @endphp
                                                    @foreach ($summary as $sum)
                                                        <tr>
                                                            <td class="fixed-columns"><b>{{ $sn++ }}</b></td>
                                                            <td class="fixed-columns"><b>{{ $sum->oem_name }}</b></td>
                                                            <td class="text-end"><b>{{ indian_format($sum->emps_vahan) }}</b>
                                                                @php $totalCountEmps += $sum->emps_vahan @endphp
                                                            </td>
                                                            <td class="text-end"><b>{{ indian_format($sum->emps_portal) }}</b>
                                                                @php $totalCountEmpsPortal += $sum->emps_portal @endphp
                                                            </td>
                                                            <td class="text-end"><b>{{ indian_format($sum->claim_emps) }}</b>
                                                                @php $totalCountEmpsClaim += $sum->claim_emps @endphp
                                                            </td>
                                                            {{-- <td class="text-end"><b>{{ indian_format($sum->drive_vahan) }}</b>
                                                                @php $totalCountVahan += $sum->drive_vahan @endphp
                                                            </td> --}}
                                                            <td class="text-end"><b>{{ indian_format($sum->vahan_edrive_approved) }}</b>
                                                                @php $totalCountVahanAppr += $sum->vahan_edrive_approved @endphp
                                                            </td>
                                                            <td class="text-end"><b>{{ indian_format($sum->vahan_edrive_unapproved) }}</b>
                                                                @php $totalCountVahanUnAppr += $sum->vahan_edrive_unapproved @endphp
                                                            </td>
                                                            <td class="text-end"><b>{{ indian_format($sum->vahan_edrive_total) }}</b>
                                                                @php $totalCountVahanTotal += $sum->vahan_edrive_total @endphp
                                                            </td>


                                                            <td class="text-end"><b>{{ indian_format($sum->buyer_id_generated_edrive) }}</b>
                                                                @php $totalCountBuyerId += $sum->buyer_id_generated_edrive @endphp
                                                            </td>
                                                            <td class="text-end"><b>{{ indian_format($sum->face_scans_count) }}</b>
                                                                @php $totalCountFaceScanned += $sum->face_scans_count @endphp
                                                            </td>
                                                            <td class="text-end"><b>{{ indian_format($sum->claim_drive) }}</b>
                                                                @php $totalCountEdriveClaim += $sum->claim_drive @endphp
                                                            </td>
                                                            <td class="text-end"><b>{{ indian_format($sum->perm_num_count) }}</b>
                                                                @php $totalCountRegNo += $sum->perm_num_count @endphp
                                                            </td>
                                                            <td class="text-end"><b>{{ indian_format($sum->total_vahm_oem) }}</b>
                                                                @php $totalVahanCountConsolidate += $sum->total_vahm_oem @endphp
                                                            </td>
                                                            
                                                            <td class="text-end"><b>{{ indian_format($sum->total_portal_oem) }}</b>
                                                                @php $totalPortalCountConsolidate += $sum->total_portal_oem @endphp
                                                            </td>
                                                            <td class="text-end"><b>{{ indian_format($sum->voucher_generated) }}</b>
                                                                @php $totalVoucherGenerated += $sum->voucher_generated @endphp
                                                            </td>
                                                            <td class="text-end"><b>{{ indian_format($sum->voucher_uploaded) }}</b>
                                                                @php $totalVoucherUploaded += $sum->voucher_uploaded @endphp
                                                            </td>
                                                            
                                                        <td class="text-end"><b>{{indian_format($sum->percentBuyerId)}}</b></td>
                                                        <td class="text-end"><b>{{indian_format($sum->percentFaceScanned)}}</b></td>
                                                        <td class="text-end"><b>{{indian_format($sum->percentVoucherGenerated)}}</b></td>
                                                        <td class="text-end"><b>{{indian_format($sum->percentVoucherUploaded)}}</b></td>
                                                        <td class="text-end"><b>{{indian_format($sum->percentPermanentNumber)}}</b></td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-right fixed-columns" colspan="2">Total</th>
                                                        <th class="text-end"><b>{{indian_format($totalCountEmps)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalCountEmpsPortal)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalCountEmpsClaim)}}</b></th>

                                                        <th class="text-end"><b>{{indian_format($totalCountVahanAppr)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalCountVahanUnAppr)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalCountVahanTotal)}}</b></th>

                                                        <th class="text-end"><b>{{indian_format($totalCountBuyerId)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalCountFaceScanned)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalCountEdriveClaim)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalCountRegNo)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalVahanCountConsolidate)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalPortalCountConsolidate)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalVoucherGenerated)}}</b></th>
                                                        <th class="text-end"><b>{{indian_format($totalVoucherUploaded)}}</b></th>
                                                    </tr>
                                                </tfoot> 
                                               

                                            </table>
                                        </div>

                                        <span></span><br>
                                        <span>The details given are for digitized vehicle records as per centralized Vahan 4.</span><br>
                                        <span>Data for Telangana, and some RTO's of Lakshadweep has not been provided as they are not in centralized Vahan 4.</span>
                                        
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
      paging: true,
      pageLength: 50,
      order: [], // Disable initial sorting
    });
</script>
@endpush
