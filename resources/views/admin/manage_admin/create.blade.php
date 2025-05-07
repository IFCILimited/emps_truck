@extends('layouts.dashboard_master')

@section('title')
    Admin - Creation Module
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
                        <h4>Admin Create</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Manage Admin</li>
                            <li class="breadcrumb-item active">Admin Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <form action="{{ route('superAdmin.store') }}" id="AdminCreationForm" role="form"
                        method="post" class='form-control prevent-multiple-submit' files=true
                        enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Name:<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder="Admin Name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">User Type:<span class="text-danger">*</span></label>
                                        <select class="form-control" name="user_type">
                                            <option selected disabled>Select</option>
                                            <option value="PMA">PMA</option>
                                            <option value="AUDITOR">AUDITOR</option>
                                            <option value="MHI-AS">MHI-AS</option>
                                            <option value="MHI-DS">MHI-DS</option>
                                            <option value="MHI-OnlyView">MHI-OnlyView</option>
                                            <option value="TESTINGAGENCY">Testing Agency</option>
                                            {{-- <option value="TESTINGAGENCY">Testing Agency</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">E-Mail ID :<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="email" placeholder="E-Mail">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Mobile No.:<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="mobile" placeholder="Mobile No.">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Designation :<span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="designation" placeholder="Designation">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Status :<span class="text-danger">*</span></label>
                                        <select class="form-control" name="status">
                                            <option selected disabled>Select</option>
                                            <option value="Y" selected>Active</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Password:<span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password" placeholder="Password">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="col-form-label pt-0">Confirm Password:<span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
                                    </div>
                                </div> --}}
                                <div class="col-4"></div>
                                <div class="col-4 mt-4">
                                    <div class="form-group">
                                        {{-- <label class="col-form-label pt-0">Actions</label> --}}
                                        <div class="text-center">
                                            <button type="reset" class="btn btn-secondary me-2"><i class="fa fa-refresh"></i> Reset</button>
                                            <button type="submit" class="btn btn-primary submit-button"><i class="fa fa-save"></i> Submit</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\AdminCreationRequest', '#AdminCreationForm') !!}

<script>
     $(document).ready(function() {
        $('.prevent-multiple-submit').on('submit', function() {
            $(this).find('button[type="submit"]').prop('disabled', true);
            var buttons = $(this).find('button[type="submit"]');
            setTimeout(function() {
                buttons.prop('disabled', false);
            }, 10000); // 25 seconds in milliseconds
        });
    });
</script>
@endpush
