<?php

namespace App\Exports;

use App\Models\SalesData;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SalesDataExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function collection()
    {
        $id = decrypt($this->data);
        // dd($id);
        return SalesData::where('oem_id',getParentId())->where('seg_id',$id['sid'])->where('cat_id',$id['cid'])->select('vin_chasis_no','customer_name','invoice_no','invoice_dt','created_at')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            
            'VIN/Chassis No',
            'Customer Name',
            'Invoice No',
            'Invoice Date',
            'Created At',
           
           
        
        ];
    }
}
