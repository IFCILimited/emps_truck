<?php

namespace App\Http\Controllers\Api;

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

class DealerController extends Controller
{
    private function checkAuthorisation() {

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

        {
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
//print_r($aadhaar); die;

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
 			DB::table('dealer_session')->Insert(
                        [
                            'session_id' => $token,
			    'username' =>$user->username,
 			    'dealer_name' => $user->name,
			    'user_id' => $user->id,
			    'aadhaar' => $aadhaar
                        ]
                    );

                        $data = [
                            'status' => 'success',
                            'message' => 'Dealer verification successful',
                            'dealer_id' => $user->dealer_code,
                            'dealer_name' => $user->name,
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


    public function operator_auth(Request $request) {

        if(!$this->checkAuthorisation()) {
            $data = [
                'status'=>'fail',
                'message'=>'Invalid username, password or timeout.'
            ];
            return $this->generateXmlResponse($data);
        }
        
//dd('hhhhh');


            $rawXml = file_get_contents('php://input');

            if ($rawXml) {
                $xml = simplexml_load_string($rawXml, "SimpleXMLElement", LIBXML_NOCDATA);
                
                if ($xml === false) {
                    $data = [
                        'status'=>'fail',
                        'message'=>'Not valid data.'
                    ];
                    return $this->generateXmlResponse($data);
                }
                $json = json_encode($xml);
                $data = json_decode($json, true);
                
               // print_r($data);//die;
 DB::table('api_log')->Insert(
                        [
                            'message' => $this->generateXmlResponse($data),
                        ]
                    );
                $sessionToken = $data['session_token'];
              // session code to be added
		
		
//
       $userid = DB::table('dealer_session')->where('session_id',$sessionToken)->first();
//print_r( $userid ); die;
	//$userid = 1;
	 if(!$userid ) {
                    $data = [
                        'status' => 'fail',
                        'message' => 'Invalid Session',
			'auth_status' =>'fail',
			'auth_error_code' =>0,

                    ];
                    return $this->generateXmlResponse($data);
                }

                $user = DB::table('users')->where('id', $userid->user_id)->first();

                if(!$user) {
                    $data = [
                        'status' => 'fail',
                        'message' => 'Invalid Device',
			'auth_status' =>'fail',
			'auth_error_code' =>0,
                    ];
                    return $this->generateXmlResponse($data);
                }


                // call here aadhar api
                ////////////////////////////////////////
                
                // print_r($data['rc']);die;

                $evalue = $data['environment'];

                // $aua_url = $this->config->item('rest_aua_url');
                
                // if($evalue=='PP')
                // {
                //         $aua_url = $this->config->item('rest_aua_url_pp');
                // }
                
                $aua_url = "http://10.247.252.95:8080/NicASAServer/ASAMain";
              
                $reg_mobile = $user->mobile;
                $reg_aadhaar = $userid->aadhaar; 
                   //  print_r(  $reg_aadhaar); die;          
                     
                $unique_txn = rand(1000000001,9999999999); 
                $txnID = $unique_txn.date('YmdHis').'XXX';  

                $sa = "ZZ1094FAME";
                $lk = "FAME-7397AL1820Q467C";

                //********************** AUTH UIDAI XML Frame **************************
                $authXml ='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
                $authXml .='<Auth xmlns="http://www.uidai.gov.in/authentication/uid-auth-request/2.0" uid="'.$reg_aadhaar.'"';
                $authXml .=' rc="'.$data['rc'].'" tid="'.$data['tid'].'" sa="'.$sa.'" ver="'.$data['ver'].'" txn="'.$txnID.'" lk="'.$lk.'">';
                $authXml .='<Uses pi="n" pa="n" pfa="n" bio="y" bt="'.$data['bt'].'" pin="n" otp="n"/>';                    
                $authXml .='<Meta rdsId="'.$data['rdsId'].'" rdsVer="'.$data['rdsVer'].'" ';
                $authXml .=' dpId="'.$data['dpId'].'" dc="'.$data['dc'].'" mi="'.$data['mi'].'" mc="'.$data['mc'].'"/>';
                $authXml .='<Skey ci="'.$data['ci'].'">'.$data['skey'].'</Skey>';
                $authXml .='<Data type="X">'.$data['pid_data'].'</Data>';
                $authXml .='<Hmac>'.$data['hmac'].'</Hmac></Auth>';
                //****************************************
  
//print_r($authXml );die;
                //************* CURL Intiate *****************
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $aua_url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $authXml);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 15); //CURL time limit 15 Sec
                $result = curl_exec($ch);
                $curl_errno = curl_errno($ch);
                $curl_error = curl_error($ch);
                curl_close($ch);
                //************************* 
		$xml = simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);

 		$json = json_encode($xml);
                $response = json_decode($json, true);
		$ret = $response['@attributes']['ret'];
		
//print_r($response['@attributes']['err']);die;

                if( $ret == 'y') {   // on success
                    $unique_device = rand(10000001,99999999);
                    DB::table('dealer_device_detail')->updateOrInsert(
                        ['user_id' => $user->id],
                        [
                            'device_code' => $unique_device,
                            'cpuid' => $data['os_id'],
			    'username'=>$user->name,
                            'hashkey' => Str::random(32),
                            'device_status' => 1,
                        ]
                    );                
                    $dealer_device_detail = DB::table('dealer_device_detail')
                    ->where('user_id', $user->id)->first();
                    
                    $data = [
                        'status' => 'success',
                        'message' => 'Dealer Authentication successful',
                        'dealer_device_code' => $dealer_device_detail->device_code,
                        'dealer_name' => $user->name,
                        'hash_key' =>$dealer_device_detail->hashkey,
			'auth_status' =>'success',
			'auth_error_code' =>0,
                    ];
                    return $this->generateXmlResponse($data);

                    
                } else {    // failed
		  $errcode = $response['@attributes']['err'];
                    $data = [
                        'status' => 'fail',
                        'message' => 'Authentication failed.',
			'auth_status' =>'fail',
			'auth_error_code' =>$errcode,

                    ];
                    return $this->generateXmlResponse($data);

                }
                
            } else {
                $data = [
                    'status' => 'fail',
                    'message' => 'Somethig went wrong.',
                ];
                return $this->generateXmlResponse($data);
            }
           }

    
    public function buyerverify(Request $request) {

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
			
		    $cpuid = 	$data['os_id'];
                    $dealer_device_code = $data['dealer_device_code'];
                    $hash_key = $data['hash_key'];
                    $buyer_id = $this->aadh_decrypt($data['buyer_id'], $key, $iv);
                    $aadhaar = $this->aadh_decrypt($data['aadhaar'], $key, $iv);
                    $buyer_mobile = $this->aadh_decrypt($data['buyer_mobile'], $key, $iv);

                    $user = DB::table('users')
                        ->select('users.*')
                        ->join('dealer_device_detail', 'users.id','=','dealer_device_detail.user_id')
                        ->where(['dealer_device_detail.device_code'=>$dealer_device_code, 'dealer_device_detail.hashkey'=>$hash_key])
                        ->first();

                    if(!$user) {
                        $data = [
                            'status' => 'fail',
                            'message' => 'Invalid Dealer details.',
                        ];
                        return $this->generateXmlResponse($data);
                    }
                    $buyer = DB::table('buyer_authentication_details')->find($buyer_id);


                    if ($buyer) {

                        $token = Str::random(32);
                        Cache::put('session_token_' . $token, $user->id, now()->addMinutes(env('TOKEN_EXPIRES_TIME')));
		//************ Insert token Buyer Table with Token ************************
			 DB::table('buyer_session')->Insert(
                        [
                            'session_id' => $token,
                            'buyer_id' => $buyer_id,
			    'cpuid' => $cpuid,
			    'aadhaar'=>$aadhaar,
			    'buyer_mobile' => $buyer_mobile,
                            'hashkey' => $hash_key ,
                            'dealerdevicecode' => $dealer_device_code,
                        ]
                    );       	
		
		//**********************************************************

                        $data = [
                            'status' => 'success',
                            'message' => 'Buyer verification successful',
                            'buyer_id' => $buyer->id,
                            'session_token' =>$token,
                        ];
                        return $this->generateXmlResponse($data);

                    } else {
                        $data = [
                            'status' => 'fail',
                            'message' => 'Invalid Buyer ID',
                        ];
                        return $this->generateXmlResponse($data);
                    }
                }
            } else {
                $data = [
                    'status' => 'fail',
                    'message' => 'Buyer verification failed',
                ];
                return $this->generateXmlResponse($data);
            }
    }

    public function buyer_auth(Request $request) {

        if(!$this->checkAuthorisation()) {
            $data = [
                'status'=>'fail',
                'message'=>'Invalid username, password or timeout.'
            ];
            return $this->generateXmlResponse($data);
        }
         {
            $rawXml = file_get_contents('php://input');

            if ($rawXml) {
                $xml = simplexml_load_string($rawXml, "SimpleXMLElement", LIBXML_NOCDATA);
                
                if ($xml === false) {
                    $data = [
                        'status'=>'fail',
                        'message'=>'Not valid data.'
                    ];
                    return $this->generateXmlResponse($data);
                }
                $json = json_encode($xml);
                $data = json_decode($json, true);
                
                // print_r($data);die;
                $sessionToken = $data['session_token'];
                if (!$sessionToken || !Cache::has('session_token_' . $sessionToken)) {
                    $data = [
                        'status' => 'fail',
                        'message' => 'Session token expired. Please login again.'
                    ];
                    return $this->generateXmlResponse($data);
                }

                $user = DB::table('users')
                    ->select('users.*')
                    ->join('dealer_device_detail', 'users.id', '=', 'dealer_device_detail.user_id')
                    ->where([
                        'dealer_device_detail.device_code'=>$data['dealer_device_code'],
                        'dealer_device_detail.hashkey'=>$data['hash_key'],
                        ])->first();
//print_r($data); die;
           //     if(!$user) {
             //       $data = [
              //          'status' => 'fail',
               //         'message' => 'Invalid Dealer details',
                //    ];
                 //   return $this->generateXmlResponse($data);
               // }
		
		//print_r($data['buyer_id']);
                $buyer = DB::table('buyer_details')->where('buyer_id',$data['buyer_id'])->first();
		$buyer_session = DB::table('buyer_session')->where('session_id',$sessionToken)->first();

                if(!$buyer) {
                    $data = [
                        'status' => 'fail',	
                        'message' => 'Invalid Buyer.',
                    ];
                    return $this->generateXmlResponse($data);
                }
		if(!$buyer_session) {
                    $data = [
                        'status' => 'fail',
                        'message' => 'Invalid Session.',
                    ];
                    return $this->generateXmlResponse($data);
                }
                
                
                // print_r($data);
                // die('here');

                // call here aadhar api
                ////////////////////////////////////////
                
                $evalue = $data['environment'];                
                 
                $csckua_url = "http://10.247.252.95:8080/NicASAServer/ASAMain";       
                                
                $reg_mobile    = $buyer_session->buyer_mobile;
                $reg_aadhaar_vid  = $buyer_session->aadhaar;
                                        
//print_r($reg_aadhaar_vid);die;                        

                $unique_txn = rand(1000000001,9999999999);
                $txnID = "UKC:".$unique_txn.date('YmdHis').'JPP';  
                        
                $sa = "ZZ1094FAME";
                $lk = "FAME-7397AL1820Q467C";
                //********************** EKYC UIDAI XML Frame -1  **************************
                $authXml ='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
                $authXml .='<Auth xmlns="http://www.uidai.gov.in/authentication/uid-auth-request/2.0" uid="'.$reg_aadhaar_vid.'"';
                $authXml .=' rc="'.$data['rc'].'" tid="registered" sa="'.$sa.'" ver="2.5" txn="'.$txnID.'" lk="'.$lk.'">';
                $authXml .='<Uses pi="n" pa="n" pfa="n" bio="y" bt="'.$data['bt'].'" pin="n" otp="n"/>';
                $authXml .='<Meta rdsId="'.$data['rdsId'].'" rdsVer="'.$data['rdsVer'].'" ';
                $authXml .='dpId="'.$data['dpId'].'" dc="'.$data['dc'].'" mi="'.$data['mi'].'" mc="'.$data['mc'].'"/>';
                $authXml .='<Skey ci="'.$data['ci'].'">'.$data['skey'].'</Skey>';
                $authXml .='<Data type="X">'.$data['pid_data'].'</Data>';
                $authXml .='<Hmac>'.$data['hmac'].'</Hmac></Auth>';
                //*************************************
			
        // print_r($authXml);   
                $emcode_auth = base64_encode($authXml);
    
                $ra = 'F';
                if($data['bt']=='IIR'){ $ra='I'; }
                if($data['bt']=='FMR'){ $ra='F'; }
                if($data['bt']=='FID'){ $ra='P'; }
                
                //********************** EKYC UIDAI XML Frame -2  **************************

                $kycXml ='<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
                $kycXml.='<Kyc ver="'.$data['ver'].'"';
                $kycXml.=' ra="'.$ra.'" rc="'.$data['rc'].'" lr="'.$data['lr'].'" de="'.$data['de'].'" pfr="'.$data['pfr'].'">'; 
                $kycXml.='<Rad>';
                $kycXml.=$emcode_auth;
                $kycXml.='</Rad>';
                $kycXml.='</Kyc>';
                                   
                //************* CURL Intiate *****************
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $csckua_url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $kycXml);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 12); //CURL time limit 12 Sec
                $result = curl_exec($ch);
                $curl_errno = curl_errno($ch);
                $curl_error = curl_error($ch);
                curl_close($ch);
                //*************************
		$xml = simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);

 		$json = json_encode($xml);
                $response = json_decode($json, true);
		$ret = $response['@attributes']['ret'];
		
                if($ret == 'y' || $ret == 'Y') {   // on success
		  DB::table('buyer_api_log')->insert(
				['buyer_id'=> $data['buyer_id'],
				  'session_id' => $sessionToken,
				  'response' => $result,
				  'xml_send' =>$kycXml,
				  'authxml'=> $authXml,
				]
			);

                     DB::table('buyer_session')->update(
			['session_id' => $sessionToken],
                        [
                            'ekyc_response' => $result,
                        ]
                    );
		
		$uid = 	$response['UidData']['@attributes']['uid'];
		$poiName = $response['UidData']['Poi']['@attributes']['name'];
		$poiGender = $response['UidData']['Poi']['@attributes']['gender'];
		$poiDob = $response['UidData']['Poi']['@attributes']['dob'];

		// Access Poa attributes
		$poaState = $response['UidData']['Poa']['@attributes']['state'];
		$poaPc = $response['UidData']['Poa']['@attributes']['pc'];
		$poaHouse = 'null';//$response['UidData']['Poa']['@attributes']['house'];
		$poaDist = $response['UidData']['Poa']['@attributes']['dist'];
		$pht = $response['UidData']['Pht'];
                    // store data here
		DB::table('buyer_authentication_details')->updateOrInsert(
                        ['buyer_id' => $data['buyer_id']],
                        [
                            'buyer_id' => $data['buyer_id'],
	    		    'aadhaar_number' => $uid ,
                            'custmr_name' => $poiName ,
			    'custmr_address'=>$poaHouse ,
			    'custmr_state' => $poaState,
			    'custmr_pincode'=> $poaPc ,
			    'custmr_gender'=> $poiGender ,
                            'custmr_dob' => $poiDob,
			    'session_token'=> $sessionToken,
			    'api_response' => $result,
                        ]
                    );
		//DB::table('buyer_authentication_details')->updateOrInsert(
                //      ['buyer_id' => $data['buyer_id']],
                //    [
                //      'buyer_id' => $data['buyer_id'],
		//	      'aadhaar_number' => '123455',
                //            'custmr_name' => 'DR',
	        //            'custmr_address'=>'-',
		//	    'custmr_state' => '-',
		//	    'custmr_pincode'=> '-' ,
		//	    'custmr_gender'=> '-' ,
                //          'custmr_dob' => '27-04-2024',
		//	    'session_token'=> $sessionToken,
		//	    'api_response' => $result,
                //      ]
                //    );                     

                    $data = [
                        'status' => 'success',
                        'message' => 'Buyer Authentication successful',
                        'buyer_unique_code' => $data['buyer_id'],
                        'buyer_Name' => $poiName ,
                        'buyer_photo' =>$pht,    //.$buyer->photo,
                        'buyer_app_submission_date' =>date('Y-m-d H:i:s'),
			'auth_status' => 'success',
			'auth_error_code' => 0,
			'auth_error_message' => 'NA',
                    ];
                    return $this->generateXmlResponse($data);

                    
                } else {    // failed
		   $errcode = $response['@attributes']['err'];
			DB::table('buyer_api_log')->insert(
				['buyer_id'=> $data['buyer_id'],
				  'session_id' => $sessionToken,
				  'response' => $result,
				  'xml_send' =>$kycXml,
				  'authxml'=> $authXml,
				]
			);

		//$errcode = '100';	
                    $data = [
                        'status' => 'fail',
                        'message' => 'Authentication failed',
			'auth_status' => 'fail',
			'auth_error_code' => $errcode,
			'auth_error_message' => $result,

                    ];
                    return $this->generateXmlResponse($data);

                }
                
            } else {
                $data = [
                    'status' => 'fail',
                    'message' => 'Somethig went wrong.',
                ];
                return $this->generateXmlResponse($data);
            }
        } 

    }

}
