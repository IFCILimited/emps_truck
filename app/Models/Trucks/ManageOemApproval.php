<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManageOemApproval extends Model
{
    protected $table = 'manage_oem_approval';
    protected $fillable = [
    'oem_id',
    'model_id',
    'status',
    'remarks',
    'submitted_date',
    'created_by',
];
public $timestamps = true;

}
