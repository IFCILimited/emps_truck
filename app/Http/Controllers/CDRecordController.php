<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CDRecord;
use Illuminate\Support\Facades\Http;

class CDRecordController extends Controller
{
    public function fetchCDInfo($cd_number)
    {
        $cd = CDRecord::where('cd_number', $cd_number)->first();

        if (!$cd) {
            return response()->json([
                'cd_number' => $cd_number,
                'response_code' => 404,
                'response_message' => 'CD record not found'
            ], 404);
        }

        // If status is digielv, fetch from DigiELV API
        if ($cd->status_flag === 'digielv') {
            $digielvResponse = Http::get('https://digielv.example.com/api/data', [
                'cd_number' => $cd_number
            ]);

            if ($digielvResponse->ok()) {
                $digielvData = $digielvResponse->json();

                // Optionally, update local DB
                // $cd->update([...]);

                return response()->json(array_merge($digielvData, [
                    'response_code' => 200,
                    'response_message' => 'Success (from DigiELV)'
                ]));
            } else {
                return response()->json([
                    'cd_number' => $cd_number,
                    'response_code' => 502,
                    'response_message' => 'Failed to fetch from DigiELV'
                ], 502);
            }
        }

        // If status is vscrap, return from local DB
        return response()->json([
            'cd_number' => $cd->cd_number,
            'present_owner_name' => $cd->present_owner_name,
            'vehicle_gvw' => $cd->vehicle_gvw,
            'scrapped_vin' => $cd->scrapped_vin,
            'status_flag' => $cd->status_flag,
            'issue_date' => $cd->issue_date,
            'valid_upto_date' => $cd->valid_upto_date,
            'new_owner_name' => $cd->new_owner_name,
            'new_registration_no' => $cd->new_registration_no,
            'new_registration_date' => $cd->new_registration_date,
            'new_vin' => $cd->new_vin,
            'response_code' => 200,
            'response_message' => 'Success'
        ]);
    }
}
