   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Claim Generate
   @endsection

   @push('styles')
   @endpush
   @section('content')
       <!-- Page Sidebar Ends-->
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>Claim Generate</h4>
                       </div>
                       {{-- <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage Bank Details</li>
                               <li class="breadcrumb-item active">Bank Details</li>
                           </ol>
                       </div> --}}
                   </div>
               </div>
           </div>
           <div class="container-fluid">
               <div class="row">
                    {{-- <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 offset-2">
                                    <label for="select_modSeg">Model Segment:</label>
                                    <select name="mod_seg" class="form-select" id="select_modSeg">
                                        <option value="" disabled selected>SELECT</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="select_modName">Model Name:</label>
                                    <select name="mod_name" class="form-select" id="select_modName">
                                        <option value="" disabled selected>SELECT</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                            <br>
                            <br>
                            <div class="row">
                            <div class="text-center">
                                <input type="submit" name="" value="Search" id="search" class="btn btn-primary" />
                                <input type="submit" name="" value="Clear" id="clear" class="btn btn-danger " />
                            </div>
                            </div>
                        </div>
                    </div> --}}
                    <form action="{{route('claimGenerate.store')}}" role="form" method="post" class='form-horizontal' id='proceedClaimForm'
                        files=true enctype='multipart/form-data' accept-charset="utf-8">
                    @csrf
                   <div class="col-sm-12">
                       <div class="card">
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        {{-- <tr>
                                            <th scope="col"></th>
                                            <th scope="col">S.No.</th>
                                            <th scope="col">Model Segment</th>
                                            <th scope="col">Model Name</th>
                                            <th scope="col">Dealer Name</th>
                                            <th scope="col">Dealer Code</th>
                                            <th scope="col">Invoice No.</th>
                                            <th scope="col">No. of Vehicle Purchased</th>
                                            <th scope="col">Total Incentives</th>
                                            <th scope="col">Invoice Date</th>
                                            <th scope="col">Vin Chassis No.</th>
                                            <th scope="col">Total Incentives</th>
                                            <th scope="col">Incentive Amount</th>
                                            <th scope="col">Customer Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Mobile No.</th>
                                            <th scope="col">Email Id</th>
                                            <th scope="col">Invoice Date</th>
                                            <th scope="col">View</th>
                                        </tr> --}}
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">S.No.</th>
                                            <th scope="col">Model Segment</th>
                                            <th scope="col">Model Name</th>
                                            {{-- <th scope="col">Dealer Name</th> --}}
                                            {{-- <th scope="col">Dealer Code</th> --}}
                                            <th scope="col">Invoice No.</th>
                                            {{-- <th scope="col">No. of Vehicle Purchased</th> --}}
					     <th scope="col">Total Invoice Amount</th>
                                           <th scope="col">Total Incentives</th>
                                            <th scope="col">Invoice Date</th>
                                            <th scope="col">Vin Chassis No.</th>
                                            {{-- <th scope="col">Total Incentives</th> --}}
                                            <th scope="col">Invoice Amount</th>
                                            <th scope="col">Customer Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Mobile No.</th>
                                            <th scope="col">Email Id</th>
                                            {{-- <th scope="col">Invoice Date</th> --}}
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($array as $arr)
                                        {{-- <tr>
                                            <th scope="row">
                                                <input type="checkbox" name="check[{{$arr}}]" buyerid="{{$arr}}" class="btnShowClass" checked/>
                                                 <input type="hidden" name="vehicleTot" id="vehicleTotCount" value=""> 
<div id="vcat"></div>
                                            </th>
                                            <th>{{$loop->iteration}}</th>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td><a href="javascript:void(0);" id="btnShow" buyerid="{{$arr}}">{{$arr}}</a></td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>Test{{$arr}}</td>
                                            <td>
                                                    <a href="{{route('ackdoc.finalview',$buyer->id)}}" class="btn btn-sm btn-warning">View</a>
                                            </td>
                                        </tr> --}}

                                        <tr>
                                            @php
                                                $sn = $loop->iteration;
                                            @endphp
                                            <td scope="row">
                                                <input type="checkbox" name="check[{{$sn}}]" buyerid="{{($arr->id)}}" class="btnShowClass" value="{{($arr->id)}}" checked/>
                                                {{-- <input type="hidden" name="vehicleTot" id="vehicleTotCount" value="">  --}}
                                                <div id="vcat"></div>
                                            </td>
                                            <th>{{$sn}}</th>
                                            <td>{{$arr->segment_name ?? 'NA'}}</td>
                                            <td>{{$arr->model_name ?? 'NA'}}</td>
                                            {{-- <td>{{$arr->dealer_id ?? 'N/A'}}</td> --}}
                                            {{-- <td>{{$arr->segment_id ?? 'N/A'}}</td> --}}
                                            <td>{{$arr->dlr_invoice_no ?? 'N/A'}}</td>
                                            {{-- <td>{{$arr->segment_id ?? 'N/A'}}</td> --}}
					    <td style="text-align:right;">
                                                {{$arr->tot_inv_amt ?? 'N/A'}}
                                            </td>
                                            <td style="text-align:right;">
                                                {{$arr->tot_admi_inc_amt ?? 'N/A'}}
                                                <input type="hidden" name="incAmt[{{$sn}}]" id="incAmt" value="{{$arr->tot_admi_inc_amt}}">
                                            </td>
                                            <td>{{date('d-m-Y', strtotime($arr->invoice_dt ?? 'N/A')) ?? 'NA'}}</td>
                                            <td>{{$arr->vin_chassis_no ?? 'N/A'}}</td>
                                            {{-- <td>{{$arr->segment_id ?? 'N/A'}}</td> --}}
                                            <td>{{$arr->invoice_amt ?? 'N/A'}}</td>
                                            {{-- <td><a href="javascript:void(0);" id="btnShow" buyerid="{{$arr->id ?? 'N/A'}}">{{$arr->segment_id ?? 'N/A'}}</a></td> --}}
                                            <td>{{$arr->custmr_name ?? 'N/A'}}</td>
                                            <td>{{$arr->add ?? 'N/A'}}</td>
                                            <td>{{$arr->mobile ?? 'N/A'}}</td>
                                            <td>{{$arr->email ?? 'N/A'}}</td>
                                            {{-- <td>{{date('d-m-Y', strtotime($arr->invoice_dt)) ?? 'NA'}}</td> --}}
                                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="row py-2">
                        <div class="col-md-2 offset-md-0">
                            <a href="{{route('claimGenerate.index')}}" class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
                                class="fa fa-backward"></i>Back</a>
                        </div>
                        <div class="col-md-2 offset-md-3">
                            <button type="submit" id="generateClaim" class="btn btn-primary btn-sm form-control form-control-sm"><i
                                    class="fa fa-forward"></i>Proceed</button>
                        </div>
                    </div>
                </form>
               </div>
           </div>
           <!-- Container-fluid Ends-->
       </div>
   @endsection
   @push('scripts')
       <script>
        //    $(document).ready(function() {
        //        $('#checkAll').click(function(e) {
        //             var isChecked = $('input[type=checkbox]').not(this).is(':checked');
        //             $('input[type=checkbox]').prop('checked', !isChecked);
        //        });

        //        $("[id*=btnShow]").click(function () {
        //                     backdrop: 'static'
        //                     keyboard: false
        //                     var BuyerID = $(this).attr('BuyerID');
        //                     alert( BuyerID);
        //                     $.ajax({
        //                         type: "POST",
        //                         url: "ClaimRecordsDisplay.aspx/BindModelPopupData",
        //                         data: "{ 'BuyerID':'" + BuyerID + "'}",
        //                         contentType: "application/json; charset=utf-8",
        //                         dataType: "json",
        //                         success: function (r) {
        //                             if (r != null) {
        //                             }
        //                         },
        //                         error: function (r) {
        //                             alert('Failed to find Item Details!');
        //                         }
        //                     });
        //         });

        //         $('#generateClaim').click(function(e) {
        //             var buyerIds = [];
        //             $('input[type=checkbox].btnShowClass:checked').each(function() {
        //                 var buyerId = $(this).attr('buyerid');
        //                 buyerIds.push(buyerId);
        //             });
        //             if(buyerIds.length===0){
        //                 Swal.fire({
        //                 icon: 'warning',
        //                 text: 'Please select vehicles to proceed for claim',
        //                 confirmButtonColor: '#3085d6',
        //                 confirmButtonText: 'OK'
        //             });
        //             }else{
        //                 $('#proceedGeneration').attr('action', '/claimToMhi/show/' + buyerIds);
        //                 $('#proceedGeneration').submit();
        //             }
        //         });
        //    });

        $(document).ready(function() {
        $('#generateClaim').click(function(event) {
        event.preventDefault(); // Prevent the form from submitting automatically



        var maxCheckboxes = 2000;
        var checkedCount = $('input[type=checkbox].btnShowClass:checked').length;

            if (checkedCount >= maxCheckboxes) {
                // $('input[type=checkbox].btnShowClass:not(:checked)').prop('disabled', true);
                Swal.fire({
                icon: 'info',
                text: 'Maximum 2000 checkboxes can be selected.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
                });
                return;
            }


        // Get form data
        var formData = {};
        $.each($('#proceedClaimForm').serializeArray(), function() {
            formData[this.name] = this.value;
        });

        var vehicleCount = 0;
        var totIncAmt = 0;
        // Loop through the keys of the formData object
        // console.log(formData);
        for (var key in formData) {
            // Check if the key starts with 'check'
            // console.log(key);
            if (key.startsWith('check')) {
                // Increment the counter
                vehicleCount++;

            }
            if (key.startsWith('incAmt')) {
                // vehicleCount++;
                totIncAmt += parseFloat(formData[key]);
            }
            // console.log(totIncAmt);
        }

        // Set the value of vehicleTotCount to vehicleCount
        // $('#vehicleTotCount').val(vehicleCount);

        if (vehicleCount == 0) {
            Swal.fire({
                icon: 'warning',
                text: 'Please select vehicles to proceed for claim',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        } else {
            // Create a new input element
            var inputElement = document.createElement('input');
            inputElement.type = 'hidden'; // Set the input type to hidden
            inputElement.name = 'vehicleCount'; // Set the name attribute
            inputElement.value = vehicleCount; // Set the value 
            
            var inputElement1 = document.createElement('input');
            inputElement1.type = 'hidden'; // Set the input type to hidden
            inputElement1.name = 'totIncAmt'; // Set the name attribute
            inputElement1.value = totIncAmt; // Set the value attribute

            // Append the input element to the #vcat div
            document.getElementById('vcat').appendChild(inputElement);
            document.getElementById('vcat').appendChild(inputElement1);

            // Display confirmation dialog
            Swal.fire({
                title: 'Are you sure you want to proceed?',
                html: '<span style="font-weight:bold; color:blue;">No. of Vehicles Selected: ' + vehicleCount + '</span><br><span style="font-weight:bold; color:blue;">Total Incentive Amount: ' + (totIncAmt) + '</span>',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    // If the user clicks "Yes", submit the form
                    $('#proceedClaimForm').submit(); // Replace 'yourFormId' with the actual ID of your form
                }
            });
        }
    });
});


        

       </script>
   @endpush
