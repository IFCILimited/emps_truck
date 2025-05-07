<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtherDetail extends Model
{
    protected $fillable = [
        'user_id',
        'dealer_mode',
        'dealer_no',
        'no_of_dealers',
        'dealer_state',
        'dealer_upload_id',
    ];
    public $timestamps = true;
}