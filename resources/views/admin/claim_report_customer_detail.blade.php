<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
    Manage Dealer
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
                        <h4>Claim Report</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            {{-- <li class="breadcrumb-item">Manage OEM</li>
                            <li class="breadcrumb-item active">OEM Post-Registration</li> --}}
                            <li class="breadcrumb-item">Claim Report</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="row mt-3"> <!-- Added margin-top -->
                <div class="col-md-4 offset-md-8 d-flex justify-content-end">
                    <a href="{{route('claimReport.index')}}" class="btn btn-warning ml-3 px-4 py-2">Claim Report</a>
                </div>
            </div>


        </div>

        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                &nbsp;
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="table table-bordered table-striped" id="">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Customer Name</th>
                                            <th>Mobile</th>
                                            <th>Segment Name</th>
                                            <th>Model Name</th>
                                            <th>Vin Chassis No</th>
                                            <th>Incentive Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($claim as $key => $claims)
                                        <tr>
                                            <td>{{ $key +1}}</td>
                                            <td>{{$claims->custmr_name}}</td>
                                            <td>{{$claims->mobile}}</td>
                                            <td>{{$claims->segment_name}}</td>
                                            <td>{{$claims->model_name}}</td>
                                            <td>{{$claims->vin_chassis_no}}</td>
                                            <td class="text-end">{{$claims->addmi_inc_amt}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    @php
                                        $totalIncentive = $claim->sum('addmi_inc_amt');
                                    @endphp
                                    <tfoot>
                                        <tr>
                                            <td colspan="6" class="text-end"><strong>Total:</strong></td>
                                            <td class="text-end"><strong>{{ number_format($totalIncentive, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-12 d-flex justify-content-end align-items-center">
                                <div>
                                    {{ $claim->links() }}
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
@include('partials.js.prevent')
@endpush
