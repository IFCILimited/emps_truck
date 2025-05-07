@extends('layouts.dashboard_master')
@section('title')
    Admin - OEM MOdel
@endsection
@push('styles')
    <style>
        .error-help-block {
            color: red;
        }
    </style>
@endpush
@section('content')
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4 class="mb-2">Check Eligibility</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid mt-4">
            <form action="{{ route('checkEligibility.store') }}" role="form" method="post" class='form-horizontal prevent-multiple-submit' files=true
                enctype='multipart/form-data' id="check_eligibility" accept-charset="utf-8">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row mb-4">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="input1">Aadhar Number</label>
                                                        <input type="text" id="input1" class="form-control" name="aadhar_no" placeholder="Enter Aadhar">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="input2">Mobile Number</label>
                                                        <input type="text" id="input2" class="form-control" name="mobile_no" placeholder="Enter Mobile">
                                                    </div>
                                                </div>

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="segmentSelect">Segment</label>
                                                    <select id="segmentSelect" name="segment_id" class="form-control">
                                                        <option disabled selected>Select a segment</option>
                                                        @foreach ($segmentCheck as $id => $segment)

                                                            <option value="{{ $segment->id }}">{{ $segment->segment_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                            {{-- <div class="text-center">
                                                <button id="checkButton" class="btn btn-primary">Check</button>
                                            </div> --}}

                                            <div class="text-center mb-2">
                                                <button type="submit" class="btn btn-primary"></i> Check</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    </div>
@endsection

@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\CheckEligibilityRequest', '#check_eligibility') !!}
@endpush

