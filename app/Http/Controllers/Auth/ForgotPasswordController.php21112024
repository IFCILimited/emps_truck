<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Auth;
use DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    public function index($userid = null) {

        if($userid != null){
        $userid = decrypt($userid);

        $user = DB::table('users')->where('id',$userid)->first();
        }
        else{
            $user = null;
        }
        return view('auth.passwords.reset',compact('userid','user'));
    }

    public function updatePassword(request $request) {

        // dd($request);
        $user = DB::table('users')->where('email',$request->email)->first();
        // dd($user->email);

        if($user) {
            // $password = $request->password;
            // $password = bcrypt($password);
            // DB::table('users')->where('email',$request->email)->update(['password' => $password]);
            // return redirect('/login');
            

            $to = $user->email;
            $cc= '';
            $bcc='';
            $subject='Password Change';
            $from = 'noreply.pmedrive@heavyindustry.gov.in';
            // $msg= $user->notify(new UserApprovalNotification($user));
            $msg=view('emails.passwordChange', ['user' => $user])->render();
            $response = sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);

            alert()->success('Password Reset Link has sent to your Email', 'Success')->persistent('Close');
            return redirect('/login');

        }

        
    }
    public function passwordUpdate(request $request)  {
            $password = $request->password;
            $password = bcrypt($password);
            DB::table('users')->where('email',$request->email)->update(['password' => $password]);
            alert()->success('Password Changed Successfully', 'Success')->persistent('Close');
            return redirect('/login');
    }
}
