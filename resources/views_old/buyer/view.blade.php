@extends('layouts.dashboard_master')
@section('title')
    Admin - Claim Generate
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
            <input type="hidden" value="{{ $bankDetail->segment_id }}" class="form-control" id="seg_id"
                name="segment_id">
            <input type="hidden" name='production_id' value="{{ $bankDetail->production_id }}" id="prd_id">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card height-equal mt-5">
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
                                                    id="" name="" value="{{ $bankDetail->vin_chassis_no }}"
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
                            {{-- <div class="card-body">
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        @php
                                            if ($bankDetail->custmr_typ == 1) {
                                                $col = 'col-3';
                                                $style = 'display:block';
                                            } else {
                                                $col = 'col-4';
                                                $style = 'display:none';
                                            }
                                        @endphp
                                        <label class="form-label" for="vehicle_segment">Customer
                                            Type/Category:</label>
                                        <input type="text" class="form-control readonly" id="cstm_typ"
                                            name="custmr_typ"
                                            value="{{ $bankDetail->custmr_typ == 1
                                                ? 'Individual Cases'
                                                : ($bankDetail->custmr_typ == 2
                                                    ? 'Proprietory Firms/Agencies'
                                                    : ($bankDetail->custmr_typ == 3
                                                        ? 'Corporate And Partnership Agencies'
                                                        : '')) }}"
                                            readonly>
                                    </div>
                                    <div class="{{ $col }} mb-3" id="">
                                        <label class="form-label">Customer Name as per <span
                                                style="color: blue;">Invoice</span>:</label>
                                        <input type="text" class="form-control readonly" id="custmr_name"
                                            name="custmr_name" value="{{ $bankDetail->custmr_name }}" readonly>
                                    </div>
                                    <div class="{{ $col }} mb-3" id="" style="{{ $style }}">
                                        <label class="form-label">Customer Name as per <span
                                                style="color: green;">Aadhaar:</span></label>
                                        <input type="text" class="form-control readonly" id="addhar_name"
                                            name="addhar_name" value="{{ $bankDetail->custmr_name }}" readonly>
                                    </div>
                                    <div class="{{ $col }} mb-3" id="">
                                        <label class="form-label" for="Email">Email Id:</label>
                                        <input class="form-control readonly" id="Email" type="text"
                                            name="email" value="{{ $bankDetail->email }}" readonly>
                                    </div>
                                </div>
                            </div> --}}
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
                                    <div class="{{$col}} mb-3">
                                        <label class="form-label" for="vehicle_segment">Customer
                                            Type/Category:</label>
                                        <input type="text" class="form-control readonly" id="cstm_typ"
                                            name="custmr_typ"
                                            value="{{ $bankDetail->custmr_typ == 1
                                                ? 'Individual Cases'
                                                : ($bankDetail->custmr_typ == 2
                                                    ? 'Proprietory Firms/Agencies'
                                                    : ($bankDetail->custmr_typ == 3
                                                        ? 'Corporate And Partnership Agencies'
                                                        : '')) }}"
                                            readonly>
                                    </div>
                                    <div class="{{ $col }} mb-3" id="">
                                        <label class="form-label">Customer Name as per <span
                                                style="color: blue;">Invoice</span>:</label>
                                        <input type="text" class="form-control readonly" id="custmr_name"
                                            name="custmr_name" value="{{ $bankDetail->custmr_name }}" readonly>
                                    </div>
                                    <div class="{{ $col }} mb-3" id="" style="{{ $style }}">
                                        <label class="form-label">Customer Name as per <span
                                                style="color: green;">Aadhaar:</span></label>
                                        <input type="text" class="form-control readonly" id="addhar_name"
                                            name="addhar_name" value="{{ $bankDetail->adhar_name }}" readonly>
                                    </div>
                                    <div class="{{ $col }} mb-3" id="">
                                        <label class="form-label" for="Email">Email Id:</label>
                                        <input class="form-control readonly" id="Email" type="text"
                                            name="email" value="{{ $bankDetail->email }}" readonly>
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
                                                value="{{ $bankDetail->city }}" placeholder="District"
                                                id="OEMAddDistrict0" readonly>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="mobile">Mobile Number:</label>
                                            <input class="form-control readonly" type="number" id="mobile"
                                                name="mobile" value="{{ $bankDetail->mobile }}" readonly>
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
                                <div class="card-header">
                                    <h4>Invoice Detail</h4>
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
                                                <input class="form-control readonly" readonly id="adhar_no"
                                                    type="text" value="{{ $cat->name }}" name="custmr_id_no">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Customer Id No.:</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <input class="form-control readonly" readonly id="adhar_no"
                                                            type="text" value="{{ $bankDetail->custmr_id_no }}"
                                                            name="custmr_id_no">
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
                                                type="text" value="{{ $bankDetail->cust_id_sec }}"
                                                name="cust_id_sec">
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

                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>Vehicle Details:</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="temp_reg">Temporary Registration Number</label>
                                        <input type="text" class="form-control readonly" id="temp_reg"
                                            value="{{ $bankDetail->temp_reg_no }}" readonly>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="vhcl_regis_no">Permanent Registration
                                            Number:</label>
                                        <input class="form-control readonly" readonly id="vhcl_regis_no" type="text"
                                            value="{{ $bankDetail->vhcl_regis_no }}">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="vihcle_dt">Permanent Registration Date:</label>
                                        <input class="form-control readonly" readonly id="vihcle_dt" type="date"
                                        value="{{ date('Y-m-d', strtotime($bankDetail->vihcle_dt)) }}">
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="vhcl_reg_file">Permanent Registration Copy:</label>
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($bankDetail->vhcl_reg_file)) }}">
                                            <i class="fa fa-download"></i> View Document
                                        </a>
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
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="range">Customer Acknowledgement:</label><br>
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($bankDetail->cst_ack_file)) }}">
                                            <i class="fa fa-download"></i> View Document
                                        </a>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">
                                            Invoice Copy:</label><br>
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($bankDetail->invc_copy_file)) }}">
                                            <i class="fa fa-download"></i> View Document
                                        </a>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">
                                            E-Voucher Copy:</label><br>
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($bankDetail->evoucher_copy_id)) }}">
                                            <i class="fa fa-download"></i> View Document
                                        </a>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">
                                            Customer Selfi Copy:</label><br>
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($bankDetail->self_copy_id)) }}">
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
            <div class="col-sm-12">
                <div class="card height-equal">
                    <div class="card-header">
                        <h4>OEM Status</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 mb-3 text-center">
                                @if($bankDetail->buyer_submitted_at > $bankDetail->oem_status_at)
                                <input type="text" class="form-control readonly"
                                    style="background-color: {{ $bankDetail->oem_status == 'A' ? '#28a745' : ($bankDetail->oem_status == 'R' ? '#dc3545' : '#ffc107') }}; color: black;"
                                    value="Pending"
                                    readonly>
                                @else
                                <input type="text" class="form-control readonly"
                                    style="background-color: {{ $bankDetail->oem_status == 'A' ? '#28a745' : ($bankDetail->oem_status == 'R' ? '#dc3545' : '#ffc107') }}; color: black;"
                                    value="{{ $bankDetail->oem_status == 'A' ? 'Approved' : ($bankDetail->oem_status == 'R' ? 'Reject With Reason: ' . $bankDetail->oem_remarks : ($bankDetail->oem_status ? $bankDetail->oem_status : 'Pending')) }}{{ $bankDetail->oem_status ? ' at ' . $bankDetail->oem_status_at : '' }}"
                                    readonly>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="backBtn">
                <div class="col-4">
                    @if (Auth::user()->hasRole('DEALER'))
                        <a href="{{ route('buyerdetail.index') }}" class="btn btn-warning form-control-sm mt-2"
                            type="" id="">Back</a>
                    @elseif(Auth::user()->hasRole('OEM'))
                    <a href="{{ url()->previous() }}" class="btn btn-warning form-control-sm mt-2" id="">Back</a>

                    @elseif(Auth::user()->hasRole('PMA'))
                    <a href="{{ route('claimProcessing') }}" class="btn btn-warning form-control-sm mt-2"
                        type="" id="">Back</a>
                    @endif
                </div>
            </div>
    </div>
@endsection
@push('scripts')
    @include('partials.js.pincode')
    {!! JsValidator::formRequest('App\Http\Requests\AckDocRequest', '.modelcreate') !!}
    </script>
@endpush
