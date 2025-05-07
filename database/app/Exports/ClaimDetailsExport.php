<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClaimDetailsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $claimData;
    protected $flag;

    public function __construct(Collection $claimData, $flag)
    {
        $this->claimData = $claimData;
        $this->flag = $flag;
    }

    public function collection()
    {
        return $this->claimData;
    }

    public function headings(): array
    {
        $headings = [];

        if ($this->flag == 'CS') {
            $headings = [
                'Claim Format Number',
                'Claim ID',
                'Lot ID',
            ];
        } elseif ($this->flag == 'CG') {
            $headings = [
                'Claim Format Number',
                'Claim ID',
            ];
        }

        $headings = array_merge($headings, [
            'OEM Name',
            'Model Name',
            'Variant Name',
            'Segment Name',
            'Vehicle Category',
            'VIN/Chassis No.',
            'Customer Name',
            'Customer Status',
            'Vehicle Reg. No.',
            'Vehicle Reg. Date',
            'Invoice No.',
            'Invoice Date',
            'Invoice Amount',
            'Total Incentives',
        ]);
        if ($this->flag == 'CS') {
            $headings[] = 'Lot Created Date';
        }

        return $headings;
    }

    public function map($claim): array
    {
        $mappedData = [];

        if ($this->flag == 'CS') {
            $mappedData = [
                $claim->claimnumberformat,
                $claim->claim_id,
                $claim->lot_id,
            ];
        } elseif ($this->flag == 'CG') {
            $mappedData = [
                $claim->claimnumberformat,
                $claim->claim_id,
            ];
        }

        $mappedData = array_merge($mappedData, [
            $claim->oem_name,
            $claim->model_name,
            $claim->variant_name,
            $claim->segment_name,
            $claim->vehicle_cat,
            $claim->vin_chassis_no,
            $claim->custmr_name,
            $claim->state,
            $claim->vhcl_regis_no,
            date('d-m-Y', strtotime($claim->vihcle_dt)),
            $claim->dlr_invoice_no,
            date('d-m-Y', strtotime($claim->invoice_dt)),
            $claim->invoice_amt,
            $claim->addmi_inc_amt,
        ]);
        
        if ($this->flag == 'CS') {
            $mappedData[] = date('d-m-Y', strtotime($claim->lot_date));
        }
        return $mappedData;
    }
}
