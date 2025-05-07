<!-- resources/views/application.blade.php -->

@extends('layouts.dashboard_master')

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
                        <h4>Operator Registration</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    
                    <form action="{{ route('manageOperator.update',encrypt($dealerReg->id)) }}" id="creDealer" role="form" method="POST"
                        class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data' accept-charset="utf-8">
                        @csrf
                        {{ method_field('PATCH') }}
                        <div class="card">
                            <div class="card-body">
                                <div class=" row">
                                    <div class="col-md-12" style="background-color: #CCCCCC;">
                                        <h5 style="padding: 10px;">Operator Registration</h5>
                                    </div>
                                </div>
                                {{-- <input type="hidden" name="oem_id" value="{{$oemId->oem_id}}"> --}}
                                <div class=" row mt-2">
                                    <label for="dealer_name" class="col-md-2 col-form-label text-md-right">Operator Name<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="dealer_name" value="{{$dealerReg->auth_name}}" class="form-control">
                                    </div>
                                    <label for="dealer_code" class="col-md-2 col-form-label text-md-right">Operator Code<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="dealer_code" value="{{$dealerReg->dealer_code}}" class="form-control">
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <div class="col-md-12" style="background-color: #CCCCCC;">
                                        <h5 style="padding: 10px;">Address of Sales Outlet</h5>
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="mobile_no" class="col-md-2 col-form-label text-md-right">Mobile No.<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="number" name="mobile_no" value="{{$dealerReg->mobile}}" class="form-control">
                                </div>

                                    <label for="address" class="col-md-2 col-form-label text-md-right">Address<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <textarea name="address" class="form-control" rows="3">{{$dealerReg->address}}</textarea>
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="pin_code" class="col-md-2 col-form-label text-md-right">Pin Code<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="number" id="pin_code" name="pin_code" value="{{$dealerReg->pincode}}" class="form-control"
                                            onkeyup="GetCityByPinCode('DEA', this.value, 0)">
                                        <span id="DEApincodeMsg0" style="color:red;font-weight:bold;display: none">

                                    </div>

                                    <label for="state" class="col-md-2 col-form-label text-md-right">State<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="state" class="form-control readonly" value="{{$dealerReg->state}}" id="DEAAddState0"
                                            value="" readonly>

                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="district" class="col-md-2 col-form-label text-md-right">District<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4"> 
                                        <input type="text" name="district" value="{{$dealerReg->auth_district}}" class="form-control readonly"
                                            id="DEAAddDistrict0" value=" " readonly>

                                    </div>

                                    <label for="landmark" class="col-md-2 col-form-label text-md-right">Landmark<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="landmark" class="form-control" value="{{$dealerReg->landmark}}">
                                    </div>
                                </div>
                                <div class=" row mt-2">
                                    <label for="email_id" class="col-md-2 col-form-label text-md-right">E-Mail ID<span
                                            class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <input type="email" name="email_id" id="email" value="{{$dealerReg->email}}" class="form-control">
                                    </div>
                                </div>
                                &nbsp;
                            </div>
                        </div>
                        <div class="row col-12">
                            <div class="col-md-4 text-left">
                                <a href="{{ route('manageOperator.index') }}" class="btn btn-warning">Back</a>
                            </div>
                            <div class="col-md-4 text-center">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update Application</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\OperatorRegistrationRequest', '#creDealer') !!}
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
