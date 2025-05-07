<?php

namespace App\Models;

use Carbon\Traits\Timestamp;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReleaseVinDetails extends Model
{
    use HasFactory;

    protected $table = 'buyer_details_release';

    protected $fillable = [
        'oem_id',
        'dealer_id',
        'production_id',
        'custmr_typ',
        'custmr_name',
        "add",
        'landmark',
        'pincode',
        'state',
        'district',
        'city',
        'mobile',
        'email',
        'custmr_id',
        'custmr_id_no',
        'addi_cust_id',
        'cust_id_sec',
        'dlr_invoice_no',
        'vihcle_dt',
        'amt_custmr',
        'invoice_amt',
        'addmi_inc_amt',
        'tot_inv_amt',
        'tot_admi_inc_amt',
        'copy_file_uploadid',
        'sec_file_uploadeif',
        'created_at',
        'updated_at',
        'claim_id',
        'invoice_dt',
        'gender',
        'vin_chassis_no',
        'segment_id',
        'status',
        'sec_file_uploadeid',
        'cst_ack_file',
        'invc_copy_file',
        'vhcl_reg_file',
        'vhcl_regis_no',
        'oem_remarks',
        'oem_status',
        'oem_status_at',
        'discount_given',
        'discount_amt',
        'empsbeforeafter',
        'dob',
        'child_id',
        'aadhaarconsent',
        'pma_status',
        'pma_process_by',
        'pma_process_at',
        'expiry_120',
        'buyer_id',
        'adh_verify',
        'buyer_submitted_at',
        'certificate_num',
        'temp_reg_no',
        'pan',
        'pancopy_id',
        'gstin',
        'gstin_id',
        'adhar_name',
        'remarks',
        'user_action',
        'action_at'
    ];

    public $timestamps = true;
}
