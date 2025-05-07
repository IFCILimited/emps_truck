<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    OEM Model Requests
@endsection

@push('styles')
    <style>
        table th {

            white-space: nowrap;
            /* Prevent text from breaking onto a new line */

        }
    </style>
@endpush

@section('content')
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>OEM Model Requests</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dt-ext table-responsive  custom-scrollbar">
                            <table class="display table-bordered  table-striped" id="basic-12">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>OEM Name</th>
                                        <th>xEV Model Name</th>
                                        <th>Variant Name </th>
                                        <th>Vehicle Segment</th>
                                        <th>Vehicle Category</th>
                                        <th> OEM Submitted Date </th>
                                        <th> PM E-Drive Certificate </th>
                                        <th> CMVR Date </th>
                                        <th> PM E-Drive Date </th>
                                        <th> Effective From </th>
                                        <th> Valid Upto </th>
                                        <th>Testing Agency Status</th>
                                        <th>Testing Agency Submitted Date</th>
                                        <th>Testing Agency By</th>
                                        <th>PMA Status</th>
                                        <th>PMA Recommended By</th>
                                        <th>PMA Remarks</th>
                                        <th>PMA Recommended Date</th>
                                        <th>Mhi Status</th>
                                        <th>MHI Approved By</th>
                                        <th>MHI Approved Date</th>
                                        <th>Remarks</th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modelMaster as $model)

                                                                        @php
                                                                            $isConditionMet = false;

                                                                            if ($model->testing_flag == 'A' && $model->pma_status == null) {
                                                                                $isConditionMet = true;
                                                                            } elseif ($model->testing_flag == 'A' && $model->pma_status == 'A') {
                                                                                $isConditionMet = true;
                                                                            } elseif ($model->testing_flag == 'A' && $model->pma_status == 'R') {
                                                                                $isConditionMet = true;
                                                                            } elseif ($model->testing_flag == 'A' && $model->pma_status == 'N') {
                                                                                $isConditionMet = true;
                                                                            } elseif ($model->testing_flag == 'A' && $model->pma_status == 'A' && $model->mhi_flag == null) {
                                                                                $isConditionMet = true;
                                                                            } elseif ($model->testing_flag == 'A' && $model->pma_status == 'A' && $model->mhi_flag == 'A') {
                                                                                $isConditionMet = true;
                                                                            } elseif ($model->testing_flag == 'A' && $model->pma_status == 'A' && $model->mhi_flag == 'R') {
                                                                                $isConditionMet = true;
                                                                            } elseif ($model->testing_flag == 'D' && $model->pma_status == null && $model->pma_revert_status == 'R') {
                                                                                $isConditionMet = true;
                                                                            } elseif ($model->testing_flag == 'A' && $model->pma_status == null && $model->pma_revert_status == null && $model->mhi_revert_status == 'R') {
                                                                                $isConditionMet = true;
                                                                            }
                                                                        @endphp

                                                                        @if ($isConditionMet)
                                                                                                    <!-- Do something when the condition is met -->

                                                                                                    <tr>
                                                                                                        <td>{{ $loop->iteration }}</td>
                                                                                                        <td>{{ $model->oem_name }}</td>
                                                                                                        <td> {{ $model->model_name }}</td>
                                                                                                        <td>{{ $model->variant_name }} </td>
                                                                                                        <td>{{ $model->segment }}</td>
                                                                                                        <td>{{ $model->vehicle_cat }}</td>
                                                                                                        @php
                                                                                                            $submitted_time = strtotime($model->submitted_at);
                                                                                                            $submitted_format = date('d-m-Y', $submitted_time);

                                                                                                            $testing_cmvr_time = strtotime($model->testing_cmvr_date);
                                                                                                            $testing_cmvr_format = date('d-m-Y', $testing_cmvr_time);

                                                                                                            $testing_approval_date = strtotime($model->testing_approval_date);
                                                                                                            $testing_approval_date = date('d-m-Y', $testing_approval_date);

                                                                                                            //$valid_from_time = strtotime($model->valid_from);
                                                                                                            $valid_from_time = strtotime($model->valid_date);
                                                                                                            $valid_from_format = date('d-m-Y', $valid_from_time);

                                                                                                            $valid_upto_time = strtotime($model->valid_upto);
                                                                                                            $valid_upto_format = date('d-m-Y', $valid_upto_time);

                                                                                                            $strToTimeDate = strtotime($model->testing_created_at);
                                                                                                            $formated = date('d-m-Y', $strToTimeDate);
                                                                                                        @endphp
                                                                                                        <td data-sort={{ $submitted_time }} class="text-center">{{ $submitted_format }}
                                                                                                        </td>
                                                                                                        <td>{{ $model->testing_certificate_no }}</td>
                                                                                                        <td data-sort={{ $testing_cmvr_time }} class="text-center">
                                                                                                            {{ $testing_cmvr_format }}</td>
                                                                                                        <td data-sort={{ $testing_approval_date }} class="text-center">
                                                                                                            {{ $testing_approval_date }}</td>
                                                                                                        <td data-sort={{ $valid_from_time }} class="text-center">
                                                                                                            {{ $valid_from_format }}</td>
                                                                                                        <td data-sort={{ $valid_upto_time }} class="text-center">
                                                                                                            {{ $valid_upto_format }}</td>
                                                                                                        <td class="text-center" @if ($model->testing_flag == 'A') bgcolor="lightgreen"
                                                                                                        @elseif($model->testing_flag == 'R') bgcolor="red"
                                                                                                        @elseif($model->testing_flag == 'D') bgcolor="red" @else bgcolor="orange" @endif>
                                                                                                            {{ $model->testing_flag == 'A' ? 'Approved' : ($model->testing_flag == 'R' ? 'Rejected' : ($model->testing_flag == 'D' ? 'Reverted' : 'Pending')) }}

                                                                                                        </td>
                                                                                                        <td data-sort={{ $strToTimeDate }} class="text-center">{{ $formated }}
                                                                                                        </td>
                                                                                                        <td class="text-center">
                                                                                                            @if($model->testing_agency_id == null)
                                                                                                                -
                                                                                                            @else
                                                                                                                {{ $users->where('id', $model->testing_agency_id)->first()->name }}
                                                                                                            @endif
                                                                                                        </td>
                                                                                                        {{-- <td class="text-center" --}} {{-- @if ($model->pma_status == 'A')
                                                                                                            bgcolor="lightgreen" @elseif($model->pma_status == 'R') bgcolor="red"
                                                                                                            @elseif($model->pma_revert_status == 'R') bgcolor="red" @else bgcolor="orange"
                                                                                                            @endif> --}}
                                                                                                            {{-- {{ $model->pma_status == 'A' ? 'Approved' : ($model->pma_status == 'R' ?
                                                                                                            'Rejected' : ($model->testing_flag == 'R' ? '-' : 'Pending')) }} --}}
                                                                                                            {{-- {{ $model->pma_status == 'A' ? 'Recommended' : ($model->pma_status == 'R' ?
                                                                                                            'Rejected' : ($model->pma_revert_status == 'R' ? 'Reverted' :
                                                                                                            ($model->pma_status == 'N' ? 'NA' : 'Pending'))) }} --}}


                                                                                                            {{-- </td> --}}
                                                                                                        <td class="text-center" style="
                                                                                                                @if ($model->pma_status == 'A' && $model->pma_revert_status == null) background-color: lightgreen; /* Approved */
                                                                                                                @elseif ($model->pma_status == 'R' && $model->pma_revert_status == null) background-color: red; /* Rejected */
                                                                                                                @elseif ($model->pma_status == 'N' && $model->pma_revert_status == null) background-color: gray; /* N/A */
                                                                                                                @elseif ($model->pma_status == null && $model->pma_revert_status == 'R' && $model->testing_flag == 'D') background-color: red; /* Reverted to Testing Agency */
                                                                                                                @elseif ($model->pma_status == null && $model->testing_flag == 'A') background-color: orange; /* Pending */
                                                                                                                @elseif ($model->pma_status == 'A' && $model->testing_flag == 'A' && $model->mhi_flag == null ) background-color: lightgreen; /* Approved */
                                                                                                                @elseif ($model->pma_status == 'A' && $model->testing_flag == 'A' && $model->mhi_flag == 'A') background-color: lightgreen; /* Approved */
                                                                                                                    @else  background-color: gray;
                                                                                                                @endif
                                                                                                            ">
                                                                                                            @if ($model->pma_status == 'A' && $model->pma_revert_status == null)
                                                                                                                Recommended
                                                                                                            @elseif($model->pma_status == 'R' && $model->pma_revert_status == null)
                                                                                                                Rejected
                                                                                                            @elseif($model->pma_status == 'N' && $model->pma_revert_status == null)
                                                                                                                N/A
                                                                                                            @elseif($model->pma_status == null && $model->pma_revert_status == 'R' && $model->testing_flag == 'D')
                                                                                                                Reverted to Testing Agency
                                                                                                            @elseif($model->pma_status == null && $model->testing_flag == 'A')
                                                                                                                Pending
                                                                                                            @elseif($model->pma_status == 'N' && $model->testing_flag == 'A' && $model->mhi_flag == 'A')
                                                                                                                N/A
                                                                                                            @elseif($model->pma_status == 'N' && $model->mhi_flag == 'A')
                                                                                                                N/A
                                                                                                            @elseif ($model->pma_status == 'A' && $model->testing_flag == 'A' && $model->mhi_flag == null)
                                                                                                            Recommended
                                                                                                            @elseif ($model->pma_status == 'A' && $model->testing_flag == 'A' && $model->mhi_flag == 'A')
                                                                                                            Recommended
                                                                                                            @else
                                                                                                                -
                                                                                                            @endif
                                                                                                        </td>
                                                                                                        <td class="text-center">
                                                                                                            @if($model->pma_created_by == null)
                                                                                                                -
                                                                                                            @else
                                                                                                                {{ $users->where('id', $model->pma_created_by)->first()->name }}
                                                                                                            @endif
                                                                                                        </td>
                                                                                                        {{-- <td>{{$model->pma_remarks}}</td> --}}
                                                                                                        <td>
                                                                                                            @if ($model->pma_status == 'R' && $model->pma_revert_status == null)
                                                                                                                {{ $model->pma_remarks }}
                                                                                                            @elseif($model->pma_status == 'N' && $model->pma_revert_status == null)
                                                                                                                -
                                                                                                            @elseif($model->pma_status == null && $model->pma_revert_status == 'R' && $model->testing_flag == 'D')
                                                                                                                {{ $model->pma_revert_remarks }}
                                                                                                            @elseif($model->pma_status == null && $model->testing_flag == 'A')
                                                                                                                -
                                                                                                            @endif
                                                                                                        </td>
                                                                                                        @php
                                                                                                            $pma_time = null; // Default value
                                                                                                        @endphp

                                                                                                        @if ($model->pma_status == 'A' || ($model->pma_status == 'R' && $model->pma_revert_status == null))
                                                                                                                                    @php
                                                                                                                                        $pma_time = strtotime($model->pma_created_at);
                                                                                                                                        $pma_format = date('d-m-Y', $pma_time);
                                                                                                                                    @endphp
                                                                                                        @elseif($model->pma_status == 'N' && $model->pma_revert_status == null)

                                                                                                        @elseif($model->pma_status == null && $model->pma_revert_status == 'R' && $model->testing_flag == 'D')
                                                                                                                                    @php
                                                                                                                                        $pma_time = strtotime($model->pma_reverted_date);
                                                                                                                                        $pma_format = date('d-m-Y', $pma_time);
                                                                                                                                    @endphp
                                                                                                        @endif

                                                                                                        <td data-sort="{{ $pma_time }}" class="text-center">
                                                                                                            {{ $pma_time != null ? $pma_format : '-' }}
                                                                                                        </td>


                                                                                                        {{-- <td class="text-center" @if ($model->mhi_flag == 'A') bgcolor="lightgreen"
                                                                                                            @elseif($model->mhi_flag == 'R') bgcolor="red" @elseif($model->mhi_revert_status
                                                                                                            == 'R') bgcolor="red" @else bgcolor="orange" @endif>
                                                                                                            {{ $model->mhi_flag == 'A' ? 'Approved' : ($model->mhi_flag == 'R' ? 'Rejected'
                                                                                                            : ($model->mhi_revert_status == 'R' ? 'Reverted' :($model->testing_flag == 'R' ?
                                                                                                            '-' : 'Pending'))) }}

                                                                                                        </td> --}}
                                                                                                        <td class="text-center" style="
                                                                                                                @if ($model->pma_status == 'A' && $model->mhi_flag == null) background-color: orange;
                                                                                                                @elseif ($model->pma_status == 'A' && $model->mhi_flag == 'R') background-color: red;
                                                                                                                @elseif ($model->pma_status == null && $model->mhi_flag == null && $model->mhi_revert_status == 'R') background-color: red;
                                                                                                                @elseif ($model->pma_status == 'A' && $model->mhi_flag == 'A') background-color: lightgreen;
                                                                                                                @elseif ($model->pma_status == 'N' && $model->mhi_flag == 'A') background-color: lightgreen;
                                                                                                                @elseif ($model->pma_status == 'N' && $model->mhi_flag == null && $model->mhi_revert_status == 'R') background-color: red;
                                                                                                                @elseif($model->pma_status == 'N' && $model->mhi_flag == 'R') background-color: red;
                                                                                                                    @else  background-color: gray;
                                                                                                                @endif
                                                                                                            ">

                                                                                                            @if ($model->pma_status == 'A' && $model->mhi_flag == null)
                                                                                                                Pending
                                                                                                            @elseif($model->pma_status == 'A' && $model->mhi_flag == 'R')
                                                                                                                Rejected
                                                                                                            @elseif ($model->pma_status == null && $model->mhi_flag == null && $model->mhi_revert_status == 'R')
                                                                                                                Reverted to PMA
                                                                                                            @elseif($model->pma_status == 'A' && $model->mhi_flag == 'A')
                                                                                                                Approved
                                                                                                            @elseif($model->pma_status == 'N' && $model->mhi_flag == 'A')
                                                                                                                Approved
                                                                                                            @elseif($model->pma_status == 'N' && $model->mhi_flag == null && $model->mhi_revert_status == 'R')
                                                                                                                Reverted to PMA
                                                                                                            @elseif($model->pma_status == 'N' && $model->mhi_flag == 'R')
                                                                                                                Rejected
                                                                                                            @endif

                                                                                                        </td>

                                                                                                        <td>
                                                                                                            @if ($model->mhi_id == null)
                                                                                                                -
                                                                                                            @else
                                                                                                                {{ $users->where('id', $model->mhi_id)->first()->name }}
                                                                                                            @endif
                                                                                                        </td>


                                                                                                        @php
                                                                                                            $mhi_time = null;
                                                                                                            $mhi_format = '-';
                                                                                                        @endphp

                                                                                                        @if ($model->pma_status == 'A' && $model->mhi_revert_status == null && $model->mhi_flag == 'A')
                                                                                                                                    @php
                                                                                                                                        $mhi_time = strtotime($model->mhi_created_at);
                                                                                                                                        $mhi_format = date('d-m-Y', $mhi_time);
                                                                                                                                    @endphp
                                                                                                        @elseif($model->pma_status == 'N' && $model->mhi_flag == 'A')
                                                                                                                                    @php
                                                                                                                                        $mhi_time = strtotime($model->mhi_created_at);
                                                                                                                                        $mhi_format = date('d-m-Y', $mhi_time);
                                                                                                                                    @endphp
                                                                                                        @elseif($model->pma_status == 'A' && $model->mhi_revert_status == 'R' && $model->mhi_flag == null)
                                                                                                                                    @php
                                                                                                                                        $mhi_time = strtotime($model->mhi_revert_date);
                                                                                                                                        $mhi_format = date('d-m-Y', $mhi_time);
                                                                                                                                    @endphp
                                                                                                        @elseif($model->pma_status == 'A' && $model->mhi_flag == 'R')
                                                                                                                                    @php
                                                                                                                                        $mhi_time = strtotime($model->mhi_created_at);
                                                                                                                                        $mhi_format = date('d-m-Y', $mhi_time);
                                                                                                                                     @endphp
                                                                                                        @elseif($model->pma_status == 'N' && $model->mhi_flag == 'R')
                                                                                                                                    @php
                                                                                                                                        $mhi_time = strtotime($model->mhi_created_at);
                                                                                                                                        $mhi_format = date('d-m-Y', $mhi_time);
                                                                                                                                    @endphp
                                                                                                        @endif

                                                                                                        <td data-sort="{{ $mhi_time ?? 0 }}" class="text-center">{{ $mhi_format }}
                                                                                                        </td>

                                                                                                        <td>
                                                                                                            @if ($model->pma_status == null && $model->mhi_flag == null && $model->mhi_revert_status == 'R')
                                                                                                                {{ $model->mhi_revert_remarks }}
                                                                                                            @elseif($model->pma_status == 'A' && $model->mhi_flag == 'R')
                                                                                                                {{ $model->mhi_remarks }}
                                                                                                            @elseif($model->pma_status == 'N' && $model->mhi_flag == 'R')
                                                                                                                {{ $model->mhi_remarks }}
                                                                                                            @else
                                                                                                                {{ $model->exist }}
                                                                                                            @endif

                                                                                                        </td>
                                                                                                        {{-- <td>@if ($model->mhi_revert_status == 'R'){{$model->mhi_revert_remarks}} @else
                                                                                                            {{ $model->exist }} @endif</td> --}}
                                                                                                        {{-- <td>
                                                                                                            @if ($model->mhi_revert_status == 'R' && $model->pma_status == 'D')
                                                                                                            Reverted by MHI
                                                                                                            @elseif($model->pma_status == 'D')
                                                                                                            @if ($model->pma_status != 'R')
                                                                                                            <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                class="btn btn-success">Process</a>
                                                                                                            @else
                                                                                                            <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                class="btn btn-success">View</a>
                                                                                                            @endif
                                                                                                            @endif
                                                                                                        </td> --}}
                                                                                                        <td>
                                                                                                            @if ($model->testing_flag == 'A' && $model->pma_status == null && Auth::user()->hasRole('PMA'))
                                                                                                                <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                    class="btn btn-success">Process</a>
                                                                                                            @elseif ($model->testing_flag == 'A' && $model->pma_status == 'A' && $model->mhi_flag == null && Auth::user()->hasRole('PMA'))
                                                                                                                <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                    class="btn btn-success">View</a>
                                                                                                            @elseif ($model->testing_flag == 'A' && $model->pma_status == 'N' && $model->mhi_flag == 'A')
                                                                                                                <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                    class="btn btn-success">View</a>
                                                                                                            @elseif ($model->testing_flag == 'A' && $model->pma_status == 'A' && $model->mhi_flag == null && Auth::user()->hasRole('MHI-DS'))
                                                                                                                <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                    class="btn btn-success">Process</a>
                                                                                                            @elseif ($model->testing_flag == 'A' && $model->pma_status == 'N' && $model->mhi_flag == 'A')
                                                                                                                <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                    class="btn btn-success">View</a>
                                                                                                            @elseif ($model->testing_flag == 'D' && $model->pma_status == null && $model->pma_revert_status == 'R')
                                                                                                                Reverted to Testing Agency
                                                                                                            @elseif ($model->testing_flag == 'A' && $model->mhi_revert_status == 'R' && (Auth::user()->hasRole('MHI-DS') || Auth::user()->hasRole('MHI-AS') || Auth::user()->hasRole('MHI') || Auth::user()->hasRole('AUDITOR')))
                                                                                                                Reverted to PMA
                                                                                                            @elseif ($model->testing_flag == 'A' && $model->mhi_revert_status == 'R' && Auth::user()->hasRole('PMA'))
                                                                                                                <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                    class="btn btn-success">Process</a>
                                                                                                            @elseif ($model->testing_flag == 'A' && $model->pma_status == 'A' && $model->mhi_flag == 'A')
                                                                                                                <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                    class="btn btn-success">View</a>
                                                                                                            @elseif ($model->testing_flag == 'A' && $model->pma_status == 'R' && $model->mhi_flag == null)
                                                                                                                <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                    class="btn btn-success">View</a>
                                                                                                            @elseif ($model->testing_flag == 'A' && $model->pma_status == 'A' && $model->mhi_flag == 'R')
                                                                                                                <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                    class="btn btn-success">View</a>
                                                                                                            @elseif ($model->testing_flag == 'A' && $model->pma_status == 'N' && $model->mhi_flag == 'R')
                                                                                                                <a href="{{ route('modelRequests.show', encrypt($model->model_detail_id)) }}"
                                                                                                                    class="btn btn-success">View</a>
                                                                                                            @endif




                                                                                                        </td>
                                                                                                    </tr>
                                                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Model Approval</h5>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action=" " method="POST" id="creApproval" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="reason">Reason for rejection</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\ModelOEMApprovalRequest', '#creApproval') !!}
@endpush