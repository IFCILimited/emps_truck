<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\User;
use App\Models\PostRegistrationDetail;
use App\Models\ManufacturingEVPlantDetail;
use Carbon\Carbon;
use App\Models\OEMType;
use UxWeb\SweetAlert\SweetAlert;
use App\Notifications\UserApprovalNotification;
use App\Notifications\UserRejectionNotification;
use App\Notifications\PostRegistrationApprovedNotification;
use App\Notifications\PostRegistrationRejectedNotification;



class ManageOemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $status = null;
            // $preUser = User::whereNotNull('oem_type_id')
            //     ->orderBy("approval_for_post_reg", "desc")
            //     ->orderBy("created_at", "desc")
            //     ->get();

            $preUser = User::whereNotNull('oem_type_id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.id', 4)
            ->where('users.parent_id', null) 
            ->orderBy('users.approval_for_post_reg', 'desc')
            ->orderBy('users.created_at', 'desc')
            ->select('users.*')
            ->get();
            $oemType = OEMType::get();
            return view('admin.oem_registration', compact('preUser', 'oemType','status'));
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function preRegister($status) {

        try {
            
            if($status == 'all'){
                return redirect('oemRegistration');
            }
            elseif($status == 'P'){
                // $preUser = User::whereNotNull('oem_type_id')
                // ->orderBy("approval_for_post_reg", "desc")
                // ->orderBy("created_at", "desc")
                // ->where('approval_for_post_reg',null)
                // ->get();
                $preUser = User::whereNotNull('oem_type_id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('roles.id', 4)
                ->where('users.parent_id', null) 
                ->where('users.approval_for_post_reg',null)
                ->orderBy('users.approval_for_post_reg', 'desc')
                ->orderBy('users.created_at', 'desc')
                ->select('users.*')
                ->get();
            }
            else{

                $preUser = User::whereNotNull('oem_type_id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('roles.id', 4)
                ->where('users.parent_id', null) 
                ->where('users.approval_for_post_reg',$status)
                ->orderBy('users.approval_for_post_reg', 'desc')
                ->orderBy('users.created_at', 'desc')
                ->select('users.*')
                ->get();
            }
            $oemType = OEMType::get();
            return view('admin.oem_registration', compact('preUser', 'oemType','status'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

            $user = User::where('id', $id)->first();
            $oemType = OEMType::get();
            return view('admin.preRegisterView', compact('user', 'oemType'));
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
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
        try {
            $user = User::where('id', $id)->first();

            $postRegDetail = PostRegistrationDetail::where('user_id', $id)->first();
            $manufacturing = ManufacturingEVPlantDetail::where('user_id', $id)->get();
            $oemType = OEMType::get();
            return view('admin.postRegisterView', compact('user', 'postRegDetail', 'manufacturing', 'oemType'));
        } catch (\Exception $e) {
            //errorMail($e, Auth::user()->id);
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
        // dd($request);
        try {
            $user = User::find($id);
            if ($user) {
               

                 $user->post_registration_status = $request->status;
                 $user->post_registration_action_by = Auth::user()->id;
                 $user->post_registration_remark = isset($request->mhi_remarks) ? $request->mhi_remarks : '';
                 $user->post_registration_at = Carbon::now();
                 
         

         if ($request->status == 'C') {

            if ($request->hasFile('approve_doc')) {

                $file = $request->approve_doc;
                $response = uploadFileWithCurl($file);

            }
            $user->recommended_by = Auth::user()->id;
            $user->recommended_at = Carbon::now();
            $user->approval_doc_id = $request->hasFile('approve_doc') ? $response : null;
            $user->e_office_noting_no = $request->e_office_noting_no;
            $user->e_office_computer_no = $request->e_office_computer_no;
            $user->post_approval_date = $request->approve_doc_date;
            $user->declaration = $request->declaration;

            $dsUsers = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.id', 10)
            ->first();
            // dd($dsUsers);
                // dd(1);
                $to = $dsUsers->email;
                $cc =  ['emps-2024@ifciltd.com'];
                $bcc = ['ajaharuddin.ansari@ifciltd.com'];
                $subject='Your registration process has been initiated';
                
                $msg=view('emails.post_registration_recomended_by_ds', ['user' => $dsUsers])->render();
                $send = sendMail($to,$cc,$bcc,$subject,$msg);
                // dd($response);
                alert()->success('Post Registration Successfully Recommended.', 'Success')->persistent('Close');
            } 
            elseif($request->status == 'A'){
                $dsUsers = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('roles.id', 11)
                ->first();
                $to = $user->email;
                $cc =  ['emps-2024@ifciltd.com',$dsUsers->email];
                $bcc = ['ajaharuddin.ansari@ifciltd.com'];
                $subject='Your post-registration approved';
                
                $msg=view('emails.postapprovalreject', ['user' => $user])->render();
                $send = sendMail($to,$cc,$bcc,$subject,$msg);
                // dd($response);
                alert()->success('Post Registration Successfully Approved.', 'Success')->persistent('Close');
            }
            else {
                $dsUsers = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('roles.id', 11)
                ->first();
                // dd(2);
                $to = $user->email;
                $cc =  ['emps-2024@ifciltd.com',$dsUsers->email];
                $bcc = ['ajaharuddin.ansari@ifciltd.com'];
                $subject='Your post-registration rejected';
                
                $msg=view('emails.postapprovalreject', ['user' => $user])->render();
                $send = sendMail($to,$cc,$bcc,$subject,$msg);
                alert()->success('Post Registration Rejected', 'Success')->persistent('Close');
            }
            $user->save();
        }
            
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
  alert()->error('Something Went Wrong', 'Danger')->persistent('Close');
           //errorMail($e, Auth::user()->id);           
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

    public function oemPostRegistration()
    {
        try {
            $status = null;
            $user = DB::table('users')
                ->join('post_registration_detail', 'post_registration_detail.user_id', '=', 'users.id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('approval_for_post_reg', 'A')
                ->where('roles.id', 4)
                ->whereNotNull('oem_type_id')
                ->orderBy("post_registration_status", "desc")
                ->orderBy("post_registration_at", "ASC")->get(['users.*']);

            $approved_by = User::get();
            return view('admin.oem_postRegistration', compact('user', 'approved_by','status'));
        } catch (\Exception $e) {
 alert()->error('Something Went Wrong', 'Danger')->persistent('Close');
            //errorMail($e, Auth::user()->id);           
 return redirect()->back();
        }
    }

    public function postRegister($status)  {
        try {
            if($status == 'all'){
                return redirect('oemPostRegistration');
            }
            elseif($status == 'P'){
                $user = DB::table('users')->join('post_registration_detail', 'post_registration_detail.user_id', '=', 'users.id')
                ->where('approval_for_post_reg', 'A')
                ->where('post_registration_status',null)
                ->whereNotNull('oem_type_id')
                ->orderBy("post_registration_status", "desc")
                ->orderBy("post_registration_at", "ASC")->get(['users.*']);
            }
            elseif($status == 'R'){
                $user = DB::table('users')->join('post_registration_detail', 'post_registration_detail.user_id', '=', 'users.id')
                ->where('approval_for_post_reg', 'A')
                ->whereIn('post_registration_status',['A','C'])
                ->whereNotNull('oem_type_id')
                ->orderBy("post_registration_status", "desc")
                ->orderBy("post_registration_at", "ASC")->get(['users.*']);
            }
            else{

            

            $user = DB::table('users')->join('post_registration_detail', 'post_registration_detail.user_id', '=', 'users.id')
                ->where('approval_for_post_reg', 'A')
                ->where('post_registration_status',$status)
                ->whereNotNull('oem_type_id')
                ->orderBy("post_registration_status", "desc")
                ->orderBy("post_registration_at", "ASC")->get(['users.*']);

            }

            $approved_by = User::get();
            return view('admin.oem_postRegistration', compact('user', 'approved_by','status'));
        } catch (\Exception $e) {
 alert()->error('Something Went Wrong', 'Danger')->persistent('Close');
            errorMail($e, Auth::user()->id);           
 return redirect()->back();
        }
    }
    

    public function PreApproveReject(Request $request)
    {
        try {
            $user = User::find($request->oem_id);
            if ($user) {
                $user->isapproved = 'Y';
                $user->approval_for_post_reg = $request->status;
                $user->approval_by = Auth::user()->id;
                $user->approval_remark = isset($request->mhi_remarks) ? $request->mhi_remarks : '';
                $user->approval_at = Carbon::now();
                $user->save();
            }

            if ($request->status == 'A') {
                // $user->notify(new UserApprovalNotification($user));
                // $to = $user->email;
                // $cc= '';
                // $bcc='';
                // $subject='Your account has been approved';
                // $from = 'noreply.pmedrive@heavyindustry.gov.in';
                // // $msg= $user->notify(new UserApprovalNotification($user));
                // $msg=view('emails.prepostapproval', ['user' => $user])->render();

                // $to = 'jajaved88@gmail.com';
                // $cc= '';
                $to = $user->email;
                $cc= ['emps-2024@ifciltd.com'];
                $bcc=['ajaharuddin.ansari@ifciltd.com'];
                $subject='Your pre-registration approved';
                // $from = 'noreply.pmedrive@heavyindustry.gov.in';
                $msg=view('emails.pre_registration_approve_dsto_oem', ['user' => $user])->render();
                $send = sendMail($to,$cc,$bcc,$subject,$msg);
                // dd($send);

            // $response = sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);
                alert()->success('Pre-Registration Successfully Approved', 'Success')->persistent('Close');
            } elseif ($request->status == 'R') {
                // $user->notify(new UserRejectionNotification($user, $request->mhi_remarks));

                // $to = $user->email;
                // $cc= '';
                // $bcc='';
                // $subject='Your account has been Rejected';
                // $from = 'noreply.pmedrive@heavyindustry.gov.in';
                // // $msg= $user->notify(new UserApprovalNotification($user));
                // $msg=view('emails.prepostapproval', ['user' => $user])->render();
                $to = $user->email;
                $cc= ['emps-2024@ifciltd.com'];
                $bcc=['ajaharuddin.ansari@ifciltd.com'];
                $subject='Your pre-registration rejected';
                // $from = 'noreply.pmedrive@heavyindustry.gov.in';
                $msg=view('emails.pre_registration_rejection_dsto_oem', ['user' => $user])->render();
                $send = sendMail($to,$cc,$bcc,$subject,$msg);
// dd($send);
                // $response = sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);
                alert()->success('Pre-Registration Successfully Rejected', 'Success')->persistent('Close');
            }
            
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e);
 alert()->error('Something Went Wrong', 'Danger')->persistent('Close');
            // errorMail($e, Auth::user()->id);           
 return redirect()->back();
        }
    }

    public function oemDetails()
    {
        ini_set('memory_limit', '7048M');
        ini_set('max_execution_time', 7600);
        try {
            $user = DB::table('users')->join('post_registration_detail', 'post_registration_detail.user_id', '=', 'users.id')
                ->where('approval_for_post_reg', 'A')
                ->whereNotNull('oem_type_id')
                ->orderBy("post_registration_status", "desc")
                ->orderBy("post_registration_at", "ASC")->get(['users.*']);

            $approved_by = User::get();
            return view('pma.oemDetails', compact('user', 'approved_by'));
        } catch (\Exception $e) {
            //errorMail($e, Auth::user()->id);
 alert()->error('Something Went Wrong', 'Danger')->persistent('Close');
            
return redirect()->back();
        }
    }

    public function modelDetails($colunm = null, $order = null)
    {
        try {
        //   dd($colunm, $order);
            
        //   if ($colunm != null && $order != null && in_array($order, ['approved', 'pending', 'rejected'])) {
        //         if($order == 'approved') {
        //             $orders = 'A';
        //         }
        //         elseif($order == 'pending') {
        //             $orders = null;
        //         }
        //         elseif($order == 'rejected') {
        //             $orders = 'R';
        //         }
        //         $models = DB::table('vw_model_details')->where($colunm, $orders)->get();
        //     }
        //     elseif ($colunm != null && $order != null && in_array($order, ['asc', 'desc'])) {
        //         $models = DB::table('vw_model_details')->where('testing_flag', 'A')->orderBy($colunm, $order)->get();
        //     }
        //     else {
                $models = DB::table('vw_model_details')->where('testing_flag', 'A')
                // ->whereIn('model_detail_id',[1294,1293, 1291, 1292, 1295])
                ->orderBy('testing_created_at', 'DESC')->get();
            // }

            
            $users = DB::table('users as u')
            ->join('model_has_roles as mhr', 'u.id', '=', 'mhr.model_id')
            ->join('roles as r', 'mhr.role_id', '=', 'r.id')
            ->select('u.*') 
            ->whereIn('r.id',['10','11', '8'])
            ->get();
            
            // dd($users);

            return view('pma.modelDetails', compact('models', 'colunm', 'order','users'));
        } catch (\Exception $e) {
            //errorMail($e, Auth::user()->id); 
            // dd($e);
 alert()->error('Something Went Wrong', 'Danger')->persistent('Close');
           
return redirect()->back();
        }
    }

    public function modelShow($id)
    {
        try {
            $id = decrypt($id);
            $model = DB::table('vw_model_details')->where('model_detail_id', $id)->first();
            $testing_agency_name = User::where('id', $model->testing_agency_id)->select('name')->first();
            return view('pma.modelShow', compact('id', 'model','testing_agency_name'));
        }  catch (\Illuminate\Database\QueryException $e) {
            $errorMessage = "Database error: " . $e->getMessage();
            if ($e->errorInfo[1] == 1062) { // Unique constraint violation
                $errorMessage = "A record with the same value already exists.";
            }
            alert()->warning('Something Went Wrong: ' . $errorMessage, 'Danger')->persistent('Close');
            return redirect()->route('manageDealer.index')->withErrors(['error' => $errorMessage]);
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error('An error occurred: ' . $e->getMessage());
    
            // Display an alert with the error message
            alert()->warning('Something Went Wrong: ' . $e->getMessage(), 'Danger')->persistent('Close');
    
            // Redirect to a specific route
            return redirect()->route('manageDealer.index');
        }
    }

}
