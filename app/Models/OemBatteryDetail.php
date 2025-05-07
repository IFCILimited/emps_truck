<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OemBatteryDetail extends Model
{
    protected $fillable = [
        'user_id', 'model_id', 'spec_density', 'life_cyc', 'no_of_battery',
        'tot_energy', 'battery_make', 'battery_capacity',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // Add other relationships if necessary
}
