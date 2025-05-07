@extends('layouts.dashboard_master')

@section('title')
    OEM E-Voucher Reports
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="container">
                
                <div class="col-sm-12">
                    <div class="card p-20 mt-2">
                        <div class="card-header mb-2">
                            <div class=" mb-3">
                                <h4 class="text-center">OEM Wise Date (From Date - To Date) Wise sales report as per PM E-DRIVE</h4>
                            </div>
                        </div>
                    <form method="POST" action="{{ route('e-trucks.evoucherReportFilter') }}">
                        @csrf <!-- Include this for Laravel -->
                        <div class="row pb-2">
                            <div class="col-md-3">
                                <label for="oem-name"><b>OEM Name</b></label>
                                <select name="oemname" id="" class="form-control" required>
                                    <option value="" selected disabled>Select</option>
                                    <option value="A" >ALL</option>
                                    @foreach ($name as $val)
                                        <option value="{{ $val->id }}" {{ $oemname !== null ? $val->id == $oemname?'selected':'' : ''}}>{{ $val->name }}</option>                                        
                                    @endforeach
                                </select>
                                {{-- <input type="text" id="oem-name" name="oemname" required class="form-control" placeholder="Enter OEM Name"> --}}
                            </div>
                            <div class="col-md-2">
                                <label for="segment"><b>Segment</b></label>
                                <select name="seg" id="" class="form-control" required>
                                    <option value="" selected disabled>Select</option>
                                    <option value="A">All</option>
                                    @foreach ($seg as $val)
                                        <option value="{{ $val->segment_name }}" {{$val->segment_name == $segmentName?'selected':''}}>{{ $val->segment_name }}</option>                                        
                                    @endforeach
                                </select>
                                {{-- <input type="text" id="segment" name="seg" class="form-control" required placeholder="Enter Segment"> --}}
                            </div>
                            <div class="col-md-2">
                                <label for="from-date"><b>From Date</b></label>
                                <input type="date" id="from-date" name="fromdate" value="{{$fromDate !== null ? $fromDate : ''}}" required class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="to-date"><b>To Date</b></label>
                                <input type="date" id="to-date" name="todate" value="{{$toDate !== null ? $toDate : ''}}" required class="form-control">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">Find</button>&nbsp;
                                <a href="{{route('e-trucks.evoucherReport')}}" class="btn btn-warning w-100">Reset</a>
                            </div>
                        </div>
                    </form>                    
                </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <table class="display table-bordered table-striped" id="basic-13">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">SN</th>
                                            <th class="text-center">OEM Name</th>
                                            <th class="text-center">Segment Name</th>
                                            <th class="text-center">Vehicle Category</th>
                                            <th class="text-center">Customer Id Generated</th>
                                            <th class="text-center">Face Id Successfully</th>
                                            <th class="text-center">E - Voucher Generated</th>
                                            <th class="text-center">E - Voucher Uploaded</th>
                                            <th class="text-center">Claims Uploaded</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            // $totalApr = 0;
                                            // $totalMay = 0;
                                            // $totalJun = 0;
                                            // $totalJul = 0;
                                            // $totalAug = 0;
                                            // $totalSep = 0;
                                            $totalInv = 0;
                                            $totalEup = 0;
                                            $totalEg = 0;
                                            $totalFs = 0;
                                            $totalCs = 0;
                                            $sn = 1;
                                        @endphp
                                        @foreach ($details as $detail)
                                        
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $detail->name }}</td>
                                                <td>{{ $detail->segment_name }}</td>
                                                <td>{{ $detail->vehicle_cat }}</td>
                                                <td class="text-end">{{ number_format($detail->invoice_count) }}</td>
                                                <td class="text-end">{{ number_format($detail->face_scanned) }}</td>
                                                <td class="text-end">{{ number_format($detail->evoucher_generated) }}</td>
                                                <td class="text-end">{{ number_format($detail->evoucher_uploaded) }}</td>
                                                <td class="text-end">{{ number_format($detail->claim_count) }}</td>
                                            </tr>
                                            @php
                                            $totalInv += $detail->invoice_count;
                                            $totalEup += $detail->evoucher_uploaded;
                                            $totalEg += $detail->evoucher_generated;
                                            $totalFs += $detail->face_scanned;
                                            $totalCs += $detail->claim_count;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total</th>
                                            <th class="text-end">{{ number_format($totalInv) }}</th>
                                            <th class="text-end">{{ number_format($totalFs) }}</th>
                                            <th class="text-end">{{ number_format($totalEg) }}</th>
                                            <th class="text-end">{{ number_format($totalEup) }}</th>
                                            <th class="text-end">{{ number_format($totalCs) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
