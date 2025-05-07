<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OEMType extends Model
{
        protected $table = 'oem_types';

       protected $fillable = [
        'type',
    ];
    public $timestamps = true;
}