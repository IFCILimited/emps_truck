<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Mail;
use Carbon\Carbon;
use App\Mail\OTPMail;
use Auth;
use App\Models\SMS;
use App\Mail\AuthOtpMail;

class TwoFA
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//         $to = "sahiljassal9198@gmail.com";
//         $response = Mail::to($to)
//         ->send(new AuthOtpMail());
// dd("sent", $response);


        $user = Auth::user();

         //if ($user->mobile_verified_at) {
            // if ($user->isotpverified) {
                if (1) {
                     if (1) {
                return $next($request);
            } else {

                if (Session::get('loginOTP')) {
                    $otpTime = Carbon::parse(Session::get('loginOTPTime'));

                    if ($otpTime->gte(Carbon::now()->subSeconds(60))) {
                        $msg = 'OTP already generated at ' . Session::get('loginOTPTime')->format('d-m-Y H:i') . ' and valid for 1 minute.';
                        return redirect('/getotp')->withErrors([$msg]);

                    } else {
                        Session::forget('loginOTP');
                        Session::forget('loginOTPTime');
                    }

                }

                $otp = rand(100000, 999999);

                $to = $user->email;
                $cc = '';
                $bcc = '';
                $subject = env('APP_NAME') .'Portal - OTP';
                $from = 'noreply.pmedrive@heavyindustry.gov.in';

                $msg = view('emails.otp', ['otp' => $otp])->render();

                $response = sendEmailNic($to, $cc, $bcc, $subject, $from, $msg);


                Session::put('loginOTP', $otp);
                Session::put('loginOTPTime', Carbon::now());

                 $msg_mail = 'One Time Passowrd(OTP) for Login: ' . $otp . ' Do not share this OTP with anyone! IFCI Ltd';
                 $smsResponse = sendSMSAPI($user['mobile'], $msg_mail);

                $portal_name= env('APP_NAME') .'-2024';
                $msg_mail = 'One-time password (OTP) for login is ' . $otp . '%0A%0ADo not share this OTP with anyone.%0A%0A'.$portal_name.', IFCI LIMITED';
                $smsResponse = sendSMS($user['mobile'], $msg_mail);

                // $smsResponse=OTPSMS($user['mobile'], $msg_mail)
                // $mobil=7379498775;
                // $smsResponse=OTPSMS($mobil, $otp);


                if ($smsResponse === 'false') {
                    $resp['error'] = 1;
                    $resp['message'] = 'SMS not sent';
                } else {
                    Session::put('verifyOTP', $otp);

                    $resp['error'] = 0;
                    $resp['message'] = 'OTP generated and sent.';
                }

                return redirect('/getotp');
            }
        } else {



            $otp = rand(100000, 999999);

            //  for mail
            // Mail::to($user->email)->send(new OTPMail($otp));
            $to = $user->email;
            $cc = '';
            $bcc = '';
            $subject = env('APP_NAME') .'Portal - OTP';
            $from = 'noreply.pmedrive@heavyindustry.gov.in';
            $msg = view('emails.otp', ['otp' => $otp])->render();

            $response = sendEmailNic($to, $cc, $bcc, $subject, $from, $msg);

            Session::put('verifyOTP', $otp);

            // for Mobile
            // $msg_mail = 'One Time Passowrd(OTP) for Login: ' . $otp . ' Do not share this OTP with anyone! IFCI Ltd';
            // $smsResponse = sendSMSAPI($user['mobile'], $msg_mail);

            // $portal_name=env('APP_NAME') .'-2024';
            // $msg_mail = 'One-time password (OTP) for login is ' . $otp . '%0A%0ADo not share this OTP with anyone.%0A%0A'.$portal_name.', IFCI LIMITED';
            // $smsResponse = sendSMS($user['mobile'], $msg_mail);

            if ($smsResponse === 'false') {
                $resp['error'] = 1;
                $resp['message'] = 'SMS not sent';
            } else {
                Session::put('verifyOTP', $otp);

                $resp['error'] = 0;
                $resp['message'] = 'OTP generated and sent.';
            }

            return redirect('/verifymobile');
        }
    }
}
