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

class VahanController extends Controller
{
    public function getModelCount()
    {
        // dd('ddd');
        // Fetch OEM details from the database
        // $oemDetails = DB::table('vahan_oem_model_detail')->whereIn('id', [3693, 145])->get();
        $oemDetails = DB::table('oem_model_master_vahan_use')->select('MORTH_OEM as morth_oem')
        ->distinct()->get();

        // return response()->json($oemDetails);
        
        $results = [];

        $fuelTypes = ["ELECTRIC(BOV)", "PURE EV"];

        $secretKey = '325jfasjFGJKHHjkjf64n8hb7JHGG6w1'; // Ensure this is 16 bytes

        foreach ($oemDetails as $oemDetail) {
            // return response()->json($oemDetail->morth_oem);
            // Prepare data for encryption
            // $data = json_encode([
            //     'oemName' => $oemDetail->oem_name,
            //     'fuelType' => $oemDetail->fuel,
            //     'fromDate' => '2024-07-05',
            //     'toDate' => '2024-07-11',
            //     'userPass' => 'vik@12345',
            // ]);
            foreach($fuelTypes as $fuel) {
                // JSON encoding with desired structure
                $data = json_encode([
                    'oemName' => $oemDetail->morth_oem,
                    'fueltype' => $fuel,
                    'fromDate' => '2024-07-05',
                    'toDate' => '2024-07-11',
                    // 'fromDate' => '2024-08-01',
                    // 'toDate' => '2024-08-31',
                    'userPass' => 'vik@12345',
                    // 'userPass' => 'Vahan@123',
                    // 'userPass' => 'mhiuser01admin',
                ]);

                


                //             $data =
                // '{"oemName":"OLA ELECTRIC TECHNOLOGIES PVT LTD","fueltype":"ELECTRIC(BOV)","fromDate":"2024-07-09","toDate":"2024-07-09","userPass":"vik@12345"}'
                // ;

                // Remove any surrounding double quotes, if necessary
                $formattedData = trim($data, '"');

                // $trimmedData = trim($data, '"');
                // dd($data);

                $encryptedData = $this->encryptData($formattedData, $secretKey);
                
                // $encryptedData = $this->encrypt($data);

                // dd($encryptedData);


                // $decrptData=$this->decryptData($encryptedData,$secretKey);

                // $decrptData=$this->decrypt($encryptedData);
                // dd($decrptData);


                // // The JSON response string
                // $jsonResponse = '{"id":"model List","ver":"1.0","ts":"2024-11-01T19:09:54.376684729","params":{"status":"Success","message":null},"responseCode":"OK","result":{"Model_Wise_count":"{\"encData\":\"ui+D5/SQq5pipiOH160nGRwzu9Ad5ZOQamkq+FzB1DCT75lI/hKVWkacxEIAUZHdDTYJhYBxFojFZhfaXL5vnX3lb1dWK2FZngZwn5I7/ajz3M0f4Ftp0YhI298Q8fajKu2wW7NHDSS6qmmB9FpCox51pJChvPtdiJlDlMtUjKGp5RUqSkAnfPI23FvMgqr8gCD5uk8a5PSPBZsZS8yh3qx3LbUZbGDKm1NGC93+q/fgq3tcbPKXdnVgqU7qJzbZwz7umthTWjaIHOZXB6eLTVkNQAEQnYHn/k3SeTWvHgycNGH5AKWmfgxi8RHvk/Tt25g+CSiAka3yrebFAFLaSth4B7vh1LqCwLuOHnDoFDoDroFElXCmmZrjVEvi3aPhrg+tEwve9guAaP4w1wDfx6AQdmQg/7SAIrpallxVYuU7n0kLrk77xH2BmMuBi2UtuvLoRwSFb7O4Zhh1Jqs0xOBELw9QenuRFQPVDRi5u19OFSF8QxEoNytdI6vHnP0X+KbNs3Hvabz6e0LD6JQalPVD1ZJ4aANCB36c0gtm4CIZTnqw7b4kBjEAwa7L/s6mmRQk0VdNc8v3sD/xGC0LLw1Gurd/J2ZniG0xY/Fr78noHlxgxDSCURXaWhZ0nuwPlsAD7E738GZUUPyUzpifVmsIWq1wNkD5kOYPBhAbwvhhbRzPz3khiu/W5+v8ZQ5eTpwa1rv4E3mhwLmSwtfikF1zpbwIKI5a01gNN2YBlZIriQ8LXduTkvXmZvc4jxl0Ws4ahDywl17UbMwjPRNimHmbhhMlzVqjbRrfmQfjUPbF6WF8OeyUe6CGLw9XLVB+y0mO2eBD35JBUp5Dd46kdH0AandYUk22BOLlhSESZW/fbZ+MMh6FyJ+ABdKQeYOmXMLqHgeTsFzKAmo83nQrufdKt1jXd+UZMlDhdPv7x8E=\"}"}}';

                // // Decode JSON to get `encData`
                // $responseArray = json_decode($jsonResponse, true);

                // // Extract the encrypted data (encData) from the nested structure
                // $encData = json_decode($responseArray['result']['Model_Wise_count'], true)['encData'];

                // // Decrypt the data
                // $decryptedData = $this->decrypt($encData);
                // dd($decryptedData);

                try{
                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'https://staging.parivahan.gov.in/vahanModelCountWS/v1.0/getModelCount',
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => '',
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_POSTFIELDS => json_encode([
                            "clientId" => "vikash",
                            // "clientId" => "PM_E-DRIVE",
                            // "clientId" => "mhiuser01admin",
                            "encData" => $encryptedData
                        ]),
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        ),
                    ));

                    $response = curl_exec($curl);

                    curl_close($curl);

                    // return response()->json($response);


                    // // Decode JSON to get `encData`
                    $responseArray = json_decode($response, true);
                    // Extract the encrypted data (encData) from the nested structure
                    // Decode the response and handle the "No Record found" message
                    $encData = json_decode($responseArray['result']['Model_Wise_count'] ?? '', true)['encData'] ?? null;

                    // Decrypt the data if available
                    $decryptedData = $encData ? $this->decrypt($encData) : null;
                    $decryptedDataArray = json_decode($decryptedData, true); // true for associative array
                    // return response()->json($decryptedDataArray);
                    // if(!$decryptedDataArray){

                    //     return response()->json($response);
                    // }

                    if (isset($responseArray['params']['message']) && $responseArray['params']['message'] === "No Record found") {
                        // return response()->json("NO RECORD");

                        $tableDataNoDetails = DB::table("oem_model_master_vahan_use")->where('"MORTH_OEM"', $oemDetail->morth_oem)->first();

                        // Store null data if no record found
                        // VahanOEMModelCount::create([
                        //     'oem_id' => $oemDetail->id,
                        //     'vahan_oem_name' => $oemDetail->vahan_oem_name,
                        //     'vahan_fuel_type' => $oemDetail->vahan_fuel_type,
                        //     'vahan_numberofvehiclesregistered' => 0,
                        //     'model_name' => 'N/A',
                        //     'vahan_date_of_registration' => now(),
                        //     'response_date' => now(),
                        // ]);

                        VahanOEMModelCount::create([
                            'oem_id' => $tableDataNoDetails->oem_id,
                            'vahan_oem_name' => 'N/A',
                            'portal_oem_name' => $tableDataNoDetails->name,
                            'vahan_model_name' => 'N/A',
                            'portal_model_name' => $tableDataNoDetails->MORTH_MODEL,
                            'portal_segemt_id' => $tableDataNoDetails->segment_id,
                            'portal_segment_name' => $tableDataNoDetails->segment_name,
                            'portal_category_id' => $tableDataNoDetails->vehicle_cat_id,
                            'portal_category_name' => $tableDataNoDetails->category_name,
                            'vahan_fuel_type' => $fuel,
                            'vahan_numberofvehiclesregistered' => 0,
                            'model_name' => 'N/A',
                            'model_id' => 'N/A',
                            'vahan_date_of_registration' => now(),
                            'response_date' => now(),
                        ]);
    
                        $results[] = [
                            'oemName' => $oemDetail->vahan_oem_name,
                            'fuelType' => $oemDetail->vahan_fuel_type,
                            'modelName' => 'N/A',
                            'numberofvehiclesregistered' => 0,
                            'dateOfRegistration' => now(),
                            'message' => 'No Record found'
                        ];
                    } else {
                        // return response()->json("RECORD");
                        if($decryptedDataArray){
                            // Loop through decrypted data if records are present
                            foreach ($decryptedDataArray as $data) {
                                // return response()->json($data);
                                // dd($decryptedDataArray,$data);
                                if (isset($data['oemname'], $data['numberOfVehiclesRegistered'], $data['dateOfRegistration'], $data['fuelType'], $data['modelName'])) {
                                    // Store each item in the model_counts table
                                    $tableData = DB::table("oem_model_master_vahan_use")->where('MORTH_MODEL', $data['modelName'])->first();
                                
                                    if($tableData) {
                                        // return response()->json($tableData);
                                        VahanOEMModelCount::create([
                                            'oem_id' => $tableData->oem_id,
                                            'vahan_oem_name' => $data['oemname'],
                                            'portal_oem_name' => $tableData->name,
                                            'vahan_model_name' => $data['modelName'],
                                            'portal_model_name' => $tableData->MORTH_MODEL,
                                            'portal_segemt_id' => $tableData->segment_id,
                                            'portal_segment_name' => $tableData->segment_name,
                                            'portal_category_id' => $tableData->vehicle_cat_id,
                                            'portal_category_name' => $tableData->category_name,
                                            'vahan_fuel_type' => $data['fuelType'],
                                            'vahan_numberofvehiclesregistered' => $data['numberOfVehiclesRegistered'],
                                            'model_name' => $data['modelName'],
                                            'model_id' => (int)$tableData->model_id,
                                            // 'vahan_date_of_registration' => Carbon::createFromTimestampMs($data['dateOfRegistration']),
                                            'vahan_date_of_registration' => $data['dateOfRegistration'],
                                            'response_date' => now(),
                                        ]);
                                        
            
                                        $results[] = [
                                            'vahan_oem_name' => $data['oemname'],
                                            'vahan_fuel_type' => $data['fuelType'],
                                            'vahan_numberofvehiclesregistered' => $data['numberOfVehiclesRegistered'],
                                            'modelName' => $data['modelName'],
                                            'vahan_date_of_registration' => $data['dateOfRegistration'],
                                            'message' => 'Record found'
                                        ];
                                    }
                                } else {
                                    $results[] = [
                                        'vahan_oem_name' => isset($data['oemname']) ? $data['oemname'] : 'N/A',
                                        'vahan_fuel_type' => isset($data['fuelType']) ? $data['fuelType'] : 'N/A',
                                        'modelName' => 'N/A',
                                        'vahan_numberofvehiclesregistered' => 0,
                                        'vahan_date_of_registration' => now(),
                                        'message' => 'Invalid response format'
                                    ];
                                }
                            }
                        }
                    }

                    // return response()->json("inserted");
                } catch (\Exception $e) {
                    return response()->json($e->getMessage());
                    // $results[] = [
                    //     'oemName' => $oemDetail->oem_name,
                    //     'fuelType' => $oemDetail->fuel,
                    //     'numberofvehiclesregistered' => 0,
                    //     'error' => $e->getMessage()
                    // ];
                }
            }


            


            
            



            

            // try {
                
            //     $curl = curl_init();

            //     curl_setopt_array($curl, array(
            //         CURLOPT_URL => 'https://staging.parivahan.gov.in/vahanModelCountWS/v1.0/getModelCount',
            //         CURLOPT_RETURNTRANSFER => true,
            //         CURLOPT_ENCODING => '',
            //         CURLOPT_MAXREDIRS => 10,
            //         CURLOPT_TIMEOUT => 0,
            //         CURLOPT_FOLLOWLOCATION => true,
            //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //         CURLOPT_CUSTOMREQUEST => 'POST',
            //         CURLOPT_POSTFIELDS => json_encode([
            //             "clientId" => "vikash",
            //             // "clientId" => "PM_E-DRIVE",
            //             // "clientId" => "mhiuser01admin",
            //             "encData" => $encryptedData
            //         ]),
            //         CURLOPT_HTTPHEADER => array(
            //             'Content-Type: application/json'
            //         ),
            //     ));

            //     $response = curl_exec($curl);

            //     curl_close($curl);



            //     // // Decode JSON to get `encData`
            //     $responseArray = json_decode($response, true);
            //     // Extract the encrypted data (encData) from the nested structure
            //     // Decode the response and handle the "No Record found" message
            //     $encData = json_decode($responseArray['result']['Model_Wise_count'] ?? '', true)['encData'] ?? null;

            //     // Decrypt the data if available
            //     $decryptedData = $encData ? $this->decrypt($encData) : null;
            //     $decryptedDataArray = json_decode($decryptedData, true); // true for associative array
            //     if(!$decryptedDataArray){

            //         return response()->json($response);
            //     }

                // Check if the response indicates "No Record found"
                // if (isset($responseArray['params']['message']) && $responseArray['params']['message'] === "No Record found") {
                //     // return response()->json("NO RECORD");
                //     // Store null data if no record found
                //     VahanOEMModelCount::create([
                //         'oem_id' => $oemDetail->id,
                //         'vahan_oem_name' => $oemDetail->vahan_oem_name,
                //         'vahan_fuel_type' => $oemDetail->vahan_fuel_type,
                //         'vahan_numberofvehiclesregistered' => 0,
                //         'model_name' => 'N/A',
                //         'vahan_date_of_registration' => now(),
                //         'response_date' => now(),
                //     ]);

                //     $results[] = [
                //         'oemName' => $oemDetail->vahan_oem_name,
                //         'fuelType' => $oemDetail->vahan_fuel_type,
                //         'modelName' => 'N/A',
                //         'numberofvehiclesregistered' => 0,
                //         'dateOfRegistration' => now(),
                //         'message' => 'No Record found'
                //     ];
                // } else {
                //     // return response()->json("RECORD");
                    
                //     // Loop through decrypted data if records are present
                //     foreach ($decryptedDataArray as $data) {
                //         // return response()->json($data);
                //         // dd($decryptedDataArray,$data);
                //         if (isset($data['oemname'], $data['numberOfVehiclesRegistered'], $data['dateOfRegistration'], $data['fuelType'], $data['modelName'])) {
                //             // Store each item in the model_counts table
                //             // DB::table("")

                //             $id = VahanOEMModelCount::create([
                //                 'oem_id' => $oemDetail->id,
                //                 'vahan_oem_name' => $data['oemname'],
                //                 'portal_oem_name' => $oemDetail->vahan_oem_name,
                //                 'vahan_model_name' => $data['modelName'],
                //                 'portal_model_name' => $oemDetail->portal_model_name,
                //                 'portal_segemt_id' => $oemDetail->portal_segemt_id,
                //                 'portal_segment_name' => $oemDetail->portal_segment_name,
                //                 'portal_category_id' => $oemDetail->portal_category_id,
                //                 'portal_category_name' => $oemDetail->portal_category_name,
                //                 'vahan_fuel_type' => $data['fuelType'],
                //                 'vahan_numberofvehiclesregistered' => $data['numberOfVehiclesRegistered'],
                //                 'model_name' => $data['modelName'],
                //                 'vahan_date_of_registration' => Carbon::createFromTimestampMs($data['dateOfRegistration']),
                //                 'response_date' => now(),
                //             ]);
                            

                //             $results[] = [
                //                 'vahan_oem_name' => $data['oemname'],
                //                 'vahan_fuel_type' => $data['fuelType'],
                //                 'vahan_numberofvehiclesregistered' => $data['numberOfVehiclesRegistered'],
                //                 'modelName' => $data['modelName'],
                //                 'vahan_date_of_registration' => $data['dateOfRegistration'],
                //                 'message' => 'Record found'
                //             ];
                //         } else {
                //             $results[] = [
                //                 'vahan_oem_name' => isset($data['oemname']) ? $data['oemname'] : 'N/A',
                //                 'vahan_fuel_type' => isset($data['fuelType']) ? $data['fuelType'] : 'N/A',
                //                 'modelName' => 'N/A',
                //                 'vahan_numberofvehiclesregistered' => 0,
                //                 'vahan_date_of_registration' => now(),
                //                 'message' => 'Invalid response format'
                //             ];
                //         }
                //     }
                // }

                
            //     // dd($results);
            //     // $to = 'ajaharuddin.ansari@ifciltd.com';
            //     // $cc= '';
            //     // $bcc='';
            //     // $subject='Model Count form Vahan Scheduler';
            //     // $from = 'noreply.pmedrive@heavyindustry.gov.in';
            //     // $msg=view('emails.model_count_report', ['results' => $results])->render();
        
            //     // $response = sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);
                

            // } catch (\Exception $e) {
            //     return response()->json($e->getMessage());
            //     // $results[] = [
            //     //     'oemName' => $oemDetail->oem_name,
            //     //     'fuelType' => $oemDetail->fuel,
            //     //     'numberofvehiclesregistered' => 0,
            //     //     'error' => $e->getMessage()
            //     // ];
            // }
        }
       

        return response()->json($results);
        // Send an email with the results
        // Mail::to('recipient@example.com')->send(new ModelCountReport($results));
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

    // public function decryptData($cipherText, $key)
    // {
    //     // Ensure IV is 16 bytes (128 bits)
    //     $iv = substr(self::IV_KEY, 0, 16);

    //     // Decode the Base64 encoded cipher text
    //     $encryptedData = base64_decode($cipherText);

    //     // Decrypt the data
    //     $decryptedData = openssl_decrypt($encryptedData, self::ALGO, $key, OPENSSL_RAW_DATA, $iv);

    //     // Remove PKCS#5 padding
    //     return $this->removePadding($decryptedData);
    // }

    // private function removePadding($data)
    // {
    //     $pad = ord($data[strlen($data) - 1]);
    //     if ($pad < 1 || $pad > 16) {
    //         return $data; // No padding
    //     }
    //     return substr($data, 0, -$pad);
    // }




    public function encrypt($data)
    {
        // Prepare data as JSON string
        //$jsonData = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        echo $data . "</br>";
        // Encrypt with AES-256-CBC
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', '325jfasjFGJKHHjkjf64n8hb7JHGG6w1', OPENSSL_RAW_DATA, '213A26DBB4A358C5');

        return base64_encode($encrypted);
    }
    public function decrypt($encryptedData)
    {
        // Decode the Base64 encoded data
        $data = base64_decode($encryptedData);

        // Decrypt the data using AES-256-CBC with PKCS5 padding
        return openssl_decrypt($data, 'AES-256-CBC', '325jfasjFGJKHHjkjf64n8hb7JHGG6w1', OPENSSL_RAW_DATA, '213A26DBB4A358C5');
    }
}
