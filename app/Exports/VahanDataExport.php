<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VahanDataExport implements FromCollection,WithHeadings
{
    protected $portal;
    protected $segment;
    protected $fromDate;
    protected $toDate;

    public function __construct($portal, $segment, $fromDate, $toDate)
    {
        $this->portal = $portal;
        $this->segment = $segment;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //pmedrive vahan data
        if($this->portal == 1)
        {
            $collectionData = DB::table('vahan_api_model_data as vamd')
            ->select(
                'oem_id',
                'vahan_oem_name',
                'portal_segemt_id',
                'portal_segment_name',
                'portal_category_id',
                'portal_category_name',
                DB::raw("TO_CHAR(DATE_TRUNC('month', vahan_date_of_registration::DATE), 'FMMonth') as month_name"),
                // DB::raw("DATE_TRUNC('month', vahan_date_of_registration::DATE) AS month"),
                DB::raw("SUM(vahan_numberofvehiclesregistered) as total_vehicles_registered")
            )
            // ->whereBetween('vahan_date_of_registration', ['2024-04-01', '2024-12-19'])
            // ->whereBetween('vahan_date_of_registration', [$this->fromDate, $this->toDate]);
            // ->whereBetween(DB::raw('TO_DATE(vahan_date_of_registration, "YYYY-MM-DD")'), [$this->fromDate, $this->toDate]);
            // ->whereRaw('TO_DATE("Date of Registration", \'DD-MM-YYYY\') BETWEEN TO_DATE(\'$this->fromDate\', \'DD-MM-YYYY\') AND TO_DATE(\'$this->toDate\', \'DD-MM-YYYY\')');
            ->whereRaw("TO_DATE(vahan_date_of_registration, 'YYYY-MM-DD') BETWEEN TO_DATE('$this->fromDate', 'YYYY-MM-DD') AND TO_DATE('$this->toDate', 'YYYY-MM-DD')");
            if($this->segment != 'all') {
                $collectionData->where('portal_segemt_id', $this->segment);
            }
            $collectionData->groupBy(
                DB::raw("DATE_TRUNC('month', vahan_date_of_registration::DATE)"),
                'oem_id',
                'vahan_oem_name',
                'portal_segemt_id',
                'portal_category_id',
                'portal_category_name',
                'portal_segment_name'
            )
            ->orderBy('vahan_oem_name');
            return $collectionData->get();
        }else{

            $formatedToDate = date('d-m-Y', strtotime($this->fromDate));
            $formatedFromDate = date('d-m-Y', strtotime($this->toDate));
            $results = DB::table('oem_model_map_view as vamd')
            ->select(
                'oem_id',
                'OEM Name',
                'segment_id',
                'segment_nm',
                'cat_id',
                'cat_nm',
                DB::raw("TO_CHAR(TO_DATE(\"Date of Registration\", 'DD-MM-YYYY'), 'FMMonth') AS month"),
                DB::raw('SUM("Number of vehicles Registered") as total_vehicles_registered')
            )
            // ->whereBetween(DB::raw('TO_DATE("Date of Registration", "DD-MM-YYYY")'), [ date('d-m-Y', strtotime($this->fromDate)),
            //     date('d-m-Y', strtotime($this->toDate))
            // ]);
            ->whereRaw("TO_DATE(\"Date of Registration\", 'DD-MM-YYYY') BETWEEN TO_DATE('".$formatedToDate."', 'DD-MM-YYYY') AND TO_DATE('".$formatedFromDate."', 'DD-MM-YYYY')");
            
            if($this->segment != 'all') {
                $results->where('segment_id', $this->segment);
            }
            $results->groupBy(
                DB::raw("TO_CHAR(TO_DATE(\"Date of Registration\", 'DD-MM-YYYY'), 'FMMonth')"),
                'oem_id',
                'OEM Name',
                'segment_id',
                'segment_nm',
                'cat_id',
                'cat_nm'
            )->orderBy('OEM Name');
            // dd($results->toSql());

            return $results->get();
        }
    }

    public function headings(): array
    {
        return [
            'oem_id',
            'oem_name',
            'segment_id',
            'segment_name',
            'category_id',
            'category_name',
            'month',
            // 'vehicle_registration_date',
            'total_vehicles_registered'
        ];
    }
}
