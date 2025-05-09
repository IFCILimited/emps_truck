<?php

namespace App\Http\Controllers\OEM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRegisterRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PostRegistrationDetail;
use App\Models\OEMType;
use App\Models\ManufacturingEVPlantDetail;
use DB;
use Exception;
use Mail;
use Auth;

class OEMPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('auth.post_register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        try {
            DB::transaction(function () use ($request) {
                $userPostData = PostRegistrationDetail::where('user_id', $request->user_id)->first();
                if ($userPostData) {
                    alert()->warning('You have already submitted post-registration')->persistent('Close');
                    return redirect()->route('home');
                }
                
                $user = User::find($request->user_id);
                $user->password = Hash::make($request->password);
                $user->landmark = $request->registered_office_landmark;
                $user->landline = $request->registered_office_landline_no;
                $user->auth_address = $request->authorized_person_address;
                $user->auth_pincode = $request->authorized_person_pincode;
                $user->auth_state = $request->authorized_person_state;
                $user->auth_district = $request->authorized_person_district;
                $user->auth_city = $request->authorized_person_city;
                $user->auth_landmark = $request->authorized_person_landmark;
                $user->auth_mobile = $request->authorized_person_mobile;
                $user->auth_email = $request->authorized_person_email;
                $user->auth_fax = $request->authorized_person_fax;
                $user->save();


                foreach ($request->evplant as $value) {
                    $manufacturing_plant = new ManufacturingEVPlantDetail;
                    $manufacturing_plant->user_id = $user->id;
                    $manufacturing_plant->plant_name = $value['plant_name'];
                    $manufacturing_plant->address = $value['plant_address'];
                    $manufacturing_plant->email = $value['plant_email'];
                    $manufacturing_plant->state = $value['plant_state'];
                    $manufacturing_plant->district = $value['plant_district'];
                    $manufacturing_plant->city = $value['plant_city'];
                    $manufacturing_plant->pincode = $value['plant_pincode'];
                    $manufacturing_plant->landline_no = $value['plant_landline'];
                    $manufacturing_plant->save();
                }

                if ($request->hasFile('gstin_registration_file')) {
                    // dd($request->file('gstin_registration_file'),'s');
                    $file = $request->gstin_registration_file;
                    $response = uploadFileWithCurl($file);
                    $gstinRegistrationId = $response;

                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }

                }

                if ($request->hasFile('oem_pan_file')) {

                    $file = $request->oem_pan_file;
                    $response = uploadFileWithCurl($file);
                    $oemPanId = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                }

                if ($request->hasFile('r_and_d_facilities_file')) {

                    $file = $request->r_and_d_facilities_file;
                    $response = uploadFileWithCurl($file);
                    $rndFacilitiesId = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                }

                if ($request->hasFile('dealer_list_file')) {

                    $file = $request->dealer_list_file;
                    $response = uploadFileWithCurl($file);
                    $dealerListId = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                }


                $post_regi = new PostRegistrationDetail;
                $post_regi->user_id = $request->user_id;
                $post_regi->gstin_no = $request->gstin_no;
                $post_regi->gstin_registration_upload_id = $gstinRegistrationId;
                $post_regi->oem_pan = $request->oem_pan;
                $post_regi->oem_pan_upload_id = $oemPanId;
                $post_regi->r_and_d_facilities_upload_id = $rndFacilitiesId;
                $post_regi->annual_turnover = $request->annual_turnover;
                $post_regi->account_holder_name = $request->account_holder_name;
                $post_regi->account_no = $request->account_number;
                $post_regi->ifsc_code = $request->ifsc_code;
                $post_regi->micr_code = $request->micr_code;
                $post_regi->account_type = $request->account_type;
                $post_regi->bank_name = $request->bank_name;
                $post_regi->branch_name = $request->branch_name;
                $post_regi->branch_address = $request->bank_address;
                $post_regi->branch_pincode = $request->branch_pincode;
                $post_regi->branch_state = $request->branch_state;
                $post_regi->branch_district = $request->branch_district;
                $post_regi->branch_city = $request->branch_city;
                $post_regi->dealer_mode = $request->dealer_mode;
                $post_regi->dealer_no = $request->dealer_numbers;
                $post_regi->no_of_dealers = $request->no_of_dealer;
                $post_regi->dealer_state = json_encode($request->state_of_dealer_presence);
                $post_regi->dealer_upload_id = $dealerListId;

                if ($request->hasFile('vehicle_photo')) {

                    $file = $request->vehicle_photo;
                    $response = uploadFileWithCurl($file);
                    $vehicle_photo_id = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                }

                $post_regi->vehicle_photo_id = $vehicle_photo_id;

                if ($request->hasFile('moa_aoa')) {

                    $file = $request->moa_aoa;
                    $response = uploadFileWithCurl($file);
                    $moa_aoa_id = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                }

                $post_regi->moa_aoa_id = $moa_aoa_id;

                if ($request->hasFile('trade_license')) {

                    $file = $request->trade_license;
                    $response = uploadFileWithCurl($file);
                    $trade_license_id = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                }

                $post_regi->trade_license_id = $trade_license_id;

                if ($request->hasFile('manufacturer_registration')) {

                    $file = $request->manufacturer_registration;
                    $response = uploadFileWithCurl($file);
                    $manufacturer_registration_id = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                }

                $post_regi->manufacturer_registration_id = $manufacturer_registration_id;

                if ($request->hasFile('pre_registration_ev_model')) {

                    $file = $request->pre_registration_ev_model;
                    $response = uploadFileWithCurl($file);
                    $pre_registration_ev_model_id = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                }

                $post_regi->pre_registration_ev_model_id = $pre_registration_ev_model_id;

                if ($request->hasFile('oem_sales_and_service_network')) {

                    $file = $request->oem_sales_and_service_network;
                    $response = uploadFileWithCurl($file);
                    $oem_sales_and_service_network_id = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                }

                $post_regi->oem_sales_and_service_network_id = $oem_sales_and_service_network_id;

                if ($request->hasFile('tesed_homologation_certificate')) {

                    $file = $request->tesed_homologation_certificate;
                    $response = uploadFileWithCurl($file);
                    $tesed_homologation_certificate_id = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                }

                $post_regi->tesed_homologation_certificate_id = $tesed_homologation_certificate_id;
                

                $post_regi->save();

                
                if ($request->hasFile('registration_certificate_upload_id')) {
                    // dd($request);
                    $file = $request->registration_certificate_upload_id;
                    $response = uploadFileWithCurl($file);
                    $registration_certificate_upload_id = $response;
                    if($response == 0){
                        alert()->warning('Something Went Wrong', 'Danger')->persistent('Close');
                        return redirect()->back();
                    }
                
            }   
            if ($request->hasFile('registration_certificate_upload_id')) {
                $userupd = DB::table('users')->where('id', $request->user_id)->update([
                    'registration_certificate_upload_id' => isset($registration_certificate_upload_id)
                ]);
            }
                $userData = $user->where('id', $request->user_id)->first();

               

                $userMail = array (
                    'name' => $user->name,
                    'email' => $user->email,
                    'status' => 'Your Post-Registration form has been successfully submit',
                    'username' => $userData->username,
                    'password' => $request->password
                );

            $to = $userMail['email'];
            $cc= '';
            $bcc='';
            $subject=$userMail['status'];
            $from = 'noreply.pmedrive@heavyindustry.gov.in';
            $msg=view('emails.Postregistration', ['user' => $userMail])->render();
 
            $response = sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);


            $dsUsers = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.id', 11)
            ->get();

           foreach($dsUsers as $dsUser){
            $to = $dsUser->email;
            $cc= '';
            $bcc='';
            $subject=env('APP_NAME').'Portal - Registration';
            $from = 'noreply.pmedrive@heavyindustry.gov.in';
            $msg=view('emails.oem_ds_as_postregister', ['dsUser' => $dsUser, 'user' => $userData])->render();

            $response = sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);

           }
            });

            alert()->success('Post Registration Successfully Submit', 'Success')->persistent('Close');
            return redirect()->route('home');
        } catch (Exception $e) {
           alert()->success('Something Went Wrong', 'Error')->persistent('Close');
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
        try {
            $id = decrypt($id);
            $user = User::Where('id', $id)->first();
            $states = DB::table('pincodecitystate')->distinct('state')->pluck('state')->toArray();
            $oemType = OEMType::get();
            $postChk = PostRegistrationDetail::where('user_id', $id)->first();
            // if($postChk){
            //     alert()->warning('You are Already Registered', 'Warning')->persistent('Close');
            //     return redirect()->route('home');
            // }
            return view('auth.post_register', compact('user', 'states', 'oemType'));
        } catch (Exception $e) {
            errorMail($e, $id);
            return redirect()->route('manageDealer.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
