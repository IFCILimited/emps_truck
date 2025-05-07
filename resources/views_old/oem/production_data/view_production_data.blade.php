@extends('layouts.dashboard_master')
@section('title')
    OEM Production Data
@endsection

@push('styles')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-7">
                        <h4>Manage Production Data</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Model name</th>
                                            <th> Model Code </th>
                                            <th> Manufacturing Date </th>
                                            <th> VIN Chassis No </th>
                                            <th>colour</th>
                                            <th> Emission Norms </th>
                                            <th> Motor Number </th>
                                            <th> Battery Number </th>
                                            <th> Battery Number2 </th>
                                            <th> Battery Number3 </th>
                                            <th> Battery Number4 </th>
                                            <th> Battery Number5 </th>
                                            <th> Battery Number6 </th>
                                            <th> Battery Number7 </th>
                                            <th> Battery Number8 </th>
                                            <th> Battery Number9 </th>
                                            <th> Battery Number10 </th>
                                            <th> Battery Make </th>
                                            <th> Battery Capacity </th>
                                            <th> BatteryChemistry </th>
                                            <th> DVA Indicative </th>
                                            <th> PMP Compliance </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productionData as $key => $productionDatas)
                                            @php
                                                $manufacturingDate = strtotime($productionDatas->manufacturing_date);
                                                $formattedDate = date('d-m-Y', $manufacturingDate);
                                            @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $productionDatas->model_name }}</td>
                                                <td>{{ $productionDatas->model_code }}</td>
                                                <td>{{ $formattedDate }}</td>
                                                <td>{{ $productionDatas->vin_chassis_no }}</td>
                                                <td>{{ $productionDatas->colour }}</td>
                                                <td>{{ $productionDatas->emission_norms }}</td>
                                                <td>{{ $productionDatas->motor_number }}</td>
                                                <td>{{ $productionDatas->battery_number }}</td>
                                                <td>{{ $productionDatas->battery_number2 }}</td>
                                                <td>{{ $productionDatas->battery_number3 }}</td>
                                                <td>{{ $productionDatas->battery_number4 }}</td>
                                                <td>{{ $productionDatas->battery_number5 }}</td>
                                                <td>{{ $productionDatas->battery_number6 }}</td>
                                                <td>{{ $productionDatas->battery_number7 }}</td>
                                                <td>{{ $productionDatas->battery_number8 }}</td>
                                                <td>{{ $productionDatas->battery_number9 }}</td>
                                                <td>{{ $productionDatas->battery_number10 }}</td>
                                                <td>{{ $productionDatas->battery_make }}</td>
                                                <td>{{ $productionDatas->battery_capacity }}</td>
                                                <td>{{ $productionDatas->battery_chemistry }}</td>
                                                <td>{{ $productionDatas->dva_indicative }}</td>
                                                <td>{{ $productionDatas->pmp_compliance }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <a href="{{ route('manageProductionData.index') }}" class="btn btn-warning">Back</a>
            </div>
        </div>
    </div>
@endsection
