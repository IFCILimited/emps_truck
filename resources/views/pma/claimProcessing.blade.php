   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Claim Processing
   @endsection

   @push('styles')
       <style>
           #preloader {
               position: fixed;
               left: 0;
               top: 0;
               width: 100%;
               height: 100%;
               z-index: 9999;
               background-color: rgba(255, 255, 255, 0.8);
               display: flex;
               align-items: center;
               justify-content: center;
           }

           .loader {
               border: 16px solid #f3f3f3;
               border-top: 16px solid #3498db;
               border-radius: 50%;
               width: 120px;
               height: 120px;
               animation: spin 2s linear infinite;
           }

           @keyframes spin {
               0% {
                   transform: rotate(0deg);
               }

               100% {
                   transform: rotate(360deg);
               }
           }
       </style>
   @endpush
   @section('content')
       <div id="preloader" style="display: none;">
           <div class="loader"></div>
       </div>

       <!-- Page Sidebar Ends-->
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">

                   <div class="row">


                       <div class="card p-10">
                           <div class="col-4 offset-3">
                               <input type="text" class="form-control" id="claim_no" placeholder="Claim Number">
                                <span class="text-danger" id="last_processed_info"></span>
                            </div>
                           <div class="col-12 p-10  offset-2">
                               {{-- <button type="button" class="btn btn-sm btn-success">Fetch Vahan</button> --}}
                               <button type="button" class="btn btn-sm btn-warning" id="vahanProcess">Vahan
                                   Process</button>
                               <button type="submit" class="btn btn-sm btn-primary" id="processClaim">Process
                                   Claim</button>
                               <button type="button" class="btn btn-sm btn-info" id="downloadClaim"> Download</button>
                               <button type="button" class="btn btn-sm btn-danger" id="exit">Exit</button>
                           </div>
                       </div>
                       <div class="col-xl-12">
                           <div class="col-6 mb-3">
                               <h4>Claim Processing</h4>
                           </div>

                           <div class="col-sm-12 col-xl-12">
                               <div class="card">
                                   <div class="card-header">

                                   </div>
                                   <div class="card-body">
                                       <ul class="simple-wrapper nav nav-tabs" id="myTab" role="tablist">
                                           <li class="nav-item"><a class="nav-link active txt-primary" id="home-tab"
                                                   data-bs-toggle="tab" href="#home" role="tab" aria-controls="home"
                                                   aria-selected="true">Unprocessed Claims</a></li>
                                           <li class="nav-item"><a class="nav-link  txt-primary" id="profile-tabs"
                                                   data-bs-toggle="tab" href="#profile" role="tab"
                                                   aria-controls="profile" aria-selected="false">Processed Claims</a></li>
                                       </ul>

                                       <div class="tab-content" id="myTabContent">
                                           <div class="tab-pane fade  show active" id="home" role="tabpanel"
                                               aria-labelledby="home-tab">
                                               <div class="dt-ext table-responsive  custom-scrollbar mt-5">
                                                   <table class="display table-bordered table-striped" id="export-button">
                                                       <thead>
                                                           <tr>
                                                               {{-- <th scope="col"><input id="checkAll" type="checkbox" name=""/></th> --}}
                                                               <th scope="col">S.No.</th>
                                                               <th scope="col">Oem Name</th>
                                                               <th scope="col">Model Segment</th>
                                                               <th scope="col">Claim Number</th>
                                                               <th scope="col">No of Vehicle </th>
                                                               <th scope="col">Total Incentive Amount</th>
                                                               <th scope="col">Created Date</th>
                                                               <th scope="col">Documents</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>

                                                           @if (count($claimMaster) > 0)
                                                               @foreach ($claimMaster->where('pma_process_at', null) as $claim)
                                                                   <tr>
                                                                       @php
                                                                           $sn = $loop->iteration;
                                                                       @endphp
                                                                       {{-- <td scope="row">
                                                                <input type="checkbox" name="check[{{$sn}}]" claimid="{{($claim->lot_id)}}" class="btnShowClass" value="{{($claim->lot_id)}}"/>
                                                            </td> --}}
                                                                       <td>{{ $sn }}</td>
                                                                       <td>{{ $claim->name }}</td>
                                                                       <td>{{ $claim->segment_name }}</td>
                                                                       <td><a
                                                                               href="{{ route('viewclaims', encrypt($claim->claim_id)) }}">{{ $claim->claimnumberformat }}</a>
                                                                       </td>
                                                                       <td>{{ $claim->vehicle_count }}</td>
                                                                       <td>{{ $claim->tot_incamt }}</td>
                                                                       <td>{{ date('d-m-Y', strtotime($claim->created_at)) }}
                                                                       </td>
                                                                       
                                                                        @if($claim->claim_doc_status == 'A')
                                                                        <td><a href="{{route('claimUploadDoc',encrypt($claim->claim_id))}}" class="btn btn-sm btn-success">View Documents</a></td>
                                                                        @else
                                                                        <td>-</td>
                                                                        @endif
                                                                    
                                                                       {{-- <td>
                                                                <a href="" class="btn btn-sm btn-warning">View</a>
                                                            </td> --}}
                                                                   </tr>
                                                               @endforeach
                                                           @else
                                                               <td colspan="19" class="text-center">No Data Available</td>
                                                           @endif
                                                       </tbody>
                                                   </table>

                                               </div>

                                           </div>
                                           <div class="tab-pane fade" id="profile" role="tabpanel"
                                               aria-labelledby="profile-tabs">
                                               <div class="dt-ext table-responsive  custom-scrollbar mt-5">
                                                   <table class="display table-bordered table-striped" id="export-button2">
                                                       <thead>
                                                           <tr>
                                                               {{-- <th scope="col"><input id="checkAll" type="checkbox" name=""/></th> --}}
                                                               <th scope="col">S.No.</th>
                                                               <th scope="col">Oem Name</th>
                                                               <th scope="col">Model Segment</th>
                                                               <th scope="col">Claim Number</th>
                                                               <th scope="col">No of Vehicle </th>
                                                               <th scope="col">Total Incentive Amount</th>
                                                               <th scope="col">Created Date</th>
								<th scope="col">Download</th>
								<th scope="col">Documents</th>
                                                           </tr>
                                                       </thead>
                                                       <tbody>

                                                           @if (count($claimMaster) > 0)
                                                               @foreach ($claimMaster->whereNotNull('pma_process_at') as $claim)
                                                                   <tr>
                                                                       @php
                                                                           $sn = $loop->iteration;
                                                                       @endphp
                                                                       {{-- <td scope="row">
                                                        <input type="checkbox" name="check[{{$sn}}]" claimid="{{($claim->lot_id)}}" class="btnShowClass" value="{{($claim->lot_id)}}"/>
                                                    </td> --}}
                                                                       <td>{{ $sn }}</td>
                                                                       <td>{{ $claim->name }}</td>
                                                                       <td>{{ $claim->segment_name }}</td>
                                                                       <td><a
                                                                               href="{{ route('viewclaims', encrypt($claim->claim_id)) }}">{{ $claim->claimnumberformat }}</a>
                                                                       </td>
                                                                       <td>{{ $claim->vehicle_count }}</td>
                                                                       {{-- {{dd($claim->claim_id)}} --}}
                                                                       <td>{{ $claim->tot_incamt }}</td>
                                                                       <td>{{ date('d-m-Y', strtotime($claim->created_at)) }}
                                                                       </td>
                                                                      <td>
                                                        <a href="{{ route('downloadClaim', $claim->claim_id) }}" class="btn btn-sm btn-warning"><i class="fa fa-download"></i></a>
                                                    </td> 
                                @if($claim->claim_doc_status  == 'A')
                                <td><a href="{{route('claimUploadDoc',encrypt($claim->claim_id))}}" class="btn btn-sm btn-success">View Documents</a></td>
                                @else
                                <td>-</td>
                                                    @endif
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
                               </div>
                           </div>

                       </div>

                   </div>

               </div>
           </div>

       </div>
   @endsection
   @push('scripts')
       <script>
           $(document).ready(function() {
               $('#checkAll').click(function(e) {
                   var isChecked = $('input[type=checkbox]').not(this).is(':checked');
                   $('input[type=checkbox]').prop('checked', !isChecked);
               });

               $('#generateClaim').click(function(e) {
                   e.preventDefault();
                   var claimIds = [];
                   $('input[type=checkbox].btnShowClass:checked').each(function() {
                       // var claimId = $(this).closest('.btnShowClass').attr('claimid');
                       var claimId = $(this).attr('claimid');
                       claimIds.push(claimId);
                   });
                   if (claimIds.length === 0) {
                       Swal.fire({
                           icon: 'warning',
                           text: 'Please select Claim to proceed',
                           confirmButtonColor: '#3085d6',
                           confirmButtonText: 'OK'
                       });
                   } else {
                       $('#proceedGeneration').submit();

                   }
               });

               // $('#proceedGeneration').submit(function(event) {
               //     $('#export-button tr').each(function(rowIndex, row) {
               //         $(row).find('input').each(function(index, input) {
               //             let hiddenInput = $('<input>')
               //                 .attr('type', 'hidden')
               //                 .attr('name', `data[${rowIndex}][${$(input).attr('name')}]`)
               //                 .val($(input).val());
               //             $('#data-form').append(hiddenInput);
               //         });
               //     });
               // });

               $("#export-button2").DataTable({
                   dom: "Bfrtip",
                   buttons: ["csvHtml5"],
                   pageLength: 2000,
                   order: [], // Disable initial sorting
               });



               $("#vahanProcess").click(function() {
                   var claimNumber = $("#claim_no").val();
                   if (claimNumber === '') {
                       Swal.fire('Please input the claim number', "!! Vahan Data Not Fetch!");
                   } else {
                       Swal.fire({
                           title: "Are you sure?",
                           text: "Do you want to continue with the Vahan fetch data process?. It will take a longer time (maximum 1 hour).",
                           icon: "warning",
                           buttons: true,
                           dangerMode: true,
                       }).then(function(isOkay) {
                           if (isOkay) {
                               var url = "vahanProcess" + '/' + claimNumber;

                               // Show the preloader
                               $("#preloader").show();

                               $.ajax({
                                   type: "GET",
                                   url: url,
                                   success: function(response) {
                                       console.log(response);
                                       // Hide the preloader
                                       $("#preloader").hide();

                                       if (response === '') {
                                           Swal.fire('Claim Number does not exist',
                                               '!! Vahan Data Not Fetch!');
                                       } else {
                                           Swal.fire('Vahan Data Downloaded Successfully').then(
                                               function() {
                                                   location
                                               .reload(); // Reload the page after the success message
                                               });
                                       }
                                   },
                                   error: function(xhr, status, error) {
                                       console.error("AJAX Error: " + error);
                                       // Hide the preloader
                                       $("#preloader").hide();
                                   }
                               });
                           }
                       });
                       return false;
                   }
               });

               $("#processClaim").click(function() {
    var claimNumber = $("#claim_no").val();
    if (claimNumber === '') {
        Swal.fire('Please input the claim number', "!! Claim Data Not Fetch!");
    } else {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to continue with the Claim process? It will take a longer time (maximum 1 hour).",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function(isOkay) {
            if (isOkay) {
                var url = "proccessClaim" + '/' + claimNumber;

                // Show the preloader
                $("#preloader").show();

                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response) {

                        console.log(response);
                        // exit;
                        // Hide the preloader
                        $("#preloader").hide();

                        if (response.success) {
                            Swal.fire('Claim Processed Successfully').then(function() {
                                location.reload(); // Reload the page after the success message
                            });
                        } else {
                            Swal.fire('Alert', response.error, 'warning');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: " + error);
                        console.error("Status: " + status);
                        console.error("Response Text: " + xhr.responseText);
                        
                        // Hide the preloader
                        $("#preloader").hide();

                        Swal.fire('Error', 'An error occurred while processing the claim: ' + xhr.responseText, 'error');
                    }
                });
            }
        });
        return false;
    }
});

