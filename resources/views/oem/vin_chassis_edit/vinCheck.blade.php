@extends('layouts.dashboard_master')
@section('title')
    Open Vin For Edit
@endsection

@push('styles')
@endpush

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Manage Vin Chassis</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg>
                                </a>
                            </li>
                            <li class="breadcrumb-item">Manage Vin Chassis</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Form starts here -->
                            <form id="deleteAllVinForm" action="{{ route('editVin.edit')}}" method="POST">
                                @csrf
                                <div class="dt-ext table-responsive custom-scrollbar">
                                    <input type="hidden" name="vin_id" value="{{$vinChassis->id}}">
                                    <table class="display table-bordered table-striped" id="basic-13">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Model Name</th>
                                                <th>Vin Chassis No.</th>
                                                <th>Factory Price</th>
                                                <th>Motor Number</th>
                                                <th>Battery Maker</th>
                                                <th>Manufacturing Date</th>
                                                <th>Total Energy Capacity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- {{dd($vinChassis->id)}} --}}
                                            @foreach ($vinChassisData as $key => $ovin)

                                            <tr>
                                                {{-- {{dd($ovin['open_vins']->id)}} --}}
                                                <td>{{ $loop->iteration }}</td>
                                                @if (!empty($ovin['open_vins']) && is_object($ovin['open_vins']))
                                                <input type="hidden" name="prod_id[]" value="{{$ovin['open_vins']->id}}">
                                                    <td>{{ $ovin['open_vins']->model_name ?? 'N/A' }}</td>
                                                    <td>{{ $ovin['open_vins']->vin_chassis_no ?? 'N/A' }}</td>
                                                    <td>{{ $ovin['open_vins']->factory_price ?? 'N/A' }}</td>
                                                    <td>{{ $ovin['open_vins']->motor_number ?? 'N/A' }}</td>
                                                    <td>{{ $ovin['open_vins']->battery_make ?? 'N/A' }}</td>
                                                    <td>{{ $ovin['open_vins']->manufacturing_date ?? 'N/A' }}</td>
                                                    <td>{{ $ovin['open_vins']->total_energy_capacity ?? 'N/A' }}</td>
                                                @else
                                                    <td colspan="7">No VIN details available</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Button to delete all VINs -->
                                <div class="col-sm-12 mt-3">
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" id="deleteAllVinButton" class="btn btn-danger">Delete All Vin</button>
                                    </div>
                                </div>
                            </form>
                            <!-- Form ends here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    document.getElementById('deleteAllVinButton').addEventListener('click', function (e) {
        e.preventDefault(); // Prevent default form submission
        Swal.fire({
            title: 'Are you sure?',
            text: "This Vin will be permanently deleted. Please confirm to proceed.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Disable the button to prevent multiple submissions
                const deleteButton = document.getElementById('deleteAllVinButton');
                deleteButton.disabled = true;
                deleteButton.innerHTML = 'Deleting...'; // Optional: Show loading text
                // Submit the form
                document.getElementById('deleteAllVinForm').submit();
            }
        });
    });
</script>
@include('partials.js.prevent')
@endpush
