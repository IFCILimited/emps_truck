<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Auth;
use DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    // protected $maxAttempts = 1;
    // protected $decayMinutes = 1;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    protected $redirectTo = RouteServiceProvider::HOME;
    protected $maxAttempts = 1;
    protected $decayMinutes = 1;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $identity = request()->get('identity');
        $fieldname = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'username' : 'username';
        request()->merge([$fieldname => $identity]);
        return $fieldname;
    }

    protected function validateLogin(Request $request)
    {
        
        $key = hex2bin("0123456789abcdef0123456789abcdef");
        $iv = hex2bin("abcdef9876543210abcdef9876543210");
        
        $decryptedId = openssl_decrypt($request->identity, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $decryptedId = trim($decryptedId);
        $decryptedPwd = openssl_decrypt($request->password, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
        $decryptedPwd = trim($decryptedPwd);
        
        $request->merge([
            'identity' => $decryptedId,
            'password' => $decryptedPwd,
            
        ]);
        $messages = [
            
            'captcha.required' => 'The CAPTCHA field is required.',
            'captcha.captcha' => 'The CAPTCHA is incorrect, please try again.',
        ];

        if ($this->username() == 'username') {
            
            $validator = Validator::make($request->all(), [
                $this->username() => [
                    'required',
                    // 'size:10',
                    function ($attribute, $value, $fail) use ($request) { // Use the $request variable in the function 
                        $user = User::where('username', $value)->first();
                        if($user){
                            $modelcheck = DB::table('model_has_roles')->where('model_id', $user->id)->first('role_id');
                            $rolecheck = DB::table('roles')->where('id', $modelcheck->role_id)->first();
                            //    dd( $modelcheck,$rolecheck);
                            // dd($user,$request->usertype,$rolecheck->name);
                            if($user->hasRole(['OEM'])){
                            if ($user && $user->isapproved == 'Y' && $rolecheck->name == $request->usertype && $user->approval_for_post_reg=='A' && $user->post_registration_status=='A') {
                                return true;
                            }
                        }elseif($user->hasRole(['DEALER'])){
                            if ($user && $user->isapproved == 'Y' && $rolecheck->name == $request->usertype && $user->oem_id!=Null) {
                                return true;
                            }
                        }elseif($user->hasRole(['MHI-AS'])||$user->hasRole(['MHI-DS'])||$user->hasRole(['MHI-OnlyView'])||$user->hasRole(['PMA'])||$user->hasRole(['AUDITOR'])||$user->hasRole(['MHI'])||$user->hasRole(['TESTINGAGENCY'])){
                            // dd($user);
                            if ($user && $user->isapproved == 'Y' && $rolecheck->name == $request->usertype) {
                                return true;
                               
                            }
                        }
                        else{
                            return false;
                        }                       
                       }
                       
                        // return $fail('These credentials do not match with selected user type / You have not approved for login. Please try again!');
                        return $fail('These credentials do not match our records.');
                    },
                ],
                'password' => 'required|string',
                'captcha' => 'required|captcha',
                
            ], $messages);
            
            $validator->validate();
        }
    }
    protected function authenticated($request)
    {

        // dd($request->password);
        // logout from other device
        Auth::logoutOtherDevices($request->password);
        auth()->user()->update(['isotpverified' => 0]);

        // dd( Auth::user()->hasRole('MHI') ||
        // Auth::user()->hasRole('OEM') ||
        // Auth::user()->hasRole('TESTINGAGENCY') ||
        // Auth::user()->hasRole('DEALER')||
        // Auth::user()->hasRole('PMA')||
        // Auth::user()->hasRole('AUDITOR'));
        //for dashoard
        if (
            Auth::user()->hasRole('MHI') ||
            Auth::user()->hasRole('OEM') ||
            Auth::user()->hasRole('TESTINGAGENCY') ||
            Auth::user()->hasRole('DEALER')||
            Auth::user()->hasRole('PMA')||
            Auth::user()->hasRole('AUDITOR')||
            Auth::user()->hasRole('MHI-AS')||
            Auth::user()->hasRole('MHI-DS')||
            Auth::user()->hasRole('MHI-OnlyView')
        ) {
		if (Auth::user()->parent_id) {
                // Fetch parent user data
                $parentUser = User::find(Auth::user()->parent_id);
                if ($parentUser) {
                    // dd($parentUser);
                    // Store parent user in session or any other mechanism
                    session(['parent_user' => $parentUser]);
                }
            }
            else{
                session(['parent_user' => null]);
            }
            return redirect('dashboard');
        } else {
            // dd(Auth::user());
            Auth::logout();
            return back()->withErrors([$this->username() . 'And password are required']);
            return redirect('home');
        }
    }
}

