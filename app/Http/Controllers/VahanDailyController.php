<?php

namespace App\Http\Controllers;

use App\Mail\ModelCountReport;
use App\Models\VahanOEMModelCount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use DB;
use Carbon\Carbon;

class VahanDailyController extends Controller
{
    public function getModelCount()
    {
        // Token generate
        $url = 'https://delhigw.napix.gov.in/nic/parivahan/oauth2/token';
        $postData = [
            'grant_type' => 'client_credentials',
            'scope' => 'napix',
        ];
        $client_id = 'd4561c1a95c23884094ab21239594740';
        $client_secret = 'a4a66266df03568b7336450ae9fbca03';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type:
        application/x-www-form-urlencoded',
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $client_id . ':' . $client_secret);
        $response = curl_exec($ch);
        curl_close($ch);
        $responseData = json_decode($response, true);
        $token = $responseData['access_token'];
        //dd($token);
        // Fetch OEM details from the database
        // $oemDetails = DB::table('oem_model_master_vahan_use')->select('MORTH_OEM')->distinct()->get();
        $oemDetails = [
            "OKAYA EV PVT LTD"
        ];
        $fuelTypes = ["ELECTRIC(BOV)", "PURE EV"];

        $secretKey = '325jfasjFGJKHHjkjf64n8hb7JHGG6w1'; // Ensure this is 16 bytes
        //dd($oemDetails);
        $fromDate = '2024-10-01';
        $toDate = $fromDate;

        $lastDate = '2024-10-01';
        // $lastDate =  Carbon::parse(now())->addDay(-1)->format('Y-m-d');
        // $lastDate =  Carbon::parse($fromDate)->addDay(+1)->format('Y-m-d');

