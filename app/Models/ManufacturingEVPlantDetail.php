<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManufacturingEVPlantDetail extends Model
{

    protected $table = 'manufacturing_ev_plants_detail';
        protected $fillable = [
        'user_id',
        'address',
        'plant_name',
        'email',
        'pincode',
        'state',
        'district',
        'city',
        'landline_no',
    ];
    public $timestamps = true;
}