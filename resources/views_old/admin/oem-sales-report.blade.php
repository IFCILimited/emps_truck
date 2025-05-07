@extends('layouts.dashboard_master')

@section('title')
    OEM EV Sales Details
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1>Actual Sales Details</h1>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th class="text-center">SN</th>
                                            <th class="text-center">OEM Name</th>
                                            <th class="text-center">April-2024</th>
                                            <th class="text-center">May-2024</th>
                                            <th class="text-center">June-2024</th>
                                            <th class="text-center">July-2024</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalApr = 0;
                                            $totalMay = 0;
                                            $totalJun = 0;
                                            $totalJul = 0;
                                            $sn = 1;
                                        @endphp
                                        @foreach ($details as $detail)
                                            @php
                                                $totalApr += $detail->Apr;
                                                $totalMay += $detail->May;
                                                $totalJun += $detail->Jun;
                                                $totalJul += $detail->Jul;
                                            @endphp
                                            <tr>
                                                <td>{{ $sn++ }}</td>
                                                <td>{{ $detail->oem_name }}</td>
                                                <td class="text-end">{{ number_format($detail->Apr) }}</td>
                                                <td class="text-end">{{ number_format($detail->May) }}</td>
                                                <td class="text-end">{{ number_format($detail->Jun) }}</td>
                                                <td class="text-end">{{ number_format($detail->Jul) }}</td>
                                                <td class="text-end">{{ number_format($detail->Apr + $detail->May + $detail->Jun + $detail->Jul) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th class="text-end">{{ number_format($totalApr) }}</th>
                                            <th class="text-end">{{ number_format($totalMay) }}</th>
                                            <th class="text-end">{{ number_format($totalJun) }}</th>
                                            <th class="text-end">{{ number_format($totalJul) }}</th>
                                            <th class="text-end">{{ number_format($totalApr + $totalMay + $totalJun + $totalJul) }}</th>
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
