@extends('layouts.dashboard_master')

@section('title')
    OEM Wise Sales Reports
@endsection
@push('styles')
<style>
 table th {
 
 white-space: nowrap;  /* Prevent text from breaking onto a new line */

}
</style>
@endpush
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>OEM Wise Sales Reports</h1>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <form method="get" action="{{route('e-trucks.oemWiseSales')}}">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="segment_filter" class="form-label">Select Segment</label>
                                        <select name="segment" id="segment_filter" class="form-control">
                                            <option selected disabled>Select Segment</option>
                                            <option value="all" {{request('segment') == 'all' ? 'selected' : ''}}>All Segment</option>
                                            @foreach ($segments as $segment)
                                                <option value="{{ $segment->segment_name }}" 
                                                        {{ request('segment') == $segment->segment_name ? 'selected' : '' }}>
                                                    {{ $segment->segment_name }}
                                                </option>
                                            @endforeach
                                        </select>                                        
                                    </div>
                                    <div class="col-md-2">
                                        <label for="segment_filter" class="form-label">Select Month</label>
                                        <select name="month" id="segment_filter" class="form-control">
                                            <option selected disabled>Select Month</option>
                                            <option value="all" {{request('month') == 'all' ? 'selected' : ''}}>All Month</option>
                                            @foreach ($dateArray as $dateKey => $dateValue)
                                                <option value="{{ $dateKey }}" 
                                                        {{ request('month') == $dateKey ? 'selected' : '' }}
                                                        >
                                                    {{ $dateValue }}
                                                </option>
                                            @endforeach
                                        </select>  
                                    </div>
                                    <div class="col-md-4">
                                        <label for="segment_filter" class="form-label">Select OEM</label>
                                        <select name="oem" id="segment_filter" class="form-control">
                                            <option selected disabled>Select OEM</option>
                                            <option value="all" {{ request('oem') == 'all' ? 'selected' : '' }}>All OEMs</option>
                                            @foreach ($oems as $oem)
                                                <option value="{{ $oem->oem_id }}" 
                                                        {{ request('oem') == $oem->oem_id ? 'selected' : '' }}
                                                        >
                                                    {{ $oem->oem_name }}
                                                </option>
                                            @endforeach
                                        </select>  
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                    <div class="col-md-2 mt-4">
                                        <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('e-trucks.Vahan-OEM-Sales-Report') }}';">
                                            Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <table class="display table-bordered table-striped" id="basic-13">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">SN</th>
                                            <th class="text-center">OEM Name</th>
                                            <th class="text-center">Segment Name</th>
                                            {{-- <th class="text-center">April-2024</th>
                                            <th class="text-center">May-2024</th>
                                            <th class="text-center">June-2024</th>
                                            <th class="text-center">July-2024</th>
                                            <th class="text-center">August-2024</th>
                                            <th class="text-center">September-2024</th> --}}
                                            <th class="text-center">Vehicle Category</th>
                                            <th class="text-center">Month</th>
                                            <th class="text-center">Financial Year</th>
                                            <th class="text-center">Sales</th>
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
                                           
                                            $totalSales = 0;
                                            $sn = 1;
                                        @endphp
                                        @foreach ($details as $detail)
                                        
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $detail->oem_name }}</td>
                                                <td>{{ $detail->segment_name }}</td>
                                                <td>{{ $detail->category_name }}</td>
                                                <td>{{ $detail->month_yr }}</td>
                                                <td>{{ $detail->financial_year }}</td>
                                                <td class="text-end">{{ number_format($detail->sales) }}</td>
                                               
                                            </tr>
                                            @php
                                        
                                            $totalSales += $detail->sales;
                                        @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="6">Total</th>
                                         
                                            <th class="text-end">{{ number_format($totalSales) }}</th>
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
