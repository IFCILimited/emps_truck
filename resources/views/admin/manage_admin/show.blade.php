@extends('layouts.dashboard_master')

@section('title')
    Admin - View Module
@endsection

@section('content')
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>View Admin</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Manage Admin</li>
                            <li class="breadcrumb-item active">View Admin</li>
                        </ol>
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
                            <div class="row g-2">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Name:</label>
                                        <p>{{ $users->name }}</p>
                                    </div>
                                </div>
                                <!-- Repeat similar fields for other user details -->
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">User Type:</label>
                                        <p>{{ $users->user_type }}</p>
                                    </div>
                                </div>
                                <!-- Repeat similar fields for other user details -->
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">E-Mail ID:</label>
                                        <p>{{ $users->email }}</p>
                                    </div>
                                </div>
                                <!-- Repeat similar fields for other user details -->
                                <!-- For example, for Mobile -->
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Mobile No.:</label>
                                        <p>{{ $users->mobile }}</p>
                                    </div>
                                </div>
                                <!-- Repeat similar fields for other user details -->
                                <!-- For example, for Designation -->
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Designation:</label>
                                        <p>{{ $users->designation }}</p>
                                    </div>
                                </div>
                                <!-- Repeat similar fields for other user details -->
                                <!-- For example, for Status -->
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Status:</label>
                                        <p>{{ $users->isactive == 'Y' ? 'Active' : 'Inactive' }}</p>
                                    </div>
                                </div>
                                <!-- Repeat similar fields for other user details -->
                                <!-- For example, for Password -->
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Password:</label>
                                        <p>{{ $users->password }}</p>
                                    </div>
                                </div>
                                <!-- Repeat similar fields for other user details -->
                                <!-- For example, for Confirm Password -->
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Confirm Password:</label>
                                        <p>{{ $users->password_confirmation }}</p>
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
