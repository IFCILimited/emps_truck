   <!-- Nav Bar Ends here -->
   @extends('layouts.dashboard_master')
   @section('title')
       Admin - Generate Vahan Report
   @endsection

   @push('styles')
        <style>
            table.dataTable {
                border: 2px solid black; /* Border around the table */
                border-collapse: collapse;
            }

            table.dataTable th, 
            table.dataTable td {
                border: 1px solid black; 
                padding: 8px;
                text-align: left;
            }
            table.dataTable th{
                border-bottom: 1px solid black !important;
            }
        </style>
   @endpush
   @section('content')
       <div class="page-body">
           <div class="container-fluid">
                <div class="page-title">
                   <div class="row">
                       <div class="col-6">
                           <h4>Generate Vahan Report</h4>
                       </div>
                       <div class="col-6">
                           <ol class="breadcrumb">
                               <li class="breadcrumb-item"><a href="#">
                                       <svg class="stroke-icon">
                                           <use href="{{ asset('admin/svg/icon-sprite.svg#stroke-home') }}"></use>
                                       </svg></a></li>
                               <li class="breadcrumb-item active">Generate Vahan Report</li>
                           </ol>
                       </div>
                   </div>
               </div>
           </div>
           <div class="container-fluid">

                <div class="d-flex justify-content-center align-items-center">
                    <div class="card mt-4">
                        <div class="col-12 text-center">
                            <h2>Ministry Of Heavy Industries<br>
                            Part A of Anneure- Selected Departmental Indicators <br> for Cabinet Sec. ({{\Carbon\Carbon::parse($current_month)->format('M Y')}})</h2>
                        </div>
                        <div class="card-header">
                            <form action="{{route('e-trucks.vahanReport.View', [3])}}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="" class="form-label">Select Year</label>
                                            {{-- <input type="date" class="form-control" /> --}}
                                            {{-- <label for="year">Select Year:</label> --}}
                                            <select class="form-control" id="year" name="year">
                                                <option value="" disabled>Select Year</option>
                                                @php
                                                $currentYear = date('Y');
                                                    for ($i = $currentYear; $i >= $currentYear - 100; $i--) {
                                                        if(request('year') == $i) {
                                                            echo "<option value=\"$i\" selected>$i</option>";
                                                        }else{
                                                            echo "<option value=\"$i\">$i</option>";
                                                        }
                                                    }
                                                @endphp
                                            </select>
                                        </div>
                                    </div>    
                                    <div class="col-md-4">
                                        <label for="month" class="form-label">Select Month:</label>
                                        @php
                                            $months = [
                                                '01' => 'January',
                                                '02' => 'February',
                                                '03' => 'March',
                                                '04' => 'April',
                                                '05' => 'May',
                                                '06' => 'June',
                                                '07' => 'July',
                                                '08' => 'August',
                                                '09' => 'September',
                                                '10' => 'October',
                                                '11' => 'November',
                                                '12' => 'December',
                                            ];
                                        @endphp
                                        <select class="form-control" id="month" name="month">
                                            <option value="" disabled>Select Month</option>
                                            @foreach($months as $monthKey => $monthVal)
                                                <option value={{$monthKey}} {{request('month') == $monthKey ? 'selected' : ''}}>{{$monthVal}}</option>
                                            @endforeach
                                        </select>
                                    </div>    
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button class="btn btn-info">Filter</button>
                                    </div>    
                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            {{-- <button class="btn btn-primary" >print</button> --}}
                            <table id="export-button" class="display bordered" >
                                <thead>
                                    <tr>
                                        <th class="text-center">SL. No.</th>
                                        <th class="text-center">Indicator</th>
                                        <th class="text-center">Previous Month <br>({{\Carbon\Carbon::parse($previous_month)->format('M Y')}})</th>
                                        <th class="text-center">Current Month <br>({{\Carbon\Carbon::parse($current_month)->format('M Y')}})</th>
                                        <th class="text-center">Current Month previous FY <br>({{\Carbon\Carbon::parse($current_month_prev_year)->format('M Y')}})</th>
                                        <th class="text-center">Year to date [(Current FY)<br>({{\Carbon\Carbon::parse($prev_financial_date)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($lastDateOfMonth)->format('d/m/Y')}})]</th>
                                        <th class="text-center">Year to Date [Previous FY <br>({{\Carbon\Carbon::parse($previous_financial_starting_year_to_date)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($previous_financial_ending_year_to_date)->format('d/m/Y')}})] </th>
                                        <th class="text-center">% Change in YTD from previous FY</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $currentYTD = $results->current_date_financial_total + $results_emps->current_date_financial_total;
                                        $previousYTD = $results->current_date_previous_financial_total + $results_emps->current_date_previous_financial_total;

                                        if($previousYTD == 0) {
                                            $percentChange = 0;
                                        }else{
                                            $percentChange = ($currentYTD / $previousYTD ) * 100;
                                        }

                                        $currentVoucherYTD = $evoucher_issued->current_date_financial_evoucher_generated;
                                        $previoudVoucherYTD = $evoucher_issued->current_date_financial_previous_evoucher_generated;

                                        if($previoudVoucherYTD == 0){
                                            $percentVoucherChange = 0;
                                        }else{
                                            $percentVoucherChange = ($currentVoucherYTD / $previoudVoucherYTD) * 100;
                                        }
                                        
                                    @endphp
                                    <tr>
                                        <td>1</td>
                                        <td>Number of e-vehicles supported under PM E Drive Scheme<b>*</b></td>
                                        <td class="text-end">{{number_format($results->prev_month_total + $results_emps->prev_month_total)}}</td>
                                        <td class="text-end">{{number_format($results->current_month_total + $results_emps->current_month_total)}}</td>
                                        <td class="text-end">{{number_format($results->current_month_previous_finance_total + $results_emps->current_month_previous_finance_total)}}</td>
                                        <td class="text-end">{{number_format($currentYTD)}}</td>
                                        <td class="text-end">{{number_format($previousYTD)}}</td>
                                        <td class="text-end">{{$percentChange < 100 ?  (($percentChange == 0) ? '-' : number_format($percentChange).'%' ) : '100%'}}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Number of e-vouchers issued for incentive disbursement under PM E-Drive<b>**</b></td>
                                        <td class="text-end">{{number_format($evoucher_issued->previous_month_evoucher_generated)}}</td>
                                        <td class="text-end">{{number_format($evoucher_issued->current_month_evoucher_generated)}}</td>
                                        <td class="text-end">{{number_format($evoucher_issued->current_month_prev_year_evoucher_generated)}}</td>
                                        <td class="text-end">{{number_format($currentVoucherYTD)}}</td>
                                        <td class="text-end">{{number_format($previoudVoucherYTD)}}</td>
                                        <td class="text-end">{{$percentVoucherChange < 100 ? (($percentVoucherChange == 0) ? '-' :  number_format($percentVoucherChange).'%' ): '100%'}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <th colspan="7">* The numbers are dynamic and may change since registration of EVs takes 3-4 weeks to confirm.</th>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <th colspan="7">** The numbers are dynamic and may change since OEMs have 120 days to file claims.</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{-- <div class="row">
                                <div class="col-md-3">
                                    <label for="segment">Select Segment</label>
                                    <select class="form-control" id="segment" name="segment">
                                        <option value="">Select Segment</option>
                                        <option value="all">All</option>
                                        <option value="1">e-2W</option>
                                        <option value="2">e-3W</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="segment">From:</label>
                                            <input class="form-control" type="date" name="from_date" placeholder="YYYY-MM-DD" onchange="addValidationIndate(this, 'min','to_date')"/>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="segment">To:</label>
                                            <input class="form-control" type="date" name="to_date" placeholder="YYYY-MM-DD" onchange="addValidationIndate(this, 'max','from_date')"/>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-3 mt-2 d-flex align-items-center">
                                    <button type="submit" class="btn btn-success w-100">Download</button>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
           </div>


       </div>
   @endsection
   @push('scripts')
   <script>

// function printSection() {
//     var content = document.getElementById("table-data").innerHTML;
//     var printWindow = window.open('', '', 'height=800,width=800');
//     printWindow.document.write('<html><head><title>Print</title>');
//     printWindow.document.write('<style>body { font-family: Arial, sans-serif; }</style>'); // Optional styling
//     printWindow.document.write('</head><body>');
//     printWindow.document.write(content);
//     printWindow.document.write('</body></html>');
//     printWindow.document.close();
//     printWindow.print();
// }

    function addValidationIndate(elem, atr, target)
    {
        $(`input[name=${target}]`).attr(atr, elem.value);
    }

   </script>
   @endpush
