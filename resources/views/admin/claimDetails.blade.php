@extends('layouts.dashboard_master')

@section('title', 'Claim Details')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 mb-3">
                        <h4>Claim Details</h4>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar mt-5">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            @if ($flag=='CS')
                                            <th>Claim Format Number</th>
                                            <th>Claim ID</th>
                                            <th>Lot ID</th>
                                            @elseif($flag=='CG')
                                            <th>Claim Format Number</th>
                                            <th>Claim ID</th>
                                            @endif
                                            <th>OEM Name</th>
                                            <th>Model Name</th>
                                            <th>Variant Name</th>
                                            <th>Segment Name</th>
                                            <th>Vehicle Category</th>
                                            <th>VIN/Chassis No.</th>
                                            <th>Customer Name</th>
                                            <th>Customer State</th>
                                            <th>Vehicle Reg. No.</th>
                                            <th>Vehicle Reg. Date</th>
                                            <th>Invoice No.</th>
                                            <th>Invoice Date</th>
                                            <th>Invoice Amount</th>
                                            <th>Total Incentives</th>
                                            @if ($flag=='CS')
                                            <th>Lot Created Date</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($claimData as $key => $claim)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                @if ($flag=='CS')
                                                <td>{{$claim->claimnumberformat}}</td>
                                                <td>{{ $claim->claim_id }}</td>
                                                <td>{{$claim->lot_id}}</td>
                                                @elseif($flag=='CG')
                                                <td>{{$claim->claimnumberformat}}</td>
                                                <td>{{ $claim->claim_id }}</td>
                                                @endif
                                                <td>{{ $claim->oem_name }}</td>
                                                <td>{{ $claim->model_name }}</td>
                                                <td>{{ $claim->variant_name }}</td>
                                                <td>{{ $claim->segment_name }}</td>
                                                <td>{{ $claim->vehicle_cat }}</td>
                                                <td>{{ $claim->vin_chassis_no }}</td>
                                                <td>{{ $claim->custmr_name }}</td>
                                                <td>{{ $claim->state }}</td>
                                                <td>{{ $claim->vhcl_regis_no }}</td>
                                                <td>{{ date('d-m-Y', strtotime($claim->vihcle_dt)) }}</td>
                                                <td>{{ $claim->dlr_invoice_no }}</td>
                                                <td>{{date('d-m-Y', strtotime( $claim->invoice_dt)) }}</td>
                                                <td>{{ $claim->invoice_amt }}</td>
                                                <td>{{ $claim->addmi_inc_amt }}</td>
                                                @if ($flag=='CS')
                                                <td>{{ date('d-m-Y', strtotime($claim->lot_date)) }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
