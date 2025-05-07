<?php

namespace App\Imports;


use App\Models\SalesData;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class SalesDataImport implements ToCollection, WithHeadingRow
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $req = $this->request;

        $pid = getParentId();
        // dd($rows);
        foreach ($rows as $row) {
            if (!empty($row['vin_chasis_no']) || $row['vin_chasis_no']!=Null) {

                if(gettype($row['invoice_date'])=='string'){
                    $date = Carbon::createFromFormat('d-m-Y', $row['invoice_date']);
                }else{
                    $date = Date::excelToDateTimeObject($row['invoice_date']);
                }
                DB::table('salesdata')->insert([
                    'oem_id' => $pid,
                    'seg_id' => $req->sid,
                    'cat_id' => $req->cid,
                    'vin_chasis_no' => $row['vin_chasis_no'],
                    'customer_name' => $row['customer_name'],
                    'invoice_no' => $row['invoice_number'],
                    // 'invoice_dt' => Date::excelToDateTimeObject($row['invoice_date']),
                    'invoice_dt' => $date,
                    'created_by' => $pid,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            'vin_chasis_no' => 'required|string|regex:/^[A-Za-z0-9]{17}$/|unique:salesdata',
            // 'customer_name' => 'required|string',
            // 'invoice_no' => 'required',
            // 'invoice_dt' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [

            'vin_chassis_no.required' => 'The VIN/chassis number is required.',
            'vin_chassis_no.regex' => 'The VIN/chassis number must be exactly 17 characters long and contain only letters and numbers.',
            'vin_chassis_no.unique' => 'The VIN/chassis number must be unique.',
            // 'customer_name.required' => 'The customer name is required.',
            // 'invoice_no.required' => 'The invoice number is required.',
            // 'invoice_dt.required' => 'The invoice date is required.',

        ];
    }
}
