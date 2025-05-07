<?php

namespace App\Http\Controllers\PMA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use App\Models\ReleaseVinDetails;
use App\Models\BuyerDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


class ReleaseVINController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $isIndex = true;
       return view('pma.releaseVIN', compact('isIndex'));
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


    public function getVIN(Request $request)
    {

        $buyerId = $request->vin_num;
        $isIndex = false;

        $details = DB::table('buyer_details_view')
        ->select('id', 'custmr_name', 'vin_chassis_no', 'segment_name', 'model_name', 'oem_status', 'status','buyer_id','dealer_name','created_at')
        ->where('vin_chassis_no', $buyerId)
        ->first();


            if (!$details) {
                alert()->warning('No Details Found', 'No buyer details found for this VIN number.');
                return redirect()->back();
            }

            return view('pma.releaseVIN', compact('buyerId', 'details', 'isIndex'));

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

    $detail->remarks = trim($request->remarks);
    $detail->user_action = trim($request->action);
    $detail->action_by = Auth::user()->id;
    $detail->created_at = Carbon::now();
    $detail->action_at = Carbon::now();

    $createdId = ReleaseVinDetails::insertGetId((array)$detail);
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
    return redirect()->route('releaseVIN.index');


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
