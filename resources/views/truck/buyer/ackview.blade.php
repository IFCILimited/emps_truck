@extends('layouts.e_truck_dashboard_master')
@section('title')
    Dealer- Buyer Information
@endsection

@push('styles')
    <style>
        /* body {
                font-family: Arial, sans-serif;
            } */

        .container {
            width: 100%;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
            background: #fff
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .section-title {
            font-weight: bold;
            margin-top: 30px;
            text-decoration: underline;
        }
    </style>
@endpush

@section('content')
    @php
        use Carbon\Carbon;
        $time = Carbon::now()->format('d-m-Y h:m:s');
    @endphp
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

        <div class="container" id="tab">
            <br>
            <br>
            <br>
            <br>
            <h3>Annexure-VI</h3>

            <h3 style="font-size: 15px; margin-top:20px" class="text-center"><b>Customer Acknowledgement Form & Dealer Verification Form</b></h3>

            <div class="section">
              <h1>  <p class="section-title text-justify">(A)- Customer Acknowledgement</p></h1>
                <p>
                    I/We hereby undertake that I/my organization as given below have purchased
                    <u>{{ $maindata->vin_chassis_no }}</u> no. of vehicle (only one for individual) details of which are
                    given below under
                    PM Electric Drive Revolution in Innovative Vehicle Enhancement (PM E-DRIVE)
                    Scheme of Government of India and the benefit of admissible incentive amount
                    has/have been received, by way of upfront reduction in the cost of vehicles as reflected
                    in the dealer's invoice.
                </p>
            </div>

            <div class="section">
                <h3 style="font-size: 15px; margin-top:20px; font-weight: bold;" class="section-title">2. Information about the Vehicles:</h3>
                <table>
                    <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Particular</th>
                            <th>Provide Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Name of the Manufacturer</td>
                            <td>{{ $oemname->name }}</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Dealer Name*</td>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Vehicle Model*</td>
                            <td>{{ $detail->model_name }}</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Model Variant*</td>
                            <td>{{ $detail->variant_name }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Chassis No.*</td>
                            <td>{{ $maindata->vin_chassis_no }}</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Gross Vehicle Weight (GVW In Tons)*</td>
                            <td>{{ $maindata->gross_weight }}</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Dealer Invoice No.*</td>
                            <td>{{ $buyer->dlr_invoice_no }}</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Dealer Invoice Amount*</td>
                            <td>{{ $buyer->invoice_amt }}</td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Incentive Amount adjusted in purchase</td>
                            <td>{{ $buyer->addmi_inc_amt }}</td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Total Number of Vehicles Purchased</td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Vehicle Unique Identification Number</td>
                            <td>
                                 {{ $maindata->vin_chassis_no }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="section">
                <h3 style="font-size: 15px; margin-top:20px;  font-weight: bold;" class="section-title">3. Information about Customer</h3>
                <table>
                    <tr>
                        <td>Customer Name*</td>
                        <td>{{ $buyer->custmr_name }}</td>
                        {{-- <td>@if ($buyer->custmr_typ == '1'){{$buyer->custmr_name}} @else {{$multibuyer->custmr_name}} @endif</td> --}}
                    </tr>
                    <tr>
                        <td>Customer Address*</td>
                        {{-- <td>{{ $buyer->add }}</td> --}}
                      <td>  @if ($buyer->custmr_typ == '1'){{ $buyer->add }} @else {{ $multibuyer->cmpny_addr .', '. $multibuyer->cmpny_land .', '. $multibuyer->cmpny_city .', '. $multibuyer->cmpny_dist .', '. $multibuyer->cmpny_state .', '. $multibuyer->cmpny_pin}} @endif </td>
                    </tr>
                    <tr>
                        <td>Customer ID Proof i.e. PAN Card or Purchase Order</td>
                        <td>{{ $buyer->cust_id_sec }}</td>
                    </tr>
                    <tr>
                        <td>Customer Address Proof</td>
                        <td>{{ $sectype->name }}</td>
                    </tr>
                    <tr>
                        <td>Customer Email ID*</td>
                        <td>{{ $buyer->email }}</td>
                    </tr>
                    <tr>
                        <td>Customer Mobile Number</td>
                        <td>{{ $buyer->mobile }}</td>
                    </tr>
                    <tr>
                        <td>Date of Purchase of EV earlier by the Customer, if any</td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>Whether single purchase or bulk purchase</td>
                        <td>
                            {{$buyer->custmr_typ == '1'? 'Individual':'Bulk'}}
                        </td>
                    </tr>
                    <tr>
                        <td>Indicate purpose, in case of bulk purchase</td>
                        <td>
                            {{$buyer->custmr_typ == '1'? '-':'Commercial'}}
                        </td>
                    </tr>
                </table>
                <br>
                <h3 style="font-size: 15px; margin-top:20px; font-weight: bold;"> 4. I/We hereby certify that the mobile number given above is functional and is in my name/in the name of
                    my family member</h3>
            </div>

            <div>
               <h1> <p class="section-title">(B) Dealer Verification:</p> </h1>
                <p class="text-justify">
                      We <u>{{ $user->name }}</u> (dealer's name), the Authorized dealer of <u>{{ $oemname->name }}</u>
                    (Manufacturer Name) do
                    verify the sale of above said Vehicle to the above-named customer/buyer.
                </p>
                <br>
                <p class="text-justify">
                    2. We also confirm that the benefit of INR <u>{{ $buyer->addmi_inc_amt }}</u> (Rupees only) on account
                    of
                    PM E-DRIVE scheme for <u>{{ $maindata->vin_chassis_no }}</u> number of vehicles has actually been given
                    to the customer in the
                    form of a reduced purchase price.
                </p>
                <br>
                <p>We have also verified the ID, address proof, and mobile number of the customer and the same are confirmed
                    to be correct.</p>
                <br><br>
                <div class="row">
                    <div class="col-6">
                        <p>Date: {{substr($time, 0, 10)}}</p>
                        <p>Place: ____________</p>
                    </div>
                    <div class="col-6 sign">
                        <p>(Signature of Authorized Signatory)</p>
                        <p>Name & Designation</p>
                        <p>Dealer Name & Mobile No.</p>
                    </div>
                </div>

                <br><br>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- <script>
        function printContent(time) {
            var div1 = document.getElementById('tab');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write(
                '<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/bootstrap.css') }}">');
            newWin.document.write('<style>');
            newWin.document.write('body { font-size: 20%; margin: 100px; }');
            newWin.document.write('.sign { text-align: right; }');
            newWin.document.write('p { font-size: 16px; font-weight: bold; margin-top: 20px; }');

            newWin.document.write('table { border-collapse: collapse; }');
            newWin.document.write('tr, th, td { border: 1px solid black; }');
            newWin.document.write('</style>');
            newWin.document.write('</head><body onload="window.print()">');
            newWin.document.write(div1.innerHTML);
            newWin.document.close();
        };
    </script> --}}

    {{-- <script>
        function printContent(time) {
            var div1 = document.getElementById('tab');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write(
                '<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/bootstrap.css') }}">');
            newWin.document.write('<style>');
            newWin.document.write('body { font-size: 20%; margin: 100px; position: relative; text-align: justify;}');
            newWin.document.write('.sign { text-align: right; }');
            newWin.document.write('p { font-size: 16px; margin-top: 20px; }');
            newWin.document.write('table { border-collapse: collapse; }');
            newWin.document.write('tr, th, td { border: 1px solid black; }');

            newWin.document.write('.datetime { position: absolute; top: 10px; right: 10px; font-size: 14px; font-style: italic; }');
            newWin.document.write('</style>');
            newWin.document.write('</head><body onload="window.print()">');

            var currentDate = new Date();

            var day = ("0" + currentDate.getDate()).slice(-2);
            var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
            var year = currentDate.getFullYear();

            var hours = ("0" + currentDate.getHours()).slice(-2);
            var minutes = ("0" + currentDate.getMinutes()).slice(-2);
            var seconds = ("0" + currentDate.getSeconds()).slice(-2);


            var formattedDateTime = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes + ':' + seconds;


            newWin.document.write('<div class="datetime">' + formattedDateTime + '</div>');

            newWin.document.write(div1.innerHTML);

            newWin.document.close();
        }
    </script> --}}


    {{-- <script>
        function printContent(time) {
            var div1 = document.getElementById('tab');
            var newWin = window.open('', 'Print-Window');
            newWin.document.open();
            newWin.document.write(
                '<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/bootstrap.css') }}">');
            newWin.document.write('<style>');
            newWin.document.write('body { font-size: 20%; margin: 100px 50px; position: relative; text-align: justify;}'); // Add left/right margin
            newWin.document.write('.sign { text-align: right; }');
            newWin.document.write('p { font-size: 16px; margin-top: 20px; }');
            newWin.document.write('table { border-collapse: collapse; }');
            newWin.document.write('tr, th, td { border: 1px solid black; }');
            newWin.document.write('.datetime { position: absolute; top: 10px; right: 10px; font-size: 14px; font-style: italic; }');
            newWin.document.write('</style>');
            newWin.document.write('</head><body onload="window.print()">');

            var currentDate = new Date();

            var day = ("0" + currentDate.getDate()).slice(-2);
            var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
            var year = currentDate.getFullYear();

            var hours = ("0" + currentDate.getHours()).slice(-2);
            var minutes = ("0" + currentDate.getMinutes()).slice(-2);
            var seconds = ("0" + currentDate.getSeconds()).slice(-2);

            var formattedDateTime = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes + ':' + seconds;

            newWin.document.write('<div class="datetime">' + formattedDateTime + '</div>');

            newWin.document.write(div1.innerHTML);

            newWin.document.close();
        }
    </script> --}}

    {{-- <script>
        function printContent(time) {
    var div1 = document.getElementById('tab');
    var newWin = window.open('', 'Print-Window');
    newWin.document.open();
    newWin.document.write(
        '<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/bootstrap.css') }}">');
    newWin.document.write('<style>');

    // General styling for the printed content
    newWin.document.write('body { font-size: 20%; margin: 0px; position: relative; text-align: justify;}'); // Remove body margin
    newWin.document.write('.sign { text-align: right; }');
    newWin.document.write('p { font-size: 16px; margin-top: 20px; }');

    // Table styles to ensure it's fully visible and doesn't overflow
    newWin.document.write('table { border-collapse: collapse; width: 100%; table-layout: auto; }'); // Auto table layout ensures full width
    newWin.document.write('th, td { padding: 10px; border: 1px solid black; word-wrap: break-word; text-align: left; }'); // Added padding and word wrap
    newWin.document.write('.datetime { position: absolute; top: 10px; right: 10px; font-size: 14px; font-style: italic; }');

    // Fix for top margin and container width
    newWin.document.write('@page { margin-top: 40px; margin-left: 40px; margin-right: 40px; margin-bottom: 40px;}'); // 20px margin for top and sides

    // Fix for horizontal table overflow: Adding left and right margins to container
    newWin.document.write('.container { margin-left: 20px; margin-right: 20px; }'); // Add horizontal margin to prevent overflow

    // Prevent page overflow when the content is too large
    newWin.document.write('@media print { table { page-break-inside: auto; } }'); // Ensure tables don't break across pages

    newWin.document.write('</style>');
    newWin.document.write('</head><body onload="window.print()">');

    var currentDate = new Date();

    var day = ("0" + currentDate.getDate()).slice(-2);
    var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
    var year = currentDate.getFullYear();

    var hours = ("0" + currentDate.getHours()).slice(-2);
    var minutes = ("0" + currentDate.getMinutes()).slice(-2);
    var seconds = ("0" + currentDate.getSeconds()).slice(-2);

    var formattedDateTime = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes + ':' + seconds;

    newWin.document.write('<div class="datetime">' + formattedDateTime + '</div>');
    newWin.document.write(div1.innerHTML);

    newWin.document.close();
}
</script>
 --}}



 <script>
    function printContent(time) {
        var div1 = document.getElementById('tab');
        var newWin = window.open('', 'Print-Window');
        newWin.document.open();
        newWin.document.write(
            '<link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors/bootstrap.css') }}">');
        newWin.document.write('<style>');

        // General styling for the printed content
        newWin.document.write('body { font-size: 20%; margin: 0px; position: relative; text-align: justify;}'); // Remove body margin
        newWin.document.write('.sign { text-align: right; margin-top: 20px}');
        newWin.document.write('p { font-size: 16px; margin: 0; padding: 0; }'); // Remove margins for all <p> elements to eliminate extra space

        // Remove margin for p tags inside the .sign class to remove extra space
        newWin.document.write('.sign p { margin: 15px; padding: 0; }'); // This removes the margin and padding between <p> tags inside .sign

        // Table styles to ensure it's fully visible and doesn't overflow
        newWin.document.write('table { border-collapse: collapse; width: 100%; table-layout: auto; }'); // Auto table layout ensures full width
        newWin.document.write('th, td { padding: 10px; border: 1px solid black; word-wrap: break-word; text-align: left; }'); // Added padding and word wrap
        newWin.document.write('.datetime { position: absolute; top: 10px; right: 10px; font-size: 14px; font-style: italic; }');

        // Fix for top margin and container width
        // Set A4 size margins: 20mm left and right, and 25mm for top and bottom
        newWin.document.write('@page { margin: 25mm 20mm 25mm 20mm; }'); // A4 size margins

        // Fix for horizontal table overflow: Adding left and right margins to container
        newWin.document.write('.container { margin-left: 20px; margin-right: 20px; }'); // Add horizontal margin to prevent overflow

        // Prevent page overflow when the content is too large
        newWin.document.write('@media print { table { page-break-inside: auto; } }'); // Ensure tables don't break across pages

        newWin.document.write('</style>');
        newWin.document.write('</head><body onload="window.print()">' );

        var currentDate = new Date();

        var day = ("0" + currentDate.getDate()).slice(-2);
        var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
        var year = currentDate.getFullYear();

        var hours = ("0" + currentDate.getHours()).slice(-2);
        var minutes = ("0" + currentDate.getMinutes()).slice(-2);
        var seconds = ("0" + currentDate.getSeconds()).slice(-2);

        var formattedDateTime = day + '/' + month + '/' + year + ' ' + hours + ':' + minutes + ':' + seconds;

        newWin.document.write('<div class="datetime">' + formattedDateTime + '</div>');
        newWin.document.write(div1.innerHTML);

        newWin.document.close();
    }
</script>

@endpush