        $results = [];
        while($fromDate <= $lastDate){
            foreach ($oemDetails as $oemDetail) {

                foreach($fuelTypes as $fuel) {
                    // JSON encoding with desired structure
                    $data = json_encode([
                        // 'oemName' => $oemDetail->MORTH_OEM,
                        'oemName' => $oemDetail,
                        'fueltype' => $fuel,
                        // 'fromDate' => '2024-10-01',
                        // 'toDate' => '2024-10-02',
                        'fromDate' => $fromDate,
                        'toDate' => $toDate,
                        'userPass' => 'Mhiuser01Admin@147'
                    ]);
            
                    // Remove any surrounding double quotes, if necessary
                    $formattedData = trim($data, '"');
                    $encryptedData = $this->encryptData($formattedData, $secretKey);
                    // $decryptedData = $this->decryptData($encryptedData, $secretKey);
    
                    try {
    
                        $postData = json_encode([
                            "clientId" => "mhiuser01admin",
                            "encData" => $encryptedData
                        ]);
        
                        $ch1 = curl_init();
                        curl_setopt_array($ch1, array(
                            CURLOPT_URL => 'https://delhigw.napix.gov.in/nic/parivahan/vahanModelCountWS/service/getModelCount',
                            // CURLOPT_URL => 'https://delhigw.napix.gov.in/nic/parivahan/vahanws/service/getDetails',
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
                            CURLINFO_HEADER_OUT => true // Enable header output tracking
                        ));
                        $response1 = curl_exec($ch1);
       
                        // Get the complete request info
                        $info = curl_getinfo($ch1);
                        $requestHeaders = curl_getinfo($ch1, CURLINFO_HEADER_OUT);
        
                        // Build and print/log the equivalent cURL command
                        $curlCommand = "curl -X POST '{$info['url']}' \\\n";
                        foreach (explode("\r\n", trim($requestHeaders)) as $headerLine) {
                            if ($headerLine) {
                                $curlCommand .= " -H \"$headerLine\" \\\n";
                            }
                        }
                        $curlCommand .= " -d '" . json_encode($postData, JSON_UNESCAPED_SLASHES) . "'";
        
                        // Display or log the cURL command for debugging
                        //echo "<pre>Equivalent cURL command:\n" . htmlspecialchars($curlCommand) . "</pre>";
        
                        // Optional: Dump additional response info if needed
                        // dd($curlCommand, $info, $response1);
        
                        curl_close($ch1);
                        // // Decode JSON to get `encData`
                        $responseArray = json_decode($response1, true);
                        // Extract the encrypted data (encData) from the nested structure
                        // Decode the response and handle the "No Record found" message
                        $encData = json_decode($responseArray['result']['Model_Wise_count'] ?? '', true)['encData'] ?? null;
                       
        
                        // // Decrypt the data if available
                         $decryptedData = $encData ? $this->decrypt($encData) : null;
                         $decryptedDataArray = json_decode($decryptedData, true); // true for associative array
                        dd($responseArray, $decryptedDataArray);

                        if (isset($responseArray['params']['message']) && $responseArray['params']['message'] === "No Record found") {
                            DB::table('vahan_api_all_data')->insert([
                                'oem_id' => null,
                                'vahan_oem_name' => null,
                                'sent_oem_name' => $oemDetail,
                                'vahan_model_name' => null,
                                'vahan_fuel_type' => null,
                                'sent_fuel_type' => $fuel,
                                'vahan_numberofvehiclesregistered' => 0,
                                'vahan_date_of_registration' => null,
                                'response_date' => now(),
                                'api_from_date' => $fromDate,
                                'api_to_date' => $toDate,
                                'message' => 'No Record found',
                                'manufacturing_year' => null,
                                'manufacturing_month' => null,
                                'api_response_array' => json_encode($responseArray),
                                'decrypted_data_array' => null
                             ]);
                        }else{
				            if($decryptedDataArray && count($decryptedDataArray) > 0){


                                foreach ($decryptedDataArray as $data) {
                                    if (isset($data['oemname'], $data['numberOfVehiclesRegistered'], $data['dateOfRegistration'], $data['fuelType'], $data['modelName'], $data['manufacturingYear'], $data['manufacturingMonth'])) {
                                        //insert all response
                                        DB::table('vahan_api_all_data')->insert([
                                            'oem_id' => NULL,
                                            'vahan_oem_name' => $data['oemname'],
                                            'sent_oem_name' => $oemDetail,
                                            'vahan_model_name' => $data['modelName'],
                                            'vahan_fuel_type' => $data['fuelType'],
                                            'sent_fuel_type' => $fuel,
                                            'vahan_numberofvehiclesregistered' => $data['numberOfVehiclesRegistered'],
                                            'vahan_date_of_registration' => $data['dateOfRegistration'],
                                            'response_date' => now(),
                                            'api_from_date' => $fromDate,
                                            'api_to_date' => $toDate,
                                            'message' => 'Record found',
                                            'manufacturing_year' => $data['manufacturingYear'],
                                            'manufacturing_month' => $data['manufacturingMonth'],
                                            'api_response_array' => json_encode($responseArray),
                                            'decrypted_data_array' => json_encode($decryptedDataArray)
                                        ]);
                                    }else{
                                        DB::table('vahan_api_all_data')->insert([
                                            'oem_id' => NULL,
                                            'vahan_oem_name' => NULL,
                                            'sent_oem_name' => $oemDetail,
                                            'vahan_model_name' => NULL,
                                            'vahan_fuel_type' => NULL,
                                            'sent_fuel_type' => NULL,
                                            'vahan_numberofvehiclesregistered' => NULL,
                                            'vahan_date_of_registration' => NULL,
                                            'response_date' => now(),
                                            'api_from_date' => $fromDate,
                                            'api_to_date' => $toDate,
                                            'message' => 'Format mismatch',
                                            'manufacturing_year' => NULL,
                                            'manufacturing_month' => NULL,
                                            'api_response_array' => json_encode($responseArray),
                                            'decrypted_data_array' => json_encode($decryptedDataArray)
                                        ]);
                                    }
                                }
			                }
                        }


                        // Check if the response indicates "No Record found"
                        // if (isset($responseArray['params']['message']) && $responseArray['params']['message'] === "No Record found") {
                        //     $tableDataNoDetails = DB::table("oem_model_master_vahan_use")->where('MORTH_OEM', $oemDetail->MORTH_OEM)->first();
    
                        //     DB::table('vahan_api_daily_model_data')->insert([
                        //         'oem_id' => $tableDataNoDetails->oem_id,
                        //         'vahan_oem_name' => 'N/A',
                        //         'portal_oem_name' => $tableDataNoDetails->name,
                        //         'vahan_model_name' => 'N/A',
                        //         'portal_model_name' => $tableDataNoDetails->MORTH_MODEL,
                        //         'portal_segemt_id' => $tableDataNoDetails->segment_id,
                        //         'portal_segment_name' => $tableDataNoDetails->segment_name,
                        //         'portal_category_id' => $tableDataNoDetails->vehicle_cat_id,
                        //         'portal_category_name' => $tableDataNoDetails->category_name,
                        //         'vahan_fuel_type' => $fuel,
                        //         'vahan_numberofvehiclesregistered' => 0,
                        //         'model_id' => 0,
                        //         'vahan_date_of_registration' => now(),
                        //         'response_date' => now(),
                        //         'api_from_date' => $fromDate,
                        //         'api_to_date' => $toDate,
                        //         'message' => 'No Record found',
                        //         'manufacturing_year' => null,
                        //         'manufacturing_month' => null
                        //     ]);
        
                        //     $results[] = [
                        //         'oemName' => $oemDetail->MORTH_OEM,
                        //         'fuelType' => $fuel,
                        //         'modelName' => 'N/A',
                        //         'numberofvehiclesregistered' => 0,
                        //         'dateOfRegistration' => now(),
                        //         'message' => 'No Record found',
                        //         'api_from_date' => $fromDate,
                        //         'api_to_date' => $toDate,
                        //         'manufacturing_year' => null,
                        //         'manufacturing_month' => null
                        //     ];
                        // } else {
        
				        //     if($decryptedDataArray && count($decryptedDataArray) > 0){

                        //         // Loop through decrypted data if records are present
                        //         foreach ($decryptedDataArray as $data) {
                        //             // return response()->json($data);
                        //             if (isset($data['oemname'], $data['numberOfVehiclesRegistered'], $data['dateOfRegistration'], $data['fuelType'], $data['modelName'])) {
                        //                 // Store each item in the model_counts table
                        //                 $tableData = DB::table("oem_model_master_vahan_use")->where('MORTH_RC_MODEL', $data['modelName'])->first();
        
                        //                 if($tableData) {
                        //                     // return response()->json($tableData);
                        //                     DB::table('vahan_api_daily_model_data')->insert([
                        //                         'oem_id' => $tableData->oem_id,
                        //                         'vahan_oem_name' => $data['oemname'],
                        //                         'portal_oem_name' => $tableData->name,
                        //                         'vahan_model_name' => $data['modelName'],
                        //                         'portal_model_name' => $tableData->MORTH_MODEL,
                        //                         'portal_segemt_id' => $tableData->segment_id,
                        //                         'portal_segment_name' => $tableData->segment_name,
                        //                         'portal_category_id' => $tableData->vehicle_cat_id,
                        //                         'portal_category_name' => $tableData->category_name,
                        //                         'vahan_fuel_type' => $data['fuelType'],
                        //                         'vahan_numberofvehiclesregistered' => $data['numberOfVehiclesRegistered'],
                        //                         'model_id' => (int)$tableData->model_id,
                        //                         // 'vahan_date_of_registration' => Carbon::createFromTimestampMs($data['dateOfRegistration']),
                        //                         'vahan_date_of_registration' => $data['dateOfRegistration'],
                        //                         'response_date' => now(),
                        //                         'api_from_date' => $fromDate,
                        //                         'api_to_date' => $toDate,
                        //                         'message' => 'Record found',
                        //                         'manufacturing_year' => $data['manufacturingYear'],
                        //                         'manufacturing_month' => $data['manufacturingMonth']
                        //                     ]);
                                            
                
                        //                     $results[] = [
                        //                         'vahan_oem_name' => $data['oemname'],
                        //                         'vahan_fuel_type' => $data['fuelType'],
                        //                         'vahan_numberofvehiclesregistered' => $data['numberOfVehiclesRegistered'],
                        //                         'modelName' => $data['modelName'],
                        //                         'vahan_date_of_registration' => $data['dateOfRegistration'],
                        //                         'message' => 'Record found',
                        //                         'api_from_date' => $fromDate,
                        //                         'api_to_date' => $toDate,
                        //                         'manufacturing_year' => $data['manufacturingYear'],
                        //                         'manufacturing_month' => $data['manufacturingMonth']
                        //                     ];
                        //                 }else{
                        //                     DB::table('vahan_api_daily_model_data')->insert([
                        //                         'oem_id' => 0,
                        //                         'vahan_oem_name' => $data['oemname'],
                        //                         'portal_oem_name' =>  $oemDetail->MORTH_OEM,
                        //                         'vahan_model_name' => $data['modelName'],
                        //                         'portal_model_name' => 'NA',
                        //                         'portal_segemt_id' => 0,
                        //                         'portal_segment_name' => 'NA',
                        //                         'portal_category_id' => 0,
                        //                         'portal_category_name' => 'NA',
                        //                         'vahan_fuel_type' => $data['fuelType'],
                        //                         'vahan_numberofvehiclesregistered' => $data['numberOfVehiclesRegistered'],
                        //                         'model_id' => 0,
                        //                         // 'vahan_date_of_registration' => Carbon::createFromTimestampMs($data['dateOfRegistration']),
                        //                         'vahan_date_of_registration' => $data['dateOfRegistration'],
                        //                         'response_date' => now(),
                        //                         'api_from_date' => $fromDate,
                        //                         'api_to_date' => $toDate,
                        //                         'message' => 'Morth Model name not found in master table',
                        //                         'manufacturing_year' => $data['manufacturingYear'],
                        //                         'manufacturing_month' => $data['manufacturingMonth']
                        //                     ]);

                        //                     $results[] = [
                        //                             'vahan_oem_name' => $data['oemname'],
                        //                             'vahan_fuel_type' => $data['fuelType'],
                        //                             'vahan_numberofvehiclesregistered' => $data['numberOfVehiclesRegistered'],
                        //                             'modelName' => $data['modelName'],
                        //                             'vahan_date_of_registration' => $data['dateOfRegistration'],
                        //                             'manufacturing_year' => $data['manufacturingYear'],
                        //                             'manufacturing_month' => $data['manufacturingMonth'],
                        //                             'message' => 'Morth Model name not found in master table',
                        //                             'api_from_date' => $fromDate,
                        //                             'api_to_date' => $toDate
                        //                     ];
        
                        //                 }
        
                        //             } else {

                        //                 DB::table('vahan_api_daily_model_data')->insert([
                        //                     'oem_id' => 0,
                        //                     'vahan_oem_name' => isset($data['oemname']) ? $data['oemname'] : 'N/A',
                        //                     'vahan_fuel_type' => isset($data['fuelType']) ? $data['fuelType'] : 'N/A',
                        //                     'portal_oem_name' =>  $oemDetail->MORTH_OEM,
                        //                     'vahan_model_name' => isset($data['modelName']) ? $data['modelName'] : 'N/A',
                        //                     'portal_model_name' => 'NA',
                        //                     'portal_segemt_id' => 0,
                        //                     'portal_segment_name' => 'NA',
                        //                     'portal_category_id' => 0,
                        //                     'portal_category_name' => ' NA',
                        //                     'vahan_numberofvehiclesregistered' => isset($data['numberOfVehiclesRegistered']) ? $data['numberOfVehiclesRegistered'] : 0,
                        //                     'model_id' => 0,
                        //                     // 'vahan_date_of_registration' => Carbon::createFromTimestampMs($data['dateOfRegistration']),
                        //                     'vahan_date_of_registration' => isset($data['dateOfRegistration']) ? $data['dateOfRegistration'] : 'N/A',
                        //                     'response_date' => now(),
                        //                     'api_from_date' => $fromDate,
                        //                     'api_to_date' => $toDate,
                        //                     'message' => 'Invalid response format',
                        //                     'manufacturing_year' => isset($data['manufacturingYear']) ? $data['manufacturingYear'] : null,
                        //                     'manufacturing_month' => isset($data['manufacturingMonth']) ? $data['manufacturingMonth'] : null
                        //                 ]);


                        //                 $results[] = [
                        //                     'vahan_oem_name' => isset($data['oemname']) ? $data['oemname'] : 'N/A',
                        //                     'vahan_fuel_type' => isset($data['fuelType']) ? $data['fuelType'] : 'N/A',
                        //                     'modelName' => 'N/A',
                        //                     'vahan_numberofvehiclesregistered' => 0,
                        //                     'vahan_date_of_registration' => now(),
                        //                     'message' => 'Invalid response format',
                        //                     'api_from_date' => $fromDate,
                        //                     'api_to_date' => $toDate,
                        //                     'manufacturing_year' => isset($data['manufacturingYear']) ? $data['manufacturingYear'] : null,
                        //                     'manufacturing_month' => isset($data['manufacturingMonth']) ? $data['manufacturingMonth'] : null
                        //                 ];
                        //             }
                        //         }
                        //     }
                        // }
        
                    } catch (\Exception $e) {
                        return response()->json($e->getMessage());
                        \Log::info('Error while fetching VAHAN API data: '.$e->getMessage());
                    }
                }
            }

            $fromDate = Carbon::parse($fromDate)->addDay(+1)->format('Y-m-d');
            $toDate = $fromDate;
        }
       
