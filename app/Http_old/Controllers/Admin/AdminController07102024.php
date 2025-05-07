<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClaimDetailsExport;
use App\Models\User;
use Auth;


class AdminController extends Controller
{
    public function index()
    {
        ini_set('memory_limit', '10048M');
        ini_set('max_execution_time', 6600);

        // $models = User::join('model_master', 'users.id', '=', 'model_master.oem_id')
        //     ->join('oem_model_details', 'model_master.id', '=', 'oem_model_details.model_id')
        //     // ->where('model_master.oem_id', Auth::user()->id)
        //     ->orderBy('oem_model_details.id')
        //     ->get([
        //         'model_master.id as model_id',
        //         'model_master.*',
        //         'oem_model_details.id as model_detail_id',
        //         'oem_model_details.*',
        //     ]);
        // dd($models);
        // $dashboard = DB::table('dashboard_view')->get();
        
        // $dealerReg = DB::table('users')
        //     ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        //     ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        //     ->whereIn('model_has_roles.role_id', [6])
        //     // ->where('oem_id', Auth::user()->id)
        //     // ->select('users.*', 'roles.name as  role')
        //     ->get();

        // $vehicleSub = DB::table('buyer_details_view')->where('status', 'A')->count();
        // $vehicleApp = DB::table('buyer_details_view')->where('oem_status', 'A')->count();

        // $PostData = DB::table('users')
        //     ->join('post_registration_detail', 'users.id', '=', 'post_registration_detail.user_id')
        //     // ->where('users.post_registration_status',null)
        //     ->get();
        // dd($pendingPost);
        // $claimData = DB::table('buyer_details_view')->get();
    
        // dd($claimData);

        $authApi = DB::table('encryption_keys')->where('oem_code',Auth::user()->id)->first();

        // Fetch the summarized data grouped by vehicle_type
        // $oem_summary = DB::table('oem_ev_summary')
        //     ->select(
        //         'vehicle_type',
        //         DB::raw('SUM(production_count) AS total_production_count'),
        //         DB::raw('SUM(sold_by_dealer) AS total_sold_by_dealer'),
        //         DB::raw('SUM(approved_by_oem) AS total_approved_by_oem'),
        //         DB::raw('SUM(claim_submitted) AS total_claim_submitted')
        //     )
        //     ->groupBy('vehicle_type')
        //     ->get();

            $pid=getParentId();
// ######################### NEW ###############33
            $dashboard = DB::table('dashboard_summary')->first();
            $claimData = DB::table('buyer_details_summary')->first();
            $PostData = DB::table('post_registration_summary')->first();
            $oem_summary = DB::table('oem_ev_summary_view')->get();
            // $dealerReg = DB::table('dealer_registration_count')->where('oem_id',Auth::user()->id)->first();
            $dealerReg = DB::table('dealer_registration_count')->where('oem_id',$pid)->first();
            $models = DB::table('model_summary')->first();
            // dd($dealerReg);
                
        // return view('admin.index', compact("dashboard","authApi", 'PostData', 'models', 'dealerReg', 'vehicleSub', 'vehicleApp', 'claimData', 'oem_summary'));
        return view('admin.index', compact("dashboard","authApi", 'PostData', 'models', 'dealerReg', 'claimData', 'oem_summary'));
    }

    public function uploaddoc()
    {
        return view('admin.upload');
    }
    public function uploadcheck(Request $request)
    {
        // dd('he');
        $file = $request->file;
        // $csrfToken = csrf_token();
        $result = exec("php " . base_path("uploaddocc.php"));
        // $result = exec("php " . base_path("uploaddocc.php"));

        // Process the result if needed
        dd($result);
    }

    public function claimDetails($flag)
    {
        if ($flag == 'AV') {
            $claimData = DB::table('buyer_details_view')
                //->whereNull('claim_id')
                ->where('oem_status', 'A')
                ->get();
        } elseif ($flag == 'CG') {
            $claimData = DB::table('buyer_details_view')
                ->whereNotNull('claim_id')
                ->whereNull('lot_id')
                ->where('oem_status', 'A')
                ->get();
        } elseif ($flag == 'CS') {
            $claimData = DB::table('buyer_details_view')
                ->whereNotNull('claim_id')
                ->whereNotNull('lot_id')
                ->where('oem_status', 'A')
                ->get();
        } elseif ($flag == 'AS') {
            $claimData = DB::table('buyer_details_view')
                ->whereIN('status', ['A', 'S'])
                ->get();
        } else {
            $claimData = DB::table('buyer_details_view')
                ->whereNotNull('claim_id')
                ->whereNotNull('lot_id')
                ->get();
            // dd($claimData);

        }

        return view('admin.claimDetails', compact("claimData", "flag"));
    }

    public function downloadClaimDetails($flag)
    {
 ini_set('memory_limit', '4096M');
    ini_set('max_execution_time', 3600);

        $query = DB::table('buyer_details_view');

        if ($flag == 'AV') {
            $query->where('oem_status', 'A');
        } elseif ($flag == 'CG') {
            $query->where('oem_status', 'A')->whereNotNull('claim_id')->whereNull('lot_id');
        } elseif ($flag == 'CS') {
            $query->where('oem_status', 'A')->whereNotNull('claim_id')->whereNotNull('lot_id');
        } elseif ($flag == 'AS') {
            $query->whereIn('status', ['A', 'S']);
        }

        $claimData = $query->get();

        return Excel::download(new ClaimDetailsExport($claimData, $flag), 'claimDetails.xlsx');
    }

    public function OEMSummary($vehicle_type)
    {
        // Fetch the detailed data based on vehicle_type
        $details = DB::table('oem_ev_summary')->where('vehicle_type', $vehicle_type)->orderBy('oem_name')->get();
        return view('admin.oem-summary-details', compact('details'));
    }
 public function OEMSalesReport()
    {
        // Fetch the detailed data based on vehicle_type
        $details = DB::table('sales_report_vw')->orderBy('oem_name')->get();
        return view('admin.oem-sales-report', compact('details'));
    }

}
