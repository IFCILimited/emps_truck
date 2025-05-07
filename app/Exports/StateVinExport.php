<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StateVinExport implements FromCollection,WithHeadings
{

    protected $portal;

    public function __construct($portal)
    {
        $this->portal = $portal;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if($this->portal == 1) {
            $collectionData = DB::table('state_wise_claim_vin_vw');
        }else{
            $collectionData = DB::table('state_wise_claim_vin_emps_vw');
        }
        return $collectionData->get();
    }

    public function headings(): array
    {
        return [
            'vin_chassis_no',
            'segment_name',
            'state',
        ];
    }
}
