<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Models\User;
use Hash;

class ManageOperatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

          // $dealerReg = User::get();
          $pid = getParentId();
        //   dd($pid);
          try {
            //   $dealerReg = DB::table('users')
            //       ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            //       ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            //       ->whereIn('model_has_roles.role_id', [6])
            //     //   ->where('oem_id', $pid)
            //       ->select('users.*', 'roles.name as  role')
            //       ->get();

                  $dealerReg = DB::table('users')
                  ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                  ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                  ->whereIn('model_has_roles.role_id', [6])
                  ->where('parent_id', Auth::user()->id)
                  ->select('users.*', 'roles.name as  role')
                  ->get();

            // dd($dealerReg);


                  return view('buyer.operator.manage_operator_index', compact('dealerReg'));
          } catch (\Exception $e) {
              errorMail($e, $pid);
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
        $pid = getParentId();
        try {
            // Auth::id();
            $oemId = DB::table('users')->where('id',  Auth::id())->first();
            // dd($oemId);
            return view('buyer.operator.manage_operator_create', compact('oemId'));
        } catch (\Exception $e) {
            errorMail($e, $pid);
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

        $password = generatePassword();
        $pid = getParentId();
        try {
            $exception = DB::transaction(function () use ($request, $password,$pid) {
                $username = generateUsername($request->dealer_name, $request->mobile_no);
                $manageDealer = new User;
                $manageDealer->name =  Auth::user()->name;
                $manageDealer->dealer_code = $request->dealer_code;
                $manageDealer->password = Hash::make($password);
                $manageDealer->username = $username;
                $manageDealer->auth_name = $request->dealer_name;
                $manageDealer->pincode = $request->pin_code;
                $manageDealer->address = $request->address;
                $manageDealer->landmark = $request->landmark;
                $manageDealer->mobile = $request->mobile_no;
                $manageDealer->state = $request->state;
                $manageDealer->isotpverified = 0;
                $manageDealer->isactive = 'Y';
                $manageDealer->isapproved = 'Y';
                $manageDealer->auth_district = $request->district;
                $manageDealer->email = $request->email_id;
                $manageDealer->oem_id = $request->oem_id;
                $manageDealer->parent_id = $pid;
                $manageDealer->save();


                $manageDealer->assignRole('DEALER');

                $userData = $manageDealer->where('id', $manageDealer->id)->first();

                $userMail = array (
                    'name' => $manageDealer->name,
                    'email' => $manageDealer->email,
                    'status' => 'Login Credential Successfully Create',
                    'username' => $userData->username,
                    'password' => $password
                );

                // Mail::send('emails.dealerCredential', $userMail, function ($message) use ($userMail) {
                // Mail::send('emails.Credential', $userMail, function ($message) use ($userMail) {
                //     $message->to($userMail['email'])->subject($userMail['status']);
                // });
                $to = $userMail['email'];
                $cc= '';
                $bcc='';
                $subject=$userMail['status'];
                // $from = 'noreply.pmedrive@heavyindustry.gov.in';
                $msg=view('emails.Credential', ['user' => $userMail])->render();

                $response = sendMail($to,$cc,$bcc,$subject,$msg);
            });
            if (is_null($exception)) {
                alert()->success('Dealer has been successfully created.', 'Success')->persistent('Close');
                return redirect()->route('manageOperator.index');
            } else {
                throw new Exception;
            }
        // } catch (\Illuminate\Database\QueryException $e) {
        //     $errorMessage = "Database error: " . $e->getMessage();
        //     if ($e->errorInfo[1] == 1062) { // Unique constraint violation
        //         $errorMessage = "A record with the same value already exists.";
        //     }
        //     alert()->warning('Something Went Wrong: ' . $errorMessage, 'Danger')->persistent('Close');
        //     return redirect()->route('manageDealer.index')->withErrors(['error' => $errorMessage]);
        } catch (Exception $e) {
           
            alert()->warning('Something Went Wrong: ' . $e->getMessage(), 'Danger')->persistent('Close');

            return redirect()->route('manageDealer.index');
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
        // $id = decrypt($id);
        // dd($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);

        $dealerReg = DB::table('users')
                  ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                  ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                  ->whereIn('model_has_roles.role_id', [6])
                  ->where('parent_id', Auth::user()->id)
                  ->where('users.id', $id)
                  ->select('users.*', 'roles.name as  role')
                  ->first();
                //   dd($dealerReg);

            $GetOemId = DB::table('users')->where('id', $id)->first();

            $oemIdCheck = $GetOemId->oem_id;

        return view('buyer.operator.edit', compact('dealerReg','oemIdCheck'));
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
        //
        $id = decrypt($id);
$password = generatePassword();
$pid = getParentId();

try {
    $exception = DB::transaction(function () use ($request, $pid, $id, $password) {
        $manageDealer = User::findOrFail($id);

        $username = generateUsername($request->dealer_name, $request->mobile_no);

        $manageDealer->name = Auth::user()->name;
        $manageDealer->dealer_code = $request->dealer_code;
        $manageDealer->password = Hash::make($password);
        $manageDealer->username = $username;
        $manageDealer->auth_name = $request->dealer_name;
        $manageDealer->pincode = $request->pin_code;
        $manageDealer->address = $request->address;
        $manageDealer->landmark = $request->landmark;
        $manageDealer->mobile = $request->mobile_no;
        $manageDealer->state = $request->state;
        $manageDealer->isotpverified = 0;
        $manageDealer->isactive = 'Y';
        $manageDealer->isapproved = 'Y';
        $manageDealer->auth_district = $request->district;
        $manageDealer->email = $request->email_id;
        $manageDealer->oem_id = $request->oem_id;
        $manageDealer->parent_id = $pid;

        $manageDealer->save();

        $manageDealer->assignRole('DEALER');

        $userData = User::find($manageDealer->id);

        $userMail = [
            'name' => $manageDealer->name,
            'email' => $manageDealer->email,
            'status' => 'Login Credentials Successfully Updated',
            'username' => $userData->username,
            'password' => $password,
        ];

        $to = $userMail['email'];
        $cc = '';
        $bcc = '';
        $subject = $userMail['status'];
        // $from = 'noreply.pmedrive@heavyindustry.gov.in';
        $msg = view('emails.Credential', ['user' => $userMail])->render();

        sendMail($to, $cc, $bcc, $subject, $msg);
    });

    if (is_null($exception)) {
        alert()->success('Dealer has been successfully updated.', 'Success')->persistent('Close');
        return redirect()->route('manageOperator.index');
    } else {
        throw new Exception('Error updating dealer.');
    }
} catch (\Exception $e) {
    alert()->error('Something went wrong. Please try again.', 'Error')->persistent('Close');
    return redirect()->back()->withInput();
}


    }

    public function updateOperator($id)
    {
        $id = decrypt($id);

        $users = DB::table('users')->where('id', $id)->first();


        try {
            DB::transaction(function () use ($id, $users) {
                if ($users->isactive == 'Y' && $users->isapproved == 'Y') {
                    DB::table('users')
                        ->where('id', $id)
                        ->update(['isactive' => 'N', 'isapproved' => 'N']);

                alert()->success('Dealer has been Deactivated Successfully.', 'Success')->persistent('Close');


                } else {
                    DB::table('users')
                        ->where('id', $id)
                        ->update(['isactive' => 'Y', 'isapproved' => 'Y']);

                alert()->success('Dealer has been Activate Successfully.', 'Success')->persistent('Close');
                }

            });
            return redirect()->route('manageOperator.index');



        } catch (\Exception $e) {
            alert()->error('Something went wrong. Please try again.', 'Error')->persistent('Close');
            return redirect()->back()->withInput();
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
