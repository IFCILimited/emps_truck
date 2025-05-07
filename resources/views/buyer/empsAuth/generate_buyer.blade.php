   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
    Manage Customer Details
   @endsection

   @push('styles')
   @endpush
   @section('content')
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4> Customer Details</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage  Customer Details</li>
                               <li class="breadcrumb-item active"> Customer Details</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <div class="row">
            <div class="col-sm-12">
                <div class="card height-equal">
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <label class="form-label" for="oem_name">OEM Name</label>
                                    <input class="form-control readonly" readonly value=" {{ $bankDetail[0]['oem_name'] }}"
                                        name="oem_name" id="oem_name" type="text">
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label" for="ev_model_name">Dealer Name:</label>
                                    <input class="form-control readonly" readonly value="{{ $bankDetail[0]['dealer_name'] }}"
                                        id="ev_model_name" type="text" name="dlr_name">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label" for="dealer">Dealer code</label>
                                    <input class="form-control readonly" readonly id="dealer" readonly type="text"
                                        id="dealer" value="{{ $bankDetail[0]['dealer_code'] }}" name="dlr_code">
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
                                                id="" name="" value="{{ $bankDetail[0]['vin_chassis_no'] }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4 mb-3" id="">
                                    <label class="form-label" for="vehicle_segment">Search Vehicle:</label>
                                    <input class="form-control srchV readonly" id=""
                                        value="{{ $bankDetail[0]['vehicle_cat'] }}" name="srch_v" readonly>
                                </div>
                                <div class="col-4 mb-3" id="xev">
                                    <label class="form-label" for="vehicle_segment">xEV Model Name/Code:</label>
                                    <input class="form-control srchV readonly" id="" name="xevmodl"
                                        value="{{ $bankDetail[0]['model_name'] }}" readonly>
                                </div>
                                <div class="col-4 mb-3" id="">
                                    <label class="form-label" for="vehicle_segment">Model Variant (if
                                        any):</label>
                                    <input class="form-control srchV readonly" id=""
                                        value="{{ $bankDetail[0]['variant_name'] }}" name="modelV" readonly>
                                </div>
                                <div class="col-4 mb-3" id="">
                                    <label class="form-label" for="vehicle_segment">Model Segment:</label>
                                    <input class="form-control srchV readonly" id="" name="seg"
                                        value="{{ $bankDetail[0]['segment_name'] }}" readonly>
                                </div>
                                <div class="col-4 mb-3" id="">
                                    <label class="form-label" for="">Ex-Factory Price:</label>
                                    <input class="form-control srchV readonly" id=""
                                        value="{{ $bankDetail[0]['factory_price'] }}" name="exfactry" readonly>
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
                                            value="{{ $bankDetail[0]['custmr_typ'] == 1
                                                ? 'Individual Cases'
                                                : ($bankDetail[0]['custmr_typ'] == 2
                                                    ? 'Proprietory Firms/Agencies'
                                                    : ($bankDetail[0]['custmr_typ'] == 3
                                                        ? 'Corporate And Partnership Agencies'
                                                        : ($bankDetail[0]['custmr_typ'] == 4
                                                            ? 'Gov. Department/Defence Supply'
                                                            : ''))) }}"
                                            disabled>

                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="vehicle_segment">Gender:</label>
                                        <input type="text" class="form-control" id="gen" name="gender"
                                            value="{{ $bankDetail[0]['custmr_typ'] == 1
                                                ? ($bankDetail[0]['gender'] == 'M'
                                                    ? 'Male'
                                                    : ($bankDetail[0]['gender'] == 'F'
                                                        ? 'Female'
                                                        : ($bankDetail[0]['gender'] == 'O'
                                                            ? 'Other'
                                                            : '')))
                                                : '' }}"
                                            disabled>

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="variant_name">Customer Name:</label>
                                        <input class="form-control readonly" readonly type="text"
                                            name="custmr_name" value="{{ $bankDetail[0]['custmr_name'] }}"
                                            id="custm_name">
                                        <span class="text-danger">As mentioned in Adhaar card</span>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="variant_name">Address:</label>
                                        {{-- <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea> --}}
                                        <input class="form-control readonly" readonly type="text" id="add"
                                            value="{{ $bankDetail[0]['add'] }}" name="add">

                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="variant_name">Landmark:</label>
                                        {{-- <textarea class="form-control" name="" id="" cols="30" rows="10"></textarea> --}}
                                        <input class="form-control readonly" readonly id="variant_name"
                                            type="text" id="variant_name" name="landmark"
                                            value="{{ $bankDetail[0]['landmark'] }}">

                                    </div>
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="vehicle_segment">Pincode:</label>
                                        <input class="form-control readonly" readonly type="text" name="Pincode"
                                            placeholder=" Pincode" value="{{ $bankDetail[0]['pincode'] }}"
                                            onkeyup="GetCityByPinCode('OEM', this.value, 0)">
                                        <span id="OEMpincodeMsg0" style="color:red;font-weight:bold;display: none">
                                            @error('Pincode')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="vehicle_segment">State:</label>
                                        <input class="form-control readonly" readonly type="text" name="State"
                                            value="{{ $bankDetail[0]['state'] }}" placeholder=" State" id="OEMAddState0"
                                            readonly>
                                        @error('State')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="vehicle_segment">District:</label>
                                        <input class="form-control readonly" readonly type="text" name="District"
                                            value="{{ $bankDetail[0]['district'] }}" placeholder="District"
                                            id="OEMAddDistrict0" readonly>
                                        @error('District')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="vehicle_segment">City:</label>
                                        <input class="form-control readonly" readonly type="text" name="City"
                                            value="{{ $bankDetail[0]['city'] }}" placeholder=" City" id="OEMAddCity0">
                                        @error('City')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="variant_name">Mobile Number:</label>
                                        <input class="form-control readonly" readonly id="variant_name"
                                            type="number" id="variant_name" name="mobile"
                                            value="{{ $bankDetail[0]['mobile'] }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="variant_name">Email Id:</label>
                                        <input class="form-control readonly" readonly id="variant_name"
                                            type="text" id="variant_name" name="email"
                                            value="{{ $bankDetail[0]['email'] }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" for="dob">Date Of Birth/Incorporation Date:</label>
                                        <input class="form-control readonly" readonly id="dob" type="date" id="dob"
                                            name="dob" value="{{ $bankDetail[0]['dob'] }}">

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
                                            <option value="{{ $bankDetail[0]['custmr_id'] }}">{{ $cat->name }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Customer Id No.:</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input class="form-control readonly" readonly id="adhar_no"
                                                    type="text" value="{{ $bankDetail[0]['custmr_id_no'] }}"
                                                    name="custmr_id_no">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label" style="display: none" id="cust_id_label">Customer Id copy:</label>
                                        <br>
                                        <a class="btn btn-success btn-sm" style="display: none" id="cut_id_doc_1"
                                            href="{{ route('doc.down', encrypt($bankDetail[0]['copy_file_uploadid'])) }}">
                                            <i class="fa fa-download"></i> View Certificate
                                        </a>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Additional Customer Id:</label>
                                        <select disabled class="form-select" name="addi_cust_id"
                                            id="battery_cat_repulsion">
                                            <option selected="selected" disabled value="0">Select</option>
                                            {{-- @foreach ($type as $val)
                                                <option value="{{ $val->id }}"
                                                    @if ($val->id == $bankDetail->addi_cust_id) selected @endif>
                                                    {{ $val->name }}</option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Additional Customer Id No.:</label>
                                        <input class="form-control readonly" readonly id="total_energy_capacity"
                                            type="text" value="{{ $bankDetail[0]['cust_id_sec'] }}"
                                            name="cust_id_sec">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Additional Customer Id copy:</label><br>
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('empsdoc.down', encrypt($bankDetail[0]['sec_file_uploadeid'])) }}">
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
                                            value="{{ $bankDetail[0]['dlr_invoice_no'] }}" name="dlr_invoice_no">
                                        <span class="text-danger">As mentioned invoice copy</span>

                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">
                                            Dealer Invoice Date:</label>
                                        <input class="form-control readonly" readonly
                                            id="max_electric_energy_consumption" type="date"
                                            value="{{ date('Y-m-d', strtotime($bankDetail[0]['invoice_dt'])) }}"
                                            name="invoice_dt">

                                    </div>

                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="max_electric_energy_consumption">Vehicle
                                            Registration Date:</label>
                                        <input class="form-control readonly" readonly
                                            id="max_electric_energy_consumption" type="date"
                                            value="{{ date('Y-m-d', strtotime($bankDetail[0]['vihcle_dt'])) }}"
                                            name="">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Invoice Amount(INR)(per vehicle):</label>
                                        <input class="form-control readonly" readonly id="minimum_acceleration"
                                            type="number" value="{{ $bankDetail[0]['invoice_amt'] }}"
                                            name="invoice_amt">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Admissible Incentive Amount(INR)(per
                                            vehicle):</label>
                                        <input class="form-control readonly" readonly id="minimum_acceleration"
                                            type="number" value="{{ $bankDetail[0]['addmi_inc_amt'] }}"
                                            name="addmi_inc_amt">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Total Invoice Amount(INR):</label>
                                        <input class="form-control readonly" readonly id="minimum_acceleration"
                                            type="number" value="{{ $bankDetail[0]['tot_inv_amt'] }}"
                                            name="tot_inv_amt">
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Total Admissible Incentive Amount(INR):</label>
                                        <input class="form-control readonly" readonly id="minimum_acceleration"
                                            type="number" value="{{ $bankDetail[0]['tot_admi_inc_amt'] }}"
                                            name="tot_admi_inc_amt">
                                    </div>
                                    <div class="col-4 mb-3 ">
                                        <label class="form-label" for="minimax_speed">Amount Payable by Customer
                                            (INR):</label>
                                        <input class="form-control readonly" readonly id="minimax_speed"
                                            type="number" value="{{ $bankDetail[0]['amt_custmr'] }}" name="amt_custmr">
                                        <span class="text-danger">Amount after deduction of EMPS-2024
                                            Incentive</span>
                                    </div>


                                    <div class="col-4 mb-3">
                                        <label class="form-label" for="discount">Discount Given</label>
                                        <input class="form-control readonly" readonly name="discount" id="discount"
                                               type="text" value="{{ $bankDetail[0]['discount_given'] ? 'YES' : 'NO' }}">
                                    </div>

                                    <div class="col-4 mb-3" id="discountFieldContainer"
                                        style="display: {{ $bankDetail[0]['discount_given'] == 1 ? 'block' : 'none' }};">
                                        <label class="form-label" for="discountAmount">Discount Amount</label>
                                        <input type="text" class="form-control readonly" readonly
                                            value="{{ $bankDetail[0]['discount_amt'] }}" name="discountAmount"
                                            id="discountAmount" placeholder="Enter discount amount">
                                    </div>
                                    <div class="col-4 mb-3 " id="empField"
                                        style="display: {{ $bankDetail[0]['discount_given'] == 1 ? 'block' : 'none' }};">
                                        <label class="form-label" for="minimax_speed">Emps 2024</label>
                                        <input class="form-control readonly" readonly name="empsBeforeAfter"
                                        type="text" value="{{ $bankDetail[0]['empsbeforeafter'] == 'Before' ? 'Before' : 'After' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- <form action="{{ route('ack.update', $bankDetail->id) }}" role="form" method="POST"
        class='form-horizontal modelcreate' files=true enctype='multipart/form-data' id="model_create"
        accept-charset="utf-8">
        @csrf
        @method('patch') --}}
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
                                type="date" value="{{ date('Y-m-d', strtotime($bankDetail[0]['vihcle_dt'])) }}"
                                name="vihcle_dt">
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label" for="">
                                Vehicle Registration Number:</label>
                            <input class="form-control readonly" readonly id="" type="text"
                                name="vhcl_regis_no" readonly value="{{ $bankDetail[0]['vhcl_regis_no'] }}">
                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label" for="range">Customer Acknowledgement:</label><br>
                            <a class="btn btn-success btn-sm"
                                href="{{ route('empsdoc.down', encrypt($bankDetail[0]['cst_ack_file'])) }}">
                                <i class="fa fa-download"></i> View Certificate
                            </a>

                        </div>
                        <div class="col-4 mb-3">
                            <label class="form-label" for="max_electric_energy_consumption">
                                Vehicle Invoice Copy:</label><br>
                            <a class="btn btn-success btn-sm"
                                href="{{ route('empsdoc.down', encrypt($bankDetail[0]['invc_copy_file'])) }}">
                                <i class="fa fa-download"></i> View Certificate
                            </a>
                        </div>
                        <div class="col-4 mb-3 ">
                            <label class="form-label" for="minimax_speed">Vehicle Registration
                                Copy:</label><br>
                            <a class="btn btn-success btn-sm"
                                href="{{ route('empsdoc.down', encrypt($bankDetail[0]['vhcl_reg_file'])) }}">
                                <i class="fa fa-download"></i> View Certificate
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
    <div class="card-header d-flex justify-content-between align-items-center position-relative">
        <div class="col-4">
            <a href="{{ route('empsbuyer.index') }}" class="btn btn-warning form-control-sm mt-2" id="">Back</a>
        </div>
        <div class="position-absolute start-50 translate-middle">
            <a href="{{ route('empsbuyer.create', ['emps_id' => $bankDetail[0]['id'], 'data' => json_encode($bankDetail)]) }}"
                id="generateCustomerIdBtn" class="btn btn-sm btn-primary">Generate Customer ID</a>
        </div>
    </div>
</div>


       </div>
   @endsection
   @push('scripts')

   {!! JsValidator::formRequest('App\Http\Requests\EmpsAuthRequest', '#empsAuth') !!}
    <script>

$(document).ready(function() {
    // Update Button click handler
    $('#updateBtn').on('click', function() {
        // Update the form action and status
        $('#formAction').val('D');

        // Optionally, submit the form if needed, or perform additional actions
        $('form').submit(); // Uncomment this line to submit the form after updating status
        console.log('Form action updated to D');
    });

    // Submit to OEM Button click handler
    $('#submitToOEMBtn').on('click', function() {
        // Show SweetAlert confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to submit to OEM?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit!',
            cancelButtonText: 'No, cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                // Update the form action and status
                $('#formAction').val('S');

                // Optionally, submit the form or send the data to the server
                $('form').submit(); // Uncomment to submit the form after status update
                console.log('Form action updated to S');
            }
        });
    });
});

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


        document.getElementById('generateCustomerIdBtn').addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default action
        const url = this.href; // Get the URL from the button's href
 
        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to generate a Customer ID?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, generate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the URL if confirmed
                window.location.href = url;
            }
        });
    });
    </script>
   @endpush
