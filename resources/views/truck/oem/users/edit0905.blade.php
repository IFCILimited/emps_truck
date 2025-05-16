<!-- resources/views/application.blade.php -->

@extends('layouts.e_truck_dashboard_master')

@section('title', 'OEM - Dealer Application')
@push('styles')
    <style>
        .help-block {
            color: red;
        }
    </style>
@endpush

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>User Registration</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('e-trucks.manageUser.update', $users->id) }}" id="creUser" role="form" method="POST"
                        class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        {{ method_field('Patch') }}
                        <div class="card">
                            <div class="card-body">
                                <div class=" row">
                                    <div class="col-md-12" style="background-color: #CCCCCC;">
                                        <h5 style="padding: 10px;">User Registration</h5>
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <input type="hidden" name="name" value="{{ Auth::user()->name }}">
                                    <div class="col-md-4">
                                        <label for="dealer_name" class="col-form-label text-md-right">Auth Name<span
                                                class="text-danger">*</span></label>
                                            <input type="text" name="auth_name"  value="{{$users->auth_name}}" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                    <label for="dealer_code" class="col-form-label text-md-right">Email<span
                                            class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" value="{{$users->email}}" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="dealer_name" class="col-form-label text-md-right">Mobile<span
                                                class="text-danger">*</span></label>
                                            <input type="number" name="mobile" value="{{$users->mobile}}" class="form-control">
                                        </div>


                                        <div class="col-md-4">
                                            <label for="dealer_name" class="col-form-label text-md-right">Designation<span
                                                    class="text-danger">*</span></label>
                                                <input type="text" name="designation" value="{{$users->auth_designation}}" class="form-control">
                                        </div>

                                        {{-- <div class="col-md-4">
                                            <label for="dealer_name" class="col-form-label text-md-right">Status<span
                                                    class="text-danger">*</span></label>
                                                    <select class="form-control" name="isactive" id="">
                                                        <option disabled selected>Select</option>
                                                        <option value="Y" {{($users->isactive == 'Y') ? 'selected' : ''}}>Activate</option>
                                                        <option value="N" {{($users->isactive == 'N') ? 'selected' : ''}} >Deactivate</option>
                                                    </select>
                                        </div> --}}

                                        <div class="col-md-4">
                                            <label for="dealer_name" class="col-form-label text-md-right">Is active<span
                                                    class="text-danger">*</span></label>
                                                    <select class="form-control" name="isactive" id="">
                                                        <option disabled selected>Select</option>
                                                        <option value="Y" {{($users->isactive == 'Y') ? 'selected' : ''}}>Activate</option>
                                                        <option value="N" {{($users->isactive == 'N') ? 'selected' : ''}} >Deactivate</option>
                                                    </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="remarks" class="col-form-label text-md-right">Remarks<span class="text-danger">*</span></label>
                                            <textarea name="remarks" class="form-control" rows="3">{{$users->remarks}}</textarea>
                                        </div>
                                </div>








                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-md-4 text-left">
                                <a href="{{ route('e-trucks.manageDealer.index') }}" class="btn btn-warning">Back</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\StoreUserDataRequest', '#creUser') !!}
@include('partials.js.pincode')
@include('partials.js.prevent')
<script>
     $('#email').on('blur', function() {
                var email = $(this).val();

                // Send AJAX request to the server to check if the email exists
                $.ajax({
                    type: 'POST',
                    url: '{{ route('check.email') }}',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'email': email
                    },
                    success: function(response) {
                        if (response.exists) {
                            // Email exists, show error message or take appropriate action
                            $('#email').val('')
                            alert('Email already exists!');
                        }
                    }
                });
            });
</script>
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
