<!-- resources/views/oem/vin_chassis_search.blade.php -->
@extends('layouts.dashboard_master')

@section('title')
   E-voucher Print
@endsection

@section('content')
    <div class="page-body">
        <div class="container">
            <form action="{{ route('Evoucher.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="text-center mt-2">
                        <h2 class="text-center">Search Buyer ID Details</h2>
                    </div>
                    <div class="row col-12 offset-2 p-2">
                        <div class="col-6">
                            <input type="text" class="form-control" id="buyer_id" name="buyer_id"
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
                            <h4>Buyer Details</h4>
                        </div>
                        <div class="dt-ext table-responsive custom-scrollbar mt-5">
                            <table class="display table-bordered table-striped" id="export-button">
                                <thead>
                                    <tr>
                                        <th>Customer Name</th>
                                        <th>Model Name</th>
                                        <th>VIN/Chassis No.</th>
                                        <th>Variant Name</th>
                                        <th>Segment Name</th>
                                        <th>Vehicle Category</th>
                                        <th>Dealer Name</th>
                                        <th>E-Voucher</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($customerDetails) && $customerDetails)
                                        <tr>
                                            <td>{{ $customerDetails->custmr_name }}</td>
                                            <td>{{ $customerDetails->model_name }}</td>
                                            <td>{{ $customerDetails->vin_chassis_no }}</td>
                                            <td>{{ $customerDetails->variant_name ?? 'N/A' }}</td>
                                            <td>{{ $customerDetails->segment_name }}</td>
                                            <td>{{ $customerDetails->vehicle_cat }}</td>
                                            <td>{{ $customerDetails->dealer_name }}</td>
                                            <td>
                                                <a href={{route('dealer.view_certificate', encrypt($customerDetails->buyer_id))}} class="btn btn-primary">
                                                    View E-Voucher
                                                  </a>
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

@push('scripts')
   @if(session('alert'))
    <script>
        Swal.fire({
            title: 'Warning',
            text: "{{ session('alert') }}",
            icon: "{{ session('alert_type') }}",
            confirmButtonText: 'Close'
        });
    </script>
@endif
@endpush
