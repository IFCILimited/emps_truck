<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VahanOEMModelCount extends Model
{
    use HasFactory;

    protected $table = 'vahan_api_model_data';

    protected $fillable = [
        'oem_id',
        'vahan_oem_name',
        'portal_oem_name',
        'vahan_model_name',
        'portal_model_name',
        'portal_segemt_id',
        'portal_segment_name',
        'portal_category_id',
        'portal_category_name',
        'vahan_fuel_type',
        'vahan_numberofvehiclesregistered',
        'vahan_date_of_registration',
        'response_date',
        'model_id',
        'api_from_date',
        'api_to_date'
    ];
}
