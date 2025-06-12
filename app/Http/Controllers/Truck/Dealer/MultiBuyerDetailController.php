<?php

namespace App\Http\Controllers\Truck\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\ModelVerification;
use App\Models\User;
use App\Models\DocumentUpload;
use App\Models\Trucks\BuyerDetail;
use Exception;
use Illuminate\Support\Carbon;
use App\Models\SMS;
use App\Http\Requests\OtpRequest;
use Session;
use App\Exports\MultiBuyerAllDetailExport;
use App\Models\Trucks\TruckCdInformation;
use Maatwebsite\Excel\Facades\Excel;

class MultiBuyerDetailController extends Controller
{
    public function index()
    {
        try {
            // dd(Auth::user()->id);
            $custId = null;

            // $dealerDetail = DB::table('multi_buyer_details')->where('dealer_id', Auth::user()->id)->whereNotIn('oem_status', ['R'])->orWhereNull('oem_status');

            $dealerDetail = DB::table('multi_buyer_details_trucks')->where(function ($query) {
                $query->where('dealer_id', '=', getParentId())
                    ->where(function ($subQuery) {
                        $subQuery->where('oem_status', '!=', 'R')
                            ->orWhereNull('oem_status');
                    });
            });

            if (isset($request->vin)) {
                $vin = $request->vin;
                $dealerDetail->where('buyer_id', 'like', '%' . $request->vin . '%');
            }
            $dealerDetail->orderBy('id', 'DESC');
            // $dealerDetail->paginate(50);
            if (isset($request->vin)) {
                $dealerDetails = $dealerDetail->paginate(50)->appends(['vin' => $request->vin]);
                $custId = $request->vin;
            } else {
                $dealerDetails = $dealerDetail->paginate(50);
            }

            // $dealerDetails = DB::table('multi_buyer_details')->paginate(50);

            return view('truck.buyer.bulkbuyer.multi_buyer_index', compact('dealerDetails', 'custId'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // dd($e->getMessage());
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function multiCreate()
    {
        try {
            $user = User::where('id', Auth::user()->id)->first();
            $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();
            $type = DB::table('customer_doc_verf_type')->whereIn('id', [7, 9, 2])->get();
            $minDate = '2024-10-01';
            $maxDate = '2026-03-31';
            // dd($minDate);

            return view('truck.buyer.bulkbuyer.create_multiple_2', compact('user', 'type', 'oemname', 'minDate', 'maxDate'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // dd($e->getMessage());
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function multiEdit($id)
    {
        ini_set('memory_limit', '7048M');
        ini_set('max_execution_time', 7600);
        try {
            // dd($id);
            $rowId = decrypt($id);
            $multiBuyerDetail = DB::table('multi_buyer_details_trucks')->where('id', $rowId)->first();

            $vins = json_decode($multiBuyerDetail->vin_map, true);
            // dd($vins[array_keys($vins)[0]]);

            //first vin id
            $id = $vins[array_keys($vins)[0]];

            $type = DB::table('customer_doc_verf_type')->whereIn('id', [7, 9, 2])->get();

            $user = User::where('id', Auth::user()->id)->first();

            $productionDetails = [];
            foreach ($vins as $vin => $buyerTableId) {


                $productionDetails[$vin] = DB::table('buyer_details_trucks as bd')
                    ->select('bd.*')
                    ->where('bd.id', $buyerTableId)->first();

                // $productionDetails[$vin] = DB::table('buyer_details_view as bd')
                //     ->select('prd.manufacturing_date', 'bd.*')
                //     ->join('production_data as prd', 'prd.id', '=', 'bd.production_id')
                //     ->where('bd.id', $buyerTableId)->first();
            }
            // dd($productionDetails);
            $bankDetail = DB::table('buyer_details_trucks_view as bd')
                ->where('id', $id)->first();
            // dd($bankDetail);

            $prodDet = DB::table('trucks_production_data')->where('id', $bankDetail->production_id)->first();
            // dd($productionDetails, $prodDet);

            $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();

            // $cat = DB::table('customer_doc_verf_type')
            //     ->whereIn('id', [2, 7])
            //     ->get();

            // dd($productionDetails, $type);
            $minDate = '2024-04-01';
            $maxDate = '2026-03-31';
            // dd($multiBuyerDetail);
            return view('truck.buyer.bulkbuyer.buyer_multi_edit', compact('bankDetail', 'productionDetails', 'user', 'id', 'type', 'oemname', 'minDate', 'maxDate', 'vins', 'rowId', 'multiBuyerDetail'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }


    public function multiExportData()
    {
        // dd("hey");
        return Excel::download(new MultiBuyerAllDetailExport(), 'multi_buyers_details.csv');
    }


    public function mangeInvoicePreview($id, $rowId, $flag, $userType)
    {
        ini_set('memory_limit', '7048M');
        ini_set('max_execution_time', 7600);
        try {

            // $id = decrypt($id);
            $rowId = decrypt($rowId);
            $multiBuyerDetail = DB::table('multi_buyer_details_trucks')->where('id', $rowId)->first();

            $type = DB::table('customer_doc_verf_type')->whereIn('id', [7, 9, 2])->get();

            // $user = User::where('id', Auth::user()->id)->first();
            $user = User::where('id', $multiBuyerDetail->created_by)->first();

            $bankDetail = DB::table('buyer_details_trucks_view as bd')
                ->where('id', $id)->first();

            $prodDet = DB::table('trucks_production_data')->where('id', $bankDetail->production_id)->first();

            // $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();
            $oemname = DB::table('users')->where('id', $user->oem_id)->first();

            $cdInfo = DB::table('truck_cd_information')
                ->where('vin_chassin_no', $bankDetail->vin_chassis_no)->get();
                // dd($cdInfo);

            $minDate = '2024-04-01';
            $maxDate = '2025-09-30';

            return view('truck.buyer.bulkbuyer.buyer_multi_invoice_preview', compact('cdInfo', 'userType', 'bankDetail', 'prodDet', 'user', 'id', 'type', 'oemname', 'minDate', 'maxDate', 'rowId', 'flag'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // errorMail($e, Auth::user()->id);
            // dd($e->getMessage());
            return redirect()->back();
        }
    }

    public function manageInvoice($id, $rowId)
    {
        try {
            // $id = decrypt($id);
            $rowId = decrypt($rowId);
            // dd($id, $rowId);

            $type = DB::table('customer_doc_verf_type')->whereIn('id', [7, 9, 2])->get();

            $user = User::where('id', Auth::user()->id)->first();

            $bankDetail = DB::table('buyer_details_trucks_view as bd')
                ->where('id', $id)->first();

            $cdinformation = DB::table('truck_cd_information')
                ->where('vin_chassin_no', $bankDetail->vin_chassis_no)->get();

            $prodDet = DB::table('trucks_production_data')->where('id', $bankDetail->production_id)->first();

            $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();

            $minDate = '2024-04-01';
            $maxDate = '2026-03-31';
            // dd($bankDetail);

            return view('truck.buyer.bulkbuyer.buyer_multi_invoice', compact('cdinformation', 'bankDetail', 'prodDet', 'user', 'id', 'type', 'oemname', 'minDate', 'maxDate', 'rowId'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function managePreview($id, $userType)
    {
        try {
            $rowId = decrypt($id);
            $multiBuyerDetail = DB::table('multi_buyer_details')->where('id', $rowId)->first();

            $vins = json_decode($multiBuyerDetail->vin_map, true);

            //first vin id
            $id = $vins[array_keys($vins)[0]];

            $type = DB::table('customer_doc_verf_type')->whereIn('id', [7, 9, 2])->get();

            // $user = User::where('id', Auth::user()->id)->first();
            $user = User::where('id', $multiBuyerDetail->created_by)->first();

            $productionDetails = [];
            foreach ($vins as $vin => $buyerTableId) {
                $productionDetails[$vin] = DB::table('buyer_details_view as bd')
                    ->select('prd.manufacturing_date', 'bd.*')
                    ->join('production_data as prd', 'prd.id', '=', 'bd.production_id')
                    ->where('bd.id', $buyerTableId)->first();
            }
            $bankDetail = DB::table('buyer_details_view as bd')
                ->where('id', $id)->first();

            $prodDet = DB::table('production_data')->where('id', $bankDetail->production_id)->first();

            // $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();
            $oemname = DB::table('users')->where('id', $user->oem_id)->first();
            $minDate = '2024-04-01';
            $maxDate = '2025-09-30';

            return view('truck.buyer.bulkbuyer.buyer_multi_edit_preview', compact('userType', 'bankDetail', 'productionDetails', 'user', 'id', 'type', 'oemname', 'minDate', 'maxDate', 'vins', 'rowId', 'multiBuyerDetail'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function multiUpdate($id, Request $request)
    {
        // dd($request->all(), $id);
        try {
            DB::transaction(function () use ($request, $id) {

                $file = '';

                $BuyerDetail = BuyerDetail::find($id);
                // dd($BuyerDetail);
                $buyerData = [];

                if ($request->hasFile('cust_sec_file')) {
                    $file = $request->cust_sec_file;
                    $response = uploadFileWithCurl($file);
                    $cust_sec_file_id = $response;
                    // $cust_sec_file_id = 2;
                    // $BuyerDetail->sec_file_uploadeid = $cust_sec_file_id;
                    $buyerData['sec_file_uploadeid'] = $cust_sec_file_id;
                }
                $buyerData['auth_per_name'] = $request->authr_per_name;
                $buyerData['custmr_typ'] = $request->custmr_typ;
                $buyerData['custmr_name'] = $request->custmr_name;
                $buyerData['addi_cust_id'] = $request->addi_cust_id;
                $buyerData['cust_id_sec'] = $request->cust_id_sec;

                BuyerDetail::where('buyer_id', $request->buyer_id)->update($buyerData);

                // $BuyerDetail->auth_per_name = $request->authr_per_name;
                // $BuyerDetail->custmr_typ = $request->custmr_typ;
                // $BuyerDetail->custmr_name = $request->custmr_name;
                // $BuyerDetail->addi_cust_id = $request->addi_cust_id;
                // $BuyerDetail->cust_id_sec = $request->cust_id_sec;
                // $BuyerDetail->save();

                DB::table('multi_buyer_details')->where('buyer_id', $request->buyer_id)->update([
                    'cmpny_addr' => $request->add,
                    'cmpny_land' => $request->landmark,
                    'cmpny_pin' => $request->Pincode,
                    'cmpny_state' => $request->State,
                    'cmpny_dist' => $request->District,
                    'cmpny_city' => $request->City,
                    'cmpny_mobile' => $request->mobile,
                    'customer_name' => $request->custmr_name,
                    'auth_prs_name' => $request->authr_per_name
                ]);
            });
            alert()->success('Data has been updated successfully.', '')->persistent('Close');

            return redirect()->back();
        } catch (Exception $e) {
            // dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function generateId(Request $request)
    {

        try {
            //check duplicates in vin numbers
            $vins = $request->vin;
            $duplicates = array_filter(array_count_values($vins), function ($count) {
                return $count > 1;
            });

            // Display duplicates
            if (!empty($duplicates)) {
                echo "Duplicates: " . implode(", ", array_keys($duplicates));
                alert()->error('', "Duplicate VIN's are not allowed.")->persistent('Close');
                return redirect()->back();
            }

            $BuyerId = Null;
            $custmrName = $request->custmr_name;
            DB::transaction(function () use ($request, &$BuyerId, $vins) {
                // $sequenceValue = DB::select("SELECT NEXTVAL('sequence_buyer_id') AS next_value");
                // $BuyerIdSeq = $sequenceValue[0]->next_value;
                // $BuyerDB = $BuyerIdSeq * 10000;

                // $Random = random_int(1000, 9999);
                // $randid = $BuyerDB + $Random;
                // $BuyerId = $randid + 1000000000;
                $BuyerId = gernerateBuyerId();

                // Additional
                if ($request->hasFile('cust_sec_file')) {

                    $file = $request->cust_sec_file;
                    $response = uploadFileWithCurl($file);
                    $additional_id = $response;
                    // $additional_id = 1;
                }

                $insertedIds = [];
                foreach ($vins as $idx => $vin) {
                    // dd($idx, $vin, $BuyerId);
                    $BuyerDetail = new BuyerDetail;
                    $BuyerDetail->oem_id = $request->oem_id;
                    // $BuyerDetail->dealer_id = $request->dealer_id;
                    $BuyerDetail->dealer_id = getParentId();
                    $BuyerDetail->child_id = Auth::user()->id;


                    //multiple vins
                    $BuyerDetail->vin_chassis_no = $vin;
                    $BuyerDetail->production_id = $request->production_id[$idx];
                    $BuyerDetail->segment_id = $request->segment_id[$idx];

                    // $BuyerDetail->temp_reg_no = $request->temp_reg[$idx];
                    $BuyerDetail->vhcl_regis_no = $request->perm_reg[$idx];
                    $BuyerDetail->vihcle_dt = $request->perm_reg_date[$idx];

                    //auth name
                    $BuyerDetail->auth_per_name = $request->auth_per_name;
                    $BuyerDetail->custmr_typ = $request->custmr_typ;
                    $BuyerDetail->custmr_name = $request->custmr_name;
                    $BuyerDetail->add = $request->add;
                    $BuyerDetail->landmark = $request->landmark;
                    $BuyerDetail->pincode = $request->Pincode;
                    $BuyerDetail->state = $request->State;
                    $BuyerDetail->district = $request->District;
                    $BuyerDetail->city = $request->City;
                    $BuyerDetail->mobile = $request->mobile;
                    $BuyerDetail->addi_cust_id = $request->addi_cust_id;
                    $BuyerDetail->cust_id_sec = $request->cust_id_sec;
                    $BuyerDetail->sec_file_uploadeid = $additional_id != null ? $additional_id : null;
                    $BuyerDetail->status = 'D';
                    $BuyerDetail->buyer_id = $BuyerId;
                    $BuyerDetail->adh_verify = 'N';

                    $BuyerDetail->addmi_inc_amt = $request->addmi_inc_amt[$idx];
                    $BuyerDetail->tot_admi_inc_amt = $request->tot_adm_inc_amt[$idx];

                    //not null fields
                    $BuyerDetail->dlr_invoice_no = "";
                    $BuyerDetail->amt_custmr = 0;
                    $BuyerDetail->invoice_amt = 0;
                    $BuyerDetail->tot_inv_amt = 0;

                    $BuyerDetail->save();
                    // dd($BuyerDetail->id);
                    $insertedIds[$vin] = $BuyerDetail->id;
                }
                $pid = getParentId();
                // dd($pid);

                DB::table('multi_buyer_details_trucks')->insert([
                    'dealer_id' => $pid,
                    'created_by' => Auth::user()->id,
                    'buyer_id' => $BuyerId,
                    'customer_name' => $request->custmr_name,
                    'auth_prs_name' => $request->auth_per_name,
                    'status' => 'D',
                    'oem_status' => 'D',
                    'vin_count' => count($vins),
                    'vin_map' => json_encode($insertedIds),
                    'adh_verify' => 'N',
                    'cmpny_addr' => $request->add,
                    'cmpny_land' => $request->landmark,
                    'cmpny_pin' => $request->Pincode,
                    'cmpny_state' => $request->State,
                    'cmpny_dist' => $request->District,
                    'cmpny_city' => $request->City,
                    'cmpny_mobile' => $request->mobile,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'submitted_at' => Carbon::now()
                ]);
            });


            alert()->success('<b>Customer ID: ' . $BuyerId . '</b><br><b>Customer Name: ' . $custmrName . '</b><br> successfully generated and saved.', 'Kindly note down the Customer ID. You will need it for authentication:')
                ->persistent('Close');

            return redirect()->route('e-trucks.buyerdetail.multi_buyers');
        } catch (Exception $e) {
            dd($e);
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function manageInvoiceDocs(Request $request)
    {
        // dd($request);
        try {

            $mid = DB::table('trucks_production_data')->where('vin_chassis_no', $request->vin)->first();
            // $fn = CheckValidity($request->invoice_dt,$mid->model_master_id);

            // // dd($fn);\
            // if($fn == false){
            //     alert()->warning('Invoice date is outside PM E-DRIVE certificate date.', 'warning')->persistent('Close');

            //     return redirect()->route('e-trucks.buyerdetail.multi_buyers');
            // }

            // dd($request->all());
            $id = $request->bankDetailRowId;
            // $cdEntries = [];
            DB::transaction(function () use ($request, $id) {

                $file = '';

                $BuyerDetail = BuyerDetail::find($id);

                if ($request->hasFile('vhcl_reg_file')) {
                    $file = $request->vhcl_reg_file;
                    $response = uploadFileWithCurl($file);
                    $vhcl_reg_file = $response;
                    // $vhcl_reg_file = 2;
                    $BuyerDetail->vhcl_reg_file = $vhcl_reg_file;
                }

                if ($request->hasFile('cst_ack_file')) {
                    $file = $request->cst_ack_file;
                    $response = uploadFileWithCurl($file);
                    $cust_sec_file_id = $response;
                    // $cust_sec_file_id = 2;
                    $BuyerDetail->cst_ack_file = $cust_sec_file_id;
                }

                if ($request->hasFile('invc_copy_file')) {
                    $file = $request->invc_copy_file;
                    $response = uploadFileWithCurl($file);
                    $invc_copy_file = $response;
                    // $invc_copy_file = 2;
                    $BuyerDetail->invc_copy_file = $invc_copy_file;
                }

                if ($request->hasFile('evoucher_copy_file')) {
                    $file = $request->evoucher_copy_file;
                    $response = uploadFileWithCurl($file);
                    $evoucher_copy_file = $response;
                    // $evoucher_copy_file = 2;
                    $BuyerDetail->evoucher_copy_id = $evoucher_copy_file;
                }

                if ($request->hasFile('selfi_copy_file')) {
                    $file = $request->selfi_copy_file;
                    $response = uploadFileWithCurl($file);
                    $self_copy_id = $response;
                    // $self_copy_id = 2;
                    $BuyerDetail->self_copy_id = $self_copy_id;
                }

                $BuyerDetail->dlr_invoice_no = $request->dlr_invoice_no;
                $BuyerDetail->invoice_dt = $request->invoice_dt;
                $BuyerDetail->invoice_amt = $request->invoice_amt;
                $BuyerDetail->addmi_inc_amt = $request->addmi_inc_amt;
                $BuyerDetail->tot_inv_amt = $request->tot_inv_amt;
                $BuyerDetail->tot_admi_inc_amt = $request->tot_admi_inc_amt;
                $BuyerDetail->amt_custmr = $request->amt_custmr;

                //registration details update
                // $BuyerDetail->temp_reg_no = $request->temp_reg;
                $BuyerDetail->vhcl_regis_no = $request->vhcl_regis_no;
                $BuyerDetail->vihcle_dt = $request->vihcle_dt;


                // $BuyerDetail->custmr_typ = $request->customer_type;

                $BuyerDetail->save();

                $buyerDetailId = $BuyerDetail->id;
                foreach ($request->data as $val) {
                    $CdDetail = new TruckCdInformation();
                    $CdDetail->cd_number = $val['cdnumber'];
                    $CdDetail->cd_owner_name = $val['cd_owner_name'];
                    $CdDetail->vehicle_gvw = $val['gvw'];
                    $CdDetail->vin_scrapped = $val['vin_no'];
                    $CdDetail->status_flag = $val['status'];
                    $CdDetail->cd_issue_date = $val['cd_issue_date'];
                    $CdDetail->cd_validity_upto = $val['cd_validation_date'];
                    $CdDetail->buyer_detail_id = $buyerDetailId;
                    $CdDetail->vin_chassin_no = $request->vin;
                    $CdDetail->cd_status = 'L';
                    $CdDetail->save();
                }
                // $cdEntries = TruckCdInformation::where('buyer_detail_id', $buyerDetailId)->get();

            });
            alert()->success('Data has been updated successfully.', '')->persistent('Close');

            return redirect()->back();
            // return view('truck.buyer.bulkbuyer.buyer_multi_invoice', compact('cdEntries'));
        } catch (Exception $e) {
            dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    public function manageOemSubmit(Request $request)
    {

        $rowId = decrypt($request->row_id);


        $multiData = DB::table('multi_buyer_details_trucks')->where('id', $rowId)->first();
        $buyer_entries = DB::table('buyer_details_trucks')->where('buyer_id', $multiData->buyer_id)->get();

        foreach ($buyer_entries as $buyer) {
            if ((int)$buyer->addmi_inc_amt == 0) {
                alert()->warning("Incentive amount is zero", 'Cannot proceed with current request')->persistent('Close');
                return redirect()->back();
            }
        }

        // $multiData = DB::table('multi_buyer_details')->where('id', $rowId)->first();
        // dd("submit it", $multiData);
        // dd($request->all());

        $buyerId = $multiData->buyer_id;
        $vinCount = $multiData->vin_count;

        $buyerData = DB::table('buyer_details_trucks')->where(['buyer_id' => $buyerId, 'status' => 'S'])->count();

        if ($buyerData == $vinCount) {

            $allVins = json_decode($multiData->vin_map, true);
            // dd("submit it", $allVins);

            // foreach($allVins as $vin => $id){
            //     $RCDetailAPI = VahanRCAPI($vin);

            //     if ($RCDetailAPI) {
            //         if ($RCDetailAPI['status'] == true && $RCDetailAPI['prcn'] != null) {
            //             $record = BuyerDetail::find($id);
            //             $record->vahanavailable = 'Y';
            //             $record->vhcl_regis_no = $RCDetailAPI['prcn'];
            //             $record->vihcle_dt = $RCDetailAPI['prcndt'];
            //             $record->save();
            //         } elseif($RCDetailAPI['status'] == false) {
            //             alert()->warning('The RC Data is not available for VIN '.$vin.' can not submit to OEM', '')->persistent('Close');
            //             return redirect()->back();
            //         }else{
            //             alert()->warning('Something went wrong', '')->persistent('Close');
            //             return redirect()->back();
            //         }
            //     }elseif($RCDetailAPI["status"] == false){
            //         alert()->warning('The RC Data is not available for VIN '.$vin.' can not submit to OEM', '')->persistent('Close');
            //         return redirect()->back();
            //     }else{
            //         alert()->warning('The RC Data is not available for VIN '.$vin.' can not submit to OEM', '')->persistent('Close');
            //         return redirect()->back();
            //     }
            // }

            DB::table('buyer_details_trucks')->where('buyer_id', $buyerId)->update(['status' => 'A', 'buyer_submitted_at' => Carbon::now()]);

            //submit to oem
            DB::table('multi_buyer_details_trucks')->where('id', $rowId)->update([
                'status' => 'A',
                'oem_status' => NULL,
                'submitted_at' => Carbon::now(),
                'submited_by' => Auth::user()->id
            ]);
            alert()->success('Success', 'Submitted to OEM successfully.')->persistent('Close');

            return redirect()->route("e-trucks.buyerdetail.multi_buyers");
        }

        alert()->error('Error', "Kindly add details of all the VIN's")->persistent('Close');

        return redirect()->back();
    }

    public function manageInvoiceDocsSubmit(Request $request)
    {
        try {
            // dd($request->all());
            $id = decrypt($request->buyer_row_id);
            $rowId = decrypt(($request->row_id));
            // dd($id);
            DB::transaction(function () use ($request, $id) {
                $BuyerDetail = BuyerDetail::find($id);
                $BuyerDetail->status = "S";

                $BuyerDetail->save();
            });
            alert()->success('Submitted successfully!', '')->persistent('Close');

            return redirect()->route('e-trucks.buyerdetail.multi_detail_edit', encrypt($rowId));
        } catch (Exception $e) {
            // dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }


    public function BulkOemReturn(Request $request)
    {
        try {
            $custId = null;
            //$dealerDetail = DB::table('multi_buyer_details')->where('dealer_id', Auth::user()->id)->where('oem_status', '=', 'R');
            $dealerDetail = DB::table('multi_buyer_details')->where('dealer_id', getParentId())->where('oem_status', '=', 'R');

            if (isset($request->vin)) {
                $vin = $request->vin;
                $dealerDetail->where('buyer_id', 'like', '%' . $request->vin . '%');
            }
            $dealerDetail->orderBy('id', 'DESC');
            if (isset($request->vin)) {
                $dealerDetails = $dealerDetail->paginate(50)->appends(['vin' => $request->vin]);
                $custId = $request->vin;
            } else {
                $dealerDetails = $dealerDetail->paginate(50);
            }

            // $dealerDetails = DB::table('multi_buyer_details')->paginate(50);

            return view('truck.buyer.bulkbuyer.multi_return_by_oem', compact('dealerDetails', 'custId'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // dd($e->getMessage());
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }


    public function saveInvoice(Request $request)
    {
        try {
            //    dd($request->all());

            $BuyerDetail = BuyerDetail::find($request->id);
            $BuyerDetail->dlr_invoice_no = $request->invRange;
            $BuyerDetail->invoice_dt = $request->invDate;
            $BuyerDetail->invoice_amt = $request->invAmt;
            $BuyerDetail->addmi_inc_amt = $request->invAdmisAmt;
            $BuyerDetail->tot_inv_amt = $request->invTotAmt;
            $BuyerDetail->tot_admi_inc_amt = $request->invTotAdmisAmt;
            $BuyerDetail->amt_custmr = $request->invPayCust;

            $BuyerDetail->save();

            return response()->json(['status' => true, 'message' => 'updated'], 200);


            //    return view('truck.buyer.bulkbuyer.multi_buyer_index', compact('dealerDetails', 'custId'));
        } catch (Exception $e) {
            //    dd($e->getMessage());
            return response()->json(['status' => false, 'message' => 'something went wrong!'], 200);
        }
    }

    public function mangeVinWiseInvoicePreview($id, $rowId)
    {
        try {
            $rowId = decrypt($rowId);
            $multiBuyerDetail = DB::table('multi_buyer_details')->where('id', $rowId)->first();

            $type = DB::table('customer_doc_verf_type')->whereIn('id', [7, 9, 2])->get();

            // $user = User::where('id', Auth::user()->id)->first();
            $user = User::where('id', $multiBuyerDetail->created_by)->first();

            $bankDetail = DB::table('buyer_details_view as bd')
                ->where('id', $id)->first();

            $prodDet = DB::table('production_data')->where('id', $bankDetail->production_id)->first();

            // $oemname = DB::table('users')->where('id', Auth::user()->oem_id)->first();
            $oemname = DB::table('users')->where('id', $user->oem_id)->first();

            return view('truck.buyer.bulkbuyer.buyer_multi_vin_invoice_preview', compact('bankDetail', 'prodDet', 'user', 'id', 'type', 'oemname', 'rowId', 'multiBuyerDetail'));
        } catch (Exception $e) {
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            return redirect()->back();
        }
    }
}
