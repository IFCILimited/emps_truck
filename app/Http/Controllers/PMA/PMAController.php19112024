<?php

namespace App\Http\Controllers\PMA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClaimMaster;
use Auth;
use DB;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClaimExport;
class PMAController extends Controller
{
    public function index() {
      //  $claimMaster = DB::table('claim_master')
        //->join('claim_lots', 'claim_master.lot_id', '=', 'claim_lots.id')
        //->join('users', 'claim_master.oem_id', '=', 'users.id')
        //->get();
$claimMaster = DB::table('claim_master_view')->whereNotNull('lot_id')->get();

            // dd($claimMaster);
        
        return view('pma.claimProcessing',compact('claimMaster'));
    }

    public function dealers($id = null) {
        if($id == 'all' || $id == null){
            $dealerReg = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->whereIn('model_has_roles.role_id', [6])
        // ->where('oem_id', Auth::user()->id)
        ->select('users.*', 'roles.name as  role')
        ->orderBy('users.name','asc')
        ->get();
        }
        else{
           
        $dealerReg = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->whereIn('model_has_roles.role_id', [6])
        ->where('oem_id', $id)
        ->select('users.*', 'roles.name as  role')
        ->orderBy('users.name','asc')
        ->get();
        }
        $users = DB::table('users')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->whereIn('model_has_roles.role_id', [4])
        // ->where('oem_id', Auth::user()->id)
        ->select('users.*', 'roles.name as  role')
        ->get();

        return view('pma.dealers',compact('dealerReg','users','id'));
    }

    public function dealersShow($id)
    {
        try {
            $id = decrypt($id);

            $dealerReg = User::where("id", $id)->first();

            return view('pma.dealersShow', compact('dealerReg'));
        } catch (\Exception $e) {
            errorMail($e, Auth::user()->id);
            return redirect()->back();
        }
    }
    public function modelmis() {
        // dd(1);
        ini_set('memory_limit', '4048M');

ini_set('max_execution_time', 6600);    
        $modelsDet = DB::table('vw_model_details as vmd')
   ->join('users', 'users.id', '=', 'vmd.oem_id')
   ->orderBy('users.name','ASC')
   ->get();
   $proDat = DB::table('production_data_view')->get();
//    dd($proDat);
   return view('pma.modelmis',compact('modelsDet','proDat'));
    }

    public function viewclaims($id){
        $id = decrypt($id);
        // dd($id);
        $claims = DB::table('buyer_details_view as bd')
        ->where('bd.claim_id', $id)
        ->get();
        // ddx($id);
        return view('pma.viewclaims',compact('claims'));
    }

    public function vahanProcess($claimno)  {

        $vahanPros = FetchVahanAPI($claimno);
        if($vahanPros){
            return true;
        }
    }
    public function proccessClaim($claimno)
    {
        // dd($claimno);\
        ini_set('memory_limit', '7048M');
    ini_set('max_execution_time', 7600);
        try {
            // Call your stored procedure here
            DB::statement('CALL chk_vahandata_new('.$claimno.')');

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function downloadClaim($claimno)
    {
        try {
            $export = new ClaimExport($claimno);
            $data = $export->collection();

            if ($data->isEmpty()) {
                return response()->json(['error' => 'No data found for the given claim number.'], 404);
            }

            return Excel::download($export, 'claims.xlsx');
        } catch (Exception $e) {
            Log::error('Error exporting claim data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to download claims data. Please try again later.'], 500);
        }
    }

    public function pincodes($id = null) {
        
        $pin = DB::table('pincodecitystate')->where('pincode',$id)->first();
        return view('pma.pincodes',compact('pin'));
    }

    public function addpin(request $request) {
        // dd($request);
        DB::table('pincodecitystate')->insert([
            'pincode' => $request->pincode,
            'city' => $request->city,
            'state' => $request->state
        ]);
        alert()->success('Data has been successfully added.','Success')->persistent('Close');
        return redirect()->back();
    }
    
}
