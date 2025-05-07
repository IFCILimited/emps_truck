<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VinChassisEdit extends Model
{
    use HasFactory;

   
    protected $table = 'vin_chassis_edit';

  
    protected $fillable = [
        'oem_id',
        'valid_from',
        'valid_to',
        'reason',
        'vin_document',
        'vin_chassis',
        'created_by',
    ];

  
    protected $casts = [
        'vin_chassis' => 'array', 
    ];

   
    protected $dates = [
        'valid_from',
        'valid_to',
        'created_at',
        'updated_at',
    ];

  
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

   
    
     
    public function oem()
    {
        return $this->belongsTo(User::class, 'oem_id'); 
    }
}
