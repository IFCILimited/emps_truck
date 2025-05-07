   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Dealer -Buyer Details
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
                           <h4>Buyer Details</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home')}}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage Requests</li>
                               <li class="breadcrumb-item active">Buyer Details</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <!-- Container-fluid starts-->
           <div class="container-fluid">
               <div class="row">
                @if($status == 'P')
                <div class="col-sm-12">
                    <p>
                        <b>Total Number Of Vehicles = {{$bdCount}}</b>&nbsp;&nbsp;<a href="{{route('downloadBuyerList')}}" class="btn btn-primary btn-sm"> Download<i class="fa fa-download"></i></a><br>
                        <b class="text-danger">Note :-  Please note, this page displays a maximum of 2000 vehicles in the ascending order of invoice date. Remaining vehicles are subsequently added as and when vehicles are approved by the OEM.
                             </b>
                    </p>
                </div>
                @endif
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
                                            <th scope="col">Company Name</th>
                                            <th scope="col">Company Id</th>
                                            <th scope="col">Authorized person Name</th>
                                            <th scope="col">Submitted At</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                       </thead>
                                       <tbody>
                                        @foreach ($bankDetail as $key => $bankDetail)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{ $bankDetail->customer_name }} </td>
                                            <td>{{ $bankDetail->buyer_id }} </td>
                                            <td>{{ $bankDetail->auth_prs_name }} </td>
                                            <td>{{ date('d-m-y',strtotime($bankDetail->submitted_at)) }} </td>
                                            <td>
                                            @if($bankDetail->status == 'A' && $bankDetail->oem_status == 'A')
                                                <a href="{{route('buyerdetail.multi_buyer_preview', [encrypt($bankDetail->id),'oem'])}}" class="btn btn-success">View</a>
                                            @elseif($bankDetail->status == 'A')
                                                <a href="{{route('manageBulkBuyerDetails.create', [encrypt($bankDetail->id)])}}" class="btn btn-primary">Create</a>
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
