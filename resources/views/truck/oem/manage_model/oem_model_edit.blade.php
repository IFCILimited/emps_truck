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
                        <h4>Edit OEM Model</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <form action="{{ route('e-trucks.oemModel.update', encrypt($oemMOdelDetail->model_id)) }}" role="form"
                method="post" class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                id="model_edit" accept-charset="utf-8">
                @csrf
                @method('patch')
                <input type="hidden" name="id" value="{{ $oemMOdelDetail->model_detail_id }}">
                <input type="hidden" name="model_id" value="{{ $oemMOdelDetail->model_id }}">


                <div class="row">
                    <div class="col-sm-12">
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>OEM & Vehicle Model Details</h4>
                                <p class="f-m-light mt-1">EV Model Information to be submitted by manufacturer for
                                    {{ env('APP_NAME') }}
                                    under MHI and submitted to Test Agency for Compliance
                                    Certification</code></p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        @if ($detCount <= 1)
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label" for="category_type">Category Type</label>
                                                <select class="form-select w-30" aria-label="select example"
                                                    id="category_type" name="category_type">
                                                    <option value="">Select Category...</option>
                                                    <option value="O"
                                                        {{ $oemMOdelDetail->category_type == 'O' ? 'selected' : '' }}>
                                                        Original
                                                        Model</option>
                                                    <option value="R"
                                                        {{ $oemMOdelDetail->category_type == 'R' ? 'selected' : '' }}>
                                                        Re-Validate
                                                    </option>
                                                    <option value="E"
                                                        {{ $oemMOdelDetail->category_type == 'E' ? 'selected' : '' }}>
                                                        Extended
                                                    </option>
                                                    <option value="V"
                                                        {{ $oemMOdelDetail->category_type == 'V' ? 'selected' : '' }}>
                                                        Revised
                                                    </option>
                                                </select>

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="model_type">Model Type</label>
                                                <select class="form-select" aria-label="select example" id="model_type"
                                                    name="model_type">
                                                    <option value="">Select Model...</option>
                                                    <option value="exist"
                                                        {{ $oemMOdelDetail->model_type == 'exist' ? 'selected' : '' }}>
                                                        Existing
                                                        Model</option>
                                                    <option value="new"
                                                        {{ $oemMOdelDetail->model_type == 'new' ? 'selected' : '' }}>New
                                                        Model
                                                    </option>
                                                </select>

                                            </div>

                                            @if ($oemMOdelDetail->model_type == 'exist')
                                                <div class="col-md-8 mb-6" id="existing_vehicle">
                                                    <label class="form-label" for="model_compli_certificate">Model
                                                        Compliance
                                                        Certificate Copy including testing report:</label>
                                                    <div class="row">
                                                        <div class="col-md-8 mb-6">
                                                            <input class="form-control" id="model_compli_certificate"
                                                                name="model_compli_certificate" type="file"
                                                                aria-label="file example">
                                                            <input type="hidden" name="compliance_doc_id"
                                                                value="{{ $oemMOdelDetail->compliance_upload_id }}">
                                                        </div>
                                                        @if (isset($oemMOdelDetail->compliance_upload_id))
                                                            <div class="col-md-4 mb-6">
                                                                <a class="btn btn-success btn-sm"
                                                                    href="{{ route('doc.down', encrypt($oemMOdelDetail->compliance_upload_id)) }}">
                                                                    <i class="fa fa-download"></i> View Certificate
                                                                </a>
                                                            </div>
                                                        @endif

                                                    </div>

                                                    <span class="text text-warning">(pdf only and max. 2 MB size)
                                                    </span>
                                                </div>
                                            @else
                                                <div class="col-md-8 mb-6" id="existing_vehicle" style="display:none">
                                                    <label class="form-label" for="model_compli_certificate">Upload
                                                        {{ env('APP_NAME') }}
                                                        Model Compliance Certificate Copy including testing report:</label>
                                                    <div class="row">
                                                        <div class="col-md-8 mb-6">
                                                            <input class="form-control" id="model_compli_certificate"
                                                                name="model_compli_certificate" type="file"
                                                                aria-label="file example">
                                                            <input type="hidden" name="compliance_doc_id" value="">
                                                        </div>

                                                    </div>

                                                    <span class="text text-warning">(pdf only and max. 2 MB size)
                                                    </span>
                                                </div>
                                            @endif
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="testing_agency">Select Testing Agency</label>
                                                <select class="form-select" name="testing_agency" id="testing_agency">
                                                    <option value="">Choose...</option>
                                                    @foreach ($agency as $key => $age)
                                                        <option value="{{ $age->id }}"
                                                            @if ($oemMOdelDetail->testing_agency_id == $age->id) selected @endif>
                                                            {{ $age->name }}</option>
                                                    @endforeach
                                                </select>


                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="oem_name">OEM Name</label>
                                                <input class="form-control readonly" readonly value="{{ $user->name }}"
                                                    name="oem_name" id="oem_name" type="text">
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="ev_model_name">EV Model Name:</label>
                                                <input class="form-control" id="ev_model_name" type="text"
                                                    value="{{ $oemMOdelDetail->model_name }}" name="ev_model_name">

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="variant_name">Variant Name</label>
                                                <input class="form-control" id="variant_name"
                                                    value="{{ $oemMOdelDetail->variant_name }}" type="text"
                                                    id="variant_name" name="variant_name">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="meeting_ev_tech">Meeting EV Technology
                                                    Function:</label>
                                                <select class="form-select" aria-label="select example"
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
                                                <select class="form-select" aria-label="select example"
                                                    id="meeting_qualify_tar" name="meeting_qualify_tar">
                                                    <option value="">Select....</option>
                                                    <option value="Y"
                                                        {{ $oemMOdelDetail->meeting_qualif == 'Y' ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="N"
                                                        {{ $oemMOdelDetail->meeting_qualif == 'N' ? 'selected' : '' }}>No
                                                    </option>
                                                </select>

                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Date of Vehicle Submission to Test Agency for
                                                    type
                                                    approval:</label>
                                                <div class="col-md-6">
                                                    <input class="form-control digits" type="date"
                                                        value="{{ $oemMOdelDetail->vehicle_sub_to_test_agency_apprv }}"
                                                        name="date_vehicle_submission" id="date_vehicle_submission">
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="meeting_qualify_tar">Gross Vehicle
                                                    Weight(in Tons):</label>
                                                <input type="number" class="form-control"
                                                    value="{{ $oemMOdelDetail->gross_weight }}" name="gross_weight"
                                                    id="">
                                            </div>
                                        
                                        @else
                                            <div class="col-md-12 mb-3">
                                                <label class="form-label" for="category_type">Category Type</label>
                                                <select class="form-select w-30" aria-label="select example"
                                                    id="category_type" name="category_type">
                                                    <option value="">Select Category...</option>
                                                    <option value="O"
                                                        {{ $oemMOdelDetail->category_type == 'O' ? 'selected' : '' }}>
                                                        Original
                                                        Model</option>
                                                    <option value="R"
                                                        {{ $oemMOdelDetail->category_type == 'R' ? 'selected' : '' }}>
                                                        Re-Validate
                                                    </option>
                                                    <option value="E"
                                                        {{ $oemMOdelDetail->category_type == 'E' ? 'selected' : '' }}>
                                                        Extended
                                                    </option>
                                                    <option value="V"
                                                        {{ $oemMOdelDetail->category_type == 'V' ? 'selected' : '' }}>
                                                        Revised
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
                                                <input type="hidden" value="{{ $oemMOdelDetail->model_id }}"
                                                    name="model_id" id="model_id">

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
                                                <label class="form-label" for="testing_agency">Select Testing
                                                    Agency</label>

                                                <select disabled class="form-select" name="testing_agency"
                                                    id="testing_agency">
                                                    <option value="">Choose...</option>
                                                    @foreach ($agency as $key => $age)
                                                        <option value="{{ $age->id }}"
                                                            @if ($oemMOdelDetail->testing_agency_id == $age->id) selected @endif>
                                                            {{ $age->name }}</option>
                                                    @endforeach
                                                </select>
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
                                                <input class="form-control readonly" readonly id="ev_model_name"
                                                    type="text" value="{{ $oemMOdelDetail->model_name }}"
                                                    name="ev_model_name">

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
                                                <label class="form-label" for="meeting_qualify_tar">Gross Vehicle
                                                    Weight(in Tons):</label>
                                                <input type="number" class="form-control"
                                                    value="{{ $oemMOdelDetail->gross_weight }}" name="gross_weight"
                                                    id="">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Date of Vehicle Submission to Test Agency for
                                                    type
                                                    approval:</label>
                                                <div class="col-md-6">
                                                    <input class="form-control digits " type="date"
                                                        value="{{ $oemMOdelDetail->vehicle_sub_to_test_agency_apprv }}"
                                                        name="date_vehicle_submission" id="date_vehicle_submission">
                                                </div>
                                            </div>

                                        @endif
                                        @if ($oemMOdelDetail->date_certificate != null)
                                            <div class="col-md-6">
                                                <label class="form-label">Certificate Effective Date:</label>
                                                <div class="col-md-6">
                                                    <input class="form-control digits " type="date"
                                                        value="{{ $oemMOdelDetail->date_certificate }}"
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
                                        @if ($detCount <= 1)
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="vehicle_segment">Vehicle Segment:</label>
                                                <select class="form-select" id="vehicle_segment" name="vehicle_segment">
                                                    <option value="">Choose...</option>
                                                    @foreach ($segment as $key => $seg)
                                                        <option value="{{ $seg->id }}"
                                                            {{ $oemMOdelDetail->segment_id == $seg->id ? 'selected' : '' }}>
                                                            {{ $seg->segment_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-4 mb-3 ">
                                                <label class="form-label" for="vehicle_category">Vehicle Category (as per
                                                    CMVR):</label>
                                                <select class="form-select" name="vehicle_category" id="">
                                                    <option selected disabled value="">Choose...</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $oemMOdelDetail->vehicle_cat_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <input type="hidden" id="vehicle_seg"
                                                value="{{ $oemMOdelDetail->segment_id }}">
                                            <input type="hidden" id="vehicle_cat"
                                                value="{{ $oemMOdelDetail->vehicle_cat_id }}">

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="tech_type">Technology Type (xEV
                                                    Type):</label>
                                                <select class="form-select" id="tech_type" id="tech_type"
                                                    name="tech_type">
                                                    <option value="">Choose...</option>
                                                    <option value="EV"
                                                        {{ $oemMOdelDetail->tech_type == 'EV' ? 'selected' : '' }}>EV
                                                    </option>

                                                </select>

                                            </div>
                                        @else
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="vehicle_segment">Vehicle Segment:</label>
                                                <select disabled class="form-select" id="vehicle_segment"
                                                    name="vehicle_segment">
                                                    <option value="">Choose...</option>
                                                    @foreach ($segment as $key => $seg)
                                                        <option value="{{ $seg->id }}"
                                                            {{ $oemMOdelDetail->segment_id == $seg->id ? 'selected' : '' }}>
                                                            {{ $seg->segment_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="vehicle_segment"
                                                    value="{{ $oemMOdelDetail->segment_id }}">
                                            </div>

                                            <div class="col-4 mb-3 ">
                                                <label class="form-label" for="vehicle_category">Vehicle Category (as per
                                                    CMVR):</label>
                                                <select disabled class="form-select" name="vehicle_category"
                                                    id="vehicle_category">
                                                    <option selected disabled value="">Choose...</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ $oemMOdelDetail->vehicle_cat_id == $category->id ? 'selected' : '' }}>
                                                            {{ $category->category_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input readonly type="hidden" name="vehicle_category"
                                                    value="{{ $oemMOdelDetail->vehicle_cat_id }}">
                                            </div>

                                            <input type="hidden" id="vehicle_seg"
                                                value="{{ $oemMOdelDetail->segment_id }}">
                                            <input type="hidden" id="vehicle_cat"
                                                value="{{ $oemMOdelDetail->vehicle_cat_id }}">

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="tech_type">Technology Type (xEV
                                                    Type):</label>
                                                <select disabled class="form-select" id="tech_type" id="tech_type"
                                                    name="tech_type">
                                                    <option value="">Choose...</option>
                                                    <option value="EV"
                                                        {{ $oemMOdelDetail->tech_type == 'EV' ? 'selected' : '' }}>EV
                                                    </option>

                                                </select>
                                                <input type="hidden" name="tech_type"
                                                    value="{{ $oemMOdelDetail->tech_type }}">

                                            </div>
                                        @endif
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Battery Type:</label>
                                            <select class="form-select" name="battery_type" id="battery_type">
                                                <option value="">Select....</option>
                                                <option value="chemistry"
                                                    {{ $oemMOdelDetail->battery_type == 'chemistry' ? 'selected' : '' }}>
                                                    Chemistry</option>
                                                <option value="other"
                                                    {{ $oemMOdelDetail->battery_type == 'other' ? 'selected' : '' }}>Other
                                                    Battery Parameters</option>
                                                <option value="lft"
                                                    {{ $oemMOdelDetail->battery_type == 'lft' ? 'selected' : '' }}>LFT
                                                </option>
                                            </select>
                                        </div>

                                        {{-- <div class="col-md-4 mb-3">
                                            <label class="form-label">Battery Power (in KWH):</label>
                                            <input class="form-control" id="battery_power" type="text"
                                                value="{{ $oemMOdelDetail->battery_power }}" name="battery_power">
                                        </div> --}}

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Ex-Factory Price (INR):</label>
                                            <input class="form-control" type="number"
                                                value="{{ $oemMOdelDetail->factory_price }}" id="ex_factory_price"
                                                name="ex_factory_price">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="vehicle_img">Upload Vehicle Image</label>
                                            <input class="form-control" id="vehicle_img" name="vehicle_img"
                                                type="file" aria-label="file example">
                                            <span>Image format:.jpeg, jpg or png</span>
                                            <input type="hidden" name="vechicle_upload_id"
                                                value="{{ $oemMOdelDetail->vehicle_img_upload_id }}">
                                            <a class="mt-2 btn btn-success btn-sm"
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
                                                value="{{ $oemMOdelDetail->spec_density }}" name="specific_density">
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="life_cycle">Life cycle (No. of Cyles):</label>
                                            <input class="form-control" id="life_cycle" type="text"
                                                value="{{ $oemMOdelDetail->life_cyc }}" name="life_cycle">
                                        </div>

                                        <div class="col-4 mb-3 ">
                                            <label class="form-label" for="battery_cat_repulsion">No. of Batteries
                                                Required for Vehicle Propulsion:*</label>
                                            {{-- <input type="hidden" name="battery_data" id="battery_data"
                                                value="{{ $oemMOdelDetail->field }}
                                                "> --}}
                                            <select class="form-select" name="battery_cat_repulsion"
                                                id="battery_cat_repulsion">
                                                <option value="">Choose...</option>
                                                @for ($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}"
                                                        {{ $oemMOdelDetail->no_of_battery == $i ? 'selected' : '' }}>
                                                        {{ $i }}</option>
                                                @endfor
                                            </select>

                                        </div>

                                        <div id="dynamic-fields-container" class="row">
                                            <!-- Dynamic battery fields will be inserted here -->
                                            @for ($i = 1; $i <= $oemMOdelDetail->no_of_battery; $i++)
                                                <div class="col-md-4 mb-3 dynamic-field">
                                                    <label class="form-label">{{ $i }}.) Battery xEV Capacity
                                                        (in kWh):</label>
                                                    <input class="form-control" type="text"
                                                        value="{{ $oemMOdelDetail->{'bat_' . $i} }}"
                                                        name="bat_{{ $i }}">
                                                </div>
                                            @endfor
                                        </div>



                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Total Energy xEV Capacity (kWh):</label>
                                            <input class="form-control" id="total_energy_capacity" type="number"
                                                value="{{ $oemMOdelDetail->tot_energy }}" name="total_energy_capacity">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Battery Make:</label>
                                            <input class="form-control" type="text"
                                                value="{{ $oemMOdelDetail->battery_make }}" id="battery_make"
                                                name="battery_make">
                                        </div>

                                        {{--  <div class="col-md-4 mb-3">
                                            <label class="form-label">Battery Capacity:</label>
                                            <input class="form-control" type="number"
                                                value="{{ $oemMOdelDetail->battery_capacity }}" id="battery_capacity"
                                                name="battery_capacity"> --}}
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
                                        <input class="form-control" id="range" type="number"
                                            value="{{ $oemMOdelDetail->range }}" name="range">

                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">Maximun
                                            Electric Energy Consumption (kWh/100 Km):</label>
                                        <input class="form-control" id="max_electric_energy_consumption" type="number"
                                            value="{{ $oemMOdelDetail->max_elect_consumption }}"
                                            name="max_electric_energy_consumption">

                                    </div>

                                    <div class="col-4 mb-3 ">
                                        <label class="form-label" for="minimax_speed">MinimumMax Speed
                                            (Km/Hr):</label>
                                        <input class="form-control" id="minimax_speed" type="text"
                                            value="{{ $oemMOdelDetail->min_max_speed }}" name="minimax_speed">
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Minimum Acceleration (m/s2):</label>
                                        <input class="form-control" id="minimum_acceleration" type="text"
                                            value="{{ $oemMOdelDetail->min_acceleration }}" name="minimum_acceleration">
                                    </div>

                                    <div class="col-4 mb-3 ">
                                        <label class="form-label" for="monitor_device_fitment">Monitoring Device
                                            Fitment (Make & ID):</label>
                                        <select class="form-select" name="monitor_device_fitment"
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

                                    {{-- @if ($oemMOdelDetail->monitoring_device_fitment == 'Y') --}}
                                    <div class="col-md-4 mb-3" id="companyNameField">
                                        <label class="form-label">Company Name:</label>
                                        <input class="form-control" type="text"
                                            value="{{ $oemMOdelDetail->company_name }}" id="company_name"
                                            name="company_name">
                                    </div>

                                    <div class="col-md-4 mb-3" id="deviceIdField">
                                        <label class="form-label">Device ID:*</label>
                                        <input class="form-control" type="text"
                                            value="{{ $oemMOdelDetail->device_id }}" id="device_id" name="device_id">
                                    </div>
                                    {{-- @endif --}}


                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Minimum Ex-Showroom Price (INR) across the
                                            Country:</label>
                                        <input class="form-control" type="number"
                                            value="{{ $oemMOdelDetail->min_ex_show_price }}" id="min_exshowrromprice"
                                            name="min_exshowrromprice">
                                        Minimum Ex-showroom price must be greater than or equal to Ex-Factory price

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Warranty Period Indicates*</label>
                                        <select name="warranty_period_indicate" class="form-control">
                                            <option selected disabled>Select</option>
                                            @php
                                                for ($i = 1; $i <= 10; $i++) {
                                                    echo '<option value="' .
                                                        $i .
                                                        '" ' .
                                                        ($oemMOdelDetail->warranty_period_indicate == $i
                                                            ? 'selected'
                                                            : '') .
                                                        '>' .
                                                        $i .
                                                        '</option>';
                                                }
                                            @endphp

                                        </select>
                                    </div>
                                    {{-- <div class="col-md-4 mb-3">
                                            <label class="form-label">Warranty Period From*</label>
                                            <input class="form-control" type="date" value="{{$oemMOdelDetail->warranty_period_from}}" name="warranty_period_from">

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Warranty Period To*</label>
                                            <input class="form-control" type="date" value="{{$oemMOdelDetail->warranty_period_to}}" name="warranty_period_to">

                                        </div> --}}
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Estimated Incentive Amount (INR):*</label>
                                        <input class="form-control readonly" type="text"
                                            value="{{ $oemMOdelDetail->estimate_incentive_amount }}"
                                            id="estimat_incentive_amt" readonly name="estimat_incentive_amt">

                                    </div>
                                    <input type="hidden" name="status" value="U">
                                    {{-- <div class="row pb-3">
                                            <div class="col-md-2 offset-md-0">
                                                <a href="{{ route('oemModel.index') }}"
                                                    class="btn btn-warning form-control-sm mt-2"> Back
                                                </a>
                                            </div>
                                            <div class="col-md-2 offset-md-3">
                                                <button class="btn btn-success form-control-sm mt-2 btn-update"
                                                    type="submit">Update</button>
                                            </div>
                                            <div class="col-md-2 offset-md-3">
                                                <button class="btn btn-primary form-control-sm mt-2 btn-submit"
                                                    type="submit">Submit</button>
                                            </div>
                                        </div> --}}

                                </div>
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-md-4 text-left">
                                <a href="{{ route('e-trucks.oemModel.index') }}" class="btn btn-warning">Back</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                    Update</button>
                            </div>
                            <div class="col-md-4 text-center">
                                <button class="btn btn-primary form-control-sm mt-2 btn-submit"
                                    type="submit">Submit</button>
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
    {!! JsValidator::formRequest('App\Http\Requests\OemModelRequest_edit', '#model_edit') !!}

    <script>
        $(document).ready(function() {
            var selectedSegment_id = $('#vehicle_seg').val();
            $.ajax({
                url: '../get_cat/' + selectedSegment_id,
                method: 'GET',
                success: function(response) {
                    $('#vehicle_category').html(response);
                    var selectedCategory_id = $('#vehicle_cat').val();
                    $('#vehicle_category').val(selectedCategory_id); // Set the selected category
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Handle error if needed
                }
            });

            $('#vehicle_segment').on('change', function() {
                var selectedSegment_id = $(this).val();
                $.ajax({
                    url: '../get_cat/' + selectedSegment_id,
                    method: 'GET',
                    success: function(response) {
                        $('#vehicle_category').html(response);
                        // Reset the vehicle category dropdown to the default option
                        $('#vehicle_category').val('').prop('disabled', false);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Handle error if needed
                    }
                });
            });



            const selectElement = document.getElementById('model_type');

            // Get the field to hide/show
            const vehicleField = document.getElementById('existing_vehicle');
            const requiredField = document.getElementById('model_compli_certificate-error');

            // Add event listener to the select element
            selectElement.addEventListener('change', function() {
                // Check the value of the select element and show/hide the field accordingly
                if (selectElement.value === 'exist') {
                    vehicleField.style.display = 'block'; // Show the field
                } else {
                    vehicleField.style.display = 'none'; // Hide the field
                    requiredField.style.display = 'none';
                }
            });


            // Get the select element
            const monitorDeviceFitment = document.getElementById('monitor_device_fitment');
            // Get the fields to show/hide
            const companyNameField = document.getElementById('companyNameField');
            const deviceIdField = document.getElementById('deviceIdField');
            const company_name = document.getElementById('company_name');
            const device_id = document.getElementById('device_id');

            // Initially hide the fields
            companyNameField.style.display = 'none';
            deviceIdField.style.display = 'none';

            // Store the original values of company_name and device_id
            let oldCompanyName = company_name.value;
            let oldDeviceId = device_id.value;
            if (monitorDeviceFitment.value === 'Y') {
                // Show the fields if 'Yes' is selected
                companyNameField.style.display = 'block';
                deviceIdField.style.display = 'block';
                // Set the old values if 'Y' is selected
                company_name.value = oldCompanyName;
                device_id.value = oldDeviceId;
            } else {
                // Hide the fields if 'No' or any other option is selected
                companyNameField.style.display = 'none';
                deviceIdField.style.display = 'none';
                company_name.value = '';
                device_id.value = '';
            }



            // Add an event listener to monitor changes in the select element
            monitorDeviceFitment.addEventListener('change', function() {
                if (monitorDeviceFitment.value === 'Y') {
                    // Show the fields if 'Yes' is selected
                    companyNameField.style.display = 'block';
                    deviceIdField.style.display = 'block';
                    // Set the old values if 'Y' is selected
                    company_name.value = oldCompanyName;
                    device_id.value = oldDeviceId;
                } else {
                    // Hide the fields if 'No' or any other option is selected
                    companyNameField.style.display = 'none';
                    deviceIdField.style.display = 'none';
                    company_name.value = '';
                    device_id.value = '';
                }
            });


            $('#battery_cat_repulsion').change(function() {
                var numBatteries = parseInt($(this).val());
                var existingFieldsCount = $('.dynamic-field').length;

                // Remove excess fields
                $('.dynamic-field').slice(numBatteries).remove();

                // Add missing fields
                for (var i = existingFieldsCount + 1; i <= numBatteries; i++) {
                    var inputFieldHTML = '<div class="col-md-4 mb-3 dynamic-field">' +
                        '<label class="form-label">' + i + '.) Battery xEV Capacity (in kWh): </label>' +
                        '<input class="form-control" type="number" value="" name="bat_' + i + '">' +
                        '</div>';
                    $('#dynamic-fields-container').append(inputFieldHTML);
                }
            }).change();


            $('.btn-update').on('click', function() {
                // alert('update');
                // Set the value of the hidden input to blank
                $('input[name="status"]').val('');
            });

            // Listen for click event on the Approve button
            // $('.btn-submit').on('click', function() {
            //     // alert('submit');
            //     // Set the value of the hidden input to 'A'
            //     $('input[name="status"]').val('S');
            // });

            $('.btn-submit').on('click', function(event) {
                // Prevent the default behavior of the button click event
                event.preventDefault();

                // Display a confirmation dialog with SweetAlert2
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to submit this form?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit it!'
                }).then((result) => {
                    // If user confirms, submit the form
                    if (result.isConfirmed) {
                        // Set the value of the hidden input to 'S'
                        $('input[name="status"]').val('S');

                        // Submit the form
                        $(this).closest('form').submit();
                    }
                });
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
                            certificate_date: certificate_date,
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
