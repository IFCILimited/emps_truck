   <!-- Nav Bar Ends here -->
   @extends('layouts.e_truck_dashboard_master')
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
                            <div style="display: flex;align-items: center;justify-content: space-between;">
                                <div style="display: flex;align-items: center;">
                                    <form action="{{route("e-trucks.buyerdetail.export_data")}}" method="post">
                                        @csrf
                                        <button class="btn btn-sm btn-primary" type="submit">Export CSV</button>
                                    </form>

                                    <div style="margin-left: 10px">
                                        <form action="{{route("e-trucks.buyerdetail.index")}}" method="get" style="display: flex">
                                            @csrf
                                            <div class="form-group">
                                                <input class="form-control" type="text" name="vin" placeholder="Enter VIN Number to search...." @if(isset($vin)) value="{{$vin}}"  @endif required/>
                                            </div>

                                            <button class="btn btn-sm btn-primary" type="submit" style="margin-left: 10px;">Search VIN</button>
                                            <a href="{{route("e-trucks.buyerdetail.index")}}" class="btn btn-info" style="margin-left: 1rem;">Refresh</a>
                                        </form>

                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('e-trucks.buyerdetail.create') }}" class="btn btn-success" style="float: right;">Add Buyer Detail</a>
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
                                               <th class="text-center">Vin Chassis No</th>
                                               <th class="text-center">Customer ID</th>
                                               <th class="text-center">Customer Name</th>
                                               <th class="text-center">Status</th>
                                               <th class="text-center">Submitted at</th>
                                               <th class="text-center">OEM Status</th>
                                               <th class="text-center">OEM Approved at</th>
                                               <th class="text-center">Action</th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                           @foreach ($bankDetails as $key => $bankDetail)
                                           {{-- {{dd($bankDetail)}} --}}
                                               <tr>
                                                   <td class="text-center">{{ $key + 1 }}</td>
                                                   <td class="text-center">{{ $bankDetail->model_name }} </td>
                                                   <td class="text-center">{{ $bankDetail->variant_name }} </td>
                                                   <td class="text-center">{{ $bankDetail->segment_name }} </td>
                                                   <td class="text-center">{{ $bankDetail->vin_chassis_no }} </td>
                                                   <td class="text-center">{{ $bankDetail->buyer_id }} </td>
                                                   <td class="text-center">{{ $bankDetail->custmr_name }} </td>
                                                   <td  class="text-center  @if ($bankDetail->status=='D')
                                                                bg-warning
                                                              @elseif($bankDetail->status=='S')
                                                                bg-primary
                                                              @elseif($bankDetail->status=='A')
                                                              bg-success
                                                              @else
                                                              bg-info
                                                              @endif">
                                                       @if ($bankDetail->adh_verify == 'N' && $bankDetail->custmr_typ==1)
                                                           <span class="text-white p-1">Face Authentication Pending</span>
                                                       @else

                                                            @if ($bankDetail->status=='D')
                                                                Pending
                                                            @elseif($bankDetail->status=='S')
                                                                Document Pending
                                                            @elseif($bankDetail->status=='A')
                                                                Submit
                                                            @elseif($bankDetail->status=='P')
                                                                RC Pending
                                                            @endif
                                                        @endif
                                                   </td>
                                                   <td>
                                                    {{ $bankDetail->buyer_submitted_at ? date('d-m-Y', strtotime($bankDetail->buyer_submitted_at)) : '-' }}
                                                   </td>
                                                   <td  class="text-center  @if ($bankDetail->oem_status==Null)
                                                                bg-warning
                                                            @elseif($bankDetail->oem_status=='R')
                                                                 bg-danger
                                                            @elseif($bankDetail->oem_status=='A')
                                                                bg-success
                                                            @else
                                                              bg-info
                                                            @endif">
                                                       @if ($bankDetail->adh_verify == 'N' && $bankDetail->custmr_typ==1)
                                                           <span class="text-white p-1">Face Authentication Pending</span>
                                                       @else
                                                                @if ($bankDetail->oem_status==Null && $bankDetail->status=='A')
                                                                    Pending
                                                                @elseif($bankDetail->oem_status=='R')
                                                                    Return by OEM
                                                                @elseif($bankDetail->oem_status=='A')
                                                                    Approved
                                                                @else
                                                                -
                                                                @endif
                                                       @endif
                                                   </td>
                                                   <td>
                                                    {{ $bankDetail->oem_status_at ? date('d-m-Y', strtotime($bankDetail->oem_status_at)) : '-' }}
                                                   </td>
                                                   <td class="text-center">
                                                       @if ($bankDetail->adh_verify == 'N' && $bankDetail->custmr_typ==1)
                                                           <span>Face Authentication Required</span>
                                                       @else
                                                           @if ($bankDetail->status == 'D')
                                                               <a href="{{ route('e-trucks.buyerdetail.edit', $bankDetail->id) }}"
                                                                   class="btn btn-sm btn-warning">Edit</a>
                                                           @elseif ($bankDetail->status == 'S')
                                                               <a href="{{ route('e-trucks.buyerdetail.ackdoc', $bankDetail->id) }}"
                                                                   class="btn btn-sm btn-primary">Upload Document</a>
                                                            @elseif ($bankDetail->status == 'P')
                                                                   <a href="{{ route('e-trucks.buyerdetail.ackdoc', $bankDetail->id) }}"
                                                                       class="btn btn-sm btn-primary">RC & Document Upload</a>
                                                           @elseif ($bankDetail->status == 'A')
                                                               <a href="{{ route('e-trucks.ackdoc.finalview', $bankDetail->id) }}"
                                                                   class="btn btn-sm btn-success">VIEW</a>
                                                           @endif
                                                       @endif

                                                   </td>
                                               </tr>
                                           @endforeach
                                       </tbody>
                                   </table>
                               </div>
                               <div class="col-12 d-flex justify-content-end align-items-center">
                                        <div>
                                            {{ $bankDetails->links() }}
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
        $('#buyer_details_table').DataTable({
            paging: false,
            searching: false,
            ordering: true,
            info: false
        });
    </script>
   @endpush
