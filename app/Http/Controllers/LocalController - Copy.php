<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Helpers\helperfunction1;

class LocalController extends Controller
{
    public function getEncryptedDataFromUATServer()
    {
        $userPass = "Madhyam@123";
        $codNo = "COD20250200BR53B2325";

        $payload = json_encode([
            'userPass' => $userPass,
            'codNo'    => $codNo
        ]);

        $encryptionPassword = "4wFbeiZfbyeagjg10DPqI4QLyWbP5o92oK292HBNGH4=";

        $encData = encryptGCM($payload, $encryptionPassword);

        // $requestData = [
        //     'clientId' => 'madhyamtest',
        //     'encData'  => $encData
        // ];

        $requestData = [
            "clientId" => "madhyamtest",
            "encData" => "xuRsB/vwJceGE+WgqYm6NrgmWoNR74+BGAv5OyK0EzLqOxJlSSJ7T120kNbA27XMTbGV1fUibBebnlBtPqZvFg2xZb8vxZ2rzu40C7Z3Q6TwqXQmRQXk2Wfggxd28Jf1"
        ];

        $response = Http::post('https://pmedriveuat.heavyindustries.gov.in/api/vahan-cod-uat', $requestData);
        //  $response = Http::get('http://127.0.0.1:8001/api/vahan-cod-uat/{$requestData}', $requestData);

        //         $response = Http::get('http://127.0.0.1:8001/api/vahan-cod-uat', [
        //     'clientId' => 'madhyamtest',
        //     'encData' => 'xuRsB/vwJceGE+WgqYm6NrgmWoNR74+BGAv5OyK0EzLqOxJlSSJ7T120kNbA27XMTbGV1fUibBebnlBtPqZvFg2xZb8vxZ2rzu40C7Z3Q6TwqXQmRQXk2Wfggxd28Jf1',
        // ]);

        // $clientId = 'madhyamtest';
        //     $encData = 'xuRsB/vwJceGE+WgqYm6NrgmWoNR74+BGAv5OyK0EzLqOxJlSSJ7T120kNbA27XMTbGV1fUibBebnlBtPqZvFg2xZb8vxZ2rzu40C7Z3Q6TwqXQmRQXk2Wfggxd28Jf1';

        //     // Make GET request to the route with both path parameters
        //     $response = Http::get("http://127.0.0.1:8001/api/vahan-cod-uat/{$clientId}/" . urlencode($encData));

        dd($response);
        $responseBody = $response->json();

        if (isset($responseBody['encData'])) {
            $decrypted = decryptGCM($responseBody['encData'], $encryptionPassword);
        } else {
            $decrypted = 'Invalid or empty response';
        }

        return response()->json([
            'encrypted_request'  => $encData,
            'raw_response'       => $responseBody,
            'decrypted_response' => json_decode($decrypted, true)
        ]);
    }

    public function checkcd()
    {

$secretKey = '4wFbeiZfbyeagjg10DPqI4QLyWbP5o92oK292HBNGH4=';
$data = [
    'codNo' => 'COD20250200BR53B2325',
    'userPass' => 'Madhyam@123'
];
$jsonData = json_encode($data);
$encrypted='t0Q1dbo5XHhHR30CAiCmOOd1QM4N/nU5qaDH/U+7BnTyt4TFy49iFMfwbxjdpibmyS4Px06XgES15jPInw3P3AF1svt0A+J307QaAYZfuyZhRFKA8BT00+4lylj9DFCrjlL5sj7pILFdcoW2L8NG/aSwdkaKvajwDQXX1IRwQLHYdqVm6ZRHac7JFNvUGoO4G86AmI4Rst3mORCXa60F8v/Jmq2poOWFQ9rfTRohsRg8hPDUgdywEMIn';
// $encrypted = encryptMhaCodPayload($jsonData, $secretKey);

$decrypted = decryptMhaCodPayload($encrypted, $secretKey);
dd($encrypted,$decrypted);


        $cdNumber = 'COD20250200BR53B2325';
        $userPass = 'Madhyam@123';
        $clientId = 'madhyamtest';
        $encryptionKey = '4wFbeiZfbyeagjg10DPqI4QLyWbP5o92oK292HBNGH4='; // use a secure key

        $jsonData = json_encode([
            'userPass' => $userPass,
            'cdNumber' => $cdNumber,
        ]);


        $encData = encryptData($jsonData, $encryptionKey);

        $data = 'EcQaQHGDKrlW6eskSKAXSc9epzUnL7EOMWsqQf4eTSJfO0y5IT9oWolwgO6SYzTJwgRfwWek7P5Tn7CRKE/U1CCGWtRsqygNB0fQ9AyBszN5xP3VBTtSM36CUfPFnenRyxsAMWLpv8YjM84s4SmetXbhdO9ZSCIt9nFYsPe+JlQVQxvzZoj3dxEO3HKE0ZxhgSSVWQFfrGkcZhWWkhtqZk9rtQCBg/7HWQByMjqBWQfe5NIFLNluetiP' ;
        $dec = decryptData($data, $encryptionKey);
// dd($dec);


        $payload = [
            'clientId' => $clientId,
            // 'encData' => 'xuRsB/vwJceGE+WgqYm6NrgmWoNR74+BGAv5OyK0EzLqOxJlSSJ7T120kNbA27XMTbGV1fUibBebnlBtPqZvFg2xZb8vxZ2rzu40C7Z3Q6TwqXQmRQXk2Wfggxd28Jf1',
            'encData' => $encData,
        ];

        // dd($payload);
        $res = callVahanApi($payload);


        dd($res);
    }

    private const ALGO = 'AES-256-CBC';
    private const IV_KEY = '213A26DBB4A358C5'; // Ensure this is 16 bytes for AES-256
    public function encryptData1($plainText, $key)
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
