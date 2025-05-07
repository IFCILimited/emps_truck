<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
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
                            <li class="breadcrumb-item"><a href="index.html">
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
                {{-- <span class="pull-right">
                    <button class="btn btn-primary" type="button">
                        <a href="{{ route('manageDealer.create') }}" class="text-light" style="text-decoration: none;"><i class="fa fa-user"></i>  Add Single Dealer</a>
                    </button>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#AddBulkDearlers"><i class="fa fa-users"></i>  Add Bulk Dealer</button>
                </span> --}}
               <div class="col-sm-12">
                <div class="card p-10">
                    <div class="row">

                        {{-- <div class="col-lg-3 offset-3">
                            <select class="form-control">
                                <option value="{{ $users->id }}" {{ ($oem_id == $users->id) ? 'selected' : '' }}>
                                    {{ $users->name }}
                                </option>
                            </select>
                        </div> --}}

                    </div>

                </div>
                </div>
            &nbsp;
            <form action="{{route('vinEdit.store')}}" role="form" method="POST"
                            class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                            id="vinsedit" accept-charset="utf-8">
                            @csrf
                <div class="col-sm-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card">
                            <div class="card-header">

                                <h4>{{ $users->name }}
                                {{-- <button type="button" style="white-space: nowrap;float:right;" class="btn btn-primary ml-2 add-more btn-sm">Add More</button> --}}
                                    </h4>
                            </div>
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="table table-bordered table-striped" id="basic-13">
                                    <thead>
                                        {{-- @if($oem_id != null) --}}
                                        <tr>
                                            <th>S.No.</th>
                                            {{-- <th>Oem Name</th> --}}
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Reason</th>
                                            <th>Document</th>

                                        </tr>
                                        {{-- @else --}}
                                        {{-- <tr>
                                            <th>S.No.</th>
                                            <th>Oem Name</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Vin Chassis</th>
                                            <th>Reason</th>
                                            <th>Document</th>

                                        </tr>
                                        @endif --}}
                                    </thead>
                                    <tbody>
                                        {{-- @if($oem_id != null) --}}
                                        @foreach($selusers as $suser)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                {{-- <td>{{$suser->name}} --}}
                                                    <input type="hidden" name="oem_id" value="{{$suser->id}}" id="">
                                                {{-- </td> --}}
                                                <td>
                                                    <input type="date" name="validFrom" class="form-control-sm " id="validFrom">
                                                </td>
                                                <td>
                                                    <input type="date" name="validTo" class="form-control-sm " id="validTo">
                                                </td>
                                                <td>
                                                    <input type="text" name="reason" class="form-control-sm " id="">
                                                </td>

                                                <td>
                                                    <input type="file" name="vin_doc" class="form-control-sm " id="">
                                                </td>

                                            </tr>

                                            @endforeach
                                        {{-- @endif --}}
                                        {{-- @else
                                            @if(isset($openVins))
                                                @foreach($openVins as $ovin)
                                            <tr>
                                                <td>{{$loop->iteration}} </td>
                                                <td>{{$users->where('id',$ovin->oem_id)->first()->name }} </td>
                                            @php
                                                $validfrom = strtotime($ovin->valid_from);
                                                $validfrom_f = date('d-m-Y', $validfrom);

                                                $validto = strtotime($ovin->valid_to);
                                                $validto_f = date('d-m-Y', $validto);
                                            @endphp
                                               <td  data-sort={{$validfrom}}>{{$validfrom_f}}</td>
                                               <td  data-sort={{$validto}}>{{$validto_f}}</td>


                                                <td>
                                                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-original-title="test"
                                                    data-bs-target="#vinshow{{$ovin->id}}"><i class="fa fa-eye">Show Vin</i></button></td>
                                                <td>{{$ovin->reason}}</td>
                                                <td><a href="{{route('doc.down',encrypt($ovin->vin_document))}}" class="btn btn-primary btn-sm"><i class="fa fa-download"></i></a></td>


                                            </tr> --}}
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="basic-13">
                                    <thead>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- @if($oem_id != null) --}}
                <div class="col-sm-12">

                            <div class="card-body">
                                <div id="vinchassis-container" class="row">
                                    <div class="col-4">

                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <th>VIN Chassis</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($chasnonew as $index => $val)
                                                <tr id="vinchassis-{{ $index }}">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <input type="text" @if($val['status'] == 3) name="vinchassis[{{ $index }}]" @endif value="{{ $val['chas_no'] }}" class="form-control" readonly>
                                                    </td>
                                                    <td>
                                                        @if ($val['status'] == 1)
                                                            <span class="text-danger">Sold in EMPS</span>
                                                        @elseif ($val['status'] == 2)
                                                            <span class="text-danger">Sold in PM E-Drive</span>
                                                        @elseif ($val['status'] == 3)
                                                            <span class="text-success">Allowed to Delete</span>
                                                        @else
                                                        <span class="text-danger">Not Found</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning " style="margin: 0 auto;align-items: center;display: grid;" id="openForEditBtn">Open For Edit</button>
            </form>
                        </div>
                    </div>
                </div>
                {{-- @endif --}}







            <!-- Modal HTML with Inline CSS -->
            {{-- <div id="editModal" style="display:none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4); overflow: hidden;">
                <div  style="position: relative; margin: 5% auto; width: 90%; max-width: 1000px; height: auto; background-color: #fff; padding: 30px; border-radius: 10px; overflow: hidden;">
                    <div  style="display: flex; justify-content: space-between; align-items: center;">
                        <form action="{{ route('vinEdit.store') }}" role="form" method="POST"
                        class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                        id="vinsedit" accept-charset="utf-8">
                            @csrf
                        <h5>Edit VIN Chassis</h5>
                        <button type="button" class="closeModal" aria-label="Close" style="font-size: 30px; color: #000; border: none; background: none; cursor: pointer;">&times;</button>
                    </div>
                    <div  style="padding: 20px; overflow-y: auto;">
                        <p>Now you can edit the VIN chassis that are allowed for deletion (status = 1).</p>

                            <table class="table" style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Oem Name</th>
                                        <th>Vin Chassis</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Reason</th>
                                        <th>Document</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($selusers as $suser)
                                    @foreach ($chasnonew as $index => $val)
                                    @if ($val['status'] == 1)


                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$suser->name}}
                                            <input type="hidden" name="oem_id" value="{{$suser->id}}" id="">
                                        </td>

                                        <td>
                                            <input type="text" name="vinchassis" class="form-control-sm " id="" value="{{$val['chas_no']}}">
                                        </td>

                                        <td>
                                            <input type="date" name="validFrom" class="form-control-sm " id="">
                                        </td>
                                        <td>
                                            <input type="date" name="validTo" class="form-control-sm " id="">
                                        </td>
                                        <td>
                                            <input type="text" name="reason" class="form-control-sm " id="">
                                        </td>

                                        <td>
                                            <input type="file" name="vin_doc" class="form-control-sm " id="">
                                        </td>

                                    </tr>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer" style="padding: 15px; display: flex; justify-content: space-between; align-items: center;">
                        <button type="button" class="btn btn-secondary" class="closeModal" style="padding: 8px 15px; background-color: #6c757d; border: none; color: #fff; cursor: pointer;">Close</button>
                        <button type="submit" class="btn btn-primary" form="vinsedit" style="padding: 8px 15px; background-color: #007bff; border: none; color: #fff; cursor: pointer;">Save Changes</button>
                    </div>
                </div>
            </div> --}}






            </div>
        </div>
    </div>

