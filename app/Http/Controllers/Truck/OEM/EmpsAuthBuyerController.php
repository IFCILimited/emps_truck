<?php

namespace App\Http\Controllers\Truck\OEM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Models\User;

class EmpsAuthBuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status)
    {
        // dd($status);

        ini_set('memory_limit', '8048M');

        ini_set('max_execution_time', 8600);
        $pid = getParentId();
        // dd($pid);
        try {
            if ($status == 'P') {
                $bankDetail = DB::table('emps_buyer_auth')
                    ->whereNull('pmedrive_oem_status')
                    ->where('oem_id', $pid)
                    ->where('pmedrive_dealer_status', 'S')
                    ->orderBy('invoice_dt', 'asc')
                    ->take(2000)
                    ->get();
                $bdCount = DB::table('emps_buyer_auth')
                    ->whereNull('pmedrive_oem_status')
                    ->where('oem_id', $pid)
                    ->where('pmedrive_dealer_status', 'S')
                    ->count();

            } elseif ($status == 'A') {
                $bankDetail = DB::table('emps_buyer_auth')->where('pmedrive_oem_status', 'A')->where('oem_id', $pid)->where('pmedrive_dealer_status', 'S')->get();
                $bdCount = DB::table('emps_buyer_auth')->where('pmedrive_oem_status', 'A')->where('oem_id', $pid)->where('pmedrive_dealer_status', 'S')->count();
            } elseif ($status == 'R') {
                $bankDetail = DB::table('emps_buyer_auth')->where('pmedrive_oem_status', 'R')->where('oem_id', $pid)->where('pmedrive_dealer_status', 'D')->get();
                $bdCount = DB::table('emps_buyer_auth')->where('pmedrive_oem_status', 'R')->where('oem_id', $pid)->where('pmedrive_dealer_status', 'D')->count();
            }

            // dd($bankDetail);
            return view('oem.emps_auth.index_buyer', compact('bankDetail', 'bdCount', 'status'));
        } catch (\Exception $e) {
            // errorMail($e, $pid);
            return [
                'msg' => $e->getMessage(),
                'ln' => $e->getLine()
            ];
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
        $id = decrypt($id);
        $pid = getParentId();
        try {
            

            $user = User::where('id', operator: $pid)->first();
            $bankDetail = DB::table('emps_buyer_auth')->where('status', 'A')
                ->where('id', $id)->first();

            $customerId = (int) $bankDetail->custmr_id;

            $cat = DB::table('customer_doc_verf_type')
                ->where('id', $customerId)
                ->first();

            $type = DB::table('customer_doc_verf_type')->where('id', $bankDetail->addi_cust_id)->first();



            return view('oem.emps_auth.create_buyer', compact('type', 'bankDetail', 'user', 'customerId', 'cat'));
        } catch (\Exception $e) {
            alert()->warning('Something went wrong!', 'Error')->persistent(true)->autoClose(false);
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
        // dd($id);
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
        $pid = getParentId();
        // dd($request);
        $vin=$request['vin_chassis_no'];
        try {
            $oem_status=Null;
                        DB::transaction(function () use ($request,&$oem_status,$pid,$vin) {

                            if ($request->status == 'R') {
                                // dd("hey");
                                $data = [
                                    'pmedrive_dealer_status' => 'D',
                                    'pmedrive_oem_remarks' => $request->oem_remarks,
                                    'pmedrive_oem_status' => $request->status,
                                    'pmedrive_oem_status_at' => now(),
                                    'pmedrive_oem_id' => $pid,
                                    'pmedrive_oem_child_id' => Auth::user()->id,
                                    // 'emps_oem_id' => $request
                                ];

                            DB::table('emps_buyer_auth')->where('id', $request->id)->update($data);


                            alert()->success('Data has been successfully reverted.', 'Success')->persistent('Close');

                            } else {
                                $data = [
                                    'pmedrive_oem_status' => 'A',
                                    'pmedrive_oem_status_at' => now(),
                                    'pmedrive_oem_id' => $pid,
                                    'pmedrive_oem_child_id' => Auth::user()->id,
                                ];
                               
                                EMPSAuthUpdate($vin);

                            DB::table('emps_buyer_auth')->where('id', $request->id)->update($data);


                            alert()->success('Data has been successfully approved.', 'Success')->persistent('Close');

                            }

                            DB::table('emps_buyer_auth')->where('id', $request->id)->update($data);


                        });

                        if ($request->status == 'R') {
                            return redirect()->route('e-trucks.Empsbuyer.index', 'R');
                        } elseif ($request->status == null) {
                            return redirect()->route('e-trucks.Empsbuyer.index', 'P');
                        }elseif($request->status =='A'){
                            return redirect()->route('e-trucks.Empsbuyer.index', 'A');
                        }

                    } catch (\Exception $e) {
                        // dd($e);
                        alert()->warning('Something went wrong!', 'Error')->persistent(true)->autoClose(false);
                        return redirect()->back();
                    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function returnToEmpsDealer($status)
     {
        // dd($status);
         $pid = getParentId();
         try {

             $bankDetail = DB::table('emps_auth_buyer_details_view')
                 ->where('pmedrive_oem_status', 'R')
                 ->where('oem_id', $pid)
                 ->get();

                 // dd($bankDetail);

             $bdCount = DB::table('emps_auth_buyer_details_view')
                 ->where('pmedrive_oem_status', 'R')
                 ->where('oem_id', $pid)
                 ->count();


             // dd($bankDetail);
             return view('oem.manage_buyer.oemreturn', compact('bankDetail','bdCount','status'));
         } catch (Exception $e) {
            alert()->warning('Something went wrong!', 'Error')->persistent(true)->autoClose(false);
            return redirect()->back();
         }
     }
    public function destroy($id)
    {
        //
    }
}
