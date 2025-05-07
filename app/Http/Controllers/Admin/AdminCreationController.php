<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use DB;
use Role;
use Exception;
use Mail;
use Auth;
use Carbon\Carbon;



class AdminCreationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->whereIn('model_has_roles.role_id', [5,8,9,10,11,12])
                ->select('users.*', 'roles.name as  role')
                ->get();

            return view('admin.manage_admin.index', compact('users'));
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('admin.manage_admin.create');
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $email=DB::table('users')->where('email',$request->email)->first();
                // $mobile=DB::table('users')->where('mobile',$request->mobile)->first();

                if( $email){
                    alert()->Warning('Email already exist, Please use another email.', 'Warning')->persistent('Close');
                    return redirect()->back();
                }

                // if( $mobile){
                //     alert()->Warning('Mobile Number already exist, Please use another mobile.', 'Warning')->persistent('Close');
                //     return redirect()->back();
                // }

            DB::transaction(function () use ($request) {
                $password = generatePassword();
                $username = generateUsername($request->name, $request->mobile);
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($password);
                $user->username = $username;
                $user->auth_name = $request->name;
                $user->auth_designation = $request->designation;
                $user->isactive = $request->status;
                $user->isotpverified = 0;
                $user->isapproved = $request->status;
                $user->mobile = $request->mobile;
                $user->user_created_by = Auth::user()->id;
                $user->user_created_at = Carbon::now();
                $user->save();

                $user->assignRole($request->user_type);

                $userData = $user->where('id', $user->id)->first();

                $userMail = array (
                    'name' => $userData->name,
                    'email' => $userData->email,
                    'status' => 'Login Credential Successfully Create',
                    'username' => $userData->username,
                    'password' => $password
                );

                $to = $userMail['email'];
                $cc= '';
                $bcc='';
                $subject=$userMail['status'];
                $from = 'noreply.pmedrive@heavyindustry.gov.in';
                $msg=view('emails.Credential', ['user' => $userMail])->render();

                sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);
            });

            alert()->success('Data has been successfully saved.', 'Success')->persistent('Close');
            return redirect()->route('superAdmin.index');
        } catch (Exception $e) {
            alert()->Warning('Something went wrong', 'Warning')->persistent('Close');
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //     $users =User::find($id);
        //    return view('admin.manage_admin.show',compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $users = User::find($id);
            // dd($users);
            return view('admin.manage_admin.edit', compact('users'));
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {

                $password = generatePassword();
                $user = User::findOrFail($id); // Change 'user_id' to the actual name of the input field that holds the user's ID
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($password);
                $user->auth_name = $request->name;
                $user->auth_designation = $request->designation;
                $user->isactive = $request->status;
                $user->mobile = $request->mobile;
                $user->save();

                $user->assignRole($request->user_type); //For Role Insert
                if($request->status=='Y'){

                    $userData = $user->where('id', $user->id)->first();

                    $userMail = array (
                        'name' => $userData->name,
                        'email' => $userData->email,
                        'status' => 'Login Credential Successfully Create',
                        'username' => $userData->username,
                        'password' => $password
                    );

                    $to = $userMail['email'];
                    $cc= '';
                    $bcc='';
                    $subject=$userMail['status'];
                    $from = 'noreply.pmedrive@heavyindustry.gov.in';
                    $msg=view('emails.Credential', ['user' => $userMail])->render();

                    sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);
                }

            });

            alert()->success('Data has been successfully updated.', 'Success');
            return redirect()->route('superAdmin.index');
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
