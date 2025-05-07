<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>{{ env('APP_NAME')}} Portal - Registration Process Initiated</title>
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
                                <h5 style="color:rgb(168, 39, 39);">Registration Status
                                </h5>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    @php 
                                        // $url = URL::temporarySignedRoute('post_registration', $expiration, ['id' => $encryptedUserId]);
                                    @endphp
                                    @if($user->post_registration_status == 'A')
                                    <td
                                        style="padding: 20px 0 30px 0; color: #153643; font-family: arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>Your account has been approved. You can now Login into portal using your credentials.
                                        </p>
                                        <p>Username : - {{ $user->username }}</p>
                                    </td>
                                    @elseif($user->post_registration_status == 'C')
                                    <td
                                        style="padding: 20px 0 30px 0; color: #153643; font-family: arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>Dear Sir,
                                            <br>
					 <br>
                                            Post Registration of {{$user->name}} (OEM) has been verified and recommended for approval.
					<br>
					<br> Regards </p>
                                        <p>
                                            {{ $user->post_registration_remark }}
                                        </p>
                                    </td>
                                    @elseif($user->post_registration_status == 'R')
                                    <td
                                        style="padding: 20px 0 30px 0; color: #153643; font-family: arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>Account Rejected
                                            <br>
                                            Your account has been rejected with the following remarks:</p>
                                        <p>
                                            {{ $user->post_registration_remark }}
                                        </p>
                                    </td>
                                    @endif
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