@endsection


<!-- Button trigger modal -->


@push('scripts')

<script>


   $(document).ready(function () {
        let fieldCount = 1; // Start with the first field

        // Add a new row
        $(document).on('click', '.add-more', function (e) {
            e.preventDefault();

            fieldCount++; // Increment field count
            const newField = `
                <div class="col-4"><div class="form-group d-flex align-items-center mb-2">
                    <input type="text" name="vinchassis[${fieldCount}]" class="form-control" placeholder="Enter VIN Chassis ${fieldCount}">
                    &nbsp;<button type="button" class="btn btn-danger ml-2 remove-field btn-sm">Remove</button>
                </div></div>
            `;

            $('#vinchassis-container').append(newField);
        });

        // Remove a row
        $(document).on('click', '.remove-field', function (e) {
            e.preventDefault();
            $(this).closest('.form-group').remove();
        });

        $('.filterBtn').click(function(e) {
    e.preventDefault(); // Prevent default button behavior

    var oem_id = $('#oem_id').val();
    // console.log(oem_id);

    if (!oem_id || oem_id === null) {
        Swal.fire({
            icon: 'warning',
            title: 'Selection Required',
            text: 'Please select OEM before applying the filter.',
            confirmButtonText: 'OK'
        });
        return false; // Prevent further action
    }


    window.location.href = "/vinSearch/" + oem_id ;
});

    });

    document.addEventListener("DOMContentLoaded", function() {
        // Listen for clicks on remove buttons
        document.querySelectorAll('.remove-vin').forEach(button => {
            button.addEventListener('click', function() {
                // Get the index of the VIN field to remove
                const index = this.getAttribute('data-index');
                // Find the parent div of the VIN field and remove it
                const vinChassisDiv = document.getElementById('vinchassis-' + index);
                vinChassisDiv.remove();
            });
        });
    });

    $(document).ready(function () {

// Handle Open For Edit button click
$('#openForEditBtn').on('click', function (e) {
    e.preventDefault(); // Prevent the default form submission

    // Show confirmation Swal
    Swal.fire({
        title: 'Are you sure?',
        text: 'The data is "Allowed to be deleted" and will be deleted permanently.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!'
    }).then((result) => {
        if (result.isConfirmed) {
            // If confirmed, submit the form
            $('#vinsedit').submit();
        }
    });
});

});

$(document).ready(function() {
    // Get today's date in the format yyyy-mm-dd
    const today = new Date().toISOString().split('T')[0];

    // Set the 'min' attribute to today's date for both inputs
    $('#validFrom, #validTo').attr('min', today);

    // Validate 'validFrom' input
    $('#validFrom').on('change', function() {
        const validFromDate = $(this).val();

        if (validFromDate < today) {
            alert("You cannot select a date before today.");
            $(this).val(''); // Reset the value
        } else {
            // Adjust the 'min' date for 'validTo' to match 'validFrom'
            $('#validTo').attr('min', validFromDate);
        }
    });

    // Validate 'validTo' input
    $('#validTo').on('change', function() {
        const validFromDate = $('#validFrom').val();
        const validToDate = $(this).val();

        if (validToDate < validFromDate) {
            alert("The 'Valid To' date cannot be earlier than the 'Valid From' date.");
            $(this).val(''); // Reset the value
        }
    });
});


// Add any other functionalities like remove or add more VIN chassis here...
//});



</script>
@include('partials.js.prevent')
@endpush
