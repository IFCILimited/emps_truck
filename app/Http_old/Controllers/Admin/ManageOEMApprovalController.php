<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OemModelMaster;
use App\Models\OemModelPerformDetail;
use App\Models\ManageOemApproval;
use App\Models\OemModelDetail;
use App\Models\User;
use Auth;
use DB;

class ManageOEMApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {


            // $modelMaster1 = DB::table("model_master as mm")
            // ->join('oem_model_details as omd', 'mm.id', '=', 'omd.model_id')
            // ->join('users as u', 'u.id', '=', 'mm.oem_id')
            // ->where('omd.testing_flag','A')
            // ->select('u.name','mm.*','omd.*')
            // ->get();
            // dd($modelMaster);

            $modelMaster = DB::table('vw_model_details')->where('testing_flag', 'A')->orderBy('testing_created_at','DESC')->get();
            // dd($modelMaster);

            // $oemApproval = ManageOemApproval::first();

            return view('admin.oem_model_index', compact('modelMaster'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }


    public function modelsView($status)
    {
        try {


            if($status == 'A'){

            $modelMaster = DB::table('vw_model_details')->where('testing_flag', 'A')->where('mhi_flag', 'A')->get();
            }
            elseif($status == 'R'){

            $modelMaster = DB::table('vw_model_details')->where('testing_flag', 'R')->where('mhi_flag', 'R')->get();

            }
            elseif($status == 'P'){

            $modelMaster = DB::table('vw_model_details')->where('testing_flag', 'A')->where('mhi_flag', null)->get();
            }
            else{
                $modelMaster = DB::table('vw_model_details')->where('testing_flag', 'A')->get(); 
            }
            // dd($modelMaster,$modelMaster1);

            // $oemApproval = ManageOemApproval::first();

            return view('admin.oem_model_index', compact('modelMaster'));
        } catch (Exception $e) {
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





    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {

                if ($request->status == 'R') {
                    $modelReject = OemModelDetail::find($request->mid);
                    $modelReject->mhi_flag = $request->status;
                    $modelReject->mhi_remarks = $request->mhi_remarks;
                    $modelReject->mhi_id = Auth::user()->id;
                    $modelReject->mhi_created_at = now();
                    $modelReject->mhi_submitted_at = now();
                    $modelReject->save();
                } elseif ($request->status == 'A') {
                    $model = OemModelDetail::find($request->mid);
                    $model->mhi_flag = $request->status;
                    $model->mhi_id = Auth::user()->id;
                    $model->mhi_created_at = now();
                    $model->mhi_submitted_at = now();
                    $model->save();
                }
            });
            if ($request->status == 'A') {
                alert()->success('Data has been successfully Approved.', 'Success')->persistent('Close');
            } elseif ($request->status == 'R') {
                alert()->success('Data has been successfully Rejected.', 'Success')->persistent('Close');
            }

            return redirect()->route('manageOEMApproval.index');
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
        try {
            $id = decrypt($id);
            // $model = DB::table("model_master as mm")
            // ->join('oem_model_details as omd', 'mm.id', '=', 'omd.model_id')
            // ->join('users as u', 'u.id', '=', 'mm.oem_id')
            // ->select('u.name','mm.*','omd.*')
            // ->where('omd.testing_flag','A')
            // ->where('mm.id',$id)
            // ->first();
            $model = DB::table('vw_model_details')->where('model_detail_id', $id)->where('testing_flag', 'A')->first();
            $testing_agency_name = User::where('id', $model->testing_agency_id)->select('name')->first();
            // dd($model,$testing_agency_name['name']);

            return view('admin.oem_model_detail', compact('model', 'testing_agency_name'));
        } catch (Exception $e) {
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
