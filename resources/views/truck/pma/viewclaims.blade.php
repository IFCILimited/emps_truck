
   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       PMA - Claims Detail
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
                           <h4>Claims Detail</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home')}}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage Claims</li>
                               <li class="breadcrumb-item active">Claims Detail</li>
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
                                            <th scope="col">VIN Chassis No.</th>
                                            <th scope="col">Invoice No.</th>
                                            <th scope="col">Invoice Date</th>
                                            <th scope="col">Vehicle Reg. No.</th>
                                            <th scope="col">Vehicle Reg. Date</th>
                                            <th scope="col">Invoice Amount</th>
                                            <th scope="col">Incentive Amount</th>
                                            <th scope="col">Customer Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Customer Mobile No</th>
                                            <th scope="col">Customer Email ID</th>
                                            {{-- <th scope="col">Invoice Created Date</th> --}}
                                            <th scope="col">Action</th>

                                           </tr>
                                       </thead>
                                       <tbody>
                                      @foreach($claims as $claim)
                                        <tr>
                                            <td>{{$loop->iteration}} </td>
                                            <td>{{$claim->segment_name}} </td>
                                            <td>{{$claim->model_name}}  </td>
                                            <td>{{$claim->dealer_name}}  </td>
                                            <td>{{$claim->dealer_code}}  </td>

                                            <td> {{$claim->dealer_mobile}} </td>
                                            <td> {{$claim->dealer_email}} </td>
                                            <td> {{$claim->vin_chassis_no}} </td>
                                            <td> {{$claim->dlr_invoice_no}} </td>

                                            <td> {{$claim->invoice_dt}} </td>
                                            <td>    {{$claim->vhcl_regis_no}}  </td>
                                            <td> {{$claim->invoice_dt}} </td>
                                            <td> {{$claim->invoice_amt}} </td>
                                            <td> {{$claim->tot_admi_inc_amt}} </td>


                                              
                                            <td> {{$claim->custmr_name}} </td>

                                            <td> {{$claim->add}},{{$claim->district}},{{$claim->state}},{{$claim->pincode}} </td>
                                            <td> {{$claim->mobile}} </td>
                                            <td> {{$claim->email}} </td>
                                            
                                            <td>
                                        @if($claim->custmr_typ == 1)
                                            <a href="{{route('e-trucks.ackdoc.finalview', $claim->id)}}" class="btn btn-success">View</a>
                                        @else
                                         <a href="{{route('e-trucks.buyerdetail.vin.manage_invoice_preview', [$claim->id, encrypt($claim->mbdId)])}}" class="btn btn-success">View</a>
                                        @endif
                                            </td>
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
  
   @endpush
