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
                                    @if (isset($customerDetails) && count($customerDetails) > 0)
                                    @foreach($customerDetails as $customer)
                                        <tr>
                                            <td>{{ $customer->custmr_name }}</td>
                                            <td>{{ $customer->model_name }}</td>
                                            <td>{{ $customer->vin_chassis_no }}</td>
                                            <td>{{ $customer->variant_name ?? 'N/A' }}</td>
                                            <td>{{ $customer->segment_name }}</td>
                                            <td>{{ $customer->vehicle_cat }}</td>
                                            <td>{{ $customer->dealer_name }}</td>
                                            <td>
                                                @if($customer->custmr_typ == 1)
                                                    <a href={{route('dealer.view_certificate', encrypt($customer->buyer_id))}} class="btn btn-info">
                                                        View E-Voucher
                                                    </a>
                                                @else
                                                <a href={{route('dealer.multiBuyerVoucher', encrypt($customer->id))}} class="btn btn-primary">
                                                    View E-Voucher
                                                  </a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
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
    </script>
@endif
@endpush
