@extends('layouts.e_truck_dashboard_master')

@section('title')
    OEM Production Data
@endsection

@section('content')
    <div class="page-body">
        <div class="container">
            <div class="col-xl-12 mt-3">
                <form action="{{route('e-trucks.manageCompanyDetails.update', $details->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @php
                    $exsitingDetails = json_decode($details->previous_info, true);
                    $updatedDetails = json_decode($details->updated_info, true);
                    $docsUploaded = json_decode($details->uploaded_docs, true);
                    // print_r($docsUploaded);
                    // die();
                    @endphp

                    <div class="card">
                        <div class="card-header">
                            <h2>Existing Details</h2>
                        </div>
                        <div class="card-body">
                            <div class="card" id="comp_details">
                                <div class="card-header">
                                    <div class="h5">
                                        Company Details
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mt-2">
                                            <label>Name</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_cust_name']}}" readonly name="exist_cust_name"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Email Id</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_cust_email']}}" readonly name="exist_cust_email"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Contact Number</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_cust_mobile']}}" readonly name="exist_cust_mobile"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>GSTIN</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_cust_gst']}}" readonly name="exist_cust_gst"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Address</label>
                                            <textarea class="form-control readonly" readonly name="exist_cust_addr">{{$exsitingDetails['exist_cust_addr']}}</textarea>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>city</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_cust_city']}}" readonly name="exist_cust_city"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>District</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_cust_dist']}}" readonly name="exist_cust_dist"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Landmark</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_cust_land']}}" readonly name="exist_cust_land"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>State</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_cust_state']}}" readonly name="exist_cust_state"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Pincode</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_cust_pincode']}}" readonly name="exist_cust_pincode"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card" id="auth_details">
                                <div class="card-header">
                                    <div class="h5">
                                        Authorized Person Details
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mt-2">
                                            <label> Name</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_auth_name']}}" name="exist_auth_name" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label> Email Id</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_auth_email']}}" name="exist_auth_email" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Contact Number</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_auth_mobile']}}" name="exist_auth_mobile" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Address</label>
                                            <textarea class="form-control readonly" readonly name="exist_auth_addr">{{$exsitingDetails['exist_auth_addr']}}</textarea>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>city</label> 
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_auth_city']}}" readonly name="exist_auth_city"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>District</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_auth_dist']}}" readonly name="exist_auth_dist"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Landmark</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_auth_land']}}" readonly name="exist_auth_land"/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>State</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_auth_state']}}" readonly name="exist_auth_state"/>
                                        </div>
                                        <div class="col-md-4 mt-2" id="auth_pincode">
                                            <label>Pincode</label>
                                            <input class="form-control readonly" type="text" value="{{$exsitingDetails['exist_auth_pincode']}}" readonly name="exist_auth_pincode"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2>Update Details</h2>
                        </div>
                        <div class="card-body">
                            <div id="update_card_table">
                                <div class="card-header">
                                    <div class="h5">
                                        Company Details
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mt-2">
                                            <label>Name</label>
                                            <input class="form-control readonly" type="text" value="{{$updatedDetails['cust_name']}}" name="cust_name" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Email Id</label>
                                            <input class="form-control readonly" type="text" value="{{$updatedDetails['cust_mail']}}" name="cust_mail" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Contact Number</label>
                                            <input class="form-control readonly" type="text" value="{{$updatedDetails['cust_mobile']}}" name="cust_mobile" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>GSTIN</label>
                                            <input class="form-control readonly" type="text" value="{{$updatedDetails['cust_gst']}}" name="cust_gst" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Address</label>
                                            <textarea class="form-control readonly" name="cust_addr" readonly>{{$updatedDetails['cust_addr']}}</textarea>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label" for="City">City:</label>
                                                <select class="form-control readonly" name="cust_city" id="CUSTAddCity0" readonly>
                                                    <option class="form-control" selected value="{{$updatedDetails['cust_city']}}">{{$updatedDetails['cust_city']}}</option>
                                                </select>
                                                @error('City')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>District</label>
                                            <input id="CUSTAddDistrict0" class="form-control readonly" type="text" value="{{$updatedDetails['cust_dist']}}" name="cust_dist" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Landmark</label>
                                            <input class="form-control readonly" type="text" value="{{$updatedDetails['cust_land']}}" name="cust_land" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>State</label>
                                            <input id="CUSTAddState0" class="form-control readonly" type="text" value="{{$updatedDetails['cust_state']}}" name="cust_state" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label" for="Pincode">Pincode:</label>
                                                <input class="form-control readonly" type="text" name="cust_pincode"
                                                    placeholder="Pincode"
                                                    onkeyup="GetCityByPinCode('CUST', this.value, 0)" value="{{$updatedDetails['cust_pincode']}}" readonly>
                                                <span id="CUSTpincodeMsg0"
                                                    style="color:red;font-weight:bold;display: none">
                                                    @error('Pincode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-header">
                                    <div class="h5">
                                        Authorized Person Details
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mt-2">
                                            <label> Name</label>
                                            <input class="form-control readonly" type="text" value="{{$updatedDetails['auth_name']}}" name="auth_name" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label> Email Id</label>
                                            <input class="form-control readonly" type="text" value="{{$updatedDetails['auth_email']}}" name="auth_email" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Contact Number</label>
                                            <input class="form-control readonly" type="text" value="{{$updatedDetails['auth_mobile']}}" name="auth_mobile" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Address</label>
                                            <textarea class="form-control readonly" name="auth_addr" readonly>{{$updatedDetails['auth_addr']}}</textarea>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label class="form-label" for="City">City:</label>
                                                <select class="form-control readonly" name="auth_city" id="AUTHAddCity0" readonly>
                                                    <option class="form-control" selected value="{{$updatedDetails['auth_city']}}">{{$updatedDetails['auth_city']}}</option>
                                                </select>
                                                @error('City')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>District</label>
                                            <input id="AUTHAddDistrict0" class="form-control readonly" type="text" value="{{$updatedDetails['auth_dist']}}" name="auth_dist" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>Landmark</label>
                                            <input class="form-control readonly" type="text" value="{{$updatedDetails['auth_land']}}" name="auth_land" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2">
                                            <label>State</label>
                                            <input id="AUTHAddState0" class="form-control readonly" type="text" value="{{$updatedDetails['auth_state']}}" name="auth_state" readonly/>
                                        </div>
                                        <div class="col-md-4 mt-2" id="auth_pincode">
                                            <label class="form-label" for="Pincode">Pincode:</label>
                                                <input class="form-control readonly" type="text" name="auth_pincode"
                                                    placeholder="Pincode"
                                                    onkeyup="GetCityByPinCode('AUTH', this.value, 0)" value="{{$updatedDetails['auth_pincode']}}" readonly>
                                                <span id="AUTHpincodeMsg0"
                                                    style="color:red;font-weight:bold;display: none">
                                                    @error('Pincode')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </span> 
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h2>Required Documents</h2>
                        </div>
                        <div class="col-12" style="max-width: 90%;margin: 0 auto;">
                            <table class="table stripped" style="padding: 0 1rem">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Doc Name</th>
                                        <th>Uploaded File</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                @foreach($docs as $doc)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <th>{{$doc->doc_name}}</th>
                                    <td class="text-center">
                                        @if(isset($docsUploaded[$doc->file_name]))
                                        <a class="btn btn-success btn-sm"
                                            href="{{ route('doc.down', encrypt($docsUploaded[$doc->file_name])) }}">
                                            <i class="fa fa-download"></i> View Document
                                        </a>
                                        @else
                                            NA
                                        @endif
                                    </td>
                                    {{-- <td>
                                        <input class="form-control" type="file" name="{{$doc->file_name}}" />
                                    </td> --}}
                                </tr>
                                @endforeach
                            </table>
                            {{-- <div class="col-12 text-center mt-2 mb-2">
                                <button type="submit" class="btn btn-info" name="update">Update</button>
                                <button id="submit_to_pma" type="button" class="btn btn-primary" name="submit">Submit</button>
                                <a class="btn btn-danger" href="{{route('manageCompanyDetails.index')}}">Back</a>
                            </div> --}}
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @if(Auth::user()->hasRole('PMA') && $details->pma_status == 'P')
                            {{-- @if(!$details->pma_status) --}}
                                <div class="col-12 d-flex justify-content-between">
                                    <button data-val="accept" type="button" class="pma_act btn btn-success">Approve</button>
                                    <button data-val="reject" type="button" class="pma_act btn btn-danger">Reject</button>
                                    <a class="btn btn-info" href="{{route('e-trucks.manageCompanyDetails.index')}}">Back</a>
                                </div>
                            {{-- @else --}}

                            {{-- @endif --}}
                            @else
                            <div class="col-12">
                                @if($details->pma_remark)
                                    <label>PMA REMARK</label>
                                    <textarea class="form-control readonly" readonly>{{$details->pma_remark}}</textarea>
                                    <span>Remarked on : {{$details->pma_action_at}}</span><br>
                                @endif
                                <a class="btn btn-info mt-2" href="{{route('e-trucks.manageCompanyDetails.index')}}">Back</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>
                {{-- <form id="submit_pma" method="post" action="{{route('manageCompanyDetails.submitToPma')}}">
                    @csrf
                    <input type="hidden" name="row_id" value="{{$details->id}}" />
                    <input type="hidden" name="action" id="pma_act_input"/>
                    <input type="hidden" name="remarks"/>
                </form> --}}
            </div>
        </div>
    </div>


    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #f8f9fa; color: #333;">
                    <h3 class="modal-title" style="margin: 0;"><b>Are you sure?</b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: transparent; border: none; color: #000; border-radius: 50%; width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                        <span aria-hidden="true" style="font-size: 1.5rem;">&times;</span>
                    </button>
                </div>
                <form id="updateForm" action="{{ route('e-trucks.manageCompanyDetails.submitToPma') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="form-group" id="form_field">
                                <div id="remark_div">
                                    <label>Remarks*</label>
                                    <textarea id="remkr" class="form-control" name="remarks" rows="4"></textarea>
                                </div>
                                <div id="file_div">
                                    <label>Upload Approve Doc*</label>
                                    <input id="app_doc" class="form-control" type="file" name="appr_doc" accept=".pdf"/>
                                </div>
                                <input id="action" type="hidden" name="action" readonly value="reject" />
                                <input type="hidden" name="row_id" value="{{$details->id}}" />
                            </div>
                        </div>
                        <div class="col-12 form-error text-danger"></div>
                        <div class="col-12 form-message text-success"></div>
                    </div>
                    <div class="modal-footer">
                        <button id="check_btn" type="button" class="btn btn-primary" style="background-color: #007bff; border: none;">Reject</button>
                        <button type="button" class="close btn btn-danger" style="background-color: #007bff; border: none;">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>

        $('#check_btn').on("click", function(event) {
            event.preventDefault(); // Prevent default form submission

            $('.form-error').text(""); // Clear any existing error messages
            // console.log($('#action').val(), $('#app_doc')[0].files);
            if($('#action').val() == 'reject') {
                // Check if the remarks field is empty
                if ($('#remkr').val().trim() === "") {
                    $('.form-error').text("The remark field is required!");
                    return; // Exit if the field is empty
                }
            }else{
                if($('#app_doc')[0].files.length == 0){
                    $('.form-error').text("The file is required!");
                    return;
                }
                if($('#app_doc')[0].files.length > 0 && $('#app_doc')[0].files[0].size > 2 * 1024 * 1024){
                    $('.form-error').text("Upload file less than 2 MB!");
                    return;
                }
            }

            // Show SweetAlert confirmation
            Swal.fire({
                title: "Warning!",
                text: "You are about to submit the form. Are you sure you want to proceed?",
                icon: "warning",
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "Cancel",
                denyButtonText: "Proceed",
                customClass: {
                    confirmButton: 'btn btn-secondary',
                    denyButton: 'btn btn-primary'
                },
                buttonsStyling: false // Disable SweetAlert default styling
            }).then((result) => {
                if (result.isDenied) {
                    $('#updateForm').submit(); // Submit the form if confirmed
                }
            });
        });


    $('.pma_act').on('click', function(){
        let attr = $(this).attr("data-val")
        // if(attr == "accept") {
        //     Swal.fire({
        //     title: "Warning!",
        //     text: "Are you sure you want to proceed?",
        //     icon: "warning",
        //     showDenyButton: true,
        //     showCancelButton: false,
        //     confirmButtonText: "Cancel",
        //     denyButtonText: "Proceed",
        //     customClass: {
        //         confirmButton: 'btn btn-secondary',
        //         denyButton: 'btn btn-primary'
        //     },
        //     buttonsStyling: false // Disable SweetAlert default styling
        //     }).then((result) => {
        //         if (result.isDenied) {
        //             $('#pma_act_input').val(attr);
        //             $('#submit_pma').submit(); // Submit the form if confirmed
        //         }
        //     });

        //     return;
        // }


        if(attr == "reject") {
            $('#remark_div').show();
            $('#file_div').hide();
            $('#remkr').val("");
            $('#action').val("reject");
            $('#check_btn').text("Reject");
            
        }else{
            $('#remark_div').hide();
            $('#file_div').show();
            $('#app_doc').val("");
            $('#action').val("accept") ;
            $('#check_btn').text("Accept");

        }
        $('.form-error').text("");
        $('#confirm').modal('show');
    })

    $('.close').on("click", function(){
        $('#confirm').modal('hide');
    })

    $('#submit_to_pma').on('click', function(){
        Swal.fire({
            title: "Warning!",
            text: "You are about to submit the form. Are you sure you want to proceed?",
            icon: "warning",
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: "Cancel",
            denyButtonText: "Proceed",
            customClass: {
                confirmButton: 'btn btn-secondary',
                denyButton: 'btn btn-primary'
            },
            buttonsStyling: false // Disable SweetAlert default styling
        }).then((result) => {
            if (result.isDenied) {
                $('#submit_pmd').submit(); // Submit the form if confirmed
            }
        });    
    })
</script>

@include('partials.js.pincode')

{{-- {!! JsValidator::formRequest('App\Http\Requests\CreateMultiBuyerIdRequest', '#model_create') !!} --}}

@endpush
