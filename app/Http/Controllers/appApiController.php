<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class appApiController extends Controller
{
    private function checkAuthorisation() {
        try {
            $headers = getallheaders();
            if (isset($headers['Authorization'])) {
                if ($headers['Authorization']) {
                    if (preg_match('/^Basic (.+)$/', $headers['Authorization'], $matches)) {
                        
                        $string = $matches[1];
                        $g_key = env('G_KEY');
                        $g_iv = env('G_IV');

                        $received_basic_auth_string = $string;

                        $decoded_data = base64_decode($received_basic_auth_string);
                        list($hex_encrypted_username, $hex_encrypted_password) = explode(':', $decoded_data);
                        $encrypted_username = hex2bin($hex_encrypted_username);
                        $encrypted_password = hex2bin($hex_encrypted_password);

                        $key = $g_key;
                        $iv = $g_iv;

                        $decrypted_username = openssl_decrypt($encrypted_username, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
                        
                        $decrypted_password = openssl_decrypt($encrypted_password, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

                        $timestamp_length = 14;

                        $original_username = substr($decrypted_username, 0, -$timestamp_length);
                        $original_password = substr($decrypted_password, 0, -$timestamp_length);

                        $timestamp = substr($decrypted_username, -$timestamp_length);

                        $timestamp = Carbon::createFromFormat('YmdHis', $timestamp);
                        if (
                            $timestamp->gt(now()->subMinutes(env('AUTH_TIME')))
                            && $original_username == env('G_USERNAME')
                            && $original_password == env('G_PASSWORD')
                            ) {
                                return true;
                            
                        } else {
                            return false;
                            
                        }

                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch(Exception $e) {
            return false;
        }

    }

    private function generateXmlResponse(array $data)
    {
        // Create a new XML element
        $xml = new \SimpleXMLElement('<xml/>');

        // Convert data array to XML
        foreach ($data as $key => $value) {
            $xml->addChild($key, $value);
        }

        // Set the response header to application/xml
        return Response::make($xml->asXML(), 200, ['Content-Type' => 'application/xml']);
    }

    public function userverify(Request $request) {

        if(!$this->checkAuthorisation()) {
            $data = [
                'status'=>'fail',
                'message'=>'Invalid username, password or timeout.'
            ];
            return $this->generateXmlResponse($data);
        }
            $rawXml = file_get_contents('php://input');

            if ($rawXml) {
                $xml = simplexml_load_string($rawXml, "SimpleXMLElement", LIBXML_NOCDATA);
                
                if ($xml === false) {
                    $data = [
                        'status'=>'fail',
                        'message'=>'Not valid data.'
                    ];
                    return $this->generateXmlResponse($data);
                } else {
                    $json = json_encode($xml);
                    $data = json_decode($json, true);
                    
                    $key = env('G_KEY');
                    $iv = env('G_IV');

                    $decrypted_username = $this->aadh_decrypt($data['dealer_username'], $key, $iv);
                    $decrypted_password = $this->aadh_decrypt($data['dealer_password'], $key, $iv);
                    $aadhaar = $this->aadh_decrypt($data['aadhaar'], $key, $iv);
                    $os_id = $data['os_id'];

                    $user = DB::table('users')->where(['username'=>$decrypted_username])->first();

                    if(!$user) {
                        $data = [
                            'status' => 'fail',
                            'message' => 'Invalid User Name.',
                        ];
                        return $this->generateXmlResponse($data);
                    }
                    if (password_verify($decrypted_password, $user->password)) {

                        $token = Str::random(32);
                        Cache::put('session_token_' . $token, $user->id, now()->addMinutes(env('TOKEN_EXPIRES_TIME')));

                        $data = [
                            'status' => 'success',
                            'message' => 'Dealer verification successful',
                            'dealer_id' => $user->dealer_code,
                            'dealer_name' => $user->name,
                            'dealer_location' => '',
                            'session_token' =>$token,
                        ];
                        return $this->generateXmlResponse($data);

                    } else {
                        $data = [
                            'status' => 'fail',
                            'message' => 'Invalid password',
                        ];
                        return $this->generateXmlResponse($data);
                    }
                }
            } else {
                $data = [
                    'status' => 'fail',
                    'message' => 'Dealer verification failed',
                ];
                return $this->generateXmlResponse($data);
            }

    }

    private function aadh_decrypt($ciphertextWithTagHex, $key, $iv) {
        $ciphertextWithTag = hex2bin($ciphertextWithTagHex);
        
        $aad = substr($ciphertextWithTag, -14);
        $temp = substr($ciphertextWithTag, 0, -14);
        
        $ciphertext = substr($temp, 0, -16);
        $tag = substr($temp, -16);

        $decrypted = openssl_decrypt($ciphertext, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag, $aad);
        
        return $decrypted ?: false;
    }

}