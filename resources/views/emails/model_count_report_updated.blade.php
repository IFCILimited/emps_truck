<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Count Report</title>
</head>
<body>
    <h1>Model Count Report ({{$type ? 'Approved' : 'UnApproved'}})</h1>
    <table border="1">
        <thead>
            <tr>
                {{-- <th>OEM Name</th>
                <th>Fuel Type</th>
                <th>Model Name</th>
                <th>No. of Vehicle Registered</th>
                <th>Date of Registration</th>
                <th>Manufacturing Year</th>
                <th>Manufacturing Month</th>
                <th>Approved Status</th>
                <th>API Date From</th>
                <th>API Date TO</th>
                <th>Approved Status</th>
                <th>Message</th> --}}
                <th>Record Type</th>
                <th>Segment Id</th>
                <th>Category Id</th>
                <th>Category Name</th>
                <th>Total Count</th>
                <th>Min Date</th>
                <th>Max Date</th>
            </tr>
        </thead>
        <tbody>
           {{-- {{dd($results,'fghj')}} --}}
            @foreach ($results as $type => $value)
            {{-- {{dd($results,$result)}} --}}
            @foreach ($value as $col => $val)
                <tr>
                        <td>{{ $type }}</td>
                        <td>{{ $val->portal_segemt_id }}</td>
                        <td>{{ $val->portal_category_id }}</td>
                        <td>{{ $val->portal_category_name }}</td>
                        <td>{{ $val->sum }}</td>
                        <td>{{ $val->min }}</td>
                        <td>{{ $val->max }}</td>
                </tr>
            @endforeach 
                    {{-- <td>{{ $result['vahan_oem_name'] }}</td>
                    <td>{{ $result['vahan_fuel_type'] }}</td>
                    <td>{{ $result['modelName']}}</td>
                    <td>{{ $result['vahan_numberofvehiclesregistered']}}</td>
                    <td>{{ $result['vahan_date_of_registration']}}</td>
                    <td>{{ $result['manufacturing_year']}}</td>
                    <td>{{ $result['manufacturing_month']}}</td>
                    <td>{{ $result['api_from_date']}}</td>
                    <td>{{ $result['api_to_date']}}</td>
                    <td>{{ $result['approved_status']}}</td>
                    <td>{{ $result['message']}}</td> --}}
                
            @endforeach
        </tbody>
    </table>
</body>
</html>
