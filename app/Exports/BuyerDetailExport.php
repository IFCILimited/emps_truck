<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class BuyerDetailExport implements FromCollection, WithHeadings
{
    public $status;
    public $type;
    public $approvedOrPendingHeaders;
    public $approvedOrPendingColumns;
    public $rejectedColumns;
    public $rejectedHeaders;
    public $approvedOrPendingBulkHeaders;
    public $approvedOrPendingBulkColumns;
    public $rejectedBulkColumns;
    public $rejectedBulkHeaders;

    public function __construct($status, $type)
    {
        $this->status = $status;
        $this->type = $type;
        $this->approvedOrPendingColumns = [
            'segment_name',
            'vehicle_cat',
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
            'invoice_amt',
            'tot_admi_inc_amt',
            'buyer_id',
            'custmr_name',
            'adhar_name',
            'add',
            'mobile',
            'email',
            'buyer_submitted_at'
        ];

        if ($this->status == 'A') {
            $this->approvedOrPendingColumns[] = 'oem_status_at';
        }
        $this->rejectedColumns = [
           'segment_name',
           'vehicle_cat',
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
            'invoice_amt',
            'tot_admi_inc_amt',
            'buyer_id',
            'custmr_name',
            'adhar_name',
            'add',
            'mobile',
            'email',
            'oem_status_at',
            'oem_remarks'
        ];

        $this->approvedOrPendingHeaders = [
            'Model Segment',
            'Category Name',
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
            'Customer ID',
            'Customer Name',
            'Customer Name as per Aadhar',
            'Customer Address',
            'Customer Mobile No',
            'Customer Email ID',
            'Dealer Submitted at'
        ];

        if ($this->status == 'A') {
            $this->approvedOrPendingHeaders[] = 'OEM Approved at';
        }

        $this->rejectedHeaders = [
            'Model Segment',
            'Category Name',
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
            'Customer ID',
            'Customer Name',
            'Customer Name as per Aadhar',
            'Customer Address',
            'Customer Mobile No',
            'Customer Email ID',
            'Reverted Date',
            'OEM Status & Remarks'
        ];

        $this->approvedOrPendingBulkColumns = [
            'segment_name',
            'vehicle_cat',
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
            'invoice_amt',
            'tot_admi_inc_amt',
            'buyer_id',
            'custmr_name',
            'add',
            'mobile',
            'email',
            'adhar_name',
            'buyer_submitted_at',
            'status',
            'oem_status'
        ];

        if ($this->type == '2' && $this->status == 'A'){
            $this->approvedOrPendingBulkColumns[] = 'oem_status_at';
        }

        $this->approvedOrPendingBulkHeaders = [
            'Model Segment',
            'Category Name',
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
            'Customer ID',
            'Customer Name',
            'Address',
            'Customer Mobile No',
            'Customer Email ID',
            'Customer Aadhar Name',
            'Dealer Submitted at',
            'Status',
            'OEM Status',
            // 'OEM Status at'
        ];
        if ($this->type == '2' && $this->status == 'A'){
                $this->approvedOrPendingBulkHeaders[] = 'OEM Approved at';
        }
        $this->rejectedBulkColumns = [
            'segment_name',
            'vehicle_cat',
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
            'invoice_amt',
            'tot_admi_inc_amt',
            'buyer_id',
            'custmr_name',
            'adhar_name',
            'add',
            'mobile',
            'email',
            'oem_status_at',
            'oem_remarks'
        ];

        $this->rejectedBulkHeaders = [
            'Model Segment',
            'Category Name',
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
            'Customer ID',
            'Customer Name',
            'Customer Name as per Aadhar',
            'Customer Address',
            'Customer Mobile No',
            'Customer Email ID',
            'Reverted Date',
            'OEM Status & Remarks'
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // dd($this->approvedOrPendingHeaders, $this->rejectedHeaders);
        ini_set('memory_limit', '10048M');
        ini_set('max_execution_time', 360000);

        $pid = getParentId();

    if ($this->type == '1'){
            $query = DB::table('buyer_details_view');
            $bankDetail = $query;

            if ($this->status == 'P') {
                $bankDetail->whereNull('oem_status')->where('status', 'A')->where('oem_id', $pid)->where('custmr_typ', 1)->select($this->approvedOrPendingColumns);
            } elseif ($this->status == 'A') {
                $bankDetail->where('oem_status', 'A')->where('status', 'A')->where('oem_id', $pid)->where('custmr_typ', 1)->select($this->approvedOrPendingColumns);
            } elseif ($this->status == 'R') {
                $bankDetail->where('oem_status', 'R')->where('oem_id', $pid)->where('custmr_typ', 1)->select($this->rejectedColumns);
            }
            $bankDetail = $bankDetail->orderBy('invoice_dt', 'asc')->get();
            return new Collection($bankDetail);
    }else {


        $columnsApprPending = ['sm.segment_name', 'cm.category_name', 
        'mm.model_name', 'us.name', 'us.dealer_code', 'us.mobile', 'us.email',
        'bdv.vin_chassis_no', 'bdv.dlr_invoice_no', 'bdv.invoice_dt',
        'bdv.vhcl_regis_no', 'bdv.vihcle_dt', 'bdv.tot_inv_amt','bdv.tot_admi_inc_amt',
        'bdv.buyer_id', 'bdv.custmr_name', 'bdv.add', 'bdv.mobile as cust_mobile',
        'bdv.email as cust_email', 'bdv.adhar_name','bdv.buyer_submitted_at','bdv.status','bdv.oem_status', 'bdv.oem_status_at'];

        if($this->type == '2' && $this->status == 'A'){
            $columnsApprPending[] = 'oem_status_at';
        }

        $columnsRejected = ['sm.segment_name', 'cm.category_name', 
        'mm.model_name', 'us.name', 'us.dealer_code', 'us.mobile', 'us.email',
        'bdv.vin_chassis_no', 'bdv.dlr_invoice_no', 'bdv.invoice_dt',
        'bdv.vhcl_regis_no', 'bdv.vihcle_dt', 'bdv.tot_inv_amt','bdv.tot_admi_inc_amt',
        'bdv.buyer_id', 'bdv.custmr_name', 'bdv.add', 'bdv.mobile',
        'bdv.email', 'bdv.adhar_name','bdv.oem_status', 'bdv.oem_status_at', 'bdv.oem_remarks'];

        $query = DB::table('buyer_details as bdv')
        // ->select($columnsApprPending)
        ->join('production_data as pd', 'pd.id' , 'bdv.production_id')
        ->join('model_master as mm', 'mm.id', 'pd.model_master_id')
        ->join('category_master as cm', 'cm.id', 'mm.vehicle_cat_id')
        ->join('segment_master as sm', 'bdv.segment_id', 'sm.id')
        ->join('users as us', 'us.id', 'bdv.dealer_id')
        ->join('multi_buyer_details as mbd', 'bdv.buyer_id', 'mbd.buyer_id')
        ->where('mbd.status', 'A')
        ->where('bdv.oem_id', $pid)
        ->whereIn('bdv.custmr_typ' ,[2,3]);
        // ->whereNull('mbd.oem_status')
        // ->where('mbd.oem_status', $this->status);
        // ->get();
        // dd($query, $this->status);
        $bulkbankDetail = $query;
        if ($this->status == 'P') {
            // $bulkbankDetail->whereNull('oem_status')->select($this->approvedOrPendingBulkColumns);
            $bulkbankDetail->whereNull('mbd.oem_status')->select($columnsApprPending);
        } elseif ($this->status == 'A') {
            $bulkbankDetail->where('mbd.oem_status', 'A')->select($columnsApprPending);
        } elseif ($this->status == 'R') {
            // $bulkbankDetail->where('oem_status', 'R')->where('oem_id', $pid)->whereIn('custmr_typ' ,[2,3])->select($this->rejectedBulkColumns);
            $bulkbankDetail->where('mbd.oem_status', 'R')->select($columnsRejected);
        }
        $bulkbankDetail = $bulkbankDetail->orderBy('invoice_dt', 'asc')->get();

        // dd($this->type, $this->status, $pid, $this->approvedOrPendingBulkHeaders, $columnsApprPending, $bulkbankDetail);

        return new Collection($bulkbankDetail);
    }
    }

    /**
     * @return array
     */
    public function headings(): array
    {
    if($this->type == '1'){
        if($this->status == 'P' || $this->status == 'A') {
            return $this->approvedOrPendingHeaders;

        }
        elseif($this->status == 'R'){
            return $this->rejectedHeaders;
        }
    }else if ($this->type == '2'){
            if($this->status == 'P' || $this->status == 'A') {
                return $this->approvedOrPendingBulkHeaders;

            }
            elseif($this->status == 'R'){
                return $this->rejectedBulkHeaders;
            }
    }
    }
}
