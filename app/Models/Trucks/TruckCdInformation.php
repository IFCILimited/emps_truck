<?php

namespace App\Models\Trucks;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruckCdInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'cd_number',
        'cd_owner_name',
        'vehicle_gvw',
        'vin_scrapped',
        'status_flag',
        'cd_issue_date',
        'cd_validity_upto',
        'buyer_detail_id',
        'vin_chassin_no',
        'cd_status',
    ];
}
