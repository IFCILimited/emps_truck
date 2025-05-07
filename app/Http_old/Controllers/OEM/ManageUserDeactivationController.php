<?php

namespace App\Http\Controllers\OEM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class ManageUserDeactivationController extends Controller
{
    public function index() {
        $dealersData = DB::table('dealer_device_detail as dvd')
        ->select('dvd.id', 'dvd.cpuid', 'usrs.name', 'usrs.auth_designation', 'dvd.device_code', 'dvd.device_status','usrs.username','usrs.dealer_code')
        ->join('users as usrs' , 'usrs.id' , '=' , 'dvd.user_id')
        ->where('usrs.oem_id', '=' , Auth::user()->id)->get();
        
        return view('oem.mamange_user_deactivation', compact('dealersData'));
    }

    public function deactiveUser(Request $request) {
        $update = DB::table('dealer_device_detail')
        ->where('id', $request->user_id)
        ->update([
            'device_status' => 0 , 
            'remarks' => trim($request->remarks),
            'action_by'=>Auth::user()->id,
            'action_at'=>Carbon::now()
        ]);
        alert()->success('User has been deactivated successfully!.','Success')->persistent('Close');
        
        return redirect()->back();
    }
}
