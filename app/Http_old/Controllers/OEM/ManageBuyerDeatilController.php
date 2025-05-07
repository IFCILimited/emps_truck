<?php

namespace App\Http\Controllers\OEM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use Auth;
use App\Models\User;
use App\Models\BuyerDetail;

class ManageBuyerDeatilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankDetail = DB::table('buyer_details_view')->where('status', 'A')->where('oem_id', Auth::user()->id)->get();

        // dd($bankDetail);


        return view('oem.manage_buyer.index_manage_buyer_deatils',compact('bankDetail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $type = DB::table('customer_doc_verf_type')->whereNotIn('id', [1])->get();
        $user = User::where('id', Auth::user()->id)->first();
        $bankDetail = DB::table('buyer_details_view as bd')->where('status', 'A')
            ->where('id', $id)->first();

        // dd($bankDetail);

        $customerId = (int) $bankDetail->custmr_id;

        $oemname = DB::table('users')->where('oem_id',Auth::user()->oem_id)->first();

        $cat = DB::table('customer_doc_verf_type')
            ->where('id', $customerId)
            ->first();
        return view('oem.manage_buyer.create_manage_buyer_deatils',compact('type','bankDetail','user','customerId','oemname','cat'));
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
	
        try{
            DB::transaction(function () use ($request) {

                $buyerAppr = BuyerDetail::find($request->id);
                if($request->status == 'R'){
                    $buyerAppr->status = 'D';
                    $buyerAppr->oem_remarks = $request->oem_remarks;
                    $buyerAppr->oem_status =$request->status;
	           $buyerAppr->oem_status_at = now();
		$buyerAppr->save();

                }else{	
		 $buyerAppr->oem_status ='A';
                $buyerAppr->oem_status_at = now();
                $buyerAppr->save();
                }
               

            });
            alert()->success('Data has been Saved')->persistent('Close');
            return redirect()->route('manageBuyerDeatils.index');
        }
        catch (\Exception $e) {
            \Log::error($e->getMessage());
            dd($e);
            alert()->warning('Data has Failed')->persistent('Close');
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
}
