<!-- otp.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Email</title>
</head>
</html>
<!DOCTYPE html>
<html>
<style>
    h1, h2, h3, h4, h5, h6 {
        text-align: center;
    }
    #t01,#t02,#t03 {
        border: 1px solid black;
}
#t03 {
  text-align: center;
}
</style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><!-- mobile responsive meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Login Details</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin: 0; padding: 0;">
    <table style="width: 100%">
        <tr>
            <td style="padding: 10px 0 20px 0;">
                <table style="border: 1px solid #cccccc; border-collapse: collapse; width:600px;">
                    <tr>
                        <td style=" color: #153643; font-size: 24px; font-weight: bold; font-family: Arial, sans-serif; background-color:#A9CCE3;text-justify-center">
                            <h2>PM E-DRIVE</h2>
                        </td>
                    </tr>
                    <tr>
                        <td   style="padding: 40px 30px 40px 30px; background-color:#ffffff;">
                            <table  style="width : 100%;">
                                <tr>
                                    <td
                                        style="color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; text-align: justify;">
                                        
                                        <p>Your OTP is: <strong>{{ $otp }}</strong></p>
                                        <br>                           
                                        <p>Please use this OTP to complete your verification process.</p>
                                        <p>
                                            Regards<br>
                                            IFCI Ltd.
                                        </p>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td  style="padding: 0px 30px 0px 30px; background-color:#ee4c50; ">
                            <table style="width: 100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;width: 75%;">
                                        <h4>&copy; 2024 {{ env('APP_NAME')}}. All rights reserved</h4>
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


