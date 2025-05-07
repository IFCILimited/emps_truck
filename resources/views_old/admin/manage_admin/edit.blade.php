@extends('layouts.dashboard_master')

@section('title')
    Admin - Edit Module
@endsection

@push('styles')
@endpush

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Admin</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Manage Admin</li>
                            <li class="breadcrumb-item active">Edit Admin</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="text-end m-1">
                <a href="{{ route('superAdmin.index') }}" class="btn btn-primary ">Back</a>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    {{-- <div class="col-12 card mt-2" >
                        <p class="m-2">
                            <strong> Note:</strong>
                            Password changes are not allowed for this account because the password is auto-generated. An
                            automatically generated password will be sent to your registered email address whenever your
                            account data is updated. This ensures the security and integrity of your account. If you have
                            any issues accessing your account, please contact support.
                        </p>
                    </div> --}}
                    <div class="card">
                        <form action="{{ route('superAdmin.update', $users->id) }}" method="post"
                            class="form-control prevent-multiple-submit" files=true enctype="multipart/form-data"
                            accept-charset="utf-8">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="col-form-label pt-0">Name:<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="name"
                                                placeholder="Admin Name" value="{{ $users->name }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="col-form-label pt-0">User Type:<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="user_type">
                                                <option disabled>Select</option>
                                                <option value="PMA" {{ $users->user_type == 'PMA' ? 'selected' : '' }}>
                                                    PMA</option>
                                                <option value="AUDITOR"
                                                    {{ $users->user_type == 'AUDITOR' ? 'selected' : '' }}>AUDITOR</option>
                                                <option value="MHI-AS"
                                                    {{ $users->user_type == 'MHI-AS' ? 'selected' : '' }}>MHI-AS</option>
                                                <option value="MHI-DS"
                                                    {{ $users->user_type == 'MHI-DS' ? 'selected' : '' }}>MHI-DS</option>
                                                <option value="MHI-OnlyView"
                                                    {{ $users->user_type == 'MHI-OnlyView' ? 'selected' : '' }}>MHI-OnlyView
                                                </option>
                                                {{-- <option value="TESTINGAGENCY" {{ $users->user_type == 'TESTINGAGENCY' ? 'selected' : '' }}>Testing Agency</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="col-form-label pt-0">E-Mail ID:<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="email" name="email" placeholder="E-Mail"
                                                value="{{ $users->email }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="col-form-label pt-0">Mobile No.:<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="mobile"
                                                placeholder="Mobile No." value="{{ $users->mobile }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="col-form-label pt-0">Designation:<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="text" name="designation"
                                                placeholder="Designation" value="{{ $users->auth_designation }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="col-form-label pt-0">Status:<span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="status">
                                                <option disabled>Select</option>
                                                <option value="Y" {{ $users->isactive == 'Y' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="N" {{ $users->isactive == 'N' ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                        </div>  
                                    </div>
                               
                                    {{-- <div class="col-4">
                                        <div class="form-group">
                                            <label class="col-form-label pt-0">Password:<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="password" name="password"
                                                placeholder="Password" disabled value="{{ Hash::make($users->password) }}">
                                        </div>
                                    </div>
                                 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="col-form-label pt-0">Confirm Password:<span
                                                    class="text-danger">*</span></label>
                                            <input class="form-control" type="password" name="password_confirmation"
                                                placeholder="Confirm Password" disabled
                                                value="{{ Hash::make($users->password) }}">
                                        </div>
                                    </div> --}}
                                    <div class="col-4"></div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            {{-- <label class="col-form-label pt-0">Actions</label> --}}
                                            <div class="text-center mt-4">
                                                <button type="reset" class="btn btn-secondary me-2"><i
                                                        class="fa fa-refresh"></i> Reset</button>
                                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                                    Update</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4"></div>
                                </div>
                            </div>
                        </form>
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
                }, 10000);
            });
        });
    </script>
@endpush
