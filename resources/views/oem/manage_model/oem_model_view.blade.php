@extends('layouts.dashboard_master')
@section('title')
    Admin - OEM MOdel
@endsection

@push('styles')
    <style>
        .error-help-block {
            color: red;
        }
        .w-30{
            width: 30%;
        }
    </style>
@endpush
@section('content')
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-10">
                        <h4>View OEM Model</h4>
                    </div>
                    <div class="col-2 text-end">
                        <button class="mt-2 btn btn-warning btn-sm" onclick="window.print()">Print</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card height-equal">
                        <div class="card-header">
                            <h4>OEM & Vehicle Model Details</h4>
                            <p class="f-m-light mt-1">EV Model Information to be submitted by manufacturer for {{ env('APP_NAME')}} under
                                MHI and submitted to Test Agency for Compliance
                                Certification</code></p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="category_type">Category Type</label>
                                        <select class="form-select w-30 readonly" readonly aria-label="select example" id="category_type"
                                            name="category_type">
                                            <option value="">Select Category...</option>
                                            <option value="O"
                                                {{ $oemMOdelDetail->category_type == 'O' ? 'selected' : '' }}>Original
                                                Model</option>
                                            <option value="R"
                                                {{ $oemMOdelDetail->category_type == 'R' ? 'selected' : '' }}>Re-Validate
                                            </option>
                                            <option value="E"
                                                {{ $oemMOdelDetail->category_type == 'E' ? 'selected' : '' }}>Extended
                                            </option>
                                            <option value="V"
                                                {{ $oemMOdelDetail->category_type == 'V' ? 'selected' : '' }}>Revised
                                            </option>
                                        </select>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="model_type">Model Type</label>
                                        <input class="form-control readonly readonly" readonly
                                            value=" {{ $oemMOdelDetail->model_type == 'new' ? 'New Model' : 'Existing Model' }}"
                                            name="oem_name" id="oem_name" type="text">

                                    </div>

                                    @if ($oemMOdelDetail->compliance_upload_id != '' && $oemMOdelDetail->model_type == 'exist')
                                        <div class="col-md-8 mb-3" id="existing_vehicle">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label" for="vehicle_img">Model Compliance Certificate
                                                        Copy including testing report:</label><br>

                                                    <a class="btn btn-success btn-sm"
                                                        href="{{ route('doc.down', encrypt($oemMOdelDetail->compliance_upload_id)) }}">
                                                        <i class="fa fa-download"></i> View Certificate
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="testing_agency">Select Testing Agency</label>

                                        <input class="form-control readonly" readonly id="testing_agency" type="text"
                                            value="{{ $oemMOdelDetail->testing_agency_name }}" name="testing_agency">

                                    </div>
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="oem_name">OEM Name</label>
                                        <input class="form-control readonly readonly" readonly
                                            value="{{ $user->where('id', $oemMOdelDetail->oem_id)->first()->name }}"
                                            name="oem_name" id="oem_name" type="text">
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="ev_model_name">EV Model Name:</label>
                                        <input class="form-control readonly" readonly id="ev_model_name" type="text"
                                            value="{{ $oemMOdelDetail->model_name }}" name="ev_model_name">

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="variant_name">Variant Name</label>
                                        <input class="form-control readonly" readonly id="variant_name"
                                            value="{{ $oemMOdelDetail->variant_name }}" type="text" id="variant_name"
                                            name="variant_name">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="meeting_ev_tech">Meeting EV Technology
                                            Function:</label>
                                        <select class="form-select readonly" disabled aria-label="select example"
                                            id="meeting_ev_tech" name="meeting_ev_tech">
                                            <option value="">Select...</option>
                                            <option value="Y"
                                                {{ $oemMOdelDetail->meeting_tech_function == 'Y' ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="N"
                                                {{ $oemMOdelDetail->meeting_tech_function == 'N' ? 'selected' : '' }}>
                                                No</option>
                                        </select>

                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="meeting_qualify_tar">Meeting Qualification
                                            Targets:</label>
                                        <select class="form-select readonly" disabled aria-label="select example"
                                            id="meeting_qualify_tar" name="meeting_qualify_tar">
                                            <option value="">Select....</option>
                                            <option readonly value="Y"
                                                {{ $oemMOdelDetail->meeting_qualif == 'Y' ? 'selected' : '' }}>Yes
                                            </option>
                                            <option readonly value="N"
                                                {{ $oemMOdelDetail->meeting_qualif == 'N' ? 'selected' : '' }}>No
                                            </option>
                                        </select>

                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Date of Vehicle Submission to Test Agency for type
                                            approval:</label>
                                        <div class="col-md-6">
                                            <input class="form-control digits readonly" type="date"
                                                value="{{ $oemMOdelDetail->vehicle_sub_to_test_agency_apprv }}" disabled
                                                name="date_vehicle_submission" id="date_vehicle_submission">
                                        </div>
                                    </div>
                                @if ($oemMOdelDetail->date_certificate != null)
                                <div class="col-md-6">
                                    <label class="form-label">Certificate Effective Date:</label>
                                    <div class="col-md-6">
                                        <input class="form-control digits " type="date"
                                            value="{{ $oemMOdelDetail->date_certificate }}" disabled
                                            name="date_certificate" id="date_certificate">
                                    </div>
                                </div>
                                @endif

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-sm-12">
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>Model Performance Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="vehicle_segment">Vehicle Segment:</label>
                                        <select class="form-select readonly" disabled id="vehicle_segment"
                                            name="vehicle_segment">
                                            <option readonly>{{ $oemMOdelDetail->segment }}</option>

                                            <input type="hidden" id="vehicle_seg"
                                                value="{{ $oemMOdelDetail->segment }}">
                                        </select>

                                    </div>
                                    <div class="col-4 mb-3 ">
                                        <label class="form-label" for="vehicle_category">Vehicle Category
                                            (as per CMVR):</label>
                                        <select class="form-select readonly" disabled name="vehicle_category"
                                            id="vehicle_category">
                                            <option>{{$oemMOdelDetail->vehicle_cat}}</option>
                                            <input readonly type="hidden" id="vehicle_cat"
                                                value="{{ $oemMOdelDetail->vehicle_cat }}">

                                        </select>

                                    </div>
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="tech_type">Technology Type (xEV
                                            Type):</label>
                                        <select class="form-select readonly" disabled id="tech_type" id="tech_type"
                                            name="tech_type">
                                            <option value="">Choose...</option>
                                            <option readonly value="EV"
                                                {{ $oemMOdelDetail->tech_type == 'EV' ? 'selected' : '' }}>EV
                                            </option>

                                        </select>

                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Battery Type:</label>
                                        <select class="form-select readonly" disabled name="battery_type"
                                            id="battery_type">
                                            <option value="">Select....</option>
                                            <option value="chemistry"
                                                {{ $oemMOdelDetail->battery_type == 'chemistry' ? 'selected' : '' }}>
                                                Chemistry</option>
                                            <option value="other"
                                                {{ $oemMOdelDetail->battery_type == 'other' ? 'selected' : '' }}>Other
                                                Battery Parameters</option>
					     <option value="lft"
                                                    {{ $oemMOdelDetail->battery_type == 'lft' ? 'selected' : '' }}>LFT</option>
                                        </select>
                                    </div>

                                    {{-- <div class="col-md-4 mb-3">
                                        <label class="form-label">Battery Power (in KWH):</label>
                                        <input class="form-control readonly" id="battery_power" type="text"
                                            value="{{ $oemMOdelDetail->battery_power }}" name="battery_power">
                                    </div> --}}

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Maximum Ex-Factory Price (INR):</label>
                                        <input class="form-control readonly" readonly type="text"
                                            value="{{ $oemMOdelDetail->factory_price }}" id="ex_factory_price"
                                            name="ex_factory_price">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="vehicle_img">Vehicle Image</label><br>
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($oemMOdelDetail->vehicle_img_upload_id)) }}">
                                            <i class="fa fa-download"></i> View Image
                                        </a>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12">
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>Battery Details:</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="specific_density">Specific Density
                                            (Wh/Kg):</label>
                                        <input class="form-control readonly" readonly id="specific_density"
                                            type="text" value="{{ $oemMOdelDetail->spec_density }}"
                                            name="specific_density">
                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="life_cycle">Life cycle (No. of Cyles):</label>
                                        <input class="form-control readonly" readonly id="life_cycle" type="text"
                                            value="{{ $oemMOdelDetail->life_cyc }}" name="life_cycle">
                                    </div>

                                    <div class="col-4 mb-3 ">
                                        <label class="form-label" for="battery_cat_repulsion">No. of Batteries
                                            Required for Vehicle Propulsion:*</label>
                                        <input type="hidden" name="battery_data" id="battery_data"
                                            value="{{ $oemMOdelDetail->no_of_battery }}
                                                ">
                                        <select class="form-select readonly" disabled name="battery_cat_repulsion"
                                            id="battery_cat_repulsion">
                                            <option value="">Choose...</option>
                                            <option value="1"
                                                {{ $oemMOdelDetail->no_of_battery == '1' ? 'selected' : '' }}>1
                                            </option>
                                            <option value="2"
                                                {{ $oemMOdelDetail->no_of_battery == '2' ? 'selected' : '' }}>2
                                            </option>
                                            <option value="3"
                                                {{ $oemMOdelDetail->no_of_battery == '3' ? 'selected' : '' }}>3
                                            </option>
                                            <option value="4"
                                                {{ $oemMOdelDetail->no_of_battery == '4' ? 'selected' : '' }}>4
                                            </option>
                                            <option value="5"
                                                {{ $oemMOdelDetail->no_of_battery == '5' ? 'selected' : '' }}>5
                                            </option>
                                            <option value="6"
                                                {{ $oemMOdelDetail->no_of_battery == '6' ? 'selected' : '' }}>6
                                            </option>
                                            <option value="7"
                                                {{ $oemMOdelDetail->no_of_battery == '7' ? 'selected' : '' }}>7
                                            </option>
                                            <option value="8"
                                                {{ $oemMOdelDetail->no_of_battery == '8' ? 'selected' : '' }}>8
                                            </option>
                                            <option value="9"
                                                {{ $oemMOdelDetail->no_of_battery == '9' ? 'selected' : '' }}>9
                                            </option>
                                            <option value="10"
                                                {{ $oemMOdelDetail->no_of_battery == '10' ? 'selected' : '' }}>10
                                            </option>
                                        </select>
                                    </div>

                                    @for ($i = 1; $i <= $oemMOdelDetail->no_of_battery; $i++)
                                        <div class="col-md-4 mb-3 dynamic-field">
                                            <label class="form-label">{{ $i }}.) Battery xEV Capacity (in
                                                kWh):</label>
                                            <input class="form-control readonly" readonly type="text"
                                                value="{{ $oemMOdelDetail->{'bat_' . $i} }}"
                                                name="bat_{{ $i }}">
                                        </div>
                                    @endfor


                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Total Energy xEV Capacity (kWh):</label>
                                        <input class="form-control readonly" readonly id="total_energy_capacity"
                                            type="text" value="{{ $oemMOdelDetail->tot_energy }}"
                                            name="total_energy_capacity">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Battery Make:</label>
                                        <input class="form-control readonly" readonly type="text"
                                            value="{{ $oemMOdelDetail->battery_make }}" id="battery_make"
                                            name="battery_make">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Battery Capacity:</label>
                                        <input class="form-control readonly" readonly type="text"
                                            value="{{ $oemMOdelDetail->battery_capacity }}" id="battery_capacity"
                                            name="battery_capacity">
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12">
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>Vehicle Eligibility Criteria</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="range">Range (Km):</label>
                                        <input class="form-control readonly" readonly id="range" type="text"
                                            value="{{ $oemMOdelDetail->range }}" name="range">

                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">Maximun
                                            Electric Energy Consumption (kWh/100 Km):</label>
                                        <input class="form-control readonly" readonly id="max_electric_energy_consumption"
                                            type="text" value="{{ $oemMOdelDetail->max_elect_consumption }}"
                                            name="max_electric_energy_consumption">

                                    </div>

                                    <div class="col-4 mb-3 ">
                                        <label class="form-label" for="minimax_speed">MinimumMax Speed
                                            (Km/Hr):</label>
                                        <input class="form-control readonly" readonly id="minimax_speed" type="text"
                                            value="{{ $oemMOdelDetail->min_max_speed }}" name="minimax_speed">
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Minimum Acceleration (m/s2):</label>
                                        <input class="form-control readonly" readonly id="minimum_acceleration"
                                            type="text" value="{{ $oemMOdelDetail->min_acceleration }}"
                                            name="minimum_acceleration">
                                    </div>

                                    <div class="col-4 mb-3 ">
                                        <label class="form-label" for="monitor_device_fitment">Monitoring Device
                                            Fitment (Make & ID):</label>
                                        <select class="form-select readonly" disabled name="monitor_device_fitment"
                                            id="monitor_device_fitment">
                                            <option value="">Select....</option>
                                            <option value="Y"
                                                {{ $oemMOdelDetail->monitoring_device_fitment == 'Y' ? 'selected' : '' }}>
                                                Yes</option>
                                            <option value="N"
                                                {{ $oemMOdelDetail->monitoring_device_fitment == 'N' ? 'selected' : '' }}>
                                                No</option>
                                        </select>
                                    </div>

                                    @if ($oemMOdelDetail->monitoring_device_fitment == 'Y')
                                        <div class="col-md-4 mb-3" id="companyNameField">
                                            <label class="form-label">Company Name:</label>
                                            <input class="form-control readonly" readonly type="text"
                                                value="{{ $oemMOdelDetail->company_name }}" id="company_name"
                                                name="company_name">
                                        </div>

                                        <div class="col-md-4 mb-3" id="deviceIdField">
                                            <label class="form-label">Device ID:*</label>
                                            <input class="form-control readonly" readonly type="text"
                                                value="{{ $oemMOdelDetail->device_id }}" id="device_id"
                                                name="device_id">
                                        </div>
                                    @endif


                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Minimum Ex-Showroom Price (INR) across the
                                            Country:</label>
                                        <input class="form-control readonly" readonly type="text"
                                            value="{{ $oemMOdelDetail->min_ex_show_price }}" id="min_exshowrromprice"
                                            name="min_exshowrromprice">
                                        Minimum Ex-showroom price must be greater than or equal to Ex-Factory price

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Warranty Period Indicates*</label>
                                        <select disabled name="warranty_period_indicate" class="form-control">
                                            <option selected>{{$oemMOdelDetail->warranty_period_indicate}}</option>
                                            {{-- @php
                                            for($i = 1; $i <= 10; $i++) {


                                                echo '<option value="'.$i.'" '.($oemMOdelDetail->warranty_period_indicate == $i ? 'selected' : '').'>'.$i.'</option>';
                                            }
                                            @endphp --}}

                                        </select>
                                    </div>
                                    {{-- <div class="col-md-4 mb-3">
                                        <label class="form-label">Warranty Period From*</label>
                                        <input class="form-control" type="date" value="{{ $oemMOdelDetail->warranty_period_from }}" name="warranty_period_from">

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Warranty Period To*</label>
                                        <input class="form-control" type="date" value="{{ $oemMOdelDetail->warranty_period_to }}" name="warranty_period_to">

                                    </div> --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Estimated Incentive Amount (INR):*</label>
                                        <input class="form-control readonly" readonly type="text"
                                            value="{{ $oemMOdelDetail->estimate_incentive_amount }}"
                                            id="estimat_incentive_amt" name="estimat_incentive_amt">
                                        Subject to NAB approval

                                    </div>
                                    <div class="col-md-4 mb-3" id="existing_vehicle">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="form-label" for="vehicle_img">Certificate Copy:</label><br>

                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($oemMOdelDetail->testing_doc_id)) }}">
                                                    <i class="fa fa-download"></i> View Certificate
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-4 mb-3" id="existing_vehicle">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label" for="vehicle_img">PM E-Drive Certificate Copy:</label><br>

                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($oemMOdelDetail->testing_cmvr_doc_id)) }}">
                                                <i class="fa fa-download"></i> View Certificate
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @if($oemMOdelDetail->assessment_report_id != null)
                                <div class="col-md-4 mb-3" id="existing_vehicle">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label" for="vehicle_img">Assessment Report:</label><br>

                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($oemMOdelDetail->assessment_report_id)) }}">
                                                <i class="fa fa-download"></i> View Certificate
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                </div>
                            </div>
                        </div>
                        <div class="row pb-3">
                            <div class="col-md-2 offset-md-0">
                                <a href="{{ route('oemModel.index') }}" class="btn btn-warning form-control-sm mt-2">
                                    Back
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\OemModelRequest_edit', '#model_edit') !!}

    <script>
        $(document).ready(function() {

            // const parentSelect = document.getElementById('vehicle_segment');
            // const childSelect = document.getElementById('vehicle_category');

            // // Populate the parent select with options
            // const parentOptions = ['e-2W', 'e-3W', 'e-4W'];
            // parentOptions.forEach(option => {
            //     const opt = document.createElement('option');
            //     opt.value = option;
            //     opt.textContent = option;
            //     parentSelect.appendChild(opt);
            // });

            // parentSelect.value = document.getElementById('vehicle_seg').value;
            // childSelect.value = document.getElementById('vehicle_cat').value;


            // // Add event listener to the parent select
            // parentSelect.addEventListener('change', () => {
            //     const selectedParentOption = parentSelect.value;

            //     // Clear the child select
            //     childSelect.innerHTML = '';

            //     // Populate the child select based on the selected parent option
            //     if (selectedParentOption === 'e-2W') {
            //         const childOptions = ['L1', 'L2'];
            //         childOptions.forEach(option => {
            //             const opt = document.createElement('option');
            //             opt.value = option;
            //             opt.textContent = option;
            //             childSelect.appendChild(opt);
            //         });
            //     } else if (selectedParentOption === 'e-3W') {
            //         const childOptions = ['e-rickshaw', 'L5'];
            //         childOptions.forEach(option => {
            //             const opt = document.createElement('option');
            //             opt.value = option;
            //             opt.textContent = option;
            //             childSelect.appendChild(opt);
            //         });
            //     } else if (selectedParentOption === 'e-4W') {
            //         const childOptions = ['M1', 'N1', 'M3'];
            //         childOptions.forEach(option => {
            //             const opt = document.createElement('option');
            //             opt.value = option;
            //             opt.textContent = option;
            //             childSelect.appendChild(opt);
            //         });
            //     }

            // });

            // const selectedParentOption = parentSelect.value;

            // // Clear the child select
            // childSelect.innerHTML = '';

            // // Populate the child select based on the selected parent option
            // if (selectedParentOption === 'e-2W') {
            //     const childOptions = ['L1', 'L2'];
            //     childOptions.forEach(option => {
            //         const opt = document.createElement('option');
            //         opt.value = option;
            //         opt.textContent = option;
            //         if (option === document.getElementById('vehicle_cat').value) {
            //             opt.selected = true; // Auto-select 'N1'
            //         }
            //         childSelect.appendChild(opt);
            //     });
            // } else if (selectedParentOption === 'e-3W') {
            //     const childOptions = ['e-rickshaw', 'L5'];
            //     childOptions.forEach(option => {
            //         const opt = document.createElement('option');
            //         opt.value = option;
            //         opt.textContent = option;
            //         if (option === document.getElementById('vehicle_cat').value) {
            //             opt.selected = true; // Auto-select 'N1'
            //         }
            //         childSelect.appendChild(opt);
            //     });
            // } else if (selectedParentOption === 'e-4W') {
            //     const childOptions = ['M1', 'N1', 'M3'];
            //     childOptions.forEach(option => {
            //         const opt = document.createElement('option');
            //         opt.value = option;
            //         opt.textContent = option;
            //         if (option === document.getElementById('vehicle_cat').value) {
            //             opt.selected = true; // Auto-select 'N1'
            //         }
            //         childSelect.appendChild(opt);
            //     });
            // }

            // const selectElement = document.getElementById('model_type');

            // // Get the field to hide/show
            // const vehicleField = document.getElementById('existing_vehicle');
            // const requiredField = document.getElementById('model_compli_certificate-error');

            // // Add event listener to the select element
            // selectElement.addEventListener('change', function() {
            //     // Check the value of the select element and show/hide the field accordingly
            //     if (selectElement.value === 'exist') {
            //         vehicleField.style.display = 'block'; // Show the field
            //     } else {
            //         vehicleField.style.display = 'none'; // Hide the field
            //         requiredField.style.display = 'none';
            //     }
            // });


            $('#battery_cat_repulsion').change(function() {
                // Get the selected number
                var num = $(this).val();
                var jsonData = $('#battery_data').val();
                var data = JSON.parse(jsonData);
                // Identify the last element to insert fields after
                var lastElement = $(this).closest('div.mb-3');

                // Remove previously added fields
                lastElement.siblings('.dynamic-field').remove();

                // Dynamically generate and append the specified number of input fields
                for (var i = 1; i <= Object.keys(data).length; i++) {
                    var value = data[i.toString()] ||
                        ''; // Fallback to an empty string if key does not exist
                    var inputField = $('<div class="col-md-4 mb-3 dynamic-field">' +
                        '<label class="form-label"> ' + i + ') Battery xEV Capacity (in kWh):</label>' +
                        '<input class="form-control readonly" readonly type="text" value="' + value +
                        '" name="field[' +
                        i +
                        ']["battery"]">' +
                        '</div>');
                    inputField.insertAfter(lastElement);

                    // Update lastElement so next field is inserted after the new one
                    lastElement = inputField;
                }
            });

            setTimeout(function() {
                $('#battery_cat_repulsion').change();
            }, 1000);

        });
    </script>
@endpush
