@extends('layouts.dashboard_master')
@section('title')
    Dealer- Buyer Information
@endsection

@push('styles')
    <style>
        .error-help-block {
            color: red;
        }

        .disabled {
            cursor: not-allowed;
            opacity: 0.5;
            /* Optional: Change appearance of disabled anchor */
        }

        @media print {
            title {
                display: none;
            }

            .print-content {
                page-break-after: always;
            }
        }
    </style>
@endpush

@section('content')
    @php
        use Carbon\Carbon;
        $time = Carbon::now()->format('d-m-Y h:m:s');
    @endphp
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <div class="container-fluid" id="container">
            <div class="page-title">
                <div class="row">
                    <div class="col-8">
                        <h4 class="mb-2">Buyer Detail</h4>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary" onclick="printContent('{{ $time }}')">Print</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid" id="tab">

            <div class="card print-content">

                <div class="card-header">
                    <h4 class="text-center">Customer Acknowledgement Form {{ env('APP_NAME')}}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p class="p-7 pb-3">A. We hereby undertake that, I/We have purchased xEV vehicle(s)
                                (details of which are given below) under the {{ env('APP_NAME')}} and have received the incentive amount as per the scheme.</p>

                        </div>

                        {{-- <div class="row"> --}}

                        <div class="col-6 ">
                            <h6><b>Name of Manufacturer:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $oemname->name }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Vehicle Model: </b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $detail->model_name }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Model Variant: </b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $detail->variant_name }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Vehicle Segment:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $detail->segment }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Dealer Name:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $user->name }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Dealer Invoice Number:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $buyer->dlr_invoice_no }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Dealer Invoice Date:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $buyer->invoice_dt }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Number of Vehicle Purchased:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>1</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Invoice Amt (INR).(Per Vehicle):</b></h6>
                        </div>
                        <div class="col-6 pb-2 mr-3">
                            <h6>{{ $buyer->invoice_amt }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Admissible Incentive Amt. (INR) (Per Vehicle):</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $buyer->addmi_inc_amt }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Total Invoice Amt. (INR):</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $buyer->tot_inv_amt }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Total Admissible Incentive Amt. (INR):</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $buyer->tot_admi_inc_amt }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Amount Payable by Customer (INR):</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            {{-- <h6>{{ $buyer->tot_inv_amt}}</h6>
                            <h6>Invoice Amt {{ $buyer->invoice_amt}}</h6>
                            <h6> Admissible Incentive {{ $buyer->addmi_inc_amt}}</h6>
                            <h6> Invoice Amt -Admissible Incentive  {{ $buyer->invoice_amt -$buyer->addmi_inc_amt}}</h6> --}}
                            <h6> {{ $buyer->invoice_amt -$buyer->addmi_inc_amt}}</h6>
                        </div>
                        <div class="col-12 pb-3">
                            <h6><b>I/We also confirm that logo sticker of {{ env('APP_NAME')}} is available on the purchased
                                    Vehicle.</b></h6>
                        </div>

                        <div class="col-6 pb-2">
                            <h6><b>Customer Type/Category :</b></h6>
                        </div>
                        <div class="col-6">
                            <h6>

                                @if ($buyer->custmr_typ == 1)
                                    Individual Cases
                                @elseif ($buyer->custmr_typ == 2)
                                    Proprietory Firms/Agencies
                                @elseif ($buyer->custmr_typ == 3)
                                    Corporate And Partnership Agencies
                                {{-- @elseif ($buyer->custmr_typ == 4)
                                    Gov. Department/Defence Supply --}}
                                @endif


                            </h6>
                        </div>

                        <div class="col-6 pb-2">
                            <h6><b>Customer Name :</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $buyer->custmr_name }}</h6>
                        </div>

                        <div class="col-6 pb-2">
                            <h6><b>Customer Address :</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $buyer->add }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Customer Mobile No :</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $buyer->mobile }}</h6>
                        </div>
                        @if($buyer->custmr_typ == 1)
                            <div class="col-6 pb-2">
                                <h6><b>Customer Email Id :</b></h6>
                            </div>
                        
                            <div class="col-6 pb-2">
                                <h6>{{ $buyer->email }}</h6>
                            </div>
                        @endif
                        {{-- <div class="col-6 pb-2">
                            <h6><b>Customer Address/ID Proof:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $type->name }}</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>Customer ID No:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $buyer->custmr_id_no }}</h6>
                        </div> --}}
                        @if ($buyer->custmr_typ != 1)
                            
                        <div class="col-6 pb-2">
                            <h6><b>PAN:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>@if($sectype->name == "PAN Card") {{ strtoupper($buyer->cust_id_sec) }} @endif</h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6><b>GSTIN No.:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>@if($sectype->name == "GST Certificate") {{ strtoupper($buyer->cust_id_sec) }} @endif</h6>
                        </div>
                            
                        @endif
                        <div class="col-6 pb-2">
                            <h6><b>Customer Address/ID Proof:</b></h6>
                        </div>
                        <div class="col-6 pb-2">
                            <h6>{{ $sectype->name }}</h6>
                        </div>

                        {{-- </div> --}}

                    </div>


                    <hr />



                    <hr />
                    <h6>Vehicle Information </h6>
                    <div class="row mt-1">
                        <div class="col-12">
                            <div class="dt-ext table-responsive  custom-scrollbar">
                                <table class="display table-bordered table-striped" id="basic-9">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Model Name</th>
                                            <th>Model Code </th>
                                            <th>Model Colour </th>
                                            <th>VIN Chassis No </th>
                                            <th>Emission Norms </th>
                                            <th>Motor Identification Number </th>
                                            <th> Vehicle Manufacturing Date </th>
                                            <th> Battery Make </th>
                                            <th> Battery Number </th>
                                            <th> Battery Capacity
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>1</td>
                                            <td>{{ $maindata->model_name }}</td>
                                            <td>{{ $maindata->model_code }}</td>
                                            <td>{{ $maindata->colour }}</td>
                                            <td>{{ $maindata->vin_chassis_no }}</td>
                                            <td>{{ $maindata->emission_norms }}</td>
                                            <td>{{ $maindata->motor_number }}</td>
                                            <td>{{ $maindata->manufacturing_date }}</td>
                                            <td>{{ $maindata->battery_make }}</td>
                                            <td>{{ $maindata->battery_number }}<br>
                                                {{ $maindata->battery_number2 }}<br>
                                                {{ $maindata->battery_number3 }}<br>
                                                {{ $maindata->battery_number4 }}<br>
                                                {{ $maindata->battery_number5 }}<br>
                                                {{ $maindata->battery_number6 }}<br>
                                                {{ $maindata->battery_number7 }}<br>
                                                {{ $maindata->battery_number8 }}<br>
                                                {{ $maindata->battery_number9 }}<br>
                                                {{ $maindata->battery_number10 }}<br>
                                            </td>
                                            <td>{{ $maindata->battery_capacity }}</td>
                                            {{-- <td>{{$maindata->model_name}}</td> --}}
                                            
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="offset-9 col-3 mt-3">
                            <h6>(Signature of Customer)</h6>
                            <p>{{ $buyer->custmr_name }}</p>
                        </div>
                        <div class="col-12 mt-1">
                            <h6>B. Dealer Verification for {{ env('APP_NAME')}}:
                            </h6>
                            <p>I/We {{ $user->name }} the authorized dealer of {{ $oemname->name }} do verify the sale of above
                                said vehicle to the above named purchaser. We also confirm that the benefit of {{ $buyer->tot_admi_inc_amt }}
                                only on account of {{ env('APP_NAME')}} Incentive has actually been given to the
                                purchaser in the form of reduced purchase price. We have also verified the ID and Address
                                proof of the purchaser and confirm to be correct.</p>
                        </div>
                        <div class="col-3 mt-1">
                            <h6>{{ $time }}</h6>
                            <p>Place: </p>
                        </div>
                        <div class="offset-6 col-3 mt-1">
                            <h6>(Signatures of Authorized Signatory) </h6>
                            <p> </p>
                        </div>
                        <div class="offset-9 col-3 mt-1">
                            <h6>Name & Designation</h6>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row" id="backBtn">
            <div class="col-4">
                <a href="{{ route('buyerdetail.index') }}" class="btn btn-warning form-control-sm mt-2" type=""
                    id="">Back</a>
            </div>

        </div>
    </div>


    <!-- Container-fluid Ends-->
    </div>
@endsection
@push('scripts')
    <script>
        function printContent(time) {
            var div1 = document.getElementById('tab');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write(
                '<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/bootstrap.css') }}">');
            newWin.document.write('<style>');
            newWin.document.write('body { font-size: 5%; }'); // Adjust the font size as needed
            newWin.document.write('</style>');
            newWin.document.write('</head><body onload="window.print()">');
            newWin.document.write(div1.innerHTML);
            newWin.document.close();
        };
    </script>
@endpush
