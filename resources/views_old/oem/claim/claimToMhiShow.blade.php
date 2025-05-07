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
                                    <select name="month" id="month" class="form-control form-control-sm" required>
                                        <option value="">Select Month</option>
                                        @foreach(range(4, 9) as $month)
                                            <option value="{{ $month }}" {{ isset($month_id) && $month_id == $month ? 'selected' : '' }}>
                                                {{ date("F", mktime(0, 0, 0, $month, 1)) }} - 2024
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                            <th scope="col">No of Vehcile </th>
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
                                                <input type="checkbox" name="check[{{$sn}}]" claimid="{{($claim->id)}}" class="btnShowClass" value="{{($claim->id)}}" checked/>
                                                <div id="vcat"></div>
                                            </td>
                                            <td>{{$sn}}</td>
                                            <td>{{$claim->claimnumberformat}}</td>
                                            <td>{{$claim->vehicle_count}}</td>
                                            <td>
                                                {{$claim->tot_incamt}}
                                                <input type="hidden" name="incAmt[{{$sn}}]" id="incAmt" value="{{$claim->tot_incamt}}">
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <td colspan="19" class="text-center">No Data Available</td>
                                        @endif
                                    </tbody>
                                </table>
                                
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
            $.each($('#proceedClaimForm').serializeArray(), function() {
                formData[this.name] = this.value;
            });

            var claimCount = 0;
            var totIncAmt = 0;
            // Loop through the keys of the formData object
            for (var key in formData) {
                // Check if the key starts with 'check'
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
