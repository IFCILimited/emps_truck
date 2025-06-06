<?php

namespace App\Http\Controllers\Truck\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Trucks\OemModelMaster;
use App\Models\Trucks\ManageOemApproval;
use App\Models\Trucks\OemModelDetail;
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

            $modelMaster = DB::table('vw_model_details_trucks')->where('testing_flag', 'A')
                // ->whereIn('model_detail_id',[1294,1293, 1291, 1292, 1295])
                ->orderBy('testing_created_at', 'DESC')->get();
            // dd($modelMaster);

            // $oemApproval = ManageOemApproval::first();
            $users = DB::table('users as u')
                ->join('model_has_roles as mhr', 'u.id', '=', 'mhr.model_id')
                ->join('roles as r', 'mhr.role_id', '=', 'r.id')
                ->select('u.*')
                ->whereIn('r.id', ['10', '11', '8', '5'])
                ->get();
            return view('truck.admin.oem_model_index', compact('modelMaster', 'users'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }


    public function modelsView($status)
    {
        try {


            if ($status == 'A') {

                $modelMaster = DB::table('vw_model_details')->where('testing_flag', 'A')->where('mhi_flag', 'A')->get();
            } elseif ($status == 'R') {

                $modelMaster = DB::table('vw_model_details')->where('testing_flag', 'R')->where('mhi_flag', 'R')->get();

            } elseif ($status == 'P') {

                $modelMaster = DB::table('vw_model_details')->where('testing_flag', 'A')->where('mhi_flag', null)->get();
            } else {
                $modelMaster = DB::table('vw_model_details')->where('testing_flag', 'A')->get();
            }
            // dd($modelMaster,$modelMaster1);

            // $oemApproval = ManageOemApproval::first();

            return view('truck.admin.oem_model_index', compact('modelMaster'));
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
        // dd('hi');
        try {
            DB::transaction(function () use ($request) {
                $modelDetails = OemModelDetail::find($request->mid);

                if (Auth::user()->hasRole('MHI-DS')) {
                    if ($request->status == 'R') {
                        // dd($request->status);
                        // $modelReject = OemModelDetail::find($request->mid);
                        // $modelReject->mhi_flag = $request->status;
                        $modelDetails->mhi_remarks = $request->mhi_remarks;
                        // $modelReject->mhi_id = Auth::user()->id;
                        // $modelReject->mhi_created_at = now();
                        // $modelReject->mhi_submitted_at = now();
                        // $modelReject->save();

                        $ta_name = DB::table('users')->where('id', $modelDetails->testing_agency_id)->first();
                        $oem = DB::table('users')->where('id', $modelDetails->oem_id)->first();
                        $detail = DB::table('vw_model_details_trucks')->where('model_detail_id', $request->mid)->first();

                        $to = $oem->email;
                        $cc = [Auth::user()->email, 'emps-2024@ifciltd.com'];
                        $bcc = ['ajaharuddin.ansari@ifciltd.com'];
                        $subject = 'Model Rejected by MHI';
                        $body = view('emails.model_rejected_by_Ds', ['user' => $ta_name, 'detail' => $oem, 'model' => $detail, 'rem' => $request->mhi_remarks])->render();

                        $send = sendMail($to, $cc, $bcc, $subject, $body);

                    }
                    // elseif ($request->status == 'A') {
                    //     // $model = OemModelDetail::find($request->mid);
                    //     // $model->mhi_flag = $request->status;
                    // }
                    $modelDetails->mhi_flag = $request->status;
                    $modelDetails->e_office_date = $request->e_office_date;
                    $modelDetails->mhi_id = Auth::user()->id;
                    $modelDetails->mhi_created_at = now();
                    $modelDetails->mhi_submitted_at = now();
                    $modelDetails->save();

                    if ($request->status == 'A') {
                        $ta_name = DB::table('users')->where('id', $modelDetails->testing_agency_id)->first();
                        $oem = DB::table('users')->where('id', $modelDetails->oem_id)->first();
                        $detail = DB::table('vw_model_details_trucks')->where('model_detail_id', $request->mid)->first();


                        $to = $oem->email;
                        $cc = [Auth::user()->email, 'emps-2024@ifciltd.com'];
                        $bcc = ['ajaharuddin.ansari@ifciltd.com'];
                        $subject = 'Model Approved by MHI';
                        $body = view('emails.model_approve_by_Ds', ['user' => $ta_name, 'detail' => $oem, 'model' => $detail])->render();

                        $send = sendMail($to, $cc, $bcc, $subject, $body);
                    }
                } else {
                    //pma login
                    if ($request->status == 'R') {
                        $modelDetails->pma_remarks = $request->mhi_remarks;
                    }
                    $modelDetails->pma_status = $request->status;
                    $modelDetails->pma_created_by = Auth::user()->id;
                    $modelDetails->pma_created_at = now();
                    $modelDetails->save();


                }



            });
            if ($request->status == 'A') {
                if (Auth::user()->hasRole('MHI-DS')) {

                    alert()->success('Data has been successfully Approved.', 'Success')->persistent('Close');
                } else {
                    alert()->success('Data has been successfully Recommended.', 'Success')->persistent('Close');
                }
            } elseif ($request->status == 'R') {
                alert()->success('Data has been successfully Rejected.', 'Success')->persistent('Close');
            }

            if (Auth::user()->hasRole('MHI-DS')) {
                return redirect()->route('e-trucks.manageOEMApproval.index');
            } else {
                return redirect()->route('e-trucks.manageOEMApproval.index');
            }
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
            // dd($e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     try {
    //         $id = decrypt($id);
    //         // dd($id);
    //         // $model = DB::table("model_master as mm")
    //         // ->join('oem_model_details as omd', 'mm.id', '=', 'omd.model_id')
    //         // ->join('users as u', 'u.id', '=', 'mm.oem_id')
    //         // ->select('u.name','mm.*','omd.*')
    //         // ->where('omd.testing_flag','A')
    //         // ->where('mm.id',$id)
    //         // ->first();
    //         $model = DB::table('vw_model_details')->where('model_detail_id', $id)->where('testing_flag', 'A')->first();
    //         $testing_agency_name = User::where('id', $model->testing_agency_id)->select('name')->first();
    //         // dd($model,$testing_agency_name['name']);

    //         return view('admin.oem_model_detail', compact('model', 'testing_agency_name'));
    //     } catch (Exception $e) {
    //         errorMail($e, Auth::user()->id);
    //         return redirect()->back();
    //     }
    // }

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
