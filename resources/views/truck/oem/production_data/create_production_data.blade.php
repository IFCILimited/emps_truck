<!-- Nav Bar Ends here -->
@extends('layouts.e_truck_dashboard_master')
@section('title')
    OEM Production Data
@endsection

@push('styles')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-7">
                        <h4>Manage Production Data</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-4">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center fw-bold">Model Name:</th>
                                <th class="text-center fw-bold">Varient Name</th>
                                <th class="text-center fw-bold">Vehicle Segment</th>
                                <th class="text-center fw-bold">Factory Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <td class="text-center">{{ $modelMaster->first()->model_name }}</td>
                            <td class="text-center">{{ $modelMaster->first()->variant_name }}</td>
                            <td class="text-center">{{ $modelMaster->first()->segment_name }}</td>
                            <td class="text-center">{{ $modelMaster->first()->factory_price }}</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('e-trucks.manageProductionData.store') }}" id="creProd" role="form"
                                method="POST" class='form-horizontal prevent-multiple-submit' files=true
                                enctype='multipart/form-data' accept-charset="utf-8">
                                <div class="dt-ext table-responsive  custom-scrollbar">
                                    @csrf
                                    <table class="display  table-striped" id="export-button1">
                                        <thead>
                                            <tr>
                                                <th>S.No.</th>
                                                <th>Model name</th>
                                                <th> Model Code </th>
                                                <th> Manufacturing Date </th>
                                                <th> VIN Chassis No </th>
                                                <th>colour</th>
                                                <th> Emission Norms </th>
                                                <th> Motor Number </th>
                                                <th> Gross Weight </th>
                                                <th> Battery Make </th>
                                                <th> No Of Batteries </th>
                                                <th> Battery Capacity </th>
                                                <th> BatteryChemistry </th>
                                                <th> DVA Indicative </th>
                                                <th> PMP Compliance </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($items as $key => $item)
                                                <tr>
                                                    {{-- @php
                                                        $manufacturingDate = strtotime($item->manufacturing_date);
                                                        $formattedDate = date('d-m-Y', $manufacturingDate);
                                                    @endphp --}}
                                                    <input type="hidden" name="model_master_id"
                                                        value="{{ $item->model_master_id }}">
                                                    <input type="hidden" name="model_deatils_id"
                                                        value="{{ $item->model_details_id }}">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][model_name]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->model_name }}" disabled>
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][model_code]"
                                                            class="form-control form-control-sm text-right"
                                                            value="{{ $item->model_code }}" disabled>
                                                    </td>
                                                    <td>
                                                        <input type="date"
                                                            name="production[{{ $key }}][manufacturing_date]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->manufacturing_date }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][vin_chassis_no]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->vin_chassis_no }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][colour]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->colour }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][emission_norms]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->emission_norms }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][motor_number]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->motor_number }}">
                                                    </td>
                                                     <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][gross_weight]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->gross_weight }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_make]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_make }}">
                                                    </td>
                                                    {{-- <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_number]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_number }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_number2]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_number2 }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_number3]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_number3 }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_number4]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_number4 }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_number5]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_number5 }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_number6]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_number6 }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_number7]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_number7 }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_number8]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_number8 }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_number9]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_number9 }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_number10]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_number10 }}">
                                                    </td> --}}
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][no_of_battery]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->no_of_battery }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_capacity]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_capacity }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][battery_chemistry]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->battery_chemistry }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][dva_indicative]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->dva_indicative }}">
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            name="production[{{ $key }}][pmp_compliance]"
                                                            class="form-control form-control-sm"
                                                            value="{{ $item->pmp_compliance }}">
                                                    </td>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row justify-content-center my-2">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Save as Draft</button>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-danger" onclick="confirmDelete('{{ route('e-trucks.manageProductionData.deleteTempData', ['id' => $items[0]->model_master_id, 'status' => '1']) }}')">Delete</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <a href="{{ route('e-trucks.manageProductionData.index') }}" class="btn btn-warning">Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('partials.js.prevent')
    {!! JsValidator::formRequest('App\Http\Requests\ProductionDataRequest', '#creProd') !!}

    <script>
        $(document).ready(function() {
    $('#creProd').on('submit', function(e) {
        let isValid = true;
        const startDate = new Date('2024-04-01');
        const endDate = new Date('2026-03-31');

        $('input[name^="production"][name$="[manufacturing_date]"]').each(function() {
            const manufacturingDate = new Date($(this).val());
            if (manufacturingDate < startDate || manufacturingDate > endDate) {
                isValid = false;
                alert('The manufacturing date must be between April 1, 2024, March 31, 2026.');
                return false; // Exit the each loop
            }
        });

        if (!isValid) {
            e.preventDefault();
            return; // Exit the submit handler
        }

        e.preventDefault(); // Prevent the default form submission

        // Fetch all data from the DataTable
        var allData = [];
        var table = $("#export-button1").DataTable(); // Initialize the DataTable inside the submit handler
        table.rows().every(function() {
            var row = {};
            $(this.node()).find('input').each(function() {
                var name = $(this).attr('name');
                if (name) {
                    row[name] = $(this).val();
                }
            });
            allData.push(row);
        });

        // Prepare the data to be sent to the server
        var formData = {
            _token: $('input[name=_token]').val(), // CSRF token
            production: allData,
            model_master_id: $('input[name=model_master_id]').val(),
            model_deatils_id: $('input[name=model_deatils_id]').val()
        };

        // Send data to the server using AJAX
        $.ajax({
            url: $('#creProd').attr('action'), // Use the form's action attribute
            method: 'POST',
            data: formData,
            success: function(response) {
                // Handle success
                swal.fire('Success', 'Data saved successfully', 'success')
                    .then(() => {
                        window.location.href = response.redirect_url;
                    });
            },
            error: function(xhr, status, error) {
                // Attempt to parse JSON response
                try {
                    var response = xhr.responseJSON;
                    if (response && response.error) {
                        swal.fire('Error', response.error, 'error');
                    } else {
                        swal.fire('Error', response.message, 'error');
                    }
                } catch (e) {
                    // If parsing fails, show raw response text
                    swal.fire('Error', 'An error occurred: ' + xhr.responseText, 'error');
                }
            }
        });
    });

    var table = $("#export-button1").DataTable({
        dom: "Bfrtip",
        buttons: ["csvHtml5"],
        pageLength: 100, // Display 100 entries per page
        lengthMenu: [10, 20, 50, 100, 2000], // Options for number of entries per page
        order: [], // Disable initial sorting
        columnDefs: [{
            targets: 'no-sort',
            orderable: false
        }], // Add 'no-sort' class to columns you don't want to be sortable
        searching: true // Ensure that searching is enabled
    });

    $('.prevent-multiple-submit').on('submit', function() {
        $(this).find('button[type="submit"]').prop('disabled', true);
        var buttons = $(this).find('button[type="submit"]');
        setTimeout(function() {
            buttons.prop('disabled', false);
        }, 20000); // 20 seconds in milliseconds
    });
});
function confirmDelete(url) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to delete this? This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the URL if confirmed
                window.location.href = url;
            }
        });
    }


    </script>
@endpush
