@extends('layouts.dashboard_master')
@section('title')
    Admin - Claim To MHI
@endsection

@push('styles')
@endpush
@section('content')
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Claim Generate</h4>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <form action="{{ route('claimToMhi.show') }}" id="proceedGeneration" role="form" method="post" class='form-horizontal'
                    files=true enctype='multipart/form-data' accept-charset="utf-8">
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <span class="text-muted">Please select the month for which you want to submit the claim.</span>
                                </div>
                                <div class="col-md-2 d-flex justify-content-center">
                                    <select name="month" id="month" class="form-control form-control-sm" required>
                                        <option disabled selected>Select Month</option>
                                        @foreach(range(4, 9) as $month)
                                            <option value="{{ $month }}">{{ date("F", mktime(0, 0, 0, $month, 1)) }} - 2024</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="dt-ext table-responsive custom-scrollbar">
                                    <table class="display table-bordered table-striped" id="export-button">
                                        <thead>
                                            <tr>
                                                <th scope="col"><input id="checkAll" type="checkbox" name=""/></th>
                                                <th scope="col">S.No.</th>
                                                <th scope="col">Claim Number</th>
                                                <th scope="col">No of Vehicle </th>
                                                <th scope="col">Total Incentive Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($claimMaster)>0)
                                                @foreach($claimMaster as $claim)
                                                    <tr>
                                                        @php
                                                            $sn = $loop->iteration;
                                                        @endphp
                                                        <td scope="row">
                                                            <input type="checkbox" name="check[{{$sn}}]" claimid="{{($claim->claim_id)}}" class="btnShowClass" value="{{($claim->claim_id)}}"/>
                                                        </td>
                                                        <td>{{$sn}}</td>
                                                        <td>{{$claim->claimnumberformat}}</td>
                                                        <td>{{$claim->vehicle_count}}</td>
                                                        <td>{{$claim->tot_incamt}}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <td colspan="19" class="text-center">No Data Available</td>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row py-2">
                        <div class="col-md-2 offset-md-5">
                            <button type="submit" id="generateClaim" class="btn btn-primary btn-sm form-control form-control-sm"><i
                                    class="fa fa-save"></i> Save as Draft</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
{!! JsValidator::formRequest('App\Http\Requests\ClaimToMhiRequest', '#proceedGeneration') !!}
    <script>
        $(document).ready(function() {
            $('#checkAll').click(function(e) {
                var isChecked = $('input[type=checkbox]').not(this).is(':checked');
                $('input[type=checkbox]').prop('checked', !isChecked);
            });

            $('#generateClaim').click(function(e) {
                e.preventDefault();
                var claimIds = [];
                $('input[type=checkbox].btnShowClass:checked').each(function() {
                    var claimId = $(this).attr('claimid');
                    claimIds.push(claimId);
                });
                var selectedMonth = $('#month').val();
                if (claimIds.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Please select Claim to proceed',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                } else if (!selectedMonth) {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Please select a Month to proceed',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                } else {
                    $('#proceedGeneration').submit();
                }
            });
        });
    </script>
@endpush
