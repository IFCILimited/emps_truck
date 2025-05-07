<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClaimExport implements FromCollection, WithHeadings
{
    protected $claimno;

    public function __construct($claimno)
    {
        $this->claimno = $claimno;
    }

    public function collection()
    {
        return DB::table('tblclaimvahanresult')
        ->where('claim_id', $this->claimno)
        ->orderBy('s_no', 'asc')
        ->selectRaw("
            s_no, claim_id, claim_no, vehicle_segment, oemname, model_name, battery_capacity,
            TO_CHAR(manufacturing_date::date, 'DD-MM-YYYY') AS manufacturing_date,
            rc_manu_month_yr, dealer_name, buyer_name, v4_owner_name, v4_customer_name_unmasked,
            customertype_desc, mobile_number,
            TO_CHAR(invoicedate::date, 'DD-MM-YYYY') AS invoicedate,
            TO_CHAR(v4_date_of_registration::date, 'DD-MM-YYYY') AS v4_date_of_registration,
            TO_CHAR(claim_submission_dt::date, 'DD-MM-YYYY') AS claim_submission_dt,
            TO_CHAR(v4_purchase_dt::date, 'DD-MM-YYYY') AS v4_purchase_dt,
            vin_chassis_no, vehicle_reg_no, v4_regn_no, incentive_amt, eligible_incentive,
            approved_incentive, final_approved_by_pma, rejected_incentive,
            final_rejected_by_pma, status, final_status_by_pma, v4_remark, remark, pma_remark,
            v4_maker, v4_vh_class, v4_eng_no, v4_state, rc_registered_at, v4_fuel_desc,
            duplicateclaims, customeridno, oem_id, battery_number, batterychemistry, dva, pmp,
            TO_CHAR(mhi_noting_appr_date::date, 'DD-MM-YYYY') AS mhi_noting_appr_date,
            TO_CHAR(testing_cmvr_date::date, 'DD-MM-YYYY') AS testing_cmvr_date,
            TO_CHAR(testing_approval_date::date, 'DD-MM-YYYY') AS testing_approval_date,
            TO_CHAR(testing_expiry_date::date, 'DD-MM-YYYY') AS testing_expiry_date,
            certificate_validity_period, certificate_numbers, model_id, buyurid,bat_capacity_prod_data,factory_price,motor_number,adh_verify 
        ")
        ->selectRaw("
            CASE
                WHEN vehicle_reg_no IS NOT NULL AND vihcle_dt IS NOT NULL
                THEN 'Y' ELSE 'N'
            END AS evoucher_generated,
            CASE
                WHEN self_copy_id IS NOT NULL
                THEN 'Y' ELSE 'N'
            END AS self_copy_uploaded
        ")
        ->get();

            
        }
       
    

    public function headings(): array
    {
        return [
            'S.No.',
            'Claim ID',
            'Claim  Number',
            'Vehicle Segment',
            'OEM Name',
            'Model Name',
            'Battery Capacity',
            'Manufacturing Date',
            'V4 Manufacturing Date',
            'Dealer Name',
            'Buyer Name',
            'V4 Owner Name',
            'V4 Owner Name Unmasked' ,
            'Customer Type',
            'Mobile Number',
            'Invoice Date',
            'V4 Date of Registration',
            'Claim Submission Date',
            'V4 Purchase Date',
            'Vin Chassis No.',
            'Vehicle Reg. No.',
            'V4 Reg. No.',
            'Claimed Incentive',
            'Eligible_incentive as per criteria',
            'Approved_incentive by system',
            'Final approved by PMA',
            'Rejected_incentive by System',
            'Final Rejected by PMA',
            'Status by System',
            'Final Status by PMA',
            'V4 Remark',
            'System Remark',
            'Final Remark by PMA',
            'V4 Maker',
            'V4 Vh. class',
            'V4 Eng. No.',
            'V4 State',
            'V4 Office',
            'V4 Fuel Desc',
            'Duplicate claims',
            'Customer Id No.',
            'OEM ID',
            'Battery Numbers',
            'Battery Chemistry',
            'DVA',
            'PMP',
            'MHI Model Approval Date',
            'Certificate CMVR Date',
            'Certificate From Date',
            'Certificate Expiry Date',
            'Certificate Dates',
            'Certificate Numbers',
            'Model ID',
            'Buyer ID',
	    'Battery Capacity As Per Production Data',
	    'Ex-Factory Price',
	    'Motor Number AS Per Production Data',
            'Addhar Verify',
            'E-Voucher Generated',
            'Self Copy Uploaded'
    ];
    }
}
