<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Manage OEM Approval
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
                        <h4>Manage OEM Approval</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dt-ext table-responsive  custom-scrollbar">
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
                                      
                                        <th>Testing Agency Status</th>
                                        <th>Status</th>
                                        <th>Testing Agency Submitted Date</th>
                                        <th> Action </th>
           
                                    </tr>
                                </thead>
                                <tbody>
                                 @foreach($modelMaster as $model)
                                 <tr>
                                     <td>{{$loop->iteration}}</td>
                                      
                                        <td>{{$model->name}}</td>
                                        <td>  {{$model->model_name}}</td>
                                        <td>{{$model->variant_name}} </td>
                                       
                                        <td>{{$model->segment_id}}</td>
                                      
                                       
                                        <td>{{$model->vehicle_cat_id}}</td>
                                        <td>{{date('d-m-Y',strtotime($model->submitted_at))}} </td>
                                        <td class="text-center"  @if($model->testing_flag == 'A') bgcolor="lightgreen" @elseif($model->testing_flag == 'R') bgcolor="red" @else bgcolor="orange"  @endif>
                                            {{ $model->testing_flag == 'A' ? 'Approved' : ($model->testing_flag == 'R' ? 'Rejected' : 'Pending') }}
                                           </td>
                                        {{-- <td>
                                         @if($model->testing_flag == 'A')
                                             <span class="badge badge-success">Approved</span>
                                         @elseif($model->testing_flag == 'R')     
                                             <span class="badge badge-danger">Rejected</span>
                                         @else    
                                             <span class="badge badge-warning">Pending</span>
                                         @endif
                                     </td> --}}
                                     {{-- <td>
                                        @if($model->mhi_flag == 'A')
                                            <span class="badge badge-success">Approved</span>
                                        @elseif($model->mhi_flag == 'R')     
                                            <span class="badge badge-danger">Rejected</span>
                                        @else    
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </td> --}}
                                    <td class="text-center"  @if($model->mhi_flag == 'A') bgcolor="lightgreen" @elseif($model->mhi_flag == 'R') bgcolor="red" @else bgcolor="orange"  @endif>
                                        {{ $model->mhi_flag == 'A' ? 'Approved' : ($model->mhi_flag == 'R' ? 'Rejected' : 'Pending') }}
                                       </td>
                                     <td> {{$model->testing_created_at}} </td>
                                        
                                        <td>
                                         
                                         <a href="{{route('manageOEMApproval.show',encrypt($model->model_id))}}" class="btn btn-success">View</a> 
                                       
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
        <!-- Container-fluid Ends-->
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Reject Model Approval</h5>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Your rejection form can go here -->
                    <!-- Example: -->
                    <form action=" " method="POST" id="creApproval" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="reason">Reason for rejection</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Reject</button>
                            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button> --}}
                        </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\ModelOEMApprovalRequest', '#creApproval') !!}
@endpush
