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
                        <h4 class="mb-2">Customer Detail(for bulk purchase)</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <form action="{{ route('e-trucks.buyerdetail.multi_invoice_update') }}" role="form" method="POST"
                class='form-horizontal modelcreate' files=true enctype='multipart/form-data' id="model_create"
                accept-charset="utf-8">
                @csrf

                <input type="hidden" name='oem_id' id="oem_id" value="{{ Auth::user()->oem_id }}">
                <input type="hidden" name='bankDetailRowId' id="bankDetailRowId" value="{{ $bankDetail->id }}">
                <input type="hidden" name='dealer_id' value="{{ $user->id }}">
                <input type="hidden" value="{{ $bankDetail->segment_id }}" class="form-control" id="seg_id"
                    name="segment_id">
                <input type="hidden" name="customer_type" value="{{ $bankDetail->custmr_typ }}" />
                <div class="row mt-3">
                    <div class="col-sm-12">
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
                                            <input class="form-control readonly" id="vin_number" name="vin"
                                                value="{{ $bankDetail->vin_chassis_no }}" readonly>

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
                                            <input class="form-control srchV readonly"
                                                value="{{ date('Y-m-d', strtotime($prodDet->manufacturing_date)) }}"
                                                id="manufacturing_date" name="manufacturing_date" readonly>
                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Gross Vehicle Weight (GVW in
                                                Tons):</label>
                                            <input class="form-control srchV readonly" id="gross_weight"
                                                value="{{ $bankDetail->gross_weight }}" name="gvw" readonly>
                                        </div>
                                        {{-- <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="vehicle_segment">Temporary Registration Number:</label>
                                            <input class="form-control srchV readonly" id="ex_price" name="exfactry"
                                                readonly>

                                        </div>
                                        <div class="col-4 mb-3" id="">
                                            <label class="form-label" for="manu_date">Permanent Registration Number:</label>
                                            <input
                                                class="form-control srchV readonly" id="manufacturing_date"
                                                name="manufacturing_date" readonly>

                                        </div> --}}
                                    </div>
                                </div>
                            </div>

                            {{-- CD No----------------------------- --}}
                            {{-- <div class="card height-equal">
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
                            </div> --}}

                            {{-- end cd no------------ --}}

                            {{-- CD Information Section --}}
                            <div class="card height-equal">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>CD Information</h4>
                                    {{-- <button type="button" class="btn btn-info" id="add_multi_cdn">Add Row</button> --}}
                                    @if (!isset($cdinformation) || !$cdinformation->count())
                                        <button type="button" class="btn btn-info" id="add_multi_cdn">Add Row</button>
                                    @endif

                                </div>
                                <div class="card-body">
                                    <div class="vehicle_div" id="cd-inputs-wrapper">

                                        @if (isset($cdinformation) && $cdinformation->count())
                                            @foreach ($cdinformation as $index => $cd)
                                                <div class="row border p-3 cd-block">
                                                    <div class="col-4 mb-3 cd-entry">
                                                        <label class="form-label">CD Number</label>
                                                        <input class="form-control cdnumber-input readonly"
                                                            name="data[{{ $index + 1 }}][cdnumber]"
                                                            value="{{ $cd->cd_number }}" readonly>
                                                        {{-- <div class="row">
                                                            <div class="col-md-6">
                                                                <input class="form-control cdnumber-input readonly"
                                                                    name="data[{{ $index + 1 }}][cdnumber]"
                                                                    value="{{ $cd->cd_number }}" readonly>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button type="button"
                                                                    class="btn btn-primary btn-sm p-2 fetch-cd-btn"
                                                                    data-index="{{ $index + 1 }}" disabled>Fetch CD
                                                                    Data</button>
                                                            </div>
                                                        </div> --}}
                                                    </div>

                                                    <div class="col-4 mb-3">
                                                        <label class="form-label">CD Owner Name:</label>
                                                        <input class="form-control readonly cd_owner_name"
                                                            name="data[{{ $index + 1 }}][cd_owner_name]"
                                                            value="{{ $cd->cd_owner_name }}" readonly>
                                                    </div>

                                                    <div class="col-4 mb-3">
                                                        <label class="form-label">Gross Vehicle Weight (GVW in
                                                            Tons):</label>
                                                        <input class="form-control readonly gvw"
                                                            name="data[{{ $index + 1 }}][gvw]"
                                                            value="{{ $cd->vehicle_gvw }}" readonly>
                                                    </div>

                                                    <div class="col-4 mb-3">
                                                        <label class="form-label">VIN/Chassis Number:</label>
                                                        <input class="form-control readonly vin_no"
                                                            name="data[{{ $index + 1 }}][vin_no]"
                                                            value="{{ $cd->vin_scrapped }}" readonly>
                                                    </div>

                                                    <div class="col-4 mb-3">
                                                        <label class="form-label">Status Flag:</label>
                                                        <input class="form-control readonly status"
                                                            name="data[{{ $index + 1 }}][status]"
                                                            value="{{ $cd->status_flag }}" readonly>
                                                    </div>

                                                    <div class="col-4 mb-3">
                                                        <label class="form-label">CD – Issue Date:</label>
                                                        <input class="form-control readonly cd_issue_date"
                                                            name="data[{{ $index + 1 }}][cd_issue_date]"
                                                            value="{{ $cd->cd_issue_date }}" readonly>
                                                    </div>

                                                    <div class="col-4 mb-3">
                                                        <label class="form-label">CD - Validity Upto Date:</label>
                                                        <input class="form-control readonly cd_validation_date"
                                                            name="data[{{ $index + 1 }}][cd_validation_date]"
                                                            value="{{ $cd->cd_validity_upto }}" readonly>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row border p-3 cd-block">
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
                                        @endif

                                    </div>
                                </div>
                            </div>




                            {{-- <div class="col-sm-12">
                                <div class="card height-equal">
                                    <div class="card-header d-flex align-items-center justify-content-between">
                                        <h4>Invoice Detail</h4>
                                        <!-- @if ($bankDetail->addmi_inc_amt == 0) -->
                                            <button id="update_incentive" class="btn btn-primary" type="button">Update Incentive Ammount</button>
                                        <!-- @endif -->
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="range">Dealer Invoice No.:</label>
                                                <input class="form-control" id="range" type="text"
                                                    value="{{ $bankDetail->dlr_invoice_no }}" name="dlr_invoice_no">
                                                <span class="text-danger" id="invoice_no_err"></span><br>

                                                <span class="text-primary">As mentioned invoice copy</span>
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="invoice_dt">
                                                    Dealer Invoice Date:</label>
                                                <input class="form-control" id="invoice_dt" type="date"
                                                    @if ($bankDetail->invoice_dt)
                                                    value="{{ date('Y-m-d', strtotime($bankDetail->invoice_dt)) }}"
                                                    @endif
                                                    name="invoice_dt" min="{{ $minDate }}"
                                                    max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}
                                                    onchange="validateDates()">
                                                <span class="text-danger" id="invoice_date_err"></span>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Invoice Amount(INR)(per vehicle):</label>
                                                <input class="form-control" id="invoice_amt" type="number"
                                                    value="{{ $bankDetail->invoice_amt }}" name="invoice_amt" min=0>
                                                <span class="text-danger" id="invoice_amt_err"></span>
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
                                        <div class="col-12">
                                            <button id="print_ack" type="button" class="btn btn-warning">Save & Print Acknowledge</button>

                                            <a target="_blank" href="{{ route('ack.view', $bankDetail->id) }}"
                                                class="btn btn-success form-control-sm" id="acknowledgeButton" style="display:none;">Print Acknowledge</a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                        </div>

                        <div class="card height-equal" id="Vehicle_details">
                            <div class="card-header">
                                <h4>Vehicle Details:</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    {{-- <div class="col-3 mb-3">
                                        <label class="form-label" for="temp_reg">Temporary Registration<br> Number</label>
                                        <input data-target="temp_reg" type="text"
                                            class="reg_num form-control readonly"
                                            id="temp_reg" name="temp_reg" value="{{ $bankDetail->temp_reg_no }}" readonly>
                                        <span style="display: none" id="temp_reg_error" class="text-danger">Please enter
                                            a valid Temporary Registration Number</span>
                                    </div> --}}
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="vhcl_regis_no">Permanent Registration<br>
                                            Number:</label>
                                        <input data-target="perm_reg" class="reg_num form-control readonly"
                                            id="vhcl_regis_no" type="text" name="vhcl_regis_no"
                                            value="{{ $bankDetail->vhcl_regis_no }}" readonly>
                                        <span style="display:none" id="perm_reg_error" class="text-danger">Please
                                            enter a
                                            valid Permanent Registration Number</span>

                                    </div>

                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="vihcle_dt">Permanent Registration
                                            <br>Date:</label>
                                        <input class="form-control readonly" id="vihcle_dt" type="text"
                                            @if ($bankDetail->vihcle_dt) value="{{ date('Y-m-d', strtotime($bankDetail->vihcle_dt)) }}" @endif
                                            name="vihcle_dt" readonly>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="vhcl_reg_file">Permanent Registration
                                            <br>Copy:</label>
                                        <input class="form-control" id="vhcl_reg_file" type="file"
                                            name="vhcl_reg_file"
                                            @if ($bankDetail->vhcl_reg_file) value="{{ $bankDetail->vhcl_reg_file }}" @endif>
                                        <input id="vhcl_reg_file_exist" type="hidden" name="vhcl_reg_file_exist"
                                            @if ($bankDetail->vhcl_reg_file) value="{{ $bankDetail->vhcl_reg_file }}" @endif />
                                        <span id="vhcl_reg_file_error" class="text-danger"></span>
                                        @if ($bankDetail->vhcl_reg_file != null)
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($bankDetail->vhcl_reg_file)) }}">
                                                <i class="fa fa-download"></i> View Document
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-info text-light" id="fetchDetails">Fetch RC
                                            Details</button>
                                        {{-- @if ($bankDetail->temp_reg_no || $bankDetail->vhcl_regis_no) --}}
                                        {{-- <div class="" id="e_voucher_div"> --}}
                                        <a style="width: 35%;float: right;" id="e_voucher_div" target="_blank"
                                            href="{{ route('e-trucks.dealer.multiBuyerVoucher', encrypt($bankDetail->id)) }}"
                                            class="btn btn-success">Generate &
                                            download E-Voucher</a>
                                        {{-- </div> --}}
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-12">
                            <div class="card height-equal">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h4>Invoice Detail</h4>
                                    @if ($bankDetail->addmi_inc_amt == 0)
                                        <button id="update_incentive" class="btn btn-primary" type="button">Update
                                            Incentive Ammount</button>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="range">Dealer Invoice No.:</label>
                                            <input class="form-control" id="range" type="text"
                                                value="{{ $bankDetail->dlr_invoice_no }}" name="dlr_invoice_no">
                                            <span class="text-danger" id="invoice_no_err"></span><br>

                                            <span class="text-primary">As mentioned invoice copy</span>
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="invoice_dt">
                                                Dealer Invoice Date:</label>
                                            <input class="form-control" id="invoice_dt" type="date"
                                                @if ($bankDetail->invoice_dt) value="{{ date('Y-m-d', strtotime($bankDetail->invoice_dt)) }}" @endif
                                                name="invoice_dt" min="{{ $minDate }}"
                                                max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}
                                                onchange="validateDates()">
                                            <span class="text-danger" id="invoice_date_err"></span>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Invoice Amount(INR)(per vehicle):</label>
                                            <input class="form-control" id="invoice_amt" type="number"
                                                value="{{ $bankDetail->invoice_amt }}" name="invoice_amt" min=0>
                                            <span class="text-danger" id="invoice_amt_err"></span>
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
                                    <div class="col-12">
                                        <button id="print_ack" type="button" class="btn btn-warning">Save & Print
                                            Acknowledge</button>

                                        <a target="_blank" href="{{ route('e-trucks.ack.view', $bankDetail->id) }}"
                                            class="btn btn-success form-control-sm" id="acknowledgeButton"
                                            style="display:none;">Print Acknowledge</a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>



                    <div class="card height-equal">
                        <div class="card-header">
                            <h4>Dcoument Upload:</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <td>
                                            <label class="form-label" for="cust_acknwldge">Customer
                                                Acknowledgement:</label>
                                            <input class="form-control docs_upload" data-target="ack" id="cust_acknwldge"
                                                type="file" name="cst_ack_file">
                                            <input type="hidden" name="cust_ack_exist"
                                                value="{{ $bankDetail->cst_ack_file }}" />
                                            <span class="text-primary">Upload Signed & Stamped Customer Acknowledgement
                                                Form.</span>
                                        </td>
                                        <td>
                                            <label class="form-label" for="invoice_copy">
                                                Invoice Copy:</label>
                                            <input class="form-control docs_upload" data-target="invc" id="invoice_copy"
                                                type="file" name="invc_copy_file">
                                            <input type="hidden" name="cust_invoice_exist"
                                                value="{{ $bankDetail->invc_copy_file }}" />
                                            <br>
                                            <br>
                                        </td>
                                        <td>
                                            <label class="form-label" for="e_voucher_copy">
                                                E-Voucher Copy:</label>
                                            <input class="form-control docs_upload" data-target="evoucher"
                                                id="e_voucher_copy" type="file" name="evoucher_copy_file">
                                            <input type="hidden" name="cust_voucher_exist"
                                                value="{{ $bankDetail->evoucher_copy_id }}" />
                                            <span class="text-primary">upload Signed & Stamped E-Voucher</span>
                                        </td>
                                        <td>
                                            <label class="form-label" for="customer_selfie_copy">
                                                Customer selfie Copy:</label>
                                            <input class="form-control docs_upload" data-target="selfie"
                                                id="customer_selfie_copy" type="file" name="selfi_copy_file">
                                            <input type="hidden" name="cust_self_file"
                                                value="{{ $bankDetail->self_copy_id }}" />
                                            <br>
                                            <br>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                            <td>
                                                <span class="text-primary">Upload Signed & Stamped Customer Acknowledgement
                                                    Form.</span>
                                                <br>
                                            </td>
                                            <td></td>
                                            <td><span class="text-primary">upload Signed & Stamped E-Voucher</span></td>
                                            <td></td>
                                        </tr> --}}
                                    <tr>
                                        <td>
                                            @if ($bankDetail->cst_ack_file != null)
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($bankDetail->cst_ack_file)) }}">
                                                    <i class="fa fa-download"></i> View Document
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($bankDetail->invc_copy_file != null)
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($bankDetail->invc_copy_file)) }}">
                                                    <i class="fa fa-download"></i> View Document
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($bankDetail->evoucher_copy_id != null)
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($bankDetail->evoucher_copy_id)) }}">
                                                    <i class="fa fa-download"></i> View Document
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($bankDetail->self_copy_id != null)
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('doc.down', encrypt($bankDetail->self_copy_id)) }}">
                                                    <i class="fa fa-download"></i> View Document
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <div style="display: flex;justify-content: space-evenly;align-items: center;">
            <div class="text-left">
                <a href="{{ route('e-trucks.buyerdetail.multi_detail_edit', encrypt($rowId)) }}"
                    class="btn btn-warning">Back</a>
            </div>
            <div class="text-center">
                <button class="btn btn-primary form-control-sm mt-2" type="submit" id="callFunctionBtn">Update</button>
            </div>
            {{-- <div class="text-center">
                        <a target="_blank" href="{{ route('ack.view', $bankDetail->id) }}"
                            class="btn btn-warning form-control-sm mt-2" id="acknowledgeButton"
                            @if ($bankDetail->status == 'S') disabled @endif>Print Acknowledge</a>
                    </div> --}}
            </form>
            @if (
                $bankDetail->self_copy_id &&
                    $bankDetail->evoucher_copy_id &&
                    $bankDetail->invc_copy_file &&
                    $bankDetail->cst_ack_file &&
                    ($bankDetail->temp_reg_no || $bankDetail->vhcl_regis_no) &&
                    // $bankDetail->vhcl_reg_file &&
                    // $bankDetail->vihcle_dt &&
                    $bankDetail->dlr_invoice_no &&
                    $bankDetail->invoice_dt &&
                    $bankDetail->invoice_amt)
                <div class="text-end">
                    <form id="final_submit_form" action="{{ route('e-trucks.buyerdetail.multi_invoice_submit') }}"
                        method="post">
                        @csrf
                        <input type="hidden" name="buyer_row_id" value="{{ encrypt($bankDetail->id) }}" />
                        <input type="hidden" name="row_id" value="{{ encrypt($rowId) }}" />
                        <button id="final_submit_btn" type="submit"
                            class="btn btn-primary form-control-sm mt-2">Save</button>
                    </form>
                </div>
            @endif
            <input type="hidden" id="formAction" name="formAction" value="">
        </div>

    </div>
    </div>
@endsection
@push('scripts')
    @include('partials.js.pincode')
    @include('partials.trucks.multi_invoice')
    {!! JsValidator::formRequest('App\Http\Requests\CreateMultiInvoiceDocsRequest', '#model_create') !!}
@endpush
