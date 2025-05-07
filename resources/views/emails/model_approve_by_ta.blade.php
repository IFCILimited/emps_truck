<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ env('APP_NAME')}} Portal - Model Approved by Testing Agency</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                    style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#70bbd9"
                            style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: arial, sans-serif;">
                            <h2>{{ env('APP_NAME')}}-2024 Portal</h2>
                            <p>
                                <h5 style="color:rgb(168, 39, 39);">Model Approved by Testing Agency.
                                </h5>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: arial, sans-serif; font-size: 24px;">
                                        {{-- <b>{{ $user->name }}!</b> --}}
                                         <p>Dear Sir/Ma'am,</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="padding: 20px 0 30px 0; color: #153643; font-family: arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        {{-- <p>You have successfully submitted the details of pre-registration for approval under {{ env('APP_NAME')}}.</p> --}}
                                        <p>
                                            Testing Agency has approved the model ({{ $detail->model_name }}) of {{$oem->name }}(OEM),for further processing. Model details are as below -

                                            <table align="center" border="30" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                                                <tbody>
                                                    <tr>
                                                        <th style="padding: 10px; text-align: left;">Model Name</th>
                                                        <th style="padding: 10px; text-align: left;">Ex-Factory Price</th>
                                                        <th style="padding: 10px; text-align: left;">Segment Name</th>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 10px;">{{ $detail->model_name }}</td>
                                                        <td style="padding: 10px; text-align: right;">{{ $detail->ex_factory_price }}</td>
                                                        <td style="padding: 10px;">{{ $detail->segment }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            
                                        </p>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: arial, sans-serif; font-size: 14px;"
                                        width="75%">
                                        &reg; {{ env('APP_NAME')}} Portal 2024<br />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
