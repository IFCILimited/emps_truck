<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class VahanController2 extends Controller
{
    public function sendEncryptedRequest(Request $request)
{
    $data  = array(
        'clientId' => $request->clientId,
        'encData'=>$request->encData,
    );

    $dataAPI = json_encode($data);

//    $url = 'https://staging.parivahan.gov.in/getCodTradeStatus/getCoDDetailsMhi';


   $url = 'https://staging.parivahan.gov.in/vahanScrapWS/getCodTradeStatus' ;

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Get response as string
    curl_setopt($ch, CURLOPT_POST, true);           // POST request
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataAPI); // Send JSON body
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json'
    ]);

    $responseBody = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        $errorMsg = curl_error($ch);
        curl_close($ch);
        return response()->json([
            'status' => $httpCode,
            'error' => true,
            'message' => 'Curl error: ' . $errorMsg,
            'raw' => null,
            'json' => null,
        ]);
    }

    curl_close($ch);

    return response()->json([
        'status' => $httpCode,
        'successful' => $httpCode >= 200 && $httpCode < 300,
        'json' => json_decode($responseBody, true),
        'raw' => $responseBody,
        'error' => $httpCode >= 400
    ]);
}
}