$('#claim_no').on('input', function() {
                $('#last_processed_info').text('');
                var claimNumber = $(this).val();
                if (!isNaN(claimNumber)) {
                    $.ajax({
                        url: '/lastprocessed/' + claimNumber,
                        method: 'GET',
                        success: function(response) {

                            var dateStr = response.lastprocessdate;
                            var formattedDate = new Date(dateStr);
                            var month = String(formattedDate.getMonth() + 1).padStart(2, '0');
                            var day = String(formattedDate.getDate()).padStart(2, '0');
                            var year = formattedDate.getFullYear();
                            var hours = String(formattedDate.getHours()).padStart(2, '0');
                            var minutes = String(formattedDate.getMinutes()).padStart(2, '0');
                            var second = String(formattedDate.getSeconds()).padStart(2, '0');

                            var formattedDateString = month + '/' + day + '/' + year + ' ' +
                                hours + ':' + minutes + ':' + second;

                            $('#last_processed_info').text('Claim ' + claimNumber +
                                ' is already processed at ' + formattedDateString);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                } else {
                    $('#last_processed_info').text('Please Enter Complete Claim Number.');
                }
            });

               $("#downloadClaim").click(function() {
    var claimNumber = $("#claim_no").val();
    if (claimNumber === '') {
        Swal.fire('Please input the claim number');
    } else {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to download claim.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function(isOkay) {
            if (isOkay) {
                var url = "downloadClaim" + '/' + claimNumber;

                // Show the preloader
                $("#preloader").show();

                $.ajax({
                    type: "GET",
                    url: url,
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(response, status, xhr) {
                        // Hide the preloader
                        $("#preloader").hide();

                        if (xhr.status === 200) {
                            var disposition = xhr.getResponseHeader('content-disposition');
                            var matches = /"([^"]*)"/.exec(disposition);
                            var filename = matches ? matches[1] : `claim_${claimNumber}.xlsx`; 
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(new Blob([response]));
                            link.download = filename;
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);

                            Swal.fire('Claim Downloaded Successfully').then(
                                function() {
                                    location.reload(); // Reload the page after the success message
                                });
                        } else {
                            Swal.fire('No data found for the given claim number');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Hide the preloader
                        $("#preloader").hide();
                        if (xhr.status === 404) {
                            Swal.fire('No data found for the given claim number');
                        } else {
                            Swal.fire('Failed to download claims data. Please try again later.');
                        }
                        console.error("AJAX Error: " + error);
                    }
                });
            }
        });
        return false;
    }
});


            });
       </script>
   @endpush
