<?php

namespace App\Http\Controllers\OEM\Claim;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClaimMaster;
use App\Models\ClaimLots;
// use App\ClaimDetail;
use App\Models\BuyerDetail;
use Auth;
use DB;
use Exception;
use Carbon\Carbon;

class ClaimToMhiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $segMaster = DB::table('segment_master')->pluck('segment_name');
        // $modelMaster = DB::table('model_master')->where('oem_id',Auth::user()->id)->pluck('model_name','id');
        $pid = getParentId();
        $claimMaster = DB::table('claim_master_view')->where('oem_id', $pid)->whereNull('lot_id')->whereNotNull('claim_id')->get();

        // dd($segMaster,$buyerDetail,$modelMaster);

        return view('oem.claim.claimToMhi', compact('claimMaster'));
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
        // Debugging the request data
        // dd($request);
        $pid = getParentId();

        try {
            $monthCount = ClaimLots::where('oem_id', $pid)->where('claim_month_id', $request->month)->count();

            if ($monthCount >= 2) {
                alert()->warning('You cannot create more than 2 claims for this month', 'Error')->persistent('Close');
                return redirect()->back();
            }

            DB::transaction(function () use ($request, $pid) {
                $claimLot = new ClaimLots;
                $claimLot->oem_id = $pid;
                $claimLot->created_by = Auth::user()->id;
                $claimLot->created_at = Carbon::now();
                $claimLot->claim_month_id = $request->month;
                $claimLot->save();

                foreach ($request->check as $key => $claim_id) {
                    $claimMaster = ClaimMaster::find($claim_id);
                    if ($claimMaster) {
                        $claimMaster->lot_id = $claimLot->id;
                        $claimMaster->save();

                        // Calculate the expiry date from invoice_dt// add by 02-08-2024
                        $expiryDate = Carbon::now()->subDays(120);

                        BuyerDetail::where('claim_id', $claim_id)
                            ->where('invoice_dt', '<', $expiryDate)
                            ->update(['expiry_120' => 'Y']);
                    }
                }
            });

            alert()->success('Claim Lot Generation Successful', 'Success')->persistent('Close');
            return redirect()->route('claimToMhi.index');
        } catch (Exception $e) {
            alert()->error('Error', $e->getMessage())->persistent('Close');
            return redirect()->back()->withInput();
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
        // dd($request);
        $pid = getParentId();
        $array = [];
        foreach ($request->check as $key => $check) {
            // dd($request->check);
            // $array[] =  $check;
            array_push($array, $check);

        }
        $claimMaster = DB::table('claim_master')->where('oem_id', $pid)->whereIn('id', $array)->whereNull('lot_id')->get();
        $month_id = $request->month;

        return view('oem.claim.claimToMhiShow', compact('claimMaster', 'month_id'));
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

    public function claimSubmitted()
    {
        $pid = getParentId();
        $claimMaster = DB::table('claim_master_view')->where('oem_id', $pid)->whereNotNull('lot_id')->whereNotNull('claim_id')->get();

        return view('oem.claim.claimSubmitted', compact('claimMaster'));
    }
}
