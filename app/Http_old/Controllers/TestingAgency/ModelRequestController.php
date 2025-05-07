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
    public function store(Request $request)
    {
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

                if ($request->hasFile('certificate')) {

                        $file = $request->certificate;
                        $response = uploadFileWithCurl($file);
                        $modelDoc_id = $response;

                        if ($request->hasFile('cmvr_certificate')) { 
                            $file = $request->cmvr_certificate;
                            $response = uploadFileWithCurl($file);
                            $cmvrid = $response;

                        }  

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
                    $model->save();

                }
                if ($request->status == 'R') {
                    $modelReject = OemModelDetail::find($request->mid);
                    $modelReject->testing_flag = $request->status;
                    $modelReject->testing_remarks = $request->remarks;
                   // $modelReject->testing_by = $pid;
                    $modelReject->testing_created_at = Carbon::now()->format('Y-m-d');
                    $modelReject->save();
                    alert()->success('Successfully Rejected.','Success')->persistent('Close');
                }elseif ($request->status == 'A'){
                    alert()->success('Successfully Approved.','Success')->persistent('Close');
                }

            });
            
            return redirect()->route('modelRequests.index');
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
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
        $model = DB::table('vw_model_details')->where('model_detail_id', $id)->where('testing_agency_id', $pid)->first();
        $testing_agency_name = Auth::user()->name;

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
