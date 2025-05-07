<?php

namespace App\Http\Controllers\OEM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Models\User;
use App\Models\BuyerDetail;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BuyerDetailExport;
use Illuminate\Support\Carbon;


class ManageBulkBuyerDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        ini_set('memory_limit', '8048M');
        ini_set('max_execution_time', 8600);
        $pid = getParentId();
        
        try {
            $buyerDetails = DB::table('multi_buyer_details as mbd')->select('mbd.*')->join('users','users.id','=','mbd.dealer_id')->where('users.oem_id', $pid);
            // dd($buyerDetails, $pid);
            // $buyerDetails = DB::table('multi_buyer_details as mbd')->join('users', 'users.id' , '=', 'mbd.dealer_id')->where('users.oem_id', $pid);
            // $bdCountData = DB::table('multi_buyer_details');
            if ($status == 'P') {
                    $buyerDetails->whereNull('oem_status');
                    // $bdCountData->whereNull('oem_status');
            } 
            else {
                $buyerDetails->where('oem_status', $status);
                    // $buyerDetails->where('oem_status', 'A');
                    // $bdCountData->where('oem_status', 'A');
            }
           
            $bankDetail = $buyerDetails->get();
            // $bdCount = $bdCountData->count();
            $bdCount = $bankDetail->count();
            // dd($bankDetail);
            if($status == 'R') {
                return view('oem.manage_multi_buyer.returnToOem', compact('bankDetail','bdCount','status'));
            }else{
                return view('oem.manage_multi_buyer.index', compact('bankDetail','bdCount','status'));
            }
        } catch (\Exception $e) {
            errorMail($e, $pid);
            return redirect()->back();
        }
    }
  

    public function managePreview($id)
    {
        try {
            $rowId = decrypt($id);
            $multiBuyerDetail = DB::table('multi_buyer_details')->where('id', $rowId)->first();

            $vins = json_decode($multiBuyerDetail->vin_map, true);
           
            //first vin id
            $id = $vins[array_keys($vins)[0]];

            $type = DB::table('customer_doc_verf_type')->whereIn('id', [7, 9, 2])->get();

            $user = User::where('id', $multiBuyerDetail->created_by)->first();

            $productionDetails = [];
            foreach($vins as $vin => $buyerTableId) {
                $productionDetails[$vin] = DB::table('buyer_details_view as bd')
                ->select('prd.manufacturing_date', 'bd.*')
                ->join('production_data as prd', 'prd.id', '=', 'bd.production_id')
                ->where('bd.id', $buyerTableId)->first();
            }
            $bankDetail = DB::table('buyer_details_view as bd')
                ->where('id', $id)->first();

            $prodDet = DB::table('production_data')->where('id', $bankDetail->production_id)->first();

            $oemname = DB::table('users')->where('id', $user->oem_id)->first();
            $minDate = '2024-04-01';
            $maxDate = '2025-09-30';

            return view('oem.manage_multi_buyer.create', compact('bankDetail', 'productionDetails', 'user', 'id', 'type', 'oemname', 'minDate', 'maxDate', 'vins', 'rowId', 'multiBuyerDetail'));
        } catch (Exception $e) {
            // dd($e->getMessage());
            alert()->error('Oops!', 'Something went wrong!')->persistent('Close');
            // errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    

    public function manageOemRevertApprove($id, Request $request)
    {
        try {
            $rowId = decrypt($id);
            // dd($rowId, $request->all());

            //revert
            if($request->action == 'revrt') {
                $multiBuyerDetail = DB::table('multi_buyer_details')->where('id', $rowId)->first();
                $vins = json_decode($multiBuyerDetail->vin_map, true);
                // dd($vins);
                DB::transaction(function () use ($request, $vins, $rowId) {
                    foreach($vins as $vin => $buyId) {
                        DB::table('buyer_details')->where('id', $buyId)->update([
                            'status' => 'D',
                            'updated_at' => Carbon::now()
                        ]);
                    }

                    DB::table('multi_buyer_details')->where('id', $rowId)->update([
                        'oem_remrk' => $request->remarks,
                        'oem_status' => 'R',
                        'status' => 'D',
                        'updated_at' => Carbon::now(),
                        'oem_action_at' => Carbon::now()
                    ]);
                });

                alert()->success('Data has been updated successfully.', '')->persistent('Close');

                return redirect()->route('manageBulkBuyerDetails.index', 'P');
                
            }

            //approved 
            DB::table('multi_buyer_details')->where('id', $rowId)->update([
                'oem_status' => 'A',
                'updated_at' => Carbon::now(),
                'oem_action_at' => Carbon::now()
            ]);

            alert()->success('Data has been updated successfully.', '')->persistent('Close');

            return redirect()->route('manageBulkBuyerDetails.index', 'P');
            
        } catch (\Exception $e) {
            // dd($e->getMessage());
            // errorMail($e, );
            alert()->error('Something went wrong!', '')->persistent('Close');

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
        try {
           
            DB::transaction(function () use ($request) {

                $buyerAppr = BuyerDetail::find($request->id);
                if ($request->status == 'R') {
                    $buyerAppr->status = 'D';
                    $buyerAppr->oem_remarks = $request->oem_remarks;
                    $buyerAppr->oem_status = $request->status;
                    $buyerAppr->oem_status_at = now();
                    $buyerAppr->child_id = Auth::user()->id;
                    $buyerAppr->save();
                    alert()->success('Data has been successfully revert.','Success')->persistent('Close');

                } else {

                    $vahan = vahanAPI($request->vin_chassis_no);

                    $buyerAppr->oem_status = 'A';
                    $buyerAppr->oem_status_at = now();
                    $buyerAppr->child_id = Auth::user()->id;
                    $buyerAppr->save();
                    alert()->success('Data has been successfully approved.','Success')->persistent('Close');
                }

            });
           
            if($request->status == 'R'){
                
                return redirect()->route('manageBuyerDetails.returnToDealer');
            }
            elseif($request->status == null){

                return redirect()->route('manageBuyerDetails.index','P');
            }
            
        } catch (\Exception $e) {
            // dd($e);
            alert()->error('Something went wrong!', '')->persistent('Close');
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }

    
   
    public function downloadBuyerList()  {
      
        try {
            return Excel::download(new BuyerDetailExport(), 'buyer_details.xlsx');
        } catch (\Exception $e) {
            // dd($e);
            alert()->error('Something went wrong!', '')->persistent('Close');
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }  
    }
}   
