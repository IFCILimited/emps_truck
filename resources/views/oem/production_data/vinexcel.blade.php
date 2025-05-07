<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Admin - OEM MOdel
@endsection

@push('styles')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Claim Generation Validity</h4>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{ route('vinFiledownload') }}" class="btn btn-success"><i class="fa fa-cloud-download"></i> Download Format.</a>
                    </div>
                    {{-- <div class="col-3 d-flex justify-content-end">
                        <a href="{{ asset('files/ManageProductionData_sample.xlsx') }}" class="btn btn-success"><i
                                class="fa fa-cloud-download"></i> Sample Production Data.</a>
                    </div> --}}

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <form action="{{ route('upload.vinexcel') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                          

                                        </div>
                                        <div class="col-md-3 pb-2">
                                            <input type="file" name="upload" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn sm-btn btn-primary">Upload Excel</button>
                                        </div>
                                    </div>
                                    <table class="display table-bordered table-striped" id="export-button">
                                        <thead>
                                            <th class="text-center">S.No.</th>
                                            <th class="text-center">Vin Number</th>
                                            <th class="text-center">Customer Name </th>
                                            <th class="text-center">Invoice Number</th>
                                            <th class="text-center">Invoice date</th>
                                            <th class="text-center">Days from Invoice (Invoice Date - OEM Approval Date)
                                            </th>
                                            <th class="text-center">Days from Invoice (Invoice Date - Current Date)</th>
                                            <th class="text-center">Dealer Status</th>
                                            <th class="text-center">Buyer Submitted Date</th>
                                            <th class="text-center">OEM Status</th>
                                            <th class="text-center">OEM Submitted Date</th>

                                        </thead>
                                        <tbody>
                                            @if (!empty($vinData))
                                                @foreach ($matchedBuyers as $index => $vin)
                                                    {{-- {{ dd($vin) }} --}}
                                                    <tr>
                                                        <td class="text-center">{{ $index + 1 }}</td>
                                                        <td class="text-center">{{ $vin->vin_chassis_no }}</td>
                                                        <td class="text-center">{{ $vin->custmr_name }}</td>
                                                        <td class="text-center">{{ $vin->dlr_invoice_no }}</td>
                                                        <td class="text-center">
                                                            {{ \Carbon\Carbon::parse($vin->invoice_dt)->format('d-m-Y') }}
                                                        </td>

                                                        <td class="text-center">
                                                            @php
                                                                if (
                                                                    !empty($vin->invoice_dt) &&
                                                                    !empty($vin->oem_status_at)
                                                                ) {
                                                                    $invoiceDate = \Carbon\Carbon::parse(
                                                                        $vin->invoice_dt,
                                                                    );
                                                                    $oemStatusDate = \Carbon\Carbon::parse(
                                                                        $vin->oem_status_at,
                                                                    );
                                                                    echo $invoiceDate->diffInDays($oemStatusDate) .
                                                                        ' days';
                                                                } else {
                                                                    echo 'N/A';
                                                                }
                                                            @endphp
                                                        </td>
                                                        <td class="text-center"
                                                            style="color: {{ $vin->invoice_dt && \Carbon\Carbon::parse($vin->invoice_dt)->diffInDays(now()) > 120 ? 'red' : 'black' }}">
                                                            {{ $vin->invoice_dt ? \Carbon\Carbon::parse($vin->invoice_dt)->diffInDays(now()) . ' days' : 'N/A' }}
                                                        </td>

                                                        <td class="text-center">
                                                            @if ($vin->status == 'D')
                                                                Draft
                                                            @else
                                                                Submitted
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            {{ \Carbon\Carbon::parse($vin->buyer_submitted_at)->format('d-m-Y') }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($vin->oem_status == 'A')
                                                                Approved
                                                                @else
                                                                --
                                                            @endif
                                                           
                                                        </td>
                                                        <td class="text-center">
                                                            {{ \Carbon\Carbon::parse($vin->oem_status_at)->format('d-m-Y') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="2" class="text-center">No Data Found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                            </div>
                        </div>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.prevent-multiple-submit').on('submit', function() {
                $(this).find('button[type="submit"]').prop('disabled', true);
                var buttons = $(this).find('button[type="submit"]');
                setTimeout(function() {
                    buttons.prop('disabled', false);
                }, 20000); // 25 seconds in milliseconds
            });
        });
    </script>
@endsection
