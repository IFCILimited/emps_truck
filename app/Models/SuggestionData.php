<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuggestionData extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'category', 'process','UserType', 'name', 'email', 'mobile', 'feedback_msg'
    ];


    // Define table name
    protected $table = 'suggestion';

    // Define primary key
    protected $primaryKey = 'id';
}
