<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimLots extends Model
{
    //
    protected $table = 'claim_lots';

    protected $fillable = [
        'id','oem_id','created_by','created_at'
    ];
    public $timestamps = false;

}
