   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
    Manage Customer Details
   @endsection

   @push('styles')
   @endpush
   @section('content')
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4> Customer Details</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage  Customer Details</li>
                               <li class="breadcrumb-item active"> Customer Details</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">
               <div class="row">

                   <div class="col-sm-12">
                       <div class="card">
                           <div class="card-header pb-0 card-no-border">
                {{-- <form action="{{route("empsbuyer.create")}}" method="post"> --}}
                                @csrf
                            <div style="display: flex;align-items: center;justify-content: space-between;">
                                <div style="display: flex;align-items: center;">
                                    <form action="{{route("empsbuyer.export_data")}}" method="post">
                                        @csrf
                                        <button class="btn btn-sm btn-primary" type="submit">Export CSV</button>
                                    </form>

                                    <div style="margin-left: 10px">
                                        <form action="{{route("empsbuyer.emps_auth")}}" method="get" style="display: flex">
                                            @csrf
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="vin" placeholder="Enter VIN Number to search...." @if(isset($vin)) value="{{$vin}}"  @endif required/>
                                            </div>

                                            <button class="btn btn-sm btn-primary" type="submit" style="margin-left: 10px;">Search VIN</button>
                                            <a href="{{route("empsbuyer.emps_auth")}}" class="btn btn-info" style="margin-left: 1rem;">Refresh</a>
                                        </form>

                                    </div>
                                </div>
                            </div>
                           </div>
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                   <table class="display table-bordered table-striped" id="buyer_details_table">
                                       <thead>
                                           <tr>
                                               <th class="text-center">S.No.</th>
                                               <th class="text-center">Model Name</th>
                                               <th class="text-center">Model Variant</th>
                                               <th class="text-center">Model Segment</th>
                                               <th class="text-center">Customer Type</th>
                                               <th class="text-center">Vin Chassis No</th>
                                               <th class="text-center">Customer ID</th>
                                               <th class="text-center">Customer Name</th>
                                               <th class="text-center">Status</th>
                                               <th class="text-center">OEM Status</th>
                                               <th class="text-center">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach ($empsAuthBuyer as $key => $empsAuthBuyers)
                                               <tr>
                                                   <td class="text-center">{{ $key + 1 }}</td>
                                                   <td class="text-center">{{ $empsAuthBuyers->model_name }} </td>
                                                   <td class="text-center">{{ $empsAuthBuyers->variant_name }} </td>
                                                   <td class="text-center">{{ $empsAuthBuyers->segment_name }} </td>
                                                   <td>{{ $empsAuthBuyers->custmr_id == '1' ? 'Individual' : ($empsAuthBuyers->custmr_id == '2' ? 'Bulk' : ' ') }}</td>
                                                   <td class="text-center">{{ $empsAuthBuyers->vin_chassis_no }} </td>
                                                   <td class="text-center">{{$empsAuthBuyers->buyer_id}} </td>
                                                   <td class="text-center">{{ $empsAuthBuyers->custmr_name }} </td>
                                                   <td  class="text-center  @if ($empsAuthBuyers->pmedrive_dealer_status=='D')
                                                                bg-warning
                                                              @elseif($empsAuthBuyers->pmedrive_dealer_status=='S')
                                                                bg-success
                                                              @else
                                                              bg-info
                                                              @endif">
                                                       @if ($empsAuthBuyers->pmedrive_adh_verify == 'N')
                                                           <span class="text-white p-1">Face Authentication Pending</span>
                                                       @else

                                                            @if ($empsAuthBuyers->pmedrive_dealer_status=='D')
                                                                Pending
                                                            @elseif($empsAuthBuyers->pmedrive_dealer_status=='S')
                                                                Submit
                                                            @endif
                                                        @endif
                                                   </td>
                                                   <td  class="text-center  @if ($empsAuthBuyers->pmedrive_oem_status==Null)
                                                                bg-warning
                                                            @elseif($empsAuthBuyers->pmedrive_oem_status=='R')
                                                                 bg-danger
                                                            @elseif($empsAuthBuyers->pmedrive_oem_status=='A')
                                                                bg-success
                                                            @else
                                                              bg-info
                                                            @endif">
                                                       @if ($empsAuthBuyers->pmedrive_adh_verify == 'N')
                                                           <span class="text-white p-1">Face Authentication Pending</span>
                                                       @else
                                                                @if ($empsAuthBuyers->pmedrive_oem_status==Null && $empsAuthBuyers->status=='A')
                                                                    Pending
                                                                @elseif($empsAuthBuyers->pmedrive_oem_status=='R')
                                                                    Return by OEM
                                                                @elseif($empsAuthBuyers->pmedrive_oem_status=='A')
                                                                    Approved
                                                                @else
                                                                -
                                                                @endif
                                                       @endif
                                                   </td>
                                                   <td class="text-center">
                                                       @if ($empsAuthBuyers->pmedrive_adh_verify == 'N')
                                                           <span>Face Authentication Required</span>
                                                       @else
                                                           @if ($empsAuthBuyers->pmedrive_dealer_status == 'D')
                                                               <a href="{{ route('empsbuyer.edit',encrypt($empsAuthBuyers->id)) }}"
                                                                   class="btn btn-sm btn-warning">Edit</a>
                                                           @elseif ($empsAuthBuyers->pmedrive_dealer_status == 'S')
                                                               <a href="{{ route('empsbuyer.edit', encrypt($empsAuthBuyers->id)) }}"
                                                                   class="btn btn-sm btn-primary">View</a>
                                                           @endif
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
                {{-- </form> --}}
               </div>
           </div>
        </div>

   @endsection
   @push('scripts')
    <script>
        $('#buyer_details_table').DataTable({
            paging: false,
            searching: false,
            ordering: true,
            info: false
        });
    </script>
   @endpush
