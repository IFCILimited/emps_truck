<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\User;
use App\Models\BuyerDetail;
use Exception;

class AckViewController extends Controller
{
    public function AckView($id)
    {
        try {
            $user = User::where('id', Auth::user()->id)->first();
            $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();
            $buyer = DB::table('buyer_details')->where('id', $id)->first();

            $detail = DB::table('vw_vin_details')->where('oem_id', $buyer->oem_id)->where('id', $buyer->production_id)->first();

            $type = DB::table('customer_doc_verf_type')->where('id', $buyer->custmr_id)->first();

            $sectype = DB::table('customer_doc_verf_type')->where('id', $buyer->addi_cust_id)->first();

            $maindata = DB::table('vw_vin_details')->where('oem_id', $buyer->oem_id)->where('id', $buyer->production_id)->first();

            $multibuyer = DB::table('multi_buyer_details')->where('buyer_id', $buyer->buyer_id)->first();

            // dd($buyer);

            return view('buyer.ackview', compact('user', 'oemname', 'detail', 'buyer', 'type', 'sectype', 'maindata', 'multibuyer'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }

    }
    public function FinallSubmit($id)
    {
        try {
            $result = DB::transaction(function () use ($id) {
                $segment = DB::table('buyer_details_view')->where('id', $id)->first();
                $result = $this->ClaimDataCheck($segment); //for count and sum check of buyer details

                if ($result['status'] === 'error') {
                    return $result;
                }

                $BuyerDetail = BuyerDetail::find($id);
                $BuyerDetail->status = 'S';
                $BuyerDetail->save();
                return ['status' => 'success'];
            });

            if ($result['status'] === 'error') {
                alert()->warning($result['message'], 'Warning')->persistent('Close');
                return redirect()->back();
            }

            alert()->success('Data has been successfully submitted', '')->persistent('Close');
            return redirect()->route('buyerdetail.index');

        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            alert()->error('An error occurred during submission.', 'Error')->persistent('Close');
            return redirect()->back();
        }
    }

    public function AckDoc($id)
    {
        // dd($id);
        try {
            $user = User::where('id', Auth::user()->id)->first();
            $bankDetail = DB::table('buyer_details_view as bd')
                ->where('id', $id)->first();
            // dd($bankDetail);

            $customerId = (int) $bankDetail->custmr_id;

            $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();

            $cat = DB::table('customer_doc_verf_type')
                ->where('id', $customerId)
                ->first();
            // dd($cat,$bankDetail->custmr_id);


            $type = DB::table('customer_doc_verf_type')->where('id', $bankDetail->addi_cust_id)->first();

            return view('buyer.ack_doc', compact('bankDetail', 'user', 'id', 'type', 'cat', 'oemname'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }

    }

    public function update(Request $request, $id)
    {
        // dd($request,$request->id);

        try {
            $existingBuyerDetail = BuyerDetail::where('vhcl_regis_no', $request->vhcl_regis_no)
                ->where('id', '!=', $id)
                ->first();


            if ($existingBuyerDetail) {
                alert()->error('The vehicle registration number already exists.', 'Error')->persistent('Close');
                return redirect()->back()->withInput();
            }

            // Call the API and store the response
            // dd($RCDetailAPI);

            $vreg = substr($request->vhcl_regis_no, 0, 2);
            $checkvahan = BuyerDetail::find($request->id);
            if ($vreg === 'TG' || $vreg === 'TR') {

            } elseif($checkvahan->vahanavailable == 'N' || $checkvahan->vahanavailable == null) {
                $RCDetailAPI = VahanRCAPI($request->vin);
                if ($RCDetailAPI) {
                    $record1 = BuyerDetail::find($request->id);
                    if ($record1->vhcl_regis_no == null ) {
                        if ($RCDetailAPI['status'] == true && $RCDetailAPI['prcn'] != null) {
                            $record = BuyerDetail::find($request->id);
                            $record->vahanavailable = 'Y';
                            $record->vhcl_regis_no = $RCDetailAPI['prcn'];
                            $record->vihcle_dt = $RCDetailAPI['prcndt'];
                            $record->save(); // Save the updated record
                        } elseif ($RCDetailAPI['status'] == false) {
                            $record = BuyerDetail::find($request->id);
                            alert()->warning('The RC Data is not available can not submit to OEM', '')->persistent('Close');
                            return redirect()->back();
                        } else {
                            alert()->warning('Something went wrong', '')->persistent('Close');
                            return redirect()->back();
                        }
                    }
                } elseif ($RCDetailAPI == false) {
                    alert()->warning('The RC Data is not available can not submit to OEM', '')->persistent('Close');
                    return redirect()->back();
                } else {
                    alert()->warning('The RC Data is not available can not submit to OEM', '')->persistent('Close');
                    return redirect()->back();
                }
            }
            $buyerID = Null;
            $oem_Status = Null;
            DB::transaction(function () use ($request, $id, &$buyerID, &$oem_Status) {

                $file3_id = Null;



                if ($request->hasFile('cst_ack_file')) {

                    $file = $request->cst_ack_file;
                    $response = uploadFileWithCurl($file);
                    $file1_id = $response;

                }

                if ($request->hasFile('invc_copy_file')) {

                    $file = $request->invc_copy_file;
                    $response = uploadFileWithCurl($file);
                    $file2_id = $response;

                }

                if ($request->hasFile('vhcl_reg_file')) {

                    $file = $request->vhcl_reg_file;
                    $response = uploadFileWithCurl($file);
                    $file3_id = $response;

                }

                if ($request->hasFile('evoucher_copy_file')) {

                    $file = $request->evoucher_copy_file;
                    $response = uploadFileWithCurl($file);
                    $file4_id = $response;

                }

                if ($request->hasFile('selfi_copy_file')) {

                    $file = $request->selfi_copy_file;
                    $response = uploadFileWithCurl($file);
                    $file5_id = $response;

                }

                // $BuyerDetail->gstin_id = $request->hasFile('gstncopy') ? $gstncopy_id : null;

                $BuyerDetail = BuyerDetail::find($id);
                // dd($BuyerDetail->oem_id);
                $oem_Status = $BuyerDetail->oem_status;
                $BuyerDetail->status = ($request->formAction == 'S') ? 'S' : 'A';
                $BuyerDetail->cst_ack_file = $file1_id !== null ? $file1_id : null;
                $BuyerDetail->invc_copy_file = $file2_id !== null ? $file2_id : null;
                $BuyerDetail->vhcl_reg_file = $file3_id !== null ? $file3_id : $BuyerDetail->vhcl_reg_file;
                $BuyerDetail->evoucher_copy_id = $file4_id !== null ? $file4_id : null;
                $BuyerDetail->self_copy_id = $file5_id !== null ? $file5_id : null;

                $BuyerDetail->vhcl_regis_no = $request->vhcl_regis_no;
                $BuyerDetail->vihcle_dt = $request->vihcle_dt;
                $BuyerDetail->buyer_submitted_at = now();
                $BuyerDetail->oem_remarks = Null;
                $BuyerDetail->oem_status = Null;
                $BuyerDetail->oem_status_at = Null;
                // $BuyerDetail->oem_id = Null;
                $BuyerDetail->save();

                $buyerID = $BuyerDetail->buyer_id;

            });

            if ($request->formAction == 'S') {
                
                $buyerAppr =  BuyerDetail::find($id);
                if((int)$buyerAppr->addmi_inc_amt == 0) {
                    alert()->warning("Incentive amount is zero", 'Cannot proceed with current request')->persistent('Close');
                    return redirect()->back();
                }

                alert()->success('Data has been successfully Updated', '')->persistent('Close');
            } else {
                $voucher = voucherSMS($buyerID); //for sms
                alert()->success('Data has been successfully submitted', '')->persistent('Close');
            }


            if ($oem_Status == 'R') {
                return redirect()->route('buyer.oemreturn');
            } else {
                return redirect()->route('buyerdetail.index');
            }

        } catch (Exception $e) {
            //dd($e);
            errorMail($e, Auth::user()->id);
            alert()->success('Something went wrong', 'Warning')->persistent('Close');
            return redirect()->back();
        }

    }

    public function view($id)
    {
        try {
            // dd(Auth::user()->id,$id);


            $user = User::where('id', Auth::user()->id)->first();
            $bankDetail = DB::table('buyer_details_view as bd')
                ->where('id', $id)->first();

            $customerId = (int) $bankDetail->custmr_id;
            if (Auth::user()->hasRole('OEM') == true) {
                $oemname = DB::table('users')->where('oem_id', Auth::user()->id)->first();
            } else {
                $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();
            }


            $cat = DB::table('customer_doc_verf_type')
                ->where('id', $customerId)
                ->first();
            // dd($cat);

            $type = DB::table('customer_doc_verf_type')->where('id', $bankDetail->addi_cust_id)->first();
            // dd($type);

            return view('buyer.view', compact('bankDetail', 'user', 'id', 'type', 'cat', 'oemname'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }


    public function OemReturn()
    {
        try {

            $bankDetail = DB::table('buyer_details_view')
                ->where('oem_status', 'R')
                ->where('dealer_id', Auth::user()->id)
                ->where('custmr_typ', 1)
                ->get();

            return view('buyer.oemreturn', compact('bankDetail'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }
    // for count and sum data check at buyer details submission page.
    private function ClaimDataCheck($segment)
    {
        $data = DB::table('buyer_details_view')->where('status', 'S')->get();
        if ($segment->segment_id == 1) {
            $count2W = $data->where('segment_id', $segment->segment_id)
                ->whereIn('vehicle_cat_id', [1, 2])
                ->count();
            $amt2W = $data->where('segment_id', $segment->segment_id)
                ->whereIn('vehicle_cat_id', [1, 2])
                ->sum('addmi_inc_amt');
            $amt2WInCrore = number_format($amt2W / 10000000, 2);

            if ($count2W > 500080) {
                return ['status' => 'error', 'message' => '2W count exceeds the limit'];
            } elseif ($amt2WInCrore > 500.08) {
                return ['status' => 'error', 'message' => '2W amount exceeds the limit'];
            }
        } elseif ($segment->segment_id == 2) {
            if ($segment->vehicle_cat_id == 3) {
                $count3W = $data->where('segment_id', $segment->segment_id)
                    ->where('vehicle_cat_id', $segment->vehicle_cat_id)
                    ->count();
                $amt3W = $data->where('segment_id', $segment->segment_id)
                    ->where('vehicle_cat_id', $segment->vehicle_cat_id)
                    ->sum('addmi_inc_amt');
                $amt3WInCrore = number_format($amt3W / 10000000, 2);

                if ($count3W > 13590) {
                    return ['status' => 'error', 'message' => '3W count exceeds the limit'];
                } elseif ($amt3WInCrore > 33.97) {
                    return ['status' => 'error', 'message' => '3W amount exceeds the limit'];
                }
            } elseif ($segment->vehicle_cat_id == 4) {
                $countL5 = $data->where('segment_id', $segment->segment_id)
                    ->where('vehicle_cat_id', $segment->vehicle_cat_id)
                    ->count();
                $amtL5 = $data->where('segment_id', $segment->segment_id)
                    ->where('vehicle_cat_id', $segment->vehicle_cat_id)
                    ->sum('addmi_inc_amt');
                $amtL5InCrore = number_format($amtL5 / 10000000, 2);

                if ($countL5 > 47119) {
                    return ['status' => 'error', 'message' => '3W (L5) count exceeds the limit'];
                } elseif ($amtL5InCrore > 235.60) {
                    return ['status' => 'error', 'message' => '3W (L5) amount exceeds the limit'];
                }
            }
        }

        return ['status' => 'success', 'message' => 'Check passed'];
    }
}
