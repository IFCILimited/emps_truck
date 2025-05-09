<?php

namespace App\Models\Trucks;

use Illuminate\Database\Eloquent\Model;

class OemModelMaster extends Model
{
    protected $table = 'truck_model_master';
    protected $primaryKey = 'id';
    public $timestamps = true; // If you want to manage timestamps manually, set it to true

    // Define fillable columns if you want to use mass assignment
    protected $fillable = [
        'oem_id',
        'model_name',
        'variant_name',
        'segment_id',
        'vehicle_cat_id',
        'vehicle_img_upload_id',
        'model_status',
    ];

    // Define relationships if any
    public function user()
    {
        return $this->belongsTo(User::class, 'oem_id');
    }
}
