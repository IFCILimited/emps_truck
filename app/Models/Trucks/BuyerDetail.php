<?php

namespace App\Models\Trucks;

use Illuminate\Database\Eloquent\Model;

class BuyerDetail extends Model
{
    protected $table = 'buyer_details_trucks';

    protected $fillable = [
        'oem_id',
        'dealer_id',
        'production_id',
        'custmr_typ',
        'custmr_name',
        'add',
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
        'sec_file_uploadeid',
        'gender',
        'invoice_dt',
        'status',
        'claim_id',
        'oem_remarks',
        'oem_status',
        'oem_status_at',
        'dob',
        'discount_given',
        'discount_amt',
        'empsbeforeafter',
        'child_id',
        'aadhaarConsent',
        'auth_per_name'
    ];
}
