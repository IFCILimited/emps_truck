@extends('layouts.home_layout')
@section('title', 'Verify Your Mobile Number')

@section('content')
    <div class="row justify-content-center login-card  bg-img ">
        <div class="col-md-4">
            <div class="card" style="margin-top: 5rem;">
                <div class="card-header"><b>Verify Your Mobile Number</b> <span class="float-end"><a href="{{ route('home') }}"><b>Home</b></a></span></div>

                <div class="card-body">
                    <form action="/verifymobile" method="POST">
                        @csrf
                    <div class="row col-12">
                        <div class="col-md-8">

                                <div class="form-group">
                                    <input type="text" id="otp" name="otp" placeholder="Enter Mobile OTP"
                                        class="form-control{{ $errors->has('otp') ? ' is-invalid' : '' }}" required>
                                    @if ($errors->has('otp'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('otp') }}</strong>
                                    </span>
                                    @endif
                                </div>

                        </div>
                        <div class="col-md-2">
                            <!-- Column for "Verify" button -->
                            <button type="submit" class="btn btn-primary">Verify</button>
                        </div>
                    </div>
                </form>
                    <div class="mt-4">
                    {{ __('If you did not receive the OTP') }},
                    <form class="d-inline" method="POST" action="#">
                        @csrf
                        <button type="submit"
                            class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

