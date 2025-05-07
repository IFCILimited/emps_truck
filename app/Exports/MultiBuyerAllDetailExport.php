<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class MultiBuyerAllDetailExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // dd("hello");
        ini_set('memory_limit', '10048M');
        ini_set('max_execution_time', 360000);

        $bankDetails = DB::table('buyer_details_view')
                ->select('model_name', 'variant_name', 'segment_name', 'vin_chassis_no', 'custmr_name', 'add', 'mobile', 'email', 'state', 'district', 'invoice_dt', 'status','oem_status')
                // ->where(function ($query) {
                //     $query->where('oem_status', '!=', 'R')
                //         ->orWhereNull('oem_status');
                // })
                ->where('dealer_id', Auth::user()->id)
                ->whereIn('custmr_typ', [2,3])
                ->orderBy('buyer_details_view.id', 'DESC')
                ->get();
            // dd($bankDetails);
        // $bankDetail = DB::table('buyer_details_view')
        //     ->select([
        //         // 'id',
        //         'segment_name',
        //         'model_name',
        //         'dealer_name',
        //         'dealer_code',
        //         'dealer_mobile',
        //         'dealer_email',
        //         'vin_chassis_no',
        //         'dlr_invoice_no',
        //         'invoice_dt',
        //         'vhcl_regis_no',
        //         'vihcle_dt',
        //         'tot_inv_amt',
        //         'tot_admi_inc_amt',
        //         'custmr_name',
        //         'add',
        //         'mobile',
        //         'email'
        //     ])
        //     ->whereNull('oem_status')
        //     ->where('oem_id', $pid)
        //     ->where('status', 'A')
        //     ->orderBy('invoice_dt', 'asc')
        //     ->get();
        return new Collection($bankDetails);

        // return BuyerDetail::all();
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
            'Status',
            'OEM Status'
        ];
    }
}
