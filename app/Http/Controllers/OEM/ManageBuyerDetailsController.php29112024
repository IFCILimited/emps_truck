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

class ManageBuyerDetailsController extends Controller
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
        // dd($pid);
        try {
            if ($status == 'P') {
                $bankDetail = DB::table('buyer_details_view')
                    ->whereNull('oem_status')
                    ->where('oem_id', $pid)
                    ->where('status', 'A')
                    ->orderBy('invoice_dt', 'asc')
                    ->take(2000)
                    ->get();
                $bdCount = DB::table('buyer_details_view')
                    ->whereNull('oem_status')
                    ->where('oem_id', $pid)
                    ->where('status', 'A')
                    ->count();

            } elseif ($status == 'A') {
                $bankDetail = DB::table('buyer_details_view')->where('oem_status', 'A')->where('oem_id', $pid)->where('status', 'A')->get();
                $bdCount = DB::table('buyer_details_view')->where('oem_status', 'A')->where('oem_id', $pid)->where('status', 'A')->count();
            }

            // dd($bankDetail);
            return view('oem.manage_buyer.index_manage_buyer_details', compact('bankDetail', 'bdCount', 'status'));
        } catch (\Exception $e) {
            errorMail($e, $pid);
            return redirect()->back();
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pid = getParentId();
        try {
            // $type = DB::table('customer_doc_verf_type')->whereNotIn('id', [1])->get();

            $user = User::where('id', $pid)->first();
            $bankDetail = DB::table('buyer_details_view as bd')->where('status', 'A')
                ->where('id', $id)->first();

            $customerId = (int) $bankDetail->custmr_id;

            // $cat = DB::table('customer_doc_verf_type')
            //     ->where('id', $customerId)
            //     ->first();


            $cat = DB::table('customer_doc_verf_type')
                ->where('id', $customerId)
                ->first();
            // dd($cat,$bankDetail->custmr_id);


            $type = DB::table('customer_doc_verf_type')->where('id', $bankDetail->addi_cust_id)->first();

            // dd($type,$cat);


            return view('oem.manage_buyer.create_manage_buyer_details', compact('type', 'bankDetail', 'user', 'customerId', 'cat'));
        } catch (\Exception $e) {
            errorMail($e, $pid);
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $type = DB::table('customer_doc_verf_type')->whereNotIn('id', [1])->get();
        // $user = User::where('id', Auth::user()->id)->first();
        // $bankDetail = DB::table('buyer_details_view as bd')
        //     ->where('id', $id)->first();

        // // dd($bankDetail);

        // $customerId = (int) $bankDetail->custmr_id;

        // $oemname = DB::table('users')->where('oem_id',Auth::user()->oem_id)->first();

        // $cat = DB::table('customer_doc_verf_type')
        //     ->where('id', $customerId)
        //     ->first();
        // return view('oem.manage_buyer.show_manage_buyer_details',compact('type','user','bankDetail','oemname','customerId','cat'));
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
        // dd($request);
        try {
$oem_status=Null;
            DB::transaction(function () use ($request,&$oem_status) {

                $buyerAppr = BuyerDetail::find($request->id);
                if ($request->status == 'R') {
                    $buyerAppr->status = 'D';
                    $buyerAppr->oem_remarks = $request->oem_remarks;
                    $buyerAppr->oem_status = $request->status;
                    $buyerAppr->oem_status_at = now();
                    $buyerAppr->child_id = Auth::user()->id;
                    $buyerAppr->save();
                    alert()->success('Data has been successfully revert.', 'Success')->persistent('Close');

                } else {

                    // $vahan = vahanAPI($request->vin_chassis_no);
                    $oem_status='A';
                    $buyerAppr->oem_status = 'A';
                    $buyerAppr->oem_status_at = now();
                    $buyerAppr->child_id = Auth::user()->id;
                    $buyerAppr->save();
                    alert()->success('Data has been successfully approved.', 'Success')->persistent('Close');
                }

            });

            if ($request->status == 'R') {
                return redirect()->route('manageBuyerDetails.returnToDealer');
            } elseif ($request->status == null) {
                return redirect()->route('manageBuyerDetails.index', 'P');
            }elseif($oem_status=='A'){
                return redirect()->route('manageBuyerDetails.index', 'A');
            }

        } catch (\Exception $e) {
            dd($e);
            errorMail($e, Auth::user()->id);
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
    public function returnToDealer()
    {
        $pid = getParentId();
        try {

            $bankDetail = DB::table('buyer_details_view')
                ->where('oem_status', 'R')
                ->where('oem_id', $pid)
                ->get();
            // dd($bankDetail);
            return view('oem.manage_buyer.oemreturn', compact('bankDetail'));
        } catch (Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }
    public function downloadBuyerList()
    {

        try {


            return Excel::download(new BuyerDetailExport(), 'buyer_details.xlsx');
        } catch (\Exception $e) {
            dd($e);
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }
}
