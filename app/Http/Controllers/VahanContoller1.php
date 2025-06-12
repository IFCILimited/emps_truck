<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Helpers\helperFuntion1;
use App\Helpers\CryptoHelper;

class VahanContoller1 extends Controller
{
    public function sendEncryptedRequest()
    {
        $userPass = "Madhyam@123";
        $codNo = "COD20250200BR53B2325";

        $payload = json_encode([
            'userPass' => $userPass,
            'codNo'    => $codNo
        ]);

        $encryptionPassword = "4wFbeiZfbyeagjg10DPqI4QLyWbP5o92oK292HBNGH4="; // Must match server's password

        // Encrypt the payload using AES-GCM
        $encData = encryptGCM($payload, $encryptionPassword);

        $requestData = [
            'clientId' => 'madhyamtest',
            'encData'  => $encData
        ];
    // $requestData = [
    //     "clientId" => "madhyamtest",
    //     "encData" => "xuRsB/vwJceGE+WgqYm6NrgmWoNR74+BGAv5OyK0EzLqOxJlSSJ7T120kNbA27XMTbGV1fUibBebnlBtPqZvFg2xZb8vxZ2rzu40C7Z3Q6TwqXQmRQXk2Wfggxd28Jf1"
    // ];

         $response = Http::post('https://staging.parivahan.gov.in/getCodTradeStatus/getCoDDetailsMhi', $requestData);
        $responseBody = $response->json();
        if (isset($responseBody['encData'])) {
            $decrypted = decryptGCM($responseBody['encData'], $encryptionPassword);
        } else {
            $decrypted = 'Invalid response';
        }

        return response()->json([
            'encrypted_request' => $encData,
            'raw_response'      => $responseBody,
            'decrypted_response'=> json_decode($decrypted, true)
        ]);
    }
}


// class UatProxyController extends Controller
// {
//     public function proxyToWhitelistedApi(Request $request)
//     {
//         $requestData = $request->only(['clientId', 'encData']);

//         $response = Http::post('https://staging.parivahan.gov.in/getCodTradeStatus/getCoDDetailsMhi', $requestData);

//         return response()->json($response->json());
//     }
// }

// Route::post('/proxyCodStatus', [UatProxyController::class, 'proxyToWhitelistedApi']);
