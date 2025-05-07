<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostRegistrationDetail extends Model
{
    protected $table = 'post_registration_detail';

    protected $fillable = [
        'user_id',
        'gstin_no',
        'gstin_registration_upload_id',
        'oem_pan',
        'oem_pan_upload_id',
        'r_and_d_facilities_upload_id',
        'annual_turnover',
        'account_holder_name',
        'account_no',
        'ifsc_code',
        'micr_code',
        'account_type',
        'bank_name',
        'branch_name',
        'branch_address',
        'branch_pincode',
        'branch_state',
        'branch_district',
        'branch_city',
        'dealer_mode',
        'dealer_no',
        'no_of_dealers',
        'dealer_state',
        'dealer_upload_id',
    ];
}

