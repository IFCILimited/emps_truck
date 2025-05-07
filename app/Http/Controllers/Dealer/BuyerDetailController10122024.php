<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\ModelVerification;
use App\Models\User;
use App\Models\DocumentUpload;
use App\Models\BuyerDetail;
use Exception;
use App\Models\SMS;
use App\Http\Requests\OtpRequest;
use Session;
use App\Exports\BuyerDetailsAllExport;
use Maatwebsite\Excel\Facades\Excel;
// use App\Http\request\BuyerDetailRequest;
// use App\Http\Requests\BuyerDetailRequest;


class BuyerDetailController extends Controller
{
    public function index(Request $request)
    {

        try {
            $pid = getParentId();
            $vin = null;
            $bankDetail = DB::table('buyer_details_view')
                ->where(function ($query) {
                    $query->where('oem_status', '!=', 'R')
                        ->orWhereNull('oem_status');
                })
                // ->where('dealer_id', Auth::user()->id)
                ->where('dealer_id', $pid)
                ->where('custmr_typ', 1)
                ->orderBy('buyer_details_view.id', 'DESC');

            if (isset($request->vin)) {
                $vin = $request->vin;
                $bankDetail->where('vin_chassis_no', 'like', '%' . $request->vin . '%');
            }
            $bankDetail->paginate(50);
            if (isset($request->vin)) {
                $bankDetails = $bankDetail->paginate(50)->appends(['vin' => $request->vin]);
            } else {
                $bankDetails = $bankDetail->paginate(50);
            }

            return view('buyer.index', compact('bankDetails', 'vin'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }

    }

    public function getcode($vin, $oemid)
    {
        // $pid=getParentId();
// dd($oemid);
        $vincheck = vehicleSoldORNot($vin);
        //dd($vincheck,'dd');
        // $responseData = json_decode($vincheck, true);
         //dd($responseData);
        // dd($vincheck->original['status']);

        // dd($vincheck->original['message'],$vincheck->original['message'] === 'Not Sold');
        if ($vincheck->original['message'] === 'Not Sold')
        // if ($vincheck== false)
        {
//dd('not s');
            $vinchasis = DB::table('vw_vin_details')->where('vin_chassis_no', $vin)->where('oem_id', $oemid)->get();
//Code by Rinki

$count = DB::table('buyer_details')->where('vin_chassis_no', $vin)->count();
            $RCDetailAPI = VahanRCAPI($vin);
            if($vinchasis->first()->vehicle_cat!=='L5' &&  $RCDetailAPI == true){
                $dt = $RCDetailAPI['prcndt'];
            }else{
                $dt=now();
            }            $tot_inc_amt = DB::select("SELECT fn_total_incentive_amount('$vin','$dt') AS total_incentive_amount")[0]->total_incentive_amount;


           // $count = DB::table('buyer_details')->where('vin_chassis_no', $vin)->count();

           // $tot_inc_amt = DB::select("SELECT total_incentive_amount('$vin') AS total_incentive_amount")[0]->total_incentive_amount;


           //  $RCDetailAPI = VahanRCAPI($vin);
             //For Check Purpose
            //  $RCDetailAPI = [
            //     'status' => TRUE,
            //     'prcn' => 'UP14ED2121', 
            //     'prcndt' => '01-12-2021', 
            //     'trcn' => 'T1121212121', 
            //     'tmpcndt' => '01-12-2021'
            //  ];

//dd($RCDetailAPI);
           

             //dd($RCDetailAPI,'ddd',$RCDetailAPI==false);
            if ($RCDetailAPI == false) {
                //dd('ddd');
                $response = array(
                    'data1' => $vinchasis,
                    'data2' => $count,
                    'data3' => $tot_inc_amt,
                    'data4' => false,
                    'data5' => Null,
                    'data6' => Null,
                    'data7' => Null,
		    'data8' => Null,
                );

            } else {

//dd('else');
                $response = array(
                    'data1' => $vinchasis,
                    'data2' => $count,
                    'data3' => $tot_inc_amt,
                    'data4' => $RCDetailAPI['status'],
                    'data5' => $RCDetailAPI['prcn'],
                    'data6' => $RCDetailAPI['prcndt'],
                    'data7' => $RCDetailAPI['trcn'],
		    'data8' => $RCDetailAPI['tmpcndt'],

                );
            }
        } else {
            $response = array(
                'data1' => $vincheck->original['message'],
                'data2' => Null,
                'data3' => Null,
                'data4' => false,
                'data5' => Null,
                'data6' => Null,
                'data7' => Null,
		'data8' => Null,
            );
        }

        // dd($response);

        return $response;
    }

    public function create()
    {

        try {
            $pid = getParentId();
            // $user = User::where('id', Auth::user()->id)->first();
            $user = User::where('id', $pid)->first();
            $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();
            $type = DB::table('customer_doc_verf_type')->whereNotIn('id', [1])->get();
            $minDate = '2024-10-01';
            $maxDate = '2026-03-31';

            return view('buyer.create', compact('user', 'type', 'oemname', 'minDate', 'maxDate'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }
    public function store(Request $request)
    {
        // dd($request);
        // try {
        $BuyerId = Null;
        $custmrName = $request->custmr_name;
        DB::transaction(function () use ($request, &$BuyerId) {

            // $sequenceValue = DB::select("SELECT NEXTVAL('sequence_buyer_id') AS next_value");
            // $BuyerIdSeq = $sequenceValue[0]->next_value;
            // $BuyerDB = $BuyerIdSeq * 10000;

            // $Random = random_int(1000, 9999);
            // $BuyerId = $BuyerDB + $Random;

            $sequenceValue = DB::select("SELECT NEXTVAL('sequence_buyer_id') AS next_value");
            $BuyerIdSeq = $sequenceValue[0]->next_value;
            $BuyerDB = $BuyerIdSeq * 10000;

            $Random = random_int(1000, 9999);
            $randid = $BuyerDB + $Random;
            $BuyerId = $randid + 1000000000;


            // // Pan Card
            if ($request->hasFile('pancopy')) {
                $file = $request->pancopy;
                $response = uploadFileWithCurl($file);
                $pancopy_id = $response;
            }

            // // GSTIN
            if ($request->hasFile('gstncopy')) {
                $file = $request->gstncopy;
                $response = uploadFileWithCurl($file);
                $gstncopy_id = $response;
            }


            // // Additional
            if ($request->hasFile('cust_sec_file')) {

                $file = $request->cust_sec_file;
                $response = uploadFileWithCurl($file);
                $additional_id = $response;
            }

            $BuyerDetail = new BuyerDetail;
            $BuyerDetail->oem_id = $request->oem_id;
            $BuyerDetail->dealer_id = $request->dealer_id;
            $BuyerDetail->vin_chassis_no = $request->vin;
            $BuyerDetail->production_id = $request->production_id;
            $BuyerDetail->segment_id = $request->segment_id;
            $BuyerDetail->custmr_typ = $request->custmr_typ;
            $BuyerDetail->custmr_name = $request->custmr_name;
            $BuyerDetail->email = $request->email;
            $BuyerDetail->add = $request->add;
            $BuyerDetail->landmark = $request->landmark;
            $BuyerDetail->pincode = $request->Pincode;
            $BuyerDetail->state = $request->State;
            $BuyerDetail->district = $request->District;
            $BuyerDetail->city = $request->City;
            $BuyerDetail->mobile = $request->mobile;
            $BuyerDetail->dob = $request->dob;
            $BuyerDetail->dlr_invoice_no = $request->dlr_invoice_no;
            $BuyerDetail->invoice_dt = $request->invoice_dt;
            $BuyerDetail->invoice_amt = $request->invoice_amt;
            $BuyerDetail->addmi_inc_amt = $request->addmi_inc_amt;
            $BuyerDetail->tot_inv_amt = $request->tot_inv_amt;
            $BuyerDetail->tot_admi_inc_amt = $request->tot_admi_inc_amt;
            $BuyerDetail->amt_custmr = $request->amt_custmr;
            $BuyerDetail->pan = $request->pan;
            $BuyerDetail->pancopy_id = $request->hasFile('pancopy') ? $pancopy_id : null;
            $BuyerDetail->gstin = $request->gstin;
            $BuyerDetail->gstin_id = $request->hasFile('gstncopy') ? $gstncopy_id : null;
            $BuyerDetail->cust_id_sec = $request->cust_id_sec;
            $BuyerDetail->addi_cust_id = $request->addi_cust_id;
            $BuyerDetail->sec_file_uploadeid = $additional_id != null ? $additional_id : null;
            $BuyerDetail->status = 'D';
            $BuyerDetail->vhcl_regis_no = $request->permanent_reg_no;
            $BuyerDetail->temp_reg_no = $request->temp_reg_no;
            $BuyerDetail->vihcle_dt = $request->permanent_reg_dt;
            $BuyerDetail->buyer_id = ($request->custmr_typ == 1) ? $BuyerId : $BuyerDetail->buyer_id;
            $BuyerDetail->adh_verify = ($request->custmr_typ == 1) ? 'N' : $BuyerDetail->adh_verify;

            $BuyerDetail->save();
        });
        if ($request->custmr_typ == 1) {

            alert()->success('<b>Customer ID: ' . $BuyerId . '</b><br><b>Customer Name: ' . $custmrName . '</b><br> successfully generated and saved.', 'Kindly note down the Customer ID. You will need it for authentication:')
                ->persistent('Close');
        } else {
            alert()->success('Data has been successfully save.', '')->persistent('Close');
        }
        return redirect()->route('buyerdetail.index');
        // } catch (Exception $e) {
        //     errorMail($e, Auth::user()->id);
        //     return redirect()->back();
        // }
    }


    public function edit($id)
    {
        try {
            // dd($id);
            $pid = getParentId();
            $type = DB::table('customer_doc_verf_type')->whereNotIn('id', [1])->get();

            // $user = User::where('id', Auth::user()->id)->first();
            $user = User::where('id', $pid)->first();

            $bankDetail = DB::table('buyer_details_view as bd')
                ->where('id', $id)->first();

            $prodDet = DB::table('production_data')->where('id', $bankDetail->production_id)->first();

            $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();

            $cat = DB::table('customer_doc_verf_type')
                ->whereIn('id', [2, 7])
                ->get();

            $minDate = '2024-10-01';
            $maxDate = '2026-03-31';

            return view('buyer.buyer_edit', compact('bankDetail', 'prodDet', 'user', 'id', 'type', 'cat', 'oemname', 'minDate', 'maxDate'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }

    }
    public function type($val)
    {

        // if($val == 1 && $stats == 'ASSAM'){
        //     $type = DB::table('customer_doc_verf_type')->wherein('id', [1,2])->get();
        //     // dd($type,1);
        // }
        // elseif($val == 1) {
        //     $type = DB::table('customer_doc_verf_type')->where('id', 1)->get();
        //     // dd($type,2);
        // }

        if ($val) {
            $type = DB::table('customer_doc_verf_type')->wherein('id', [2, 7])->get();
        }


        return $type;
    }

    public function CheckAdhar($name, $adhar, $segid)
    {
        // $data = DB::select("select check_data_exists('".$adhar."','".$segid."','".$name."')");
        // $data = DB::select('select check_data_exists(?, ?, ?)', [$adhar, $segid, $name]);

        // add 18-07-2024 mobile
        $data = DB::select('select check_data_exists_mobile(?, ?, ?)', [$adhar, $segid, $name]);
        return ['data' => $data];
    }

    //11-07-2024
    public function sendOtp($mobile, $otp)
    {

        // for Mobile OTP  Aadhar Verification ################################

        // $msg_mail = 'One Time Passowrd(OTP) for Login: ' . $otp . ' Do not share this OTP with anyone! IFCI Ltd';
        // $smsResponse = sendSMSAPI($mobile, $msg_mail);

        $portal_name = 'EMPS';
        $msg_mail = $otp . ' is the OTP to verify your mobile number with EMPS-2024 portal. %0A%0AKindly share this code with your dealer.' . $portal_name . ', IFCI LIMITED';
        $smsResponse = sendSMS($mobile, $msg_mail);

        // dd($smsResponse);
        if ($smsResponse === 'false') {
            $resp['error'] = 1;
            $resp['message'] = 'SMS not sent';
        } else {
            Session::put('verifyOTP', $otp);

            $resp['error'] = 0;
            $resp['message'] = 'OTP generated and sent.';
        }

    }

    public function verifybuyer(request $request, $otp)
    {
        $OTP = (int) $request->session()->get('verifyOTP');
        $enteredOtp = (int) $otp;

        // dd($OTP,$enteredOtp,($OTP === $enteredOtp));
        if ($OTP === $enteredOtp) {
            return 1;
        } else {
            return 2;
        }
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        $oem_Status = Null;
        try {
            DB::transaction(function () use ($request, $id, &$oem_Status) {

                $data = DB::table('buyer_details')->where('id', $id)->first();
                $oem_Status = $data->oem_status;

                $filedata = '';
                $file = '';

                $pancopy_id = Null;
                $gstin_id = Null;



                if ($request->hasFile('cust_sec_file')) {
                    $file = $request->cust_sec_file;
                    $response = uploadFileWithCurl($file);
                    $cust_sec_file_id = $response;
                }

                if ($request->hasFile('vhcl_reg_file')) {
                    $file = $request->vhcl_reg_file;
                    $response = uploadFileWithCurl($file);
                    $vhcl_reg_file_id = $response;
                }

                // // Pan Card
                if ($request->hasFile('pancopy')) {
                    $file = $request->pancopy;
                    $response = uploadFileWithCurl($file);
                    $pancopy_id = $response;
                }

                // // GSTIN
                if ($request->hasFile('gstncopy')) {
                    $file = $request->gstncopy;
                    $response = uploadFileWithCurl($file);
                    $gstin_id = $response;
                }

                $BuyerDetail = BuyerDetail::find($id);

                // $BuyerDetail->production_id = $request->production_id == null ? $request->prod_id : $request->production_id;
                // $BuyerDetail->custmr_typ = $request->custmr_typ;
                $BuyerDetail->custmr_name = $request->custmr_name;
                $BuyerDetail->email = $request->email;

                if ($request->custmr_typ != 1) {
                    $BuyerDetail->add = $request->add;
                    $BuyerDetail->landmark = $request->landmark;
                    $BuyerDetail->pincode = $request->Pincode;
                    $BuyerDetail->state = $request->State;
                    $BuyerDetail->district = $request->District;
                    $BuyerDetail->city = $request->City;
                    $BuyerDetail->mobile = $request->mobile;
                    $BuyerDetail->dob = $request->dob;
                }
                $BuyerDetail->dlr_invoice_no = $request->dlr_invoice_no;
                $BuyerDetail->invoice_dt = $request->invoice_dt;
                $BuyerDetail->invoice_amt = $request->invoice_amt;
                $BuyerDetail->addmi_inc_amt = $request->addmi_inc_amt;
                $BuyerDetail->tot_inv_amt = $request->tot_inv_amt;
                $BuyerDetail->tot_admi_inc_amt = $request->tot_admi_inc_amt;
                $BuyerDetail->amt_custmr = $request->amt_custmr;
                $BuyerDetail->pan = $request->pan;


                $BuyerDetail->gstin = $request->gstin;

                // file
                $BuyerDetail->pancopy_id = $pancopy_id != null ? $pancopy_id : $BuyerDetail->pancopy_id;
                $BuyerDetail->gstin_id = $gstin_id != null ? $gstin_id : $BuyerDetail->gstin_id;
                $BuyerDetail->sec_file_uploadeid = $request->hasFile('cust_sec_file') ? $cust_sec_file_id : $BuyerDetail->sec_file_uploadeid;
                $BuyerDetail->vhcl_reg_file = $request->hasFile('vhcl_reg_file') ? $vhcl_reg_file_id : $BuyerDetail->vhcl_reg_file;

                $BuyerDetail->addi_cust_id = $request->addi_cust_id;
                $BuyerDetail->cust_id_sec = $request->cust_id_sec;
                $BuyerDetail->vhcl_regis_no = $request->vhcl_regis_no;
                $BuyerDetail->vihcle_dt = $request->vihcle_dt;
                $BuyerDetail->temp_reg_no = $request->temp_reg;

                // $BuyerDetail->status = $request->formAction === 'S' ? 'S' : ($request->formAction === 'A' ? 'A' : 'D');
                $BuyerDetail->status = $request->formAction === 'S' ? 'S' : ($request->formAction === 'A' ? 'A' : ($request->formAction === 'P' ? 'P' : 'D'));

                $BuyerDetail->buyer_submitted_at = $request->formAction === 'A' ? now() : null;

                $BuyerDetail->vhcl_regis_no = $request->vhcl_regis_no;
                $BuyerDetail->vihcle_dt = $request->vihcle_dt;

                if ($request->temp_reg) {
                    $BuyerDetail->temp_reg_no = $request->temp_reg;
                }
                $BuyerDetail->save();

                // DB::table('buyers_aadhar')->insert([
                //     'buyer_id' => $BuyerDetail->id,
                //     'aadhar_number' => $request->custmr_id_no,
                // ]);

            });
            alert()->success('Data has been successfully updated.', '')->persistent('Close');

            if ($oem_Status == 'R') {
                return redirect()->route('buyer.oemreturn');
            } else {
                return redirect()->route('buyerdetail.index');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
            errorMail($e, Auth::user()->id);
            return redirect()->route('buyerdetail.index');
        }

    }

    public function aadhar_api_data(request $request)
    {

        // dd($request->all());
        // $customer = json_decode($cust);
        $ipAddress = $_SERVER['REMOTE_ADDR'];

        $apiStore = DB::table('aadhar_api_data')->insert([
            'name' => $request->CustomerName,
            'mobile' => $request->Mobile,
            'aadharno' => $request->AadharNumber,
            'ip' => $ipAddress,
            'api_resp' => $request->rep,
            'user_id' => Auth::user()->id,
        ]);

        return true;


    }
    public function updateTempReg(Request $request)
    {
        

        if($request->target=='temp' || $request->target=='perm' || $request->target=='both' )
        {
            // dd($request,$request->id);

            $existingBuyerDetail = BuyerDetail::where('vhcl_regis_no', $request->vhcl_regis_no)
                ->where('id', '!=', $request->id)
                ->first();
                // dd($existingBuyerDetail);
    
    
            if ($existingBuyerDetail) {
                $message = 'The vehicle registration number already exists.';
            }
            // Find the record by ID and update the temp_reg value
            $record = BuyerDetail::find($request->id); // replace YourModel with your actual model
            // dd($record);
            if($request->target == "both") {
                $record->temp_reg_no = $request->tempVal;
                $record->vhcl_regis_no = $request->permVal;
                $message = "Temporary & Permanent Registration Number updated successfully.";
            }else if($request->target == "perm"){
                $record->vhcl_regis_no = $request->permVal;
                $message = "Permanent Registration Number updated successfully.";
            }else{
                $record->temp_reg_no = $request->tempVal;
                $message = "Temporary Registration Number updated successfully.";
            }
    
            if ($record) {
                $record->vahanavailable = 'N';
                $record->save();
                return response()->json(['message' => $message]);
            } else {
                return response()->json(['message' => 'Record not found.'], 404);
            }

        }else{

        $RCDetailAPI = VahanRCAPI($request->vin); // Call the API and store the response

        // Check if the status is true
        if ($RCDetailAPI) {
            if ($RCDetailAPI['status'] == true && $RCDetailAPI['prcn'] != null) {
                $record = BuyerDetail::find($request->id);
                // Update the record with the RC details
                $record->vhcl_regis_no = $RCDetailAPI['prcn'];
                $record->vihcle_dt = $RCDetailAPI['prcndt'];
                $record->vahanavailable = 'Y';
                $record->save(); // Save the updated record


                $json = response()->json([
                    'message' => 'The permanent RC details have been successfully updated.',
                    'status' => $RCDetailAPI['status'],
                    'prcn' => $RCDetailAPI['prcn'],
                    'prcndt' => $RCDetailAPI['prcndt'],
                ]);
            } else {
                // Return message if RC data is not available
                $json = response()->json([
                    'message' => 'The RC Data is not available on vahan, Please enter manually',
                    'status' => $RCDetailAPI['status'],
                    'prcn' => $RCDetailAPI['prcn'],
                    'prcndt' => $RCDetailAPI['prcndt'],
                ]);
            }
        } else {
            $json = response()->json([
                'status' => 'N',
                'message' => 'Unable to fetch RC detail from vahan, Try again.',
                'status' => false,
            ]);
        }

        return $json; // Return the response
    }


        // // try{
        //     $existingBuyerDetail = BuyerDetail::where('vhcl_regis_no', $request->vhcl_regis_no)
        //     ->where('id', '!=', $request->id)
        //     ->first();
        //     dd($existingBuyerDetail);


        // if ($existingBuyerDetail) {
        //     // alert()->error('The vehicle registration number already exists.', 'Error')->persistent('Close');
        //     // return redirect()->back()->withInput();
        //     $message = 'The vehicle registration number already exists.';
        // }
        // Find the record by ID and update the temp_reg value
        // $record = BuyerDetail::find($request->id); // replace YourModel with your actual model
        // // dd($record);
        // if($request->target == "both") {
        //     $record->temp_reg_no = $request->tempVal;
        //     $record->vhcl_regis_no = $request->permVal;
        //     $message = "Temporary & Permanent Registration Number updated successfully.";
        // }else if($request->target == "perm"){
        //     $record->vhcl_regis_no = $request->permVal;
        //     $message = "Permanent Registration Number updated successfully.";
        // }else{
        //     $record->temp_reg_no = $request->tempVal;
        //     $message = "Temporary Registration Number updated successfully.";
        // }

        // if ($record) {
        //     $record->save();
        //     return response()->json(['message' => $message]);
        // } else {
        //     return response()->json(['message' => 'Record not found.'], 404);
        // }

        // }catch(Exception $e){
        //     return response()->json(['message' => 'Something Went Wrong'], 500);
        // }

    }

    public function exportData()
    {
        return Excel::download(new BuyerDetailsAllExport, 'buyers_details.csv');
    }

    public function searchVin(Request $request)
    {
        // dd($request->all());
        try {
            $bankDetails = DB::table('buyer_details_view')
                ->where(function ($query) {
                    $query->where('oem_status', '!=', 'R')
                        ->orWhereNull('oem_status');
                })
                ->where('dealer_id', Auth::user()->id)
                ->where('vin_chassis_no', 'like', '%' . $request->vin_num . '%')
                ->orderBy('buyer_details_view.id', 'DESC')
                ->paginate(50);
            return view('buyer.index', compact('bankDetails'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }


}
