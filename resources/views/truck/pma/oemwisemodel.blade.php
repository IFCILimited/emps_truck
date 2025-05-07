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
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export3">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">S.No.</th>
                                            <th style="text-align: center;">OEM Name</th>
                                           
                                            <th style="text-align: center;">Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                      @foreach($oemList as $oem) 
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td class="text-center">{{$oem->name}} </td>
                                            <td>
                                                <a href="{{ route('e-trucks.oemwisemodel.show',[$oem->id])}}" class="btn btn-primary">View Models</a>
                                            </td>
                                           
                                            
                                        
                                        </tr>
                                        @endforeach
                                            
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
        </div>
    </div>
@endsection
