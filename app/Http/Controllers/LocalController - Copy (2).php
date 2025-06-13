<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class LocalController extends Controller
{
    const SALT_LENGTH = 16;
    const IV_LENGTH = 12;
    const ITERATIONS = 65536;
    const KEY_LENGTH = 32; // 256-bit
    const ALGO = 'aes-256-gcm';

    /**
     * Encrypt and optionally decrypt payload (Java-style AES-GCM with PBKDF2)
     */
    public function encryptPayload()
    {
        $data = [
            'userPass' => 'Madhyam@123',
            'codNo' => 'COD20250200BR53B2325',
        ];
        $jsonPayload = json_encode($data);
        $password = '4wFbeiZfbyeagjg10DPqI4QLyWbP5o92oK292HBNGH4=';

        $encrypted = $this->encryptGCM($jsonPayload, $password);
        // dd($encrypted);
        $requestData = [
            'clientId' => 'madhyamtest',
            'encData' => $encrypted,
        ];
        // dd($requestData);

        //  $response = Http::post('https://pmedriveuat.heavyindustries.gov.in/api/vahan-cod-uat', $requestData);


        //  dd($response);
        // $responseBody = $response->json();
           $encrypted="xuRsB/vwJceGE+WgqYm6NrgmWoNR74+BGAv5OyK0EzLqOxJlSSJ7T120kNbA27XMTbGV1fUibBebnlBtPqZvFg2xZb8vxZ2rzu40C7Z3Q6TwqXQmRQXk2Wfggxd28Jf1";
        $decrypted = $this->decryptGCM($encrypted, $password);
        dd($decrypted );
           if (isset($responseBody['encData'])) {
            $decrypted = $this->decryptGCM($encrypted, $password);
        } else {
            $decrypted = 'Invalid or empty response';
        }

        return response()->json([
            'encrypted_request'  => $encData,
            'raw_response'       => $responseBody,
            'decrypted_response' => json_decode($decrypted, true)
        ]);
        // $decrypted = $this->decryptGCM($encrypted, $password);


        // return response()->json([
        //     'encrypted_request' => $response,
        //     'decrypted_check' => json_decode($decrypted, true),
        // ]);
    }

    private function encryptGCM(string $plaintext, string $password): string
    {
        $salt = random_bytes(self::SALT_LENGTH);
        $iv = random_bytes(self::IV_LENGTH);

        $key = $this->pbkdf2Key($password, $salt);

        $tag = '';
        $ciphertext = openssl_encrypt(
            $plaintext,
            self::ALGO,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            '',
            16
        );

        // Pack iv + salt + ciphertext + tag into one buffer
        $encrypted = $iv . $salt . $ciphertext . $tag;

        return base64_encode($encrypted);
    }

    private function decryptGCM(string $base64Ciphertext, string $password): string
    {
        $data = base64_decode($base64Ciphertext);

        $iv = substr($data, 0, self::IV_LENGTH);
        $salt = substr($data, self::IV_LENGTH, self::SALT_LENGTH);
        $ciphertext = substr($data, self::IV_LENGTH + self::SALT_LENGTH, -16);
        $tag = substr($data, -16);

        $key = $this->pbkdf2Key($password, $salt);

        return openssl_decrypt(
            $ciphertext,
            self::ALGO,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );
    }

    private function pbkdf2Key(string $password, string $salt): string
    {
        return hash_pbkdf2('sha256', $password, $salt, self::ITERATIONS, self::KEY_LENGTH, true);
    }
}
