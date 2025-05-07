<?php

namespace App\Http\Controllers\Truck\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ReleaseVinDetails;
use App\Models\BuyerDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ManageVinNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isIndex = true;
        return view('truck.buyer.manage_vin_number', compact('isIndex'));
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
        //
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
        $id = decrypt($id);
        if($request->type == "Bulk") {


try{
            DB::transaction(function () use ($request, $id) {




                $details = DB::table('multi_buyer_details')->select(
                    'id',
                    'buyer_id',
                    'status',
                    'oem_status',
                    'vin_count',
                    'vin_map',
                    'adh_verify',
                    'auth_addr',
                    'landmark',
                    'pincode',
                    'state',
                    'district',
                    'city',
                    'mobile',
                    'adhar_name',
                    'dob',
                    'gender',
                    'custmr_id_no',
                    'created_at',
                    'updated_at',
                    'submitted_at',
                    'dealer_id',
                    'created_by',
                    'submited_by',
                    'customer_name',
                    'auth_prs_name'
                )
                ->find($id);

                $detailsArray = json_decode(json_encode($details), true);
                $detailsArray['remark'] = trim($request->remarks);
                $detailsArray['released_by'] = Auth::user()->id;
                $detailsArray['released_on'] = Carbon::now();
                $detailsArray['action_at'] = Carbon::now();

                //insert in multi_buyer_Details_release table
                $createdId = DB::table('multi_buyer_details_release')->insertGetId($detailsArray);

                //fetch details from buyer details
                $buyer_detail = DB::table('buyer_details')->select(
                        'oem_id',
                        'dealer_id',
                        'production_id',
                        'custmr_typ',
                        'custmr_name',
                        "add",
                        'landmark',
                        'pincode',
                        'state',
                        'district',
                        'city',
                        'mobile',
                        'email',
                        'custmr_id',
                        'custmr_id_no',
                        'addi_cust_id',
                        'cust_id_sec',
                        'dlr_invoice_no',
                        'vihcle_dt',
                        'amt_custmr',
                        'invoice_amt',
                        'addmi_inc_amt',
                        'tot_inv_amt',
                        'tot_admi_inc_amt',
                        'copy_file_uploadid',
                        'sec_file_uploadeif',
                        'claim_id',
                        'invoice_dt',
                        'gender',
                        'vin_chassis_no',
                        'segment_id',
                        'status',
                        'sec_file_uploadeid',
                        'cst_ack_file',
                        'invc_copy_file',
                        'vhcl_reg_file',
                        'vhcl_regis_no',
                        'oem_remarks',
                        'oem_status',
                        'oem_status_at',
                        'discount_given',
                        'discount_amt',
                        'empsbeforeafter',
                        'dob',
                        'child_id',
                        'aadhaarconsent',
                        'pma_status',
                        'pma_process_by',
                        'pma_process_at',
                        'expiry_120',
                        'buyer_id',
                        'adh_verify',
                        'buyer_submitted_at',
                        'certificate_num',
                        'temp_reg_no',
                        'pan',
                        'pancopy_id',
                        'gstin',
                        'gstin_id',
                        'adhar_name'
                )->where('buyer_id', $detailsArray["buyer_id"])->get();
                $createdIds = [];
                foreach($buyer_detail as $buy_det) {
                    $buyerDetailsArray = json_decode(json_encode($buy_det), true);
                    $buyerDetailsArray['remarks'] = "BULK VIN RELEASE";
                    $buyerDetailsArray['user_action'] = trim($request->action);
                    $buyerDetailsArray['action_by'] = Auth::user()->id;
                    $buyerDetailsArray['created_at'] = Carbon::now();
                    $buyerDetailsArray['action_at'] = Carbon::now();

                    $createdIds[] = ReleaseVinDetails::insertGetId($buyerDetailsArray);
                }




			BuyerDetail::where('buyer_id', $detailsArray["buyer_id"])->delete();
                    DB::table('multi_buyer_details')->where('buyer_id', $detailsArray["buyer_id"])->delete();



 			$message = "VIN released successfully !";
                    alert()->success($message, 'Success')->persistent('Close');


 });

            return redirect()->route('manage_vin_number.index');
}catch(\Exception $ex){
	alert()->warning('Something went wrong', 'Warning')->persistent('Close');
	 return redirect()->route('manage_vin_number.index');

}

        }elseif($request->type == "Individual"){

        $message = null;
        $isError = false;
            $detail = DB::table('buyer_details')->select(
                    'oem_id',
                    'dealer_id',
                    'production_id',
                    'custmr_typ',
                    'custmr_name',
                    "add",
                    'landmark',
                    'pincode',
                    'state',
                    'district',
                    'city',
                    'mobile',
                    'email',
                    'custmr_id',
                    'custmr_id_no',
                    'addi_cust_id',
                    'cust_id_sec',
                    'dlr_invoice_no',
                    'vihcle_dt',
                    'amt_custmr',
                    'invoice_amt',
                    'addmi_inc_amt',
                    'tot_inv_amt',
                    'tot_admi_inc_amt',
                    'copy_file_uploadid',
                    'sec_file_uploadeif',
                    'claim_id',
                    'invoice_dt',
                    'gender',
                    'vin_chassis_no',
                    'segment_id',
                    'status',
                    'sec_file_uploadeid',
                    'cst_ack_file',
                    'invc_copy_file',
                    'vhcl_reg_file',
                    'vhcl_regis_no',
                    'oem_remarks',
                    'oem_status',
                    'oem_status_at',
                    'discount_given',
                    'discount_amt',
                    'empsbeforeafter',
                    'dob',
                    'child_id',
                    'aadhaarconsent',
                    'pma_status',
                    'pma_process_by',
                    'pma_process_at',
                    'expiry_120',
                    'buyer_id',
                    'adh_verify',
                    'buyer_submitted_at',
                    'certificate_num',
                    'temp_reg_no',
                    'pan',
                    'pancopy_id',
                    'gstin',
                    'gstin_id',
                    'adhar_name'
            )->find($id);

            $detailsArray = json_decode(json_encode($detail), true);
            $detailsArray['remarks'] = trim($request->remarks);
            $detailsArray['user_action'] = trim($request->action);
            $detailsArray['action_by'] = Auth::user()->id;
            $detailsArray['created_at'] = Carbon::now();
            $detailsArray['action_at'] = Carbon::now();

            $createdId = ReleaseVinDetails::insertGetId($detailsArray);
            $isError = true;
            $message = "Something went Wrong !";

            if($createdId) {
                BuyerDetail::destroy($id);
                $isError = false;
            }
            if($isError){
                alert()->error($message, 'Error')->persistent('Close');
            }else{
                $message = "Customer updated successfully !";
                if($request->action == "release") {
                    $message = "VIN released successfully !";
                }
                alert()->success($message, 'Success')->persistent('Close');
            }
        }elseif($request->type == "Emps"){

            $empsDetails = DB::table('emps_buyer_auth')->select(
                'id',
                'segment_name',
                'factory_price',
                'model_name',
                'variant_name',
                'vehicle_cat',
                'emps_details_id',
                'oem_id',
                'dealer_id',
                'production_id',
                'custmr_typ',
                'custmr_name',
                'add',
                'landmark',
                'pincode',
                'state',
                'district',
                'city',
                'mobile',
                'email',
                'custmr_id',
                'custmr_id_no',
                'addi_cust_id',
                'cust_id_sec',
                'dlr_invoice_no',
                'vihcle_dt',
                'amt_custmr',
                'invoice_amt',
                'addmi_inc_amt',
                'tot_inv_amt',
                'tot_admi_inc_amt',
                'copy_file_uploadid',
                'sec_file_uploadeif',
                'created_at',
                'updated_at',
                'claim_id',
                'invoice_dt',
                'gender',
                'vin_chassis_no',
                'segment_id',
                'status',
                'sec_file_uploadeid',
                'cst_ack_file',
                'invc_copy_file',
                'vhcl_reg_file',
                'vhcl_regis_no',
                'model_id',
                'oem_remarks',
                'oem_status',
                'oem_status_at',
                'dob',
                'discount_given',
                'discount_amt',
                'empsbeforeafter',
                'dealer_name',
                'dealer_code',
                'dealer_mobile',
                'dealer_email',
                'oem_name',
                'vehicle_cat_id',
                'aadhaarconsent',
                'lot_id',
                'claimnumberformat',
                'lot_date',
                'pma_status',
                'pma_process_by',
                'pma_process_at',
                'manufacturing_date',
                'empscertificatefrom',
                'empscertificateto',
                'testing_cmvr_date',
                'testing_approval_date',
                'testing_expiry_date',
                'tot_energy',
                'pmp',
                'dva',
                'battery_type',
                'mhi_noting_appr_date',
                'motor_number',
                'battery_chemistry',
                'buyer_id',
                'buyer_id_dt',
                'pmedrive_dealer_id',
                'pmedrive_dealer_child_id',
                'pmedrive_dealer_status',
                'pmedrive_adh_verify',
                'pmedrive_adh_auth_dt',
                'adhar_name',
                'pmedrive_adh_add',
                'pmedrive_adh_landmark',
                'pmedrive_adh_state',
                'pmedrive_adh_district',
                'pmedrive_adh_city',
                'pmedrive_adh_pincode',
                'pmedrive_adh_mobile',
                'pmedrive_adh_gen',
                'pmedrive_adh_dob',
                'pmedrive_custmr_id_no',
                'pmedrive_evoucher_copy_id',
                'pmedrive_self_copy_id',
                'pmedrive_dealer_submitted_oem',
                'pmedrive_oem_status',
                'pmedrive_oem_remarks',
                'pmedrive_oem_id',
                'pmedrive_oem_child_id',
                'pmedrive_oem_status_at'
            )->find($id);


                $empsDetailsArray = json_decode(json_encode($empsDetails), true);
                $empsDetailsArray['remarks'] = trim($request->remarks);
                $empsDetailsArray['user_action'] = trim($request->action);
                $empsDetailsArray['action_by'] = Auth::user()->id;
                $empsDetailsArray['released_on'] = Carbon::now();
                $empsDetailsArray['action_at'] = Carbon::now();

                $createdId = DB::table('emps_buyer_auth_release')->insertGetId($empsDetailsArray);


                // DB::table('emps_buyer_auth')
                // ->where('id', $id)
                // ->update([
                //     'buyer_id' => null,
                //     'buyer_id_dt' => null,
                //     'pmedrive_dealer_id' => null,
                //     'pmedrive_dealer_child_id' => null,
                //     'pmedrive_dealer_status' => null,
                //     'pmedrive_adh_verify' => null,
                //     'pmedrive_adh_auth_dt' => null,
                //     'adhar_name' => null,
                //     'pmedrive_adh_add' => null,
                //     'pmedrive_adh_landmark' => null,
                //     'pmedrive_adh_state' => null,
                //     'pmedrive_adh_district' => null,
                //     'pmedrive_adh_city' => null,
                //     'pmedrive_adh_pincode' => null,
                //     'pmedrive_adh_mobile' => null,
                //     'pmedrive_adh_gen' => null,
                //     'pmedrive_adh_dob' => null,
                //     'pmedrive_custmr_id_no' => null,
                //     'pmedrive_evoucher_copy_id' => null,
                //     'pmedrive_self_copy_id' => null,
                //     'pmedrive_dealer_submitted_oem' => null,
                //     'pmedrive_oem_status' => null,
                //     'pmedrive_oem_remarks' => null,
                //     'pmedrive_oem_id' => null,
                //     'pmedrive_oem_child_id' => null,
                //     'pmedrive_oem_status_at' => null,
                // ]);

                $isError = true;

                $message = "Something went Wrong !";

                if($createdId) {
                    DB::table('emps_buyer_auth')
                    ->where('id', $id)
                    ->delete();
                    // BuyerDetail::destroy($id);
                    // $isError = false;
                }
                if($isError){
                    alert()->error($message, 'Error')->persistent('Close');
                }else{
                    $message = "Customer updated successfully !";
                    if($request->action == "release") {
                        $message = "VIN released successfully !";
                    }
                    alert()->success($message, 'Success')->persistent('Close');
                }

            }

            return redirect()->route('manage_vin_number.index');

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

    public function getCustomerDetails(Request $request){


        if (!is_numeric($request->vin_num)) {
            // return redirect()->back()->with('alert', 'Please enter Customer ID')->with('alert_type', 'error');
            alert()->warning('alert', 'Please enter Customer ID');
            return redirect()->back();
        }
        $buyerId = $request->vin_num;
        $isIndex = false;

        // dd($buyerId);

        // $details =DB::table('multi_buyer_details')
        // ->where('buyer_id', $buyerId)
        // ->where('dealer_id', Auth::user()->id)
        // ->first();
        // $isBulk = false;
        // if($details) {
        //     $isBulk = true;
        //     return view('truck.buyer.manage_vin_number', compact('buyerId', 'details', 'isIndex', 'isBulk'));
        // }

        // $details = DB::table('buyer_details_view')
        // ->select('id', 'custmr_name', 'vin_chassis_no', 'segment_name', 'model_name', 'factory_price', 'oem_status', 'status')
        // ->where('buyer_id', $buyerId)
        // ->where('dealer_id', Auth::user()->id) // Corrected method call
        // // ->orWhere('buyer_id', (int)$vinNumber) // Ensure this is intended; might need grouping
        // ->first();

        $Buyer = null;
        $details = null;
        $isBulk = false;

        $empsBuyer = DB::table('emps_buyer_auth')
        ->select('id', 'custmr_name', 'vin_chassis_no', 'segment_name', 'model_name', 'factory_price', 'pmedrive_oem_status', 'pmedrive_dealer_status')
        ->where('buyer_id', $buyerId)
        ->where('pmedrive_dealer_id', Auth::user()->id)
        ->first();

        if($empsBuyer) {
            $Buyer = 'Emps';
            $details = $empsBuyer;
            return view('truck.buyer.manage_vin_number', compact('buyerId', 'details', 'isIndex', 'isBulk', 'Buyer'));
        }


        $multi_buyer = DB::table('multi_buyer_details')
    ->where('buyer_id', $buyerId)
    ->where('dealer_id', Auth::user()->id)
    ->first();
    if($multi_buyer){
        $Buyer = 'Bulk';
        $details = $multi_buyer;
        $isBulk = true;
        return view('truck.buyer.manage_vin_number', compact('buyerId', 'details', 'isIndex', 'isBulk', 'Buyer'));

    }

    $buyerDetails = DB::table('buyer_details_view')
        ->select('id', 'custmr_name', 'vin_chassis_no', 'segment_name', 'model_name', 'factory_price', 'oem_status', 'status')
        ->where('buyer_id', $buyerId)
        ->where('dealer_id', Auth::user()->id)
        ->first();

        if($buyerDetails) {
            $Buyer = 'Individual';
            $details = $buyerDetails;
            return view('truck.buyer.manage_vin_number', compact('buyerId', 'details', 'isIndex', 'isBulk', 'Buyer'));
        }



        alert()->warning('alert', 'No data found for the given buyer.');
        return redirect()->back();
    }
}
