<!-- resources/views/oem/vin_chassis_search.blade.php -->
@extends('layouts.dashboard_master')

@section('title')
    OEM Production Data
@endsection

@section('content')
    <div class="page-body">
        <div class="container">
            <form action="{{ route('VinChassis.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="text-center mt-2">
                        <h2 class="text-center">Search VIN/Chassis Details</h2>
                    </div>
                    <div class="row col-12 offset-2 p-2">
                        <div class="col-6">
                            <input type="text" class="form-control" id="vin_chassis_no" name="vin_chassis_no"
                                value="{{ old('vin_chassis_no') }}" required>
                        </div>
                        <div class="col-6">
                            <button type="submit" class="btn btn-sm btn-primary">Search</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 mb-3 d-flex" style="justify-content: space-between;">
                            <h4>Customer's & Dealer's Details</h4>
                            <a href="{{route('downloadBuyerStages')}}" class="btn btn-primary btn-sm"> <i class="fa fa-download"></i> Buyer's stages</a>
                        </div>
                        <div class="dt-ext table-responsive custom-scrollbar mt-5">
                            <table class="display table-bordered table-striped" id="export-button">
                                <thead>
                                    <tr>
                                        <th>VIN/Chassis No.</th>
                                        <th>Model Name</th>
                                        <th>Variant Name</th>
                                        <th>Segment Name</th>
                                        <th>Vehicle Category</th>
                                        <th>Status</th>
                                        <th>Dealer Code</th>
                                        <th>Dealer Name</th>
                                        <th>Dealer Mobile No.</th>
                                        <th>Dealer Email</th>
                                        <th>Customer Name</th>
                                        <th>Buyer Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($customerDetails) && $customerDetails)
                                        <tr>
                                            <td>{{ $customerDetails->vin_chassis_no }}</td>
                                            <td>{{ $customerDetails->model_name }}</td>
                                            <td>{{ $customerDetails->variant_name ?? 'N/A' }}</td>
                                            <td>{{ $customerDetails->segment_name }}</td>
                                            <td>{{ $customerDetails->vehicle_cat }}</td>
                                            <td>{{ $customerDetails->status == 'D' ? 'Draft' : ($customerDetails->status == 'S' ? 'Submit' : 'Pending') }}
                                            </td>
                                            <td>{{ $customerDetails->dealer_code }}</td>
                                            <td>{{ $customerDetails->dealer_name }}</td>
                                            <td>{{ $customerDetails->dealer_mobile }}</td>
                                            <td>{{ $customerDetails->dealer_email }}</td>
                                            <td>{{ $customerDetails->custmr_name }}</td>
                                            <td>
                                                @if ($customerDetails->status == 'A' && $customerDetails->oem_status == 'A')
                                                <a href="{{ route('ackdoc.finalview', $customerDetails->id) }}" class="btn btn-primary">
                                                    View
                                                </a>
                                                @elseif($customerDetails->status == 'A' && $customerDetails->oem_status == Null)
                                                <a href="{{ route('manageBuyerDetails.create', $customerDetails->id) }}" class="btn btn-primary">
                                                    Create
                                                </a>
                                                @elseif($customerDetails->status == 'D' || $customerDetails->status == 'S'  && $customerDetails->oem_status == Null)
                                                <a href="#" disabaled class="btn btn-primary">
                                                    Pending
                                                </a>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="12" class="text-center">No data available in table</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
