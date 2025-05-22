@extends('layouts.e_truck_dashboard_master')
@section('title')
    Admin - OEM MOdel
@endsection
@push('styles')
    <style>
        .error-help-block {
            color: red;
        }

        .w-30 {
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
                    <div class="col-6">
                        <h4 class="mb-2">OEM Model</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <form action="{{ route('e-trucks.oemModel.revalidatestore') }}" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' id="model_create"
                accept-charset="utf-8">
                @csrf
                {{-- {{dd($oemMOdelDetail->model_id)}} --}}
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>OEM & Vehicle Model Details</h4>
                                <p class="f-m-light mt-1">EV Model Information to be submitted by manufacturer for
                                    {{ env('APP_NAME') }} under MHI and submitted to Test Agency for Compliance
                                    Certification</code></p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="category_type">Category Type</label>
                                            <select class="form-select w-30" aria-label="select example" id="category_type"
                                                name="category_type">
                                                <option value="">Select Category...</option>
                                                <option value="O"
                                                    {{ $oemMOdelDetail->category_type == 'O' ? 'selected' : '' }}>Original
                                                    Model</option>
                                                <option value="R"
                                                    {{ $oemMOdelDetail->category_type == 'R' ? 'selected' : '' }}>
                                                    Re-Validate
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
                                            <input type="hidden" value="{{ $oemMOdelDetail->model_type }}"
                                                name="model_type" id="model_type">
                                            <input type="hidden" value="{{ $oemMOdelDetail->model_id }}" name="model_id"
                                                id="model_id">

                                        </div>

                                        @if ($oemMOdelDetail->compliance_upload_id != '' && $oemMOdelDetail->model_type == 'exist')
                                            <div class="col-md-8 mb-3" id="existing_vehicle">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="form-label" for="vehicle_img">Model Compliance
                                                            Certificate
                                                            Copy including testing report:</label><br>

                                                        <a class="btn btn-success btn-sm"
                                                            href="{{ route('doc.down', encrypt($oemMOdelDetail->compliance_upload_id)) }}">
                                                            <i class="fa fa-download"></i> View Certificate
                                                        </a>
                                                        <input type="hidden" name="compliance_upload_id"
                                                            value="{{ $oemMOdelDetail->compliance_upload_id }}"
                                                            id="">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif


                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="testing_agency">Select Testing Agency</label>

                                            <input class="form-control readonly" readonly id="testing_agency" type="text"
                                                value="{{ $oemMOdelDetail->testing_agency_name }}" name="testing_agency">
                                            <input type="hidden" value="{{ $oemMOdelDetail->testing_agency_id }}"
                                                name="testing_agency">

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
                                                value="{{ $oemMOdelDetail->variant_name }}" type="text"
                                                id="variant_name" name="variant_name">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="meeting_ev_tech">Meeting EV Technology
                                                Function:</label>
                                            <select class="form-select readonly" disabled aria-label="select example"
                                                id="meeting_ev_tech" name="">
                                                <option value="">Select...</option>
                                                <option value="Y"
                                                    {{ $oemMOdelDetail->meeting_tech_function == 'Y' ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="N"
                                                    {{ $oemMOdelDetail->meeting_tech_function == 'N' ? 'selected' : '' }}>
                                                    No</option>
                                            </select>
                                            <input type="hidden" name="meeting_ev_tech"
                                                value="{{ $oemMOdelDetail->meeting_tech_function }}">

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
                                            <input type="hidden" name="meeting_qualify_tar"
                                                value="{{ $oemMOdelDetail->meeting_qualif }}">


                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="meeting_qualify_tar">Gross Vehicle Weight (GVW in Tons):</label>
                                            <input type="number" class="form-control" name="gross_weight" id="">

                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Date of Vehicle Submission to Test Agency for type
                                                approval:</label>
                                            <div class="col-md-6">
                                                <input class="form-control digits " type="date"
                                                    value="{{ $oemMOdelDetail->vehicle_sub_to_test_agency_apprv }}"
                                                    name="date_vehicle_submission" id="date_vehicle_submission">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Certificate Effective Date:</label>
                                            <div class="col-md-6">
                                                <input class="form-control digits " type="date" value=" "
                                                    name="date_certificate" id="date_certificate">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="card height-equal">
                                <div class="card-header">
                                    <h4>Model Performance Details</h4>
                                    {{-- <p class="f-m-light mt-1">EV Model Information to be submitted by manufacturer for {{ env('APP_NAME')}}-2024 under MHI and submitted to Test Agency for Compliance
                                    Certification</code></p> --}}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">Vehicle Segment:</label>
                                            <select class="form-select readonly" disabled id="vehicle_segment"
                                                name="">
                                                <option readonly>{{ $oemMOdelDetail->segment }}</option>

                                                <input type="hidden" name="vehicle_segment"
                                                    value="{{ $oemMOdelDetail->segment_id }}">
                                            </select>

                                        </div>
                                        <div class="col-4 mb-3 ">
                                            <label class="form-label" for="vehicle_category">Vehicle Category
                                                (as per CMVR):</label>
                                            <select class="form-select readonly" disabled name=""
                                                id="vehicle_category">
                                                <option value="{{ $oemMOdelDetail->vehicle_cat_id }}">
                                                    {{ $oemMOdelDetail->vehicle_cat }}</option>
                                                <input readonly type="hidden" name="vehicle_category"
                                                    value="{{ $oemMOdelDetail->vehicle_cat_id }}">

                                            </select>

                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="tech_type">Technology Type (xEV
                                                Type):</label>
                                            <select class="form-select readonly" disabled id="tech_type" id="tech_type"
                                                name="">
                                                <option value="">Choose...</option>
                                                <option readonly value="EV"
                                                    {{ $oemMOdelDetail->tech_type == 'EV' ? 'selected' : '' }}>EV
                                                </option>

                                            </select>
                                            <input type="hidden" name="tech_type"
                                                value="{{ $oemMOdelDetail->tech_type }}">

                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Battery Type:</label>
                                            <select class="form-select" name="battery_type" id="battery_type">
                                                <option value="">Select....</option>
                                                <option value="chemistry">Chemistry</option>
                                                <option value="other">Other Battery Parameters</option>
                                                <option value="lft">LFT</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Maximum Ex-Factory Price (INR):</label>
                                            <input class="form-control" type="number" value=""
                                                id="ex_factory_price" name="ex_factory_price">
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
                                            <input class="form-control" id="specific_density" type="text"
                                                value="" name="specific_density">

                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="life_cycle">Life cycle (No. of Cyles):</label>
                                            <input class="form-control" id="life_cycle" type="text" value=""
                                                name="life_cycle">

                                        </div>
                                        <div class="col-4 mb-3 ">
                                            <label class="form-label" for="battery_cat_repulsion">No. of Batteries
                                                Required for Vehicle Propulsion:*</label>
                                            {{-- <select class="form-select" name="battery_cat_repulsion"
                                                id="battery_cat_repulsion">
                                                <option value="">Choose...</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select> --}}
                                            <input type="number" name="battery_cat_repulsion"  class="form-control" id="">
                                        </div>
                                        {{-- <div id="dynamicFields"></div> --}}

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Total Energy xEV Capacity (kWh):</label>
                                            <input class="form-control" id="total_energy_capacity" type="number"
                                                value="" name="total_energy_capacity">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Battery Make:</label>
                                            <input class="form-control" type="text" value="" id="battery_make"
                                                name="battery_make">
                                        </div>
                                        {{-- <div class="col-md-4 mb-3">
                                            <label class="form-label">Battery Capacity:</label>
                                            <input class="form-control" type="number" value=""
                                                id="battery_capacity" name="battery_capacity">
                                        </div> --}}
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
                                            <input class="form-control" id="range" type="number" value=""
                                                name="range">

                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="max_electric_energy_consumption">Maximun
                                                Electric Energy Consumption (kWh/100 Km):</label>
                                            <input class="form-control" id="max_electric_energy_consumption"
                                                type="number" value="" name="max_electric_energy_consumption">

                                        </div>
                                        <div class="col-4 mb-3 ">
                                            <label class="form-label" for="minimax_speed">MinimumMax Speed
                                                (Km/Hr):</label>
                                            <input class="form-control" id="minimax_speed" type="text" value=""
                                                name="minimax_speed">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Minimum Acceleration (m/s2):</label>
                                            <input class="form-control" id="minimum_acceleration" type="text"
                                                value="" name="minimum_acceleration">
                                        </div>
                                        <div class="col-4 mb-3 ">
                                            <label class="form-label" for="monitor_device_fitment">Monitoring Device
                                                Fitment (Make & ID):</label>
                                            <select class="form-select" name="monitor_device_fitment"
                                                id="monitor_device_fitment">
                                                <option value="">Select....</option>
                                                <option value="Y">Yes</option>
                                                <option value="N">No</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3" id="companyNameField">
                                            <label class="form-label">Company Name:</label>
                                            <input class="form-control" type="text" value="" id="company_name"
                                                name="company_name">
                                        </div>

                                        <div class="col-md-4 mb-3" id="deviceIdField">
                                            <label class="form-label">Device ID:*</label>
                                            <input class="form-control" type="text" value="" id="device_id"
                                                name="device_id">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Minimum Ex-Showroom Price (INR) across the
                                                Country:</label>
                                            <input class="form-control" type="number" value=""
                                                id="min_exshowrromprice" name="min_exshowrromprice">
                                            Minimum Ex-showroom price must be greater than or equal to Ex-Factory price
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Warranty Period Indicates*</label>
                                            <select name="warranty_period_indicate" class="form-control">
                                                <option selected disabled>Select</option>
                                                @php
                                                    for ($i = 1; $i <= 10; $i++) {
                                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                        {{-- <div class="col-md-4 mb-3">
                                            <label class="form-label">Warranty Period To*</label>
                                            <input class="form-control" type="date" value="" name="warranty_period_to">

                                        </div> --}}
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Estimated Incentive Amount (INR):*</label>
                                            <input class="form-control readonly" type="number" value=""
                                                id="estimat_incentive_amt" name="estimat_incentive_amt" readonly>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row col-12">
                                <div class="col-md-4 text-left">
                                    <a href="{{ route('e-trucks.oemModel.index') }}" class="btn btn-warning">Back</a>
                                </div>
                                <div class="col-md-4 text-center">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                        Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\OemModelRequest', '#model_create') !!}

    <script>
        $(document).ready(function() {

            $('#vehicle_segment').on('change', function() {
                var selectedSegment_id = $(this).val();
                $.ajax({
                    url: '../oemModel/get_cat/' +
                        selectedSegment_id, // Change the URL to your backend script
                    method: 'GET',
                    data: {
                        id: selectedSegment_id
                    }, // Pass any data if needed
                    success: function(response) {
                        // Populate the vehicle category dropdown with the fetched data
                        $('#vehicle_category').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Handle error if needed
                    }
                });
            });



            // const selectElement = document.getElementById('model_type');
            // // alert(selectElement.value);
            // // Get the field to hide/show
            // const vehicleField = document.getElementById('existing_vehicle');
            // const requiredField = document.getElementById('model_compli_certificate-error');

            // Add event listener to the select element
            // vehicleField.style.display = 'none'; // Hide the field
            // requiredField.style.display = 'none';

            // selectElement.addEventListener('change', function() {
            //     // Check the value of the select element and show/hide the field accordingly
            //     if (selectElement.value === 'exist') {
            //         vehicleField.style.display = 'block'; // Show the field
            //         // requiredField.style.display = 'required';

            //     } else {
            //         vehicleField.style.display = 'none'; // Hide the field
            //         requiredField.style.display = 'none';
            //     }
            // });

            // Get the select element
            const monitorDeviceFitment = document.getElementById('monitor_device_fitment');
            // Get the fields to show/hide
            const companyNameField = document.getElementById('companyNameField');
            const deviceIdField = document.getElementById('deviceIdField');

            // Initially hide the fields
            companyNameField.style.display = 'none';
            deviceIdField.style.display = 'none';

            // Add an event listener to monitor changes in the select element
            monitorDeviceFitment.addEventListener('change', function() {
                if (monitorDeviceFitment.value === 'Y') {
                    // Show the fields if 'Yes' is selected
                    companyNameField.style.display = 'block';
                    deviceIdField.style.display = 'block';
                } else {
                    // Hide the fields if 'No' or any other option is selected
                    companyNameField.style.display = 'none';
                    deviceIdField.style.display = 'none';
                }
            });


            $('#battery_cat_repulsion').change(function() {
                // Get the selected number
                var num = $(this).val();

                // Identify the last element to insert fields after
                var lastElement = $(this).closest('div.mb-3');

                // Remove previously added fields
                lastElement.siblings('.dynamic-field').remove();

                // Dynamically generate and append the specified number of input fields
                for (var i = 1; i <= num; i++) {
                    var inputField = $('<div class="col-md-4 mb-3 dynamic-field">' +
                        '<label class="form-label">' + i + ') Battery xEV Capacity (in kWh):</label>' +
                        '<input class="form-control" type="number" value="" name="bat_' + i +
                        '">' +
                        '</div>');
                    inputField.insertAfter(lastElement);

                    // Update lastElement so next field is inserted after the new one
                    lastElement = inputField;
                }
            });


            $('#vehicle_category, #ex_factory_price, #total_energy_capacity ').change(function() {

                var cat_id = $('#vehicle_category').val();
                var ex_factory = $('#ex_factory_price').val();
                var tot_energy = $('#total_energy_capacity').val();
                var certificate_date = $('#date_certificate').val();

                if (cat_id != null && ex_factory != null && tot_energy != null) {
                    $.ajax({
                        url: '/oemModel/calculate_incentive_amt',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        data: {
                            cat_id: cat_id, // Assuming cat_id holds the desired value
                            ex_factory: ex_factory, // Assuming ex_factory holds the desired value
                            tot_energy: tot_energy, // Assuming tot_energy holds the desired value
                            certificate_date: certificate_date, // Assuming tot_energy holds the desired value
                        },
                        success: function(response) {
                            console.log(response);
                            var incentiveAmount = response.length > 0 ? response[0].result :
                                null;


                            $('#estimat_incentive_amt').val(incentiveAmount);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            // Handle error if needed
                        }
                    });
                }

            });

        });

        // $(document).ready(function() {
        //     $('#date_certificate').on('change', function() {
        //         var selectedDate = $(this).val();
        //         var validDate = new Date('2024-11-08');
        //         var enteredDate = new Date(selectedDate);
        //         if (enteredDate <= validDate) {
        //             alert('Please select a date after November 8, 2024.');
        //             $(this).val('');
        //         }
        //     });
        // });
    </script>
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
@endpush
