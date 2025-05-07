<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use DB;

class BuyerDetailStage implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        ini_set('memory_limit', '10048M');
        ini_set('max_execution_time', 360000);  

        $pid = getParentId();
        $bankDetail = DB::table('buyer_details_view')
            ->select([
                'segment_name',     
                'model_name',        
                'dealer_name',       
                'dealer_code',       
                'dealer_mobile',  
                'dealer_email',   
                'vin_chassis_no',    
                'dlr_invoice_no',        
                'invoice_dt',        
                'vhcl_regis_no',    
                'vihcle_dt',    
                'tot_inv_amt',    
                'tot_admi_inc_amt',  
                'custmr_name',     
                'add',           
                'mobile',
                'email',
                DB::raw("CASE WHEN status = 'D' THEN 'Stage 1' WHEN status = 'S' THEN 'Stage 2' ELSE status END as stage")
            ])
            ->whereNull('oem_status')
            ->where('oem_id', $pid)
            ->whereIn('status', ['S','D'])
            ->orderBy('invoice_dt', 'asc')
            ->get();

        return new Collection($bankDetail);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Model Segment',
            'Model Name',
            'Dealer Name',
            'Dealer Code',
            'Dealer Mobile No.',
            'Dealer Email ID',
            'VIN Chassis No.',
            'Invoice No.',
            'Invoice Date',
            'Vehicle Reg. No.',
            'Vehicle Reg. Date',
            'Invoice Amount',
            'Incentive Amount',
            'Customer Name',
            'Address',
            'Customer Mobile No.',
            'Customer Email ID',
            'Status'
        ];
    }
}
