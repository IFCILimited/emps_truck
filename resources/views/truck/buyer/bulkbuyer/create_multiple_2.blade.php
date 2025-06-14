@extends('layouts.e_truck_dashboard_master')
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
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mb-2"> Company Detail (for bulk purchase)</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">

            <form action="{{ route('e-trucks.buyerdetail.generateId') }}" role="form" method="POST"
                class='form-horizontal modelcreate prevent-multiple-submit' files=true enctype='multipart/form-data'
                id="model_create" accept-charset="utf-8">

                @csrf

                <input type="hidden" name='oem_id' id="oem_id" value="{{ Auth::user()->oem_id }}">
                <input type="hidden" name='dealer_id' value="{{ $user->id }}">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card height-equal mt-5">
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
                                    <h4>Authorized Person Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3" id="">
                                            <label class="form-label">Authorized Person Name:</label>
                                            <input type="text" class="form-control" id="auth_per_name"
                                                name="auth_per_name">
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
                                            <label class="form-label" for="vehicle_segment">Company
                                                Type/Category:</label>
                                            <select class="form-select customer-type" id="cstm_typ" name="custmr_typ">
                                                <option selected="selected" disabled value="0">Select</option>
                                                <option value="2">Proprietory Firms/Agencies</option>
                                                <option value="3">Corporate And Partnership Agencies</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3" id="">
                                            <label class="form-label">Company Name:</label>
                                            <input type="text" class="form-control" id="custmr_name" name="custmr_name">
                                            <div class="text-center">
                                                <span class="text-primary">Company Name as per invoice</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="add">Address:</label>
                                            <input class="form-control" type="text" id="add" name="add">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="landmark">Landmark:</label>
                                            <input class="form-control" id="landmark" type="text" name="landmark">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="Pincode">Pincode:</label>
                                            <input class="form-control" type="text" name="Pincode"
                                                placeholder="Pincode" onkeyup="GetCityByPinCode('OEM', this.value, 0)">
                                            <span id="OEMpincodeMsg0" style="color:red;font-weight:bold;display: none">
                                                @error('Pincode')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="State">State:</label>
                                            <input class="form-control readonly" type="text" name="State"
                                                placeholder="State" id="OEMAddState0" readonly>
                                            @error('State')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-4 mb-3">
                                            <label class="form-label" for="District">District:</label>
                                            <input class="form-control readonly" type="text" name="District"
                                                placeholder="District" id="OEMAddDistrict0" readonly>
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
                                            <label class="form-label" for="mobile">Contact Number:</label>
                                            <input class="form-control" type="number" id="mobile" name="mobile"
                                                value="">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Additional Company Id:</label>
                                            <select class="form-select" name="addi_cust_id" id="addi_cust_id">
                                                <option selected="selected" disabled value="0">Select</option>
                                                @foreach ($type as $val)
                                                    <option value="{{ $val->id }}">{{ $val->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Additional Customer Id No.:</label>
                                            <input class="form-control" id="total_energy_capacity" type="text"
                                                value="" style="text-transform: uppercase;" name="cust_id_sec">
                                        </div>


                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Additional Company Id copy:</label>
                                            <input class="form-control" type="file" id="cust_sec_file"
                                                name="cust_sec_file">
                                            <input type="hidden" value="" name="prev_file" />
                                        </div>
                                    </div>
                                </div>

                            </div>



                            <div class="card height-equal">
                                <div class="card-header"
                                    style="display: flex;justify-content: space-between;align-items: center;">
                                    <h4>Vehicle Information</h4>
                                    <button type="button" class="btn btn-info" id="add_multi_vin">Add Row</button>
                                </div>
                                <div class="card-body">

                                    <div class="vehicle_div">
                                        <div class="row border p-3">
                                            <div class="col-4 mb-3">
                                                <label class="form-label" for="vehicle_segment">VIN Number</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input class="form-control vin_inp" id="vin"
                                                            name="vin[]">
                                                        <span class="text-danger"></span>

                                                        <input class="prod_id" type="hidden" name='production_id[]'
                                                            id="prd_id">
                                                        <input type="hidden" name="segment_id[]" id="seg_id">
                                                        <input type="hidden" name="tot_adm_inc_amt[]"
                                                            id="tot_adm_inc_amt">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-primary btn-sm p-2"
                                                            onclick="getProjectCode()">Fetch
                                                            Data</button>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="col-4 mb-3" id="">
                                                <label class="form-label" for="vehicle_segment">Category Name:</label>
                                                <input class="form-control srchV readonly ctr_name" id="sh_vehicle"
                                                    name="srch_v" readonly>
                                            </div>

                                            <div class="col-4 mb-3" id="xev">
                                                <label class="form-label" for="vehicle_segment">xEV Model
                                                    Name/Code:</label>
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
                                            <div class="col-4 mb-3" id="">
                                                <label class="form-label" for="manu_date">Manufacturing Date:</label>
                                                <input min="{{ $minDate }}" max="{{ $maxDate }}"
                                                    class="form-control srchV readonly" id="manufacturing_date"
                                                    name="manufacturing_date" readonly>

                                            </div>

                                            <div class="col-4 mb-3" id="">
                                                <label class="form-label" for="vehicle_segment">Admissible Incentive
                                                    Amount(INR)(per vehicle):</label>
                                                <input class="form-control srchV readonly" id="addmi_inc_amt"
                                                    name="addmi_inc_amt[]" readonly>
                                            </div>

                                            {{-- <div class="col-4 mb-3" id="">
                                                <label class="form-label" for="vehicle_segment">Temporary Registration Number:</label>
                                                <input class="form-control srchV readonly" id="temp_reg" name="temp_reg[]"
                                                    readonly>
    
                                            </div> --}}
                                            <div class="col-4 mb-3" id="">
                                                <label class="form-label" for="manu_date">Permanent Registration
                                                    Number:</label>
                                                <input class="form-control srchV readonly" id="perm_reg"
                                                    name="perm_reg[]" readonly>
                                            </div>
                                            <div class="col-4 mb-3" id="">
                                                <label class="form-label" for="manu_date">Permanent Registration
                                                    Date:</label>
                                                <input class="form-control srchV readonly" id="perm_reg_date"
                                                    name="perm_reg_date[]" readonly>
                                            </div>
                                            <div class="col-4 mb-3" id="">
                                                <label class="form-label" for="manu_date">Gross Vehicle Weight (GVW in
                                                    Tons):</label>
                                                <input class="form-control srchV readonly" id="gvw" name="gvw[]"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button class="btn btn-primary form-control-sm mt-2" type="submit"
                                    id="callFunctionBtn">Generate Corporate ID</button>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
        <div class="col-4">
            <a href="{{ route('e-trucks.buyerdetail.index') }}" class="btn btn-warning">Back</a>
        </div>
    </div>

    </div>
    <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
    <script>
        // prevent multiple press
        $(document).ready(function() {
            $('#model_create').on('submit', function(event) {
                //check all vins are fetched before submitting
                const prod_id = document.getElementsByClassName('prod_id');
                console.log(prod_id);
                // const prod_id = $(this).find('.prod_id')
                // console.log(prod_id);
                if ($('#model_create').valid()) {
                    for (let i = 0; i < prod_id.length; i++) {
                        // return;
                        if (prod_id[i].value.trim() == '') {
                            alert('all VIN details are required!');
                            event.preventDefault();
                            return;
                        }
                    }
                }
                // event.preventDefault();
                // return;
                $(this).find('button[type="submit"]').prop('disabled', true);
                var buttons = $(this).find('button[type="submit"]');
                setTimeout(function() {
                    buttons.prop('disabled', false);
                }, 20000); // 25 seconds in milliseconds
            });
        });


        $('#add_multi_vin').on("click", function() {
            const html = `<div class="row border mt-2"><div class="col-12 mt-2">
                                <button onclick="removeVinRow()" type="button" class="btn btn-sm btn-danger" style="float: right;">X</button>
                            </div>
                            <div class="row">
                            <div class="col-4 mb-3">
                                <label class="form-label" for="vehicle_segment">VIN Number</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control vin_inp" id="vin" name="vin[]">
                                        <span class="text-danger"></span>
                                        <input class="prod_id" type="hidden" name='production_id[]' id="prd_id">
                                        <input type="hidden" name="segment_id[]" id="seg_id">
                                        <input type="hidden" name="tot_adm_inc_amt[]" id="tot_adm_inc_amt">
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-primary btn-sm p-2" onclick="getProjectCode()">Fetch
                                            Data</button>
                                    </div>
                                </div>


                            </div>

                            <div class="col-4 mb-3" id="">
                                <label class="form-label" for="vehicle_segment">Category Name:</label>
                                <input class="form-control srchV readonly ctr_name" id="sh_vehicle" name="srch_v"
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
                            <div class="col-4 mb-3" id="">
                                <label class="form-label" for="manu_date">Manufacturing Date:</label>
                                <input min="{{ $minDate }}" max="{{ $maxDate }}"
                                    class="form-control srchV readonly" id="manufacturing_date"
                                    name="manufacturing_date" readonly>
                            </div>
                            <div class="col-4 mb-3" id="">
                                <label class="form-label" for="vehicle_segment">Admissible Incentive Amount(INR)(per vehicle):</label>
                                <input class="form-control srchV readonly" id="addmi_inc_amt" name="addmi_inc_amt[]"
                                    readonly>
                            </div>
                            <div class="col-4 mb-3" id="">
                                <label class="form-label" for="manu_date">Permanent Registration Number:</label>
                                <input
                                    class="form-control srchV readonly" id="perm_reg"
                                    name="perm_reg[]" readonly>
                            </div>
                            <div class="col-4 mb-3" id="">
                                <label class="form-label" for="manu_date">Permanent Registration Date:</label>
                                <input
                                    class="form-control srchV readonly" id="perm_reg_date"
                                    name="perm_reg_date[]" readonly>
                            </div>
                            <div class="col-4 mb-3" id="">
                                <label class="form-label" for="manu_date">Gross Vehicle Weight (GVW in Tons):</label>
                                <input
                                    class="form-control srchV readonly" id="gvw"
                                    name="gvw[]" readonly>
                            </div>
                        </div><div>`;

            $(".vehicle_div").append(html);
        });

        function removeVinRow() {
            event.target.parentNode.parentNode.remove();
        }

        $("#modal-close").on("click", function() {
            $('#vinModal').modal('hide');
        })

        let enteredVins = [];
        // vinChassis detail from production data 
        function getProjectCode() {
            const currentBtn = event.target;

            currentBtn.setAttribute("disabled", true);
            currentBtn.innerText = "Fetching...";

            const siblingElement = currentBtn.closest('.row').children[0];
            const vinElement = siblingElement.querySelector('.vin_inp');
            const rowParent = currentBtn.closest('.row.border');
            // Clear all relevant fields
            siblingElement.querySelector('.prod_id').value = "";
            siblingElement.querySelector('#seg_id').value = "";
            siblingElement.querySelector('#tot_adm_inc_amt').value = "";

            rowParent.querySelector('#addmi_inc_amt').value = "";
            rowParent.querySelector('#sh_vehicle').value = "";
            rowParent.querySelector('#xevmdl').value = "";
            rowParent.querySelector('#modl_vrnt').value = "";
            rowParent.querySelector('#segment').value = "";
            rowParent.querySelector('#ex_price').value = "";
            rowParent.querySelector('#manufacturing_date').value = "";
            rowParent.querySelector('#perm_reg').value = "";
            rowParent.querySelector('#perm_reg_date').value = "";
            rowParent.querySelector('#gvw').value = "";

            const vinElementValue = vinElement.value.trim();
            if (!vinElementValue) {
                siblingElement.querySelector('span.text-danger').innerText = 'VIN is required';
                currentBtn.removeAttribute("disabled");
                currentBtn.innerText = "Fetch Data";
                return;
            }
            siblingElement.querySelector('span.text-danger').innerText = "";

            const oemid = document.getElementById("oem_id").value;
            const token = $("input[name='_token']").val();

            $.ajax({
                url: `/e-trucks/vin/getcode/${vinElementValue}/${oemid}`,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                    if (response.data2 === 1) {
                        vinElement.value = "";
                        alert('Vehicle with this VIN is already sold');
                    } else if (!response.data1.length) {
                        vinElement.value = "";
                        alert('Please enter a correct VIN number');
                    } else if (response.data1[0].manufacturing_date) {
                        const manufacturingDate = new Date(response.data1[0].manufacturing_date);
                        const startDate = new Date('2024-04-01');
                        const endDate = new Date('2026-03-31');

                        if (manufacturingDate >= startDate && manufacturingDate <= endDate) {
                            siblingElement.querySelector('.prod_id').value = response.data1[0].id;
                            siblingElement.querySelector('#seg_id').value = response.data1[0].segment_id;
                            siblingElement.querySelector('#tot_adm_inc_amt').value = response.data3;

                            rowParent.querySelector('#addmi_inc_amt').value = response.data3;
                            rowParent.querySelector('#sh_vehicle').value = response.data1[0].vehicle_cat;
                            rowParent.querySelector('#xevmdl').value = response.data1[0].model_name;
                            rowParent.querySelector('#modl_vrnt').value = response.data1[0].variant_name;
                            rowParent.querySelector('#segment').value = response.data1[0].segment;
                            rowParent.querySelector('#ex_price').value = response.data1[0].factory_price;
                            rowParent.querySelector('#manufacturing_date').value = response.data1[0]
                                .manufacturing_date;
                            rowParent.querySelector('#gvw').value = response.data1[0].gross_weight;

                            if (response.data4) {
                                rowParent.querySelector('#perm_reg').value = response.data5;
                                // rowParent.querySelector('#perm_reg_date').value = response.data6;
                                rowParent.querySelector('#perm_reg_date').value = response.data5 ? response
                                    .data6 : '';
                            } else {
                                Swal.fire({
                                    title: 'RC Details Not Found!',
                                    text: "RC details for the entered VIN were not found. Please register your VIN on the Vahan portal first.",
                                    icon: 'warning',
                                    confirmButtonColor: '#3085d6'
                                });
                            }
                        } else {
                            alert('The manufacturing date is not between 1 April 2024 and 31 March 2026');
                        }
                    } else if (response.data1 === 'Sold') {
                        vinElement.value = "";
                        alert('Vehicle with this VIN is already sold in EMPS');
                    }

                    currentBtn.removeAttribute("disabled");
                    currentBtn.innerText = "Fetch Data";
                },
                error: function(err) {
                    console.error(err);
                    currentBtn.removeAttribute("disabled");
                    currentBtn.innerText = "Fetch Data";
                }
            });
        }

    </script>
    @include('partials.js.pincode')
    {!! JsValidator::formRequest('App\Http\Requests\CreateMultiBuyerIdRequest', '#model_create') !!}
@endpush
