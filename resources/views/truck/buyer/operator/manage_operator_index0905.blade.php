<!-- Nav Bar Ends here -->
@extends('layouts.e_truck_dashboard_master')
@section('title')
    Manage Dealer
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
                        <h4>Manage Operator</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            {{-- <li class="breadcrumb-item">Manage OEM</li>
                            <li class="breadcrumb-item active">OEM Post-Registration</li> --}}
                            <li class="breadcrumb-item">Manage Operator</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <span class="pull-right">
                    <button class="btn btn-primary" type="button">
                        <a href="{{ route('e-trucks.manageOperator.create') }}" class="text-light" style="text-decoration: none;"><i class="fa fa-user"></i>  Add Operator</a>
                    </button>
                    {{-- <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#AddBulkDearlers"><i class="fa fa-users"></i>  Add Dealers in Bulk</button> --}}
                </span>
                &nbsp;
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Operator Name</th>
                                            <th>Operator Code</th>
                                            <th>Mobile Number</th>
                                            <th>Username</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dealerReg as $key => $dealerRegs)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $dealerRegs->name }}</td>
                                                <td>{{ $dealerRegs->dealer_code }}</td>
                                                <td>{{ $dealerRegs->mobile }}</td>
                                                <td>{{ $dealerRegs->username }}</td>
                                                <td>
                                                    <ul class="action">
                                                        @if($dealerRegs->isactive == 'Y' && $dealerRegs->isapproved == 'Y')
                                                            <li>
                                                                <a href="javascript:void(0);"
                                                                   class="btn btn-sm btn-primary"
                                                                   onclick="confirmAction('{{ route('e-trucks.updateOperator.update', encrypt($dealerRegs->id)) }}', 'deactivate')">
                                                                   Login Activate
                                                                </a>
                                                            </li>
                                                        @elseif($dealerRegs->isactive == 'N' && $dealerRegs->isapproved == 'N')
                                                            <li>
                                                                <a href="javascript:void(0);"
                                                                   class="btn btn-sm btn-danger"
                                                                   onclick="confirmAction('{{ route('e-trucks.updateOperator.update', encrypt($dealerRegs->id)) }}', 'activate')">
                                                                   Login Deactivate
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </td>

                                                <td>
                                                    <ul class="action">
                                                        @if($dealerRegs->isactive == 'Y' && $dealerRegs->isapproved == 'Y')
                                                            <!-- Deactivate Button -->
                                                            <li><a href="{{ route('e-trucks.manageOperator.edit', encrypt($dealerRegs->id)) }}" class="btn btn-sm btn-warning">Edit</a></li>&nbsp;
                                                            <li><a href="{{ route('e-trucks.manageDealer.resendMail', encrypt($dealerRegs->id)) }}" class="btn btn-sm btn-success">Resend Mail</a></li>
                                                        @elseif($dealerRegs->isactive == 'N' && $dealerRegs->isapproved == 'N')
                                                            <!-- Activate Button -->
                                                            <li><a href="#" class="btn btn-sm btn-warning disabled" style="pointer-events: none; opacity: 0.6;">Edit</a></li>&nbsp;
                                                            <li><a href="#" class="btn btn-sm btn-success disabled" style="pointer-events: none; opacity: 0.6;">Resend Mail</a></li>
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
    <div class="modal fade" id="AddBulkDearlers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Excel File</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ asset('files/BulkDealer.xlsx') }}" class="btn btn-pill btn-outline-info btn-air-info"><i class="fa fa-file-excel-o"></i> Download Excel Format</a>
                        &nbsp;<span data-bs-dismiss="modal"><i class="fa fa-window-close" aria-hidden="true"></i></span>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{ route('e-trucks.upload-excel') }}" method="POST" enctype="multipart/form-data" class="class='form-horizontal prevent-multiple-submit">
                        @csrf
                        <div class="form-group">
                            <label for="excel_file">Choose Excel File:</label>
                            <input type="file" name="excel_file" id="excel_file" class="form-control form-control-file" accept=".xlsx, .xls">
                            @error('excel_file')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary m-2">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@include('partials.js.prevent')

<script>
    function confirmAction(url, actionType) {
        let actionText = actionType === 'deactivate' ? 'deactivate' : 'activate';
        let confirmButtonColor = actionType === 'deactivate' ? '#d33' : '#28a745';

        Swal.fire({
            title: "Are you sure?",
            text: "You are about to " + actionText + " this operator!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, " + actionText + "!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url; // Redirect to update route
            }
        });
    }
</script>
@endpush
