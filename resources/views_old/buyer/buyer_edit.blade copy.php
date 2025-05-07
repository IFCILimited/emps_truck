@extends('layouts.dashboard_master')
@section('title')
    Buyer Details
@endsection

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .error-help-block {
            color: red;
        }

        .disabled {
            cursor: not-allowed;
            opacity: 0.5;
            /* Optional: Change appearance of disabled anchor */
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
                        <h4 class="mb-2">Buyer Detail</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <form action="{{ route('buyer.update', $bankDetail->id) }}" role="form" method="POST"
                class='form-horizontal modelcreate' files=true enctype='multipart/form-data' id="model_create"
                accept-charset="utf-8">

                @csrf
                @method('patch')

                <input type="hidden" name='oem_id' id="oem_id" value="{{ Auth::user()->oem_id }}">
                <input type="hidden" name='dealer_id' value="{{ $user->id }}">
                <input type="hidden" value="{{ $bankDetail->segment_id }}" class="form-control" id="seg_id"
                    name="segment_id">



                <div class="row">
                    <div class="col-sm-12">
                        <div class="card height-equal">
                            <div class="card-body">
                                <div class="row">
                                    <div class="row">
                                        <ul>
                                            <span class="right badge badge-danger"> New</span> <br>
                                            <li><strong>1.</strong> OTP exemption for Aadhar Authentication is made
                                                available for sales which took place during April 1, 2024 till June 20,
                                                2024. However, Aadhar authentication is mandatory for sales w.e.f. June 21,
                                                2024 onwards.</li>
                                            <br>
                                            <li><strong>2.</strong> PAN card submission has been allowed as identity proof
                                                as an option, in addition to Aadhar Card for the state of Assam as in case
                                                of FAME-II.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card height-equal">

                            <div class="card-body">
                                <div class="row">
                                    <div class="row">


                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="oem_name">OEM Name</label>
                                            <input class="form-control readonly" readonly value="{{ $oemname->name }}"
                                                name="oem_name" id="oem_name" type="text">
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="ev_model_name">Dealer Name:</label>
                                            <input class="form-control readonly" readonly value="{{ $user->name }}"
                                                id="ev_model_name" type="text" name="dlr_name">

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="variant_name">Dealer code</label>
                                            <input class="form-control readonly" id="variant_name" readonly type="text"
                                                id="variant_name" value="{{ $bankDetail->dealer_code }}" name="dlr_code">
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="card height-equal">
                                <div class="card-header">
                                    <h4>Vehicle Information</h4>

                                </div>
                                <div class="card-body" id="oldVin">
                                    <input type="hidden" name='prod_id' value="{{ $bankDetail->production_id }}">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">VIN Number</label>
                                            <div class="row">
                                                {{-- <div class="col-md-6">
                                                    <input class="form-control readonly" id=""
                                                        name="" value="{{ $bankDetail->vin_chassis_no }}" readonly>
                                                </div> --}}
                                                {{-- <div class="col-md-6">
                                                    <a class="btn btn-primary" onclick="ChangeVin()">Change Vin</a>
                                                </div> --}}

                                                <input class="form-control readonly" id="" name=""
                                                    value="{{ $bankDetail->vin_chassis_no }}" readonly>
                                            </div>

                                        </div>
                                        {{-- <input type="hidden" name='production_id' value="" id="prd_id"> --}}

                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Search Vehicle:</label>
                                            <input class="form-control srchV readonly" id=""
                                                value="{{ $bankDetail->vehicle_cat }}" name="srch_v" readonly>


                                        </div>

                                        <div class="col-4 mb-3" id="xev">
                                            <label class="form-label" for="vehicle_segment">xEV Model Name/Code:</label>
                                            <input class="form-control srchV readonly" id="" name="xevmodl"
                                                value="{{ $bankDetail->model_name }}" readonly>

                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Model Variant (if
                                                any):</label>
                                            <input class="form-control srchV readonly" id=""
                                                value="{{ $bankDetail->variant_name }}" name="modelV" readonly>

                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Model Segment:</label>
                                            <input class="form-control srchV readonly" id="" name="seg"
                                                value="{{ $bankDetail->segment_name }}" readonly>



                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="">Ex-Factory Price:</label>
                                            <input class="form-control srchV readonly" id=""
                                                value="{{ $bankDetail->factory_price }}" name="exfactry" readonly>

                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Manufacturing Date:</label>
                                            <input class="form-control srchV readonly"
                                                value="{{ $prodDet->manufacturing_date }}" id=""
                                                name="manufacturing_date" readonly>

                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">Customer
                                                Type/Category:</label>
                                            <select class="form-select customer-type" id="cstm_typ" name="custmr_typ">
                                                <option selected="selected" disabled value="0">Select</option>
                                                @if ($bankDetail->custmr_typ == 1)
                                                    <option value="1" selected>Individual Cases</option>
                                                @else
                                                    <option value="2"
                                                        @if ($bankDetail->custmr_typ == 2) selected @endif>
                                                        Proprietory Firms/Agencies</option>
                                                    <option value="3"
                                                        @if ($bankDetail->custmr_typ == 3) selected @endif>
                                                        Corporate And Partnership Agencies</option>
                                                    <option value="4"
                                                        @if ($bankDetail->custmr_typ == 4) selected @endif>
                                                        Gov. Department/Defence Supply</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="Email">Email Id:</label>
                                            <input class="form-control" id="Email" type="text" name="email"
                                                value="{{ $bankDetail->email }}">
                                        </div>
                                        {{-- <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">Customer
                                                Type/Category:</label>
                                            <select class="form-select customer-type" id="cstm_typ" name="custmr_typ">
                                                <option value="">Choose...</option>
                                                <option selected="selected" disabled value="0">Select</option>
                                                <option value="1" @if ($bankDetail->custmr_typ == 1) selected @endif>
                                                    Individual Cases</option>
                                                <option value="2" @if ($bankDetail->custmr_typ == 2) selected @endif>
                                                    Proprietory Firms/Agencies</option>
                                                <option value="3" @if ($bankDetail->custmr_typ == 3) selected @endif>
                                                    Corporate And Partnership Agencies</option>
                                                <option value="4" @if ($bankDetail->custmr_typ == 4) selected @endif>
                                                    Gov. Department/Defence Supply</option>
                                            </select>
                                        </div> --}}
                                    </div>
                                </div>
                                {{-- fetch new vin detail --}}
                                {{-- <div class="card-body" id="newVin" style="display: none;">
                                    <input type="hidden" name='production_id' id="prd_idd">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">VIN Number</label>
                                            <div class="row">
                                                <div class="col-md-6"><input class="form-control" id="vin"
                                                        name="vin"></div>
                                                <div class="col-md-6">
                                                    <a class="btn btn-primary" onclick="getProjectCode()">Fetch
                                                        Data</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Search Vehicle:</label>
                                            <input class="form-control srchV readonly" id="sh_vehicle" name="srch_v"
                                                readonly>
                                        </div>

                                        <div class="col-4 mb-3" id="xev">
                                            <label class="form-label" for="vehicle_segment">xEV Model Name/Code:</label>
                                            <input class="form-control srchV readonly" id="xevmdl" name="xevmodl"
                                                readonly>
                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Model Variant (if
                                                any):</label>
                                            <input class="form-control srchV readonly" id="modl_vrnt" name="modelV"
                                                readonly>
                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Model Segment:</label>
                                            <input class="form-control srchV readonly" id="segment" name="seg"
                                                readonly>
                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Ex-Factory Price:</label>
                                            <input class="form-control srchV readonly" id="ex_price" name="exfactry"
                                                readonly>
                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Manufacturing Date:</label>
                                            <input class="form-control srchV readonly" id="manufacturing_date"
                                                name="manufacturing_date" readonly>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            {{-- <div class="card height-equal">
                                <div class="card-header">
                                    <h4>Customer Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">Customer
                                                Type/Category:</label>
                                            <select class="form-select customer-type" id="cstm_typ" name="custmr_typ">
                                                <option selected="selected" disabled value="0">Select</option> --}}
                                                {{-- <option value="1" @if ($bankDetail->custmr_typ == 1) selected @endif>
                                                    Individual Cases</option> --}}
                                                {{-- @if ($bankDetail->custmr_typ == 1)
                                                    <option value="1" selected>Individual Cases</option>
                                                @else
                                                    <option value="2"
                                                        @if ($bankDetail->custmr_typ == 2) selected @endif>
                                                        Proprietory Firms/Agencies</option>
                                                    <option value="3"
                                                        @if ($bankDetail->custmr_typ == 3) selected @endif>
                                                        Corporate And Partnership Agencies</option>
                                                    <option value="4"
                                                        @if ($bankDetail->custmr_typ == 4) selected @endif>
                                                        Gov. Department/Defence Supply</option>
                                                @endif
                                            </select>
                                        </div> --}}
                                        {{-- <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Temporary Registration
                                                Number</label>
                                            <input type="text" class="form-control" id="temp_reg" name="temp_reg"
                                                value="{{ $bankDetail->temp_reg_no }}">
                                        </div> --}}
                                        {{-- <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="Email">Email Id:</label>
                                            <input class="form-control" id="Email" type="text" name="email"
                                                value="{{ $bankDetail->email }}">
                                        </div>
                                    </div>
                                </div>

                            </div> --}}

                            {{-- {{dd($bankDetail->custmr_name)}} --}}
                            {{-- <div class="col-sm-12 customer-info">
                                <div class="card height-equal">
                                    <div class="card-header">
                                        <h4>Customer Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="Name">Customer Name:</label>
                                                <input class="form-control" type="text" name="custmr_name"
                                                    value="{{ $bankDetail->custmr_name }}" id="custm_name">
                                                <span class="text-danger">As mentioned in Aadhaar card</span>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="Address">Address:</label>
                                                <input class="form-control" type="text" id="add"
                                                    value="{{ $bankDetail->add }}" name="add">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="Landmark">Landmark:</label>
                                                <input class="form-control" type="text" id="Landmark"
                                                    name="landmark" value="{{ $bankDetail->landmark }}">
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="Pincode">Pincode:</label>
                                                <input class="form-control" type="text" name="Pincode"
                                                    placeholder=" Pincode" value="{{ $bankDetail->pincode }}"
                                                    onkeyup="citydata(this.value)">
                                                <span id="OEMpincodeMsg0"
                                                    style="color:red;font-weight:bold;display: none">
                                                    @error('Pincode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </span>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="State">State:</label>
                                                <input class="form-control readonly" type="text" name="State"
                                                    value="{{ $bankDetail->state }}" placeholder=" State"
                                                    id="OEMAddState0" readonly>
                                                @error('State')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="District">District:</label>
                                                <input class="form-control readonly" type="text" name="District"
                                                    value="{{ $bankDetail->district }}" placeholder="District"
                                                    id="OEMAddDistrict0" readonly>
                                                @error('District')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="City">City:</label>
                                                <select class="form-control" name="City" id="OEMAddCity0">
                                                    <option value="">Choose City ....</option>
                                                    <option value="{{ $bankDetail->city }}" selected>
                                                        {{ $bankDetail->city ? $bankDetail->city : '' }}
                                                    </option>
                                                </select>
                                                @error('City')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="mobile">Mobile Number:</label>
                                                <input class="form-control" type="number" id="mobile" name="mobile"
                                                    value="{{ $bankDetail->mobile }}">
                                            </div> --}}

                                            {{-- <div class="col-md-4 mb-3">
                                                <label class="form-label" for="Email">Email Id:</label>
                                                <input class="form-control" id="Email" type="text" name="email"
                                                    value="{{ $bankDetail->email }}">
                                            </div> --}}

                                            {{-- <div class="col-md-4 mb-3"> --}}
                                                {{-- <label class="form-label" for="dob">Date Of Incorporation:</label> --}}
                                                {{-- <label class="form-label" id="dateLabel" for="dob">Date Of
                                                    Incorporation:</label>
                                                <input class="form-control" type="date" name="dob"
                                                    value="{{ $bankDetail->dob }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            @if ($bankDetail->custmr_typ==1)
                            <div class="col-sm-12 customer-info">
                                <div class="card height-equal">
                                    <div class="card-header">
                                        <h4>Customer Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="Name">Customer Name:</label>
                                                <input class="form-control" type="text" name="custmr_name"
                                                    value="{{ $buyerDetail->custmr_name }}">
                                                <span class="text-danger">As mentioned in Aadhaar card</span>
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" >Gender:</label>
                                                <input class="form-control" type="text" name="gender"
                                                    value="{{ $buyerDetail->custmr_gender }}" >

                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="Address">Address:</label>
                                                <input class="form-control" type="text" 
                                                    value="{{ $buyerDetail->custmr_address }}" name="add">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="Landmark">Landmark:</label>
                                                <input class="form-control" type="text"
                                                    name="landmark" value="{{ $buyerDetail->custmr_landmark }}">
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="Pincode">Pincode:</label>
                                                <input class="form-control" type="text" name="Pincode"
                                                    placeholder=" Pincode" value="{{ $buyerDetail->custmr_pincode }}">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="State">State:</label>
                                                <input class="form-control readonly" type="text" name="State"
                                                    value="{{ $buyerDetail->custmr_state }}" placeholder=" State"
                                                     readonly>
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="District">District:</label>
                                                <input class="form-control readonly" type="text" name="District"
                                                    value="{{ $buyerDetail->custmr_district }}" placeholder="District" readonly>
                                                </div>
                                                
                                                <div class="col-4 mb-3">
                                                    <label class="form-label" for="City">City:</label>
                                                    <input class="form-control readonly" type="text" name="City"
                                                        value="{{ $buyerDetail->custmr_city }}" placeholder="City"
                                                         readonly>
                                                
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="mobile">Mobile Number:</label>
                                                <input class="form-control" type="number"  name="mobile"
                                                    value="{{ $buyerDetail->custmr_mobile }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" id="dateLabel" for="dob">Date Birth:</label>
                                                <input class="form-control" type="date" name="dob"
                                                    value="{{ $buyerDetail->custmr_dob }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-sm-12 customer-info">
                                <div class="card height-equal">
                                    <div class="card-header">
                                        <h4>Customer Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="Name">Customer Name:</label>
                                                <input class="form-control" type="text" name="custmr_name"
                                                    value="{{ $bankDetail->custmr_name }}" id="custm_name">
                                                <span class="text-danger">As mentioned in Aadhaar card</span>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="Address">Address:</label>
                                                <input class="form-control" type="text" id="add"
                                                    value="{{ $bankDetail->add }}" name="add">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="Landmark">Landmark:</label>
                                                <input class="form-control" type="text" id="Landmark"
                                                    name="landmark" value="{{ $bankDetail->landmark }}">
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="Pincode">Pincode:</label>
                                                <input class="form-control" type="text" name="Pincode"
                                                    placeholder=" Pincode" value="{{ $bankDetail->pincode }}"
                                                    onkeyup="citydata(this.value)">
                                                <span id="OEMpincodeMsg0"
                                                    style="color:red;font-weight:bold;display: none">
                                                    @error('Pincode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </span>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="State">State:</label>
                                                <input class="form-control readonly" type="text" name="State"
                                                    value="{{ $bankDetail->state }}" placeholder=" State"
                                                    id="OEMAddState0" readonly>
                                                @error('State')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="District">District:</label>
                                                <input class="form-control readonly" type="text" name="District"
                                                    value="{{ $bankDetail->district }}" placeholder="District"
                                                    id="OEMAddDistrict0" readonly>
                                                @error('District')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="City">City:</label>
                                                <select class="form-control" name="City" id="OEMAddCity0">
                                                    <option value="">Choose City ....</option>
                                                    <option value="{{ $bankDetail->city }}" selected>
                                                        {{ $bankDetail->city ? $bankDetail->city : '' }}
                                                    </option>
                                                </select>
                                                @error('City')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="mobile">Mobile Number:</label>
                                                <input class="form-control" type="number" id="mobile" name="mobile"
                                                    value="{{ $bankDetail->mobile }}">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" id="dateLabel" for="dob">Date Of
                                                    Incorporation:</label>
                                                <input class="form-control" type="date" name="dob"
                                                    value="{{ $bankDetail->dob }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif


                            <div class="col-sm-12">
                                <div class="card height-equal">
                                    <div class="card-header">
                                        <h4>Invoice Detail</h4>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="range">Dealer Invoice No.:</label>
                                                <input class="form-control" id="range" type="text"
                                                    value="{{ $bankDetail->dlr_invoice_no }}" name="dlr_invoice_no">
                                                <span class="text-danger">As mentioned invoice copy</span>

                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="invoice_dt">
                                                    Dealer Invoice Date:</label>
                                                <input class="form-control" id="invoice_dt" type="date"
                                                    value="{{ date('Y-m-d', strtotime($bankDetail->invoice_dt)) }}"
                                                    name="invoice_dt" min="{{ $minDate }}"
                                                    max="{{ $maxDate }}" onchange="validateDates()">

                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="vihcle_dt">Vehicle
                                                    Registration Date:</label>
                                                <input class="form-control" id="vihcle_dt" type="date"
                                                    value="{{ date('Y-m-d', strtotime($bankDetail->vihcle_dt)) }}"
                                                    name="vihcle_dt" min="{{ $minDate }}"
                                                    max="{{ $maxDate }}" onchange="validateDates()">


                                            </div>



                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Invoice Amount(INR)(per vehicle):</label>
                                                <input class="form-control" id="invoice_amt" type="number"
                                                    value="{{ $bankDetail->invoice_amt }}" name="invoice_amt">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Admissible Incentive Amount(INR)(per
                                                    vehicle):</label>
                                                <input class="form-control readonly" id="addmi_inc_amt" type="number"
                                                    value="{{ $bankDetail->addmi_inc_amt }}" readonly
                                                    name="addmi_inc_amt">
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Total Invoice Amount(INR):</label>
                                                <input class="form-control readonly" id="tot_inv_amt" type="number"
                                                    value="{{ $bankDetail->tot_inv_amt }}" readonly name="tot_inv_amt">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Total Admissible Incentive Amount(INR):</label>
                                                <input class="form-control readonly" id="tot_adm_inc_amt" type="number"
                                                    value="{{ $bankDetail->tot_admi_inc_amt }}" readonly
                                                    name="tot_admi_inc_amt">
                                            </div>
                                            <div class="col-4 mb-3 ">
                                                <label class="form-label" for="minimax_speed">Amount Payable by Customer
                                                    (INR):</label>
                                                <input class="form-control readonly" id="amt_custmr" type="number"
                                                    value="{{ $bankDetail->amt_custmr }}" readonly name="amt_custmr">
                                                <span class="text-danger">Amount after deduction of EMPS
                                                    Incentive</span>
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="discount">Discount Given</label>
                                                <select class="form-control" name="discount" id="discount"
                                                    onchange="addField()">
                                                    <option value="" selected disabled>Select</option>
                                                    <option value="1"
                                                        {{ $bankDetail->discount_given == 1 ? 'selected' : '' }}>Yes
                                                    </option>
                                                    <option value="0"
                                                        {{ $bankDetail->discount_given == 0 ? 'selected' : '' }}>No
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-4 mb-3" id="discountFieldContainer"
                                                style="display: {{ $bankDetail->discount_given == 1 ? 'block' : 'none' }};">
                                                <label class="form-label" for="discountAmount">Discount Amount</label>
                                                <input type="text" class="form-control"
                                                    value="{{ $bankDetail->discount_amt }}" name="discountAmount"
                                                    id="discountAmount" placeholder="Enter discount amount">
                                            </div>
                                            <div class="col-4 mb-3 " id="empField"
                                                style="display: {{ $bankDetail->discount_given == 1 ? 'block' : 'none' }};">
                                                <label class="form-label" for="minimax_speed">Emps 2024</label>
                                                <select class="form-control" name="empsBeforeAfter">
                                                    <option selected disabled>Select</option>
                                                    <option value="Before"
                                                        {{ $bankDetail->empsbeforeafter == 'Before' ? 'selected' : '' }}>
                                                        Before</option>
                                                    <option value="After"
                                                        {{ $bankDetail->empsbeforeafter == 'After' ? 'selected' : '' }}>
                                                        After
                                                    </option>
                                                </select>
                                            </div>


                                        </div>

                                    </div>


                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card height-equal">
                                    <div class="card-header">
                                        <h4>Customer Identification Information:</h4>

                                    </div>
                                    {{-- {{dd($cat)}} --}}
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4 mb-3 customer-id-container">
                                                <label class="form-label" for="customer_id">Customer Id:*</label>
                                                <select class="form-select" name="customer_id"
                                                    onchange="chnInput(this.value)" id="cstmer_typ">
                                                    @foreach ($cat as $cats)
                                                        <option value="{{ $cats->id }}"
                                                            {{ $bankDetail->custmr_id == $cats->id ? 'selected' : '' }}>
                                                            {{ $cats->name }}
                                                        </option>
                                                    @endforeach
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3 customer-id-no-container">
                                                <label class="form-label">Customer Id No.:</label>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <input class="form-control" id="adhar_no" type="text"
                                                            value="{{ $bankDetail->custmr_id_no }}" name="custmr_id_no">
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-md-4 mb-3 customer-id-copy-container">
                                                <label class="form-label" id="cust_id_label">Customer Id copy:</label>
                                                <input class="form-control" type="file" value="" id="cust_id"
                                                    name="custmr_file_copy">
                                                {{-- {{dd($bankDetail->copy_file_uploadid);}} --}}
                                                @if ($bankDetail->copy_file_uploadid != null)
                                                    <a class="btn btn-success btn-sm" id="cut_id_doc_1"
                                                        href="{{ route('doc.down', encrypt($bankDetail->copy_file_uploadid)) }}">
                                                        <i class="fa fa-download"></i> View Certificate
                                                    </a>
                                                @endif
                                                <input type="hidden" id="cut_id_doc_id" name="custmr_file_copy_id"
                                                    value="{{ $bankDetail->copy_file_uploadid }}">
                                            </div>
                                            {{-- <div class="col-md-4 mb-3">
                                                <label class="form-label">Customer Id copy:</label>
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($bankDetail->copy_file_uploadid)) }}">
                                                    <i class="fa fa-download"></i> View Certificate
                                                </a>
                                            </div> --}}


                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Additional Customer Id:</label>
                                                <select class="form-select" name="addi_cust_id"
                                                    id="battery_cat_repulsion">
                                                    <option selected="selected" disabled value="0">Select</option>
                                                    @foreach ($type as $val)
                                                        <option value="{{ $val->id }}"
                                                            @if ($val->id == $bankDetail->addi_cust_id) selected @endif>
                                                            {{ $val->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Additional Customer Id No.:</label>
                                                <input class="form-control" id="total_energy_capacity" type="text"
                                                    value="{{ $bankDetail->cust_id_sec }}"
                                                    style="text-transform: uppercase;" name="cust_id_sec">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Additional Customer Id copy:</label>
                                                <input class="form-control" type="file" value=""
                                                    id="battery_make" name="cust_sec_file">
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($bankDetail->sec_file_uploadeid)) }}">
                                                    <i class="fa fa-download"></i> View Certificate
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>Vehicle Details:</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Temporary Vehicle Registration
                                                Number</label>
                                            <input type="text" class="form-control readonly" id="temp_reg" name="temp_reg"
                                                value="{{ $bankDetail->temp_reg_no }}" readonly>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="">
                                                Permanent Vehicle Registration Number:</label>
                                            <input class="form-control" id="" type="text" name="vhcl_regis_no">
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="max_electric_energy_consumption">Vehicle
                                                Registration Date:</label>
                                            <input class="form-control" id="max_electric_energy_consumption" type="date"
                                                value="{{ date('Y-m-d', strtotime($bankDetail->vihcle_dt)) }}" name="vihcle_dt">
                                        </div>
                                        {{-- <div class="col-4 mb-3 ">
                                            <label class="form-label" for="minimax_speed">Vehicle Registration
                                                Copy:</label>
                                            <input class="form-control" id="minimax_speed" type="file" name="vhcl_reg_file">
                                        </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>Dcoument Upload:</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="range">Customer Acknowledgement:</label>
                                        <input class="form-control" id="range" type="file" name="cst_ack_file">
                                        <span class="text-danger">Upload Signed & Stamped Customer Acknowledgement
                                            Form (pdf only and max. 2 MB size)</span>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">
                                            Invoice Copy:</label>
                                        <input class="form-control" id="max_electric_energy_consumption" type="file"
                                            name="invc_copy_file">
        
                                        <span class="text-danger text-justify">Upload Invoice Copy (pdf only and max. 2 MB
                                            size)</span>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">
                                            E-Voucher Copy:</label>
                                        <input class="form-control" id="max_electric_energy_consumption" type="file"
                                            name="invc_copy_file">
        
                                        <span class="text-danger">upload Signed & Stamped E-Voucher
                                             (pdf only and max. 2 MB size)</span>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">
                                            Customer Selfi Copy:</label>
                                        <input class="form-control" id="max_electric_energy_consumption" type="file"
                                            name="invc_copy_file">
        
                                        <span class="text-danger">upload  Customer Selfi Copy
                                             (pdf only and max. 2 MB size)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="display: flex;justify-content: space-evenly;align-items: center;">
                        <div class="text-left">
                            <a href="{{ route('buyerdetail.index') }}" class="btn btn-warning">Back</a>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-primary form-control-sm mt-2" type="submit"
                                id="callFunctionBtn">Update</button>
                        </div>
                        @if ($bankDetail->custmr_typ == 1)
                            <div>
                                <a target="_blank" href="{{ route('dealer.view_certificate', encrypt($id)) }}"
                                    class="btn btn-success form-control-sm mt-2">View E-Voucher
                                </a>
                            </div>
                        @endif


                        <div class="text-center">
                            <a target="_blank" href="{{ route('ack.view', $bankDetail->id) }}"
                                class="btn btn-warning form-control-sm mt-2" id="acknowledgeButton"
                                @if ($bankDetail->status == 'S') disabled @endif>Print Acknowledge</a>
                        </div>

                        <div class="text-end">
                            <a target="_blank" href="{{ route('buyer.submit', $bankDetail->id) }}"
                                class="btn btn-success form-control-sm mt-2  " id="submitBtn">Save & Next</a>
                        </div>
                        {{-- <div class="text-end">
                            <a target="_blank" href="{{ route('buyer.submit', $bankDetail->id) }}"
                                class="btn btn-success form-control-sm mt-2  " id="submitBtn">Final submit</a>
                        </div> --}}
                        {{-- <div class="text-end">
                            <a target="_blank" href="{{ route('buyer.submit', $bankDetail->id) }}"
                                class="btn btn-success form-control-sm mt-2 disabled " id="submitBtn">Final submit</a>
                        </div> --}}
                    </div>
                    {{-- <div class="row">
                        <div class="col-3 text-left">
                            <a href="{{ route('buyerdetail.index') }}" class="btn btn-warning">Back</a>
                        </div>
                        <div class="col-3 text-center">
                            <button class="btn btn-primary form-control-sm mt-2" type="submit"
                                id="callFunctionBtn">Update</button>
                        </div>

                        <div class="col-3 text-center">
                            <a target="_blank" href="{{ route('ack.view', $bankDetail->id) }}"
                                class="btn btn-warning form-control-sm mt-2" id="acknowledgeButton"
                                @if ($bankDetail->status == 'S') disabled @endif>Print Acknowledge</a>

                        </div>

                        <div class="col-3 text-end">
                            <a target="_blank" href="{{ route('buyer.submit', $bankDetail->id) }}"
                                class="btn btn-success form-control-sm mt-2 disabled " id="submitBtn">Final submit</a>
                        </div>
                    </div> --}}


                    <div class="card height-equal mt-5">
                        <div class="card-header">
                            <h4>Vehicle Details:</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-3 mb-3" id="">
                                        <label class="form-label" for="manu_date">Temporary Registration
                                            Number</label>
                                        <input type="text" class="form-control readonly" id="temp_reg" name="temp_reg"
                                            value="{{ $bankDetail->temp_reg_no }}" readonly>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="">
                                            Permanent Registration Number:</label>
                                        <input class="form-control readonly" id="" type="text" name="vhcl_regis_no" value="123456987" readonly>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">Vehicle
                                            Registration Date:</label>
                                        <input class="form-control readonly" id="max_electric_energy_consumption" type="date"
                                            value="{{ date('Y-m-d', strtotime($bankDetail->vihcle_dt)) }}" name="vihcle_dt" readonly>
                                    </div>
                                    <div class="col-3 mb-3 ">
                                        <label class="form-label" for="minimax_speed">Vehicle Registration
                                            Copy:</label>
                                        <input class="form-control" id="minimax_speed" type="file" name="vhcl_reg_file">
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="text-left  col-6">
                            <a href="{{ route('buyerdetail.index') }}" class="btn btn-warning">Back</a>
                        </div>
                        {{-- <div class="text-center">
                            <button class="btn btn-primary form-control-sm mt-2" type="submit"
                                id="callFunctionBtn">Update</button>
                        </div> --}}
                        <div class="text-right col-6">
                            <a target="_blank" href="{{ route('buyer.submit', $bankDetail->id) }}"
                                class="btn btn-success form-control-sm mt-2  " id="submitBtn">Upload & Final Submit</a>
                        </div>
                    </div>
            </form>
        </div>

    </div>
    </div>
    <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
    @include('partials.js.pincode')
    <script>
        $('#invoice_amt').on('keyup', function() {
            var val1 = parseFloat($('#invoice_amt').val()) || 0;
            var val2 = parseFloat($('#addmi_inc_amt').val()) || 0;

            // Check if val1 is smaller than val2
            if (val1 < val2) {
                $('#error_msg').text(
                    'Invoice Amount should be greater than Admissible Incentive Amount');
                $('#tot_inv_amt').val('');
                $('#amt_custmr').val('');
            } else {
                $('#error_msg').text(''); // Clear error message
                var result = val1 - val2;
                $('#tot_inv_amt').val(result);
                $('#amt_custmr').val(result);
            }
        });


        function addField() {
            var discountSelect = document.getElementById('discount');
            var discountFieldContainer = document.getElementById('discountFieldContainer');
            var empField = document.getElementById('empField');

            if (discountSelect.value === '1') {
                discountFieldContainer.style.display = 'block';
                empField.style.display = 'block';
            } else {
                discountFieldContainer.style.display = 'none';
                empField.style.display = 'none';
            }
        }


        $(document).ready(function() {
            const customerTypeSelect = $('#cstm_typ'); // Ensure this ID matches your select element
            $("#cstmer_typ").empty();
            $("#custmr_id_no").empty();
            $("#custmr_file_copy_id").empty();

            // Function to toggle visibility based on selected value
            function toggleCustomerInfo() {
                const customerInfo = $('.customer-info');
                const customerIdContainer = $('.customer-id-container');
                const customerIdNoContainer = $('.customer-id-no-container');
                const customerIdCopyContainer = $('.customer-id-copy-container');
                var dateLabel = $('#dateLabel'); // Reference to the label for the date input

                if (customerTypeSelect.val() === '1') {
                    customerInfo.show();
                    customerIdContainer.hide();
                    customerIdNoContainer.hide();
                    customerIdCopyContainer.hide();

                    // clearInputValues(customerInfo);
                    // clearInputValues(customerIdContainer);
                    clearInputValues(customerIdNoContainer);
                    clearInputValues(customerIdCopyContainer);

                    // Function to toggle readonly state
                    function toggleReadonly(isReadonly) {
                        customerInfo.find('input, select').each(function() {
                            $(this).prop('readonly', isReadonly); // Set readonly for input
                            $(this).prop('disabled', isReadonly && $(this).is(
                                'select')); // Disable select if readonly
                            if (isReadonly) {
                                $(this).addClass('readonly'); // Add readonly class
                            } else {
                                $(this).removeClass('readonly'); // Remove readonly class
                            }
                        });
                        // Change the label text for the date input
                        if (isReadonly) {
                            dateLabel.text('Date of Birth'); // Change to Date of Birth
                        } else {
                            dateLabel.text('Date Of Incorporation'); // Change to Date Of Incorporation
                            // Always apply readonly logic to specific fields regardless of the readonly state
                            $("#OEMAddState0").prop('readonly', true).addClass('readonly');
                            $("#OEMAddDistrict0").prop('readonly', true).addClass('readonly');
                        }
                    }

                    // Initial check based on value when page loads
                    if (customerTypeSelect.val() === '1') {
                        NullValues(customerIdContainer);
                        toggleReadonly(true); // Make fields readonly
                    } else {
                        toggleReadonly(false); // Enable fields
                    }

                    // Event listener for when customer type changes
                    // customerTypeSelect.on('change', function() {
                    //     if ($(this).val() === '1') {
                    //     customerInfo.hide();
                    //      clearInputValues(customerInfo);
                    //         // toggleReadonly(true); // Make fields readonly
                    //     } else {
                    //         toggleReadonly(false); // Enable fields
                    //     }
                    // });
                } else {
                    customerInfo.show();
                    customerIdContainer.show();
                    customerIdNoContainer.show();
                    customerIdCopyContainer.show();

                    // Make AJAX call if a valid value is selected
                    if (customerTypeSelect.val()) {
                        var url = '/customer/type/' + customerTypeSelect.val();

                        $.ajax({
                            url: url,
                            method: 'GET',
                            success: function(response) {
                                console.log('Response:', response);
                                $('#cstmer_typ').empty();

                                // Append new options
                                $.each(response, function(index, option) {
                                    $('#cstmer_typ').append('<option value="' + option.id +
                                        '"' +
                                        (option.id === 1 ? ' selected' : '') +
                                        '>' + option.name + '</option>');
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            }
                        });
                    }
                }
            }

            // Function to clear input values in a container
            function clearInputValues(container) {
                const inputs = container.find('input, textarea'); // Use jQuery to find inputs
                inputs.each(function() {
                    $(this).val(''); // Clear the value
                });
            }

            // Initial check on page load
            toggleCustomerInfo();

            // Add event listener to handle changes
            customerTypeSelect.change(toggleCustomerInfo);
        });




        function citydata(value) {
            $('#OEMAddCity0').val('')
            GetCityByPinCode('OEM', value, 0)
        }

        function getProjectCode() {

            $(".srchV").val('');

            var val = document.getElementById("vin").value;
            var oemid = document.getElementById("oem_id").value;

            var token = $("input[name='_token']").val();

            // console.log('/vin/getcode/' + val + '/' + oemid);

            $.ajax({
                url: '/vin/getcode/' + val + '/' + oemid,

                method: 'GET',


                success: function(responce) {
                    console.log(responce);


                    if (responce.data2 == 1) {
                        alert('Vehicle with this VIN no is already sold')
                        $('#sh_vehicle').val();
                        $('#xevmdl').val();
                        $('#modl_vrnt').val();
                        $('#segment').val();
                        $('#ex_price').val();
                        $('#manufacturing_date').val();
                        $('#tot_adm_inc_amt').val();
                        $('#addmi_inc_amt').val();

                    } else if (responce.data1.length == 0) {
                        $('#vin').val();
                        alert('Please enter correct VIN no')

                    } else if (responce.data1[0].manufacturing_date) {
                        let manufacturingDate = new Date(responce.data1[0].manufacturing_date);
                        let startDate = new Date('2024-04-01');
                        let endDate = new Date('2024-09-30');

                        if (manufacturingDate >= startDate && manufacturingDate <= endDate) {
                            $('#prd_idd').val(responce.data1[0].id);
                            $('#seg_id').val(responce.data1[0].segment_id);
                            $('#sh_vehicle').val(responce.data1[0].vehicle_cat);
                            $('#xevmdl').val(responce.data1[0].model_name);
                            $('#modl_vrnt').val(responce.data1[0].variant_name);
                            $('#segment').val(responce.data1[0].segment);
                            $('#ex_price').val(responce.data1[0].factory_price);
                            $('#manufacturing_date').val(responce.data1[0].manufacturing_date);
                            $('#tot_adm_inc_amt').val(responce.data3);
                            $('#addmi_inc_amt').val(responce.data3);
                        } else {
                            alert('The manufacturing date is not between 1 April 2024 and 30 Sep 2024');
                        }
                    } else {
                        $('#prd_idd').val(responce.data1[0].id);
                        $('#seg_id').val(responce.data1[0].segment_id);
                        $('#sh_vehicle').val(responce.data1[0].vehicle_cat);
                        $('#xevmdl').val(responce.data1[0].model_name);
                        $('#modl_vrnt').val(responce.data1[0].variant_name);
                        $('#segment').val(responce.data1[0].segment);
                        $('#ex_price').val(responce.data1[0].factory_price);
                        $('#manufacturing_date').val(responce.data1[0].manufacturing_date);
                        $('#tot_adm_inc_amt').val(responce.data3);
                        $('#addmi_inc_amt').val(responce.data3);
                    }
                }
            });
        }

        // function ChangeVin() {
        //     $("#oldVin").hide();
        //     $("#newVin").show();
        //     $("#invoice_amt").val("");
        //     $("#addmi_inc_amt").val("");
        //     $("#tot_inv_amt").val("");
        //     $("#tot_adm_inc_amt").val("");
        //     $("#amt_custmr").val("");
        // }

        function validateDates() {
            var manu_date = new Date($("#manufacturing_date").val());
            var invoiceDate = new Date($("#invoice_dt").val());
            var vehicleDate = new Date($("#vihcle_dt").val());

            if (invoiceDate < manu_date) {
                alert("Invoice date is less than manufacturing date");
            }
            if (invoiceDate > vehicleDate) {
                alert("Invoice date cannot be greater than vehicle registration date");
                $("#invoice_dt").val("");
                $("#vihcle_dt").val("");
            }
        }

        $("#invoice_dt, #vihcle_dt").change(validateDates);


        function chnInput(val) {
            // alert(val);
            if (val == 1) {
                $('#change_adhar').css("display", "block");
                $('#adhar_no').prop('readonly', ture).addClass('readonly');
                $("#callFunctionBtn").prop("disabled", true);
                $('#cust_id').css("display", "none");
                $('#cust_id_label').css("display", "none");
            } else {
                // $('#Clickadhr').css("display", "none");
                $('#change_adhar').css("display", "none");
                $("#callFunctionBtn").prop("disabled", false);
                $('#adhar_no').prop('readonly', false).removeClass('readonly');
                $('#cust_id').css("display", "block");
                $('#cust_id_label').css("display", "block");
            }
        }


        $(document).ready(function() {
            $('#cstm_typ').on('change', function() {
                const customerInfo = $('.customer-info');
                const customerIdContainer = $('.customer-id-container');
                const customerIdNoContainer = $('.customer-id-no-container');
                const customerIdCopyContainer = $('.customer-id-copy-container');
                var dateLabel = $('#dateLabel'); // Reference to the label for the date input
                var val = $(this).val();
                if ($(this).val() === '1') {
                    customerInfo.hide();
                    customerIdContainer.hide();
                    customerIdNoContainer.hide();
                    customerIdCopyContainer.hide();
                    NullValues(customerInfo);
                    $("#cstmer_typ").empty();
                    $("#custmr_id_no").empty();
                    $("#custmr_file_copy_id").empty();
                    // toggleReadonly(true); // Make fields readonly
                } else {
                    customerInfo.show();
                    customerInfo.find('input, select').each(function() {
                        $(this).prop('readonly', false); // Remove readonly for input fields
                        $(this).prop('disabled', false); // Enable select fields
                        $(this).removeClass('readonly'); // Remove readonly class
                        dateLabel.text('Date Of Incorporation'); // Change to Date Of Incorporation
                        $("#OEMAddState0").prop('readonly', true).addClass('readonly');
                        $("#OEMAddDistrict0").prop('readonly', true).addClass('readonly');
                    });

                    if (val) {
                        var url = '/customer/type/' + val;

                        $.ajax({
                            url: url,
                            method: 'GET',
                            success: function(response) {
                                console.log('Response:', response);
                                $('#cstmer_typ').empty();

                                // Append new options
                                $.each(response, function(index, option) {
                                    //alert(option.id);
                                    $('#cstmer_typ').append('<option value="' + option
                                        .id +
                                        '"' + (option.id === 1 ? ' selected' : '') +
                                        '>' +
                                        option.name + '</option>');
                                });
                                // Handle response data here
                            },
                        });
                    }
                }

            });
        });
        // Function to clear input values and assign null
        function NullValues(container) {
            const inputs = container.find('input, select, textarea'); // Use jQuery to find inputs, selects, and textareas
            inputs.each(function() {
                if ($(this).is('select')) {
                    $(this).prop('selectedIndex', 0); // Reset select options
                } else {
                    $(this).val(null); // Assign null to input and textarea values
                }
            });
        }

        document.getElementById('submitBtn').addEventListener('click', function(event) {
            event.preventDefault();


            Swal.fire({
                title: 'Are you sure you want to submit Buyer Detail?',
                text: "Once you submit buyer details, you cannot make any changes.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    window.location.href = event.target.href;
                }
            });
        });
        document.getElementById('acknowledgeButton').addEventListener('click', function(event) {
            // event.preventDefault();
            $('#submitBtn').removeClass('disabled');
            $('#acknowledgeButton').addClass('disabled');
            //  $('#acknowledgeButton').removeAttr('href');

        });
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\BuyerDetailRequestUpdate', '.modelcreate') !!}
@endpush
