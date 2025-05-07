<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ClaimDetailsExport;
use App\Models\User;
use Auth;
use Carbon\Carbon;


class VahanDashboardController extends Controller
{
    public function index()
    {
        // return view('admin.under_maintanence');

        ini_set('memory_limit', '10048M');
        ini_set('max_execution_time', 6600);

        $authApi = DB::table('encryption_keys')->where('oem_code', Auth::user()->id)->first();
        $fomated = [];


        if (
            Auth::user()->hasRole('MHI-AS') ||
            Auth::user()->hasRole('MHI-DS') ||
            Auth::user()->hasRole('MHI-OnlyView') ||
            Auth::user()->hasRole('PMA') || Auth::user()->hasRole('OEM') || Auth::user()->hasRole('OEM-Truck') || Auth::user()->hasRole('MHI')
        ) {
            $oemId = NULL;
            if (Auth::user()->hasRole('OEM')) {
                $oemId = getParentId();
            }

            $summary = DB::select('SELECT * FROM get_dashboard_consolidated_summary(?, ?, ?)', [$oemId, NULL, NULL]);

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
                if ($category->category_name == "L1" || $category->category_name == "L2") {
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
                } else {
                    $fomated[] = [
                        "categroy_name" => $category->category_name,
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
            }
            // dd($fomated);

            $fomated[] = $total_L1_L2;
            $fomated = collect($fomated);
            $fomated = $fomated->sortBy('segment_name');
        } elseif (Auth::user()->hasRole('DEALER')) {

            $details = DB::table('buyer_details_view')
                ->where('dealer_id', getParentId())
                ->where('invoice_dt', '>=', '2024-10-01')
                ->orderBy('vin_chassis_no')
                ->get();

            return view('admin.index_summary_dealer_vin', compact('details'));
        }
        // return view('admin.index', compact('totals', 'vehicleSales', 'vahan_summary', 'salesSum', 'emps_summary', 'portal_summary_edrive', 'emps_buyer_summary_total'));
        // dd($fomated);
        return view('admin.index_updated', compact('fomated'));
    }


    public function segmentWise($segment)
    {
        $toViewSegment = [];
        if (urldecode($segment) == "L1+L2" || $segment == "L1+L2") {
            $toViewSegment = ['L1', 'L2'];
        } elseif (urldecode($segment) == "L5") {
            $toViewSegment = ['L5'];
        } else {
            $toViewSegment = ['e-rickshaw & e-cart'];
        }
        $categoryInput = '{' . implode(',', $toViewSegment) . '}';
        $summary = DB::select('SELECT * FROM get_dashboard_consolidated_summary(?, ?, ?)', [NULL, $categoryInput, '1']);

        $maxPercent = 0;
        $ranked = [];

        foreach ($summary as $sum) {
            $sum->total_portal_oem = (int) $sum->emps_portal + (int) $sum->buyer_id_generated_edrive;
            $sum->total_vahm_oem = (int) $sum->total_vahan;
            $sum->percentBuyerId = 0;
            if ($sum->vahan_edrive_total > 0) {
                $percentBuyerIdGenerated = round(($sum->buyer_id_generated_edrive / $sum->vahan_edrive_total) * 100);
                $sum->percentBuyerId = $percentBuyerIdGenerated > 100 ? 100 : $percentBuyerIdGenerated;
            }

            $sum->percentFaceScanned = 0;
            if ($sum->buyer_id_generated_edrive > 0) {
                $percentFaceScaned = round(($sum->face_scans_count / $sum->buyer_id_generated_edrive) * 100);
                $sum->percentFaceScanned = $percentFaceScaned > 100 ? 100 : $percentFaceScaned;
            }

            $sum->percentVoucherGenerated = 0;
            if ($sum->face_scans_count > 0) {
                $percentVoucherGenerated = round(($sum->voucher_generated / $sum->face_scans_count) * 100);
                $sum->percentVoucherGenerated = $percentVoucherGenerated > 100 ? 100 : $percentVoucherGenerated;
            }

            $sum->percentVoucherUploaded = 0;
            if ($sum->voucher_generated > 0) {
                $percentVoucherUploaded = round(($sum->voucher_uploaded / $sum->voucher_generated) * 100);
                $sum->percentVoucherUploaded = $percentVoucherUploaded > 100 ? 100 : $percentVoucherUploaded;
            }

            $sum->percentPermanentNumber = 0;
            if ($sum->vahan_edrive_total > 0) {
                $percentPermanentNumber = round(($sum->perm_num_count / $sum->vahan_edrive_total) * 100);
                $sum->percentPermanentNumber = $percentPermanentNumber;
            }
            array_push($ranked, $sum);
        }
        usort($ranked, function ($a, $b) {
            return $b->percentFaceScanned <=> $a->percentFaceScanned;
        });
        // dd($ranked);
        $summary = $ranked;

        return view('admin.index_summary_oem_updated', compact('summary', 'toViewSegment'));
    }
}
