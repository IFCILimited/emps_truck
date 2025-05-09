@extends('layouts.e_truck_dashboard_master')
@section('title', 'OEM - Dealer Application')
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
                <div class="card">
                    <div class="card-body">
                        <form action="{{route('e-trucks.manageDealer.update', $dealerReg->id)}}" id="Dealer" 
                            role="form" method="POST" class='form-horizontal prevent-multiple-submit'
                        accept-charset="utf-8">
                        @csrf
                        @method('put')
                            <div class="form-group row mt-2">
                                <div class="col-md-12" style="background-color: #CCCCCC;">
                                    <h5 style="padding: 10px;">Dealer Registration</h5>
                                </div>
                            </div>
                            <input type="hidden" name="id" value="{{ $dealerReg->id }}"/>
                            <div class="form-group row mt-2">
                                <label for="dealer_name" class="col-md-2 col-form-label text-md-right">Dealer Name<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="dealer_name" name="dealer_name" class="form-control" value="{{$dealerReg->name}}">
                                </div>
                                <label for="dealer_code" class="col-md-2 col-form-label text-md-right">Dealer Code<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="dealer_code" name="dealer_code" class="form-control" value="{{$dealerReg->dealer_code}}">
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <label for="gstin_number" class="col-md-2 col-form-label text-md-right">GSTIN Number<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="gstin_number" name="gstin_number" class="form-control" value="{{$dealerReg->dealer_gstin_no}}">
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <div class="col-md-12" style="background-color: #CCCCCC;">
                                    <h5 style="padding: 10px;">Address of Sales Outlet</h5>
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <label for="authorized_person_name" class="col-md-2 col-form-label text-md-right">Authorized Person Name<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="authorized_person_name" name="authorized_person_name" class="form-control" value="{{$dealerReg->auth_name}}">
                                </div>
                                <label for="address" class="col-md-2 col-form-label text-md-right">Address<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <textarea id="address" name="address" class="form-control" rows="3">{{$dealerReg->address}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                   <label for="pin_code" class="col-md-2 col-form-label text-md-right">Pin Code<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="number" id="pin_code" name="pin_code" class="form-control"   onkeyup="GetCityByPinCode('DEA', this.value, 0)" value="{{$dealerReg->pincode}}">
                                    <span id="DEApincodeMsg0"
                                    style="color:red;font-weight:bold;display: none">
                                    @error('Pincode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label for="state" class="col-md-2 col-form-label text-md-right">State<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="state" class="form-control readonly" id="DEAAddState0"  value="{{$dealerReg->state}}" readonly >
                                @error('State')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-2">

                                <label for="district" class="col-md-2 col-form-label text-md-right">District<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="district" class="form-control readonly" id="DEAAddDistrict0" value="{{$dealerReg->district}}" readonly >
                                    @error('District')
                                                <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                  <label for="landmark" class="col-md-2 col-form-label text-md-right">Landmark<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="landmark" name="landmark" class="form-control" value="{{$dealerReg->landmark}}">
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                 <label for="mobile_no" class="col-md-2 col-form-label text-md-right">Mobile No.<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="number" id="mobile_no" name="mobile_no" class="form-control" value="{{$dealerReg->mobile}}">
                                </div>

                                  <label for="landline_no" class="col-md-2 col-form-label text-md-right">Landline No.<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="number" id="landline_no" name="landline_no" class="form-control" value="{{$dealerReg->landline}}" >
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                            <label for="fax_no" class="col-md-2 col-form-label text-md-right">Fax No.<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="fax_no" name="fax_no" class="form-control" value="{{$dealerReg->fax}}">
                                </div>
                                <label for="email_id" class="col-md-2 col-form-label text-md-right">E-Mail ID<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="email" id="email" name="email_id" class="form-control" value="{{$dealerReg->email}}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12">
                        <div class="col-md-4 text-left">
                            <a href="{{ route('e-trucks.manageDealer.index') }}" class="btn btn-warning">Back</a>
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
@include('partials.js.pincode')
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\DealerRegistrationRequest', '#Dealer') !!}
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
