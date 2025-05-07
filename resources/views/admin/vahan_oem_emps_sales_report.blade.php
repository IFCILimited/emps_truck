@extends('layouts.dashboard_master')

@section('title')
    OEM EV Sales Details
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>OEM wise month wise sales as per Vahan (EMPS)</h1>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <form method="GET" action="{{ route('Vahan-OEM-Emps-Sales-Report') }}">
                                <div class="row align-items-center">
                                    <div class="row align-items-center">
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
                                                <option value="all" {{request('oem') == 'all' ? 'selected' : '' }}>All OEMs</option>
                                                @foreach ($oems as $oem)
                                                    <option value="{{ $oem->oem_id }}" 
                                                            {{ request('oem') == $oem->oem_id ? 'selected' : '' }}
                                                            >
                                                        {{ $oem->oem_name }} ({{$oem->oem_id}})
                                                    </option>
                                                @endforeach
                                            </select>  
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div>
                                        <div class="col-md-2 mt-4">
                                            <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('Vahan-OEM-Emps-Sales-Report') }}';">
                                                Reset
                                            </button>
                                        </div>
                                                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <table class="table table-bordered table-striped" id="basic-13">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">SN</th>
                                            <th class="text-center">OEM Name</th>
                                            <th class="text-center">Segment Name</th>
                                            <th class="text-center">Month</th>
                                            <th class="text-center">Sales</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                            $sn = 1;
                                        @endphp
                                        @foreach ($details as $detail)
                                            @php
                                                $total += $detail->sales;
                                            @endphp
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $detail->oem_name }}</td>
                                                <td>{{ $detail->segment_name }}</td>
                                                <td>{{ \Carbon\Carbon::createFromFormat('m-Y', $detail->month)->format('M-Y') }}</td>
                                                <td class="text-end">{{ number_format($detail->sales) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4">Total</th>
                                            <th class="text-end">{{ number_format($total) }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <span></span><br>
                                    <span>The details given are for digitized vehicle records as per centralized Vahan 4.</span><br>
                                    <span>Data for Telangana, and some RTO's of Lakshadweep has not been provided as they are not in centralized Vahan 4.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
