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
                        <h4>Dealer Registration</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('e-trucks.manageDealer.store') }}" id="creDealer" role="form" method="POST"
                        class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class=" row">
                                    <div class="col-md-12" style="background-color: #CCCCCC;">
                                        <h5 style="padding: 10px;">Dealer Registration</h5>
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="dealer_name" class="col-md-2 col-form-label text-md-right">Dealer Name<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="dealer_name" class="form-control">
                                    </div>
                                    <label for="dealer_code" class="col-md-2 col-form-label text-md-right">Dealer Code<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="dealer_code" class="form-control">
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="gstin_number" class="col-md-2 col-form-label text-md-right">GSTIN
                                        Number<span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="gstin_number" class="form-control">
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <div class="col-md-12" style="background-color: #CCCCCC;">
                                        <h5 style="padding: 10px;">Address of Sales Outlet</h5>
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="authorized_person_name"
                                        class="col-md-2 col-form-label text-md-right">Authorized Person Name<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="authorized_person_name" class="form-control">
                                    </div>
                                    <label for="address" class="col-md-2 col-form-label text-md-right">Address<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <textarea name="address" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="pin_code" class="col-md-2 col-form-label text-md-right">Pin Code<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="number" id="pin_code" name="pin_code" class="form-control"
                                            onkeyup="GetCityByPinCode('DEA', this.value, 0)">
                                        <span id="DEApincodeMsg0" style="color:red;font-weight:bold;display: none">

                                    </div>

                                    <label for="state" class="col-md-2 col-form-label text-md-right">State<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="state" class="form-control readonly" id="DEAAddState0"
                                            value="" readonly>

                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="district" class="col-md-2 col-form-label text-md-right">District<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="district" class="form-control readonly"
                                            id="DEAAddDistrict0" value=" " readonly>

                                    </div>

                                    <label for="landmark" class="col-md-2 col-form-label text-md-right">Landmark<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="landmark" class="form-control">
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="mobile_no" class="col-md-2 col-form-label text-md-right">Mobile No.<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="number" name="mobile_no" class="form-control">
                                    </div>

                                    <label for="landline_no" class="col-md-2 col-form-label text-md-right">Landline
                                        No.</label>
                                    <div class="col-md-4">
                                        <input type="number" name="landline_no" class="form-control">
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="fax_no" class="col-md-2 col-form-label text-md-right">Fax No.</label>
                                    <div class="col-md-4">
                                        <input type="text" name="fax_no" class="form-control">
                                    </div>
                                    <label for="email_id" class="col-md-2 col-form-label text-md-right">E-Mail ID<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="email" name="email_id" id="email" class="form-control">
                                    </div>
                                </div>
                                &nbsp;
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-md-4 text-left">
                                <a href="{{ route('e-trucks.manageDealer.index') }}" class="btn btn-warning">Back</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Application</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\DealerRegistrationRequest', '#creDealer') !!}
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
