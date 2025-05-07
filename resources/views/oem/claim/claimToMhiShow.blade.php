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
                   </div>
               </div>
           </div>
           <div class="container-fluid">
               <div class="row">
                    <form action="{{route('claimToMhi.store')}}" role="form" method="post" class='form-horizontal' id='proceedClaimForm'
                        files=true enctype='multipart/form-data' accept-charset="utf-8">
                    @csrf

                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <span class="text-muted">Please select the month for which you want to submit the claim.</span>
                                </div>
                               <div class="col-md-2 d-flex justify-content-center">
                                    <select name="segment" class="form-control form-control-sm" required>
                                        <option disabled selected>Select Segment</option>
                                        <option value="1" {{$request->segment == 1?'selected':''}}>e-2W</option>
                                        <option value="2" {{$request->segment == 2?'selected':''}}>e-3W</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">

                                <div class="col-md-6">
                                    <span class="text-muted">Please select the month for which you want to submit the claim.</span>
                                </div>
                                {{-- <div class="col-md-2 d-flex justify-content-center">
                                    <select name="month" id="month" class="form-control form-control-sm" required>
                                        <option disabled selected>Select Month</option>
                                        @php
                                            $startDate = new DateTime('2024-10-01');
                                            $endDate = new DateTime('2026-03-31');
                                            $currentDate = new DateTime('first day of this month');

                                            while ($startDate <= $endDate && $startDate <= $currentDate) {
                                                $value = $startDate->format('m');
                                                $label = $startDate->format('F - Y');
                                                echo "<option value='$value'>$label</option>";
                                                $startDate->modify('+1 month');
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex justify-content-center">
                                    <select name="month" id="month" class="form-control form-control-sm" required>
                                        <option disabled selected>Select Month</option>
                                        @php
                                            $startDate = new DateTime('2024-10-01');
                                            $endDate = new DateTime('2026-03-31');
                                            $currentDate = new DateTime('first day of this month');

                                            $selectedMonth = session('month_id');

                                            while ($startDate <= $endDate && $startDate <= $currentDate) {
                                                $value = $startDate->format('m');
                                                $label = $startDate->format('F - Y');

                                                $isSelected = ($value == $selectedMonth) ? 'selected' : '';

                                                echo "<option value='$value' $isSelected>$label</option>";

                                                $startDate->modify('+1 month');
                                            }
                                        @endphp
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div> --}}
                   <div class="col-sm-12">
                       <div class="card">
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">S.No.</th>
                                            <th scope="col">Claim Number</th>
                                            <th scope="col">Total No of Vehcile </th>
                                            <th scope="col">Approved Vehicle</th>
                                            <th scope="col">Approved Amount</th>
                                            <th scope="col">Rejected Vehicle</th>
                                            <th scope="col">Rejected Amount</th>
                                            
                                            <th scope="col">Total Incentive Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($claimMaster)>0)
                                        @foreach($claimMaster as $claim)
                                        <tr>
                                            @php
                                                $sn = $loop->iteration;
                                            @endphp
                                            <td scope="row">
                                                <input type="checkbox" name="check[{{$sn}}]" claimid="{{($claim->claim_id)}}" class="btnShowClass" value="{{($claim->claim_id)}}" checked/>
                                                <div id="vcat"></div>
                                            </td>
                                            <td style="text-align: right;">{{$sn}}</td>
                                            <td>{{$claim->claimnumberformat}}</td>
                                            <td style="text-align: right;">{{$claim->vehicle_count}}</td>
                                            <td style="text-align: right;"><a href="javascript:void(0);" data-bs-toggle="modal" data-original-title="test" data-bs-target="#approveVehicle" id="">{{$claim->approved_count}}</a>
                                                
                                                <input type="hidden" name="data[{{$sn}}][claim_id]" id="claim_id" value="{{$claim->claim_id}}">
                                                <input type="hidden" name="data[{{$sn}}][approved_vehicle]" id="appvehicle" value="{{$claim->approved_count}}">
                                                <div class="modal fade" id="approveVehicle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog  modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="rejectModalLabel">Approved Vins</h4>
                                                            <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        {{-- {{dd($claim->approved_vins)}} --}}
                                                        <div class="modal-body">
                                                          
                                                               
                                                                    @php 
                                                                        $approvedVins  = json_decode($claim->approved_vins, true);
                                                                    @endphp
                                                                  
                                                                   
                                                                    <table class="table table-bordered display modal-export"  id="">
                                                                        <thead>
                                                                            <th>S.No.</th>
                                                                            <th style="text-align:left;">Vins</th>
                                                                           
                                                                        </thead>
                                                    
                                                                        <tbody>
                                                                            @foreach($approvedVins as $vin)
                                                                            <tr>
                                                                                <td>{{$loop->iteration}}</td>
                                                                                <td style="text-align:left;">{{$vin}} </td>
                                                                              
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>      
                                                                       
                                                                    
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                            
                                            <td style="text-align: right;">{{indian_number_format($claim->approved_amount)}}
                                                <input type="hidden" name="data[{{$sn}}][approved_amount]" id="approved_amount" value="{{$claim->approved_amount}}">
                                                <input type="hidden" name="incAmt[{{$sn}}]" id="incAmt" value="{{$claim->approved_amount}}">
                                            </td>
                                            <td style="text-align: right;">

                                                <a href="javascript:void(0);" data-bs-toggle="modal" data-original-title="test" data-bs-target="#rejected_count" id="">{{$claim->rejected_count}}</a>
                                                <div class="modal fade" id="rejected_count" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog  modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="rejectModalLabel">Rejected Vins</h4>
                                                            <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        {{-- {{dd($claim->approved_vins)}} --}}
                                                        <div class="modal-body">
                                                          
                                                               
                                                                    @php 
                                                                        $rejectedVins  = json_decode($claim->rejected_vins, true);
                                                                    @endphp
                                                                  
                                                                   
                                                                    <table class="table table-bordered display modal-export"  id="">
                                                                        <thead>
                                                                            <th>S.No.</th>
                                                                            <th style="text-align:left;">Vins</th>
                                                                           
                                                                        </thead>
                                                    
                                                                        <tbody>
                                                                            @foreach($rejectedVins as $vin)
                                                                            <tr>
                                                                                <td>{{$loop->iteration}}</td>
                                                                                <td style="text-align:left;">{{$vin}} </td>
                                                                              
                                                                            </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>      
                                                                       
                                                                    
                                                            </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            </td>
                                            <td style="text-align: right;">{{indian_number_format($claim->rejected_amount)}}</td>
                                            <td>
                                                {{indian_number_format($claim->tot_incamt)}}
                                                
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <td colspan="19" class="text-center">No Data Available</td>
                                        @endif
                                    </tbody>
                                </table>
                                <p class="text-danger"><b>Note: Vehicle(s) rejected due to invoice date exceeding 120 days from today.                    </b>            </p>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="row py-2">
                        <div class="col-md-2 offset-md-0">
                            <a href="{{route('claimToMhi.index')}}" class="btn btn-warning btn-sm form-control form-control-sm font-weight-bold"><i
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
        $(document).ready(function() {
        $('#generateClaim').click(function(event) {
            event.preventDefault(); // Prevent the form from submitting automatically

            // Get form data
            // var formData = $('#proceedClaimForm').serialize();
            var formData = {};
            var claimIds = [];
            $.each($('#proceedClaimForm').serializeArray(), function() {
                formData[this.name] = this.value;

                // if (this.name.match(/^check\[\d+\]$/)) {
                //     claimIds.push(this.value); // this.value is the actual claim ID
                // }
            });
            // console.log(claimIds);
            var claimCount = 0;
            var totIncAmt = 0;
            // Loop through the keys of the formData object
            for (var key in formData) {
                // Check if the key starts with 'check'
                // console.log(key);
                if (key.startsWith('check')) {
                    // Increment the counter
                    claimCount++;
                }

                if (key.startsWith('incAmt')) {
                // vehicleCount++;
                totIncAmt += parseFloat(formData[key]);
            }
            }
            if(claimCount == 0){
                Swal.fire({
                        icon: 'warning',
                        text: 'Please select Claim to proceed',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                        });
            }else{
            // console.log(claimCount);
            // Display confirmation dialog
            var inputElement = document.createElement('input');
            inputElement.type = 'hidden'; // Set the input type to hidden
            inputElement.name = 'vehicleCount'; // Set the name attribute
            inputElement.value = claimCount; // Set the value

            var inputElement1 = document.createElement('input');
            inputElement1.type = 'hidden'; // Set the input type to hidden
            inputElement1.name = 'totIncAmt'; // Set the name attribute
            inputElement1.value = totIncAmt; // Set the value attribute

            // Append the input element to the #vcat div
            document.getElementById('vcat').appendChild(inputElement);
            document.getElementById('vcat').appendChild(inputElement1);
            Swal.fire({
                title: 'Are you sure you want to proceed?',
                // html: 'No. of Vehicles Selected: ' + claimCount + '<br>Total Incentive Amount: ' + claimCount*100,
                html: '<span style="font-weight:bold; color:blue;">No. of Individual Claim Selected: ' + claimCount + '</span><br><span style="font-weight:bold; color:blue;">Total Incentive Amount: ' + totIncAmt + '</span>',
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