        return response()->json($results);
    }

    private const ALGO = 'AES-256-CBC';
    private const IV_KEY = '213A26DBB4A358C5'; // Ensure this is 16 bytes for AES-256
    public function encryptData($plainText, $key)
    {
        // Ensure IV is 16 bytes (128 bits)
        $iv = substr(self::IV_KEY, 0, 16);

        // Encrypt the data
        $encryptedData = openssl_encrypt($plainText, self::ALGO, $key, OPENSSL_RAW_DATA, $iv);

        // Encode the encrypted data in Base64
        return base64_encode($encryptedData);
    }

    public function decryptData($cipherText, $key)
    {
        // dd($cipherText,$key);
        // Ensure IV is 16 bytes (128 bits)
        $iv = substr(self::IV_KEY, 0, 16);

        // Decode the Base64 encoded cipher text
        $encryptedData = base64_decode($cipherText);

        // Decrypt the data
        $decryptedData = openssl_decrypt($encryptedData, self::ALGO, $key, OPENSSL_RAW_DATA, $iv);

        // Remove PKCS#5 padding
        return $this->removePadding($decryptedData);
    }

    private function removePadding($data)
    {
        $pad = ord($data[strlen($data) - 1]);
        if ($pad < 1 || $pad > 16) {
            return $data; // No padding
        }
        return substr($data, 0, -$pad);
    }




    // public function encrypt($data)
    // {
    //     // Prepare data as JSON string
    //     //$jsonData = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    //     echo $data . "</br>";
    //     // Encrypt with AES-256-CBC
    //     $encrypted = openssl_encrypt($data, 'AES-256-CBC', '325jfasjFGJKHHjkjf64n8hb7JHGG6w1', OPENSSL_RAW_DATA, '213A26DBB4A358C5');

    //     return base64_encode($encrypted);
    // }
     public function decrypt($encryptedData)
    {
         // Decode the Base64 encoded data
         $data = base64_decode($encryptedData);

         // Decrypt the data using AES-256-CBC with PKCS5 padding
         return openssl_decrypt($data, 'AES-256-CBC', '325jfasjFGJKHHjkjf64n8hb7JHGG6w1', OPENSSL_RAW_DATA, '213A26DBB4A358C5');
    }
}
