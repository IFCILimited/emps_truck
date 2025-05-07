   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Model Details
   @endsection

   @push('styles')
   @endpush
   @section('content')
       <div class="page-body">
           <div class="container-fluid">
               <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>Model Details</h4>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">
               <div class="row">
                   <div class="col-sm-12">
                       <div class="card">
                           <div class="card-body">
                               <div class="dt-ext table-responsive  custom-scrollbar">
                                   {{-- <table class="display table-bordered  table-striped" id="export-button">
                                       <thead>
                                           <tr>
                                               <th>S.No.</th>
                                               <th>OEM Name</th>
                                               <th>xEV Model Name</th>
                                               <th>Variant Name </th>
                                               <th>Vehicle Segment</th>
                                               <th>Vehicle Category</th>
                                               <th>Status</th>
                                               <th>Action </th>
                  
                                           </tr>
                                       </thead>
                                       <tbody>
                                        @foreach($models as $model)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                               <td>{{$model->name}}</td>
                                               <td>  {{$model->model_name}}</td>
                                               <td>{{$model->variant_name}} </td>
                                               <td>{{$model->segment_name}}</td>
                                               <td>{{$model->category_name}}</td>
                                               <td>
                                                @if($model->testing_flag == 'A')
                                                    <span class="badge badge-success">Approved</span>
                                                @elseif($model->testing_flag == 'R')     
                                                    <span class="badge badge-danger">Rejected</span>
                                                @else    
                                                    <span class="badge badge-warning">Pending</span>
                                                @endif
                                            </td>
                                               <td>
                                                <a href="{{route('modelShow',encrypt($model->model_id))}}" class="btn btn-success">View</a>
                                                </td>

                                        </tr>
                                        @endforeach
                                       </tbody>
                                   </table> --}}
                                   <table class="display table-bordered  table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>OEM Name</th>
                                            <th>xEV Model Name</th>
                                            <th>Variant Name </th>
                                            <th>Vehicle Segment</th>
                                            <th>Vehicle Category</th>
                                            <th> OEM Submitted Date </th>
                                            <th> CMVR Certificate </th>
                                            <th> CMVR Date </th>
                                            <th> Valid From </th>
                                            <th> Valid Upto </th>
                                            <th>Testing Agency Status</th>
                                            <th>Status</th>
                                            <th>Testing Agency Submitted Date</th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($models as $model)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $model->oem_name }}</td>
                                                <td> {{ $model->model_name }}</td>
                                                <td>{{ $model->variant_name }} </td>
                                                <td>{{ $model->segment }}</td>
                                                <td>{{ $model->vehicle_cat }}</td>
                                                <td>{{ date('d-m-Y', strtotime($model->submitted_at)) }} </td>
                                                <td>{{ $model->testing_certificate_no }}</td>
                                                <td>{{ date('d-m-Y', strtotime($model->testing_cmvr_date)) }} </td>
                                                <td>{{ date('d-m-Y', strtotime($model->valid_from)) }} </td>
                                                <td>{{ date('d-m-Y', strtotime($model->valid_upto)) }} </td>
                                                <td class="text-center"
                                                    @if ($model->testing_flag == 'A') bgcolor="lightgreen" @elseif($model->testing_flag == 'R') bgcolor="red" @else bgcolor="orange" @endif>
                                                    {{ $model->testing_flag == 'A' ? 'Approved' : ($model->testing_flag == 'R' ? 'Rejected' : 'Pending') }}
                                                </td>
                                                <td class="text-center"
                                                    @if ($model->mhi_flag == 'A') bgcolor="lightgreen" @elseif($model->mhi_flag == 'R') bgcolor="red" @else bgcolor="orange" @endif>
                                                    {{ $model->mhi_flag == 'A' ? 'Approved' : ($model->mhi_flag == 'R' ? 'Rejected' : 'Pending') }}
                                                </td>
                                                <td>{{ date('d-m-Y', strtotime($model->testing_created_at)) }}</td>
                                                <td>
                                                    <a href="{{route('modelShow',encrypt($model->model_detail_id))}}"
                                                        class="btn btn-success">View</a>
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
