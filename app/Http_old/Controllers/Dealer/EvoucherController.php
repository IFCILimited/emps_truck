<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;

class EvoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('buyer.e_voucher_search');
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
        $customerDetails = null;

        if ($request->has('buyer_id')) {
            $request->validate([
                'buyer_id' => 'required|string|max:255',
            ]);

            $buyerID = $request->input('buyer_id');
            $customerDetails = DB::table('buyer_details_view')
                ->where('buyer_id', $buyerID)
                ->get();

            if(!$customerDetails) {
              return redirect()->back()->with('alert', 'No details found for entered customer ID')->with('alert_type', 'error');
            }

                // if (is_null($customerDetails->temp_reg_no) && is_null($customerDetails->vhcl_regis_no)) {
                //     return redirect()->back()->with('alert', 'E-voucher does not generate.')->with('alert_type', 'warning');
                // }
                foreach($customerDetails as $customerDetail)
                {
                    if ($customerDetail->adh_verify == 'N' || (is_null($customerDetail->temp_reg_no) && is_null($customerDetail->vhcl_regis_no))) {
                        return redirect()->back()->with('alert', 'The generation of E-voucher is still pending.')->with('alert_type', 'warning');
                    }
                }

            // Debugging: Check if customerDetails is not null
            if ($customerDetails) {
                \Log::info('Customer Details Found: ', (array) $customerDetails);
            } else {
                \Log::info('No Customer Details Found for VIN/Chassis No: ');
            }
        }

        return view('buyer.e_voucher_search', compact('customerDetails'));
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
