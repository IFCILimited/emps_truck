<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use Exception;
use App\Models\User;
use App\Exports\EmpsBuyerDetailsExport;
use Maatwebsite\Excel\Facades\Excel;

class EmpsAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pid = getParentId();
        return view('buyer.empsAuth.create_buyer');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {

        $empsID = $request->emps_id;
        $pid = getParentId();

        $bankDetail = request()->data;

        $empsBuyer = json_decode($bankDetail, true);

        $BuyerId = gernerateBuyerId();
        $custmrName = $empsBuyer[0]['custmr_name'];

        try {
            DB::transaction(function () use ($request, $empsBuyer, $BuyerId, &$custmrName,$pid) {
                $data = [
                    'segment_name' => $empsBuyer[0]['segment_name'],
                    'factory_price' => $empsBuyer[0]['factory_price'],
                    'model_name' => $empsBuyer[0]['model_name'],
                    'variant_name' => $empsBuyer[0]['variant_name'],
                    'vehicle_cat' => $empsBuyer[0]['vehicle_cat'],
                    'emps_details_id' => $empsBuyer[0]['id'],
                    'oem_id' => $empsBuyer[0]['oem_id'],
                    'dealer_id' => $empsBuyer[0]['dealer_id'],
                    'production_id' => $empsBuyer[0]['production_id'],
                    'custmr_typ' => $empsBuyer[0]['custmr_typ'],
                    'custmr_name' => $empsBuyer[0]['custmr_name'],
                    'add' => $empsBuyer[0]['add'],
                    'landmark' => $empsBuyer[0]['landmark'],
                    'pincode' => $empsBuyer[0]['pincode'],
                    'state' => $empsBuyer[0]['state'],
                    'district' => $empsBuyer[0]['district'],
                    'city' => $empsBuyer[0]['city'],
                    'mobile' => $empsBuyer[0]['mobile'],
                    'email' => $empsBuyer[0]['email'],
                    'custmr_id' => $empsBuyer[0]['custmr_id'],
                    'custmr_id_no' => $empsBuyer[0]['custmr_id_no'],
                    'addi_cust_id' => $empsBuyer[0]['addi_cust_id'],
                    'cust_id_sec' => $empsBuyer[0]['cust_id_sec'],
                    'dlr_invoice_no' => $empsBuyer[0]['dlr_invoice_no'],
                    'vihcle_dt' => $empsBuyer[0]['vihcle_dt'],
                    'amt_custmr' => $empsBuyer[0]['amt_custmr'],
                    'invoice_amt' => $empsBuyer[0]['invoice_amt'],
                    'addmi_inc_amt' => $empsBuyer[0]['addmi_inc_amt'],
                    'tot_inv_amt' => $empsBuyer[0]['tot_inv_amt'],
                    'tot_admi_inc_amt' => $empsBuyer[0]['tot_admi_inc_amt'],
                    'copy_file_uploadid' => $empsBuyer[0]['copy_file_uploadid'],
                    'sec_file_uploadeif' => $empsBuyer[0]['sec_file_uploadeif'],
                    'created_at' => $empsBuyer[0]['created_at'],
                    'updated_at' => $empsBuyer[0]['updated_at'],
                    'claim_id' => $empsBuyer[0]['claim_id'],
                    'invoice_dt' => $empsBuyer[0]['invoice_dt'],
                    'gender' => $empsBuyer[0]['gender'],
                    'vin_chassis_no' => $empsBuyer[0]['vin_chassis_no'],
                    'segment_id' => $empsBuyer[0]['segment_id'],
                    'status' => $empsBuyer[0]['status'],
                    'sec_file_uploadeid' => $empsBuyer[0]['sec_file_uploadeid'],
                    'cst_ack_file' => $empsBuyer[0]['cst_ack_file'],
                    'invc_copy_file' => $empsBuyer[0]['invc_copy_file'],
                    'vhcl_reg_file' => $empsBuyer[0]['vhcl_reg_file'],
                    'vhcl_regis_no' => $empsBuyer[0]['vhcl_regis_no'],
                    'model_id' => $empsBuyer[0]['model_id'],
                    'oem_remarks' => $empsBuyer[0]['oem_remarks'],
                    'oem_status' => $empsBuyer[0]['oem_status'],
                    'oem_status_at' => $empsBuyer[0]['oem_status_at'],
                    'dob' => $empsBuyer[0]['dob'],
                    'discount_given' => $empsBuyer[0]['discount_given'],
                    'discount_amt' => $empsBuyer[0]['discount_amt'],
                    'empsbeforeafter' => $empsBuyer[0]['empsbeforeafter'],
                    'dealer_name' => $empsBuyer[0]['dealer_name'],
                    'dealer_code' => $empsBuyer[0]['dealer_code'],
                    'dealer_mobile' => $empsBuyer[0]['dealer_mobile'],
                    'dealer_email' => $empsBuyer[0]['dealer_email'],
                    'oem_name' => $empsBuyer[0]['oem_name'],
                    'vehicle_cat_id' => $empsBuyer[0]['vehicle_cat_id'],
                    'aadhaarconsent' => $empsBuyer[0]['aadhaarconsent'],
                    'lot_id' => $empsBuyer[0]['lot_id'],
                    'claimnumberformat' => $empsBuyer[0]['claimnumberformat'],
                    'lot_date' => $empsBuyer[0]['lot_date'],
                    'pma_status' => $empsBuyer[0]['pma_status'],
                    'pma_process_by' => $empsBuyer[0]['pma_process_by'],
                    'pma_process_at' => $empsBuyer[0]['pma_process_at'],
                    'manufacturing_date' => $empsBuyer[0]['manufacturing_date'],
                    'empscertificatefrom' => $empsBuyer[0]['empscertificatefrom'],
                    'empscertificateto' => $empsBuyer[0]['empscertificateto'],
                    'testing_cmvr_date' => $empsBuyer[0]['testing_cmvr_date'],
                    'testing_approval_date' => $empsBuyer[0]['testing_approval_date'],
                    'testing_expiry_date' => $empsBuyer[0]['testing_expiry_date'],
                    'tot_energy' => $empsBuyer[0]['tot_energy'],
                    'pmp' => $empsBuyer[0]['pmp'],
                    'dva' => $empsBuyer[0]['dva'],
                    'battery_type' => $empsBuyer[0]['battery_type'],
                    'mhi_noting_appr_date' => $empsBuyer[0]['mhi_noting_appr_date'],
                    'motor_number' => $empsBuyer[0]['motor_number'],
                    'battery_chemistry' => $empsBuyer[0]['battery_chemistry'],
                    'buyer_id' => $BuyerId,
                    'buyer_id_dt' => now(),
                    'pmedrive_dealer_id' => $pid,
                    'pmedrive_dealer_child_id' => Auth::user()->id,
                    'pmedrive_dealer_status' => 'D',
                ];



                $id = DB::table('emps_buyer_auth')->insertGetId($data);

            });

            alert()->success('<b>EMPS Customer ID: ' . $BuyerId . '</b><br><b>Customer Name: ' . $custmrName . '</b><br> successfully generated and saved.', 'Kindly note down the Customer ID. You will need it for authentication:')
                ->persistent('Close');
            return redirect()->route('empsbuyer.emps_auth');

        } catch (\Exception $e) {
            \Log::error('Error creating Buyer ID: ' . $e->getMessage());
            alert()->error('Something went wrong. Please try again.', 'Error')->persistent('Close');
            return redirect()->back()->withInput();
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

        $customerDetails = null;

        if ($request->has('vin_chassis_no')) {
            $request->validate([
                'vin_chassis_no' => 'required|string|max:255',
            ]);

            $vinChassisNo = $request->input('vin_chassis_no');

            $data = EmpsAuthCheck($vinChassisNo);

            $customerDetails = json_decode($data->content(), true);
            
            $empsAuthBuyer = DB::table('emps_buyer_auth')
                ->where('vin_chassis_no', $vinChassisNo)
                ->orderBy('emps_buyer_auth.id', 'DESC')->first();


            if (!empty($empsAuthBuyer)) {
                if($empsAuthBuyer->pmedrive_dealer_id==$pid){
 
                    alert()->success('Customer ID ' . '( ' . $empsAuthBuyer->buyer_id . ' )' . ' Already Generated.', 'Success')->persistent('Close');
                    return redirect()->route('empsbuyer.emps_auth');
                }else{
                    alert()->Warning('Customer ID already generated', 'Warning')->persistent('Close');
                    return redirect()->back();
                }
            } else {
                return view('buyer.empsAuth.create_buyer', compact('customerDetails'));
            }
        }

    }



    public function show_detail($id)
    {

        $id = decrypt($id);

        $empsBuyer = request()->data;

        $bankDetail = json_decode($empsBuyer, true);

        $customerId = $bankDetail[0]['custmr_typ'];

        $cat = DB::table('customer_doc_verf_type')
            ->where('id', $customerId)
            ->first();

        $BuyerId = gernerateBuyerId();

        return view('buyer.empsAuth.generate_buyer', compact('bankDetail', 'cat', 'BuyerId'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function emps_auth(Request $req)
    {
        $toSearch = null;
        if(isset($req->vin)){
            $toSearch = $req->vin;
        }
        $pid = getParentId();

        $emps = DB::table('emps_buyer_auth')
            ->where('pmedrive_dealer_id', $pid);
        if($toSearch){
            $emps->where('vin_chassis_no', $toSearch);
        }
        $empsAuthBuyer = $emps->orderBy('emps_buyer_auth.id', 'DESC')->get();
        return view('buyer.empsAuth.auth_index', compact('empsAuthBuyer'));
    }
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);

        try {
            $user = User::where('id', Auth::user()->id)->first();
            $bankDetail = DB::table('emps_buyer_auth')
                ->where('id', $id)->first();

            $customerId = (int) $bankDetail->custmr_id;
            $AddcustomerId = (int) $bankDetail->addi_cust_id;

            $cat = DB::table('customer_doc_verf_type')
                ->where('id', $customerId)
                ->first();

            $type = DB::table('customer_doc_verf_type')->where('id', $AddcustomerId)->first();

            return view('buyer.empsAuth.edit_buyer', compact('bankDetail', 'user', 'customerId', 'cat','type'));
        } catch (Exception $e) {
            alert()->error('Something went wrong. Please try again.', 'Error')->persistent('Close');
            return redirect()->back();
        }


        // return view('buyer.empsAuth.edit_buyer');
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

        $empsid = $request->emps_id;

        $bankDetail = DB::table('emps_buyer_auth')
            ->where('id', $empsid)->first();

       try {
           DB::transaction(function () use ($request, $id, $empsid ) {

                $file1_id = Null;
                $file2_id = Null;

                $data = [
                    // 'pmedrive_evoucher_copy_id' => $file1_id !== null ? $file1_id : null,
                    // 'pmedrive_self_copy_id' => $file1_id !== null ? $file2_id : null,
                    'pmedrive_dealer_status' => $request->formAction == 'S' ? 'S' : 'D',
                    'pmedrive_dealer_submitted_oem' => now(),
                    'pmedrive_oem_status' => null,
                ];

                if ($request->hasFile('evoucher_copy_file')) {

                    $file = $request->evoucher_copy_file;
                    $response = uploadFileWithCurl($file);
                    $file1_id = $response;
                    // $file1_id = 1;
                    $data['pmedrive_evoucher_copy_id'] = $file1_id;
                }

                if ($request->hasFile('cust_selfie_copy')) {

                    $file = $request->cust_selfie_copy;
                    $response = uploadFileWithCurl($file);
                    $file2_id = $response;
                    // $file2_id = 1;
                    $data['pmedrive_self_copy_id'] = $file2_id;
                }

                


                DB::table('emps_buyer_auth')->where('id', $empsid)->update($data);

            });
            if ($request->formAction == 'S') {
                alert()->success('Successfully Submitted to OEM', 'Success')->persistent('Close');
                return redirect()->route('empsbuyer.emps_auth');
            } elseif ($request->formAction == 'D') {
                alert()->success('Data has been successfully updated ')->persistent('Close');
                return redirect()->route('empsbuyer.edit', encrypt($bankDetail->id));
            }

       } catch (\Exception $e) {
           \Log::error('Error creating Buyer ID: ' . $e->getMessage());
           alert()->error('Something went wrong. Please try again.', 'Error')->persistent('Close');
           return redirect()->back()->withInput();
       }



    }


    public function evoucher($id)
    {

        $userId = decrypt($id);

        $detail = DB::table('emps_buyer_auth')
            ->where('buyer_id', $userId)
            ->first();

        $url = route("vcf");
        $qRCode = 'PM E-DRIVE Portal';
        $shortURL = 'TEst';

        $detail->formatedAmount = indian_format($detail->addmi_inc_amt);
        $detail->custmr_name = ucwords(strtolower($detail->custmr_name));

        return view('buyer.certificate', compact('qRCode', 'detail'));

        // dd($detail);
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

    public function export_data()
    {
        return Excel::download(new EmpsBuyerDetailsExport, 'buyers_details_emps.csv');
    }
}
