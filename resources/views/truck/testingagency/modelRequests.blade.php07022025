   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
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
                           <h4>Model Requests Received</h4>
                       </div>
                       <div class="col-6">  
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home')}}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item">Manage Requests</li>
                               <li class="breadcrumb-item active">Model Requests Received</li>
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
                                   <table class="display table-bordered dataTable table-striped" id="export-button">
                                       <thead>
                                           <tr>
                                               <th>S.No.</th>
                                             
                                               <th>OEM Name</th>
                                               <th>xEV Model Name</th>
                                               <th>Variant Name </th>
                                              
                                               <th>Vehicle Segment</th>
                                               <th>Vehicle Category</th>
                                              
                                              
                                               <th> OEM Submitted Date </th>
                                             
                                               <th>Status</th>
                                               <th>Testing Agency Submitted Date</th>
                                               <th> Action </th>
                  
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
                                               <td>{{date('d-m-Y',strtotime($model->submitted_at))}} </td>
                                               {{-- <td>{{ date('d-m-Y', strtotime($model->submitted_at)) }}</td> --}}
                                            @if($model->testing_flag == 'A')
                                                <td class="bg-success"><span>Approved</span></td>
                                            @elseif($model->testing_flag == 'R')
                                                <td class="bg-danger"><span>Rejected</span></td>
                                            @else
                                                <td class="bg-warning"><span>Pending</span></td>

                                            @endif
                                            {{-- <td class="text-center"  @if($model->testing_flag == 'A') bgcolor="lightgreen" @elseif($model->testing_flag == 'R') bgcolor="red" @else bgcolor="orange"  @endif>
                                                {{ $model->testing_flag == 'A' ? 'Approved' : ($model->testing_flag == 'R' ? 'Rejected' : 'Pending') }}
                                               </td> --}}


                                            {{-- <td>{{$model->testing_created_at}} </td> --}}

                                            <td>{{ ($model->testing_created_at != null) ? date('d-m-Y',strtotime($model->testing_created_at)) : ''}} </td>

                                               
                                               <td class="text-center">
                                                @if($model->testing_flag == 'A' || $model->testing_flag == 'R')
                                                    <a href="{{route('modelRequests.show',encrypt($model->id))}}" class="btn btn-sm btn-success">View</a> 
                                                
                                                @else    
                                                    <a href="{{route('modelRequests.create',encrypt($model->id))}}" class="btn btn-sm btn-warning">Create</a> 
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
