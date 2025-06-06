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

            <form action="{{ route('buyerdetail.store') }}" role="form" method="POST"
                class='form-horizontal modelcreate prevent-multiple-submit' files=true enctype='multipart/form-data'
                id="model_create" accept-charset="utf-8">
                @csrf
                <input type="hidden" name='oem_id' id="oem_id" value="{{ Auth::user()->oem_id }}">
                <input type="hidden" name='dealer_id' value="{{ $user->id }}">

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



                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="card height-equal">
                                    <div class="card-header">
                                        <h4>Customer Information</h4>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">





                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="variant_name">Customer Name:</label>
                                                <input class="form-control" type="text" name="custmr_name"
                                                    id="custm_name">
                                                <span class="text-danger">As mentioned in Adhaar card</span>
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="variant_name">Address:</label>
                                                {{-- <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea> --}}
                                                <input class="form-control" type="text" id="add"
                                                    name="add">

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="variant_name">Landmark:</label>
                                                {{-- <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea> --}}
                                                <input class="form-control" id="variant_name" type="text"
                                                    id="variant_name" name="landmark">

                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="vehicle_segment">Pincode:</label>
                                                <input class="form-control" type="text" name="Pincode"
                                                    value="{{ old('Pincode') }}" placeholder=" Pincode"
                                                    onkeyup="GetCityByPinCode('OEM', this.value, 0)">
                                                <span id="OEMpincodeMsg0"
                                                    style="color:red;font-weight:bold;display: none">
                                                    @error('Pincode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="vehicle_segment">State:</label>
                                                <input class="form-control readonly" type="text" name="State"
                                                    value="{{ old('State') }}" placeholder=" State" id="OEMAddState0"
                                                    readonly>
                                                @error('State')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="District">District:</label>
                                                <input class="form-control readonly" type="text" name="District"
                                                    value="{{ old('District') }}" placeholder="District"
                                                    id="OEMAddDistrict0" readonly>
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
                                                <label class="form-label" for="email">Email Id:</label>
                                                <input class="form-control" id="email" type="text" id="email"
                                                    name="email">

                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="dob">Date Of Birth/Incorporation
                                                    Date:</label>
                                                <input class="form-control" type="date" id="dob"
                                                    name="dob">

                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="vehicle_segment">Customer
                                                    Type/Category:</label>
                                                <select class="form-select addEventListener" id="cstm_typ"
                                                    name="custmr_typ">
                                                    <option value="">Choose...</option>
                                                    <option selected="selected" disabled value="0">Select</option>
                                                    <option value="1">Individual Cases</option>
                                                    <option value="2">Proprietory Firms/Agencies</option>
                                                    <option value="3">Corporate And Partnership Agencies</option>
                                                    <option value="4">Gov. Department/Defence Supply</option>
                                                </select>

                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="vehicle_segment">Gender:</label>
                                                <select class="form-select addEventListener" id="gen"
                                                    name="gender">
                                                    <option value="">Choose...</option>
                                                    <option selected="selected" disabled value="0">Select</option>
                                                    <option value="M">Male</option>
                                                    <option value="F">Female</option>
                                                    <option value="O">Other</option>
                                                </select>

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
                                                <span class="text-danger">As mentioned invoice copy</span>

                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="invoice_dt">
                                                    Dealer Invoice Date:</label>
                                                <input class="form-control" id="invoice_dt" type="date"
                                                    value="" name="invoice_dt" min="{{ $minDate }}"
                                                    max="{{ $maxDate }}" onchange="validateDates()">

                                            </div>

                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="vihcle_dt">Vehicle
                                                    Registration Date:</label>
                                                <input class="form-control" id="vihcle_dt" type="date" value=""
                                                    name="vihcle_dt" min="{{ $minDate }}"
                                                    max="{{ $maxDate }}" onchange="validateDates()">

                                            </div>


                                            {{-- <div class="col-4 mb-3 ">
                                                <label class="form-label" for="minimax_speed">Amount Payable by Customer
                                                    (INR):</label>
                                                <input class="form-control" id="minimax_speed" type="number"
                                                    value="" name="amt_custmr">
                                                <span class="text-danger">Amount after deduction of {{ env('APP_NAME')}}-2024</span>
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Invoice Amount(INR)(per vehicle):</label>
                                                <input class="form-control" id="minimum_acceleration" type="number"
                                                    value="" name="invoice_amt">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Admissible Incentive Amount(INR)(per
                                                    vehicle):</label>
                                                <input class="form-control" id="minimum_acceleration" type="number"
                                                    value="" name="addmi_inc_amt">
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Total Invoice Amount(INR):</label>
                                                <input class="form-control" id="minimum_acceleration" type="number"
                                                    value="" name="tot_inv_amt">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Total Admissible Incentive Amount(INR):</label>
                                                <input class="form-control readonly" id="tot_adm_inc_amt" type="number"
                                                    value="" name="tot_admi_inc_amt" readonly>
                                            </div>


                                            <div class="col-12">
                                                <button class="btn btn-primary form-control-sm mt-2" type="submit"
                                                    id="callFunctionBtn" disabled>Save
                                                    as Draft</button>
                                            </div> --}}

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Invoice Amount(INR)(per vehicle):</label>
                                                <input class="form-control" id="invoice_amt" type="number"
                                                    value="" name="invoice_amt">
                                                <span id="error_msg" style="color: red; font-weight: bold;"></span>
                                            </div>

                                            <div class="col-md-4 mb-3">
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
                                                <span class="text-danger">Amount after deduction of {{ env('APP_NAME')}}-2024
                                                    Incentive</span>
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="discount">Discount Given</label>
                                                <select class="form-control" name="discount" id="discount"
                                                    onchange="addField()">
                                                    <option value="">Select</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <div class="col-4 mb-3" id="discountFieldContainer" style="display: none;">
                                                <label class="form-label" for="discountAmount">Discount Amount</label>
                                                <input type="number" class="form-control" name="discountAmount"
                                                    id="discountAmount" placeholder="Enter discount amount">
                                            </div>
                                            <div class="col-4 mb-3 " id="empField" style="display: none;">
                                                <label class="form-label" for="minimax_speed">{{ env('APP_NAME')}} 2024</label>
                                                <select class="form-control" name="empsBeforeAfter">
                                                    <option>Select</option>
                                                    <option value="Before">Before</option>
                                                    <option value="After">After</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-12" id="normalDiv">
                                <div class="card height-equal">
                                    <div class="card-header">
                                        <h4>Customer Identification Information:</h4>

                                    </div>
                                    <div class="card-body">
                                        <div class="row">


                                            <div class="col-4 mb-3 ">
                                                <label class="form-label" for="battery_cat_repulsion">Customer
                                                    Id:*</label>
                                                <select class="form-select" name="custmr_id"
                                                    onchange="chnInput(this.value)" id="cstmer_typ">
                                                    <option value="">Choose...</option>

                                                </select>
                                            </div>


                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Customer Id No.:</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input class="form-control" id="adhar_no" type="text"
                                                            value="" name="custmr_id_no">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a class="btn btn-primary" id="Clickadhr"
                                                            onclick="VerifyAdhar()">
                                                            Verify</a>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" id="cust_id_lable">Customer Id copy:</label>
                                                <input class="form-control" type="file" value="" id="cust_id"
                                                    name="custmr_file_copy">
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
                                            <div class="col-12" id="aadharConsent">
                                                <label class="form-label" for="aadhaarConsent">Aadhaar Consent</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="aadhaarConsent"
                                                        name="aadhaarConsent">
                                                    <span>I, the holder of Aadhaar number XXXXXXXXXX<span
                                                            id="aadhaarLastFour"></span>, hereby give my consent to
                                                        Ministry of Heavy Industry (MHI) to obtain my Aadhaar number, Name
                                                        and Fingerprint/Iris for authentication with UIDAI. Ministry of
                                                        Heavy Industry (MHI) has informed me that my identity information
                                                        would only be used for verification purposes and also informed that
                                                        my biometrics will not be stored/shared and will be submitted to
                                                        CIDR only for the purpose of authentication.</span>
                                                    <br><br><span>मैं आधार नंबर की धारक प्रमाणीकरण के लिए यूआईडीएआई के पास
                                                        मौज़ूद मेरा आधार नम्बर XXXXXXXXXX<span
                                                            id="aadhaarLastFour1"></span>,
                                                        नाम और फिंगर प्रिंट/आईरिस प्राप्त करने के लिए भारी उद्योग
                                                        मंत्रालय (एमएचआई) को एतद्द्वारा अपनी सहमति देती हूँ ।
                                                        भारी उद्योग मंत्रालय (एमएचआई) ने मुझे सूचित किया है कि मेरी
                                                        पहचान की जानकारी का उपयोग केवल ईएमपीएस-2024 के
                                                        तहत सत्यापन के उद्देश्य के लिए ही किया जाएगा और मुझे यह भी सूचित
                                                        किया गया है कि मेरे बायोमैट्रिक और केवाईसी विवरण
                                                        संग्रहीत / साझा नहीं किए जाएंगे और इन्हें केवल प्रमाणीकरण के
                                                        उद्देश्य के लिए सीडीआईआर को ही प्रस्तुत किए जाएंगे ।</span>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                                <button class="btn btn-primary form-control-sm mt-2" type="submit"
                                                    id="callFunctionBtn" disabled>Save
                                                    as Draft</button>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                    {{-- <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#exampleModal">Simple</button> --}}

            </form>

            <div class="modal fade" id="otpModal" tabindex="-1" role="dialog" aria-labelledby="otpModal"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modal-toggle-wrapper">

                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="otp">Enter OTP</label>
                                            <input type="text" id="otp" name="otp"
                                                placeholder="Enter Mobile OTP"
                                                class="form-control{{ $errors->has('otp') ? ' is-invalid' : '' }}"
                                                required>

                                            <span id="inc" class="text-danger">

                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-3 mt-2">
                                        <button type="button" onclick="verifyOtp()"
                                            class="btn btn-primary">Verify</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <a href="{{ route('buyerdetail.index') }}" class="btn btn-warning">Back</a>
        </div>
    </div>

    </div>
    <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
    @include('partials.js.pincode')
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}

    <script>
        function chnInput(val) {
            // alert(val);
            if (val == 1) {
                $('#Clickadhr').css("display", "block");
                $("#callFunctionBtn").prop("disabled", true);
                    $('#cust_id').css("display", "none");
                    $('#cust_id_lable').css("display", "none");
            } else {
                $('#Clickadhr').css("display", "none");
                $("#callFunctionBtn").prop("disabled", false);
                $('#cust_id').show();
                $('#cust_id_lable').show();
            }
        }

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


        function updateConsentText() {
            var aadhaarInput = document.getElementById('adhar_no').value;
            if (aadhaarInput.length === 12 && !isNaN(aadhaarInput)) {
                var lastFourDigits = aadhaarInput.slice(-4);
                document.getElementById('aadhaarLastFour').innerText = lastFourDigits;
                document.getElementById('aadhaarLastFour1').innerText = lastFourDigits;
            } else {
                document.getElementById('aadhaarLastFour').innerText = "XXXX";
                document.getElementById('aadhaarLastFour1').innerText = "XXXX";
            }
        }


        function verifyOtp() {
            var otp = $('#otp').val();
            $.ajax({
                url: '/verifybuyer/' + otp,
                method: 'GET',
                success: function(data) {
                    if (data == 1) {
                        // console.log(data);
                        alert('Mobile Verified Successfully');
                        $('#otpModal').modal('hide');
                    } else {
                        $('#inc').text('Invalid OTP'); // Display the error message
                        $('#otp').val(''); // Clear the OTP input field
                        $('#otpModal').modal('show');
                    }

                }
            });

        }

        $(document).ready(function() {
            $("#aadharConsent").hide();

            $(document).on('change', '#cstm_typ', function() {

                var stats = document.getElementById("OEMAddState0").value;
                let uniqueStats = Array.from(new Set(stats.split(',')));

                // alert(uniqueStats);
                // return;
                var val = $('#cstm_typ option:selected').val();

                if (val != 1) {
                    $("#gen").prop("disabled", true);
                    $("#gen").val('');
                    document.getElementById("Clickadhr").style.display = "none";
                    $("#callFunctionBtn").prop("disabled", false);
                    $("#aadharConsent").hide();

                } else {
                    $("#gen").prop("disabled", false);
                    document.getElementById("Clickadhr").style.display = "block";
                    $("#callFunctionBtn").prop("disabled", true);
                    $("#aadharConsent").show();


                }

                var token = $("input[name='_token']").val();

                $.ajax({
                    url: '/customer/type/' + val + '/' + uniqueStats,

                    method: 'GET',

                    // data: {

                    //     _token: token
                    // },
                    success: function(data) {
                        $('#cstmer_typ').empty();

                        // Append new options
                        $.each(data, function(index, option) {
                            //alert(option.id);
                            $('#cstmer_typ').append('<option value="' + option.id +
                                '"' + (option.id === 1 ? ' selected' : '') + '>' +
                                option.name + '</option>');


                            if (uniqueStats == 'ASSAM' && val == 1) {
                                $('#cust_id').css("display", "none");
                                $('#cust_id_lable').css("display", "none");
                            } else {
                                if (option.id == val) {
                                    $('#cust_id').hide();
                                    $('#cust_id_lable').hide();

                                } else {
                                    $('#cust_id').show();
                                    $('#cust_id_lable').show();
                                }
                            }


                        });

                    }
                });


            });



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



        });



        var customer = {};

        function VerifyAdhar() {

            var stats = document.getElementById("OEMAddState0").value;
            let uniqueStats = Array.from(new Set(stats.split(',')));

            var invoiceDt = new Date($("#invoice_dt").val());
            // alert(uniqueStats);
            // return;
            // console.log(invoiceDt);
            if (invoiceDt == 'Invalid Date') {
                alert('Please Select Invoice Date');
                return false;
            }

            updateConsentText();
            CustomerName = document.getElementById("custm_name").value;
            Adharno = document.getElementById("adhar_no").value;
            CustomerMobile = document.getElementById("mobile").value;
            segid = document.getElementById("seg_id").value;

            var lastFourDigits = Adharno.slice(-4);

            $.ajax({
                // url: '/check/adhar/' + CustomerName + '/' + lastFourDigits + '/' + segid,
                // type: "GET",
                url: '/check/adhar/' + CustomerMobile + '/' + lastFourDigits + '/' +
                segid, //mobile replace as place of name 18-07-2024
                type: "GET",

                success: function(response) {
                    // if (response.data[0].check_data_exists == true) {
                    if (response.data[0].check_data_exists_mobile == true) { //add 18-07-2024
                        $('#adhar_no').val('');
                        alert('You have already bought with this Aadhar');
                    } else {
                        // Aadhar number is not used, proceed with the second AJAX request
                        var customer = {
                            CustomerName: $('#custm_name').val(),
                            AadharNumber: $('#adhar_no').val()
                        };
                        var cust = {
                            CustomerName: $('#custm_name').val(),
                            AadharNumber: $('#adhar_no').val(),
                            Mobile: $('#mobile').val()
                        };
                        // var cust = $('#mobile').val();

                        $.ajax({
                            url: 'https://fame2uat.heavyindustries.gov.in/Services/DidmService.asmx/GetAadharDetails2',
                            method: 'POST',
                            data: '{CustomerDetails: ' + JSON.stringify(customer) + '}',
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",

                            success: function(response) {
                                var rep = response.d;
                                                cust.rep = rep;
                                                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                                $.ajax({
                                                url: '/aadhar_api_data',
                                                method: 'POST',
                                                contentType: 'application/json',
                                                data: JSON.stringify(cust),
                                                headers: {
                                                    'X-CSRF-TOKEN': csrfToken
                                                },
                                                success: function(response) {
                                                    console.log(response);
                                                }
                                            });
                                if (response.d.length != 72) {
                                    $('#adhar_no').val('');
                                    alert(response.d)
                                    // alert('Aadhar Name Mismatch')
                                } else {


                                    $.ajax({
                                        url: 'https://fame2uat.heavyindustries.gov.in/Services/DidmService.asmx/GetAadharDetailsMobile',
                                        method: 'POST',
                                        data: '{CustomerDetails2: ' + JSON.stringify(cust) +
                                            '}',
                                        contentType: "application/json; charset=utf-8",
                                        dataType: "json",
                                        success: function(response) {


                                            var rep = response.d;
                                                cust.rep = rep;
                                                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                                                $.ajax({
                                                url: '/aadhar_api_data',
                                                method: 'POST',
                                                contentType: 'application/json',
                                                data: JSON.stringify(cust),
                                                headers: {
                                                    'X-CSRF-TOKEN': csrfToken
                                                },
                                                success: function(response) {
                                                    console.log(response);
                                                }
                                            });
                                            // console.log(response.d);
                                            if (response.d.length != 72) {
                                                $('#adhar_no').val('');
                                                // alert(response.d)
                                                alert('Mobile not linked with Aadhar')
                                            } else {

                                                
                                               

                                                if (uniqueStats == 'ASSAM') {


                                                    if (new Date(invoiceDt) <=
                                                        new Date('2024-04-01') ||
                                                        new Date(
                                                            invoiceDt) >= new Date(
                                                            '2024-06-20')) {
                                                        $('#Clickadhr').addClass(
                                                                "disabled")
                                                            .text("Verified")
                                                            .removeClass("btn-primary")
                                                            .addClass("btn-warning");

                                                        $("#callFunctionBtn").prop(
                                                            "disabled",
                                                            false);
                                                        $('#adhar_no').prop('readonly',
                                                                true)
                                                            .addClass('readonly');
                                                        $('#custm_name').prop(
                                                                'readonly',
                                                                true)
                                                            .addClass('readonly');
                                                        $('#mobile').prop('readonly',
                                                                true)
                                                            .addClass('readonly');
                                                        var num = $('#mobile').val();
                                                        var otp = Math.floor(Math
                                                                .random() *
                                                                (
                                                                    999999 - 100000 + 1)
                                                                ) +
                                                            100000;
                                                        // var msg = 'One Time Passowrd(OTP) for Login: '+otp+' Do not share this OTP with anyone! IFCI Ltd';
                                                        $.ajax({
                                                            url: '/sendOtp/' +
                                                                num +
                                                                '/' + otp,
                                                            type: "GET",
                                                            success: function(
                                                                response) {
                                                                // Handle the response from the server
                                                                // console.log(response); // Log the response to the console
                                                                $('#otpModal')
                                                                    .modal({
                                                                        backdrop: 'static',
                                                                        keyboard: false
                                                                    });
                                                                $('#otpModal')
                                                                    .modal(
                                                                        'show'
                                                                        );

                                                            },

                                                        });
                                                    } else {
                                                        $('#Clickadhr').addClass(
                                                                "disabled")
                                                            .text("Verified")
                                                            .removeClass("btn-primary")
                                                            .addClass("btn-warning");

                                                        $("#callFunctionBtn").prop(
                                                            "disabled",
                                                            false);
                                                        $('#adhar_no').prop('readonly',
                                                                true)
                                                            .addClass('readonly');
                                                        $('#custm_name').prop(
                                                                'readonly',
                                                                true)
                                                            .addClass('readonly');
                                                        $('#mobile').prop('readonly',
                                                                true)
                                                            .addClass('readonly');
                                                    }
                                                } else if (new Date(invoiceDt) >=
                                                    new Date('2024-04-01') && new Date(
                                                        invoiceDt) <= new Date(
                                                        '2024-06-20')) {
                                                    $('#Clickadhr').addClass("disabled")
                                                        .text("Verified")
                                                        .removeClass("btn-primary")
                                                        .addClass("btn-warning");

                                                    $("#callFunctionBtn").prop(
                                                        "disabled",
                                                        false);
                                                    $('#adhar_no').prop('readonly',
                                                            true)
                                                        .addClass('readonly');
                                                    $('#custm_name').prop('readonly',
                                                            true)
                                                        .addClass('readonly');
                                                    $('#mobile').prop('readonly', true)
                                                        .addClass('readonly');
                                                } else if (uniqueStats == 'ASSAM' &&
                                                    new Date(invoiceDt) >= new Date(
                                                        '2024-04-01') && new Date(
                                                        invoiceDt) <= new Date(
                                                        '2024-06-20')) {
                                                    $('#Clickadhr').addClass("disabled")
                                                        .text("Verified")
                                                        .removeClass("btn-primary")
                                                        .addClass("btn-warning");

                                                    $("#callFunctionBtn").prop(
                                                        "disabled",
                                                        false);
                                                    $('#adhar_no').prop('readonly',
                                                            true)
                                                        .addClass('readonly');
                                                    $('#custm_name').prop('readonly',
                                                            true)
                                                        .addClass('readonly');
                                                    $('#mobile').prop('readonly', true)
                                                        .addClass('readonly');
                                                } else {

                                                    $('#Clickadhr').addClass("disabled")
                                                        .text("Verified")
                                                        .removeClass("btn-primary")
                                                        .addClass("btn-warning");

                                                    $("#callFunctionBtn").prop(
                                                        "disabled",
                                                        false);
                                                    $('#adhar_no').prop('readonly',
                                                            true)
                                                        .addClass('readonly');
                                                    $('#custm_name').prop('readonly',
                                                            true)
                                                        .addClass('readonly');
                                                    $('#mobile').prop('readonly', true)
                                                        .addClass('readonly');
                                                    var num = $('#mobile').val();
                                                    var otp = Math.floor(Math.random() *
                                                            (
                                                                999999 - 100000 + 1)) +
                                                        100000;
                                                    // var msg = 'One Time Passowrd(OTP) for Login: '+otp+' Do not share this OTP with anyone! IFCI Ltd';
                                                    $.ajax({
                                                        url: '/sendOtp/' + num +
                                                            '/' + otp,
                                                        type: "GET",
                                                        success: function(
                                                            response) {
                                                            // Handle the response from the server
                                                            // console.log(response); // Log the response to the console
                                                            $('#otpModal')
                                                                .modal({
                                                                    backdrop: 'static',
                                                                    keyboard: false
                                                                });
                                                            $('#otpModal')
                                                                .modal(
                                                                    'show');

                                                        },

                                                    });
                                                }


                                            }
                                        },
                                    })

                                }
                            },
                            error: function(xhr, status, error) {
                                console.error(error);
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }


        function toggleDiv() {
            var div = document.getElementById("xev");
            if (div.style.display === "none") {
                div.style.display = "block";
            } else {
                div.style.display = "none";
            }
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
                            $('#prd_id').val(responce.data1[0].id);
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
                            alert('The manufacturing date is not between 1 April 2024 and 30 September 2024');
                        }
                    } else {
                        // console.log(responce.data3);
                        $('#prd_id').val(responce.data1[0].id);
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

        function validateDates() {
            var manu_date = new Date($("#manufacturing_date").val());
            var invoiceDate = new Date($("#invoice_dt").val());
            var vehicleDate = new Date($("#vihcle_dt").val());
            //alert(vehicleDate);
            //alert(invoiceDate );

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
        }

        $("#invoice_dt, #vihcle_dt").change(validateDates);
    </script>
    {!! JsValidator::formRequest('App\Http\Requests\BuyerDetailRequest', '.modelcreate') !!}
@endpush
