@extends('layouts.e_truck_dashboard_master')
@section('title')
Dealer- Buyer Information
@endsection

@push('styles')
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
                    <h4 class="mb-2">Buyer Details</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <input type="hidden" name='oem_id' id="oem_id" value="{{ Auth::user()->oem_id }}">
        <input type="hidden" name='dealer_id' value="{{ $user->id }}">
        <input type="hidden" value="{{ $bankDetail->segment_id }}" class="form-control" id="seg_id" name="segment_id">
        <input type="hidden" name='production_id' value="{{ $bankDetail->production_id }}" id="prd_id">
        <div class="row">
            <div class="col-sm-12">
                <div class="card height-equal">
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <label class="form-label" for="oem_name">OEM Name</label>
                                    <input class="form-control readonly" readonly value=" {{ $bankDetail->oem_name }}"
                                        name="oem_name" id="oem_name" type="text">
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label" for="ev_model_name">Dealer Name:</label>
                                    <input class="form-control readonly" readonly value="{{ $bankDetail->dealer_name }}"
                                        id="ev_model_name" type="text" name="dlr_name">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="dealer">Dealer code</label>
                                    <input class="form-control readonly" readonly id="dealer" readonly type="text"
                                        id="dealer" value="{{ $bankDetail->dealer_code }}" name="dlr_code">
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
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <label class="form-label" for="vehicle_segment">VIN Number</label>
                                    <div class="row">
                                        <div class="col-md-12"><input class="form-control readonly" readonly
                                                id="vin_number" name="" value="{{ $bankDetail->vin_chassis_no }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
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
                                    <input type="date" class="form-control srchV readonly"
                                        value="{{ date('Y-m-d', strtotime($bankDetail->manufacturing_date)) }}" id=""
                                        name="manufacturing_date" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card height-equal">
                        <div class="card-header">
                            <h4>Customer Details</h4>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                @php
                                    if ($bankDetail->custmr_typ == 1) {
                                        $col = 'col-4';
                                        $style = 'display:block';
                                    } else {
                                        $col = 'col-3';
                                        $style = 'display:none';
                                    }
                                @endphp
                                <div class="{{ $col }} mb-3">
                                    <label class="form-label" for="vehicle_segment">Customer
                                        Type/Category:</label>
                                    <input type="text" class="form-control readonly" id="cstm_typ" name="custmr_typ"
                                        value="{{ $bankDetail->custmr_typ == 1
    ? 'Individual Cases'
    : ($bankDetail->custmr_typ == 2
        ? 'Proprietory Firms/Agencies'
        : ($bankDetail->custmr_typ == 3
            ? 'Corporate And Partnership Agencies'
            : '')) }}" readonly>
                                </div>
                                <div class="{{ $col }} mb-3" id="">
                                    <label class="form-label">Customer Name as per <span
                                            style="color: blue;">Invoice</span>:</label>
                                    <input type="text" class="form-control readonly" id="custmr_name" name="custmr_name"
                                        value="{{ $bankDetail->custmr_name }}" readonly>
                                </div>
                                <div class="{{ $col }} mb-3" id="" style="{{ $style }}">
                                    <label class="form-label">Customer Name as per <span
                                            style="color: green;">Aadhaar:</span></label>
                                    <input type="text" class="form-control readonly" id="addhar_name" name="addhar_name"
                                        value="{{ $bankDetail->adhar_name }}" readonly>
                                </div>
                                <div class="{{ $col }} mb-3" id="">
                                    <label class="form-label" for="Email">Email Id:</label>
                                    <input class="form-control readonly" id="Email" type="text" name="email"
                                        value="{{ $bankDetail->email }}" readonly>
                                </div>
                                <div class="{{ $col }} mb-3" @if ($bankDetail->custmr_typ != 1) disabled @endif>
                                    <div class="form-group">
                                        <label for="gen">Gender:</label>
                                        <input type="text" class="form-control readonly" readonly id="gen" name="gender"
                                            value="{{ $bankDetail->gender == 'M' ? 'Male' : ($bankDetail->gender == 'F' ? 'Female' : ($bankDetail->gender == 'O' ? 'Other' : '')) }}"
                                            placeholder="Enter Male, Female, or Other">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 customer-info">
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>Customer Address Detail</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="Address">Address:</label>
                                        <input class="form-control readonly" readonly type="text" id="add"
                                            value="{{ str_replace('null', '', $bankDetail->add) }}" name="add">
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="Landmark">Landmark:</label>
                                        <input class="form-control readonly" readonly type="text" id="Landmark"
                                            name="landmark" value="{{ $bankDetail->landmark }}">
                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="Pincode">Pincode:</label>
                                        <input class="form-control readonly" readonly type="text" name="Pincode"
                                            placeholder=" Pincode" value="{{ $bankDetail->pincode }}"
                                            onkeyup="citydata(this.value)">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="State">State:</label>
                                        <input class="form-control readonly" type="text" name="State"
                                            value="{{ $bankDetail->state }}" placeholder=" State" id="OEMAddState0"
                                            readonly>
                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="District">District:</label>
                                        <input class="form-control readonly" type="text" name="District"
                                            value="{{ $bankDetail->district }}" placeholder="District"
                                            id="OEMAddDistrict0" readonly>
                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="City">City:</label>
                                        <input class="form-control readonly" type="text" name="District"
                                            value="{{ $bankDetail->city }}" placeholder="District" id="OEMAddDistrict0"
                                            readonly>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="mobile">Mobile Number:</label>
                                        <input class="form-control readonly" type="number" id="mobile" name="mobile"
                                            value="{{ $bankDetail->mobile }}" readonly>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" id="dateLabel" for="dob">Date of
                                            Birth:</label>
                                        <input class="form-control readonly" readonly type="date" name="dob"
                                            value="{{ date('Y-m-d', strtotime($bankDetail->dob)) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card height-equal">
                        <div class="card-header d-flex align-items-center justify-content-between">
                                <h4>Invoice Detail</h4>
                                <button id="update_incentive" class="btn btn-primary" type="button">Update Incentive
                                    Amount</button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="range">Dealer Invoice No.:</label>
                                        <input class="form-control readonly" readonly id="range" type="text"
                                            value="{{ $bankDetail->dlr_invoice_no }}" name="dlr_invoice_no">
                                        <span class="text-primary">As mentioned invoice copy</span>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="invoice_dt">
                                            Dealer Invoice Date:</label>
                                        <input class="form-control readonly" readonly id="invoice_dt" type="date"
                                            value="{{ date('Y-m-d', strtotime($bankDetail->invoice_dt)) }}"
                                            name="invoice_dt">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Invoice Amount(INR)(per vehicle):</label>
                                        <input class="form-control readonly" readonly id="invoice_amt" type="number"
                                            value="{{ $bankDetail->invoice_amt }}" name="invoice_amt">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Admissible Incentive Amount(INR)(per
                                            vehicle):</label>
                                        <input class="form-control readonly" id="addmi_inc_amt" type="number"
                                            value="{{ $bankDetail->addmi_inc_amt }}" readonly name="addmi_inc_amt">
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
                                        <span class="text-primary">Amount after deduction of PM E-DRIVE
                                            Incentive</span>
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
                            <div class="card-body">
                                <div class="row">
                                    @if ($bankDetail->custmr_typ != 1)
                                        <div class="col-4 mb-3 ">
                                            <label class="form-label" for="battery_cat_repulsion">Customer
                                                Id:*</label>
                                            <input class="form-control readonly" readonly id="adhar_no" type="text"
                                                value="{{ $cat->name }}" name="custmr_id_no">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Customer Id No.:</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input class="form-control readonly" readonly id="adhar_no" type="text"
                                                        value="{{ $bankDetail->custmr_id_no }}" name="custmr_id_no">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" id="cust_id_label">Customer Id copy:</label>
                                            <br>
                                            <a class="btn btn-success btn-sm" id="cut_id_doc_1"
                                                href="{{ route('doc.down', encrypt($bankDetail->copy_file_uploadid)) }}">
                                                <i class="fa fa-download"></i> View Certificate
                                            </a>
                                        </div>
                                    @endif
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Additional Customer Id:</label>
                                        <input class="form-control readonly" readonly id="total_energy_capacity"
                                            type="text" value="{{ $type->name }}" name="cust_id_sec">

                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Additional Customer Id No.:</label>
                                        <input class="form-control readonly" readonly id="total_energy_capacity"
                                            type="text" value="{{ $bankDetail->cust_id_sec }}" name="cust_id_sec">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Additional Customer Id copy:</label><br>
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($bankDetail->sec_file_uploadeid)) }}">
                                            <i class="fa fa-download"></i> View Document
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('e-trucks.ack.update', $bankDetail->id) }}" role="form" method="POST"
        class='form-horizontal modelcreate' files=true enctype='multipart/form-data' id="model_create"
        accept-charset="utf-8">
        @csrf
        @method('patch')

        <!-- <div class="card height-equal">
            <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;">
                <h4>Vehicle Details:</h4>
                @if(!$bankDetail->vhcl_regis_no)
                    <button type="button" id="fetch_rc_details" class="btn btn-info">Fetch RC Details</button>
                @endif
            </div>
            <div class="card-body">
                <input type="hidden" id="formAction" name="formAction">
                <div class="row">
                    <div class="col-3 mb-3">
                        <label class="form-label" for="temp_reg">Temporary Registration Number</label>
                        <input type="text" class="reg_num form-control readonly" id="temp_reg"
                            value="{{ $bankDetail->temp_reg_no }}" readonly>
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label" for="vhcl_regis_no">Permanent Registration
                            Number:</label>
                        <input class="reg_num form-control  readonly" id="vhcl_regis_no" type="text"
                            name="vhcl_regis_no" value="{{ $bankDetail->vhcl_regis_no }}" readonly>
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label" for="vihcle_dt">Permanent Registration Date:</label>
                        <input class="form-control readonly" id="vihcle_dt" type="text"
                            value="{{ $bankDetail->vihcle_dt ? date('Y-m-d', strtotime($bankDetail->vihcle_dt)) : '' }}"
                            onchange="validateDates()" name="vihcle_dt" readonly>
                    </div>


                    <div class="col-3 mb-3">
                        <label class="form-label" for="vhcl_reg_file">Permanent Registration Copy:</label>
                        <input class="form-control" id="vhcl_reg_file" type="file" name="vhcl_reg_file">

                        @if ($bankDetail->vhcl_reg_file != null)
                            <a class="btn btn-success btn-sm"
                                href="{{ route('doc.down', encrypt($bankDetail->vhcl_reg_file)) }}">
                                <i class="fa fa-download"></i> View Document
                            </a>
                        @endif

                    </div>
                    @if($bankDetail->vhcl_regis_no || $bankDetail->temp_reg_no)
                        <div class="col-12">
                            <a target="_blank" href="{{ route('dealer.view_certificate', encrypt($bankDetail->buyer_id)) }}"
                                class="btn btn-success form-control-sm mt-2">Generate &
                                download E-Voucher</a>
                        </div>
                    @endif
                </div>
            </div>
        </div> -->

        <div class="card height-equal">
            <div class="card-header" style="display:flex;align-items:center;justify-content:space-between;">
                <h4>Vehicle Details:</h4>
                {{-- @if($bankDetail->vahanavailable == 'N' || $bankDetail->vahanavailable == Null) --}}
                    <button type="button" id="fetch_rc_details" class="btn btn-info">Fetch RC Details</button>
                {{-- @endif --}}
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-3 mb-3">
                    <input type="hidden" id="formAction" name="formAction">
                    <input type="hidden" id="vin" name="vin">
                        <label class="form-label" for="temp_reg">Temporary Registration<br> Number</label>
                        <input data-target="temp_reg" type="text"
                            class="reg_num form-control {{ $bankDetail->temp_reg_no ? 'readonly' : '' }}" {{ $bankDetail->temp_reg_no ? 'readonly' : '' }} id="temp_reg" name="temp_reg"
                            value="{{ $bankDetail->temp_reg_no }}">
                        <span style="display: none" id="temp_reg_error" class="text-danger">Please enter
                            a valid Temporary Registration Number</span>
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label" for="vhcl_regis_no">Permanent Registration<br> Number:</label>
                        <input data-target="perm_reg"
                            class="reg_num form-control {{ $bankDetail->vhcl_regis_no ? 'readonly' : '' }}" {{ $bankDetail->vhcl_regis_no ? 'readonly' : '' }} id="vhcl_regis_no" type="text"
                            name="vhcl_regis_no" value="{{ $bankDetail->vhcl_regis_no }}">
                        <span style="display:none" id="perm_reg_error" class="text-danger">Please enter a
                            valid Permanent Registration Number</span>
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label" for="vihcle_dt">Permanent Registration<br> Date:</label>
                        <input class="form-control {{ $bankDetail->vihcle_dt ? 'readonly' : '' }}" {{ $bankDetail->vihcle_dt ? 'readonly' : '' }} id="vihcle_dt" type="text"
                            value="{{ $bankDetail->vihcle_dt }}" onchange="validateDates()" name="vihcle_dt">
                    </div>

                    <div class="col-3 mb-3">
                        <label class="form-label" for="vhcl_reg_file">Permanent Registration<br> Copy:</label>
                        @if($bankDetail->vhcl_reg_file ==Null)
                        <input class="form-control" id="vhcl_reg_file" type="file" name="vhcl_reg_file">
                        @endif
                        @if($bankDetail->vhcl_reg_file !=Null)
                        <a class="btn btn-success btn-sm"
                            href="{{ route('doc.down', encrypt($bankDetail->vhcl_reg_file)) }}">
                            <i class="fa fa-download"></i> View Document
                        </a>
                        @endif

                    </div>
                    <div div class="col-5 mb-3" id="e_voucher_div" style="display: none;">
                        <button id="e_voucher_btn" class="btn btn-success form-control-sm mt-2">Generate &
                            download E-Voucher</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card height-equal">
            <div class="card-header">
                <h4>Document Upload:</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-3 mb-3">
                        <label class="form-label" for="cust_acknwldge">Customer Acknowledgement:</label>
                        <input class="form-control docs_upload" data-target="ack" id="cust_acknwldge" type="file"
                            name="cst_ack_file">
                        <span class="text-primary">Upload Signed & Stamped Customer Acknowledgement
                            Form.</span>
                        @if ($bankDetail->cst_ack_file != null)
                            <a class="btn btn-success btn-sm"
                                href="{{ route('doc.down', encrypt($bankDetail->cst_ack_file)) }}">
                                <i class="fa fa-download"></i> View Document
                            </a>
                        @endif
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label" for="invoice_copy">
                            Invoice Copy:</label>
                        <input class="form-control docs_upload" data-target="invc" id="invoice_copy" type="file"
                            name="invc_copy_file">
                        <br>
                        @if ($bankDetail->invc_copy_file != null)
                            <a class="btn btn-success btn-sm"
                                href="{{ route('doc.down', encrypt($bankDetail->invc_copy_file)) }}">
                                <i class="fa fa-download"></i> View Document
                            </a>
                        @endif
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label" for="e_voucher_copy">
                            E-Voucher Copy:</label>
                        <input class="form-control docs_upload" data-target="evoucher" id="e_voucher_copy" type="file"
                            name="evoucher_copy_file">

                        <span class="text-primary">upload Signed & Stamped E-Voucher</span>
                        @if ($bankDetail->evoucher_copy_id != null)
                            <a class="btn btn-success btn-sm"
                                href="{{ route('doc.down', encrypt($bankDetail->evoucher_copy_id)) }}">
                                <i class="fa fa-download"></i> View Document
                            </a>
                        @endif
                    </div>
                    <div class="col-3 mb-3">
                        <label class="form-label" for="customer_selfie_copy">
                            Customer selfie Copy:</label>
                        <input class="form-control docs_upload" data-target="selfie" id="customer_selfie_copy"
                            type="file" name="selfi_copy_file">
                        <br>
                        @if ($bankDetail->self_copy_id != null)
                            <a class="btn btn-success btn-sm"
                                href="{{ route('doc.down', encrypt($bankDetail->self_copy_id)) }}">
                                <i class="fa fa-download"></i> View Document
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 text-center">
            <div class="d-flex justify-content-between mt-2">
                <div class="d-inline-block">
                    <a href="{{ route('e-trucks.buyerdetail.index') }}" class="btn btn-warning">Back</a>
                </div>
                <div class="text-center">
                        <a target="_blank" href="{{ route('e-trucks.ack.view', $bankDetail->id) }}"
                            class="btn btn-warning form-control-sm mt-2" id="acknowledgeButton"
                            @if ($bankDetail->status == 'S') disabled @endif>Print Acknowledge</a>
                    </div>
                <div class="d-inline-block">
                    <button type="button" class="btn btn-primary form-control-sm" id="updateBtn">Update</button>
                </div>
                <div class="d-inline-block">
                    <button type="button" class="btn btn-success form-control-sm" id="submitBtn" disabled>Submit to
                        OEM</button>
                </div>
            </div>
        </div>

    </form>

    <!-- Container-fluid Ends-->
