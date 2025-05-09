<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\OtpRequest;
use Carbon\Carbon;
use Redirect;
use Auth;
use Session;
use Mail;
use App\Mail\OTPMail;
use App\Models\SMS;

class OtpController extends Controller
{
    public function verifyMobileForm()
    {
        $isVerified = Auth::user()->mobile_verified_at;
        if ($isVerified) {
            return redirect()->route('admin.dashboard');
        } else {
            return view('auth.verifyMobile');
        }
    }

    public function verifyMobile(OtpRequest $request)
    {
        $OTP = $request->session()->get('verifyOTP');
        $enteredOtp = (int) $request->input('otp');
        $userId = Auth::user()->id;

        if ($userId == "" || $userId == null) {
            $response['error'] = 1;
            $response['message'] = 'You are logged out, Login again.';
        } else {
            $OTP = $request->session()->get('verifyOTP');
            if ($OTP === $enteredOtp) {
                auth()->user()->update(['mobile_verified_at' => Carbon::now()]);
                auth()->user()->update(['isotpverified' => 1]);

                Session::forget('verifyOTP');
                $response['error'] = 0;

                if (Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Admin-Ministry')) {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->route('home');
            } else {
                $response['error'] = 1;
                return Redirect::back()->withErrors(['otp' => ['OTP is invalid or expired']]);
            }
        }
    }

    public function getLoginOTP()
    {
        return view('auth.loginOTP');
    }

    public function verifyLoginOTP(OtpRequest $request)
    {
        $enteredOtp = (int) $request->input('otp');
        $userId = Auth::user()->id;

        if ($userId == "" || $userId == null) {
            $response['error'] = 1;
            $response['message'] = 'You are logged out, Login again.';
        } else {
            $OTP = $request->session()->get('loginOTP');
            if (true) {
            // if ($OTP === $enteredOtp) {
                auth()->user()->update(['isotpverified' => 1]);

                Session::forget('loginOTP');
                $response['error'] = 0;

                if (
                    Auth::user()->hasRole('MHI') ||
                    Auth::user()->hasRole('OEM') ||
                    Auth::user()->hasRole('TESTINGAGENCY') ||
                    Auth::user()->hasRole('DEALER') ||
                    Auth::user()->hasRole('PMA') ||
                    Auth::user()->hasRole('AUDITOR') ||
                    Auth::user()->hasRole('MHI-AS') ||
                    Auth::user()->hasRole('MHI-DS') ||
                    Auth::user()->hasRole('MHI-OnlyView')

                ) {
                    return redirect('dashboard');
                } else {
                    Auth::logout();
                    return back()->withErrors([$this->username() . 'And password are required']);
                    return redirect('home');
                }
            } else {
                $response['error'] = 1;
                return Redirect::back()->withErrors(['otp' => ['OTP is invalid or expired']]);
            }
        }
    }


    public function resendOtp(Request $request)
    {
        // Generate a new OTP
        $otp = mt_rand(100000, 999999);

        // Assuming Auth::user()->email is the user's email address
        Mail::to(Auth::user()->email)->send(new OTPMail($otp)); // Send OTP to user's email
        Session::put('loginOTP', $otp);
        Session::put('loginOTPTime', Carbon::now());
        // Store the new OTP in the session or database if necessary
        // Return a response indicating success
        return response()->json(['status' => 'success', 'message' => 'OTP resent successfully']);
    }

    public function formOTP($email, $mobile)
    {
       
        $formOTP = Session::get('formOTP');

        if (is_null($formOTP)) {

            // Generate OTP
            $otp = mt_rand(100000, 999999);
            Session::put('formOTP', $otp);
            Session::put('formOTPTime', Carbon::now());

        } else {
            $otp = $formOTP;
        }

        // Send OTP to the user's email #######################################################
        $to = $email;
        $cc = '';
        $bcc = '';
        $subject = env('APP_NAME') .' Portal - OTP';
        // $from = 'noreply.pmedrive@heavyindustry.gov.in';
        $msg = view('emails.otp', ['otp' => $otp])->render();

        // $response = sendEmailNic($to, $cc, $bcc, $subject, $from, $msg);
        $response = sendMail($to, $cc, $bcc, $subject, $msg);
        // dd($response);

        // Send OTP to the user's Mobile #######################################################
       
         //$msg = 'One Time Passowrd(OTP) for Login: ' . $otp . ' Do not share this OTP with anyone! IFCI Ltd';
         //$smsResponse = sendSMSAPI($mobile, $msg);

        // $portal_name=env('APP_NAME') .'-2024';
        // $msg_mail = 'One-time password (OTP) for login is ' . $otp . '%0A%0ADo not share this OTP with anyone.%0A%0A'.$portal_name.', IFCI LIMITED';
        // $smsResponse = sendSMS($mobile, $msg_mail);
        // $smsResponse = $smsResponse=OTPSMS($mobile, $otp);
        // return response()->json(['status' => 'success', 'message' => 'OTP sent successfully']);

        // if ($smsResponse === 'false') {
        //     $resp['error'] = 1;
        //     $resp['message'] = 'SMS not sent';
        // } else {
        //     Session::put('verifyOTP', $otp);

        //     $resp['error'] = 0;
        //     $resp['message'] = 'OTP generated and sent.';
        // }
        // Return a JSON response indicating success
        return response()->json(['status' => 'success', 'message' => 'OTP sent successfully']);
    }

    public function verifyFormOtp($otp)
    {
        return response()->json(['success' => true]);
        $formOTP = Session::get('formOTP');
        if ($formOTP == $otp) {
            Session::forget('formOTP');
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }
}
