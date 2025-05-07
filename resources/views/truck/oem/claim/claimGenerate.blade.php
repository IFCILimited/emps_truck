   <!-- Nav Bar Ends here -->
   @extends('layouts.e_truck_dashboard_master')
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
           {{-- <div class="modal fade" id="vehicleDetailsModal" tabindex="-1" aria-labelledby="vehicleDetailsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="vehicleDetailsModalLabel">Vehicle Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Vehicle details will be displayed here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
             </div>
            </div> --}}
           <!-- Container-fluid starts-->
           <div class="container-fluid">
               <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 offset-2">
                                    <label for="select_modSeg">Model Segment:</label>
                                    <select name="mod_seg" class="form-select" id="select_modSeg">
                                        <option value="" disabled selected>SELECT</option>
                                        @foreach($segMaster as $key=>$seg)
                                        {{-- {{dd(isset($modSeg)==$key)}} --}}
                                            <option value="{{encrypt($key)}}" @if(isset($modSeg) == $key) selected @endif>{{$seg}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- <div class="col-md-4">
                                </div> --}}
                                <div class="col-md-4">
                                    <label for="select_modName">Model Name:</label>
                                    <select name="mod_name" class="form-select" id="select_modName">
                                        <option value="" disabled selected>SELECT</option>
                                        @if(isset($modName))
                                        @foreach($modelMaster as $key=>$model)
                                            <option value="{{encrypt($key)}}" @if(isset($modName) == $key) selected @endif>{{$model}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-4">
                                </div>
                            </div>
                            <br>
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <label for="select_vinChasNo">VIN Chassis No :</label>
                                    <select name="mod_vinChas" class="form-select" id="select_vinChasNo">
                                        <option value="" disabled selected>SELECT</option>
                                    </select>
                                </div>
                            </div> --}}
                            <br>
                            <div class="row">
                            <div class="text-center">
                               <input type="button" name="" value="Search" id="search" class="btn btn-primary" />
                                <input type="button" name="" value="Clear" id="clear" class="btn btn-danger " />
                            </div>
                            </div>
                        </div>
                    </div>
                    {{-- {{ route('claimGenerate.show') }} --}}
                    <form action="{{ route('e-trucks.claimGenerate.show') }}" id="proceedGeneration" role="form" method="post" class='form-horizontal'
                        files=true enctype='multipart/form-data' accept-charset="utf-8">
                    @csrf
                   <div class="col-sm-12">
                       <div class="card">
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th scope="col"><input id="checkAll" type="checkbox" name=""/></th>
                                            <th scope="col">S.No.</th>
                                            <th scope="col">Model Segment</th>
                                            <th scope="col">Model Name</th>
                                            <th scope="col">Dealer Name</th>
                                            {{-- <th scope="col">Dealer Code</th> --}}
                                            <th scope="col">Invoice No.</th>
                                            {{-- <th scope="col">No. of Vehicle Purchased</th> --}}
                                            <th scope="col">Invoice Amount</th>
                                            <th scope="col">Invoice Date</th>
                                            <th scope="col">Vin Chassis No.</th>
                                            {{-- <th scope="col">Total Incentives</th> --}}
                                            <th scope="col">Invoice Amount</th>
                                            <th scope="col">Customer Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Mobile No.</th>
                                            <th scope="col">Email Id</th>
                                            {{-- <th scope="col">Invoice Date</th> --}}
                                            <th scope="col">View</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                        @if(count($buyerDetail)>0)
                                        @foreach($buyerDetail as $buyer)
                                        {{-- {{dd($buyer->id)}} --}}
                                        <tr>
                                            @php
                                                $sn = $loop->iteration;
                                            @endphp
                                            <td scope="row"><input type="checkbox" name="check[{{$sn}}]" buyerid="{{($buyer->id)}}" class="btnShowClass" value="{{($buyer->id)}}"/></td>
                                            <th>{{$sn}}</th>
                                            {{-- <td>{{$buyer->segment_id ?? 'NA'}}</td> --}}
                                            <td>{{$buyer->segment_name ?? 'NA'}}</td>
                                            <td>{{$buyer->model_name ?? 'NA'}}</td>
                                            <td>{{$dealer->where('id',$buyer->dealer_id)->first()->name ?? 'NA'}}</td>
                                            {{-- <td>{{$buyer->segment_id ?? 'NA'}}</td> --}}
                                            <td>{{$buyer->dlr_invoice_no ?? 'NA'}}</td>
                                            {{-- <td>{{$buyer->segment_id ?? 'NA'}}</td> --}}
                                            <td>{{$buyer->tot_inv_amt ?? 'NA'}}</td>
                                            <td>{{date('d-m-Y', strtotime($buyer->invoice_dt)) ?? 'NA'}}</td>
                                            <td>{{$buyer->vin_chassis_no ?? 'NA'}}</td>
                                            {{-- <td>{{$buyer->segment_id ?? 'NA'}}</td> --}}
                                            <td>{{$buyer->invoice_amt ?? 'NA'}}</td>
                                            {{-- <td><a href="javascript:void(0);" id="btnShow" buyerid="{{$buyer->id ?? 'NA'}}">{{$buyer->segment_id ?? 'NA'}}</a></td> --}}
                                            <td>{{$buyer->custmr_name ?? 'NA'}}</td>
                                            <td>{{$buyer->add ?? 'NA'}}</td>
                                            <td>{{$buyer->mobile ?? 'NA'}}</td>
                                            <td>{{$buyer->email ?? 'NA'}}</td>
                                            {{-- <td>{{$buyer->invoice_dt ?? 'NA'}}</td> --}}
                                            <td>
                                                <a href="{{route('e-trucks.ackdoc.finalview',$buyer->id)}}" class="btn btn-sm btn-warning">View</a>
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
                        <div class="col-md-2 offset-md-5">
                            <button type="submit" id="generateClaim" class="btn btn-primary btn-sm form-control form-control-sm"><i
                                    class="fa fa-save"></i> Save as Draft</button>
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
            $('#search').click(function(e) {
                var modSeg = $('#select_modSeg').val();
                var modName = $('#select_modName').val();

                var link = '/claimGenerate/search/' + modSeg + '/' +modName;
                window.location.href = link;

            });

            $('#clear').click(function(e) {

                var link = '../../../claimGenerate';
                window.location.href = link;

            });

               $('#checkAll').click(function(e) {
                    var isChecked = $('input[type=checkbox]').not(this).is(':checked');
                    $('input[type=checkbox]').prop('checked', !isChecked);
               });


                $('#select_modSeg').on('change', function() {
                    var selectedSegment_id = $(this).val();
                    var oemid = {{getParentId()}};
                    // console.log(selectedSegment_id);
                    $.ajax({
                        url: '/get_modelName/' +
                        selectedSegment_id + '/' + oemid, // Change the URL to your backend 
                        // url: '{{route("modelname",[' + selectedSegment_id + ',' + oemid + '])}}',
                        method: 'GET',
                        data: {
                            id: selectedSegment_id
                        }, // Pass any data if needed
                        success: function(response) {
                            console.log(response);
                            // Populate the vehicle category dropdown with the fetched data
                            $('#select_modName').html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            // Handle error if needed
                        }
                    });
                });




                $('#generateClaim').click(function(e) {
                    e.preventDefault();

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
                    var buyerIds = [];
                    $('input[type=checkbox].btnShowClass:checked').each(function() {
                        // var buyerId = $(this).closest('.btnShowClass').attr('buyerid');
                        var buyerId = $(this).attr('buyerid');
                        buyerIds.push(buyerId);
                    });
                    if(buyerIds.length===0){
                        Swal.fire({
                        icon: 'warning',
                        text: 'Please select vehicles to proceed for claim',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                        });
                    }else{
                        $('#proceedGeneration').submit();

                    }
                });
           });
       </script>
   @endpush
