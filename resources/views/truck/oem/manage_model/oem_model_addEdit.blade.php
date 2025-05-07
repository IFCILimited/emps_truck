<!-- Nav Bar Ends here -->
@extends('layouts.e_truck_dashboard_master')
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
                    <div class="col-6">
                        <h4>OEM Model</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div id="ContentPlaceHolder1_divFormButton" class="btn_alignments">
                        <a id="ContentPlaceHolder1_lbExistingModel" class="btn btn-primary" href="">Existing
                            Model</a>
                        <a id="ContentPlaceHolder1_lbNewModel" class="btn btn-success"
                            href="{{ route('e-trucks.oemModel.create') }}">New Model</a>
                        <div class="pt20"></div>
                        <div>*<span style="font-weight: bold; color: red"> Note for Existing and New Model</span> </div>
                        <div class="pt20"></div>
                        <div><span style="font-weight: bold">Existing Model:</span> A model for which OEM has already
                            received the certificate from Testing Agency through offline process and would like to enter the
                            same in the system.</div>
                        <div class="pt10"></div>
                        <div><span style="font-weight: bold">New Model:</span> A model for which OEM would like Testing
                            Agency to test the model through online process. In this process OEM will receive Model Fame
                            Compliance Certificate online only.</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Container-fluid Ends-->
    </div>
@endsection

