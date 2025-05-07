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
                        <h4 class="mb-2">Customer Detail(for bulk purchase) NEW</h4>
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
                <input type="hidden" name='bankDetailRowId' id="bankDetailRowId" value="{{$bankDetail->id}}">
                <input type="hidden" name='dealer_id' value="{{ $user->id }}">
                <input type="hidden" value="{{ $bankDetail->segment_id }}" class="form-control" id="seg_id"
                    name="segment_id">
                <input type="hidden" name="customer_type" value="{{$bankDetail->custmr_typ}}"/>
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
                                    <h4>Authorized Person Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3" id="">
                                            <label class="form-label">Authorized Person Name: </label>
                                            <input type="text" class="form-control readonly" id="custmr_name"
                                                name="authr_per_name" value="{{ $bankDetail->auth_per_name }}" readonly>
                                        </div>
                                        <div class="col-md-4 mb-3" id="">
                                            <label class="form-label">Authorized Person Name as per <span
                                                style="color: green;">Aadhaar:</span></label>
                                            <input type="text" class="form-control readonly" id="ath_per_name" name="ath_per_name" readonly value="{{$multiBuyerDetail->adhar_name}}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="Address">Address:</label>
                                            <input class="form-control readonly" type="text" id="add"
                                                value="{{$multiBuyerDetail->auth_addr}}"
                                                name="add" readonly>
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="Landmark">Landmark:</label>
                                            <input class="form-control readonly" type="text" id="Landmark"
                                                name="landmark" value="{{$multiBuyerDetail->landmark}}" readonly>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="Pincode">Pincode:</label>
                                            <input class="form-control readonly" type="text" name="Pincode"
                                                placeholder=" Pincode" value="{{$multiBuyerDetail->pincode}}"
                                                 readonly>
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
                                                value="{{$multiBuyerDetail->state}}" placeholder=" State"
                                                id="OEMAddState0" readonly>
                                            @error('State')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="District">District:</label>
                                            <input class="form-control readonly" type="text" name="District"
                                                value="{{$multiBuyerDetail->district}}" placeholder="District"
                                                id="OEMAddDistrict0" readonly>
                                            @error('District')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="City">City:</label>
                                            <select class="form-control readonly" name="City" id="OEMAddCity0" readonly>
                                                <option value="">Choose City ....</option>
                                                <option value="" selected>
                                                    {{ $multiBuyerDetail->city ? $multiBuyerDetail->city : '' }}
                                                </option>
                                            </select>
                                            @error('City')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="mobile">Mobile Number:</label>
                                            <input class="form-control readonly" type="number" id="mobile" name="mobile"
                                            value="{{$multiBuyerDetail->mobile}}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="card height-equal">
                                <div class="card-header">
                                    <h4>Company Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">Company Type/Category:</label>
                                            <select class="form-select customer-type readonly" id="cstm_typ" name="custmr_typ">
                                                <option selected="selected" disabled value="0">Select</option>
                                                    <option value="2"
                                                        @if ($bankDetail->custmr_typ == 2) selected @endif>
                                                        Proprietory Firms/Agencies</option>
                                                    <option value="3"
                                                        @if ($bankDetail->custmr_typ == 3) selected @endif>
                                                        Corporate And Partnership Agencies</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3" id="">
                                            <label class="form-label">Company Name:</label>
                                            <input type="text" class="form-control readonly" id="custmr_name"
                                                name="custmr_name" value="{{$bankDetail->custmr_name}}" readonly>
                                            <div class="text-center">
                                                <span class="text-primary">Company Name as per invoice</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="Address">Address:</label>
                                            <textarea class="form-control readonly" name="add">{{ str_replace('null', '', $multiBuyerDetail->cmpny_addr) }}</textarea>
                                            {{-- <input class="form-control readonly" type="text" id="add"
                                                value="{{ str_replace('null', '', $multiBuyerDetail->cmpny_addr) }}"
                                                name="add" readonly> --}}
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="Landmark">Landmark:</label>
                                            <input class="form-control readonly" type="text" id="Landmark"
                                                name="landmark" value="{{ $multiBuyerDetail->cmpny_land }}" readonly>
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="Pincode">Pincode:</label>
                                            <input class="form-control readonly" type="text" name="Pincode"
                                                placeholder=" Pincode" value="{{ $multiBuyerDetail->cmpny_pin }}"
                                                onkeyup="citydata(this.value)" readonly>
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
                                                value="{{ $multiBuyerDetail->cmpny_state }}" placeholder=" State"
                                                id="OEMAddState0" readonly>
                                            @error('State')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="District">District:</label>
                                            <input class="form-control readonly" type="text" name="District"
                                                value="{{ $multiBuyerDetail->cmpny_dist }}" placeholder="District"
                                                id="OEMAddDistrict0" readonly>
                                            @error('District')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="City">City:</label>
                                            <select class="form-control readonly" name="City" id="OEMAddCity0" readonly>
                                                <option value="">Choose City ....</option>
                                                <option value="{{ $multiBuyerDetail->cmpny_city }}" selected>
                                                    {{ $multiBuyerDetail->cmpny_city ? $multiBuyerDetail->cmpny_city : '' }}
                                                </option>
                                            </select>
                                            @error('City')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="mobile">Contact Number:</label>
                                            <input class="form-control readonly" type="number" id="mobile" name="mobile"
                                                value="{{ $multiBuyerDetail->cmpny_mobile }}" readonly>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Additional Company Id:</label>
                                            <select class="form-select readonly" name="addi_cust_id" id="addi_cust_id" readonly>
                                                <option selected="selected" disabled value="0">Select</option>
                                                @foreach ($type as $val)
                                                        <option value="{{ $val->id }}"
                                                            @if ($val->id == $bankDetail->addi_cust_id) selected @endif disabled>
                                                            {{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Additional Customer Id No.:</label>
                                            <input class="form-control readonly" id="total_energy_capacity" type="text"
                                                value="{{ $bankDetail->cust_id_sec }}"
                                                style="text-transform: uppercase;" name="cust_id_sec" readonly>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Additional Company Id copy:</label><br>
                                            {{-- <input class="form-control" type="file" value=""
                                                id="battery_make" name="cust_sec_file"> --}}
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($bankDetail->sec_file_uploadeid)) }}">
                                                <i class="fa fa-download"></i> View Document
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="card height-equal">
                                <div class="card-header">
                                    <h4>Vehicle Information</h4>

                                </div>
                                <div class="card-body" id="oldVin">
                                    <input type="hidden" name='prod_id' value="{{ $bankDetail->production_id }}">
                                    <div class="row">
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="vehicle_segment">VIN Number</label>
                                            <input class="form-control readonly" id="" name=""
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
                                                value="{{ $prodDet->manufacturing_date }}" id=""
                                                name="manufacturing_date" readonly>
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
                                                <input class="form-control readonly" id="range" type="text"
                                                    value="{{ $bankDetail->dlr_invoice_no }}" name="dlr_invoice_no" readonly>
                                                <span class="text-primary">As mentioned invoice copy</span>
                                            </div>
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="invoice_dt">
                                                    Dealer Invoice Date:</label>
                                                <input class="form-control readonly" id="invoice_dt" type="date"
                                                    value="{{ date('Y-m-d', strtotime($bankDetail->invoice_dt)) }}"
                                                    name="invoice_dt" onchange="validateDates()" readonly>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">Invoice Amount(INR)(per vehicle):</label>
                                                <input class="form-control readonly" id="invoice_amt" type="number"
                                                    value="{{ $bankDetail->invoice_amt }}" name="invoice_amt" readonly>
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

                                                    {{-- <input class="form-control" id="tot_adm_inc_amt" type="number"
                                                    value="{{ $bankDetail->tot_admi_inc_amt }}" name="tot_admi_inc_amt"> --}}
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

                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>Vehicle Details:</h4>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="vhcl_regis_no">Permanent Registration<br>
                                            Number:</label>
                                        <input data-target="perm_reg"
                                            class="reg_num form-control readonly"
                                            id="vhcl_regis_no" type="text" name="vhcl_regis_no"
                                            value="{{ $bankDetail->vhcl_regis_no }}" readonly>
                                        <span style="display:none" id="perm_reg_error" class="text-danger">Please enter a
                                            valid Permanent Registration Number</span>

                                    </div>

                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="vihcle_dt">Permanent Registration <br>Date:</label>
                                        <input class="form-control readonly" id="vihcle_dt" type="date"
                                        @if($bankDetail->vihcle_dt)
                                            value="{{ date('Y-m-d', strtotime($bankDetail->vihcle_dt)) }}"
                                        @endif
                                            onchange="validateDates()" name="vihcle_dt" readonly>
                                    </div>
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="vhcl_reg_file">Permanent Registration <br>Copy:</label>
                                        {{-- <input class="form-control" id="vhcl_reg_file" type="file" name="vhcl_reg_file"> --}}
                                        <input type="hidden" name="vhcl_reg_file_exist" value="{{$bankDetail->vhcl_reg_file}}"/>
                                        
                                        @if ($bankDetail->vhcl_reg_file != null)
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($bankDetail->vhcl_reg_file)) }}">
                                                <i class="fa fa-download"></i> View Document
                                            </a>
                                        @endif
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
                                        <label class="form-label" for="cust_acknwldge">Customer Acknowledgement:</label>
                                        {{-- <input class="form-control docs_upload" data-target="ack" id="cust_acknwldge" type="file" name="cst_ack_file"> --}}
                                        {{-- <span class="text-primary">Upload Signed & Stamped Customer Acknowledgement
                                            Form.</span> --}}
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
                                        {{-- <input class="form-control docs_upload" data-target="invc" id="invoice_copy" type="file"
                                            name="invc_copy_file"> --}}
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
                                        {{-- <input class="form-control docs_upload" data-target="evoucher" id="e_voucher_copy" type="file"
                                            name="evoucher_copy_file"> --}}
            
                                        {{-- <span class="text-primary">upload Signed & Stamped E-Voucher</span> --}}
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
                                        {{-- <input class="form-control docs_upload" data-target="selfie" id="customer_selfie_copy" type="file"
                                            name="selfi_copy_file"> --}}
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
                
                
                    <div class="text-left">
                        <a href="{{ route('e-trucks.claimProcessing') }}" class="btn btn-warning form-control-sm mt-2">Back</a>
                        
                    </div>
            </form>
                  
            
        </div>
    </div>

@endsection
