@extends('layouts.dashboard_master')
@section('title')
   EMPS Authentication Report
@endsection

@push('styles')
<style>
    .card {
        cursor: pointer; /* Show pointer on hover */
        text-decoration: none; /* Remove underline */
        color: inherit; /* Keep text color */
    }
</style>
@endpush
@section('content')
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="row">
                        <div class="col-6">
                            <h4>Model Report</h4>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{route('modelChartDetails.create')}}" class="btn btn-primary">
                                Model Revert History
                            </a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container mt-4">
            <div class="row g-3">
                <div class="col-md-2">
                    <div class="card shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title"><b>OEM</b></h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-white">Submitted Model<br>(No's)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#oemModal">
                                                {{ $modelCount->oem_count }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title"><b>Testing Agency</b></h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-white">Pending Models (No's)</th>
                                        <th class="text-white">Approved Models (No's)</th>
                                        <th class="text-white">Rejected Models (No's)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#pendingModal">
                                                {{ $modelCount->testing_pending }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" class="text-success text-decoration-none" data-bs-toggle="modal" data-bs-target="#approvedModal">
                                                {{ $modelCount->testing_approved }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" class="text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#rejectedModal">
                                                {{ $modelCount->testing_rejected }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table> <!-- Table properly closed here -->
                        </div>
                    </div>
                </div>



                <div class="col-md-6">
                    <div class="card shadow-sm text-center">
                        <div class="card-body">
                            <h5 class="card-title"><b>PMA</b></h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="text-white">Pending Models (No's)</th>
                                        <th class="text-white">Recommended Models (No's)</th>
                                        <th class="text-white">Rejected Models (No's)</th>
                                        <th class="text-white">N/A Models (No's)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#pmaPendingModal">
                                                {{ $modelCount->pma_pending }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" class="text-success text-decoration-none" data-bs-toggle="modal" data-bs-target="#pmaApprovedModal">
                                                {{ $modelCount->pma_approved }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" class="text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#pmaRejectedModal">
                                                {{ $modelCount->pma_reject }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" class="text-warning text-decoration-none" data-bs-toggle="modal" data-bs-target="#pmaRecommendedModal">
                                                {{ $modelCount->pma_recommanded }}
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8 mx-auto">
                            <div class="card shadow-sm text-center">
                                <div class="card-body">
                                    <h5 class="card-title"><b>MHI</b></h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="bg-primary">
                                                <th class="text-white">Segment</th>
                                                <th class="text-white">Pending Models (No's)</th>
                                                <th class="text-white">Approved Models (No's)</th>
                                                <th class="text-white">Rejected Models (No's)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th>2W</th>
                                                <td><a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#pending2WModal">{{ $modelCount->mhi_pending_seg_1 }}</a></td>
                                                <td><a href="#" class="text-success text-decoration-none" data-bs-toggle="modal" data-bs-target="#approved2WModal">{{ $modelCount->mhi_approved_seg_1 }}</a></td>
                                                <td><a href="#" class="text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#rejected2WModal">{{ $modelCount->mhi_reject_seg_1 }}</a></td>
                                            </tr>
                                            <tr>
                                                <th>3W</th>
                                                <td><a href="#" class="text-primary text-decoration-none" data-bs-toggle="modal" data-bs-target="#pending3WModal">{{ $modelCount->mhi_pending_seg_2 }}</a></td>
                                                <td><a href="#" class="text-success text-decoration-none" data-bs-toggle="modal" data-bs-target="#approved3WModal">{{ $modelCount->mhi_approved_seg_2 }}</a></td>
                                                <td><a href="#" class="text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#rejected3WModal">{{ $modelCount->mhi_reject_seg_2 }}</a></td>
                                            </tr>
                                        </tbody>
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


<div class="modal fade" id="oemModal" tabindex="-1" aria-labelledby="oemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="oemModalLabel">OEM Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered display header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Variant Name</th>
                        <th>Category</th>
                        <th>Segment</th>
                    </thead>


                    {{-- @php
                        $uniqueOems = $modelDetails->unique('oem_name');
                    @endphp --}}
                    <tbody id="oemTableBody">
                        @foreach($modelDetails as $modelDetail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $modelDetail->oem_name }}</td>
                            <td>{{ $modelDetail->model_name }}</td>
                            <td>{{ $modelDetail->variant_name }}</td>
                            <td>{{ $modelDetail->vehicle_cat }}</td>
                            <td>{{ $modelDetail->segment }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="pendingModal" tabindex="-1" aria-labelledby="pendingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pendingModalLabel">Pending Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered display header-fix">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>OEM Name</th>
                            <th>Model Name</th>
                            <th>Segment</th>
                            <th>Category</th>
                            <th>Submitted by OEM</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 1; @endphp
                        @foreach($modelDetails as $modelDetail)
                        @if(is_null($modelDetail->testing_flag) || $modelDetail->testing_flag == 'D')
                            <tr>
                                <td>{{ $counter }}</td>
                                <td>{{ $modelDetail->oem_name }}</td>
                                <td>{{ $modelDetail->model_name }}</td>
                                <td>{{ $modelDetail->segment }}</td>
                                <td>{{ $modelDetail->vehicle_cat }}</td>
                                <td>{{ \Carbon\Carbon::parse(time: $modelDetail->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('modelChart.show', encrypt($modelDetail->model_detail_id)) }}"
                                       class="btn btn-success">View</a>
                                </td>
                            </tr>
                            @php $counter++; @endphp
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- Approved Modal -->
<div class="modal fade" id="approvedModal" tabindex="-1" aria-labelledby="approvedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approvedModalLabel">Approved Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Segment</th>
                        <th>Category</th>
                        <th>Submitted by OEM</th>
                        <th>{{ env('APP_NAME')}} Certificate Effective Date</th>
                        <th>{{ env('APP_NAME')}} Compliance Certificate Valid Upto</th>
                        <th>Action</th>
                    </thead>
                    @php
                        $counter = 1;
                        $modelApprs = $modelDetails->where('testing_flag', 'A');
                    @endphp
                    <tbody id="oemTableBody">
                        @foreach($modelApprs as $key =>$modelAppr)
                            <tr>
                                <td>{{  $counter }}</td>
                                <td>{{ $modelAppr->oem_name }}</td>
                                <td>{{ $modelAppr->model_name }}</td>
                                <td>{{ $modelAppr->segment }}</td>
                                <td>{{ $modelAppr->vehicle_cat }}</td>
                                <td>{{ \Carbon\Carbon::parse($modelAppr->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $modelAppr->valid_date)->format('d-m-Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse( $modelAppr->valid_upto)->format('d-m-Y') }}</td>
                                <td> <a href="{{ route('modelChart.show', encrypt($modelAppr->model_detail_id)) }}"
                                    class="btn btn-success">View</a></td>
                            </tr>
                            @php $counter++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Rejected Modal -->
<div class="modal fade" id="rejectedModal" tabindex="-1" aria-labelledby="rejectedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectedModalLabel">Rejected Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered display header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Segment</th>
                        <th>Category</th>
                        <th>Submitted by OEM</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </thead>
                    @php
                        $counter = 1;
                        $modelRejects = $modelDetails->where('testing_flag', 'R');
                    @endphp
                    <tbody id="oemTableBody">
                        @foreach($modelRejects as $key =>$modelReject)
                            <tr>
                                <td>{{  $counter }}</td>
                                <td>{{ $modelReject->oem_name }}</td>
                                <td>{{ $modelReject->model_name }}</td>
                                <td>{{ $modelReject->segment }}</td>
                                <td>{{ $modelReject->vehicle_cat }}</td>
                                <td>{{ \Carbon\Carbon::parse($modelReject->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td><span class="text-danger">{{ $modelReject->testing_remarks }}</span></td>
                                <td> <a href="{{ route('modelChart.show', encrypt($modelReject->model_detail_id)) }}"
                                    class="btn btn-success">View</a></td>
                            </tr>
                            @php $counter++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- PMA Pending Modal -->
<div class="modal fade" id="pmaPendingModal" tabindex="-1" aria-labelledby="pmaPendingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pmaPendingModalLabel">PMA Pending Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-bordered display header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Segment</th>
                        <th>Category</th>
                        <th>Submitted by OEM</th>
                        <th>Submitted by Testing Agency</th>
                        <th>{{ env('APP_NAME')}} Certificate Effective Date</th>
                        <th>{{ env('APP_NAME')}} Compliance Certificate Valid Upto</th>
                        <th>Action</th>
                    </thead>
                    @php
                        $counter = 1;
                    @endphp
                    <tbody id="oemTableBody">
                        @foreach($modelDetails->where('testing_flag', 'A') as $key =>$modelDetail)
                        @if(is_null($modelDetail->pma_status))
                            <tr>
                                <td>{{  $counter }}</td>
                                <td>{{ $modelDetail->oem_name }}</td>
                                <td>{{ $modelDetail->model_name }}</td>
                                <td>{{ $modelDetail->segment }}</td>
                                <td>{{ $modelDetail->vehicle_cat }}</td>
                                <td>{{  \Carbon\Carbon::parse( $modelDetail->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse( $modelDetail->testing_created_at)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $modelDetail->valid_date)->format('d-m-Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse( $modelDetail->valid_upto)->format('d-m-Y') }}</td>
                                <td> <a href="{{ route('modelChart.show', encrypt($modelDetail->model_detail_id)) }}"
                                    class="btn btn-success">View</a></td>
                            </tr>
                            @php $counter++; @endphp
                        @endif
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PMA Approved Modal -->
<div class="modal fade" id="pmaApprovedModal" tabindex="-1" aria-labelledby="pmaApprovedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pmaApprovedModalLabel">PMA Recommended Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-bordered display header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Segment</th>
                        <th>Category</th>
                        <th>Submitted by OEM</th>
                        <th>Submitted by Testing Agency</th>
                        <th>Submitted by PMA</th>
                        <th>Action</th>
                    </thead>
                    @php
                        $counter = 1;
                        $PmaModelApprs = $modelDetails->where('pma_status', 'A');
                    @endphp
                    <tbody id="oemTableBody">
                        @foreach($PmaModelApprs as $key =>$PmaModelAppr)
                            <tr>
                                <td>{{  $counter }}</td>
                                <td>{{ $PmaModelAppr->oem_name }}</td>
                                <td>{{ $PmaModelAppr->model_name }}</td>
                                <td>{{ $PmaModelAppr->segment }}</td>
                                <td>{{ $PmaModelAppr->vehicle_cat }}</td>
                                <td>{{  \Carbon\Carbon::parse( $PmaModelAppr->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse( $PmaModelAppr->testing_created_at)->format('d-m-Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse( $PmaModelAppr->pma_created_at)->format('d-m-Y') }}</td>
                                <td> <a href="{{ route('modelChart.show', encrypt($PmaModelAppr->model_detail_id)) }}"
                                    class="btn btn-success">View</a></td>
                            </tr>
                            @php $counter++; @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PMA Rejected Modal -->
<div class="modal fade" id="pmaRejectedModal" tabindex="-1" aria-labelledby="pmaRejectedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pmaRejectedModalLabel">PMA Rejected Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-bordered display header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Segment</th>
                        <th>Category</th>
                        <th>Submitted by OEM</th>
                        <th>Submitted by Testing Agency</th>
                        <th>Rejected by PMA</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </thead>
                    @php
                        $counter = 1;
                        $PmaModelRejects = $modelDetails->where('pma_status', 'R');
                    @endphp
                    <tbody id="oemTableBody">
                        @foreach($PmaModelRejects as $key =>$PmaModelReject)
                            <tr>
                                <td>{{  $counter }}</td>
                                <td>{{ $PmaModelReject->oem_name }}</td>
                                <td>{{ $PmaModelReject->model_name }}</td>
                                <td>{{ $PmaModelReject->segment }}</td>
                                <td>{{ $PmaModelReject->vehicle_cat }}</td>
                                <td>{{  \Carbon\Carbon::parse( $PmaModelReject->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse( $PmaModelReject->testing_created_at)->format('d-m-Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse( $PmaModelReject->pma_created_at)->format('d-m-Y') }}</td>
                                <td><span class="text-danger">{{ $PmaModelReject->pma_remarks }}</span></td>
                                <td> <a href="{{ route('modelChart.show', encrypt($PmaModelReject->model_detail_id)) }}"
                                    class="btn btn-success">View</a></td>
                            </tr>
                            @php $counter++; @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="pmaRecommendedModal" tabindex="-1" aria-labelledby="pmaRecommendedModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pmaRecommendedModal">PMA Not Recommended Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-bordered display header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Segment</th>
                        <th>Category</th>
                        <th>Submitted by OEM</th>
                        <th>Submitted by Testing Agency</th>
                        <th>Action</th>
                    </thead>
                    @php
                        $counter = 1;
                        $PmaModelNonRecs = $modelDetails->where('pma_status', 'N');
                    @endphp
                    <tbody id="oemTableBody">
                        @foreach($PmaModelNonRecs as $key =>$PmaModelNonRec)
                            <tr>
                                <td>{{  $counter }}</td>
                                <td>{{ $PmaModelNonRec->oem_name }}</td>
                                <td>{{ $PmaModelNonRec->model_name }}</td>
                                <td>{{ $PmaModelNonRec->segment }}</td>
                                <td>{{ $PmaModelNonRec->vehicle_cat }}</td>
                                <td>{{  \Carbon\Carbon::parse( $PmaModelNonRec->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse( $PmaModelNonRec->testing_created_at)->format('d-m-Y') }}</td>
                                <td> <a href="{{ route('modelChart.show', encrypt($PmaModelNonRec->model_detail_id)) }}"
                                    class="btn btn-success">View</a></td>
                            </tr>
                            @php $counter++; @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="pending2WModal" tabindex="-1" aria-labelledby="pending2WModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pending2WModalLabel">2W Pending Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered display header-fix">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>OEM Name</th>
                                <th>Model Name</th>
                                <th>Segment</th>
                                <th>Category</th>
                                <th>Submitted by OEM</th>
                                <th>Submitted by Testing Agency</th>
                                <th>Submitted by PMA</th>
                                <th>{{ env('APP_NAME') }} Certificate Effective Date</th>
                                <th>{{ env('APP_NAME') }} Compliance Certificate Valid Upto</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 1; @endphp
                            @foreach($modelDetails->where('segment_id', '1')->whereIn('pma_status', ['A', 'N']) as $modelDetail)
                                @if(is_null($modelDetail->mhi_flag))
                                    <tr>
                                        <td>{{ $counter }}</td>
                                        <td>{{ $modelDetail->oem_name }}</td>
                                        <td>{{ $modelDetail->model_name }}</td>
                                        <td>{{ $modelDetail->segment }}</td>
                                        <td>{{ $modelDetail->vehicle_cat }}</td>
                                        <td>{{  \Carbon\Carbon::parse( $modelDetail->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                        <td>{{  \Carbon\Carbon::parse( $modelDetail->testing_created_at)->format('d-m-Y') }}</td>
                                        <td>{{  \Carbon\Carbon::parse( $modelDetail->pma_created_at)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse( $modelDetail->valid_date)->format('d-m-Y') }}</td>
                                        <td>{{  \Carbon\Carbon::parse( $modelDetail->valid_upto)->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('modelChart.show', encrypt($modelDetail->model_detail_id)) }}" class="btn btn-success">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    @php $counter++; @endphp
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- End Table Responsive -->
            </div>
        </div>
    </div>
</div>

<!-- 2W Approved Modal -->
<div class="modal fade" id="approved2WModal" tabindex="-1" aria-labelledby="approved2WModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approved2WModalLabel">2W Approved Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table table-bordered display header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Segment</th>
                        <th>Category</th>
                        <th>Submitted by OEM</th>
                        <th>Submitted by Testing Agency</th>
                        <th>Submitted by PMA</th>
                        <th>Submitted by MHI</th>
                        <th>Action</th>
                    </thead>
                    @php
                        $counter = 1;
                        $mhiModelApprs = $modelDetails->where('segment_id', '1')->where('mhi_flag','A')->whereIn('pma_status', ['A', 'N']);
                    @endphp
                    <tbody id="oemTableBody">
                        @foreach($mhiModelApprs as $key =>$mhiModelAppr)
                            <tr>
                                <td>{{  $counter }}</td>
                                <td>{{ $mhiModelAppr->oem_name }}</td>
                                <td>{{ $mhiModelAppr->model_name }}</td>
                                <td>{{ $mhiModelAppr->segment }}</td>
                                <td>{{ $mhiModelAppr->vehicle_cat }}</td>
                                <td>{{ \Carbon\Carbon::parse( $modelAppr->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $modelAppr->testing_created_at)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $modelAppr->pma_created_at)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $modelAppr->mhi_created_at)->format('d-m-Y') }}</td>
                                <td> <a href="{{ route('modelChart.show', encrypt($modelAppr->model_detail_id)) }}"
                                    class="btn btn-success">View</a></td>
                            </tr>
                            @php $counter++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- 2W Rejected Modal -->
<div class="modal fade" id="rejected2WModal" tabindex="-1" aria-labelledby="rejected2WModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejected2WModalLabel">2W Rejected Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-bordered display header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Segment</th>
                        <th>Category</th>
                        <th>Submitted by OEM</th>
                        <th>Submitted by Testing Agency</th>
                        <th>Submitted by PMA</th>
                        <th>Reject by MHI</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </thead>
                    @php
                        $counter = 1;
                        $mhiModelRejects = $modelDetails->where('segment_id', '1')->where('mhi_flag','R')->whereIn('pma_status', ['A', 'N']);
                    @endphp
                    <tbody id="oemTableBody">
                        @foreach($mhiModelRejects as $key =>$mhiModelReject)
                            <tr>
                                <td>{{  $counter }}</td>
                                <td>{{ $mhiModelReject->oem_name }}</td>
                                <td>{{ $mhiModelReject->model_name }}</td>
                                <td>{{ $mhiModelReject->segment }}</td>
                                <td>{{ $mhiModelReject->vehicle_cat }}</td>
                                <td>{{ \Carbon\Carbon::parse( $mhiModelReject->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $mhiModelReject->testing_created_at)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $mhiModelReject->pma_created_at)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $mhiModelReject->mhi_created_at)->format('d-m-Y') }}</td>
                                <td><span class="text-danger">{{ $mhiModelReject->mhi_remarks }}</span></td>
                                <td> <a href="{{ route('modelChart.show', encrypt($mhiModelReject->model_detail_id)) }}"
                                    class="btn btn-success">View</a></td>
                            </tr>
                            @php $counter++; @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3W Pending Modal -->
<div class="modal fade" id="pending3WModal" tabindex="-1" aria-labelledby="pending3WModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pending3WModalLabel">3W Pending Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                            <div class="modal-body">
                                <div class="table-responsive">
                                <table class="table table-bordered display header-fix">
                                    <thead id="oemTableHead">
                                        <th>S.No.</th>
                                        <th>OEM Name</th>
                                        <th>Model Name</th>
                                        <th>Segment</th>
                                        <th>Category</th>
                                        <th>Submitted by OEM</th>
                                        <th>Submitted by Testing Agency</th>
                                        <th>Submitted by PMA</th>
                                        <th>{{ env('APP_NAME') }} Certificate Effective Date</th>
                                        <th>{{ env('APP_NAME') }} Compliance Certificate Valid Upto</th>
                                        <th>Action</th>
                                    </thead>
                                    @php
                                        $counter = 1;
                                        $mhiModelPendings = $modelDetails->where('segment_id', '2')->whereIn('pma_status', ['A', 'N']);
                                    @endphp
                                    <tbody id="oemTableBody">
                                        @foreach($mhiModelPendings as $key =>$mhiModelPending)
                                        @if(is_null($mhiModelPending->mhi_flag))
                                            <tr>
                                                <td>{{  $counter }}</td>
                                                <td>{{ $mhiModelPending->oem_name }}</td>
                                                <td>{{ $mhiModelPending->model_name }}</td>
                                                <td>{{ $mhiModelPending->segment }}</td>
                                                <td>{{ $mhiModelPending->vehicle_cat }}</td>
                                                <td>{{  \Carbon\Carbon::parse( $mhiModelPending->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                                <td>{{  \Carbon\Carbon::parse( $mhiModelPending->testing_created_at)->format('d-m-Y') }}</td>
                                                <td>{{  \Carbon\Carbon::parse( $mhiModelPending->pma_created_at)->format('d-m-Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse( $mhiModelPending->valid_date)->format('d-m-Y') }}</td>
                                                <td>{{  \Carbon\Carbon::parse( $mhiModelPending->valid_upto)->format('d-m-Y') }}</td>
                                                <td> <a href="{{ route('modelChart.show', encrypt($mhiModelPending->model_detail_id)) }}"
                                                    class="btn btn-success">View</a></td>
                                            </tr>
                                            @php $counter++; @endphp
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<!-- 3W Approved Modal -->
<div class="modal fade" id="approved3WModal" tabindex="-1" aria-labelledby="approved3WModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="approved3WModalLabel">3W Approved Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-bordered display header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Segment</th>
                        <th>Category</th>
                        <th>Submitted by OEM</th>
                        <th>Submitted by Testing Agency</th>
                        <th>Submitted by PMA</th>
                        <th>Submitted by MHI</th>
                        <th>Action</th>
                    </thead>
                    @php
                        $counter = 1;
                        $mhiModelApprs = $modelDetails->where('segment_id', '2')->where('mhi_flag', 'A')->whereIn('pma_status', ['A', 'N']);
                    @endphp
                    <tbody id="oemTableBody">
                        @foreach($mhiModelApprs as $key =>$mhiModelAppr)
                            <tr>
                                <td>{{  $counter }}</td>
                                <td>{{ $mhiModelAppr->oem_name }}</td>
                                <td>{{ $mhiModelAppr->model_name }}</td>
                                <td>{{ $mhiModelAppr->segment }}</td>
                                <td>{{ $mhiModelAppr->vehicle_cat }}</td>
                                <td>{{  \Carbon\Carbon::parse( $mhiModelAppr->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse( $mhiModelAppr->testing_created_at)->format('d-m-Y') }}</td>
                                <td>{{  \Carbon\Carbon::parse( $mhiModelAppr->pma_created_at)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $mhiModelAppr->mhi_created_at)->format('d-m-Y') }}</td>
                                <td> <a href="{{ route('modelChart.show', encrypt($mhiModelAppr->model_detail_id)) }}"
                                    class="btn btn-success">View</a></td>
                            </tr>
                            @php $counter++; @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 3W Rejected Modal -->
<div class="modal fade" id="rejected3WModal" tabindex="-1" aria-labelledby="rejected3WModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejected3WModalLabel">3W Rejected Applications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                <table class="table table-bordered header-fix">
                    <thead id="oemTableHead">
                        <th>S.No.</th>
                        <th>OEM Name</th>
                        <th>Model Name</th>
                        <th>Segment</th>
                        <th>Category</th>
                        <th>Submitted by OEM</th>
                        <th>Submitted by Testing Agency</th>
                        <th>Submitted by PMA</th>
                        <th>Reject by MHI</th>
                        <th>Remarks</th>
                        <th>Action</th>
                    </thead>
                    @php
                        $counter = 1;
                        $mhiModelRejects = $modelDetails->where('segment_id', '2')->where('mhi_flag', 'R')->whereIn('pma_status', ['A', 'N']);
                    @endphp
                    <tbody id="oemTableBody">
                        @foreach($mhiModelRejects as $key =>$mhiModelReject)
                            <tr>
                                <td>{{  $counter }}</td>
                                <td>{{ $mhiModelReject->oem_name }}</td>
                                <td>{{ $mhiModelReject->model_name }}</td>
                                <td>{{ $mhiModelReject->segment }}</td>
                                <td>{{ $mhiModelReject->vehicle_cat }}</td>
                                <td>{{ \Carbon\Carbon::parse( $mhiModelReject->vehicle_sub_to_test_agency_apprv)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $mhiModelReject->testing_created_at)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $mhiModelReject->pma_created_at)->format('d-m-Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse( $mhiModelReject->mhi_created_at)->format('d-m-Y') }}</td>
                                <td><span class="text-danger">{{ $mhiModelReject->mhi_remarks }}</span></td>
                                <td> <a href="{{ route('modelChart.show', encrypt($mhiModelReject->model_detail_id)) }}"
                                    class="btn btn-success">View</a></td>
                            </tr>
                            @php $counter++; @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@push('scripts')
    <script>
    //      $(document).ready(function() {
    //     $('.pendingTable').DataTable({
    //         "paging": true,
    //         "lengthMenu": [5, 10, 25, 50],
    //         "searching": true,
    //         "ordering": true,
    //         "info": true,
    //         "autoWidth": false,
    //         "responsive": true
    //     });
    // });

    $(".pendingTable").DataTable({
      dom: "Bfrtip",
      buttons: ["csvHtml5"],
      paging: true,
      pageLength: 50,
      order: [], // Disable initial sorting
    });
    </script>
@endpush

