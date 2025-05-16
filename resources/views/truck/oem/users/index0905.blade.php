<!-- Nav Bar Ends here -->
@extends('layouts.e_truck_dashboard_master')
@section('title')
    Manage User
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
                        <h4>Manage User</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            {{-- <li class="breadcrumb-item">Manage OEM</li>
                            <li class="breadcrumb-item active">OEM Post-Registration</li> --}}
                            <li class="breadcrumb-item">Manage User</li>
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
                        <a href="{{ route('e-trucks.manageUser.create') }}" class="text-light" style="text-decoration: none;"><i class="fa fa-user"></i>  Add User</a>
                    </button>
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
                                            <th>Name</th>
                                            <th>Authorized Person Name</th>
                                            <th>UserName</th>
                                            <th>Email</th>
                                            <th>Mobile Number</th>
                                            <th>Designation</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $key => $user)
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->auth_name }}</td>
                                                <td>{{ $user->username }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->mobile }}</td>
                                                <td>{{ $user->auth_designation }}</td>
                                                {{-- <td>{{ ($user->isapproved == 'Y') ? 'Approved' : 'Not Approved' }}</td> --}}
                                                <td style="color: {{ ($user->isapproved == 'Y') ? 'green' : 'red' }};">
                                                    {{ ($user->isapproved == 'Y') ? 'Active' : 'De-active' }}
                                                </td>
                                                <td>
                                                    <ul class="action">
                                                        <li class=""><a href="{{ route('e-trucks.manageUser.edit', encrypt($user->id)) }}" class="btn btn-sm btn-warning">Edit</a></li>
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

@push('scripts')
@include('partials.js.prevent')
@endpush
