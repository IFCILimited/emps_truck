@extends('layouts.dashboard_master')
@section('title')
   EMPS Authentication Report
@endsection

@push('styles')
<style>
    .card {
        cursor: pointer; /* Show pointer on hover */
        text-decoration: none; /* Remove underline */
        color: inherit; /* Keep text color */
    }
</style>
@endpush
@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="row">
                    <div class="col-6">
                        <h4>Model Revert</h4>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 m-2">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <form method="get">
                        <div class="row align-items-center">
                            <div class="form-group col-md-3">
                                <label for="oemDropdown">OEM</label>
                                <select class="form-control" name="oem_id" id="oem_id">
                                    <option value="all">All</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request()->query('oem_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="modelDropdown">Model Name</label>
                                <select class="form-control" name="model_id" id="model_id">
                                    <option value="all">All</option>
                                    @foreach($modelName as $modelNames)
                                        <option value="{{ $modelNames->model_id }}" {{ request()->query('model_id') ==  $modelNames->model_id ? 'selected' : '' }}>
                                            {{ $modelNames->model_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-2 align-items-center">
                                <input type="submit" value="Filter" class="btn btn-primary">
                            </div>

                            <div class="form-group col-md-2 align-items-center">
                                <a href="{{ route('modelChartDetails.create') }}" class="btn btn-danger w-100 text-center">Reset filters</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="table table-bordered custom-table header-fix">
                                    <thead class="text-center align-middle table-primary">
                                        <tr>
                                            <th>S.No.</th>
                                            <th>OEM Name</th>
                                            <th>Model Name</th>
                                            <th>Segment Name</th>
                                            <th>Vehicle Category</th>
                                            <th>Model Type</th>
                                            <th>Factory Price</th>
                                            <th>{{ env('APP_NAME') }} Certificate Effective Date</th>
                                            <th>{{ env('APP_NAME') }} Compliance Certificate Valid Upto</th>
                                            <th>Testing Status</th>
                                            <th>PMA Revert Remarks</th>
                                            <th>PMA Revert By</th>
                                            <th class="w-2">PMA Revert at</th>
                                            <th>MHI Revert Remarks</th>
                                            <th>MHI Revert By</th>
                                            <th>MHI Revert at</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center align-middle">
                                        @forelse ($datas as $key => $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->oem_name }}</td>
                                                <td>{{ $data->model_name }}</td>
                                                <td>{{ $data->segment }}</td>
                                                <td>{{ $data->vehicle_cat }}</td>
                                                <td>{{ $data->model_type }}</td>
                                                <td>{{ number_format($data->factory_price, 2) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->valid_date)->format('d-m-Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->valid_upto)->format('d-m-Y') }}</td>
                                                <td>{{ $data->testing_flag }}</td>
                                                <td>{{ $data->pma_revert_remarks }}</td>
                                                <td>{{ $data->name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->pma_revert_created_at)->format('d-m-Y') }}</td>
                                                <td>{{ $data->mhi_revert_remarks }}</td>
                                                <td>{{ $data->mhi_name }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->mhi_revert_created_at)->format('d-m-Y') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="18" class="text-center">No records found</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
 $(document).ready(function () {
    $("#oem_id").change(function () {
        var oemId = $(this).val();
        // console.log("oem_id is: ", oemId);
        // return false;
        if (oemId !== "") {
            $.ajax({
                url: "/fetchModelRevert/" + oemId,
                type: "GET",
                success: function (data) {
                    // Update Model Dropdown
                    $("#model_id").empty();
                    $("#model_id").append('<option value="all">All</option>');

                    $.each(data.data, function (key, model) {
                        $("#model_id").append(
                            '<option value="' + model.model_id + '">' + model.model_name + "</option>"
                        );
                    });
                },
                error: function () {
                    alert("Error loading models. Please try again.");
                },
            });
        } else {
            $("#model_id").empty().append('<option value="">All</option>');
        }
    });
});

</script>
@endpush

