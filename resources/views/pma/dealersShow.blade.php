@extends('layouts.dashboard_master')

@section('title', 'OEM- Dealer Application')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Dealer Registration</h4>
                    </div>
                    <div class="col-6 text-end">
                        <a href="javascript:void(0);" class="btn btn-pill btn-outline-primary" onclick="window.print();"><i
                                class="fa fa-print"></i> Print</a>
                        <a href="{{ route('manageDealer.edit', encrypt($dealerReg->id)) }}"
                            class="btn btn-pill btn-outline-warning"><i class="fa fa-edit"></i> Edit</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group row mt-2">
                                <div class="col-md-12" style="background-color: #CCCCCC;">
                                    <h5 style="padding: 10px;">Dealer Registration</h5>

                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <label for="dealer_name" class="col-md-2 col-form-label text-md-right">Dealer Name<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="dealer_name" name="dealer_name" class="form-control"
                                        value="{{ $dealerReg->name }}" disabled>
                                </div>
                                <label for="dealer_code" class="col-md-2 col-form-label text-md-right">Dealer Code<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="dealer_code" name="dealer_code" class="form-control"
                                        value="{{ $dealerReg->dealer_code }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <label for="gstin_number" class="col-md-2 col-form-label text-md-right">GSTIN Number<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="gstin_number" name="gstin_number" class="form-control"
                                        value="{{ $dealerReg->dealer_gstin_no }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <div class="col-md-12" style="background-color: #CCCCCC;">
                                    <h5 style="padding: 10px;">Address of Sales Outlet</h5>
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <label for="authorized_person_name" class="col-md-2 col-form-label text-md-right">Authorized
                                    Person Name<span class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="authorized_person_name" name="authorized_person_name"
                                        class="form-control" value="{{ $dealerReg->auth_name }}" disabled>
                                </div>
                                <label for="address" class="col-md-2 col-form-label text-md-right">Address<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <textarea id="address" name="address" class="form-control" rows="3" disabled>{{ $dealerReg->address }}</textarea>
                                </div>
                                {{-- <label for="pin_code" class="col-md-2 col-form-label text-md-right">Pin Code<span
                                    class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="pin_code" name="pin_code" class="form-control"   onkeyup="GetCityByPinCode('DEA', this.value, 0)">
                                    <span id="DEApincodeMsg0"
                                    style="color:red;font-weight:bold;display: none">
                                    @error('Pincode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div> --}}
                            </div>
                            <div class="form-group row mt-2">
                                <label for="pin_code" class="col-md-2 col-form-label text-md-right">Pin Code<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="pin_code" name="pin_code" class="form-control"
                                        onkeyup="GetCityByPinCode('DEA', this.value, 0)" value="{{ $dealerReg->pincode }}"
                                        disabled>
                                    <span id="DEApincodeMsg0" style="color:red;font-weight:bold;display: none">
                                        @error('Pincode')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                </div>

                                <label for="state" class="col-md-2 col-form-label text-md-right">State<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="state" class="form-control readonly" id="DEAAddState0"
                                        value="{{ $dealerReg->state }}" readonly disabled>
                                    @error('State')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mt-2">

                                <label for="district" class="col-md-2 col-form-label text-md-right">District<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" name="district" class="form-control readonly"
                                        id="DEAAddDistrict0" value="{{ $dealerReg->district }}" readonly disabled>
                                    @error('District')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label for="landmark" class="col-md-2 col-form-label text-md-right">Landmark<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="landmark" name="landmark" class="form-control"
                                        value="{{ $dealerReg->landmark }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <label for="mobile_no" class="col-md-2 col-form-label text-md-right">Mobile No.<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="mobile_no" name="mobile_no" class="form-control"
                                        value="{{ $dealerReg->mobile }}" disabled>
                                </div>

                                <label for="landline_no" class="col-md-2 col-form-label text-md-right">Landline No.<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="landline_no" name="landline_no" class="form-control"
                                        value="{{ $dealerReg->landline }}" disabled>
                                </div>
                            </div>
                            <div class="form-group row mt-2">
                                <label for="fax_no" class="col-md-2 col-form-label text-md-right">Fax No.<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="text" id="fax_no" name="fax_no" class="form-control"
                                        value="{{ $dealerReg->fax }}" disabled>
                                </div>
                                <label for="email_id" class="col-md-2 col-form-label text-md-right">E-Mail ID<span
                                        class="text-danger">*</span></label>
                                <div class="col-md-4">
                                    <input type="email" id="email_id" name="email_id" class="form-control"
                                        value="{{ $dealerReg->email }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row col-12">
                        <div class="col-md-4 text-left">
                            <a href="{{ route('dealers') }}" class="btn btn-warning">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('partials.js.pincode')
@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\DealerRegistrationRequest', '#Dealer') !!}
@endpush
