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
                           <h4>Permanent Registration Number Report</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">RC Report</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">
               <div class="row">

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12 mb-3 d-flex" style="justify-content: space-between;">
                                <h4>Buyer Details</h4>
                            </div>
                            <div class="dt-ext table-responsive custom-scrollbar mt-5">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Customer ID</th>
                                            <th>Vin Chassis</th>
                                            <th>Customer Type</th>
                                            <th>Customer Name as per Invoice</th>
                                            <th>Model Name</th>
                                            <th>Segment Name</th>
                                            <th>Vehicle Category</th>
                                            <th>RC Data AVailable</th>
                                            <th>Vehicle RC Number</th>
                                            <th>Vehicle RC Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($RCReport as $key=>$detail)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $detail->buyer_id }}</td>
                                                <td>{{ $detail->vin_chassis_no }}</td>
                                                <td>{{ $detail->custmr_typ == 1 ? 'Individual' : 'Bulk' }}</td>
                                                <td>{{ $detail->custmr_name }}</td>
                                                <td>{{ $detail->model_name }}</td>
                                                <td>{{ $detail->segment_name }}</td>
                                                <td>{{ $detail->vehicle_cat }}</td>
                                                <td class="text-white" 
                                                style="background-color: {{ $detail->vahanavailable == 'Y' ? 'green' : 'red' }}">
                                                {{ $detail->vahanavailable == 'Y' ? 'Yes' : 'No' }}
                                            </td>                                            
                                                <td>{{ $detail->vhcl_regis_no }}</td>
                                                <td>{{ $detail->vihcle_dt }}</td>
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
