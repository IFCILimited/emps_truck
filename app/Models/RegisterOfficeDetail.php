<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterOfficeDetail extends Model
{
    protected $table = 'register_office_detail';
    protected $fillable = [
        'user_id',
        'address',
        'pincode',
        'state',
        'district',
        'city',
        'landmark',
        'landline_no',
        'fax_no',
        'email',
    ];
    public $timestamps = true;
}