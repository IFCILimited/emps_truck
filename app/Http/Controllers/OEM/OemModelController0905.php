<?php

namespace App\Http\Controllers\oem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OemBatteryDetail;
use App\Models\OemModelDetail;
use App\Models\OemModelPerformDetail;
use App\Models\OemVehicleCriteria;
// use App\Helpers\helperFunction1;
use Auth;
use DB;
use App\Models\User;
use App\Models\DocumentUpload;
use Carbon\Carbon;
use App\Models\OemModelMaster;
use Exception;

class OemModelController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pid = getParentId();
        try {
            $segment = DB::table('segment_master')->where('active', '1')->get();
            $oemMOdelDetail = User::join('model_master', 'users.id', '=', 'model_master.oem_id')
                // ->join('oem_model_details', 'model_master.id', '=', 'oem_model_details.model_id')
                ->where('model_master.oem_id', $pid)
                // ->orderBy('oem_model_details.id')
                ->get([
                    'model_master.id as model_id',
                    'model_master.*',
                    // 'oem_model_details.id as model_detail_id',
                    // 'oem_model_details.*',
                ]);
            $oemDet = DB::table('oem_model_details')->where('oem_id', $pid)->get();
            return view('oem.manage_model.oem_model', compact('oemMOdelDetail', 'segment','oemDet'));
        } catch (\Exception $e) {
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');
            errorMail($e,$pid);
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
            $pid = getParentId();
            $user = User::where('id', $pid)->first();
            // 5 is Testing Agency Role
            $agency = DB::table("users as u")
                ->join("model_has_roles as mhr", "u.id", "=", "mhr.model_id")
                ->select("u.*", "mhr.*")
                ->where("mhr.role_id", "=", 5)
                ->where('u.parent_id', null)
                ->get();
            $segment = DB::table('segment_master')->where('active', '1')->get();
            return view('oem.manage_model.oem_model_create', compact('user', 'agency', 'segment'));
        } catch (\Exception $e) {
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');

          // errorMail($e, Auth::user()->id);
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
        $pid = getParentId();
        $user_id = $pid;
        // dd($request);
        try {
            DB::transaction(function () use ($request, $user_id) {

                $oemModelmaster = new OemModelMaster;
                $oemModelmaster->oem_id = $user_id;
                $oemModelmaster->model_name = $request->ev_model_name;
                // $oemModelmaster->model_code = $request->ev_model_code;
                $oemModelmaster->variant_name = $request->variant_name;
                $oemModelmaster->vehicle_cat_id = $request->vehicle_category;
                $oemModelmaster->segment_id = $request->vehicle_segment;
                $oemModelmaster->model_status = 'active';
                $oemModelmaster->child_id = Auth::user()->id;

                if ($request->hasFile('vehicle_img')) {

                    $file = $request->vehicle_img;
                    $response = uploadFileWithCurl($file);

                }
                $oemModelmaster->vehicle_img_upload_id = $response;
                $oemModelmaster->save();


                $oemModelDetail = new OemModelDetail;
                $oemModelDetail->oem_id = $user_id;
                $oemModelDetail->model_id = $oemModelmaster->id;
                $oemModelDetail->category_type = $request->category_type;
                $oemModelDetail->model_type = $request->model_type;
                $oemModelDetail->status = 'D';

                $oemModelDetail->testing_agency_id = $request->testing_agency;
                $oemModelDetail->meeting_tech_function = $request->meeting_ev_tech;
                $oemModelDetail->meeting_qualif = $request->meeting_qualify_tar;
                $oemModelDetail->vehicle_sub_to_test_agency_apprv = $request->date_vehicle_submission;
                $oemModelDetail->date_certificate = $request->date_certificate;
                $oemModelDetail->tech_type = $request->tech_type;
                $oemModelDetail->factory_price = $request->ex_factory_price;
                $oemModelDetail->battery_type = $request->battery_type;


                $oemModelDetail->spec_density = $request->specific_density;
                $oemModelDetail->life_cyc = $request->life_cycle;
                $oemModelDetail->no_of_battery = $request->battery_cat_repulsion;
                $oemModelDetail->bat_1 = ($request->bat_1) ? $request->bat_1 : null;
                $oemModelDetail->bat_2 = ($request->bat_2) ? $request->bat_2 : null;
                $oemModelDetail->bat_3 = ($request->bat_3) ? $request->bat_3 : null;
                $oemModelDetail->bat_4 = ($request->bat_4) ? $request->bat_4 : null;
                $oemModelDetail->bat_5 = ($request->bat_5) ? $request->bat_5 : null;
                $oemModelDetail->bat_6 = ($request->bat_6) ? $request->bat_6 : null;
                $oemModelDetail->bat_7 = ($request->bat_7) ? $request->bat_7 : null;
                $oemModelDetail->bat_8 = ($request->bat_8) ? $request->bat_8 : null;
                $oemModelDetail->bat_9 = ($request->bat_9) ? $request->bat_9 : null;
                $oemModelDetail->bat_10 = ($request->bat_10) ? $request->bat_10 : null;
                $oemModelDetail->tot_energy = $request->total_energy_capacity;
                $oemModelDetail->battery_make = $request->battery_make;
               // $oemModelDetail->battery_capacity = $request->battery_capacity;

                $oemModelDetail->range = $request->range;
                $oemModelDetail->max_elect_consumption = $request->max_electric_energy_consumption;
                $oemModelDetail->min_max_speed = $request->minimax_speed;
                $oemModelDetail->min_acceleration = $request->minimum_acceleration;
                $oemModelDetail->monitoring_device_fitment = $request->monitor_device_fitment;
                $oemModelDetail->company_name = $request->company_name;
                $oemModelDetail->device_id = $request->device_id;
                $oemModelDetail->min_ex_show_price = $request->min_exshowrromprice;
                // $oemModelDetail->warranty_period_from = $request->warranty_period_from;
                $oemModelDetail->warranty_period_indicate = $request->warranty_period_indicate;
                $oemModelDetail->estimate_incentive_amount = $request->estimat_incentive_amt;


                if ($request->hasFile('model_compli_certificate')) {

                    $file = $request->model_compli_certificate;
                    $response = uploadFileWithCurl($file);

                }

                $oemModelDetail->compliance_upload_id = $response;
                $oemModelDetail->child_id = Auth::user()->id;
                $oemModelDetail->save();
            });

            // $oemModelmaster = OemModelMaster::Where('oem_id', $user_id)->orderBy('id', 'desc')->first();
            alert()->success('Data has been successfully saved.', 'Success!')->persistent('Close');
            return redirect()->route('oemModel.index');
        } catch (\Exception $e) {
//dd($e);
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');

           errorMail($e, $pid);
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
        $pid = getParentId();
        try {
            $id = decrypt($id);
            $user = User::where('id', $pid)->first();
            $oemMOdelDetail = DB::table('vw_model_details as vmd')
                ->join("users as u", "vmd.testing_agency_id", "=", "u.id")
                ->where('vmd.model_detail_id', $id)->where('vmd.oem_id', $pid)->first(['vmd.*', 'u.name as testing_agency_name']);
            // dd($oemMOdelDetail);
            return view('oem.manage_model.oem_model_view', compact('user', 'oemMOdelDetail'));
        } catch (\Exception $e) {
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');

          //  errorMail($e, Auth::user()->id);
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
        $pid = getParentId();
        try {
            $id = decrypt($id);
            $user = User::where('id', $pid)->first();
            $agency = DB::table("users as u")
                ->join("model_has_roles as mhr", "u.id", "=", "mhr.model_id")
                ->select("u.*", "mhr.*")
                ->where("mhr.role_id", "=", 5)
                ->where('u.parent_id', null)
                ->get();
            $oemMOdelDetail = DB::table('vw_model_details')->where('model_detail_id', $id)->where('oem_id', $pid)->first();
            $detCount = DB::table('vw_model_details')->where('model_id', $oemMOdelDetail->model_id)->where('oem_id', $pid)->count();

            // dd($detCount);
            $segment = DB::table('segment_master')->where('active', '1')->get();
            $categories = DB::table('category_master')->where('active', '1')->get();
            return view('oem.manage_model.oem_model_edit', compact('user', 'detCount','oemMOdelDetail', 'agency', 'segment', 'categories'));
        } catch (\Exception $e) {
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');

       //     errorMail($e, Auth::user()->id);
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

        $id = decrypt($id);

        $pid = getParentId();
        $user_id = $pid;

        try {
            DB::transaction(function () use ($request, $id, $user_id) {

                $oemModelmaster = OemModelMaster::find($id);
                $oemModelmaster->oem_id = $user_id;
                $oemModelmaster->model_name = $request->ev_model_name;
                // $oemModelmaster->model_code = $request->ev_model_code;
                $oemModelmaster->variant_name = $request->variant_name;
                $oemModelmaster->vehicle_cat_id = $request->vehicle_category;
                $oemModelmaster->segment_id = $request->vehicle_segment;
                $oemModelmaster->child_id = Auth::user()->id;
                if ($request->hasFile('vehicle_img')) {

                    $file = $request->vehicle_img;
                    $response = uploadFileWithCurl($file);
                    $oemModelmaster->vehicle_img_upload_id = $response;

                }
                $oemModelmaster->save();

                $oemModelDetail = OemModelDetail::find($request->id);
                $oemModelDetail->category_type = $request->category_type;
                $oemModelDetail->model_type = $request->model_type;
                $oemModelDetail->testing_agency_id = $request->testing_agency;
                $oemModelDetail->meeting_tech_function = $request->meeting_ev_tech;
                $oemModelDetail->meeting_qualif = $request->meeting_qualify_tar;
                $oemModelDetail->vehicle_sub_to_test_agency_apprv = $request->date_vehicle_submission;
                $oemModelDetail->tech_type = $request->tech_type;
                $oemModelDetail->factory_price = $request->ex_factory_price;
                $oemModelDetail->battery_type = $request->battery_type;
                $oemModelDetail->spec_density = $request->specific_density;
                $oemModelDetail->life_cyc = $request->life_cycle;
                $oemModelDetail->no_of_battery = $request->battery_cat_repulsion;
                $oemModelDetail->bat_1 = ($request->bat_1) ? $request->bat_1 : null;
                $oemModelDetail->bat_2 = ($request->bat_2) ? $request->bat_2 : null;
                $oemModelDetail->bat_3 = ($request->bat_3) ? $request->bat_3 : null;
                $oemModelDetail->bat_4 = ($request->bat_4) ? $request->bat_4 : null;
                $oemModelDetail->bat_5 = ($request->bat_5) ? $request->bat_5 : null;
                $oemModelDetail->bat_6 = ($request->bat_6) ? $request->bat_6 : null;
                $oemModelDetail->bat_7 = ($request->bat_7) ? $request->bat_7 : null;
                $oemModelDetail->bat_8 = ($request->bat_8) ? $request->bat_8 : null;
                $oemModelDetail->bat_9 = ($request->bat_9) ? $request->bat_9 : null;
                $oemModelDetail->bat_10 = ($request->bat_10) ? $request->bat_10 : null;
                $oemModelDetail->tot_energy = $request->total_energy_capacity;
                $oemModelDetail->battery_make = $request->battery_make;
              //  $oemModelDetail->battery_capacity = $request->battery_capacity;
                $oemModelDetail->range = $request->range;
                $oemModelDetail->max_elect_consumption = $request->max_electric_energy_consumption;
                $oemModelDetail->min_max_speed = $request->minimax_speed;
                $oemModelDetail->min_acceleration = $request->minimum_acceleration;
                $oemModelDetail->monitoring_device_fitment = $request->monitor_device_fitment;
                $oemModelDetail->company_name = $request->company_name;
                $oemModelDetail->device_id = $request->device_id;
                $oemModelDetail->min_ex_show_price = $request->min_exshowrromprice;
                // $oemModelDetail->warranty_period_from = $request->warranty_period_from;
                // $oemModelDetail->warranty_period_to = $request->warranty_period_to;
                $oemModelDetail->warranty_period_indicate = $request->warranty_period_indicate;
                $oemModelDetail->estimate_incentive_amount = $request->estimat_incentive_amt;

                if ($request->hasFile('model_compli_certificate')) {
                    $file = $request->model_compli_certificate;
                    $response = uploadFileWithCurl($file);
                    $oemModelDetail->compliance_upload_id = $response;

                }
                $oemModelDetail->child_id = Auth::user()->id;
                $oemModelDetail->save();

                if ($request->status == 'S') {
                    $oemModelmaster = OemModelDetail::find($request->id);
                    $oemModelmaster->status = 'S';
                    $oemModelmaster->submitted_at = Carbon::now();
                    $oemModelmaster->save();


                    $ta_name = DB::table('users')->where('id',$oemModelmaster->testing_agency_id)->first();
                    $oem = DB::table('users')->where('id',$user_id)->first();
                    $detail = DB::table('vw_model_details')->where('model_detail_id',$request->id)->first();
                    // dd($oem,$detail);
            $to = $oem->email;
            $cc =  ['emps-2024@ifciltd.com'];
            $bcc = ['ajaharuddin.ansari@ifciltd.com'];
            $subject = 'Model submitted successfully';
            $body = view('emails.model_submitted_by_oem', ['user' => $ta_name, 'detail'=>$oem,'exfp'=>$request->ex_factory_price, 'model'=>$detail])->render();

            $send = sendMail($to,$cc,$bcc,$subject,$body);
            
            $to1 = $ta_name->email;
            $cc1 =  [$oem->email,'emps-2024@ifciltd.com'];
            $bcc1 = ['ajaharuddin.ansari@ifciltd.com'];
            $subject1 = 'Model submitted successfully by OEM';
            $body1 = view('emails.model_submitted_by_oem_toTa', ['user' => $ta_name, 'detail'=>$oem, 'model'=>$detail])->render();
            
            $send1 = sendMail($to1,$cc1,$bcc1,$subject1,$body1);

                }
            });

            if($request->status == 'S'){
                alert()->success('Data has been successfully submitted.', 'Success')->persistent('Close');
            }else{
                alert()->success('Data has been successfully updated.', 'Success')->persistent('Close');
            }
            return redirect()->route('oemModel.index');
        } catch (\Exception $e) {
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');
           dd($e);
           errorMail($e, $pid);
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


    public function final_submit($id)
    {
        $pid = getParentId();
        try {
            $oemModelmaster = OemModelDetail::find($id);
            $oemModelmaster->status = 'S';
            $oemModelmaster->submitted_at = Carbon::now();
            $oemModelmaster->save();

            
            return redirect()->route('oemModel.index');
        } catch (\Exception $e) {
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');

// errorMail($e, Auth::user()->id);
            return redirect()->back();
        }

    }

    public function get_category($data)
    {
        try {
            $options = '<option selected disabled value="">Choose...</option>'; // Default option
            if (!empty($data)) {
                $categories = DB::table('category_master')->where('segment_id', $data)->where('active', '1')->get();
                foreach ($categories as $category) {
                    $options .= '<option value="' . $category->id . '">' . $category->category_name . '</option>';
                }
            }
            return $options;
        } catch (\Exception $e) {
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');

// errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function calculate_incentive_amt(Request $request)
    {
        try {
            $ex_factory = $request->input('ex_factory');
            $tot_energy = $request->input('tot_energy');
            $cat_id = $request->input('cat_id');
            $certificate_dt = $request->input(key: 'certificate_date');
            // dd($ex_factory,$tot_energy,$cat_id);
            if ($ex_factory && $tot_energy && $cat_id && $certificate_dt) {
                $result = DB::select("SELECT fn_estimated_incentive_amount(?, ?, ?, ?) AS result", [$ex_factory, $tot_energy, $cat_id, $certificate_dt]);
                return $result;
            }
        } catch (\Exception $e) {
        alert()->warning('Something went wrong.', 'Danger')->persistent('Close');
//    errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function models($id) {
        $id = decrypt($id);
        $pid = getParentId();
        try {
            $segment = DB::table('segment_master')->where('active', '1')->get();
            $oemMOdelDetail = User::join('model_master', 'users.id', '=', 'model_master.oem_id')
                ->join('oem_model_details', 'model_master.id', '=', 'oem_model_details.model_id')
                ->where('model_master.oem_id', $pid)
                ->where('oem_model_details.model_id', $id)
                ->orderBy('oem_model_details.id')
                ->get([
                    'model_master.id as model_id',
                    'model_master.*',
                    'oem_model_details.id as model_detail_id',
                    'oem_model_details.*',
                ]);
                // dd($oemMOdelDetail);
            return view('oem.manage_model.models', compact('oemMOdelDetail', 'segment'));
        } catch (\Exception $e) {
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');
            errorMail($e,$pid);
            return redirect()->back();
        }
    }
    public function revalidate($id) {
        $id = decrypt($id);
        $pid = getParentId();
        try {

            $user = User::where('id', $pid)->first();
            $oemMOdelDetail = DB::table('vw_model_details as vmd')
                ->join("users as u", "vmd.testing_agency_id", "=", "u.id")
                ->where('vmd.model_id', $id)->where('vmd.oem_id', $pid)->first(['vmd.*', 'u.name as testing_agency_name']);

                    // dd($oemMOdelDetail);
            return view('oem.manage_model.revalidate', compact('user', 'oemMOdelDetail'));
        } catch (\Exception $e) {
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');
// dd($e);
          //  errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function revalidatestore(Request $request)
    {
        $pid = getParentId();
        $user_id = $pid;

        try {
            DB::transaction(function () use ($request, $user_id) {

                // $oemModelmaster = new OemModelMaster;
                // $oemModelmaster->oem_id = $user_id;
                // $oemModelmaster->model_name = $request->ev_model_name;
                // // $oemModelmaster->model_code = $request->ev_model_code;
                // $oemModelmaster->variant_name = $request->variant_name;
                // $oemModelmaster->vehicle_cat_id = $request->vehicle_category;
                // $oemModelmaster->segment_id = $request->vehicle_segment;
                // $oemModelmaster->model_status = 'active';
                // $oemModelmaster->child_id = Auth::user()->id;

                // if ($request->hasFile('vehicle_img')) {

                //     $file = $request->vehicle_img;
                //     $response = uploadFileWithCurl($file);

                // }
                // $oemModelmaster->vehicle_img_upload_id = $response;
                // $oemModelmaster->save();


                $oemModelDetail = new OemModelDetail;
                $oemModelDetail->oem_id = $user_id;
                $oemModelDetail->model_id = $request->model_id;
                $oemModelDetail->category_type = $request->category_type;
                $oemModelDetail->model_type = $request->model_type;
                $oemModelDetail->status = 'D';

                $oemModelDetail->testing_agency_id = $request->testing_agency;
                $oemModelDetail->meeting_tech_function = $request->meeting_ev_tech;
                $oemModelDetail->meeting_qualif = $request->meeting_qualify_tar;
                $oemModelDetail->vehicle_sub_to_test_agency_apprv = $request->date_vehicle_submission;
                $oemModelDetail->date_certificate = $request->date_certificate;
                $oemModelDetail->tech_type = $request->tech_type;
                $oemModelDetail->factory_price = $request->ex_factory_price;
                $oemModelDetail->battery_type = $request->battery_type;


                $oemModelDetail->spec_density = $request->specific_density;
                $oemModelDetail->life_cyc = $request->life_cycle;
                $oemModelDetail->no_of_battery = $request->battery_cat_repulsion;
                $oemModelDetail->bat_1 = ($request->bat_1) ? $request->bat_1 : null;
                $oemModelDetail->bat_2 = ($request->bat_2) ? $request->bat_2 : null;
                $oemModelDetail->bat_3 = ($request->bat_3) ? $request->bat_3 : null;
                $oemModelDetail->bat_4 = ($request->bat_4) ? $request->bat_4 : null;
                $oemModelDetail->bat_5 = ($request->bat_5) ? $request->bat_5 : null;
                $oemModelDetail->bat_6 = ($request->bat_6) ? $request->bat_6 : null;
                $oemModelDetail->bat_7 = ($request->bat_7) ? $request->bat_7 : null;
                $oemModelDetail->bat_8 = ($request->bat_8) ? $request->bat_8 : null;
                $oemModelDetail->bat_9 = ($request->bat_9) ? $request->bat_9 : null;
                $oemModelDetail->bat_10 = ($request->bat_10) ? $request->bat_10 : null;
                $oemModelDetail->tot_energy = $request->total_energy_capacity;
                $oemModelDetail->battery_make = $request->battery_make;
               // $oemModelDetail->battery_capacity = $request->battery_capacity;

                $oemModelDetail->range = $request->range;
                $oemModelDetail->max_elect_consumption = $request->max_electric_energy_consumption;
                $oemModelDetail->min_max_speed = $request->minimax_speed;
                $oemModelDetail->min_acceleration = $request->minimum_acceleration;
                $oemModelDetail->monitoring_device_fitment = $request->monitor_device_fitment;
                $oemModelDetail->company_name = $request->company_name;
                $oemModelDetail->device_id = $request->device_id;
                $oemModelDetail->min_ex_show_price = $request->min_exshowrromprice;
                // $oemModelDetail->warranty_period_from = $request->warranty_period_from;
                $oemModelDetail->warranty_period_indicate = $request->warranty_period_indicate;
                $oemModelDetail->estimate_incentive_amount = $request->estimat_incentive_amt;


                // if ($request->hasFile('model_compli_certificate')) {

                //     $file = $request->model_compli_certificate;
                //     $response = uploadFileWithCurl($file);

                // }

                $oemModelDetail->compliance_upload_id = $request->compliance_upload_id;
                $oemModelDetail->child_id = Auth::user()->id;
                $oemModelDetail->save();
            });

            // $oemModelmaster = OemModelMaster::Where('oem_id', $user_id)->orderBy('id', 'desc')->first();
            alert()->success('Data has been successfully saved.', 'Success!')->persistent('Close');
            return redirect()->route('oemModel.index');
        } catch (\Exception $e) {
// dd($e);
alert()->warning('Something went wrong.', 'Danger')->persistent('Close');

           errorMail($e, $pid);
            return redirect()->back();
        }
    }
}
