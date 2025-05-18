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
                                            <label class="form-label" for="manu_date">Gross Weight (in Tons):</label>
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
                                                <label class="form-label">Gross Vehicle Weight (GVW):</label>
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
    <script>
        let usedCdData = [];

        // vinChassis detail from production data
        function getProjectCode() {

            $(".srchV").val('');

            var val = document.getElementById("vin").value;
            var oemid = document.getElementById("oem_id").value;

            var token = $("input[name='_token']").val();
            // console.log(val,oemid,token);
            $.ajax({
                url: '/e-trucks/vin/getcode/' + val + '/' + oemid,

                method: 'GET',

                success: function(response) {
                    console.log(response);
                    // alert('h');
                    // console.warn(response.data1[0].manufacturing_date);
                    // console.log(response.data2 == 1,response.data1.length,response.data1[0].manufacturing_date,response.data1 == 'Sold',response.data1,response,response.data4 == true);
                    if (response.data2 == 1) {
                        alert('Vehicle with this VIN no is already sold')
                        $('#sh_vehicle').val();
                        $('#xevmdl').val();
                        $('#modl_vrnt').val();
                        $('#segment').val();
                        $('#ex_price').val();
                        $('#manufacturing_date').val();
                        $('#tot_adm_inc_amt').val();
                        $('#addmi_inc_amt').val();
                        $('#gross_weight').val();

                    } else if (response.data1.length == 0) {
                        $('#vin').val();
                        alert('Please enter correct VIN no')

                    } else if (response.data1[0].manufacturing_date) {
                        let manufacturingDate = new Date(response.data1[0].manufacturing_date);
                        let startDate = new Date('2024-04-01');
                        let endDate = new Date('2026-03-31');

                        if (manufacturingDate >= startDate && manufacturingDate <= endDate) {
                            if (response.data4 == true) {
                                //console.log(response.data5 ? response.data6 : '')
                                $('#prd_id').val(response.data1[0].id);
                                $('#seg_id').val(response.data1[0].segment_id);
                                $('#sh_vehicle').val(response.data1[0].vehicle_cat);
                                $('#xevmdl').val(response.data1[0].model_name);
                                $('#modl_vrnt').val(response.data1[0].variant_name);
                                $('#segment').val(response.data1[0].segment);
                                $('#ex_price').val(response.data1[0].factory_price);
                                $('#manufacturing_date').val(response.data1[0].manufacturing_date);
                                $('#gross_weight').val(response.data1[0].gross_weight);
                                $('#tot_adm_inc_amt').val(response.data3);
                                $('#addmi_inc_amt').val(response.data3);
                                $('#permanent_reg_no').val(response.data5);
                                //$('#permanent_reg_dt').val(response.data6);
                                $('#permanent_reg_dt').val(response.data5 ? response.data6 : '');
                                $('#temp_reg_no').val(response.data7);
                                $('#temp_reg_dt').val(response.data8);
                            }
                            // } else {
                            //     //  if (response.data1[0].vehicle_cat === 'L5' && response.data4 == false) {
                            //     //     alert('Unable to fetch vahan details. Please try again.');
                            //     // } else {
                            //         alert('Vahan Details not found');

                            //         $('#prd_id').val(response.data1[0].id);
                            //         $('#seg_id').val(response.data1[0].segment_id);
                            //         $('#sh_vehicle').val(response.data1[0].vehicle_cat);
                            //         $('#xevmdl').val(response.data1[0].model_name);
                            //         $('#modl_vrnt').val(response.data1[0].variant_name);
                            //         $('#segment').val(response.data1[0].segment);
                            //         $('#ex_price').val(response.data1[0].factory_price);
                            //         $('#manufacturing_date').val(response.data1[0].manufacturing_date);
                            //         $('#tot_adm_inc_amt').val(response.data3);
                            //         $('#addmi_inc_amt').val(response.data3);
                            //         $('#permanent_reg_no').val(response.data5);
                            //         //$('#permanent_reg_dt').val(response.data6);
                            //         $('#permanent_reg_dt').val(response.data5 ? response.data6 : '');
                            //         $('#temp_reg_no').val(response.data7);
                            //         $('#temp_reg_dt').val(response.data8);

                            //     // };

                            // }

                        } else {
                            alert('The manufacturing date is not between 1 October 2024 and 31 March 2026');
                        }
                    } else if (response.data1 == 'Sold') {
                        $('#vin').val('');
                        alert('Vehicle with this VIN no is already sold in EMPS')
                    } else {
                        $('#prd_id').val(response.data1[0].id);
                        $('#seg_id').val(response.data1[0].segment_id);
                        $('#sh_vehicle').val(response.data1[0].vehicle_cat);
                        $('#xevmdl').val(response.data1[0].model_name);
                        $('#modl_vrnt').val(response.data1[0].variant_name);
                        $('#segment').val(response.data1[0].segment);
                        $('#ex_price').val(response.data1[0].factory_price);
                        $('#manufacturing_date').val(response.data1[0].manufacturing_date);
                        $('#tot_adm_inc_amt').val(response.data3);
                        $('#addmi_inc_amt').val(response.data3);
                        $('#permanent_reg_dt').val(response.data5 ? response.data6 : '');
                        $('#temp_reg_no').val(response.data7);
                        $('#temp_reg_dt').val(response.data8);
                    }
                }
            });
        }

        // invoice amt calculation
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

        // button text change
        $('#cstm_typ').on('change', function() {
            var val = $(this).val();
            if (val !== '1') {
                callFunctionBtn.innerHTML = 'Save & Next';
                $('.nonInv').show();
                $('.customer-info').show();
            } else {
                callFunctionBtn.innerHTML = 'Generate Customer ID';
                $('.nonInv').hide();
                $('.customer-info').hide();
            }
        });

        let cdIndex = 1;

        $('#add_multi_cdn').on('click', function() {
            cdIndex++;
            let newRow = `
    <div class="row border p-3 mb-3 cd-block" data-index="${cdIndex}">
        <div class="col-4 mb-3 cd-entry">
            <label class="form-label">CD Number</label>
            <div class="row">
                <div class="col-md-6">
                    <input class="form-control cdnumber-input" name="data[${cdIndex}][cdnumber]">
                    <input type="hidden" name="data[${cdIndex}][production_id]" class="prod_id" />
                    <input type="hidden" name="data[${cdIndex}][segment_id]" />
                    <input type="hidden" name="data[${cdIndex}][tot_adm_inc_amt]" />
                </div>
                <div class="col-md-6">
                    <button type="button" class="btn btn-primary btn-sm p-2 fetch-cd-btn" data-index="${cdIndex}">Fetch CD Data</button>
                </div>
            </div>
        </div>

        <div class="col-4 mb-3">
            <label class="form-label">CD Owner Name:</label>
            <input class="form-control readonly" name="data[${cdIndex}][cd_owner_name]" readonly>
        </div>

        <div class="col-4 mb-3">
            <label class="form-label">Gross Vehicle Weight (GVW):</label>
            <input class="form-control readonly" name="data[${cdIndex}][gvw]" readonly>
        </div>

        <div class="col-4 mb-3">
            <label class="form-label">VIN/Chassis Number:</label>
            <input class="form-control readonly" name="data[${cdIndex}][vin_no]" readonly>
        </div>

        <div class="col-4 mb-3">
            <label class="form-label">Status Flag:</label>
            <input class="form-control readonly" name="data[${cdIndex}][status]" readonly>
        </div>

        <div class="col-4 mb-3">
            <label class="form-label">CD – Issue Date:</label>
            <input class="form-control readonly" name="data[${cdIndex}][cd_issue_date]" readonly>
        </div>

        <div class="col-4 mb-3">
            <label class="form-label">CD - Validity Upto Date:</label>
            <input class="form-control readonly" name="data[${cdIndex}][cd_validation_date]" readonly>
        </div>

        <div class="col-4 mt-4">
            <button type="button" class="btn btn-danger btn-sm remove-cd-btn">Remove</button>
        </div>
    </div>`;

            $('#cd-inputs-wrapper').append(newRow);
        });


        // let usedCdData = [];

        $(document).on('click', '.fetch-cd-btn', function() {
            let index = $(this).data('index');
            let cdNumber = $(`[name="data[${index}][cdnumber]"]`).val()?.trim();

            if (!cdNumber) {
                alert('Please enter a CD number.');
                return;
            }

            // Check if CD number already used
            if (usedCdData.some(entry => entry.cdNumber === cdNumber)) {
                alert('This CD number has already been used.');
                return;
            }

            $.ajax({
                url: `/e-trucks/get_cd_data/${cdNumber}`,
                type: 'GET',
                success: function(response) {
                    if (response.error) {
                        swal.fire('Error', response.error, 'error');
                    } else {
                        // Fill in the form fields
                        $(`[name="data[${index}][cd_owner_name]"]`).val(response.present_owner_name ||
                            '');
                        $(`[name="data[${index}][gvw]"]`).val(response.vehicle_gvw || '');
                        $(`[name="data[${index}][vin_no]"]`).val(response.scrapped_vin || '');
                        $(`[name="data[${index}][status]"]`).val(response.status_flag || '');
                        $(`[name="data[${index}][cd_issue_date]"]`).val(response.issue_date || '');
                        $(`[name="data[${index}][cd_validation_date]"]`).val(response.valid_upto_date ||
                            '');

                        // Add full data to the array
                        usedCdData.push({
                            cdNumber: cdNumber,
                            index: index,
                            data: {
                                cd_owner_name: response.present_owner_name || '',
                                gvw: response.vehicle_gvw || '',
                                vin_no: response.scrapped_vin || '',
                                status: response.status_flag || '',
                                cd_issue_date: response.issue_date || '',
                                cd_validation_date: response.valid_upto_date || ''
                            }
                        });

                        const totalGvw = usedCdData.reduce((sum, entry) => {
                            const gvw = parseFloat(entry.data.gvw);
                            return sum + (isNaN(gvw) ? 0 : gvw);
                        }, 0);

                        console.log('usedCdData:', usedCdData);
                        console.log('Total GVW:', totalGvw);

                        // Store cdNumber as attribute for future removal reference
                        $(`[name="data[${index}][cdnumber]"]`).attr('data-used-cd', cdNumber);
                    }
                },
                error: function(xhr) {
                    alert("AJAX Error: " + xhr.responseText);
                }
            });
        });

        // Remove specific row and update usedCdData
        $('#cd-inputs-wrapper').on('click', '.remove-cd-btn', function() {
            let $block = $(this).closest('.cd-block');
            let $cdInput = $block.find('[name^="data["][name$="[cdnumber]"]');
            let cdNumber = $cdInput.attr('data-used-cd');

            if (cdNumber) {
                usedCdData = usedCdData.filter(entry => entry.cdNumber !== cdNumber);
            }

            $block.remove();
        });




        $(document).ready(function() {
            $('.prevent-multiple-submit').on('submit', function() {
                $(this).find('button[type="submit"]').prop('disabled', true);
                var buttons = $(this).find('button[type="submit"]');
                setTimeout(function() {
                    buttons.prop('disabled', false);
                }, 20000); // 25 seconds in milliseconds
            });

        });

        // date check of invoice and registration
        function validateDates() {
            var manu_date = new Date($("#manufacturing_date").val());
            var invoiceDate = new Date($("#invoice_dt").val());
            var vehicleDate = new Date($("#vihcle_dt").val());
            var category = $('#sh_vehicle').val();

            if (invoiceDate < manu_date) {
                alert("Invoice date is less than manufacturing date");
                $("#invoice_dt").val("");
                $("#vihcle_dt").val("");
            }
            if (invoiceDate > vehicleDate) {
                alert("Invoice date cannot be greater than vehicle registration date");
                $("#invoice_dt").val("");
                $("#vihcle_dt").val("");
            }

            // if (category == 'L5') {
            //     var selectedDate = $('#invoice_dt').val();
            //     var inputDate = new Date(selectedDate);
            //     var comparisonDate = new Date('2024-11-08');

            //     if (inputDate >= comparisonDate) {
            //         alert('Vehicle count limit exceded');
            //         $("#invoice_dt").val("");
            //     }

            // }
        }
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\TruckBuyerDetailRequest', '.modelcreate') !!}
@endpush
