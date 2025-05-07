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

                    <div class="col-2">

                        {{-- <ol class="breadcrumb">
                            <li class="breadcrumb-item"> --}}
                        {{-- <a class="btn btn-success " href="/Auth/Adminpanel/OEM/ModelAddEdit.aspx">Add xEV Model</a> --}}
                        <a href="{{ route('oemModel.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> xEV
                            Model</a>
                        {{-- <a id="ContentPlaceHolder1_lbExistingModel" class="btn btn-primary" href="">Existing
                            Model</a> --}}

                        {{-- </li>
                        </ol> --}}
                    </div>



                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div id="ContentPlaceHolder1_divFormButton" class="btn_alignments">
                            <div class="pt20"></div>
                            <div>*<span style="font-weight: bold; color: red"> Note for Existing and New Model</span> </div>
                            <div class="pt20"></div>
                            <div><span style="font-weight: bold">New Model:</span> A model for which OEM would like Testing
                                Agency to test the model through online process. In this process OEM will receive Model Fame
                                Compliance Certificate online only.
                            </div>
                            <div class="pt10"></div>
                            <div><span style="font-weight: bold">Existing Model:</span> A model for which OEM has already
                                received the certificate from Testing Agency through offline process and would like to enter
                                the
                                same in the system.</div>
                        </div>
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
                                            <th class="text-center">Ev Model Name</th>
                                            <th class="text-center">Variant Name</th>
                                            <th class="text-center">Tech Type</th>
                                            {{-- <th class="text-center">Status</th>
                                            <th class="text-center">Testing Agency Status</th>
                                            <th class="text-center">MHI Status</th> --}}
                                            <th class="text-center">Action</th>
                                            <th class="text-center">Re-Validate</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($oemMOdelDetail as $key => $oem)
                                            <tr class="odd">
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td class="text-center">{{ $oem->model_name }}</td>
                                                <td class="text-center">{{ $oem->variant_name }}</td>
                                                <td class="text-center">{{ $oem->tech_type }}</td>
                                                {{-- <td class="text-center">
                                                    @if ($oem->status == 'D')
                                                        <span class="badge badge-light-warning">Draft</span>
                                                    @else
                                                        <span class="badge badge-light-success">Submitted</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
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
                                                </td> --}}
                                                <td class="text-center">
                                                    <ul class="action">
                                                        {{-- @if ($oem->status == 'D')
                                                            <li>
                                                                <a class="btn btn-sm btn-warning"
                                                                    href="{{ route('oemModel.edit', encrypt($oem->model_id)) }}">Edit</a>
                                                            </li>
                                                        @else --}}
                                                            <li>
                                                                <a class="btn btn-sm btn-success"
                                                                    href="{{ route('oemModel.models', encrypt($oem->model_id)) }}">View</a>
                                                            </li>
                                                        {{-- @endif --}}
                                                    </ul>
                                                </td>
                                                <td class="text-center">
                                                    <ul class="action">
                                                      
                                                        @php
                                                            $disanbleButton = false;
                                                            // dd($oemDet);
                                                            foreach ($oemDet->where('model_id', $oem->model_id)->sortBy('id') as $det) {
                                                                // dd($oemDet->where('model_id', 51)->where('id',166)->sortBy('id'));
                                                                if($det->mhi_flag == 'A' && $det->status == 'S' && $det->testing_flag == 'A'){
                                                                    $disanbleButton = true;
                                                                    
                                                                }
                                                                elseif($det->testing_flag == null && $det->mhi_flag == null && $det->status == 'D'){  
                                                                    $disanbleButton = false;
                                                                    // dd(1);
                                                                }
                                                                elseif(($det->mhi_flag == 'R' || $det->testing_flag == 'R')){
                                                                    $disanbleButton = true;
                                                                }
                                                                elseif($det->status == 'S' && $det->mhi_flag == null && $det->testing_flag == null){
                                                                    $disanbleButton = false;
                                                                }
                                                            }
                                                            // dd($det);
                                                    @endphp
                                                    {{-- {{dd($disanbleButton)}} --}}
                                                    @if($disanbleButton)
                                                        <li>
                                                            <a class="btn btn-sm btn-info" href="{{ route('oemModel.revalidate', encrypt($oem->model_id)) }}">Re-Validate</a>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <button disabled class="w-100 btn btn-sm btn-info">Re-Validate</button>
                                                        </li>
                                                    @endif
                                                    
                                                    </ul>
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
