<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\OEMType;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PreRegisterRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Auth, Log, Exception, DB;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, (new PreRegisterRequest())->rules());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $oemType = OemType::where("type", $data['oem_type'])->first();
        $data['password'] = isset($data['password']) ? $data['password'] : Null;

         if ($data['Registration_file']) {

             $file = $data['Registration_file'];
            //  $response = uploadFileWithCurl($file); //file upload using API
            //  $documentUpload_id = $response;
             $documentUpload_id = 1;

         }
        $username = generateUsername($data['Name'], $data['Mobile']);
        return User::create([
            'name' => $data['Name'],
            'username' => $username,
            'email' => strtolower($data['Mail']),
            'mobile' => $data['Mobile'],
            'password' => Hash::make($data['password']),
            'oem_type_id' => $oemType->id,
            'address' => $data['Address'],
            'pincode' => $data['Pincode'],
            'state' => $data['State'],
            'district' => $data['District'],
            'city' => $data['City'],
            'auth_name' => $data['Person'],
            'auth_designation' => $data['Person_designation'],
            'isactive' => 'Y',
            'isotpverified' => 0,
            'isapproved' => 'N',
            'fax' => $data['Fax'],
            'registration_no' => $data['Registration'],
            'registration_certificate_upload_id' => $documentUpload_id
        ]);
    }

    protected function registered(Request $request, $user)
    {

        try {
            $user->assignRole('OEM');
            Auth::logout();
           
            $to = $user->email;
            $cc= '';
            $bcc='';
            $subject=env('APP_NAME') .' Portal - Registration';
            $from = 'noreply.pmedrive@heavyindustry.gov.in';
            $msg=view('emails.registration', ['user' => $user])->render();


            $dsUsers = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.id', 11)
            ->get();

           foreach($dsUsers as $dsUser){
            $to = $dsUser->email;
            $cc= '';
            $bcc='';
            $subject=env('APP_NAME') .' Portal - Registration';
            $from = 'noreply.pmedrive@heavyindustry.gov.in';
            $msg=view('emails.oem_ds_registration', ['dsUser' => $dsUser, 'user' => $user])->render();

            $response = sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);

           }
                alert()->success('Pre-Registration successfully Submitted', 'Pre-Registration')->persistent('Close');
                return redirect()->route('home');
        } catch (Exception $e) {
		alert()->success('Not Registered', 'Pre-Registration')->persistent('Close');

                   return redirect()->back();
        }
    }
}