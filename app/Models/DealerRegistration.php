<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DealerRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'dealer_code',
        'gstin_number',
        'authorized_person_name',
        'pin_code',
        'address',
        'landline_no',
        'landmark',
        'mobile_no',
        'state',
        'fax_no',
        'district',
        'email_id',
        'dealer_name'
    ];
}
