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
            <div class="container  mt-2">
                <form action="{{ route('empsbuyer.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="text-center mt-2">
                            <h2 class="text-center">EMPS VIN Chassis Search</h2>
                        </div>
                        <div class="row col-12 offset-2 p-2">
                            <div class="col-6">
                                <input type="text" class="form-control" id="vin_chassis_no" name="vin_chassis_no"
                                    value="{{ old('vin_chassis_no') }}" required>
                            </div>
                            <div class="col-6">
                                <button type="submit" class="btn btn-sm btn-primary">Search</button>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar mt-5">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>VIN/Chassis No.</th>
                                            <th>Model Name</th>
                                            <th>Variant Name</th>
                                            <th>Segment Name</th>
                                            <th>Vehicle Category</th>
                                            <th>Customer Type</th>
                                            <th>Dealer Name</th>
                                            <th>Customer Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($customerDetails) && $customerDetails['status'] == 'SuccessE')
                                            @foreach($customerDetails['message'] as $customerDetail)
                                            <tr>
                                                <td>{{ $customerDetail['vin_chassis_no'] }}</td>
                                                <td>{{ $customerDetail['model_name'] }}</td>
                                                <td>{{ $customerDetail['variant_name'] ?? 'N/A' }}</td>
                                                <td>{{ $customerDetail['segment_name'] }}</td>
                                                <td>{{ $customerDetail['vehicle_cat'] }}</td>
                                                <td>{{ $customerDetail['custmr_id'] == '1' ? 'Individual' : ($customerDetail['custmr_id'] == '2' ? 'Bulk' : ' ') }}</td>
                                                <td>{{ $customerDetail['dealer_name'] }}</td>
                                                <td>{{ $customerDetail['custmr_name'] }}</td>
                                                {{-- <td>
                                                    @if ($customerDetail['status'] == 'A' && $customerDetail['oem_status'] == 'A')
                                                    <a href="{{ route('ackdoc.finalview', $customerDetail->id) }}" class="btn btn-primary">
                                                        View
                                                    </a>
                                                    @elseif($customerDetail['status'] == 'A' && $customerDetail['oem_status'] == Null)
                                                    <a href="{{ route('manageBuyerDetails.create', $customerDetail->id) }}" class="btn btn-primary">
                                                        Create
                                                    </a>
                                                    @elseif($customerDetail['status'] == 'D' || $customerDetail['status'] == 'S'  && $customerDetail['oem_status'] == Null)
                                                    <a href="#" disabaled class="btn btn-primary">
                                                        Pending
                                                    </a>
                                                    @endif
                                                </td> --}}
                                                <td>
                                                    <a href="{{ route('empsbuyer.show_detail', ['id' => encrypt($customerDetail['id']), 'data' => json_encode($customerDetails['message'])]) }}" class="btn btn-primary">
                                                        Create
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @elseif(isset($customerDetails) && $customerDetails['status'] == 'SuccessNE')
                                        <tr>
                                            <td colspan="12" class="text-center text-danger"><b>{{$customerDetails['message']}}</b></td>
                                        @elseif(isset($customerDetails) && $customerDetails['status'] == 'Warning')
                                            <tr>
                                                <td colspan="12" class="text-center text-danger"><b>{{$customerDetails['message']}}</b></td>
                                            </tr>
                                        @elseif(isset($customerDetails) && $customerDetails['status'] == 'Error')
                                        <tr>
                                            <td colspan="12" class="text-center text-danger"><b>{{$customerDetails['message']}}</b></td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td colspan="12" class="text-center text-danger"><b>Data Not Found</b></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
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
