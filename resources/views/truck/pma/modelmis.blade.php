<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Admin - OEM MOdel
@endsection

@push('styles')
@endpush
@section('content')
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-10">
                        <h4>OEM Model</h4>
                    </div>

                    


                </div>

                
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
      
                                <table class="display dataTable table-bordered" id="export-button" role="grid"
                                    aria-describedby="basic-9_info">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.No.</th>
                                            <th class="text-center">Oem Name</th>
                                            <th class="text-center">Date of OEM Approval</th>
                                            <th class="text-center">xEV Model Name</th>
                                            <th class="text-center">Segment</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Oem Submitted Date Model Approval</th>
                                            <th class="text-center">Testing Agency Submitted Date</th>
                                            <th class="text-center">MHI Submitted Date</th>
                                            <th class="text-center">Model Approval Status</th>
                                            <th class="text-center">Production Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
      
                                       @foreach($modelsDet as $mdet)
                                            <tr class="odd">
                                                <td class="text-center">{{$loop->iteration}}</td>
                                                <td class="text-center">{{$mdet->oem_name}}</td>
                                                <td class="text-center">{{($mdet->approval_at == null)?'-':date('d-m-Y',strtotime($mdet->approval_at))}}</td>
                                                <td class="text-center">{{$mdet->model_name}}</td>
                                                <td class="text-center">{{$mdet->segment}}</td>
                                                <td class="text-center">{{$mdet->vehicle_cat}}</td>
                                                <td class="text-center">{{($mdet->submitted_at == null)?'-':date('d-m-Y',strtotime($mdet->submitted_at))}}</td>
                                                <td class="text-center">{{($mdet->testing_created_at == null)?'-':date('d-m-Y',strtotime($mdet->testing_created_at))}}</td>
                                                <td class="text-center">{{($mdet->mhi_submitted_at == null)?'-':date('d-m-Y',strtotime($mdet->mhi_submitted_at))}}</td>
                                                
                                                    @if ($mdet->testing_flag == null)
                                                    <td class="text-center bg-warning"> <span class="">Pending at Testing Agency</span></td>
                                                    @elseif($mdet->mhi_flag == null && $mdet->testing_flag == 'A' || $mdet->testing_flag == 'R')
                                                    <td class="text-center bg-warning">   <span class="">Pending at MHI</span></td>
                                                    @elseif($mdet->mhi_flag == 'A')    
                                                    <td class="text-center bg-success">  <span class="">Approved</span></td>
                                                    @elseif($mdet->mhi_flag == 'R' || $mdet->testing_flag == 'R')
                                                    <td class="text-center bg-danger">  <span class="">Rejected</span>
                                                    </td>
                                                    @endif
      
                                                <td class="text-center">{{$proDat->where('model_id',$mdet->model_id)->count()}}</td>    
                                               {{-- <td class="text-center">
                                                    <span class="badge 
                                                        {{ $oem->testing_flag == 'A' ? 'badge-success' : ($oem->testing_flag == 'R' ? 'badge-danger' : 'badge-warning') }}">
                                                        {{ $oem->testing_flag == 'A' ? 'Approved' : ($oem->testing_flag == 'R' ? 'Reject' : 'Pending') }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge 
                                                        {{ $oem->mhi_flag == 'A' ? 'badge-success' : ($oem->mhi_flag == 'R' ? 'badge-danger' : 'badge-warning') }}">
                                                        {{ $oem->mhi_flag == 'A' ? 'Approved' : ($oem->mhi_flag == 'R' ? 'Reject' : 'Pending') }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <ul class="action">
                                                      
                                                            <li>
                                                                <a class="btn btn-sm btn-warning"
                                                                    href="">Edit</a>
                                                            </li>
                                                       
                                                    </ul>
                                                </td> --}}
                                               
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
