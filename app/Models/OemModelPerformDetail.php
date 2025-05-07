<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OemModelPerformDetail extends Model
{
    protected $fillable = [
        'user_id', 'model_id', 'vehicle_seg', 'vehicle_cat', 'tech_type', 'fuel_type',
        'factory_price', 'vechicle_upload_id',
    ];

    // Define relationships, for example, to a User model
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // If 'vechicle_upload_id' is a foreign key to another model, define that relationship too
}
