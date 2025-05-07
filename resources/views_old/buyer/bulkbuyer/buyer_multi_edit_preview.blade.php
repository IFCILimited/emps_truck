@extends('layouts.dashboard_master')
@section('title')
    Company Details (for bulk purchase)
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
                        <h4 class="mb-2">Company Detail (for bulk purchase)</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <form action="{{ route('buyerdetail.multi_update', $bankDetail->id) }}" role="form" method="POST"
                class='form-horizontal modelcreate' files=true enctype='multipart/form-data' id="model_create"
                accept-charset="utf-8">

                @csrf
                @method('patch')

                <input type="hidden" name='oem_id' id="oem_id" value="{{ Auth::user()->oem_id }}">
                <input type="hidden" name='dealer_id' value="{{ $user->id }}">
                <input type="hidden" value="{{ $bankDetail->segment_id }}" class="form-control" id="seg_id"
                    name="segment_id">
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
                                            <input class="form-control readonly" type="text" id="add"
                                                value="{{ str_replace('null', '', $multiBuyerDetail->cmpny_addr) }}"
                                                name="add" readonly>
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
                                            <input class="form-control" id="total_energy_capacity" type="text"
                                                value="{{ $bankDetail->cust_id_sec }}"
                                                style="text-transform: uppercase;" name="cust_id_sec">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Additional Company Id copy:</label>
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
                                <div class="card-body">
                                    <table class="table table-stripped table-bordered" id="multiVinTable">
                                        <tr>
                                            <th>VIN Number</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach($vins as $vin => $bd_id)
                                        <tr>
                                            <td>
                                                <div class="row">
                                                    <div class="col-4 mb-3">
                                                        <label class="form-label" for="vehicle_segment">VIN Number</label>
                                                        
                                                        <input class="form-control readonly" id="vin" name="vin[]" value="{{ $vin }}" readonly>
                                                        <span class="text-danger"></span>

                                                        <input type="hidden" name='production_id[]' id="prd_id" value="{{$productionDetails[$vin]->production_id}}">
                                                        <input type="hidden" name="segment_id[]" id="seg_id" value="{{$productionDetails[$vin]->segment_id}}">
                                                           
            
            
                                                    </div>
                                                    <div class="col-4 mb-3" id="">
                                                        <label class="form-label" for="vehicle_segment">Category Name:</label>
                                                        <input class="form-control srchV readonly" id="sh_vehicle" name="srch_v"
                                                            readonly value="{{$productionDetails[$vin]->vehicle_cat}}">
                                                    </div>
            
                                                    <div class="col-4 mb-3" id="xev">
                                                        <label class="form-label" for="vehicle_segment">xEV Model Name/Code:</label>
                                                        <input class="form-control srchV readonly" id="xevmdl" name="xevmodl"
                                                            readonly value="{{$productionDetails[$vin]->model_name}}">
            
                                                    </div>
                                                    <div class="col-4 mb-3" id="">
                                                        <label class="form-label" for="vehicle_segment">Model Variant (if
                                                            any):</label>
                                                        <input class="form-control srchV readonly" id="modl_vrnt" name="modelV"
                                                            readonly value="{{$productionDetails[$vin]->variant_name}}">
            
                                                    </div>
                                                    <div class="col-4 mb-3" id="">
                                                        <label class="form-label" for="vehicle_segment">Model Segment:</label>
                                                        <input class="form-control srchV readonly" id="segment" name="seg"
                                                            readonly value="{{$productionDetails[$vin]->segment_name}}">
                                                        
            
                                                    </div>
                                                    <div class="col-4 mb-3" id="">
                                                        <label class="form-label" for="vehicle_segment">Ex-Factory Price:</label>
                                                        <input class="form-control srchV readonly" id="ex_price" name="exfactry"
                                                            readonly value="{{$productionDetails[$vin]->factory_price}}">
            
                                                    </div>
                                                    <div class="col-4 mb-3" id="">
                                                        <label class="form-label" for="manu_date">Manufacturing Date:</label>
                                                        <input min="{{ $minDate }}" max="{{ $maxDate }}"
                                                            class="form-control srchV readonly" id="manufacturing_date"
                                                            name="manufacturing_date" readonly value="{{$productionDetails[$vin]->manufacturing_date}}">
            
                                                    </div>
                                                    <div class="col-4 mb-3" id="">
                                                        <label class="form-label" for="vehicle_segment">Temporary Registration Number:</label>
                                                        <input class="form-control srchV readonly" id="ex_price" name="exfactry"
                                                            readonly value="{{$productionDetails[$vin]->temp_reg_no}}">
            
                                                    </div>
                                                    <div class="col-4 mb-3" id="">
                                                        <label class="form-label" for="manu_date">Permanent Registration Number:</label>
                                                        <input
                                                            class="form-control srchV readonly" id="manufacturing_date"
                                                            name="manufacturing_date" readonly value="{{$productionDetails[$vin]->vhcl_regis_no}}">
            
                                                    </div>
                                                    <div class="col-4 mb-3" id="">
                                                        <label class="form-label" for="manu_date">Permanent Registration Date:</label>
                                                        <input
                                                            class="form-control srchV readonly" id="perm_reg_date"
                                                            name="perm_reg_date[]" readonly value="{{ date('Y-m-d', strtotime($productionDetails[$vin]->vihcle_dt)) }}">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if( $userType == "deal" )
                                                    <a href="{{ route('buyerdetail.manage_invoice_preview', [$bd_id, encrypt($rowId), 'prev', 'deal']) }}" class="btn btn-info">View</a>
                                                @else
                                                    <a href="{{ route('buyerdetail.manage_invoice_preview', [$bd_id, encrypt($rowId), 'prev', 'oem']) }}" class="btn btn-info">View</a>
                                                @endif
                                            </td>
                                            
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>

                <div class="text-left">
                    @if( $userType == "deal" )
                        <a href="{{ route('buyerdetail.multi_buyers') }}" class="btn btn-warning">Back</a>
                    @else
                        {{-- <a href="{{ route('manageBulkBuyerDetails.index', 'A') }}" class="btn btn-warning">Back</a> --}}
                        <a href="{{ route('manageBulkBuyerDetails.index', $multiBuyerDetail->oem_status) }}" class="btn btn-warning">Back</a>
                    @endif
                </div>
                
                
                    
            </form>
                    
            
        </div>
    </div>

@endsection
