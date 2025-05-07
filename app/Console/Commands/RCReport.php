<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\VahanController;
use DB;
use Carbon\Carbon;


class RCReport extends Command
{
    protected $signature = 'get:RC-Report';
    protected $description = 'Get RC Report';

    public function handle()
    {
        ini_set('memory_limit', '10048M');
        ini_set('max_execution_time', 360000);
        $buyerDetails = DB::table('buyer_details_view')->where('adh_verify','Y')->get();

        foreach ($buyerDetails as $detail) {
            //dd($detail);
            $Chassis_Number = $detail->vin_chassis_no;

            $url = 'https://delhigw.napix.gov.in/nic/parivahan/oauth2/token';
            $postData = [
                'grant_type' => 'client_credentials',
                'scope' => 'napix',
            ];
            $username = '3196a9095aeb9ac74f18c6747cc4d105';
            $password = '38ab4d425593eac474b67c3b34279fa7';
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type:application/x-www-form-urlencoded',
            ]);
            curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
            $response = curl_exec($ch);
            curl_close($ch);
            $responseData = json_decode($response, true);
            $token = $responseData['access_token'];


            $vinchasis = $Chassis_Number;

            $postData = '{"chasisNo":"' . $vinchasis . '","clientId":"MHI_EMPS"}';
            // dd($postData);

            $ch = curl_init();
            curl_setopt_array(
                $ch,
                array(
                    CURLOPT_URL => 'https://delhigw.napix.gov.in/nic/parivahan/vahanws/service/getChasisDetails',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $postData,
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $token
                    ),
                )
            );
            $response1 = curl_exec($ch);
            curl_close($ch);
            $inputKey = "MhI_EmPs@8300@";
            $result = $response1; // Replace with your encrypted data
            if (strlen($result) < 100) {
                return false;
            }

            $dataArray = fnDecrypt($result, $inputKey);
            $dataArray = [
                'buyer_details_id' => $detail->id,
                'buyer_id' => $detail->buyer_id,
                'vin_chasis_no' => $vinchasis,
                'custmr_typ' => $detail->custmr_typ,
                'custmr_name' => $detail->custmr_name,
                'model_id' => $detail->model_id,
                'model_name' => $detail->model_name,
                'segment_id' => $detail->segment_id,
                'segment_name' => $detail->segment_name,
                'vehicle_cat_id' => $detail->vehicle_cat_id,
                'vehicle_cat' => $detail->vehicle_cat,
                'vhcl_regis_no' => $dataArray['rc_regn_no'] ?? null,
                'vihcle_dt' => $dataArray['rc_regn_dt'] ?? null,
                'vahanavailable' => 'Y',
                'status' => $detail->status,
                'dealer_id' => $detail->dealer_id,
                'oem_id' => $detail->oem_id,
                'operator_id' => $detail->operator_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            $vindata = DB::table('vehicle_rc_report')->where('vin_chassis_no', $vinchasis)->first();
            if ($vindata) {
                // Update existing record
                DB::table('vehicle_rc_report')
                    ->where('id', $vindata->id)
                    ->update([
                        'buyer_details_id' => $detail->id,
                        'buyer_id' => $detail->buyer_id,
                        'vin_chassis_no' => $vinchasis,
                        'custmr_typ' => $detail->custmr_typ,
                        'custmr_name' => $detail->custmr_name,
                        'model_id' => $detail->model_id,
                        'model_name' => $detail->model_name,
                        'segment_id' => $detail->segment_id,
                        'segment_name' => $detail->segment_name,
                        'vehicle_cat_id' => $detail->vehicle_cat_id,
                        'vehicle_cat' => $detail->vehicle_cat,
                        'vhcl_regis_no' => $dataArray['vhcl_regis_no'] ?? $detail->vhcl_regis_no,
                        'vihcle_dt' => $dataArray['vihcle_dt'] ?? $detail->vihcle_dt,
                        'vahanavailable' => !empty($dataArray['vhcl_regis_no']) ? 'Y' : $detail->vahanavailable,
                        'status' => $detail->status,
                        'dealer_id' => $detail->dealer_id,
                        'oem_id' => $detail->oem_id,
                        'operator_id' => $detail->operator_id,
                        'updated_at' => Carbon::now(),
                    ]);
            } else {
                // Insert new record
                DB::table('vehicle_rc_report')->insert([
                    'buyer_details_id' => $detail->id,
                    'buyer_id' => $detail->buyer_id,
                    'vin_chassis_no' => $vinchasis,
                    'custmr_typ' => $detail->custmr_typ,
                    'custmr_name' => $detail->custmr_name,
                    'model_id' => $detail->model_id,
                    'model_name' => $detail->model_name,
                    'segment_id' => $detail->segment_id,
                    'segment_name' => $detail->segment_name,
                    'vehicle_cat_id' => $detail->vehicle_cat_id,
                    'vehicle_cat' => $detail->vehicle_cat,
                    'vhcl_regis_no' => $dataArray['vhcl_regis_no'] ?? null,
                    'vihcle_dt' => $dataArray['vihcle_dt'] ?? null,
                    'vahanavailable' => !empty($dataArray['vhcl_regis_no']) ? 'Y' : 'N',
                    'status' => $detail->status,
                    'dealer_id' => $detail->dealer_id,
                    'oem_id' => $detail->oem_id,
                    'operator_id' => $detail->operator_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

    }
}
