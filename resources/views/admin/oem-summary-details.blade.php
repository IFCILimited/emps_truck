@extends('layouts.dashboard_master')

@section('title')
    OEM EV Summary Details
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>{{ $details->first()->vehicle_type }} Details</h1>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">SN</th>
                                            <th>OEM Name</th>
                                            <th class="text-center">Vehicle Type</th>
                                            <th class="text-center">Vehicle Category</th>
                                            <th class="text-center">Total Production Count</th>
                                            <th class="text-center">Total Sold by Dealer</th>
                                            <th class="text-center">Total Approved by OEM</th>
                                            <th class="text-center">Total Claims Submitted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                             $sn = 1;
                                        @endphp
                                        @foreach ($details as $detail)
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $detail->oem_name }}</td>
                                                <td class="text-end">{{ $detail->vehicle_type }}</td>
                                                <td class="text-end">{{ $detail->vehicle_cat }}</td>
                                                <td class="text-end">{{ number_format($detail->production_count) }}</td>
                                                <td class="text-end">{{ number_format($detail->sold_by_dealer) }}</td>
                                                <td class="text-end">{{ number_format($detail->approved_by_oem) }}</td>
                                                <td class="text-end">{{ number_format($detail->claim_submitted) }}</td>
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
