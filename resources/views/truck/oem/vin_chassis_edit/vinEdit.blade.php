<!-- Nav Bar Ends here -->
@extends('layouts.e_truck_dashboard_master')
@section('title')
Open Vin For Edit
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
                    <h4>Manage Vin Chassis</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">
                                <svg class="stroke-icon">
                                    <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Manage Vin Chassis</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12" style="margin-top: 10px">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="table table-bordered table-striped" id="basic-13">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Vin Chassis Number</th>
                                            <th>Date Valid From</th>
                                            <th>Date Valid To</th>
                                            <th>Reason</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vinChassis as $key => $ovin)
                                            @if($ovin->delete_vin == 'N')
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        @if (is_array($ovin->vin_chassis))
                                                            @foreach ($ovin->vin_chassis as $vin)
                                                                {{ $vin }}<br> {{-- Adjust display logic if needed --}}
                                                            @endforeach
                                                        @else
                                                            {{ $ovin->vin_chassis }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $ovin->valid_from }}</td>
                                                    <td>{{ $ovin->valid_to }}</td>
                                                    <td>{{ $ovin->reason }}</td>
                                                    <td>
                                                        <ul class="">
                                                            <li class=""><a href="{{ route('e-trucks.editVin.create', $ovin->id)}}"
                                                                    class="btn btn-sm btn-primary">View Vin Details</a></li>
                                                            &nbsp;
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endif
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
</div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            let fieldCount = 1; // Start with the first field

            // Add a new row
            $(document).on('click', '.add-more', function (e) {
                e.preventDefault();

                fieldCount++; // Increment field count
                const newField = `
                    <div class="form-group d-flex align-items-center mb-2">
                        <input type="text" name="vinchassis[${fieldCount}]" class="form-control" placeholder="Enter VIN Chassis ${fieldCount}">
                        <button type="button" class="btn btn-danger ml-2 remove-field">Remove</button>
                    </div>
                `;

                $('#vinchassis-container').append(newField);
            });

            // Remove a row
            $(document).on('click', '.remove-field', function (e) {
                e.preventDefault();
                $(this).closest('.form-group').remove();
            });
        });
    </script>
    @include('partials.js.prevent')
@endpush