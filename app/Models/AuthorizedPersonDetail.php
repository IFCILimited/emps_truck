<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorizedPersonDetail extends Model
{
    protected $table = 'authorized_person_detail';
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'pincode',
        'state',
        'district',
        'city',
        'landmark',
        'mobile',
        'email',
        'fax_no',
    ];
    public $timestamps = true;
}