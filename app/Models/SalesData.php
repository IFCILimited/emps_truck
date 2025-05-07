<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesData extends Model
{
    use HasFactory;

    protected $table = 'salesdata';

    protected $fillable = [
        'oem_id',
        'seg_id',
        'cat_id',
        'vin_chasis_no',
        'customer_name',
        'invoice_no',
        'invoice_dt',
        'created_by',
        // 'updated_by',
    ];
}
