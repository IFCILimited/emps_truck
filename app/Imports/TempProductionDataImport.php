<?php

namespace App\Imports;

use Auth;
use App\Models\TempProductionData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Http\Request;
use Carbon\Carbon;

// class TempProductionDataImport implements ToCollection, WithHeadingRow, WithValidation
class TempProductionDataImport implements ToCollection, WithHeadingRow
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function collection(Collection $rows)
    {

        // dd($this->request);
        $req = $this->request;
$pid = getParentId();
        foreach ($rows as $row) {
           //  dd(Date::excelToDateTimeObject($row['manufacturing_date']));
//dd($row['manufacturing_date'] != null && $row['vin_chassis_no'] !=null);
if ($row['manufacturing_date'] != null && $row['vin_chassis_no'] !=null ){

    if(gettype($row['manufacturing_date'])=='string'){
        // dd(gettype($row['manufacturing_date']),$row['manufacturing_date']);
        $date = Carbon::createFromFormat('Y-m-d', $row['manufacturing_date']);
        // dd($date);
    }else{
        $date = Date::excelToDateTimeObject($row['manufacturing_date']);
    }
            TempProductionData::create([
                'oem_id' => $pid,
                'model_details_id' => $req->model_det_id,
                'model_master_id' =>  $req->model_id,
                // 'manufacturing_date' => Date::excelToDateTimeObject($row['manufacturing_date']),
                'manufacturing_date' => $date,
                'vin_chassis_no' => $row['vin_chassis_no'],
                'colour' => $row['colour'],
                'emission_norms' => $row['emission_norms'],
                'motor_number' => $row['motor_number'],
                'battery_number' => $row['battery_number'],
                'battery_number2' => $row['battery_number2'],
                'battery_number3' => $row['battery_number3'],
                'battery_number4' => $row['battery_number4'],
                'battery_number5' => $row['battery_number5'],
                'battery_number6' => $row['battery_number6'],
                'battery_number7' => $row['battery_number7'],
                'battery_number8' => $row['battery_number8'],
                'battery_number9' => $row['battery_number9'],
                'battery_number10' => $row['battery_number10'],
                'battery_make' => $row['battery_make'],
                'battery_capacity' => $row['battery_capacity'],
                'battery_chemistry' => $row['battery_chemistry'],
                'dva_indicative' => $row['dva_indicative'],
                'pmp_compliance' => $row['pmp_compliance'],
                'uploaded_method' => 'Excel',
		'child_id'=>Auth::user()->id
            ]);
	
        }
}
}

public function rules(): array
{
    return [
        'manufacturing_date' => 'required',
        'vin_chassis_no' => 'required|string|regex:/^[A-Za-z0-9]{17}$/|unique:temp_production_data',
        'colour' => 'required|string',
        'motor_number' => 'required',
        'battery_number' => 'required',
        'battery_make' => 'required',
        'battery_capacity' => 'required',
        'battery_chemistry' => 'required',
        'dva_indicative' => 'required',
        'pmp_compliance' => 'required',
    ];
}

public function customValidationMessages()
    {
        return [
            'manufacturing_date.required' => 'The manufacturing date is required.',
            'vin_chassis_no.required' => 'The VIN/chassis number is required.',
            'vin_chassis_no.regex' => 'The VIN/chassis number must be exactly 17 characters long and contain only letters and numbers.',
            'vin_chassis_no.unique' => 'The VIN/chassis number must be unique.',
            'colour.required' => 'The colour is required.',
            'motor_number.required' => 'The motor number is required.',
            'battery_number.required' => 'The battery number is required.',
            'battery_make.required' => 'The battery make is required.',
            'battery_capacity.required' => 'The battery capacity is required.',
            'battery_chemistry.required' => 'The battery chemistry is required.',
            'dva_indicative.required' => 'The DVA indicative is required.',
            'pmp_compliance.required' => 'The PMP compliance is required.',
        ];
    }

}



