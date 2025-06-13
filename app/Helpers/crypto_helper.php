<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('encryptGCM')) {
    function encryptGCM(string $plaintext, string $password): string
    {
        $saltLength = 16;
        $ivLength = 12;
        $iterations = 65536;
        $keyLength = 32; // 256-bit
        $algo = 'aes-256-gcm';

        $salt = random_bytes($saltLength);
        $iv = random_bytes($ivLength);
        $key = hash_pbkdf2('sha256', $password, $salt, $iterations, $keyLength, true);

        $tag = '';
        $ciphertext = openssl_encrypt(
            $plaintext,
            $algo,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '',
            16
        );

        return base64_encode($iv . $salt . $ciphertext . $tag);
    }
}

if (!function_exists('decryptGCM')) {
    function decryptGCM(string $base64Ciphertext, string $password): string
    {
        $saltLength = 16;
        $ivLength = 12;
        $keyLength = 32;
        $iterations = 65536;
        $algo = 'aes-256-gcm';

        $data = base64_decode($base64Ciphertext);
        $iv = substr($data, 0, $ivLength);
        $salt = substr($data, $ivLength, $saltLength);
        $ciphertext = substr($data, $ivLength + $saltLength, -16);
        $tag = substr($data, -16);
        $key = hash_pbkdf2('sha256', $password, $salt, $iterations, $keyLength, true);

        return openssl_decrypt($ciphertext, $algo, $key, OPENSSL_RAW_DATA, $iv, $tag);
    }
}

if (!function_exists('fetchCodDetails')) {
    function fetchCodDetails(string $clientId, string $userPass, string $codNo, string $password, array $responseMessages = []): array
    {
        $payload = [
            'userPass' => $userPass,
            'codNo' => $codNo,
        ];

        if (empty($clientId)) {
            return [
                'status' => 400,
                'responseCode' => 300,
                'message' =>'Client-Id cannot be empty/blank',
            ];
        }

        $encData = encryptGCM(json_encode($payload), $password);

        $requestData = [
            'clientId' => $clientId,
            'encData' => $encData,
        ];

        $response = Http::post('https://staging.parivahan.gov.in/vahanScrapWS/getCoDDetailsMhi', $requestData);

        if (!$response->ok() || !isset($response['encData'])) {
            return [
                'status' => 500,
                'message' => 'Failed to fetch data from API.',
            ];
        }

        $decrypted = decryptGCM($response['encData'], $password);
        $decoded = json_decode($decrypted, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'status' => 500,
                'message' => 'Failed to parse API response.',
            ];
        }
        return $decoded;
    }
}
