<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class BuyerDetailExport implements FromCollection, WithHeadings
{
    public function __construct()
    {
        // Constructor code if needed
    }

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
                // 'id',              
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
                'email'  
            ])
            ->whereNull('oem_status')
            ->where('oem_id', $pid)
            ->where('status', 'A')
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
        //     'S.No.',
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
            'Customer Mobile No',
            'Customer Email ID',
        ];
    }
}
