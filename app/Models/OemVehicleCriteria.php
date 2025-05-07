<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OemVehicleCriteria extends Model
{

    protected $table = 'oem_vehicle_criteria';
    protected $fillable = [
        'user_id', 'model_id', 'range', 'max_elect_consumption', 'min_max_speed', 
        'min_acceleration', 'monitoring_device_fitment', 
        'min_ex_show_price', 'estimate_incentive_amount'
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Add other relationships if needed
}