</div>
@endsection
@push('scripts')
    @include('partials.js.pincode')
    {!! JsValidator::formRequest('App\Http\Requests\AckDocRequest', '.modelcreate') !!}
    <script>

$("#update_incentive").on("click", function() {
            let vin = document.getElementById("vin_number").value;
            let row_id = {{ $bankDetail->id }};
            let oemid = document.getElementById("oem_id").value;
            let invoice_amt = document.getElementById("invoice_amt").value;
            $.ajax({
                url: "{{ route('buyerdetail.update.incentive') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    vin,
                    row_id,
                    oemid,
                    invoice_amt
                },
                success: function(result) {
                    if (result.status == 0) {
                        $('#addmi_inc_amt').val(result.data.invt_amt);
                        $('#tot_adm_inc_amt').val(result.data.invt_amt);
                        $('#tot_inv_amt').val(result.data.net_amt);
                        $('#amt_custmr').val(result.data.net_amt);
                        Swal.fire(
                            '',
                            'Incentive amount updated successfully!',
                            'success'
                        );
                        return;
                    }
                    Swal.fire(
                        '',
                        'Something went wrong!',
                        'error'
                    );
                    console.error(result.msg);
 
                },
                error: function(err) {
                    Swal.fire(
                        '',
                        'Something went wrong!',
                        'error'
                    );
                    console.error(err);
                }
            })
        });

        $('#fetch_rc_details').on("click", function () {
            var vin = document.getElementById("vin_number").value;
            // var oemid = document.getElementById("oem_id").value;

            let reqData = {
                _token: "{{ csrf_token() }}", // CSRF token for security
                id: "{{ $id }}", // The ID of the record
                vin
            }
            var token = $("input[name='_token']").val();
            // console.log(val,oemid,token);
            $.ajax({
                url: "{{ route('update-temp-reg') }}", // Laravel route
                method: "POST",
                data: reqData,

                success: function (response) {
                    if ($('#vhcl_regis_no').val()) {
                        $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
                    }

                    if ($('#vihcle_dt').val()) {
                        $('#vihcle_dt').prop('readonly', true).addClass('readonly');
                    }

                    if ($('#temp_reg').val()) {
                        $('#temp_reg').prop('readonly', true).addClass('readonly');
                    }

                    // alert(response.status)
                if (response.status == false) {

                        Swal.fire(
                            'Warning',
                            response.message,
                            'error'
                        );

                        // Enable the fields for editing if the status is false
                        // $('#vhcl_regis_no').prop('readonly', false).removeClass('readonly');
                        // $('#vihcle_dt').prop('readonly', false).removeClass('readonly').attr('type', 'date');
                        // $('#temp_reg').prop('readonly', false).removeClass('readonly');

                        // Apply readonly and class if values exist
                        if ($('#vhcl_regis_no').val()) {
                            $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
                        }

                        if ($('#vihcle_dt').val()) {
                            $('#vihcle_dt').prop('readonly', true).addClass('readonly');
                        }

                        if ($('#temp_reg').val()) {
                            $('#temp_reg').prop('readonly', true).addClass('readonly');
                        }


                    } else if(response.status == true) {
                        Swal.fire(
                            '',
                            response.message,
                            'success'
                        );

                        // Set the values and keep the fields readonly
                        $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
                        $('#vihcle_dt').prop('readonly', false).removeClass('readonly').attr('type', 'text');
                        $('#temp_reg').prop('readonly', true).addClass('readonly');

                        // Set the values from the response
                        $('#vhcl_regis_no').val(response.prcn);
                        $('#vihcle_dt').val(response.prcndt);
                        $('#fetch_rc_details').hide();

                        //show voucher generation if the vahan details are fetched 
                        $('#e_voucher_div').show();

                    }else{
                        Swal.fire(
                            'Warning',
                            response.message,
                            'error'
                        );
                        
                        // Enable the fields for editing if the status is false
                        // $('#vhcl_regis_no').prop('readonly', false).removeClass('readonly');
                        // $('#vihcle_dt').prop('readonly', false).removeClass('readonly').attr('type', 'date');
                        // $('#temp_reg').prop('readonly', false).removeClass('readonly');

                        
                        $('#vhcl_regis_no').val('');
                        $('#vihcle_dt').val('');
                        // $('#temp_reg').val('');
                        
                        // Apply readonly and class if values exist
                if ($('#vhcl_regis_no').val()) {
                    $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
                }

                if ($('#vihcle_dt').val()) {
                    $('#vihcle_dt').prop('readonly', true).addClass('readonly');
                }

                if ($('#temp_reg').val()) {
                    $('#temp_reg').prop('readonly', true).addClass('readonly');
                }

    }
                }


            });
        });

        let filesObject = {};
        $(".docs_upload").on("change", function () {
            let target = this.getAttribute("data-target");
            const file = this.files[0];
            const fileType = file.type;

            if (this.files.length > 0 && fileType === 'application/pdf') {
                filesObject[target] = true;
            } else {
                filesObject[target] = false;
            }

            if (Object.keys(filesObject).length == 4) {
                let allValuesExist = true;
                $("#submitBtn").attr("disabled", true)
                for (const key in filesObject) {
                    if (!filesObject[key]) {
                        allValuesExist = false;
                        break;
                    }
                }

                if (allValuesExist) {
                    $("#submitBtn").removeAttr("disabled")
                }
            }
        })


        const formActionInput = document.getElementById('formAction');
        const vinInput = document.getElementById('vin');
        var vin = document.getElementById("vin_number").value;
        $(document).ready(function () {

        $('#vhcl_regis_no').prop('readonly', true).addClass('readonly');
        $('#vihcle_dt').prop('readonly', true).addClass('readonly');
        $('#temp_reg').prop('readonly', true).addClass('readonly');

            $('#submitBtn, #updateBtn').on('click', function () {
                // Check which button was clicked
                if (this.id === 'submitBtn') {
                    formActionInput.value = 'A'; // Set value for Submit
                    vinInput.value =vin; // Set value for Submit
                } else if (this.id === 'updateBtn') {
                    formActionInput.value = 'S'; // Set value for Update
                }

                $('#model_create').submit(); // Submit the form
            });
        });


        var isEvoucherShow = false;
            $('.reg_num').on('input', function(){
                const tempReg = this.value;
                const eVoucherDiv = document.getElementById('e_voucher_div');

                const tmp_regex = /^T[0-9]{4}[A-Z]{2}[0-9]{4}[A-Z]{1,2}$/;
                const prefix = tempReg.substring(0, 2);

                if (prefix === 'TR' || prefix === 'TG') {
        console.log('Prefix matches: ' + prefix);
        eVoucherDiv.style.display = 'none'; // Show the E-Voucher button
            submitBtn.disabled = false;
            document.getElementById("temp_reg_error").style.display = 'none';
            document.getElementById("perm_reg_error").style.display = 'none';
           
        return; 
    }

                let toShow = "";
    let toHide = "";

    if (tmp_regex.test(tempReg)) {
       
        if ($('#vhcl_regis_no').val().trim().length >= 9) {
            eVoucherDiv.style.display = 'block'; // Show the E-Voucher button
            submitBtn.disabled = false;
            document.getElementById("temp_reg_error").style.display = 'none';
            document.getElementById("perm_reg_error").style.display = 'none';
            return; 
        }
    } else {
        
        toShow = "temp_reg_error";
        toHide = "perm_reg_error";
    }

    if ($('#vhcl_regis_no').val().trim() && $('#vhcl_regis_no').val().trim().length < 9) {
        toShow = "perm_reg_error";
        toHide = "temp_reg_error";
    }

    document.getElementById(toShow).style.display = 'block';
    document.getElementById(toHide).style.display = 'none';
    submitBtn.disabled = true;
    eVoucherDiv.style.display = 'none';

            })

            // Add click event to the "View E-Voucher" button
            document.getElementById('e_voucher_btn').addEventListener('click', function() {
                event.preventDefault(); // Prevent the form from being submitted
                let isTempReg = false;
                let isPermReg = false;
                let notifyText = "This will lock the Temporary Registration Number field.";
                let target = "temp";
                let tempVal = 0;
                let permVal = 0;
                let buyer_id = {!! json_encode($bankDetail->buyer_id) !!};

                const tmp_regex = /^T[0-9]{4}[A-Z]{2}[0-9]{4}[A-Z]{1,2}$/;

                
                if(tmp_regex.test($('#temp_reg').val())){
                    isTempReg = true;
                    tempVal = $('#temp_reg').val().trim();
                }
                if($('#vhcl_regis_no').val().trim().length >= 9){
                    isPermReg = true;
                    notifyText = "This will lock the Permanent Registration Number field.";
                    target = "perm";
                    permVal = $('#vhcl_regis_no').val().trim();
                }

                if(isTempReg && isPermReg){
                    notifyText = "This will lock the Temporary & Permanent Registration Number field.";
                    target = "both";
                    tempVal = $('#temp_reg').val().trim();
                    permVal = $('#vhcl_regis_no').val().trim();
                }

                let reqData = {
                    _token: "{{ csrf_token() }}", // CSRF token for security
                    id: "{{ $id }}", // The ID of the record
                    target,
                    tempVal,
                    permVal,
                    buyer_id
                }

                
                Swal.fire({
                    title: 'Are you sure?',
                    text: notifyText,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Generate E-Voucher'
                }).then((result) => {
                    // return;
                    if (result.isConfirmed) {
                        const tempRegField = document.getElementById('temp_reg');
                        const permRegField = document.getElementById('vhcl_regis_no');

                        // Send AJAX request to update temp_reg in the database
                        $.ajax({
                            url: "{{ route('update-temp-reg') }}", // Laravel route
                            method: "POST",
                            data: reqData,
                            success: function(response) {
                                Swal.fire(
                                    'Locked!',
                                    response.message,
                                    'success'
                                );

                                if(target == "both"){
                                    permRegField.readOnly = true;
                                    permRegField.classList.add('readonly'); // Add readonly class

                                    tempRegField.readOnly = true;
                                    tempRegField.classList.add('readonly'); // Add readonly class
                                }else if(target == "perm"){
                                    permRegField.readOnly = true;
                                    permRegField.classList.add('readonly'); // Add readonly class

                                }else{
                                    tempRegField.readOnly = true;
                                    tempRegField.classList.add('readonly');
                                }

                                // Hide the "View E-Voucher" button after confirmation
                                document.getElementById('e_voucher_div').style.display = 'none';

                                // Open the route in a new tab/window
                                window.open(
                                    "{{ route('dealer.view_certificate', encrypt($bankDetail->buyer_id)) }}",
                                    '_blank');
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'There was an error updating the Registration Number.',
                                    'error'
                                );
                            }
                        });
                    }
                });


            });
    </script>
@endpush