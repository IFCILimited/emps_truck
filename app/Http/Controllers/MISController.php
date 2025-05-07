<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class MISController extends Controller
{
    public function index()
    {
        $pid = getParentId();

        $fuser = DB::table('post_registration_detail')->where('user_id',$pid)->first();
        // dd($fuser);

        

        $misData = DB::table('emps_buyer_details as ebd')
        // ->join('users as u', 'ebd.dealer_id', '=', 'u.id')
            ->where('ebd.gst_number', $fuser->gstin_no)
            ->where('ebd.invoice_dt', '>=', '2024-10-01')
            // ->select(
            //     DB::raw('COALESCE(COUNT(ebd.vin_chassis_no), 0) as vin_count'),
            //     DB::raw('COALESCE(COUNT(ebd.buyer_id), 0) as buyer_count'),
            //     DB::raw('COALESCE(COUNT(ebd.pmedrive_self_copy_id), 0) as self_copy_count'),
            // )
        // ->groupBy('u.dealer_code', 'u.mobile', 'u.email')
            ->get();
        // dd($misData);

        return view('admin.authenticationReport',compact('misData'));
    }
}
