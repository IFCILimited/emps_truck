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
                        <h4 class="mb-2">Claim Generate</h4>
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
                                </div>
                            </div>
                            <div class="card-body" id="newVin" style="display: none;">
                                <div class="row">
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="vehicle_segment">VIN Number</label>
                                        <div class="row">
                                            <div class="col-md-6"><input class="form-control readonly" readonly
                                                    id="vin" name="vin"></div>
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

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">Customer
                                                Type/Category:</label>
                                            <input type="text" class="form-control" id="cstm_typ" name="custmr_typ"
                                                value="{{ $bankDetail->custmr_typ == 1
                                                    ? 'Individual Cases'
                                                    : ($bankDetail->custmr_typ == 2
                                                        ? 'Proprietory Firms/Agencies'
                                                        : ($bankDetail->custmr_typ == 3
                                                            ? 'Corporate And Partnership Agencies'
                                                            : ($bankDetail->custmr_typ == 4
                                                                ? 'Gov. Department/Defence Supply'
                                                                : ''))) }}"
                                                disabled>

                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">Gender:</label>
                                            <input type="text" class="form-control" id="gen" name="gender"
                                                value="{{ $bankDetail->custmr_typ == 1
                                                    ? ($bankDetail->gender == 'M'
                                                        ? 'Male'
                                                        : ($bankDetail->gender == 'F'
                                                            ? 'Female'
                                                            : ($bankDetail->gender == 'O'
                                                                ? 'Other'
                                                                : '')))
                                                    : '' }}"
                                                disabled>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="variant_name">Customer Name:</label>
                                            <input class="form-control readonly" readonly type="text"
                                                name="custmr_name" value="{{ $bankDetail->custmr_name }}"
                                                id="custm_name">
                                            <span class="text-danger">As mentioned in Adhaar card</span>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="variant_name">Address:</label>
                                            {{-- <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea> --}}
                                            <input class="form-control readonly" readonly type="text" id="add"
                                                value="{{ $bankDetail->add }}" name="add">

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="variant_name">Landmark:</label>
                                            {{-- <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea> --}}
                                            <input class="form-control readonly" readonly id="variant_name"
                                                type="text" id="variant_name" name="landmark"
                                                value="{{ $bankDetail->landmark }}">

                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">Pincode:</label>
                                            <input class="form-control readonly" readonly type="text" name="Pincode"
                                                placeholder=" Pincode" value="{{ $bankDetail->pincode }}"
                                                onkeyup="GetCityByPinCode('OEM', this.value, 0)">
                                            <span id="OEMpincodeMsg0" style="color:red;font-weight:bold;display: none">
                                                @error('Pincode')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">State:</label>
                                            <input class="form-control readonly" readonly type="text" name="State"
                                                value="{{ $bankDetail->state }}" placeholder=" State" id="OEMAddState0"
                                                readonly>
                                            @error('State')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">District:</label>
                                            <input class="form-control readonly" readonly type="text" name="District"
                                                value="{{ $bankDetail->district }}" placeholder="District"
                                                id="OEMAddDistrict0" readonly>
                                            @error('District')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">City:</label>
                                            <input class="form-control readonly" readonly type="text" name="City"
                                                value="{{ $bankDetail->city }}" placeholder=" City" id="OEMAddCity0">
                                            @error('City')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="variant_name">Mobile Number:</label>
                                            <input class="form-control readonly" readonly id="variant_name"
                                                type="number" id="variant_name" name="mobile"
                                                value="{{ $bankDetail->mobile }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="variant_name">Email Id:</label>
                                            <input class="form-control readonly" readonly id="variant_name"
                                                type="text" id="variant_name" name="email"
                                                value="{{ $bankDetail->email }}">
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
                                        <div class="col-4 mb-3 ">
                                            <label class="form-label" for="battery_cat_repulsion">Customer
                                                Id:*</label>
                                            <select disabled class="form-select" name="custmr_id" id="cstmer_typ">
                                                <option value="{{ $bankDetail->custmr_id }}">{{ $cat->name }}
                                                </option>
                                            </select>
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
                                            <label class="form-label" style="display: none" id="cust_id_label">Customer Id copy:</label>
                                            <br>
                                            <a class="btn btn-success btn-sm" style="display: none" id="cut_id_doc_1"
                                                href="{{ route('doc.down', encrypt($bankDetail->copy_file_uploadid)) }}">
                                                <i class="fa fa-download"></i> View Certificate
                                            </a>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Additional Customer Id:</label>
                                            <select disabled class="form-select" name="addi_cust_id"
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
                                            <input class="form-control readonly" readonly id="total_energy_capacity"
                                                type="text" value="{{ $bankDetail->cust_id_sec }}"
                                                name="cust_id_sec">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Additional Customer Id copy:</label><br>
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($bankDetail->sec_file_uploadeid)) }}">
                                                <i class="fa fa-download"></i> View Certificate
                                            </a>
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
                                            <span class="text-danger">As mentioned invoice copy</span>

                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="max_electric_energy_consumption">
                                                Dealer Invoice Date:</label>
                                            <input class="form-control readonly" readonly
                                                id="max_electric_energy_consumption" type="date"
                                                value="{{ date('Y-m-d', strtotime($bankDetail->invoice_dt)) }}"
                                                name="invoice_dt">

                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="max_electric_energy_consumption">Vehicle
                                                Registration Date:</label>
                                            <input class="form-control readonly" readonly
                                                id="max_electric_energy_consumption" type="date"
                                                value="{{ date('Y-m-d', strtotime($bankDetail->vihcle_dt)) }}"
                                                name="">
                                        </div>
                                      
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Invoice Amount(INR)(per vehicle):</label>
                                            <input class="form-control readonly" readonly id="minimum_acceleration"
                                                type="number" value="{{ $bankDetail->invoice_amt }}"
                                                name="invoice_amt">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Admissible Incentive Amount(INR)(per
                                                vehicle):</label>
                                            <input class="form-control readonly" readonly id="minimum_acceleration"
                                                type="number" value="{{ $bankDetail->addmi_inc_amt }}"
                                                name="addmi_inc_amt">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Total Invoice Amount(INR):</label>
                                            <input class="form-control readonly" readonly id="minimum_acceleration"
                                                type="number" value="{{ $bankDetail->tot_inv_amt }}"
                                                name="tot_inv_amt">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Total Admissible Incentive Amount(INR):</label>
                                            <input class="form-control readonly" readonly id="minimum_acceleration"
                                                type="number" value="{{ $bankDetail->tot_admi_inc_amt }}"
                                                name="tot_admi_inc_amt">
                                        </div>
                                        <div class="col-4 mb-3 ">
                                            <label class="form-label" for="minimax_speed">Amount Payable by Customer
                                                (INR):</label>
                                            <input class="form-control readonly" readonly id="minimax_speed"
                                                type="number" value="{{ $bankDetail->amt_custmr }}" name="amt_custmr">
                                            <span class="text-danger">Amount after deduction of EMPS-2024
                                                Incentive</span>
                                        </div>


                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="discount">Discount Given</label>
                                            <input class="form-control readonly" readonly name="discount" id="discount"
                                                   type="text" value="{{ $bankDetail->discount_given == 1 ? 'YES' : 'NO' }}">
                                        </div>
                                        
                                        <div class="col-4 mb-3" id="discountFieldContainer"
                                            style="display: {{ $bankDetail->discount_given == 1 ? 'block' : 'none' }};">
                                            <label class="form-label" for="discountAmount">Discount Amount</label>
                                            <input type="text" class="form-control readonly" readonly
                                                value="{{ $bankDetail->discount_amt }}" name="discountAmount"
                                                id="discountAmount" placeholder="Enter discount amount">
                                        </div>
                                        <div class="col-4 mb-3 " id="empField"
                                            style="display: {{ $bankDetail->discount_given == 1 ? 'block' : 'none' }};">
                                            <label class="form-label" for="minimax_speed">Emps 2024</label>
                                            <input class="form-control readonly" readonly name="empsBeforeAfter"
                                            type="text" value="{{ $bankDetail->empsbeforeafter == 'Before' ? 'Before' : 'After' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('ack.update', $bankDetail->id) }}" role="form" method="POST"
            class='form-horizontal modelcreate' files=true enctype='multipart/form-data' id="model_create"
            accept-charset="utf-8">
            @csrf
            @method('patch')
            <div class="col-sm-12">
                <div class="card height-equal">
                    <div class="card-header">
                        <h4>Acknowledge Document</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label class="form-label" for="max_electric_energy_consumption">Vehicle
                                    Registration Date:</label>
                                <input class="form-control readonly" readonly id="max_electric_energy_consumption"
                                    type="date" value="{{ date('Y-m-d', strtotime($bankDetail->vihcle_dt)) }}"
                                    name="vihcle_dt">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" for="">
                                    Vehicle Registration Number:</label>
                                <input class="form-control readonly" readonly id="" type="text"
                                    name="vhcl_regis_no" readonly value="{{ $bankDetail->vhcl_regis_no }}">
                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" for="range">Customer Acknowledgement:</label><br>
                                <a class="btn btn-success btn-sm"
                                    href="{{ route('doc.down', encrypt($bankDetail->cst_ack_file)) }}">
                                    <i class="fa fa-download"></i> View Certificate
                                </a>

                            </div>
                            <div class="col-4 mb-3">
                                <label class="form-label" for="max_electric_energy_consumption">
                                    Vehicle Invoice Copy:</label><br>
                                <a class="btn btn-success btn-sm"
                                    href="{{ route('doc.down', encrypt($bankDetail->invc_copy_file)) }}">
                                    <i class="fa fa-download"></i> View Certificate
                                </a>
                            </div>
                            <div class="col-4 mb-3 ">
                                <label class="form-label" for="minimax_speed">Vehicle Registration
                                    Copy:</label><br>
                                <a class="btn btn-success btn-sm"
                                    href="{{ route('doc.down', encrypt($bankDetail->vhcl_reg_file)) }}">
                                    <i class="fa fa-download"></i> View Certificate
                                </a>
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
                                <input type="text" class="form-control readonly"
                                    style="background-color: {{ $bankDetail->oem_status == 'A' ? '#28a745' : ($bankDetail->oem_status == 'R' ? '#dc3545' : '#ffc107') }}; color: black;"
                                    value="{{ $bankDetail->oem_status == 'A' ? 'Approved' : ($bankDetail->oem_status == 'R' ? 'Reject With Reason: ' . $bankDetail->oem_remarks : ($bankDetail->oem_status ? $bankDetail->oem_status : 'Pending')) }}{{ $bankDetail->oem_status ? ' at ' . $bankDetail->oem_status_at : '' }}"
                                    readonly>
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
                        <a href="{{ route('manageBuyerDetails.index','A') }}" class="btn btn-warning form-control-sm mt-2"
                            type="" id="">Back</a>
                    @elseif(Auth::user()->hasRole('PMA'))
                    <a href="{{ route('claimProcessing') }}" class="btn btn-warning form-control-sm mt-2"
                        type="" id="">Back</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
    @include('partials.js.pincode')
    {!! JsValidator::formRequest('App\Http\Requests\AckDocRequest', '.modelcreate') !!}
    <script>
        $(document).ready(function() {
            var val = $('#cstm_typ').val();
            if(val=='Individual Cases'){
                $('#cust_id_label').hide();
                $('#cut_id_doc_1').hide();
            }else{
                $('#cust_id_label').show();
                $('#cut_id_doc_1').show();
            }
        });
    </script>
@endpush
