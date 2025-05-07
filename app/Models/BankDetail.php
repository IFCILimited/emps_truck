<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    protected $fillable = [
        'user_id',
        'account_holder_name',
        'account_no',
        'ifsc_code',
        'micr_code',
        'account_type',
        'bank_name',
        'branch_name',
        'address',
        'pincode',
        'state',
        'district',
        'city',
    ];
    public $timestamps = true;
}