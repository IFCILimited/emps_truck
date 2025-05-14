<?php

namespace App\Models\Trucks;

use Illuminate\Database\Eloquent\Model;

class TempProductionData extends Model
{

    protected $table = 'temp_production_data_trucks';

    protected $fillable = [
        'oem_id', 
        'model_details_id', 
        'model_master_id', 
        'manufacturing_date', 
        'vin_chassis_no', 
        'colour', 
        'emission_norms', 
        'motor_number', 
        'gross_weight',
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
        'uploaded_method',
'child_id' 
    ];

    protected $casts = [
        'Manufacturing_Date' => 'date',
        'processed' => 'boolean',
    ];

    /**
     * Get the user that owns the TempProductionData
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public function OemModelMaster()
    {
        return $this->belongsTo('App\OemModelMaster', 'model_master_id','id');
    }
}
