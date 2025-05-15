@extends('layouts.e_truck_dashboard_master')
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
            <form action="{{ route('e-trucks.checkEligibility.store') }}" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                id="check_eligibility" accept-charset="utf-8">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <span>
                                                Note: The <b>"Check Eligibility"</b> tab is only for </span><span
                                                class="text-danger"><b>individual customers.</b></span>

                                            <div class="row mb-4 mt-4">

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="input1">Aadhar Number</label>
                                                        <input type="text" id="input1" class="form-control"
                                                            name="aadhar_no" placeholder="Enter Aadhar">
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="input2">Mobile Number</label>
                                                        <input type="text" id="input2" class="form-control"
                                                            name="mobile_no" placeholder="Enter Mobile">
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for="segmentSelect">Segment</label>
                                                        <select id="segmentSelect" name="segment_id" class="form-control">
                                                            <option disabled selected>Select a segment</option>
                                                            @foreach ($segmentCheck as $id => $segment)
                                                                <option value="{{ $segment->id }}">
                                                                    {{ $segment->segment_name }}</option>
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


            </form>
            <form action="{{ route('e-trucks.cdcheck') }}" role="form" method="post"
                class='form-horizontal prevent-multiple-submit' files=true enctype='multipart/form-data'
                id="check_eligibility" accept-charset="utf-8">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <span>
                                                Note: The <b>"CD Eligibility"</b> tab is only for </span><span
                                                class="text-danger"><b>individual customers.</b></span>

                                            <div class="row mb-4 mt-4" id="cd-inputs-wrapper">
                                                <div class="col-sm-4 cd-entry">
                                                    <div class="form-group">
                                                        <label>CD Number</label>
                                                        <input type="text" class="form-control" name="data[1][cdnumber]"
                                                            placeholder="Enter CD Number">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="text-center mb-2" id="cd-buttons">
                                            <button type="button" id="addCdBtn" class="btn btn-success">Add +</button>
                                            <button type="submit" class="btn btn-primary">Check</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </form>
            {{-- @if (isset($results))
            {{dd($results)}}
            @endif --}}

            <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="dt-ext table-responsive custom-scrollbar">
                            @if (isset($results) && count($results) > 0)
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>CD Number</th>
                                            <th>Present Owner</th>
                                            <th>Vehicle GVW</th>
                                            <th>Scrapped VIN</th>
                                            <th>Status Flag</th>
                                            <th>Issue Date</th>
                                            <th>Valid Upto</th>
                                            <th>New Owner</th>
                                            <th>New Reg No</th>
                                            <th>New Reg Date</th>
                                            <th>New VIN</th>
                                            <th>Response Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $key => $item)
                                            @php $r = $item['response']; @endphp
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item['cdnumber'] }}</td>
                                                <td>{{ $r['present_owner_name'] }}</td>
                                                <td>{{ $r['vehicle_gvw'] }}</td>
                                                <td>{{ $r['scrapped_vin'] }}</td>
                                                <td>{{ $r['status_flag'] }}</td>
                                                <td>{{ $r['issue_date'] }}</td>
                                                <td>{{ $r['valid_upto_date'] }}</td>
                                                <td>{{ $r['new_owner_name'] ?? '-' }}</td>
                                                <td>{{ $r['new_registration_no'] ?? '-' }}</td>
                                                <td>{{ $r['new_registration_date'] ?? '-' }}</td>
                                                <td>{{ $r['new_vin'] ?? '-' }}</td>
                                                <td>{{ $r['response_message'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No results found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


</div>
        </div>
    </div>
@endsection

@push('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\CheckEligibilityRequest', '#check_eligibility') !!}


    <script>
        $(document).ready(function() {
            var i = 1;
            // Handle Add button
            $('#addCdBtn').click(function() {
                i++;
                const newInput = `
                <div class="col-sm-4 cd-entry mb-2">
                    <div class="form-group">
                        <label>CD Number</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="data[${i}][cdnumber]" placeholder="Enter CD Number">
                            <div class="input-group-append">
                                <button type="button" style="margin-left: 4px;margin-top: 3px;" class="btn btn-sm btn-danger removeCdBtn">&times;</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                $('#cd-inputs-wrapper').append(newInput);
            });

            // Handle Remove button using event delegation
            $('#cd-inputs-wrapper').on('click', '.removeCdBtn', function() {
                $(this).closest('.cd-entry').remove();
            });
        });
    </script>
@endpush
