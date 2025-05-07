<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class VahanMasterExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $collectionData = DB::table('oem_model_master_vahan_use')
            ->select(
                'oem_id' , 'name', 'segment_id' , 'vehicle_cat_id' , 'category_name' , 'segment_name', 
                'MORTH_RC_MODEL' , 'MORTH_MODEL' , 'MORTH_OEM' , 
                'testing_appr_date_min' , 'testing_appr_date_max' , 'emps_model_id'  
            )->get();
        return $collectionData;
    }

    public function headings(): array
    {
        return [
            'oem_id',
            'oem_name',
            'segment_id',
            'category_id',
            'category_name',
            'segment_name',
            'MORTH_RC_MODEL',
            'MORTH_MODEL',
            'MORTH_OEM',
            'emps_certificate_valid_from',
            'emps_certificate_valid_to',
            'emps_model_id'
        ];
    }
}
