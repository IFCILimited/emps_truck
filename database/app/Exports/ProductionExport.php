<?php
namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ProductionExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        ini_set('memory_limit', '10048M');

ini_set('max_execution_time', 360000);  
        $pid = getParentId();
        $id = decrypt($this->data);

        $productionData = DB::table('production_data')
            ->join('model_master', 'production_data.model_master_id', '=', 'model_master.id')
            ->where('production_data.oem_id', $pid)
            ->where('production_data.model_master_id', $id['model_id'])
            ->where('production_data.model_details_id', $id['model_det_id'])
            ->select(
                DB::raw('ROW_NUMBER() OVER(ORDER BY production_data.id) as SNo'),
                'model_master.model_name as ModelName',
                'model_master.model_code as ModelCode',
                'production_data.manufacturing_date as ManufacturingDate',
                'production_data.vin_chassis_no as VINChassisNo',
                'production_data.colour',
                'production_data.emission_norms as EmissionNorms',
                'production_data.motor_number as MotorNumber',
                'production_data.battery_number as BatteryNumber',
                'production_data.battery_number2 as BatteryNumber2',
                'production_data.battery_number3 as BatteryNumber3',
                'production_data.battery_number4 as BatteryNumber4',
                'production_data.battery_number5 as BatteryNumber5',
                'production_data.battery_number6 as BatteryNumber6',
                'production_data.battery_number7 as BatteryNumber7',
                'production_data.battery_number8 as BatteryNumber8',
                'production_data.battery_number9 as BatteryNumber9',
                'production_data.battery_number10 as BatteryNumber10',
                'production_data.battery_make as BatteryMake',
                'production_data.battery_capacity as BatteryCapacity',
                'production_data.battery_chemistry as BatteryChemistry',
                'production_data.dva_indicative as DVAIndicative',
                'production_data.pmp_compliance as PMPCompliance'
            )
            ->get();

        return new Collection($productionData);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'S.No.',
            'Model name',
            'Model Code',
            'Manufacturing Date',
            'VIN Chassis No',
            'Colour',
            'Emission Norms',
            'Motor Number',
            'Battery Number',
            'Battery Number2',
            'Battery Number3',
            'Battery Number4',
            'Battery Number5',
            'Battery Number6',
            'Battery Number7',
            'Battery Number8',
            'Battery Number9',
            'Battery Number10',
            'Battery Make',
            'Battery Capacity',
            'Battery Chemistry',
            'DVA Indicative',
            'PMP Compliance'
        ];
    }
}
