<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Admin - Dashboard
@endsection

@push('styles')
    <style>

    </style>
@endpush
{{-- @php 
$filteredModels = $models->filter(function ($model) {
    return $model->mhi_flag === 'R' || $model->testing_flag === 'R';
});
$countRejMod = $filteredModels->count();
@endphp --}}
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Dashboard</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg class="stroke-icon">
                                        <use href="admin/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            {{-- <li class="breadcrumb-item">Dashboard</li> --}}
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row size-column">
                <div class="col-xxl-12 box-col-12">
                    <div class="row">
                        @if(Auth::user()->hasRole('DEALER'))
                            <div class="card mt-4" style="width: 80%;margin: 0 auto;">
                                <div class="card-body">
                                    <div class="container centered-container">
                                        <h2 class="text-center">Download Applications</h2>
                                        <a href="{{ asset('docs/dealer/app-release.apk') }}" class="btn btn-primary mt-2"
                                            download>PM E-DRIVE</a>
                                        <a href="https://play.google.com/store/apps/details?id=in.gov.uidai.facerd"
                                            class="btn btn-secondary mt-2" target="_blank">AadhaarFaceRD (UIDAI)</a>
                                        <div class="disclaimer text-danger">
                                            <p><strong>NOTE:</strong> Please ensure that you have deleted the existing
                                                applications (AadhaarFaceRD, PM E-DRIVE UAT version) before installing the
                                                applications above.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @else
                            <div class="col-sm-12 mt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <span class="text-primary" style="font-size: 20px">This page is under maintenance</span>    
                                    </div>
                                </div>

                            </div>
                        
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection