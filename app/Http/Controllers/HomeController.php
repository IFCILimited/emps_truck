<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Counter;

class HomeController extends Controller
{


    public function index()
    {
        $counter = Counter::firstOrCreate([], ['count' => 0]);
            // Increment the counter
        $counter->increment('count');

        return view('landing.index');
    }

    // public function dashboard(){
    //     return view('layouts.dashboard_master');
    // }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
    public function signin($roleid)
    {
        $role_id = decrypt($roleid);
        session(['role_id' => $role_id]);
        return redirect()->route('login');
    }

    public function contact()
    {
        return view('landing.contact');
    }
    public function about_us()
    {
        return view('landing.about_us');
    }
    public function feedback()
    {
        return view('landing.feedback');
    }
    public function impotrant_links()
    {
        return view('landing.important_links');
    }
    public function press_release()
    {
        return view('landing.press_release');
    }
    public function FAQs()
    {
        return view('landing.faq');
    }
    public function policy_document()
    {
        return view('landing.policy_doc');
    }
    public function policy_procedure()
    {
        return view('landing.policy_procedure');
    }
    public function suggestion()
    {
        return view('landing.suggestion');
    }
    public function support()
    {
        return view('landing.support');
    }
    public function who()
    {
        return view('landing.who');
    }
    public function dashboard()
    {

        // return view('landing.under_maintanence');

        // $claime2w1Amtsub = DB::table('buyer_details_view')->where('oem_status', 'A')->where('segment_id', '1')->where('vehicle_cat_id', '1')->whereNotNull('claim_id')->whereNotNull('lot_id')->sum('addmi_inc_amt');
        // $claime2w2Amtsub = DB::table('buyer_details_view')->where('oem_status', 'A')->where('segment_id', '1')->where('vehicle_cat_id', '2')->whereNotNull('claim_id')->whereNotNull('lot_id')->sum('addmi_inc_amt');
        // $claimse2wAmtsub = $claime2w1Amtsub + $claime2w2Amtsub;   
        // $claimse3wAmtsub = DB::table('buyer_details_view')->where('oem_status', 'A')->where('segment_id', '2')->where('vehicle_cat_id', '3')->whereNotNull('claim_id')->whereNotNull('lot_id')->sum('addmi_inc_amt');
        // $claimse3wL5Amtsub = DB::table('buyer_details_view')->where('oem_status', 'A')->where('segment_id', '2')->where('vehicle_cat_id', '4')->whereNotNull('claim_id')->whereNotNull('lot_id')->sum('addmi_inc_amt');
        // $fuel_co2 = DB::table('vw2_fuel_saved_co2') ->selectRaw('SUM(fuelsaved_perday) as total_fuelsaved_perday, SUM(totalfuelsaved) as total_fuel_saved, SUM(co2perday) as co2perday, SUM(co2total) as co2total')->get();

        $carbonData=DB::table('claim_fuel_co2_results')->first();

    // $consolidated_summary = DB::table('consolidated_dashboard_summary_vw')->get();
    // // $consolidated_array = json_decode(json_encode($consolidated_summary, true));
    // // dd($consolidated_summary);
    // $fomated = [];
    // $total_L1_L2 = [
    //     "categroy_name" => "L1+L2",
    //     "segment_name" => "e-2W",
    //     "target_sales" => 0,
    //     "voucher_generated" => 0,
    //     "voucher_uploaded" => 0,
    //     "drive_vahan" => 0,
    //     "drive_portal" => 0,
    //     "emps_vahan" => 0,
    //     "emps_portal" => 0,
    //     "total_vahan" => 0,
    //     "total_portal" => 0,
    //     "face_scans_count" => 0,
    //     "claim_drive" => 0,
    //     "claim_emps" => 0,
    //     "buyer_id_drive" => 0
    // ];
    // foreach ($consolidated_summary as $category) {
    //     if ($category->categroy_name == "L1" || $category->categroy_name == "L2") {
    //         $total_L1_L2['target_sales'] = (float) $category->target_sales;
    //         $total_L1_L2['voucher_generated'] += (int) $category->voucher_generated;
    //         $total_L1_L2['voucher_uploaded'] += (int) $category->voucher_uploaded;
    //         $total_L1_L2['drive_vahan'] += (int) $category->drive_vahan;
    //         $total_L1_L2['drive_portal'] += (int) $category->drive_portal;
    //         $total_L1_L2['emps_vahan'] += (int) $category->emps_vahan;
    //         $total_L1_L2['emps_portal'] += (int) $category->emps_portal;
    //         $total_L1_L2['total_vahan'] += (int) $category->total_vahan;
    //         // $total_L1_L2['total_portal'] += (int) $category->total_portal;
    //         // $total_L1_L2['total_portal'] += (int) $category->emps_portal + (int) $category->face_scans_count;
    //         $total_L1_L2['total_portal'] += (int) $category->emps_portal + (int) $category->buyer_id_generated_edrive;
    //         $total_L1_L2['face_scans_count'] += (int) $category->face_scans_count;
    //         $total_L1_L2['claim_drive'] += (int) $category->claim_edrive;
    //         $total_L1_L2['claim_emps'] += (int) $category->claim_emps;
    //         $total_L1_L2['buyer_id_drive'] += (int) $category->buyer_id_generated_edrive;
    //     }else{
    //         $fomated[] = [
    //             "categroy_name" => $category->categroy_name,
    //             "segment_name" => $category->segment_name,
    //             "target_sales" => $category->target_sales,
    //             "voucher_generated" => $category->voucher_generated,
    //             "voucher_uploaded" => $category->voucher_uploaded,
    //             "drive_vahan" => $category->drive_vahan,
    //             "drive_portal" => $category->drive_portal,
    //             "emps_vahan" => $category->emps_vahan,
    //             "emps_portal" => $category->emps_portal,
    //             "total_vahan" => $category->total_vahan,
    //             // "total_portal" => $category->total_portal,
    //             // "total_portal" => (int) $category->emps_portal + (int) $category->face_scans_count,
    //             "total_portal" => (int) $category->emps_portal + (int) $category->buyer_id_generated_edrive,
    //             "face_scans_count" => $category->face_scans_count,
    //             "claim_drive" => $category->claim_edrive,
    //             "claim_emps" => $category->claim_emps,
    //             "buyer_id_drive" => $category->buyer_id_generated_edrive
    //         ];
    //     }
    // }
    // $fomated[] = $total_L1_L2;
    // $fomated = collect($fomated); // Convert to collection if it isn't already
    // $fomated = $fomated->sortBy('segment_name'); // Sort by 'segment_name'

    $summary_prev =  DB::table('dashboard_consolidated_summary_current_updated_vw as dcs')
            // $summary_prev =  DB::table('dashboard_consolidated_summary as dcs')
            ->select(
                'dcs.categroy_name',
                'dcs.segment_name',
                DB::raw("
                    CASE 
                        WHEN dcs.categroy_name = 'L1' OR dcs.categroy_name = 'L2' THEN
                            (SELECT SUM(target_sales) FROM segment_sales ss WHERE ss.fy = '2024-25' and ss.vehicle_cat IS NULL)
                        ELSE
                            (SELECT SUM(target_sales) FROM segment_sales ss WHERE ss.fy = '2024-25' and ss.vehicle_cat = dcs.category_id)
                    END AS target_sales
                "),
                DB::raw('SUM(dcs.sales_e_voucher) as voucher_generated'),
                DB::raw('SUM(dcs.sales_e_voucher_uploaded) as voucher_uploaded'),
                DB::raw('SUM(dcs.sales_drive_vahan) as drive_vahan'),
                DB::raw('SUM(dcs.sales_drive_portal) as drive_portal'),
                DB::raw('SUM(dcs.sales_emps_vahan) as emps_vahan'),
                DB::raw('SUM(dcs.sales_emps_portal) as emps_portal'),
                DB::raw('SUM(dcs.total_sales_vahan) as total_vahan'),
                DB::raw('SUM(dcs.total_sales_portal) as total_portal'),
                DB::raw('SUM(dcs.claim_edrive) as claim_drive'),
                DB::raw('SUM(dcs.claim_emps) as claim_emps'),
                DB::raw('SUM(dcs.face_scanned_count) as face_scans_count'),
                DB::raw('SUM(dcs.buyer_id_edrive) as buyer_id_generated_edrive'),
                DB::raw('SUM(dcs.perm_num_count) as perm_num_count'),
                DB::raw('SUM(dcs.vahan_edrive_approved) as vahan_edrive_approved'),
                DB::raw('SUM(dcs.vahan_edrive_unapproved) as vahan_edrive_unapproved'),
                DB::raw('SUM(dcs.vahan_edrive_total) as vahan_edrive_total')
            );

            $summary = $summary_prev->groupBy('dcs.category_id', 'dcs.segment_id', 'dcs.categroy_name', 'dcs.segment_name')
            ->orderBy('dcs.category_id')
            ->get();

            $fomated = [];
            $total_L1_L2 = [
                "categroy_name" => "L1+L2",
                "segment_name" => "e-2W",
                "target_sales" => 0,
                "voucher_generated" => 0,
                "voucher_uploaded" => 0,
                "drive_vahan" => 0,
                "drive_portal" => 0,
                "emps_vahan" => 0,
                "emps_portal" => 0,
                "total_vahan" => 0,
                "total_portal" => 0,
                "claim_drive" => 0,
                "claim_emps" => 0,
                "face_scans_count" => 0,
                "buyer_id_drive" => 0,
                "drive_vahan_approved" => 0,
                "drive_vahan_unapproved" => 0,
                "drive_vahan_total" => 0,
                "perm_num_count_edrive" => 0,
                "percent_buyer_id" => 0,
                "percent_face_scanned" => 0,
                "percentVoucherGenerated" => 0,
                "percentVoucherUploaded" => 0,
                "percentPermanentNumber" => 0
            ];
            foreach ($summary as $category) {
                if ($category->categroy_name == "L1" || $category->categroy_name == "L2") {
                    $total_L1_L2['target_sales'] = (float) $category->target_sales;
                    $total_L1_L2['voucher_generated'] += (int) $category->voucher_generated;
                    $total_L1_L2['voucher_uploaded'] += (int) $category->voucher_uploaded;
                    $total_L1_L2['drive_vahan'] += (int) $category->drive_vahan;
                    $total_L1_L2['drive_portal'] += (int) $category->drive_portal;
                    $total_L1_L2['emps_vahan'] += (int) $category->emps_vahan;
                    $total_L1_L2['emps_portal'] += (int) $category->emps_portal;
                    $total_L1_L2['total_vahan'] += (int) $category->total_vahan;

                    $total_L1_L2['drive_vahan_approved'] += (int) $category->vahan_edrive_approved;
                    $total_L1_L2['drive_vahan_unapproved'] += (int) $category->vahan_edrive_unapproved;
                    $total_L1_L2['drive_vahan_total'] += (int) $category->vahan_edrive_total;
                    // $total_L1_L2['total_portal'] += (int) $category->total_portal;
                    // $total_L1_L2['total_portal'] += (int) $category->emps_portal + (int) $category->face_scans_count;
                    $total_L1_L2['total_portal'] += (int) $category->emps_portal + (int) $category->buyer_id_generated_edrive;
                    $total_L1_L2['claim_drive'] += (int) $category->claim_drive;
                    $total_L1_L2['claim_emps'] += (int) $category->claim_emps;
                    $total_L1_L2['face_scans_count'] += (int) $category->face_scans_count;
                    $total_L1_L2['buyer_id_drive'] += (int) $category->buyer_id_generated_edrive;
                    $total_L1_L2['perm_num_count_edrive'] += (int) $category->perm_num_count;
                }else{
                    $fomated[] = [
                        "categroy_name" => $category->categroy_name,
                        "segment_name" => $category->segment_name,
                        "target_sales" => $category->target_sales,
                        "voucher_generated" => $category->voucher_generated,
                        "voucher_uploaded" => $category->voucher_uploaded,
                        "drive_vahan" => $category->drive_vahan,
                        "drive_portal" => $category->drive_portal,
                        "emps_vahan" => $category->emps_vahan,
                        "emps_portal" => $category->emps_portal,
                        "total_vahan" => $category->total_vahan,

                        "drive_vahan_approved" => $category->vahan_edrive_approved,
                        "drive_vahan_unapproved" => $category->vahan_edrive_unapproved,
                        "drive_vahan_total" => $category->vahan_edrive_total,
                        // "total_portal" => $category->total_portal,
                        // "total_portal" => (int) $category->emps_portal + (int) $category->face_scans_count,
                        "total_portal" => (int) $category->emps_portal + (int) $category->buyer_id_generated_edrive,
                        "claim_drive" => $category->claim_drive,
                        "claim_emps" => $category->claim_emps,
                        "face_scans_count" => $category->face_scans_count,
                        "buyer_id_drive" => $category->buyer_id_generated_edrive,
                        "perm_num_count_edrive" => $category->perm_num_count,
                    ];
                }
            };

            $fomated[] = $total_L1_L2;
            $fomated = collect($fomated);
            $fomated = $fomated->sortBy('segment_name');

// dd($fomated);
// $maxDateOfVahan = DB::table('vahan_api_model_data')->max('api_to_date');
$maxDateOfVahan = DB::table('vahan_api_model_data_approved')->max('api_to_date');

// return view('landing.dashboard_updated', compact('fomated', 'maxDateOfVahan','fuel_co2','claimse2wAmtsub','claimse3wAmtsub','claimse3wL5Amtsub'));
return view('landing.dashboard_updated', compact('fomated', 'maxDateOfVahan','carbonData'));

    }



    public function ClaimSubmissionAnnouncements()
    {
        return view('landing.ClaimSubmissionAnnouncements');
    }
    public function draftPMPGuidelines()
    {
        return view('landing.draft_guideline');
    }
    public function EVPCSGuidelines()
    {
        return view('landing.EVPCS_guideline');
    }
    public function empsSales()
    {
        dd(empsSale());
        return view('landing.draft_guideline');
    }
    public function models($oem_id = null, $segment=null ,$status = null)
    {

        // dd($oem_id,$segment);
           
        $oemname = DB::table('users')
        ->select('users.id as oem_id', 'users.name as oem_name')
        ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->where('users.oem_type_id', 3)
        ->where('model_has_roles.role_id', 4)
        ->where('users.approval_for_post_reg', 'A')
        ->where('users.post_registration_status', 'A')
        ->orderBy('users.name')
        ->get();
                    // dd($oem_name);
        if($oem_id != null &&  $segment != null){

            $oem_name = DB::table('users')
            ->select('users.id as oem_id', 'users.name as oem_name')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('users.oem_type_id', 3)
            ->where('users.id', $oem_id)
            ->where('model_has_roles.role_id', 4)
            ->where('users.approval_for_post_reg', 'A')
            ->where('users.post_registration_status', 'A')
            ->orderBy('users.name')
            ->get();
       
            $model_detail = DB::table('vw_model_details')
            ->select(
                'vw_model_details.*', // Select all columns
                DB::raw('(CASE 
                    WHEN valid_from <= NOW() AND valid_upto >= NOW() THEN \'Active\' 
                    ELSE \'Expired\' 
                END) AS acstatus')
            )
            ->where('mhi_flag', 'A')
            ->where('oem_id', $oem_id)
            ->where('segment_id', $segment)
            ->orderBy('vw_model_details.model_name')
            ->get();
        
            


        }
        else{

            $oem_name = DB::table('users')
            ->select('users.id as oem_id', 'users.name as oem_name')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->where('users.oem_type_id', 3)
            ->where('model_has_roles.role_id', 4)
            ->where('users.approval_for_post_reg', 'A')
            ->where('users.post_registration_status', 'A')
            ->orderBy('users.name')
            ->get();

            $model_detail = DB::table('vw_model_details')
            ->select(
                'vw_model_details.*', // Select all columns
                DB::raw('(CASE 
                    WHEN valid_from <= NOW() AND valid_upto >= NOW() THEN \'Active\' 
                    ELSE \'Expired\' 
                END) AS acstatus')
            )
            ->where('mhi_flag', 'A')
            // ->where('oem_id', $oem_id)
            // ->where('segment_id', $segment)
            ->orderBy('vw_model_details.model_name')
            ->get();

            
            // dd($model_detail);
        }

            return view('landing.models', compact('oem_name','oemname','oem_id','segment','status', 'model_detail'));
    }
}
