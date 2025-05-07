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
use App\Exports\VahanDataExport;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use App\Exports\VahanMasterExport;



class PMAController extends Controller
{
    public function index()
    {

        // ini_set('memory_limit', '10048M');
        // ini_set('max_execution_time', 10000);

            // TimeLimit();

        //  $claimMaster = DB::table('claim_master')
        //->join('claim_lots', 'claim_master.lot_id', '=', 'claim_lots.id')
        //->join('users', 'claim_master.oem_id', '=', 'users.id')
        //->get();
        $claimMaster = DB::table('claim_master_view')->whereNotNull('lot_id')->get();

        // dd($claimMaster);

        return view('pma.claimProcessing', compact('claimMaster'));
    }

    public function dealers($id = null)
    {
        if ($id == 'all' || $id == null) {
            $dealerReg = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->whereIn('model_has_roles.role_id', [6])
                // ->where('oem_id', Auth::user()->id)
                ->select('users.*', 'roles.name as  role')
                ->orderBy('users.name', 'asc')
                ->get();
        } else {

            $dealerReg = DB::table('users')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->whereIn('model_has_roles.role_id', [6])
                ->where('oem_id', $id)
                ->select('users.*', 'roles.name as  role')
                ->orderBy('users.name', 'asc')
                ->get();
        }
        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->whereIn('model_has_roles.role_id', [4])
            // ->where('oem_id', Auth::user()->id)
            ->select('users.*', 'roles.name as  role')
            ->get();

        return view('pma.dealers', compact('dealerReg', 'users', 'id'));
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
    public function modelmis()
    {
        TimeLimit();

        $modelsDet = DB::table('vw_model_details as vmd')
            ->join('users', 'users.id', '=', 'vmd.oem_id')
            ->orderBy('users.name', 'ASC')
            ->get();
        $proDat = DB::table('production_data_view')->get();
        
        return view('pma.modelmis', compact('modelsDet', 'proDat'));
    }

    public function viewclaims($id)
    {
        $id = decrypt($id);
        // dd($id);
        // $claims = DB::table('buyer_details_view as bd')
        //     ->where('bd.claim_id', $id)
        //     ->get();

            $claims = DB::table('buyer_details_view as bd')
            ->select('bd.*', 'mbd.id as mbdId')
            ->leftjoin('multi_buyer_details as mbd' , 'bd.buyer_id', 'mbd.buyer_id')
            ->where('bd.claim_id', $id)
            ->get();
        // ddx($id);
        return view('pma.viewclaims', compact('claims'));
    }

    public function vahanProcess($claimno)
    {
        // ini_set('memory_limit', '8048M');
        // ini_set('max_execution_time', 8600);

        TimeLimit();

        $vahanPros = FetchVahanAPI($claimno);
        if ($vahanPros) {
            return true;
        }
    }
    public function proccessClaim($claimno)
    {
        //dd($claimno);
        // set_time_limit(0);
        // ini_set('memory_limit', '10048M');


        // ini_set('memory_limit', '10048M');
        // ini_set('max_execution_time', 100000);
        // ini_set('max_execution_time', 0);
         //TimeLimit();


          //ini_set('memory_limit', '6144M');
          //ini_set('max_execution_time', '6000');
	  //ini_set('default_socket_timeout', '6000');
	  //ini_set('max_input_time', '3600');
        //  ini_set('post_max_size', '1000M');
        //  ini_set('upload_max_filesize', '1000M');
        //  ini_set('max_input_vars', '100000');

        try {
            // Call your stored procedure here
            DB::statement('CALL chk_vahandata_new(' . $claimno . ')');
            // DB::select('CALL chk_vahandata_new(?)',[$claimno]);

            DB::table('claim_master')
    ->where('id', $claimno)
    ->update([
        'pma_process_at' => Carbon::now(), 
        'pma_process_by' => Auth::user()->id, 
    ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }

    public function downloadClaim($claimno)
    {
        // ini_set('memory_limit', '10048M');
        // ini_set('max_execution_time', 10000);

        TimeLimit();
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

    public function pincodes($id = null)
    {

        $pin = DB::table('pincodecitystate')->where('pincode', $id)->first();
        return view('pma.pincodes', compact('pin'));
    }

    public function addpin(request $request)
    {
        // dd($request);
        DB::table('pincodecitystate')->insert([
            'pincode' => $request->pincode,
            'city' => $request->city,
            'state' => $request->state
        ]);
        alert()->success('Data has been successfully added.', 'Success')->persistent('Close');
        return redirect()->back();
    }

    public function evoucherReport()
    {
        // dd($request);
        $oemname = null;
        $segmentName = null;
        $fromDate = null;
        $toDate = null;
    
        $details = DB::table('oem_evoucher_report')->orderBy('name', 'asc')->get();

        $name = DB::table('oem_evoucher_report')->distinct('name')
            ->orderBy('name', 'asc')->get();

        $seg = DB::table('oem_evoucher_report')
            ->distinct('segment_name')
            ->get();

        // dd($seg);

        return view('pma.evoucherReport', compact('details', 'name', 'seg','oemname', 'segmentName', 'fromDate', 'toDate'));
    }
    public function evoucherReportFilter(Request $request)
    {


    $oemname = $request->input('oemname', null);
    $segmentName = (String)$request->input('seg', null);
    $fromDate = $request->input('fromdate', null);
    $toDate = $request->input('todate', null);

    // Call the PostgreSQL function and get results
    $details = DB::select("
        SELECT * 
        FROM get_oem_evoucher_report(?, ?, ?, ?)
    ", [$oemname, $segmentName, $fromDate, $toDate]);

    // dd($details);
        $name = DB::table('oem_evoucher_report')->distinct('name')
            ->orderBy('name', 'asc')->get();

        $seg = DB::table('oem_evoucher_report')
            ->distinct('segment_name')
            ->get();

        // $details = DB::table('oem_evoucher_report')
        //     ->where('name', $request->oemname)
        //     ->when($request->seg == 'A', function ($query) {
        //         $query->whereIn('segment_name', ['e-3W', 'e-2W']);
        //     }, function ($query) use ($request) {
        //         $query->where('segment_name', $request->seg);
        //     })
        //     // ->when(!empty($request->fromdate) && !empty($request->todate), function ($query) use ($request) {
        //     //     $query->whereBetween('created_at', [$request->fromdate, $request->todate]);
        //     // })
        //     ->orderBy('name', 'asc')
        //     ->get();


        // dd($details);


        return view('pma.evoucherReport', compact('details', 'name', 'seg','oemname','segmentName','fromDate','toDate'));
    }

    public function oemWiseSales()
    {
        $segments = DB::table('segment_master')->get();
        $oems = DB::table('oem_category_wise_vw')
        ->select('oem_name', 'oem_id')
        ->distinct('oem_name')->get();

        $currentDate = Carbon::now();
        $startDate = Carbon::create(2024, 10, 1);
        $dateArray = [];
        while ($startDate <= $currentDate) {
            $dateArray[$startDate->format('m-Y')] = $startDate->format('M-Y');
            $startDate->addMonth();
        }

        $data = DB::table('oem_wise_sales_vw');
        if(isset($request->oem) && $request->oem != 'all'){
            $data = $data->where('oem_id', $request->oem);
        }

        if(isset($request->month) && $request->month != 'all'){
            // Dec-2024
            $currentMonthYearFormated = Carbon::createFromFormat('m-Y', $request->month)->format('M-Y');
            $data = $data->where('month_yr', $currentMonthYearFormated);
        }

        if(isset($request->segment) && $request->segment != 'all'){
            $data = $data->where('segment_name', $request->segment);
        }

        $details = $data->orderBy('oem_name', 'asc')->get();
        return view('pma.oem_wise_sales', compact('details', 'segments', 'oems', 'dateArray'));
    }
    public function vahanReportView(Request $request, $portal){
        ini_set('memory_limit', '10048M');
        ini_set('max_execution_time', 10000);
        if($portal == 3) {
            // dd($request->all(), $portal);
            $selected_date = CarbonImmutable::now();
            $currentDate = false;

            if($request->has('year') && $request->has('month')) {
                if($request->input('year') == $selected_date->format('Y') && $request->input('month') == $selected_date->format('m')) {
                    $currentDate = true;
                }
                $year_month_selected = $request->input('year') . '-' . $request->input('month');

                $selected_date =  CarbonImmutable::parse($year_month_selected);
            }

            // $original = $selected_date;
            $current_month = $selected_date->format('Y-m');
            // $current_month = '2024-12';
            $previous_month = $selected_date->addMonths(-1)->format('Y-m');
            // $previous_month = '2024-11';
            
            $lastDateOfMonth = $selected_date->endOfMonth()->format('d-m-Y');
            if($currentDate){
                $lastDateOfMonth = $selected_date->format('d-m-Y');
            }
            // $lastDateOfMonth = $selected_date->format('d-m-Y');
            // $lastDateOfMonth = '31-12-2024';
            
            $current_month_prev_year = $selected_date->addYears(-1)->format('Y-m');
            // $current_month_prev_year = '2023-12';

            $current = explode('-', $current_month);
            $fin_year = $current[0];
            if((int)$current[1] < 4){
                $fin_year = (int)$current[0] - 1;
            }
            $prev_financial_date = '01-04-'.$fin_year;
            // $prev_financial_date = '01-04-2024 ';

            $previous_financial_ending_year_to_date = Carbon::parse($selected_date)->addYears(-1)->endOfMonth()->format(('d-m-Y'));
            if($currentDate){
                $previous_financial_ending_year_to_date = Carbon::parse($selected_date)->addYears(-1)->format(('d-m-Y'));
            }
            // $previous_financial_ending_year_to_date = Carbon::parse($selected_date)->addYears(-1)->format(('d-m-Y'));
            $previous_financial_starting_year_to_date = Carbon::parse($prev_financial_date)->addYears(-1)->format(('d-m-Y'));
            // dd($previous_financial_ending_year_to_date, $previous_financial_starting_year_to_date);
           
            //DB DATE -->> 2024-10-01 (Y-M-D)
            //pmedrive vahan total
            // $results = DB::table('vahan_api_model_data as vamd')
            $results = DB::table('vahan_sales_report_combined_vw as vamd')
            ->selectRaw(
                'SUM(CASE WHEN TO_CHAR(TO_DATE(vahan_date_of_registration, \'YYYY-MM-DD\'), \'YYYY-MM\') = ? THEN vahan_numberofvehiclesregistered ELSE 0 END) as prev_month_total',
                [$previous_month]
            )
            ->selectRaw(
                'SUM(CASE WHEN TO_CHAR(TO_DATE(vahan_date_of_registration, \'YYYY-MM-DD\'), \'YYYY-MM\') = ? THEN vahan_numberofvehiclesregistered ELSE 0 END) as current_month_total',
                [$current_month]
            )->selectRaw(
                'SUM(CASE WHEN TO_CHAR(TO_DATE(vahan_date_of_registration, \'YYYY-MM-DD\'), \'YYYY-MM\') = ? THEN vahan_numberofvehiclesregistered ELSE 0 END) as current_month_previous_finance_total',
                [$current_month_prev_year]
            )->selectRaw(
                'SUM(CASE WHEN TO_DATE(vahan_date_of_registration, \'YYYY-MM-DD\') BETWEEN TO_DATE(?, \'DD-MM-YYYY\') AND TO_DATE(?, \'DD-MM-YYYY\') THEN vahan_numberofvehiclesregistered ELSE 0 END) as current_date_financial_total',
                [$prev_financial_date, $lastDateOfMonth]
            )
            ->selectRaw(
                'SUM(CASE WHEN TO_DATE(vahan_date_of_registration, \'YYYY-MM-DD\') BETWEEN TO_DATE(?, \'DD-MM-YYYY\') AND TO_DATE(?, \'DD-MM-YYYY\') THEN vahan_numberofvehiclesregistered ELSE 0 END) as current_date_previous_financial_total',
                [$previous_financial_starting_year_to_date, $previous_financial_ending_year_to_date]
            )
            ->first();

            //emps vahan total
            $results_emps = DB::table('oem_model_map_view as vamd')
                ->selectRaw(
                    'SUM(CASE WHEN TO_CHAR(TO_DATE("Date of Registration", \'DD-MM-YYYY\'), \'YYYY-MM\') = ? THEN "Number of vehicles Registered" ELSE 0 END) as prev_month_total',
                    [$previous_month]
                )
                ->selectRaw(
                    'SUM(CASE WHEN TO_CHAR(TO_DATE("Date of Registration", \'DD-MM-YYYY\'), \'YYYY-MM\') = ? THEN "Number of vehicles Registered" ELSE 0 END) as current_month_total',
                    [$current_month]
                )->selectRaw(
                    'SUM(CASE WHEN TO_CHAR(TO_DATE("Date of Registration", \'DD-MM-YYYY\'), \'YYYY-MM\') = ? THEN "Number of vehicles Registered" ELSE 0 END) as current_month_previous_finance_total',
                    [$current_month_prev_year]
                )->selectRaw(
                    'SUM(CASE WHEN TO_DATE("Date of Registration", \'DD-MM-YYYY\') BETWEEN TO_DATE(?, \'DD-MM-YYYY\') AND TO_DATE(?, \'DD-MM-YYYY\') THEN "Number of vehicles Registered" ELSE 0 END) as current_date_financial_total',
                    [$prev_financial_date, $lastDateOfMonth]
                )
                ->selectRaw(
                    'SUM(CASE WHEN TO_DATE("Date of Registration", \'DD-MM-YYYY\') BETWEEN TO_DATE(?, \'DD-MM-YYYY\') AND TO_DATE(?, \'DD-MM-YYYY\') THEN "Number of vehicles Registered" ELSE 0 END) as current_date_previous_financial_total',
                    [$previous_financial_starting_year_to_date, $previous_financial_ending_year_to_date]
                )
                ->first();

            $evoucher_issued = DB::table('buyer_details_view as bdv')
                    ->selectRaw("count(CASE
                                WHEN (bdv.temp_reg_no IS NOT NULL OR bdv.vhcl_regis_no IS NOT NULL)
                                AND bdv.adh_verify = 'Y' AND bdv.invoice_dt >= '2024-10-01'
                                AND TO_CHAR(bdv.invoice_dt, 'YYYY-MM') = ?
                                THEN 1
                                ELSE NULL
                                END) as previous_month_evoucher_generated", [$previous_month])
                    ->selectRaw("count(CASE
                                WHEN (bdv.temp_reg_no IS NOT NULL OR bdv.vhcl_regis_no IS NOT NULL)
                                AND bdv.adh_verify = 'Y' AND bdv.invoice_dt >= '2024-10-01'
                                AND TO_CHAR(bdv.invoice_dt, 'YYYY-MM') = ?
                                THEN 1
                                ELSE NULL
                                END) as current_month_evoucher_generated", [$current_month])
                    ->selectRaw("count(CASE
                                WHEN (bdv.temp_reg_no IS NOT NULL OR bdv.vhcl_regis_no IS NOT NULL)
                                AND bdv.adh_verify = 'Y' AND bdv.invoice_dt >= '2024-10-01'
                                AND TO_CHAR(bdv.invoice_dt, 'YYYY-MM') = ?
                                THEN 1
                                ELSE NULL
                                END) as current_month_prev_year_evoucher_generated", [$current_month_prev_year])
                    ->selectRaw("count(CASE
                                WHEN (bdv.temp_reg_no IS NOT NULL OR bdv.vhcl_regis_no IS NOT NULL)
                                AND bdv.adh_verify = 'Y' AND bdv.invoice_dt >= '2024-10-01'
                                AND bdv.invoice_dt BETWEEN TO_DATE(?, 'DD-MM-YYYY') AND TO_DATE(?, 'DD-MM-YYYY')
                                THEN 1
                                ELSE NULL
                                END) as current_date_financial_evoucher_generated", [$prev_financial_date, $lastDateOfMonth])
                    ->selectRaw("count(CASE
                                WHEN (bdv.temp_reg_no IS NOT NULL OR bdv.vhcl_regis_no IS NOT NULL)
                                AND bdv.adh_verify = 'Y' AND bdv.invoice_dt >= '2024-10-01'
                                AND bdv.invoice_dt BETWEEN TO_DATE(?, 'DD-MM-YYYY') AND TO_DATE(?, 'DD-MM-YYYY')
                                THEN 1
                                ELSE NULL
                                END) as current_date_financial_previous_evoucher_generated", [$previous_financial_starting_year_to_date, $previous_financial_ending_year_to_date])
                    ->first();

            // dd($results, $results_emps, $evoucher_issued, $previous_financial_starting_year_to_date, $previous_financial_ending_year_to_date, $previous_month, $current_month, $current_month_prev_year, $prev_financial_date, $lastDateOfMonth);

            return view('pma.view_report_monthly', compact('results', 'evoucher_issued', 'results_emps', 'current_month', 'previous_month', 'current_month_prev_year', 'prev_financial_date', 'lastDateOfMonth', 'previous_financial_starting_year_to_date', 'previous_financial_ending_year_to_date'));
        }
        return view('pma.view_report_page', compact('portal'));
    }
 
    public function vahanReportGenerate(Request $request) {
        //generate excel
        try {
            $export = new VahanDataExport($request->portal, $request->segment, $request->from_date, $request->to_date);
            $data = $export->collection();
            if ($data->isEmpty()) {
 
                alert()->warning('No Data found for selected filters.','Warning')->persistent('Close');
                return redirect()->back();
                // return response()->json(['error' => 'No data found for the given claim number.'], 404);
            }
 
            return Excel::download($export, 'vahan_data.xlsx');
        } catch (Exception $e) {
            // Log::error('Error exporting claim data: ' . $e->getMessage());
            alert()->error('Something went wrong!.','Error')->persistent('Close');
            return redirect()->back();
            // return response()->json(['error' => 'Failed to download claims data. Please try again later.'], 500);
        }
    }
    public function manageVahanModel() {
        try{
            //run procedure
            DB::select('call match_vahan_model_with_portal()');
            //fetch table details
            $details = DB::table('vahan_master_models_list')->get();

            return view('pma.manageVahanModel', compact('details'));

        }catch (Exception $e) {
           alert()->error('Something went wrong!.','Error')->persistent('Close');
            return redirect()->back();
            
        }
    }
    public function fetchModelDetails(Request $request){
        try{
            $details = DB::table('vw_model_details')->where('model_name', $request->model)->first();

            $empsCertificate = EMPSCertificateDateFetch($request->vahan_model);
            $empsData = null;
            if($empsCertificate && isset($empsCertificate[0])) {
                $empsData = $empsCertificate[0];
            }

            return response()->json(['status' => 1, 'result' => $details, 'emps' => $empsData], 200);
        }catch (Exception $e) {
          return response()->json(['status' => 0, 'error' => $e->getMessage()], 500);
        }
    }

    public function saveVahanModel(Request $request) {
        // dd($request->all());
        try{
            // oem_model_master_vahan_use
            $modelData = [
                'oem_id' => $request->oem_id,
                'name' => $request->portal_oem_name,
                'model_name' => $request->portal_model_name,
                'model_id' => $request->model_id,
                'segment_id' => $request->segment_id,
                'vehicle_cat_id' => $request->category_id,
                'category_name' => $request->portal_category_name,
                'segment_name' => $request->portal_segment_name,
                'MORTH_RC_MODEL' => $request->vahan_model_name,
                'MORTH_MODEL' => $request->vahan_model_name,
                'MORTH_OEM'=> $request->vahan_oem_name,
                'created_by' => Auth::user()->id,
                'added_at' => Carbon::now()
            ];
            if($request->emps_model_id && $request->emps_model_id != 'null'){
                $modelData['emps_model_id'] = $request->emps_model_id;
                $modelData['testing_appr_date_min'] = $request->emps_valid_from;
                $modelData['testing_appr_date_max'] = $request->emps_valid_upto;
            }
            DB::table('oem_model_master_vahan_use')->insert($modelData);
            alert()->success('Model added successfully!','Success')->persistent('Close');
            return redirect()->route('vahanModel');
        }catch (Exception $e) {
            alert()->error('Something went wrong!.','Error')->persistent('Close');
            return redirect()->back();
        }
    }

public function exportVahan() {
        try {
            $export = new VahanMasterExport();
            $data = $export->collection();
            if ($data->isEmpty()) {
 
                alert()->warning('No Data found','Warning')->persistent('Close');
                return redirect()->back();
            }
 
            return Excel::download($export, 'vahan_master.xlsx');
        } catch (Exception $e) {
            alert()->error('Something went wrong!.','Error')->persistent('Close');
            return redirect()->back();
        }
    }




}
