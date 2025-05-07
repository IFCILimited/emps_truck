@extends('layouts.dashboard_master')
@section('title')
   Vahan Details
@endsection

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Vahan Details</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg class="stroke-icon">
                                        <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Vahan Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header bg-primary"><b>Fetch Vahan Details</b></div>
                        <div class="card-body">
                            <div class="loader-container" id="loaderContainer">
                                <div class="loader"></div>
                            </div>

                            <form id="claim-form" action="{{ route('apivahan.store') }}" role="form" method="post"
                                class="form-horizontal" files=true enctype="multipart/form-data" accept-charset="utf-8">
                                @csrf

                                <div class="form-group row">
                                    <label for="Chassis_Number" class="col-md-3 col-form-label text-md-right"> Chassis
                                        Number</label>
                                    <div class="col-md-6">
                                        <input type="text" name="Chassis_Number" id="Chassis_Number" class="form-control"
                                            placeholder="Enter Chassis Number">
                                    </div>
                                </div>

                                <div class="form-group row mt-2">
                                    <div class="col-md-6 offset-md-4" id="button-container">
                                        <button type="submit" class="btn btn-success btn-sm px-4" id="process-button">Process</button>
                                        <button type="button" class="btn btn-primary btn-sm px-4" id="refresh-button">Reset</button>
                                        <a href="{{ route('dashboard') }}" class="btn btn-danger btn-sm px-4" id="">Exit</a>
                                    </div>
                                </div>
                                
                            </form>
                            <div class="text-center" id="wait-msg" style="display: none;">
                                <p>Please wait, processing...</p>
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
        $(document).ready(function() {
            $("#process-button").click(function() {
                // Hide all buttons
                $("#button-container").hide();
                // Show "Please wait" message
                $("#wait-msg").show();
            });

            $("#refresh-button").click(function() {
                $("#claim_number").val('');
            });
        });
    </script>
@endpush
