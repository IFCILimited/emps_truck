

@extends('layouts.dashboard_master')
@section('title', 'OTP Verification')

@section('content')
    <div class="row justify-content-center login-card  bg-img">
        <div class="col-md-4">
            <div class="card" style="margin-top: 5rem;">
                <div class="card-header"><b>OTP Verification</b> <span class="float-end"><a href="{{ route('home') }}"><b>Home</b></a></span></div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12"> <!-- Change the column width to 12 to use full width -->
                            <form action="/verifyotp" method="POST" class="theme-form">
                                @csrf

                                <div class="form-group">
                                    <label for="otp">OTP has been sent to {{ str_pad(substr(Auth::user()->mobile, -4), strlen(Auth::user()->mobile), '*', STR_PAD_LEFT) }}</label>
                                    <input type="text" id="otp" name="otp"
                                        class="form-control{{ $errors->has('otp') ? ' is-invalid' : '' }}" required>
                                    @if ($errors->has('otp'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('otp') }}</strong> <!-- Fix the error message to display correctly -->
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group mt-2 text-center">
                                    <input type="submit" value="Verify" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- <p>{{ __('If you did not receive the OTP') }},
                        <span id="resendOtpBtn" class="btn btn-primary">Get OTP</span>
                        <i id="otpBtnSpinner" style="display: none;">Please wait, OTP generation in progress...</i>
                    </p> --}}
                </div>
            </div>
        </div>
    </div>
@endsection
