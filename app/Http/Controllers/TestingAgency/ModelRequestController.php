<?php

namespace App\Http\Controllers\TestingAgency;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\OemModelMaster;
use App\Models\OemModelDetail;
use App\Models\DocumentUpload;
use Exception;
use Carbon\Carbon;

class ModelRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // dd(Auth::user()->parent_id,session('parent_user'));
        try{
            $parentUser = session('parent_user') != null ? session('parent_user'): null;

            if($parentUser != null){


            if(Auth::user()->parent_id == $parentUser->id){
                $pid = Auth::user()->parent_id;
            }else{
                $pid = Auth::user()->id;
            }
        }else{
            $pid = Auth::user()->id;
        }
        $models = DB::table("model_master as mm")
                ->join('oem_model_details as omd', 'mm.id', '=', 'omd.model_id')
                ->join('users as u', 'u.id', '=', 'mm.oem_id')
                ->join('segment_master as sm', 'sm.id', '=', 'mm.segment_id')
                ->join('category_master as cm', 'cm.id', '=', 'mm.vehicle_cat_id')
                ->where('omd.testing_agency_id', $pid)
                ->where('omd.status', 'S')
                ->select('u.name', 'mm.*', 'omd.*', 'sm.segment_name', 'cm.category_name')
                ->orderBy('omd.id','DESC')
                ->get();
            //  dd($models);
        return view('testingagency.modelRequests', compact('models'));
    } catch (\Exception $e) {
        // dd($e);
        errorMail($e, Auth::user()->id);
        return redirect()->back();
    }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        try{
        $id = decrypt($id);

        $parentUser = session('parent_user') != null ? session('parent_user'): null;

        if($parentUser != null){


        if(Auth::user()->parent_id == $parentUser->id){
            $pid = Auth::user()->parent_id;
        }else{
            $pid = Auth::user()->id;
        }
    }else{
        $pid = Auth::user()->id;
    }



        $model = DB::table('vw_model_details')->where('model_detail_id', $id)->where('testing_agency_id', $pid)->first();
        $testing_agency_name = Auth::user()->name;
        // dd($model);
        return view('testingagency.modelVerification', compact('model','testing_agency_name'));
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

     public function modelPreview(Request $request) {


        try{
            $id = $request->mid;

            $parentUser = session('parent_user') != null ? session('parent_user'): null;

            if($parentUser != null){


            if(Auth::user()->parent_id == $parentUser->id){
                $pid = Auth::user()->parent_id;
            }else{
                $pid = Auth::user()->id;
            }
        }else{
            $pid = Auth::user()->id;
        }
        if ($request->hasFile('certificate')) {

            $file = $request->certificate;
            $response = uploadFileWithCurl($file);
            $modelDoc_id = $response;

            if ($request->hasFile('cmvr_certificate')) {
                $file = $request->cmvr_certificate;
                $response = uploadFileWithCurl($file);
                $cmvrid = $response;

            }

            if ($request->hasFile('assessment_report')) {
                $file = $request->assessment_report;
                $response = uploadFileWithCurl($file);
                $assessment_id = $response;

            }
        }

            $model = DB::table('vw_model_details')->where('model_detail_id', $id)->where('testing_agency_id', $pid)->first();
            $testing_agency_name = Auth::user()->name;
            // dd($model);
            return view('testingagency.modelPreview', compact('model','testing_agency_name','request','modelDoc_id','cmvrid','assessment_id'));
        } catch (\Exception $e) {
            // errorMail($e, Auth::user()->id);
            // dd($e);
            alert()->warning('Please check all input fields','Warning')->persistent('Close');
            return redirect()->back();
        }


     }
    public function store(Request $request)
    {
        if($request->input('fullRequest') !=  null){

            $request = json_decode($request->input('fullRequest'), true);
            // dd($request,1);
        }
      

       
    // Now you can access the original request data
    // dd($fullRequest,$request); // Debug to check the data
        try {
            DB::transaction(function () use ($request) {

                $parentUser = session('parent_user') != null ? session('parent_user'): null;

            if($parentUser != null){


            if(Auth::user()->parent_id == $parentUser->id){
                $pid = Auth::user()->parent_id;
            }else{
                $pid = Auth::user()->id;
            }
        }else{
            $pid = Auth::user()->id;
        }
        $modelDoc_id = $request->modelDoc_id;
        $cmvrid = $request->cmvrid;
        $assessment_id = $request->assessment_id;
                // if ($request->hasFile('certificate')) {

                //         $file = $request->certificate;
                //         $response = uploadFileWithCurl($file);
                //         $modelDoc_id = $response;

                //         if ($request->hasFile('cmvr_certificate')) {
                //             $file = $request->cmvr_certificate;
                //             $response = uploadFileWithCurl($file);
                //             $cmvrid = $response;

                //         }

                //         if ($request->hasFile('assessment_report')) {
                //             $file = $request->assessment_report;
                //             $response = uploadFileWithCurl($file);
                //             $assessment_id = $response;

                //         }

                    $model = OemModelDetail::find($request->mid);
                    $model->testing_factory_price = $request->factory_price;
                    $model->testing_spec_density = $request->spec_density;
                    $model->testing_life_cyc = $request->life_cyc;
                    $model->testing_min_ex_show_price = $request->min_ex_show_price;
                    $model->testing_range = $request->range;
                    $model->testing_max_elect_consumption = $request->max_elect_consumption;
                    $model->testing_min_max_speed = $request->min_max_speed;
                    $model->testing_min_acceleration = $request->min_acceleration;
                    $model->testing_meeting_tech_function = $request->meeting_tech_function;
                    $model->testing_meeting_qualif = $request->meeting_qualif;
                    $model->testing_vehicle_sub_to_test_agency_apprv = $request->vehicle_sub_to_test_agency_apprv;
                    $model->testing_doc_id = $modelDoc_id;
                    $model->testing_cmvr_doc_id = $cmvrid;
                    $model->testing_certificate_no = $request->certificate_no;
                    $model->testing_cmvr_date = $request->cmvr_date;
                    $model->testing_approval_date = $request->approval_date;
                    $model->testing_valid_date = $request->valid_date;

                    $model->testing_expiry_date = $request->expiry_date;
                    // $model->empscertificatefrom = $request->empscertificatefrom;
                    // $model->empscertificateto = $request->empscertificateto;
                    $model->pmp_compliance = $request->pmp_compliance;
                    // $model->inspection_officer = $request->inspection_officer;
                    // $model->approval_officer = $request->approval_officer;
                    // $model->supplier_list = $request->supplier_list;
                    $model->warranty_check = $request->warranty_check;
                    // $model->strip_down_analysis = $request->strip_down_analysis;

                    //$model->testing_by = $pid;
                    $model->testing_flag = $request->status;
                    $model->testing_created_at = Carbon::now()->format('Y-m-d');
                    $model->assessment_report_id = $assessment_id;
                    $model->testing_estimate_incentive_amount = $request->testing_estimate_incentive_amount;
                    $model->save();

        if($request->status == 'A'){
                    $ta_name = DB::table('users')->where('id',$model->testing_agency_id)->first();
                    $oem = DB::table('users')->where('id',$model->oem_id)->first();
                    $detail = DB::table('vw_model_details')->where('model_detail_id',$request->mid)->first();
            if($detail->segment_id == 1){
                $em = DB::table('users')->where('id',194)->first()->email;

                    $to = $em;
                }
                elseif($detail->segment_id == 2){
                    $em = DB::table('users')->where('id',200)->first()->email;
                $to = $em;

            }
                    $cc =  [$oem->email,$ta_name->email,'emps-2024@ifciltd.com'];
                    $bcc = ['ajaharuddin.ansari@ifciltd.com'];
                    $subject = 'Model Approved by Testing Agency';
                    $body = view('emails.model_approve_by_ta', ['user' => $ta_name,'oem'=>  $oem,  'detail'=>$detail])->render();
        
                    $send = sendMail($to,$cc,$bcc,$subject,$body);
        }
                if ($request->status == 'R') {

                    // dd('aa');
                    $modelReject = OemModelDetail::find($request->mid);
                    $modelReject->testing_flag = $request->status;
                    $modelReject->testing_remarks = $request->remarks;
                   // $modelReject->testing_by = $pid;
                    $modelReject->testing_created_at = Carbon::now()->format('Y-m-d');
                    $modelReject->save();


                    $ta_name = DB::table('users')->where('id',$modelReject->testing_agency_id)->first();
                    $oem = DB::table('users')->where('id',$modelReject->oem_id)->first();
                    $detail = DB::table('vw_model_details')->where('model_detail_id',$request->mid)->first();

                    $to = $oem->email;
                    $cc =  ['emps-2024@ifciltd.com'];
                    $bcc = ['ajaharuddin.ansari@ifciltd.com'];
                    $subject = 'Model Rejected by Testing Agency';
                    $body = view('emails.model_rejected_by_ta', ['user' => $ta_name, 'detail'=>$oem, 'model'=>$detail])->render();
        
                    $send = sendMail($to,$cc,$bcc,$subject,$body);

                    alert()->success('Successfully Rejected.','Success')->persistent('Close');
                }elseif ($request->status == 'A'){
                    alert()->success('Successfully Approved.','Success')->persistent('Close');
                }

            });

            return redirect()->route('modelRequests.index');
        } catch (\Exception $e) {
            // dd($e);
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
            $parentUser = session('parent_user') != null ? session('parent_user'): null;

            if($parentUser != null){


            if(Auth::user()->parent_id == $parentUser->id){
                $pid = Auth::user()->parent_id;
            }else{
                $pid = Auth::user()->id;
            }
        }else{
            $pid = Auth::user()->id;
        }
        $id = decrypt($id);
        if(Auth::user()->hasRole('TESTINGAGENCY')){
        $model = DB::table('vw_model_details')->where('model_detail_id', $id)->where('testing_agency_id', $pid)->first();
        $testing_agency_name = Auth::user()->name;
        }
        elseif(Auth::user()->hasRole('PMA')){
            $model = DB::table('vw_model_details')->where('model_detail_id', $id)->first();
            $testing_agency_name = DB::table('users')->where('id',$model->testing_agency_id)->first()->name;
        }
        elseif(Auth::user()->hasRole('MHI-DS|MHI-AS|MHI|MHI-OnlyView')){
            $model = DB::table('vw_model_details')->where('model_detail_id', $id)->where('testing_flag', 'A')->first();
            $testing_agency_name = DB::table('users')->where('id',$model->testing_agency_id)->first()->name;
        }

        return view('testingagency.modelVerificationShow', compact('id', 'model','testing_agency_name'));
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

    public function modelRevert(Request $request)
    {

        $model = DB::table('oem_model_details')->where('id', $request->mid)->first();

        try {
            DB::transaction(function () use ($model, $request) {



                DB::table('oem_model_details_auditor')->insert([
                    'oem_model_details_id' => $model->id,
                    'oem_id' => $model->oem_id,
                    'model_id' => $model->model_id,
                    'status' => $model->status,
                    'model_type' => $model->model_type,
                    'compliance_upload_id' => $model->compliance_upload_id,
                    'testing_agency_id' => $model->testing_agency_id,
                    'meeting_tech_function' => $model->meeting_tech_function,
                    'meeting_qualif' => $model->meeting_qualif,
                    'vehicle_sub_to_test_agency_apprv' => $model->vehicle_sub_to_test_agency_apprv,
                    'tech_type' => $model->tech_type,
                    'battery_type' => $model->battery_type,
                    'factory_price' => $model->factory_price,
                    'spec_density' => $model->spec_density,
                    'life_cyc' => $model->life_cyc,
                    'no_of_battery' => $model->no_of_battery,
                    'bat_1' => $model->bat_1,
                    'bat_2' => $model->bat_2,
                    'bat_3' => $model->bat_3,
                    'bat_4' => $model->bat_4,
                    'bat_5' => $model->bat_5,
                    'bat_6' => $model->bat_6,
                    'bat_7' => $model->bat_7,
                    'bat_8' => $model->bat_8,
                    'bat_9' => $model->bat_9,
                    'bat_10' => $model->bat_10,
                    'tot_energy' => $model->tot_energy,
                    'battery_make' => $model->battery_make,
                    'battery_capacity' => $model->battery_capacity,
                    'range' => $model->range,
                    'max_elect_consumption' => $model->max_elect_consumption,
                    'min_max_speed' => $model->min_max_speed,
                    'min_acceleration' => $model->min_acceleration,
                    'monitoring_device_fitment' => $model->monitoring_device_fitment,
                    'company_name' => $model->company_name,
                    'device_id' => $model->device_id,
                    'min_ex_show_price' => $model->min_ex_show_price,
                    'estimate_incentive_amount' => $model->estimate_incentive_amount,
                    'created_at' => $model->created_at,
                    'updated_at' => $model->updated_at,
                    'submitted_at' => $model->submitted_at,
                    'testing_factory_price' => $model->testing_factory_price,
                    'testing_spec_density' => $model->testing_spec_density,
                    'testing_life_cyc' => $model->testing_life_cyc,
                    'testing_min_ex_show_price' => $model->testing_min_ex_show_price,
                    'testing_range' => $model->testing_range,
                    'testing_max_elect_consumption' => $model->testing_max_elect_consumption,
                    'testing_min_max_speed' => $model->testing_min_max_speed,
                    'testing_min_acceleration' => $model->testing_min_acceleration,
                    'testing_meeting_tech_function' => $model->testing_meeting_tech_function,
                    'testing_meeting_qualif' => $model->testing_meeting_qualif,
                    'testing_vehicle_sub_to_test_agency_apprv' => $model->testing_vehicle_sub_to_test_agency_apprv,
                    'testing_doc_id' => $model->testing_doc_id,
                    'testing_certificate_no' => $model->testing_certificate_no,
                    'testing_cmvr_date' => $model->testing_cmvr_date,
                    'testing_approval_date' => $model->testing_approval_date,
                    'testing_expiry_date' => $model->testing_expiry_date,
                    'testing_status' => $model->testing_status,
                    'testing_flag' => $model->testing_flag,
                    'testing_remarks' => $model->testing_remarks,
                    'testing_id' => $model->testing_id,
                    'testing_created_at' => $model->testing_created_at,
                    'testing_submitted_at' => $model->testing_submitted_at,
                    'mhi_flag' => $model->mhi_flag,
                    'mhi_remarks' => $model->mhi_remarks,
                    'mhi_id' => $model->mhi_id,
                    'mhi_created_at' => $model->mhi_created_at,
                    'mhi_submitted_at' => $model->mhi_submitted_at,
                    'empscertificatefrom' => $model->empscertificatefrom,
                    'empscertificateto' => $model->empscertificateto,
                    'pmp_compliance' => $model->pmp_compliance,
                    'inspection_officer' => $model->inspection_officer,
                    'approval_officer' => $model->approval_officer,
                    'supplier_list' => $model->supplier_list,
                    'warranty_check' => $model->warranty_check,
                    'strip_down_analysis' => $model->strip_down_analysis,
                    'warranty_period_indicate' => $model->warranty_period_indicate,
                    'warranty_period_from' => $model->warranty_period_from,
                    'warranty_period_to' => $model->warranty_period_to,
                    'child_id' => $model->child_id,
                    'testing_cmvr_doc_id' => $model->testing_cmvr_doc_id,
                    'category_type' => $model->category_type,
                    'mhi_noting_appr_date' => $model->mhi_noting_appr_date,
                    'pma_status' => $model->pma_status,
                    'pma_remarks' => $model->pma_remarks,
                    'pma_revert_status' => $model->pma_revert_status,
                    'pma_revert_remarks' => $model->pma_revert_remarks,
                    'pma_revert_created_by' => Auth::user()->id,
                    'pma_revert_created_at' => now(),
                    'pma_revert_updated_at' => now(),


                ]);

                DB::table('oem_model_details')->where('id', $model->id)->update([
                    'testing_flag' => 'D',
                    'pma_status' => null,
                    'pma_remarks' => null,
                    'pma_revert_status' => 'R',
                    'pma_revert_remarks' => $request->pma_revert_remarks,
                    'pma_revert_created_by' => Auth::user()->id,
                    'pma_revert_created_at' => now(),
                    'pma_revert_updated_at' => now(),
                ]);

                alert()->success('Successfully Reverted.','Success')->persistent('Close');

            });

            return redirect()->route('manageOEMApproval.index');

            } catch (\Exception $e) {
                // dd($e);
                return redirect()->back();
            }
    }

    public function modelRevertMHI(Request $request)
    {
 
        $model = DB::table('oem_model_details')->where('id', $request->mid)->first();
 
        try {
            DB::transaction(function () use ($model, $request) {
 
 
 
                DB::table('oem_model_details_auditor')->insert([
                    'oem_model_details_id' => $model->id,
                    'oem_id' => $model->oem_id,
                    'model_id' => $model->model_id,
                    'status' => $model->status,
                    'model_type' => $model->model_type,
                    'compliance_upload_id' => $model->compliance_upload_id,
                    'testing_agency_id' => $model->testing_agency_id,
                    'meeting_tech_function' => $model->meeting_tech_function,
                    'meeting_qualif' => $model->meeting_qualif,
                    'vehicle_sub_to_test_agency_apprv' => $model->vehicle_sub_to_test_agency_apprv,
                    'tech_type' => $model->tech_type,
                    'battery_type' => $model->battery_type,
                    'factory_price' => $model->factory_price,
                    'spec_density' => $model->spec_density,
                    'life_cyc' => $model->life_cyc,
                    'no_of_battery' => $model->no_of_battery,
                    'bat_1' => $model->bat_1,
                    'bat_2' => $model->bat_2,
                    'bat_3' => $model->bat_3,
                    'bat_4' => $model->bat_4,
                    'bat_5' => $model->bat_5,
                    'bat_6' => $model->bat_6,
                    'bat_7' => $model->bat_7,
                    'bat_8' => $model->bat_8,
                    'bat_9' => $model->bat_9,
                    'bat_10' => $model->bat_10,
                    'tot_energy' => $model->tot_energy,
                    'battery_make' => $model->battery_make,
                    'battery_capacity' => $model->battery_capacity,
                    'range' => $model->range,
                    'max_elect_consumption' => $model->max_elect_consumption,
                    'min_max_speed' => $model->min_max_speed,
                    'min_acceleration' => $model->min_acceleration,
                    'monitoring_device_fitment' => $model->monitoring_device_fitment,
                    'company_name' => $model->company_name,
                    'device_id' => $model->device_id,
                    'min_ex_show_price' => $model->min_ex_show_price,
                    'estimate_incentive_amount' => $model->estimate_incentive_amount,
                    'created_at' => $model->created_at,
                    'updated_at' => $model->updated_at,
                    'submitted_at' => $model->submitted_at,
                    'testing_factory_price' => $model->testing_factory_price,
                    'testing_spec_density' => $model->testing_spec_density,
                    'testing_life_cyc' => $model->testing_life_cyc,
                    'testing_min_ex_show_price' => $model->testing_min_ex_show_price,
                    'testing_range' => $model->testing_range,
                    'testing_max_elect_consumption' => $model->testing_max_elect_consumption,
                    'testing_min_max_speed' => $model->testing_min_max_speed,
                    'testing_min_acceleration' => $model->testing_min_acceleration,
                    'testing_meeting_tech_function' => $model->testing_meeting_tech_function,
                    'testing_meeting_qualif' => $model->testing_meeting_qualif,
                    'testing_vehicle_sub_to_test_agency_apprv' => $model->testing_vehicle_sub_to_test_agency_apprv,
                    'testing_doc_id' => $model->testing_doc_id,
                    'testing_certificate_no' => $model->testing_certificate_no,
                    'testing_cmvr_date' => $model->testing_cmvr_date,
                    'testing_approval_date' => $model->testing_approval_date,
                    'testing_expiry_date' => $model->testing_expiry_date,
                    'testing_status' => $model->testing_status,
                    'testing_flag' => $model->testing_flag,
                    'testing_remarks' => $model->testing_remarks,
                    'testing_id' => $model->testing_id,
                    'testing_created_at' => $model->testing_created_at,
                    'testing_submitted_at' => $model->testing_submitted_at,
                    'mhi_flag' => $model->mhi_flag,
                    'mhi_remarks' => $model->mhi_remarks,
                    'mhi_id' => $model->mhi_id,
                    'mhi_created_at' => $model->mhi_created_at,
                    'mhi_submitted_at' => $model->mhi_submitted_at,
                    'empscertificatefrom' => $model->empscertificatefrom,
                    'empscertificateto' => $model->empscertificateto,
                    'pmp_compliance' => $model->pmp_compliance,
                    'inspection_officer' => $model->inspection_officer,
                    'approval_officer' => $model->approval_officer,
                    'supplier_list' => $model->supplier_list,
                    'warranty_check' => $model->warranty_check,
                    'strip_down_analysis' => $model->strip_down_analysis,
                    'warranty_period_indicate' => $model->warranty_period_indicate,
                    'warranty_period_from' => $model->warranty_period_from,
                    'warranty_period_to' => $model->warranty_period_to,
                    'child_id' => $model->child_id,
                    'testing_cmvr_doc_id' => $model->testing_cmvr_doc_id,
                    'category_type' => $model->category_type,
                    'mhi_noting_appr_date' => $model->mhi_noting_appr_date,
                    'pma_status' => $model->pma_status,
                    'pma_remarks' => $model->pma_remarks,
                    'pma_revert_status' => $model->pma_revert_status,
                    'pma_revert_remarks' => $model->pma_revert_remarks,
                    'pma_revert_created_by' => Auth::user()->id,
                    'pma_revert_created_at' => now(),
                    'pma_revert_updated_at' => now(),
                    'mhi_revert_status' => $model->mhi_revert_status,
                    'mhi_revert_remarks' => $model->mhi_revert_remarks,
                    'mhi_revert_created_by' => Auth::user()->id,
                    'mhi_revert_created_at' => now(),
                    'mhi_revert_updated_at' => now(),
 
 
                ]);
 
                DB::table('oem_model_details')->where('id', $model->id)->update([
                    'pma_status' => null,
                    'pma_remarks' => null,
                    'mhi_flag' => null,
                    'mhi_revert_status' => 'R',
                    'mhi_revert_remarks' => $request->mhi_revert_remarks,
                    'mhi_revert_created_by' => Auth::user()->id,
                    'mhi_revert_created_at' => now(),
                    'mhi_revert_updated_at' => now(),
                ]);
 
                alert()->success('Successfully Reverted.','Success')->persistent('Close');
 
            });
 
            return redirect()->route('manageOEMApproval.index');
 
            } catch (\Exception $e) {
                // dd($e);
                return redirect()->back();
            }
    }

 public function modelChart($id)
    {
        try{
            $parentUser = session('parent_user') != null ? session('parent_user'): null;
 
            if($parentUser != null){
 
 
            if(Auth::user()->parent_id == $parentUser->id){
                $pid = Auth::user()->parent_id;
            }else{
                $pid = Auth::user()->id;
            }
        }else{
            $pid = Auth::user()->id;
        }
        $id = decrypt($id);
 
        $model = DB::table('vw_model_details')->where('model_detail_id', $id)->first();
        $testing_agency_name = DB::table('users')->where('id',$model->testing_agency_id)->first()->name;
 
        return view('testingagency.modelVerificationShow', compact('id', 'model','testing_agency_name'));
    } catch (\Exception $e) {
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
