<!-- Nav Bar Ends here -->
@extends('layouts.dashboard_master')
@section('title')
   OEM Sales Report
@endsection

@push('styles')
@endpush
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>OEM Sales Report</h4>
                    </div>
                    {{-- <div class="col-3 d-flex justify-content-end">
                        <a href="{{ route('downloadFile.productiondata') }}" class="btn btn-success"><i
                                class="fa fa-cloud-download"></i> Format for Sales Data.</a>
                    </div> --}}
			{{-- <div class="col-3 justify-content-end">
                        <a href="{{ asset('files/SalesData.xlsx') }}" class="btn btn-success"><i
                                class="fa fa-cloud-download"></i> Format for Sales Data.</a>
                    </div> --}}

                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <table class="display table-bordered table-striped" id="export-button">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">Sales Reported by the OEMs </th>
                                            {{-- <th colspan="3" class="text-center">Consolidated Sales till Previous Day ({{$prev_date}})</th> --}}
                                            <th colspan="3" class="text-center">Consolidated Sales till Current Day ({{$curr_date}})</th>
                                            {{-- <th colspan="3" class="text-center">Variation in Sales</th> --}}
                                            {{-- <th rowspan="2" class="text-center">Action</th> --}}
                                            <th>Last Updated Date</th>
                                        </tr>
                                        <tr>
                                            <!-- Previous Day Columns -->
                                            {{-- <th class="text-center">e-2W (L1+L2)</th>
                                            <th class="text-center">e-3W (e-Rick & e-Cart)</th>
                                            <th class="text-center">e-3W (L5)</th>
                                 --}}
                                            <!-- Current Day Columns -->
                                            <th class="text-center">e-2W (L1+L2)</th>
                                            <th class="text-center">e-3W (e-Rick & e-Cart)</th>
                                            <th class="text-center">e-3W (L5)</th>
                                            <th></th>
                                
                                            <!-- Variation in Sales Columns -->
                                            {{-- <th class="text-center">e-2W (L1+L2)</th>
                                            <th class="text-center">e-3W (e-Rick & e-Cart)</th>
                                            <th class="text-center">e-3W (L5)</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $totals = [
                                            'e2w_l1_l2_prev_day' => 0,
                                            'e3w_erick_cart_prev_day' => 0,
                                            'e3w_l5_prev_day' => 0,
                                            'e2w_l1_l2_curr_day' => 0,
                                            'e3w_erick_cart_curr_day' => 0,
                                            'e3w_l5_curr_day' => 0,
                                            'e2w_l1_l2_variation' => 0,
                                            'e3w_erick_cart_variation' => 0,
                                            'e3w_l5_variation' => 0,
                                        ];
                                        @endphp
                                        @foreach($oemSalesData as $oem)
                                        <tr>
                                            <td>{{ $oem->oem_name }}</td>
                                            
                                            <!-- Consolidated Sales till Previous Day Data -->
                                            {{-- <td>{{ $oem->e2w_l1_l2_prev_day }}</td>
                                            <td>{{ $oem->e3w_erick_cart_prev_day }}</td>
                                            <td>{{ $oem->e3w_l5_prev_day }}</td> --}}
                                            
                                            <!-- Consolidated Sales till Current Day Data -->
                                            <td>{{ $oem->e2w_l1_l2_curr_day }}</td>
                                            <td>{{ $oem->e3w_erick_cart_curr_day }}</td>
                                            <td>{{ $oem->e3w_l5_curr_day }}</td>
                                            <td>{{  date('d-m-Y', strtotime($oem->latest_created_at)) }}</td>
                                
                                            <!-- Variation in Sales Data -->
                                            {{-- <td>{{ $oem->e2w_l1_l2_variation }}</td>
                                            <td>{{ $oem->e3w_erick_cart_variation }}</td>
                                            <td>{{ $oem->e3w_l5_variation }}</td> --}}
                                        </tr>
                                        
                                        @php 
                                            // $totals['e2w_l1_l2_prev_day'] += $oem->e2w_l1_l2_prev_day;
                                            // $totals['e3w_erick_cart_prev_day'] += $oem->e3w_erick_cart_prev_day;
                                            // $totals['e3w_l5_prev_day'] += $oem->e3w_l5_prev_day;

                                            $totals['e2w_l1_l2_curr_day'] += $oem->e2w_l1_l2_curr_day;
                                            $totals['e3w_erick_cart_curr_day'] += $oem->e3w_erick_cart_curr_day;
                                            $totals['e3w_l5_curr_day'] += $oem->e3w_l5_curr_day;

                                            // $totals['e2w_l1_l2_variation'] += $oem->e2w_l1_l2_variation;
                                            // $totals['e3w_erick_cart_variation'] += $oem->e3w_erick_cart_variation;
                                            // $totals['e3w_l5_variation'] += $oem->e3w_l5_variation;
                                        @endphp
                                        @endforeach
                                        <tfoot>
                                        <!-- Totals Row -->
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            
                                            <!-- Totals for Previous Day -->
                                            {{-- <td><strong>{{ $totals['e2w_l1_l2_prev_day'] }}</strong></td>
                                            <td><strong>{{ $totals['e3w_erick_cart_prev_day'] }}</strong></td>
                                            <td><strong>{{ $totals['e3w_l5_prev_day'] }}</strong></td> --}}
                                
                                            <!-- Totals for Current Day -->
                                            <td><strong>{{ $totals['e2w_l1_l2_curr_day'] }}</strong></td>
                                            <td><strong>{{ $totals['e3w_erick_cart_curr_day'] }}</strong></td>
                                            <td><strong>{{ $totals['e3w_l5_curr_day'] }}</strong></td>
                                            <td></td>
                                            <!-- Totals for Variation -->
                                            {{-- <td><strong>{{ $totals['e2w_l1_l2_variation'] }}</strong></td>
                                            <td><strong>{{ $totals['e3w_erick_cart_variation'] }}</strong></td>
                                            <td><strong>{{ $totals['e3w_l5_variation'] }}</strong></td> --}}
                                        </tr>
                                    </tfoot>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
           $('.prevent-multiple-submit').on('submit', function() {
               $(this).find('button[type="submit"]').prop('disabled', true);
               var buttons = $(this).find('button[type="submit"]');
               setTimeout(function() {
                   buttons.prop('disabled', false);
               }, 20000); // 25 seconds in milliseconds
           });
       });
    </script>
@endsection
