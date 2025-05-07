<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManufacturingInformation extends Model
{
    protected $fillable = [
        'user_id',
        'company_registration_no',
        'registration_certificate_upload_id',
        'gstin_no',
        'gstin_registration_upload_id',
        'oem_pan',
        'oem_pan_upload_id',
        'r_and_d_facilities_upload_id',
        'annual_turnover',
    ];
    public $timestamps = true;
}