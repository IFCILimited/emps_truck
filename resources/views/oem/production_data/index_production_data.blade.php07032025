<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Admin - OEM MOdel
@endsection

@push('styles')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Manage Production Data</h4>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{ route('downloadFile.productiondata') }}" class="btn btn-success"><i
                                class="fa fa-cloud-download"></i> Format for Production Data.</a>
                    </div>
			<div class="col-3 d-flex justify-content-end">
                        <a href="{{ asset('files/ManageProductionData_sample.xlsx') }}" class="btn btn-success"><i
                                class="fa fa-cloud-download"></i> Sample Production Data.</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <th class="text-center">S.No.</th>
                                        <th class="text-center">Ev Model Name</th>
                                        <th class="text-center">Model Detail Id</th>
                                        <th class="text-center">Variant Name</th>
                                        <th class="text-center">Vehicle Segment</th>
                                        <th class="text-center">Tech Type</th>
                                        <th class="text-center">Factory Price</th>
                                        <th class="text-center">Certificate No.</th>
                                        <th class="text-center">CMVR Date</th>
                                        <th class="text-center">{{ env('APP_NAME')}} Date From</th>
                                        <th class="text-center">{{ env('APP_NAME')}} Date To</th>
                                        <th class="text-center">Action</th>
                                    </thead>
                                    <tbody>
                                        @if (isset($modelMaster))
                                            @foreach ($modelMaster as $model)
                                                {{-- {{dd($model)}} --}}
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $model->model_name }}</td>
                                                    <td class="text-right">{{ $model->id }}</td>
                                                    <td>{{ $model->variant_name }}</td>
                                                    <td>{{ $model->segment_id }}</td>
                                                    <td>{{ $model->tech_type }}</td>
                                                    <td>{{ indian_number_format($model->factory_price) }}</td>
                                                    <td>{{ $model->testing_certificate_no }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($model->testing_cmvr_date)) }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($model->testing_approval_date)) }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($model->testing_expiry_date)) }}</td>

                                                    @php
                                                        $prData = $productionData
                                                            ->where('model_master_id', $model->model_id)
                                                            ->where('model_details_id', $model->id)
                                                            ->where('status', 'D')
                                                            ->first();
                                                        $data = [
                                                            'model_id' => $model->model_id,
                                                            'model_det_id' => $model->id,
                                                        ];
                                                    @endphp

                                                    @if ($productionData->where('model_master_id', $model->model_id)->where('model_details_id', $model->id)->count() == 0)
                                                        <td>
                                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                                data-original-title="test"
                                                                data-bs-target="#uploadProdData{{ $model->id }}-{{ $model->model_id }}">Upload</button>
                                                        </td>
                                                    @elseif($productionData->where('model_master_id', $model->model_id)->where('model_details_id', $model->id)->pluck('status')[0] == 'D')
                                                    <td class="text-center">
                                                        <a href="{{ route('manageProductionData.edit', encrypt($data)) }}"
                                                            class="btn btn-sm btn-warning">Edit</a>
                                                        <a href="{{ route('manageProductionData.downloadexcel', encrypt($data)) }}"
                                                            class="btn btn-sm btn-success mt-2">Download</a>
                                                    </td>
                                                    @elseif($productionData->where('model_master_id', $model->model_id)->where('model_details_id', $model->id)->pluck('status')[0] == 'S')
                                                        <td class="d-flex justify-content-around m-2">
                                                            <a href="{{ route('manageProductionData.downloadexcel', encrypt($data)) }}"
                                                                class="btn  btn-success">Download</a> &nbsp; &nbsp; &nbsp;
                                                            &nbsp;
                                                            @if ($prData)
                                                                <a href="{{ route('manageProductionData.edit', encrypt($data)) }}"
                                                                    class="btn  btn-warning">Edit</a>
                                                            @else
                                                                <button class="btn btn-primary " data-bs-toggle="modal"
                                                                    data-original-title="test"
                                                                    data-bs-target="#uploadProdData{{ $model->id }}-{{ $model->model_id }}">Upload</button>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                                <div class="modal fade"
                                                    id="uploadProdData{{ $model->id }}-{{ $model->model_id }}"
                                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg modal-dialog-centered"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Upload Excel
                                                                    File</h5>
                                                                <button class="btn-close py-0" type="button"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('uploadProductionData') }}"
                                                                    method="POST" class="prevent-multiple-submit" enctype="multipart/form-data">
                                                                    @csrf
                                                                    <div class="form-group">
                                                                        <input type="hidden" name="model_id"
                                                                            value="{{ $model->model_id }}">
                                                                        <input type="hidden" name="model_det_id"
                                                                            value="{{ $model->id }}">
                                                                        <label for="excel_file">Choose Excel File:</label>
                                                                        <input type="file" name="excel_file"
                                                                            id="excel_file"
                                                                            class="form-control form-control-file"
                                                                            accept=".xlsx, .xls">
                                                                        @error('excel_file')
                                                                            <div class="text-danger">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Upload</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
           $('.prevent-multiple-submit').on('submit', function() {
               $(this).find('button[type="submit"]').prop('disabled', true);
               var buttons = $(this).find('button[type="submit"]');
               setTimeout(function() {
                   buttons.prop('disabled', false);
               }, 20000); // 25 seconds in milliseconds
           });
       });
    </script>
@endsection
