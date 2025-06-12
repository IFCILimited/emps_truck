@extends('layouts.e_truck_dashboard_master')
@section('title')
    Customer Details
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
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mb-2"> Customer Detail</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">

            <form action="{{ route('e-trucks.buyerdetail.store') }}" role="form" method="POST"
                class='form-horizontal modelcreate prevent-multiple-submit' files=true enctype='multipart/form-data'
                id="model_create" accept-charset="utf-8">
                @csrf
                <input type="hidden" name='oem_id' id="oem_id" value="{{ Auth::user()->oem_id }}">
                <input type="hidden" name='dealer_id' value="{{ $user->id }}">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card height-equal mt-5">
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
                                                id="variant_name" value="{{ Auth::user()->dealer_code }}" name="dlr_code">
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
                                <div class="card-body">
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
                                        <input type="hidden" name='production_id' value="" id="prd_id">

                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Category Name:</label>
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
                                            <input type="hidden" class="form-control" id="seg_id" name="segment_id"
                                                readonly>

                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Ex-Factory Price:</label>
                                            <input class="form-control srchV readonly" id="ex_price" name="exfactry"
                                                readonly>

                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Manufacturing Date:</label>
                                            <input min="{{ $minDate }}" max="{{ $maxDate }}"
                                                class="form-control srchV readonly" id="manufacturing_date"
                                                name="manufacturing_date" readonly>

                                        </div>
                                        {{-- <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Temporary RC Number:</label>
                                            <input class="form-control srchV readonly" id="temp_reg_no"
                                                name="temp_reg_no" readonly>

                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Temporary RC Date:</label>
                                            <input class="form-control srchV readonly" id="temp_reg_dt"
                                                name="temp_reg_dt" readonly>

                                        </div> --}}

                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Parmanent RC Number:</label>
                                            <input class="form-control srchV readonly" id="permanent_reg_no"
                                                name="permanent_reg_no" readonly>

                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Parmanent RC Date:</label>
                                            <input class="form-control srchV readonly" id="permanent_reg_dt"
                                                name="permanent_reg_dt" readonly>

                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Gross Vehicle Weight (GVW in
                                                Tons):</label>
                                            <input class="form-control srchV readonly" id="gross_weight" name="gvw"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- CD No----------------------------- --}}
                            <div class="card height-equal">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>CD Information</h4>
                                    <button type="button" class="btn btn-info" id="add_multi_cdn">Add Row</button>
                                </div>
                                <div class="card-body">
                                    <div class="vehicle_div">
                                        <div class="row border p-3 cd-block" id="cd-inputs-wrapper">
                                            <div class="col-4 mb-3 cd-entry">
                                                <label class="form-label">CD Number</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input class="form-control cdnumber-input"
                                                            name="data[1][cdnumber]">
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                        <button type="button"
                                                            class="btn btn-primary btn-sm p-2 fetch-cd-btn"
                                                            data-index="1">Fetch CD Data</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label">CD Owner Name:</label>
                                                <input class="form-control readonly cd_owner_name"
                                                    name="data[1][cd_owner_name]" readonly>
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label">Gross Vehicle Weight (GVW in Tons):</label>
                                                <input class="form-control readonly gvw" name="data[1][gvw]" readonly>
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label">VIN/Chassis Number:</label>
                                                <input class="form-control readonly vin_no" name="data[1][vin_no]"
                                                    readonly>
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label">Status Flag:</label>
                                                <input class="form-control readonly status" name="data[1][status]"
                                                    readonly>
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label">CD – Issue Date:</label>
                                                <input class="form-control readonly cd_issue_date"
                                                    name="data[1][cd_issue_date]" readonly>
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label">CD - Validity Upto Date:</label>
                                                <input class="form-control readonly cd_validation_date"
                                                    name="data[1][cd_validation_date]" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- end cd no------------ --}}


                            <div class="card height-equal">
                                <div class="card-header">
                                    <h4>Customer Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">Customer
                                                Type/Category:</label>
                                            <select class="form-select customer-type" id="cstm_typ" name="custmr_typ">
                                                <option selected="selected" disabled value="0">Select</option>
                                                <option value="1">Individual Cases</option>

                                            </select>
                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label">Customer Name:</label>
                                            <input type="text" class="form-control" id="custmr_name"
                                                name="custmr_name">
                                            <div class="text-center">
                                                <span class="text-primary">Customer Name as per invoice</span>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label">Email Id:</label>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 customer-info" style="display: none">
                                <div class="card height-equal">
                                    <div class="card-header">
                                        <h4>Customer Address Detail</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="add">Address:</label>
                                                <input class="form-control" type="text" id="add"
                                                    name="add">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="landmark">Landmark:</label>
                                                <input class="form-control" id="landmark" type="text"
                                                    name="landmark">
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="Pincode">Pincode:</label>
                                                <input class="form-control" type="text" name="Pincode"
                                                    placeholder="Pincode"
                                                    onkeyup="GetCityByPinCode('OEM', this.value, 0)">
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
                                                    placeholder="State" id="OEMAddState0" readonly>
                                                @error('State')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="District">District:</label>
                                                <input class="form-control readonly" type="text" name="District"
                                                    placeholder="District" id="OEMAddDistrict0" readonly>
                                                @error('District')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="City">City:</label>
                                                <select class="form-control" name="City" id="OEMAddCity0">
                                                    <option class="form-control" selected disabled value="">Choose
                                                        City ....</option>
                                                </select>
                                                @error('City')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="mobile">Mobile Number:</label>
                                                <input class="form-control" id="mobile" type="number"
                                                    name="mobile">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="dob">Date Of Incorporation
                                                    Date:</label>
                                                <input class="form-control" type="date" id="dob"
                                                    name="dob">

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card height-equal">
                                    <div class="card-header">
                                        <h4>Invoice Detail</h4>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="range">Dealer Invoice No.:</label>
                                                <input class="form-control" id="range" type="text" value=""
                                                    name="dlr_invoice_no">
                                                <span class="text-primary">As mentioned invoice copy</span>

                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="invoice_dt">
                                                    Dealer Invoice Date:</label>
                                                <input class="form-control" id="invoice_dt" type="date"
                                                    value="" name="invoice_dt" min="{{ $minDate }}"
                                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    onchange="validateDates()">

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Invoice Amount(INR)(per vehicle):</label>
                                                <input class="form-control" id="invoice_amt" type="number"
                                                    value="" name="invoice_amt">
                                                <span id="error_msg" style="color: red; font-weight: bold;"></span>
                                            </div>

                                            {{-- <div class="col-md-4 mb-3">
                                                <label class="form-label">Admissible Incentive Amount(INR)(per
                                                    vehicle):</label>
                                                <input class="form-control readonly" id="addmi_inc_amt" type="number"
                                                    value="" name="addmi_inc_amt" readonly>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Total Invoice Amount(INR):</label>
                                                <input class="form-control readonly" id="tot_inv_amt" type="number"
                                                    value="" name="tot_inv_amt" readonly>
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Total Admissible Incentive Amount(INR):</label>
                                                <input class="form-control readonly" id="tot_adm_inc_amt" type="number"
                                                    value="" name="tot_admi_inc_amt" readonly>
                                            </div>
                                            <div class="col-4 mb-3 ">
                                                <label class="form-label" for="minimax_speed">Amount Payable by Customer
                                                    (INR):</label>
                                                <input class="form-control readonly" id="amt_custmr" type="number"
                                                    value="" name="amt_custmr" readonly>
                                                <span class="text-primary">Amount after deduction of PM E-DRIVE 2024
                                                    Incentive</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-12">
                                <div class="card height-equal">
                                    <div class="card-header">
                                        <h4>Customer Identification Information:</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6 nonInv mb-3" style="display: none">
                                                <label class="form-label">PAN:</label>
                                                <input class="form-control" id="pan" type="text" value=""
                                                    name="pan">
                                            </div>
                                            <div class="col-md-6 nonInv mb-3" style="display: none">
                                                <label class="form-label">PAN Copy.:</label>
                                                <input class="form-control" id="pancopy" type="file" value=""
                                                    name="pancopy">
                                            </div>
                                            <div class="col-md-6 nonInv mb-3" style="display: none">
                                                <label class="form-label">GSTIN No.:</label>
                                                <input class="form-control" id="gstin" type="text" value=""
                                                    name="gstin">
                                            </div>
                                            <div class="col-md-6 nonInv mb-3" style="display: none">
                                                <label class="form-label">GSTN Copy:</label>
                                                <input class="form-control" id="gstncopy" type="file" value=""
                                                    name="gstncopy">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Additional Customer Id:</label>
                                                <select class="form-select" name="addi_cust_id" id="addi_cust_id">
                                                    <option selected="selected" disabled value="0">Select</option>
                                                    @foreach ($type as $val)
                                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Additional Customer Id No.:</label>
                                                <input class="form-control" id="cust_id_sec" type="text"
                                                    value="" name="cust_id_sec">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Additional Customer Id copy:</label>
                                                <input class="form-control" type="file" value=""
                                                    id="battery_make" name="cust_sec_file">
                                            </div>
                                            <div class="col-12 text-center">
                                                <button class="btn btn-primary form-control-sm mt-2" type="submit"
                                                    id="callFunctionBtn">Save & Next</button>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
        <div class="col-4">
            <a href="{{ route('e-trucks.buyerdetail.index') }}" class="btn btn-warning">Back</a>
        </div>
    </div>

    </div>
    <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
    @include('partials.js.pincode')
    @include('partials.trucks.single_user')

    {!! JsValidator::formRequest('App\Http\Requests\TruckBuyerDetailRequest', '.modelcreate') !!}
@endpush
