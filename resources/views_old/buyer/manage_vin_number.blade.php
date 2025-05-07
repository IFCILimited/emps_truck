   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Manage Buyer Details
   @endsection

   @push('styles')
   @endpush
   @section('content')
       <div class="page-body">
           <div class="container-fluid">
                <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>Edit/Release VIN</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item active">Edit/Release VIN</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">
            <form action="{{route("manage_vin_number.get_customer")}}" method="post">
                @csrf

                <div class="d-flex justify-content-center align-items-center"> 
                    <div class="card mt-4" style="width: 60% !important;"> 
                        <div class="card-header pb-0 card-no-border">
                            <h6>Search Customer Id</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8"> 
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="vin_num" value="@if(isset($buyerId)){{$buyerId}}@endif" required placeholder="Enter Customer ID"/>
                                    </div>
                                </div>
                                <div class="col-4 d-flex align-items-end"> 
                                    <button type="submit" class="btn btn-success w-100">Fetch Details</button> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </form>
            @if(!$isIndex)
                @if(!isset($details))
                <div class="col-sm-12 mt-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <span class="text-danger">No details found for entered Customer Id.</span>
                        </div>
                    </div>
                </div>
                @else
                    <div class="row mt-4">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header pb-0 card-no-border">
                                    <h4>Customer Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="dt-ext table-responsive  custom-scrollbar">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                @if(!$isBulk)
                                                <tr>
                                                    <th class="text-center">Customer Name</th>
                                                    <th class="text-center">VIN Number</th>
                                                    <th class="text-center">Model</th>
                                                    <th class="text-center">Segment</th>
                                                    <th class="text-center">Factory Price</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                                @else
                                                <tr>
                                                    <th class="text-center">Customer Name</th>
                                                    <th class="text-center">Authorized Person Name</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                                @endif
                                            </thead>
                                            <tbody>
                                                
                                                <tr>
                                                    @if(!$isBulk)
                                                    <td>{{$details->custmr_name}}</td>
                                                    <td>{{$details->vin_chassis_no}}</td>
                                                    <td>{{$details->model_name}}</td>
                                                    <td>{{$details->segment_name}}</td>
                                                    <td>{{$details->factory_price}}</td>
                                                    <td>
                                                        <div>
                                                            @if($details->oem_status == 'A' || $details->status == 'A')
                                                                <button style="width: 100%" type="button" class="btn btn-primary mt-2" disabled>Submitted</button>
                                                            @else
                                                                {{-- <button @if(!is_null($details->oem_status) && $details->oem_status == 'A') disabled @endif data-method="release" style="width: 80%" type="button" class="openModal btn btn-sm btn-primary text-uppercase" data-toggle="modal" data-target="#confirm"> --}}
                                                                    <button @if($details->oem_status == 'A') disabled @endif data-method="release" style="width: 80%" type="button" class="openModal btn btn-sm btn-primary text-uppercase" data-toggle="modal" data-target="#confirm">
                                                                    Release VIN
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    @else
                                                    <td>{{$details->customer_name}}</td>
                                                    <td>{{$details->auth_prs_name}}</td>
                                                    <td>
                                                        <div>
                                                            @if($details->oem_status == 'A' || $details->status == 'A')
                                                                <button style="width: 100%" type="button" class="btn btn-primary mt-2" disabled>Submitted</button>
                                                            @else
                                                                <button @if(!is_null($details->oem_status) && $details->oem_status != 'D') disabled @endif data-method="release" style="width: 80%" type="button" class="openModal btn btn-sm btn-primary text-uppercase" data-toggle="modal" data-target="#confirm">
                                                                    Release VIN
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                    @endif
                                                    
                                                </tr>
                                                    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
                                <form id="updateForm" action="{{ route('manage_vin_number.update', encrypt($details->id)) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="col-12">
                                            <div class="form-group" id="form_field">
                                                <label>Remarks*</label>
                                                <textarea id="remkr" class="form-control" name="remarks" rows="4" required></textarea>
                                                <input id="action" type="hidden" name="action" readonly value="" />
                                                <input id="type" type="hidden" name="type" value="{{$isBulk}}" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-12 form-error text-danger"></div>
                                        <div class="col-12 form-message text-success"></div>
                                        <div id="doc_link"></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button id="check_btn" type="submit" class="btn btn-primary" style="background-color: #007bff; border: none;">Yes!</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                @endif
            @endif
           </div>


       </div>
   @endsection
   @push('scripts')
   <script>

$(document).ready(function() {
        $('#check_btn').on("click", function(event) {
            event.preventDefault(); // Prevent default form submission

            $('.form-error').text(""); // Clear any existing error messages

            // Check if the remarks field is empty
            if ($('#remkr').val().trim() === "") {
                $('.form-error').text("The remarks field is required!");
                return; // Exit if the field is empty
            }

            // Show SweetAlert confirmation
            Swal.fire({
            title: "Warning!",
            text: "Proceeding this request will relase all the VINs associated with the entered customer ID, and you will not be able to retrieve it again",
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

// Add inline styles after the SweetAlert is shown
$('.swal2-confirm').css('margin-right', '10px'); // Space between buttons

        });
    });


    $('.openModal').on("click", function(){
        $('#remkr').val("");
        $('.form-error').text("");
        $('#action').val(event.target.getAttribute("data-method"));
        $('#confirm').modal('show');
    })

    $('.close').on("click", function(){
        $('#confirm').modal('hide');
    })
   </script>
   @endpush
