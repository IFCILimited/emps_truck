<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimMaster extends Model
{
    //
    protected $table = 'claim_master';

    protected $fillable = [
        'id',
        'claimnumberformat',
        'oem_id',
        'created_by',
        'created_at',
        'updated_at',
        'vehicle_count',
        'tot_incamt',
    ];
    public $timestamps = false;

}
