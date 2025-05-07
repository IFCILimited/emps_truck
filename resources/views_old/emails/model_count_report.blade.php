<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Model Count Report</title>
</head>
<body>
    <h1>Model Count Report</h1>
    <table border="1">
        <thead>
            <tr>
                <th>OEM Name</th>
                <th>Fuel Type</th>
                <th>Model Name</th>
                <th>No. of Vehicle Registered</th>
                <th>Date of Registration</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
           {{-- {{dd($results,'fghj')}} --}}
            @foreach ($results as $result)
            {{-- {{dd($results,$result)}} --}}
                <tr>
                    <td>{{ $result['oemName'] }}</td>
                    <td>{{ $result['fuelType'] }}</td>
                    <td>{{ $result['modelName']}}</td>
                    <td>{{ $result['numberofvehiclesregistered']}}</td>
                    <td>{{ $result['dateOfRegistration']}}</td>
                    <td>{{ $result['message']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
