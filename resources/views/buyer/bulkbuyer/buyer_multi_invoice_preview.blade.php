@extends('layouts.dashboard_master')
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
            <form action="{{ route('buyerdetail.multi_invoice_update') }}" role="form" method="POST"
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
                                                    name="invoice_dt" min="{{ $minDate }}"
                                                    max="{{ $maxDate }}" onchange="validateDates()" readonly>
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
                                    {{-- <div class="col-3 mb-3">
                                        <label class="form-label" for="temp_reg">Temporary Registration Number</label>
                                        <input data-target="temp_reg" type="text"
                                            class="reg_num form-control readonly"
                                            id="temp_reg" name="temp_reg" value="{{ $bankDetail->temp_reg_no }}" readonly>
                                        <span style="display: none" id="temp_reg_error" class="text-danger">Please enter
                                            a valid Temporary Registration Number</span>
                                    </div> --}}
                                    <div class="col-3 mb-3">
                                        <label class="form-label" for="vhcl_regis_no">Permanent Registration
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

                @if($userType == 'pma')
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
                @endif
                
                {{-- <div style=""> --}}
                    <div class="text-left">
                        @if($userType == 'deal')
                            @if($flag == 'prev')
                                {{-- send back to dealer preview page --}}
                                <a href="{{ route('buyerdetail.multi_buyer_preview', [encrypt($rowId), 'deal']) }}" class="btn btn-warning">Back</a>
                            @else
                                {{-- send back to dealer edit page --}}
                                <a href="{{ route('buyerdetail.multi_detail_edit', encrypt($rowId)) }}" class="btn btn-warning">Back</a>
                            @endif
                        @elseif($userType == 'pma')
                            <a href="{{ route('claimProcessing') }}" class="btn btn-warning form-control-sm mt-2">Back</a>
                        @else
                            @if($flag == 'edit')
                                {{-- send back to oem create page --}}
                                <a href="{{ route('manageBulkBuyerDetails.create', encrypt($rowId)) }}" class="btn btn-warning">Back</a>
                            @else
                                {{-- send back to oem preview page --}}
                                <a href="{{ route('buyerdetail.multi_buyer_preview', [encrypt($rowId), 'oem']) }}" class="btn btn-warning">Back</a>
                            @endif
                            
                        @endif
                    </div>
                    {{-- <div class="text-center">
                        <button class="btn btn-primary form-control-sm mt-2" type="submit"
                            id="callFunctionBtn">Update</button>
                    </div>
                    <div class="text-center">
                        <a target="_blank" href="{{ route('ack.view', $bankDetail->id) }}"
                            class="btn btn-warning form-control-sm mt-2" id="acknowledgeButton"
                            @if ($bankDetail->status == 'S') disabled @endif>Print Acknowledge</a>
                    </div> --}}
            </form>
                  
            
        </div>
    </div>

@endsection
