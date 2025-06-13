<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
   
class LocalController extends Controller
{
    private const SALT_LENGTH = 16; // 128-bit
    private const IV_LENGTH = 12;   // 96-bit for GCM
    private const ALGO = 'aes-256-gcm';
    private const KEY_LENGTH = 32;  // 256-bit key
    private const PBKDF2_ITERATIONS = 10000;

    /**
     * Encrypt payload in AES-GCM (Java-compatible format)
     */

    private function removePadding($data)
    {
        $pad = ord($data[strlen($data) - 1]);
        if ($pad < 1 || $pad > 16) {
            return $data; // No padding
        }
        return substr($data, 0, -$pad);
    }
    public function encryptPayload()
    {
        $payload = [
            'userPass' => 'Madhyam@123',
            'codNo'    => 'COD20250200BR53B2325',
        ];

        $jsonPayload = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $password = '4wFbeiZfbyeagjg10DPqI4QLyWbP5o92oK292HBNGH4=';
        // $encrypted = 'oDzQ2FgvY6powpXRVpaZJP1iQz7y4ruH6bUkOMLKDeAgnjlm4rDibTnC+5g2jdvQGaUFNOHhEG2aX5GvwpcbZem4RlGd21PfTieav+p8bMku8nFUCI/NDD1zorGAwG3Ih9KrFnKLB8FwtMVcZETwVemnMsE5FlJOjUbRQuT3nQfQaiwYo0i4wofp4auGANL3Pc5+ImRRwMtkrkWfEJhGiUbB4L8wy60Ga16LgxwS7OF3+rJZdrgT/ejTzrnSgLVzLOgVYFVKLv7+bPHoDqCVk94x5fwfsy//ToU4DJ2jlGALYEt1cJbe1CzGuYZB4twIwq4KEbPjWq+tZXMCcBAL/9uG2Nds3k8+G13KhPSIVWDzS8Us72cwgUc/HOA79TTBn8j9cg+6qmZGyZJrkcOUGUFxUIYqJB4xpZG8sC13vnAozasXAvVc6vywVQHYsxIekSX3fs6fB9SLH/nX92VHNL79C2URjty0dgElbLubT2sZWPI83Dm2lKvddOsaNqLOZGPg/IlW1xS3OLXGiuALtyj2cF/yQxUmb80LeLiJaxXnGGHDmGpuY6g=';

        $encrypted = $this->encryptGCM($jsonPayload, $password);

        $requestData = [
            "clientId" => "madhyamtest",
            "encData" => $encrypted,
        ];
        // dd($requestData);
        // $response1 = Http::post('https://pmedriveuat.heavyindustries.gov.in/api/vahan-cod-uat', $requestData);
        
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        // ])->post('https://pmedriveuat.heavyindustries.gov.in/api/vahan-cod-uat', $requestData);

        $response= callVahanApi($requestData);
        $res = json_decode($response, true);  // Convert JSON to an associative array
        dd($res);
        // Extract the encData from the response (use null coalescing to handle if it's not available)
        $encDatares = $res['json']['encData'] ?? null;
        dd($encDatares);
        
      if ($encDatares) {
    // Call your decryption method
    $decrypted = $this->decryptGCM($encDatares, $password);
dd($response,$encDatares,$decrypted);
    // Debugging output, check the decrypted data
    //dd($decrypted);
} else {
    // Handle case where encData is not available
    dd("encData not found in the response");
}

        // dd($decrypted);

        // return response()->json([
        //     'clientId' => 'madhyamtest',
        //     'decrypted'  => json_decode($decrypted, true),
        // ]);
    }

   public function encryptGCM(string $plaintext, string $password): string
    {
        $salt = random_bytes(self::SALT_LENGTH);
        $iv   = random_bytes(self::IV_LENGTH);

        $key = $this->pbkdf2Key($password, $salt);

        $tag = '';
        $ciphertext = openssl_encrypt(
            $plaintext,
            self::ALGO,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        if ($ciphertext === false) {
            throw new \RuntimeException("Encryption failed");
        }

        $result = $iv . $salt . $ciphertext . $tag;

        return base64_encode($result);
    }

    private function pbkdf2Key(string $password, string $salt): string
    {
        return hash_pbkdf2('sha256', $password, $salt, self::PBKDF2_ITERATIONS, self::KEY_LENGTH, true);
    }

// Function to decrypt the GCM-encrypted data
public function decryptGCM(string $base64Ciphertext, string $password): string
    {
        $data = base64_decode($base64Ciphertext);

        if ($data === false || strlen($data) < (self::IV_LENGTH + self::SALT_LENGTH + 16)) {
            return 'Invalid encrypted data';
        }

        $iv = substr($data, 0, self::IV_LENGTH);
        $salt = substr($data, self::IV_LENGTH, self::SALT_LENGTH);
        $tag = substr($data, -16);
        $ciphertext = substr($data, self::IV_LENGTH + self::SALT_LENGTH, -16);

        $key = $this->pbkdf2Key($password, $salt);

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::ALGO,
            $key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag
        );

        return $plaintext !== false ? $plaintext : 'Decryption failed';
    }
}
