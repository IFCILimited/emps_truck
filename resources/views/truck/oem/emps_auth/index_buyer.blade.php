   <!-- Nav Bar Ends here -->
   @extends('layouts.e_truck_dashboard_master')
   @section('title')
       Admin - Model Requests Received
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
                           <h4>Model Buyer Deatils</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home')}}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage Requests</li>
                               <li class="breadcrumb-item active">Model Buyer Deatils</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <!-- Container-fluid starts-->
           <div class="container-fluid">
               <div class="row">



                   <div class="col-sm-12">
                       <div class="card">
                           {{-- <div class="card-header pb-0 card-no-border">
                    <h4>HTML5 Export Buttons</h4>
                  </div> --}}
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                   <table class="display table-bordered  table-striped" id="export-button">
                                       <thead>
                                           <tr>
                                            <th scope="col">S.No.</th>
                                            <th scope="col">Model Segment</th>
                                            <th scope="col">Model Name</th>
                                            <th scope="col">Dealer Name</th>
                                            <th scope="col">Dealer Code</th>
                                            <th scope="col">Dealer Mobile No.</th>
                                            <th scope="col">Dealer Email ID</th>
                                            <th scope="col">Invoice No.</th>
                                            <th scope="col">Invoice Date</th>
                                            <th scope="col">VIN Chassis No.</th>
                                            <th scope="col">Customer ID</th>
                                            <th scope="col">Vehicle Reg. No.</th>
                                            <th scope="col">Incentive Amount</th>
                                            <th scope="col">Customer Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Customer Mobile No</th>
                                            <th scope="col">Customer Email ID</th>
                                            <th scope="col">Invoice Created Date</th>
                                        @if($status == 'A' || $status == 'P')
                                            <th scope="col">Action</th>
                                        @elseif($status == 'R')
                                            <th scope="col">Remarks</th>
                                        @endif

                                           </tr>
                                       </thead>
                                       <tbody>
                                        @foreach ($bankDetail->whereNotIn('oem_status',['R']) as $key => $bankDetail)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{ $bankDetail->segment_name }} </td>
                                            <td>{{ $bankDetail->model_name }} </td>
                                            <td>{{ $bankDetail->dealer_name }} </td>
                                            <td>{{ $bankDetail->dealer_code }} </td>

                                            <td>{{ $bankDetail->dealer_mobile }} </td>
                                            <td>{{ $bankDetail->dealer_email }} </td>
                                            <td>{{ $bankDetail->dlr_invoice_no }} </td>

                                            <td>{{ $bankDetail->invoice_dt }} </td>
                                            <td>{{ $bankDetail->vin_chassis_no }} </td>
                                            <td>{{ $bankDetail->buyer_id }} </td>
                                            <td>{{ $bankDetail->vhcl_regis_no }} </td>


                                            <td>{{ $bankDetail->model_name }} </td>
                                            <td>{{ $bankDetail->custmr_name }} </td>

                                            <td>{{ $bankDetail->add }} </td>
                                            <td>{{ $bankDetail->mobile }} </td>
                                            <td>{{ $bankDetail->email }} </td>
                                            <td>{{ $bankDetail->invoice_dt }} </td>
                                        @if($status == 'A' || $status == 'P')
                                            <td>
                                              @if($bankDetail->pmedrive_dealer_status == 'S' && $bankDetail->pmedrive_oem_status == 'A')
                                            <a href="{{route('e-trucks.Empsbuyer.cerate', encrypt($bankDetail->id))}}" class="btn btn-primary">View</a>
                                            @elseif($bankDetail->pmedrive_dealer_status == 'S')
                                                <a href="{{route('e-trucks.Empsbuyer.cerate', encrypt($bankDetail->id))}}" class="btn btn-success">Create</a>
                                            @endif
                                            </td>
                                        @elseif($status == 'R')
                                            <td><span style="color: red;">{{ $bankDetail->pmedrive_oem_remarks }}</span></td>
                                        @endif
                                        </tr>
                                        @endforeach

                                       </tbody>

                                   </table>
                               </div>

                           </div>
                       </div>
                   </div>


               </div>
           </div>
           <!-- Container-fluid Ends-->
       </div>


   @endsection
   @push('script')
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
    $(document).ready(function() {
        $('.btnApp').click(function(e) {

            $('#formApprove').submit();
        });
        $('.btnReject').click(function(e) {

            $('#formReject').submit();
        });
    });
    </script>
   @endpush
