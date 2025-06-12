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
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mb-2">Customer Detail</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <form action="{{ route('e-trucks.buyer.update', $bankDetail->id) }}" role="form" method="POST"
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
                                            <p style="margin-left: 20px;"><strong
                                                    class="text-danger">Instructions:</strong><span
                                                    class="right badge badge-danger"> New</span> <br></p>
                                            <div class="card-header">
                                                <p><strong>1.In case permanent RC is not available:</strong></p>
                                                <ul style="list-style-type: disc; margin-left: 20px;">
                                                    <li>If the Permanent RC details are not available, you can save the data
                                                        without RC details by clicking the <strong>Save</strong> button.
                                                    </li>
                                                    <li>The RC status will be marked as <strong>Pending</strong> until you
                                                        submit the RC details later.</li>
                                                    <li>For cross-verification, press the <strong>Update</strong> button to
                                                        upload the necessary documents.</li>
                                                    <li>Once the RC details are available, return to the form, fill in the
                                                        RC details, and click <strong>Submit</strong> to finalize the
                                                        submission with the complete RC information.</li>
                                                </ul>
                                            </div>

                                            <div class="card-header">
                                                <p><strong>2.In case permanent RC is Available:</strong></p>
                                                <ul style="list-style-type: disc; margin-left: 20px;">
                                                    <li>If you have the Permanent RC details, fill in the required
                                                        RC-related fields and attach the supporting document.</li>
                                                    <li>For cross-verification, press the <strong>Update</strong> button to
                                                        upload the required documents.</li>
                                                    <li>Once completed, click <strong>Submit</strong> to send the data to
                                                        the OEM along with the RC details.</li>
                                                </ul>
                                            </div>
                                            <div class="card-header">
                                                <p><strong>3.Important Note:</strong></p>
                                                <ul style="list-style-type: disc; margin-left: 20px;">
                                                    <li>Ensure that the supporting document copy is in PDF format and the
                                                        file size does not exceed 2 MB.</li>
                                                </ul>
                                            </div>
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
                                                <input class="form-control readonly" id="vin_number" name="vin"
                                                    value="{{ $bankDetail->vin_chassis_no }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Search Vehicle:</label>
                                            <input class="form-control srchV readonly" id="sh_vehicle"
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
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Gross Vehicle Weight (GVW in
                                                Tons):</label>
                                            <input class="form-control srchV readonly"
                                                value="{{ $prodDet->gross_weight }}" id="" name="gross_weight"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card height-equal">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>CD Information</h4>
                                    {{-- <button type="button" class="btn btn-info" id="add_multi_cdn">Add Row</button> --}}
                                </div>
                                <div class="card-body">
                                    <div class="vehicle_div">
                                        @foreach ($cdDet as $cd)
                                        <div class="row border p-3 cd-block" id="cd-inputs-wrapper">
                                                <div class="col-4 mb-3 cd-entry">
                                                    <label class="form-label">CD Number</label>
                                                    <input value="{{ $cd->cd_number }}"
                                                        class="form-control cdnumber-input readonly"
                                                        name="data[1][cdnumber]" readonly>
                                                </div>

                                                {{-- <div class="col-4 mb-3 cd-entry">
                                                    <label class="form-label">CD Number</label>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input value="{{ $cd->cd_number }}"
                                                                class="form-control cdnumber-input"
                                                                name="data[1][cdnumber]" >
                                                        </div>

                                                        <div class="col-md-6">
                                                            <button type="button"
                                                                class="btn btn-primary btn-sm p-2 fetch-cd-btn"
                                                                data-index="1">Fetch CD Data</button>
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                <div class="col-4 mb-3">
                                                    <label class="form-label">CD Owner Name:</label>
                                                    <input value="{{ $cd->cd_owner_name }}"
                                                        class="form-control readonly cd_owner_name"
                                                        name="data[1][cd_owner_name]" readonly>
                                                </div>

                                                <div class="col-4 mb-3">
                                                    <label class="form-label">Gross Vehicle Weight (GVW):</label>
                                                    <input value="{{ $cd->vehicle_gvw }}"
                                                        class="form-control readonly gvw" name="data[1][gvw]" readonly>
                                                </div>

                                                <div class="col-4 mb-3">
                                                    <label class="form-label">VIN/Chassis Number:</label>
                                                    <input value="{{ $cd->vin_scrapped }}"
                                                        class="form-control readonly vin_no" name="data[1][vin_no]"
                                                        readonly>
                                                </div>

                                                <div class="col-4 mb-3">
                                                    <label class="form-label">Status Flag:</label>
                                                    <input value="{{ $cd->status_flag }}"
                                                        class="form-control readonly status" name="data[1][status]"
                                                        readonly>
                                                </div>

                                                <div class="col-4 mb-3">
                                                    <label class="form-label">CD – Issue Date:</label>
                                                    <input value="{{ $cd->cd_issue_date }}"
                                                        class="form-control readonly cd_issue_date"
                                                        name="data[1][cd_issue_date]" readonly>
                                                </div>

                                                <div class="col-4 mb-3">
                                                    <label class="form-label">CD - Validity Upto Date:</label>
                                                    <input value="{{ $cd->cd_validity_upto }}"
                                                        class="form-control readonly cd_validation_date"
                                                        name="data[1][cd_validation_date]" readonly>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="card height-equal">
                                <div class="card-header">
                                    <h4>Customer Details</h4>

                                </div>
                                {{-- <div class="card-body">
                                    <div class="row">
                                        <div class="col-3 mb-3">
                                            <label class="form-label" for="vehicle_segment">Customer
                                                Type/Category:</label>
                                            <select class="form-select customer-type" id="cstm_typ" name="custmr_typ">
                                                <option selected="selected" disabled value="0">Select</option>
                                                @php
                                                    if ($bankDetail->custmr_typ == 1) {
                                                        $col = 'col-3';
                                                        $style = 'display:block';
                                                    } else {
                                                        $col = 'col-4';
                                                        $style = 'display:none';
                                                    }
                                                @endphp

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
                                        <div class="{{ $col }} mb-3" id="">
                                            <label class="form-label">Customer Name as per <span
                                                    style="color: blue;">Invoice</span>:</label>
                                            <input type="text" class="form-control" id="custmr_name"
                                                name="custmr_name" value="{{ $bankDetail->custmr_name }}">
                                        </div>
                                        <div class="{{ $col }} mb-3" id=""
                                            style="{{ $style }}">
                                            <label class="form-label">Customer Name as per <span
                                                    style="color: green;">Aadhaar:</span></label>
                                            <input type="text" class="form-control readonly" id="addhar_name"
                                                name="addhar_name" value="{{ $bankDetail->adhar_name }}" readonly>
                                        </div>
                                        <div class="{{ $col }} mb-3" id="">
                                            <label class="form-label" for="Email">Email Id:</label>
                                            <input class="form-control" id="Email" type="text" name="email"
                                                value="{{ $bankDetail->email }}">
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="card-body">
                                    <div class="row">
                                        @php
                                            if ($bankDetail->custmr_typ == 1) {
                                                $col = 'col-3';
                                                $style = 'display:block';
                                            } else {
                                                $col = 'col-4';
                                                $style = 'display:none';
                                            }
                                        @endphp
                                        <div class="{{ $col }} mb-3">
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
                                                @endif
                                            </select>
                                        </div>
                                        <div class="{{ $col }} mb-3" id="">
                                            <label class="form-label">Customer Name as per <span
                                                    style="color: blue;">Invoice</span>:</label>
                                            <input type="text" class="form-control" id="custmr_name"
                                                name="custmr_name" value="{{ $bankDetail->custmr_name }}">
                                        </div>
                                        <div class="{{ $col }} mb-3" id=""
                                            style="{{ $style }}">
                                            <label class="form-label">Customer Name as per <span
                                                    style="color: green;">Aadhaar:</span></label>
                                            <input type="text" class="form-control readonly" id="addhar_name"
                                                name="addhar_name" value="{{ $bankDetail->adhar_name }}" readonly>
                                        </div>
                                        <div class="{{ $col }} mb-3" id="">
                                            <label class="form-label" for="Email">Email Id:</label>
                                            <input class="form-control" id="Email" type="text" name="email"
                                                value="{{ $bankDetail->email }}">
                                        </div>
                                        <div class="{{ $col }} mb-3"
                                            @if ($bankDetail->custmr_typ != 1) disabled @endif>
                                            <div class="form-group">
                                                <label for="gen">Gender:</label>
                                                <input type="text" class="form-control readonly" readonly
                                                    id="gen" name="gender"
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
                                                <input class="form-control" type="text" id="add"
                                                    value="{{ str_replace('null', '', $bankDetail->add) }}"
                                                    name="add">
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
                                                    value="{{ date('Y-m-d', strtotime($bankDetail->dob)) }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-12">
                                <div class="card height-equal">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h4>Invoice Detail</h4>
                                            <button id="update_incentive" class="btn btn-primary" type="button">Update Incentive Ammount</button>
                                       </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="range">Dealer Invoice No.:</label>
                                                <input class="form-control" id="range" type="text"
                                                    value="{{ $bankDetail->dlr_invoice_no }}" name="dlr_invoice_no">
                                                <span class="text-primary">As mentioned invoice copy</span>
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="invoice_dt">
                                                    Dealer Invoice Date:</label>
                                                <input class="form-control" id="invoice_dt" type="date"
                                                    value="{{ date('Y-m-d', strtotime($bankDetail->invoice_dt)) }}"
                                                    name="invoice_dt" min="{{ $minDate }}"
                                                   max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" onchange="validateDates()">
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
                                                <span class="text-primary">Amount after deduction of PM E-DRIVE
                                                    Incentive</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div> --}}

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
                                                    <i class="fa fa-download"></i> View Document
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card height-equal">
                            <div class="card-header"
                                style="display:flex;align-items:center;justify-content:space-between;">
                                <h4>Vehicle Details:</h4>
                                {{-- @if ($bankDetail->vahanavailable == 'N' || $bankDetail->vahanavailable == null) --}}
                                <button type="button" id="fetch_rc_details" class="btn btn-info">Fetch RC
                                    Details</button>
                                {{-- @endif --}}
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="col-3 mb-3">
                                <label class="form-label" for="temp_reg">Temporary Registration<br> Number</label>
                                <input data-target="temp_reg" type="text"
                                    class="reg_num form-control {{ $bankDetail->temp_reg_no ? 'readonly' : '' }}" {{ $bankDetail->temp_reg_no ? 'readonly' : '' }}
                                    id="temp_reg" name="temp_reg" value="{{ $bankDetail->temp_reg_no }}" >
                                <span style="display: none" id="temp_reg_error" class="text-danger">Please enter
                                    a valid Temporary Registration Number</span>
                            </div> --}}
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="vhcl_regis_no">Permanent Registration<br>
                                            Number:</label>
                                        <input data-target="perm_reg"
                                            class="reg_num form-control {{ $bankDetail->vhcl_regis_no ? 'readonly' : '' }}"
                                            {{ $bankDetail->vhcl_regis_no ? 'readonly' : '' }} id="vhcl_regis_no"
                                            type="text" name="vhcl_regis_no"
                                            value="{{ $bankDetail->vhcl_regis_no }}">
                                        <span style="display:none" id="perm_reg_error" class="text-danger">Please enter a
                                            valid Permanent Registration Number</span>
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="vihcle_dt">Permanent Registration <br>Date:</label>
                                        <input class="reg_num form-control {{ $bankDetail->vihcle_dt ? 'readonly' : '' }}"
                                            {{ $bankDetail->vihcle_dt ? 'readonly' : '' }} id="vihcle_dt" type="text"
                                            value="{{ $bankDetail->vihcle_dt }}" onchange="validateDates()"
                                            name="vihcle_dt">
                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="vhcl_reg_file">Permanent Registration<br>
                                            Copy:</label>
                                        <input class="form-control" id="vhcl_reg_file" type="file"
                                            name="vhcl_reg_file">
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($bankDetail->vhcl_reg_file)) }}">
                                            <i class="fa fa-download"></i> View Document
                                        </a>

                                    </div>
                                    <!-- @if ($bankDetail->temp_reg_no || $bankDetail->vhcl_regis_no)
    <div div class="col-5 mb-3" id="e_voucher_div">
                                                                    <a target="_blank" href="{{ route('dealer.view_certificate', encrypt($bankDetail->buyer_id)) }}" class="btn btn-success form-control-sm mt-2">Generate &
                                                                        download E-Voucher</a>
                                                                </div>
    @endif -->
                                    <div div class="col-5 mb-3" id="e_voucher_div" style="display: none;">
                                        <button id="e_voucher_btn" class="btn btn-success form-control-sm mt-2">Generate &
                                            download E-Voucher</button>
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
                                            <input class="form-control" id="range" type="text"
                                                value="{{ $bankDetail->dlr_invoice_no }}" name="dlr_invoice_no">
                                            <span class="text-primary">As mentioned invoice copy</span>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="invoice_dt">
                                                Dealer Invoice Date:</label>
                                            <input class="form-control" id="invoice_dt" type="date"
                                                value="{{ date('Y-m-d', strtotime($bankDetail->invoice_dt)) }}"
                                                name="invoice_dt" min="{{ $minDate }}"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                onchange="validateDates()">
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

                    </div>
                </div>
                <div style="display: flex;justify-content: space-evenly;align-items: center;">
                    <div class="text-left">
                        <a href="{{ route('e-trucks.buyerdetail.index') }}" class="btn btn-warning">Back</a>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary form-control-sm mt-2" type="submit"
                            id="callFunctionBtn">Update</button>
                    </div>
                    <div class="text-center">
                        <a target="_blank" href="{{ route('e-trucks.ack.view', $bankDetail->id) }}"
                            class="btn btn-warning form-control-sm mt-2" id="acknowledgeButton"
                            @if ($bankDetail->status == 'S') disabled @endif>Print Acknowledge</a>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-primary form-control-sm mt-2" id="submitBtn">Submit as RC
                            Pending</button>
                    </div>
                    <input type="hidden" id="formAction" name="formAction" value="">
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    @include('partials.js.pincode')
    @include('partials.trucks.buyer_edit')
    {!! JsValidator::formRequest('App\Http\Requests\BuyerDetailRequestUpdate', '.modelcreate') !!}
@endpush
