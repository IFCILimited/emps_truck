<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Oem List
@endsection

@push('styles')
<style>
    table th {
    
    white-space: nowrap;  /* Prevent text from breaking onto a new line */
   
}
</style>
@endpush
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>OEM List</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">OEM Wise Model</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
       
                
            
            <div class="row">
                <div class="col-12 p-10">
                    <div class="card">
                        <div class="card-body ">
                            <div class="row">
                            <div class="col-8">
                                <label for="">OEM :- </label>
                                <h3 class="text-left" >{{$oemName->name}}</h3>
                            </div>
                            <div class="col-4">
                                <label for="">Model:-</label>
                                <h3 class="text-left" >{{$models->model_name}}</h3>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export3">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th colspan="4" style="text-align: center;">PM E-Drive <br>Compliance Certificate</th>
                                            <th colspan="3" class="text-center"> Documents</th>
                                            <th></th>
                                        </tr>
                                        <tr>
                                            <th style="text-align: center;">S.No.</th>
                                            <th style="text-align: center;">Valid <br>From</th>
                                            <th style="text-align: center;">Valid <br>To</th>
                                            <th style="text-align: center;">Effective<br> Date</th>
                                            <th style="text-align: center;">CMVR <br> Certificate<br> Date</th>
                                            <th style="text-align: center;">Certificate Copy<br>(Original Model)</th>
                                            <th style="text-align: center;">Assessment<br> Report</th>
                                            <th style="text-align: center;">CMVR <br>Certificate <br>Copy</th>
                                            <th style="text-align: center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach($modelDet as $model)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>

                                            
                                            <td class="text-center">
                                                {{ $model->valid_from ? date('d-m-Y', strtotime($model->valid_from)) : '-' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $model->valid_upto ? date('d-m-Y', strtotime($model->valid_upto)) : '-' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $model->valid_date ? date('d-m-Y', strtotime($model->valid_date)) : '-' }}
                                            </td>
                                            <td class="text-center">
                                                {{ $model->testing_cmvr_date ? date('d-m-Y', strtotime($model->testing_cmvr_date)) : '-' }}
                                            </td>
                                            
                                            <td class="text-center">
                                                <a class="mt-2 btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($model->testing_doc_id)) }}">
                                                <i class="fa fa-download"></i>  
                                            </a>
                                            </td>
                                            <td class="text-center">
                                                <a class="mt-2 btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($model->assessment_report_id)) }}">
                                                <i class="fa fa-download"></i>  
                                            </a>
                                            </td>
                                            <td class="text-center">
                                                <a class="mt-2 btn btn-success btn-sm"
                                                href="{{ route('doc.down', encrypt($model->testing_cmvr_doc_id)) }}">
                                                <i class="fa fa-download"></i>  
                                            </a>
                                            </td>

                                            
                                          
                                            <td>
                                                <a href="{{route('modelRequests.show',encrypt($model->model_detail_id))}}" class="btn btn-primary">View Detail</a>
                                            </td>
                                           
                                            
                                        
                                        </tr>
                                        @endforeach    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 text-center mt-2">
                    
                    <a href="{{ url()->previous() }}" class="btn btn-warning">Back</a>
                </div>
                <!-- Container-fluid Ends-->
            </div>
        </div>
    </div>
@endsection
