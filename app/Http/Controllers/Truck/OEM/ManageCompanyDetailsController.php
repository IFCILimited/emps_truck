<?php

namespace App\Http\Controllers\Truck\OEM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Illuminate\Support\Carbon;


class ManageCompanyDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $data = DB::table('oem_update_profile_data as oupd')->select('oupd.*', 'usr.name');
        if(Auth::user()->hasRole('OEM')){
            $data->where('oupd.oem_id', getParentId());
        }else{
            $data->where('oupd.status', 'S');
        }
        $data->join('users as usr', 'usr.id', 'oupd.oem_id');
        $details = $data->get();
        return view('truck.oem.user_details.manage_user_details_list', compact('details'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $userId = Auth::user()->id;

        $isExist = DB::table('oem_update_profile_data')
        ->where('oem_id', $userId)
        ->where('status', 'S')
        ->where('pma_status', 'P')
        ->exists();
        if($isExist){
            alert()->warning('An active application already exists! A new application cannot be created.')->persistent('Close');
            return redirect()->back();
        }

        $usersDetails = DB::table('users as usr')
        ->select('usr.name', 
            'usr.address', 
            'usr.email',
            'usr.mobile',
            'prd.gstin_no',
            'prd.oem_pan',
            'usr.pincode', 
            'usr.state', 
            'usr.district', 
            'usr.city', 
            'usr.landmark',
            'usr.auth_name',
            'usr.auth_address',
            'usr.auth_pincode',
            'usr.auth_state',
            'usr.auth_district',
            'usr.auth_city', 
            'usr.auth_landmark', 
            'usr.auth_mobile', 
            'usr.auth_email')
        ->join('post_registration_detail as prd', 'prd.user_id', "usr.id")
        ->where('usr.id', $userId)
        ->first();
        $docs = DB::table('oem_update_profile_docs')->get();
        // dd($usersDetails, $docs);
        return view('truck.oem.user_details.manage_user_details', compact('usersDetails', 'docs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::transaction(function() use ($request){
                // dd($request->all(), $request->files,Auth::user()->id, getParentId());
                //auth profile data
                $existingProfileData = json_encode([
                    'exist_cust_name' => $request->exist_cust_name,
                    'exist_cust_email' => $request->exist_cust_email,
                    'exist_cust_mobile' => $request->exist_cust_mobile,
                    'exist_cust_gst' => $request->exist_cust_gst,
                    'exist_cust_addr' => $request->exist_cust_addr,
                    'exist_cust_city' => $request->exist_cust_city,
                    'exist_cust_dist' => $request->exist_cust_dist,
                    'exist_cust_land' => $request->exist_cust_land,
                    'exist_cust_state' => $request->exist_cust_state,
                    'exist_cust_pincode' => $request->exist_cust_pincode,
                    'exist_auth_name' => $request->exist_auth_name,
                    'exist_auth_email' => $request->exist_auth_email,
                    'exist_auth_mobile' => $request->exist_auth_mobile,
                    'exist_auth_addr' => $request->exist_auth_addr,
                    'exist_auth_city' => $request->exist_auth_city,
                    'exist_auth_dist' => $request->exist_auth_dist,
                    'exist_auth_land' => $request->exist_auth_land,
                    'exist_auth_state' => $request->exist_auth_state,
                    'exist_auth_pincode' => $request->exist_auth_pincode
                ]);
                //profile data
                $updateProfileData = json_encode([
                    'cust_name' => $request->cust_name,
                    'cust_mail' => $request->cust_mail,
                    'cust_mobile' => $request->cust_mobile,
                    'cust_gst' => $request->cust_gst,
                    'cust_addr' => $request->cust_addr,
                    'cust_city' => $request->cust_city,
                    'cust_dist' => $request->cust_dist,
                    'cust_land' => $request->cust_land,
                    'cust_state' => $request->cust_state,
                    'cust_pincode' => $request->cust_pincode,
                    'auth_name' => $request->auth_name,
                    'auth_email' => $request->auth_email,
                    'auth_mobile' => $request->auth_mobile,
                    'auth_addr' => $request->auth_addr,
                    'auth_city' => $request->auth_city,
                    'auth_dist' => $request->auth_dist,
                    'auth_land' => $request->auth_land,
                    'auth_state' => $request->auth_state,
                    'auth_pincode' => $request->auth_pincode
                ]);
                // dd($request->all(), $request->files,Auth::user()->id, getParentId(), $authProfileData, $custProfileData);

                //fetch all docs
                $docs = DB::table('oem_update_profile_docs')->get();
                
                $uploaded_docs = [];
                //upload files
                foreach($docs as $doc){
                    if($request->hasFile($doc->file_name)) {
                        $file = $request->file($doc->file_name);
                        $response = uploadFileWithCurl($file);
                        $uploaded_reg_file = $response;
                        // $uploaded_reg_file = 2;
                        $uploaded_docs[$doc->file_name] = $uploaded_reg_file;
                    }
                }
                // dd($docs, $request->all(), $uploaded_docs);
                DB::table('oem_update_profile_data')->insert([
                    'oem_id' => getParentId(),
                    'previous_info' => $existingProfileData,
                    'updated_info' => $updateProfileData,
                    'uploaded_docs' => json_encode($uploaded_docs),
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'status' => 'D'
                ]);
            });
            alert()->success('Data has been successfully Saved', 'Success')->persistent('Close');
            return redirect()->route('e-trucks.manageCompanyDetails.index');
        }catch(\Exception $ex){
            // dd($ex->getMessage());
            // errorMail($e, Auth::user()->id);
            alert()->error('Something went wrong!', 'Error')->persistent('Close');
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
        try{
            $details = DB::table('oem_update_profile_data')->find($id);
            // dd($details);
            $docs = DB::table('oem_update_profile_docs')->get();
            if($details->status == 'S') {
                //go into preview
                return view('truck.oem.user_details.manage_user_details_preview', compact('details', 'docs'));
            }
            return view('truck.oem.user_details.manage_user_details_edit', compact('details', 'docs'));
        }catch(\Exception $ex){
            // dd($ex->getMessage());
            // errorMail($e, Auth::user()->id);
            alert()->error('Something went wrong!', 'Error')->persistent('Close');
            return redirect()->back();
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
        try{
            // dd($request->all(), $id);
            DB::transaction(function() use ($request, $id){
                $exsiting = DB::table('oem_update_profile_data')->find($id);
                // dd($exsiting);

                //auth profile data
                $existingProfileData = json_encode([
                    'exist_cust_name' => $request->exist_cust_name,
                    'exist_cust_email' => $request->exist_cust_email,
                    'exist_cust_mobile' => $request->exist_cust_mobile,
                    'exist_cust_gst' => $request->exist_cust_gst,
                    'exist_cust_addr' => $request->exist_cust_addr,
                    'exist_cust_city' => $request->exist_cust_city,
                    'exist_cust_dist' => $request->exist_cust_dist,
                    'exist_cust_land' => $request->exist_cust_land,
                    'exist_cust_state' => $request->exist_cust_state,
                    'exist_cust_pincode' => $request->exist_cust_pincode,
                    'exist_auth_name' => $request->exist_auth_name,
                    'exist_auth_email' => $request->exist_auth_email,
                    'exist_auth_mobile' => $request->exist_auth_mobile,
                    'exist_auth_addr' => $request->exist_auth_addr,
                    'exist_auth_city' => $request->exist_auth_city,
                    'exist_auth_dist' => $request->exist_auth_dist,
                    'exist_auth_land' => $request->exist_auth_land,
                    'exist_auth_state' => $request->exist_auth_state,
                    'exist_auth_pincode' => $request->exist_auth_pincode
                ]);
                //profile data
                $updateProfileData = json_encode([
                    'cust_name' => $request->cust_name,
                    'cust_mail' => $request->cust_mail,
                    'cust_mobile' => $request->cust_mobile,
                    'cust_gst' => $request->cust_gst,
                    'cust_addr' => $request->cust_addr,
                    'cust_city' => $request->cust_city,
                    'cust_dist' => $request->cust_dist,
                    'cust_land' => $request->cust_land,
                    'cust_state' => $request->cust_state,
                    'cust_pincode' => $request->cust_pincode,
                    'auth_name' => $request->auth_name,
                    'auth_email' => $request->auth_email,
                    'auth_mobile' => $request->auth_mobile,
                    'auth_addr' => $request->auth_addr,
                    'auth_city' => $request->auth_city,
                    'auth_dist' => $request->auth_dist,
                    'auth_land' => $request->auth_land,
                    'auth_state' => $request->auth_state,
                    'auth_pincode' => $request->auth_pincode
                ]);
                // dd($request->all(), $request->files,Auth::user()->id, getParentId(), $authProfileData, $custProfileData);
                $exisitingDocs = json_decode($exsiting->uploaded_docs, true);

                
                //fetch all docs
                $docs = DB::table('oem_update_profile_docs')->get();
                
                $uploaded_docs = $exisitingDocs;
                //upload files
                foreach($docs as $doc){
                    if($request->hasFile($doc->file_name)) {
                        $file = $request->file($doc->file_name);
                        $response = uploadFileWithCurl($file);
                        $uploaded_reg_file = $response;
                        // $uploaded_reg_file = 3;
                        $uploaded_docs[$doc->file_name] = $uploaded_reg_file;
                    }
                }
                // dd($docs, $request->all(), $uploaded_docs, json_decode($updateProfileData, true),$updateProfileData);
                DB::table('oem_update_profile_data')->where('id', $id)->update([
                    // 'oem_id' => getParentId(),
                    'previous_info' => $existingProfileData,
                    'updated_info' => $updateProfileData,
                    'uploaded_docs' => json_encode($uploaded_docs),
                    // 'created_by' => Auth::user()->id,
                    'updated_at' => Carbon::now(),
                    // 'status' => 'D'
                ]);
            });
            alert()->success('Data has been updated Successfully', 'Success')->persistent('Close');
            return redirect()->back();
        }catch(\Exception $ex){
            // dd($ex->getMessage());
            // errorMail($e, Auth::user()->id);
            alert()->error('Something went wrong!', 'Error')->persistent('Close');
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

    public function submitToPma(Request $request)
    {
        try{
            // dd($request->all());
            DB::transaction(function() use ($request){
                $toUpdate = [];
                if(Auth::user()->hasRole('PMA')){
                    $action = 'A';
                    if($request->action == 'reject'){
                        $action = 'R';
                    }
                    $toUpdate = [
                        'pma_action_at' => Carbon::now(),
                        'pma_status' => $action,
                        'pma_action_by' => Auth::user()->id,
                        'pma_remark' => $request->remarks
                    ];

                    if($action == 'A'){
                        if($request->hasFile('appr_doc')) {
                            $file = $request->file('appr_doc');
                            $response = uploadFileWithCurl($file);
                            $uploaded_reg_file = $response;
                            // $uploaded_reg_file = 3;
                            $toUpdate['pma_approved_doc'] = $uploaded_reg_file;
                        }

                        $details_ome_update = DB::table('oem_update_profile_data')->find($request->row_id);
                        // dd($details_ome_update);
                        $user_id = $details_ome_update->oem_id;
                        $details_post_registration = DB::table('post_registration_detail')->where('user_id', $user_id)->first();
                        $details_user = DB::table('users')->find($user_id);

                        $updated_info = json_decode($details_ome_update->updated_info, true);
                        // post_registration_detail_update
                        // users_update
                        // dd($details_ome_update, $details_post_registration, $details_user, $updated_info);

                        //insert into user update
                        DB::table('users_update')->insert([
                            'user_id' => $details_user->id,
                            'name' => $details_user->name,
                            'email' => $details_user->email,
                            'mobile' => $details_user->mobile,
                            'address' => $details_user->address,
                            'pincode' => $details_user->pincode,
                            'state' => $details_user->state,
                            'district' => $details_user->district,
                            'landmark' => $details_user->landmark,
                            'city' => $details_user->city,
                            'auth_name' => $details_user->auth_name,
                            'auth_address' => $details_user->auth_address,
                            'auth_pincode' => $details_user->auth_pincode,
                            'auth_state' => $details_user->auth_state,
                            'auth_district' => $details_user->auth_district,
                            'auth_city' => $details_user->auth_city,
                            'auth_landmark' => $details_user->landmark,
                            'auth_mobile' => $details_user->auth_mobile,
                            'auth_email' => $details_user->auth_email,
                            'action_by' => Auth::user()->id,
                            'action_at' => Carbon::now()
                        ]);

                        //insert into post registration trail
                        DB::table('post_registration_detail_update')->insert([
                            'user_id' => $details_user->id,
                            'gstin_no' => $details_post_registration->gstin_no,
                            'action_by' => Auth::user()->id,
                            'action_at' => Carbon::now()
                        ]);

                        //update users table
                        DB::table('users')->where('id', $user_id)->update([
                            'name' => $updated_info['cust_name'],
                            'email' => $updated_info['cust_mail'],
                            'mobile' => $updated_info['cust_mobile'],
                            'address' => $updated_info['cust_addr'],
                            'pincode' => $updated_info['cust_pincode'],
                            'state' => $updated_info['cust_state'],
                            'district' => $updated_info['cust_dist'],
                            'landmark' => $updated_info['cust_land'],
                            'city' => $updated_info['cust_city'],
                            'auth_name' => $updated_info['auth_name'],
                            'auth_address' => $updated_info['auth_addr'],
                            'auth_pincode' => $updated_info['auth_pincode'],
                            'auth_state' => $updated_info['auth_state'],
                            'auth_district' => $updated_info['auth_dist'],
                            'auth_city' => $updated_info['auth_city'],
                            'auth_landmark' => $updated_info['auth_land'],
                            'auth_mobile' => $updated_info['auth_mobile'],
                            'auth_email' => $updated_info['auth_email'],
                            'old_name' => $details_user->name,
                        ]);

                        //update post registration
                        DB::table('post_registration_detail')->where('id', $details_post_registration->id)->update([
                            'gstin_no' => $updated_info['cust_gst']
                        ]);
                    }

                }
                else{
                    $toUpdate = [
                        'submited_at' => Carbon::now(),
                        'status' => 'S',
                        'pma_status' => 'P'
                    ];
                }
                DB::table('oem_update_profile_data')->where('id', $request->row_id)->update($toUpdate);
            });
            alert()->success('Data has been submitted successfully', 'Success')->persistent('Close');
            return redirect()->route('e-trucks.manageCompanyDetails.index');
        }
        catch(\Exception $ex){
            // dd($ex->getMessage());
            // errorMail($e, Auth::user()->id);
            alert()->error('Something went wrong!', 'Error')->persistent('Close');
            return redirect()->back();
        }

    }
}
