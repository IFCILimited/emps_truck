<?php

namespace App\Http\Controllers\OEM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BuyerDetailStage;


class VINChassisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('oem.vin_chassis_search');
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
        // dd($request);
        $customerDetails = null;
    
        if ($request->has('vin_chassis_no')) {
            $request->validate([
                'vin_chassis_no' => 'required|string|max:255',
            ]);
    
            $vinChassisNo = $request->input('vin_chassis_no');
            $customerDetails = DB::table('buyer_details_view')
                ->where('vin_chassis_no', $vinChassisNo)
                ->first();
    
            // Debugging: Check if customerDetails is not null
            if ($customerDetails) {
                \Log::info('Customer Details Found: ', (array) $customerDetails);
            } else {
                \Log::info('No Customer Details Found for VIN/Chassis No: ' . $vinChassisNo);
            }
        }
    
        return view('oem.vin_chassis_search', compact('customerDetails'));
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

    public function downloadBuyerStages() {
        try {

           
            return Excel::download(new BuyerDetailStage(), 'buyer_details_stages.xlsx');
    } catch (\Exception $e) {
        // dd($e);
        errorMail($e, Auth::user()->id);
        return redirect()->back();
    }  
    }
}
