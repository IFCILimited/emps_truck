<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormData extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'category', 'process', 'name', 'email', 'mobile', 'feedback_msg'
    ];


    // Define table name
    protected $table = 'feedback';

    // Define primary key
    protected $primaryKey = 'id';
}
