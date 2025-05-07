<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use Auth;

class EmpsBuyerDetailsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        ini_set('memory_limit', '10048M');
        ini_set('max_execution_time', 360000);  
        $pid = getParentId();
        $bankDetails = DB::table('emps_buyer_auth')
                ->select('model_name', 'variant_name', 'segment_name', 'vin_chassis_no', 'custmr_name', 'add', 'mobile', 'email', 'state', 'district', 'invoice_dt', 'oem_status')
                ->where(function ($query) {
                    $query->where('oem_status', '!=', 'R')
                        ->orWhereNull('oem_status');
                })
                ->where('pmedrive_dealer_id', $pid)
                
                // ->where('custmr_typ', '1')
                ->orderBy('emps_buyer_auth.id', 'DESC')
                ->get();
        return new Collection($bankDetails);
    }

    public function headings(): array
    {
        return [
            'Model Name',
            'Model Variant',
            'Dealer Segment',
            'Vin Chassis No',
            'Customer Name',
            'Address',
            'Mobile No.',
            'Email Id',
            'State',
            'District',
            'Dealer Inovoice Date',
            'OEM Status'
        ];
    }
}
