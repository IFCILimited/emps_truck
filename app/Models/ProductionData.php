<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionData extends Model
{

    protected $table = 'production_data';

    protected $fillable = [
        'oem_id', 
        'model_details_id', 
        'model_master_id', 
        'manufacturing_date', 
        'vin_chassis_no', 
        'colour', 
        'emission_norms', 
        'motor_number', 
        'battery_number', 
        'battery_number2', 
        'battery_number3', 
        'battery_number4', 
        'battery_number5', 
        'battery_number6', 
        'battery_number7', 
        'battery_number8', 
        'battery_number9', 
        'battery_number10', 
        'battery_make', 
        'battery_capacity', 
        'battery_chemistry', 
        'dva_indicative', 
        'pmp_compliance', 
        'status', 
        'uploaded_method',
    ];
}
