<?php

namespace App\Http\Controllers\Truck\OEM;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\ClaimMaster;
// use App\ClaimDetail;
use App\Models\BuyerDetail;
use Auth;
use DB;
use Exception;
use Carbon\Carbon;

class ClaimGenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 3600);

        $pid = getParentId();
        $modelMaster = DB::table('model_master')->where('oem_id', $pid)->pluck('model_name', 'id');
        $segMaster = DB::table('segment_master')->pluck('segment_name', 'id');
        $buyerDetail = DB::table('buyer_details_within_120_days')->where('oem_status', 'A')->where('oem_id', $pid)->where('within_120_days', 'true')->whereNull('claim_id')->distinct()->get();
        $dealer = DB::table('users')->get();

        return view('truck.oem.claim.claimGenerate', compact('buyerDetail', 'segMaster', 'modelMaster', 'dealer'));
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

        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 3600);

        $pid = getParentId();
        try {
            DB::transaction(function () use ($request, $pid) {

                $claimMast = new ClaimMaster;
                $claimMast->oem_id = $pid;
                $claimMast->created_by = Auth::user()->id;
                $claimMast->created_at = Carbon::now();
                $claimMast->vehicle_count = $request->vehicleCount;
                $claimMast->tot_incamt = $request->totIncAmt;
                $claimMast->child_id = Auth::user()->id;
                $claimMast->save();


                foreach ($request->check as $key => $check) {
                    // dd($request->check);
                    // $claimDetail= new ClaimDetail;
                    // $claimDetail->claimid=$claimMast->id;
                    // $claimDetail->buyer_id= $check;
                    // $claimDetail->save();

                    $buyerDetail = BuyerDetail::where('id', $check)->first();
                    $buyerDetail->claim_id = $claimMast->id;
                    $buyerDetail->save();
                }

                $claimMaster = ClaimMaster::find($claimMast->id);
                $claimNumberFormat = getClaimNumberFormat(Auth::user()->name, $claimMast->id);
                $claimMaster->claimnumberformat = $claimNumberFormat;
                $claimMaster->save();

            });


            alert()->success('Claim Generation Successful', 'Success')->persistent('Close');
            return redirect()->route('claimGenerate.index');
        } catch (Exception $e) {
            alert()->error('Error', $e->getMessage())
                ->persistent("Close");
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function show(Request $request)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 3600);

        // dd($request);
        $array = [];
        $pid = getParentId();
        foreach ($request->check as $key => $check) {
            // $array[] =  $check;
            array_push($array, $check);


        }
        // $array = DB::table('buyer_details')->where('oem_id', $pid)->whereIn('id', $array)->get();
        $array = DB::table('buyer_details_within_120_days')->where('oem_id', $pid)->whereIn('id', $array)->get();
        // dd($array);
        foreach($array as $arr){
            $invoiceDate = substr($arr->invoice_dt, 0, 10); // Extracts 'YYYY-MM-DD' part
            $vihcle_dt = substr($arr->vihcle_dt, 0, 10); // Extracts 'YYYY-MM-DD' part
            if ($invoiceDate < '2024-04-01' || $invoiceDate > '2026-03-31') {
                alert()->warning('Invoice Date should be between 1st April 2024 and 31st March 2026', 'Danger')->persistent('Close');
                return redirect()->back();
            }
            if ($vihcle_dt < '2024-04-01' || $vihcle_dt > '2026-03-31') {
                alert()->warning('Vehicle Date should be between 1st April 2024 and 31st March 2026', 'Danger')->persistent('Close');
                return redirect()->back();
            }
        // $id = $request->input('ids');
        // $array = explode(",", $id);
        }
        return view('truck.oem.claim.claimGenerateShow', compact('array'));
    }


    public function search($modSeg, $modName)
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 3600);


        try {
            $pid = getParentId();
            if ($modSeg == 'null' || $modName == 'null') {
                alert()->warning('Please Select both Model Segment and Name', 'Warning')->persistent('Close');
                return redirect()->route('claimGenerate.index');
            }
            $modSeg = decrypt($modSeg);
            $modName = decrypt($modName);

            $segMaster = DB::table('segment_master')->pluck('segment_name', 'id');
            $modelMaster = DB::table('model_master')->where('oem_id', $pid)->pluck('model_name', 'id');
            $buyerDetail = DB::table('buyer_details_within_120_days')->where('oem_status', 'A')->where('oem_id', $pid)
                ->where('within_120_days', 'true')->whereNull('claim_id')->where('model_id', $modName)->where('segment_id', $modSeg)->distinct()->get();
            $dealer = DB::table('users')->get();
            return view('truck.oem.claim.claimGenerate', compact('dealer', 'buyerDetail', 'segMaster', 'modelMaster', 'modSeg', 'modName'));
        } catch (Exception $e) {
            alert()->error('Error', $e->getMessage())
                ->persistent("Close");
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
