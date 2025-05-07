<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempBankDetail extends Model
{
    protected $table = 'temp_bank_details';
    protected $fillable = [
                'user_id',
                'ifsc_code',
                'account_holder_name',
                'bank_name',
                'branch_name',
                'branch_address',
                'branch_city',
                'account_no',
                'micr_code',
                'account_type',
                'branch_pincode',
                'branch_state',
                'branch_district',
                'Status',
                'created_at',
                'updated_at'
    ];
}
