<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class APIController extends Controller
{
    public function generatetoken(Request $request)
    {
        $user = User::where('username', $request->username)
            ->where('email', $request->email)
            ->first();

        if ($user) {
            $oem_code = $user->parent_id ?? $user->id;

            // Check if a token already exists for this user
            $existingToken = DB::table('personal_access_tokens')
                ->where('tokenable_id', $user->id)
                ->orderBy('id', 'desc')
                ->first();

            // dd($existingToken,Carbon::now()->addHours(6));

            if ($existingToken) {
                // If the token has never been used and is not expired
                if ($existingToken->last_used_at === null) {
                    if (Carbon::now()->lessThanOrEqualTo($existingToken->expires_at)) {
                        // Token is still valid, return the same token
                        return response()->json(['token' => $existingToken->encrypted_token]);
                    } else {
                        // Token is expired, generate a new one
                        $token = $user->createToken('auth_token')->plainTextToken;
                        DB::table('personal_access_tokens')
                            ->where('tokenable_id', $user->id)
                            ->orderBy('id', 'desc')
                            ->limit(1)
                            ->update([
                                'encrypted_token' => $token,
                                'oem_code' => $oem_code,
                                'expires_at' => Carbon::now()->addHours(6), // Set expiration time to 6 hours from now
                            ]);
                        return response()->json(['token' => $token]);
                    }
                }
            }

            // If no existing token or token was used/expired, create a new token
            $token = $user->createToken('auth_token')->plainTextToken;
            DB::table('personal_access_tokens')
                ->where('tokenable_id', $user->id)
                ->orderBy('id', 'desc')
                ->limit(1)
                ->update([
                    'encrypted_token' => $token,
                    'oem_code' => $oem_code,
                    'expires_at' => Carbon::now()->addHours(6), // Set expiration time to 6 hours from now
                ]);

            return response()->json(['token' => $token]);
        } else {
            return response()->json(['message' => 'Invalid credentials', 'status' => 'Error', 'code' => 401]);
        }
    }

    public function SalesData(Request $request)
    {
        try {

            // Decrypt the token using the custom decryption method
            $encryptedData = $request->input('EncryptedData');
            $oem_code = $request->input('oem_code');
            $decryptedData = $this->customDecrypt($encryptedData, $oem_code);
            $requestData = json_decode($decryptedData, true);
            

            // Recreate the request object from the decrypted data array
            $request = new Request($requestData);
 //dd($requestData,$oem_code,$request);
            // Validate the request data
            $validatedData = $request->validate([
                // 'oem_code' => 'required',
                'token' => 'required',
                'saleData.*.vin_chasis_no' => 'required|string|regex:/^[A-Za-z0-9]{17}$/|unique:salesdata',
                'saleData.*.customer_name' => 'required',
                'saleData.*.invoice_no' => 'required',
                'saleData.*.invoice_dt' => 'required|date_format:d-m-Y',
                'saleData.*.seg_id' => 'required',
                'saleData.*.cat_id' => 'required',
                'saleData.*.state' => 'required',
                'saleData.*.pincode' => 'required'
            ]);
            if (!empty($validatedData['saleData'])) {

                $user = User::where('id', $oem_code)->first();


                $token_check = DB::table('personal_access_tokens')
                    ->where('oem_code', $oem_code)
                    ->where('encrypted_token', $request->token)
                    // ->whereNull('last_used_at')
                    ->first();

                if ($user) {
                    if ($token_check) {
                        // Check if the token has already been used
                        if (!is_null($token_check->last_used_at)) {
                            return response()->json([
                                'message' => 'Token has already been used. Please generate a new token.',
                                'status' => 'Error',
                                'code' => 401
                            ]);
                        }

                        // Check if the token is expired
                        if (Carbon::now()->greaterThan($token_check->expires_at)) {
                            return response()->json([
                                'message' => 'Token has expired. Please generate a new token.',
                                'status' => 'Error',
                                'code' => 401
                            ]);
                        }

                        $exception = DB::transaction(function () use ($request, $token_check,$oem_code) {
                            foreach ($request['saleData'] as $sales) {
//dd($sales);
                                DB::table('salesdata')->insert([
                                    'oem_id' => $oem_code,
                                    'vin_chasis_no' => $sales['vin_chasis_no'],
                                    'customer_name' => $sales['customer_name'],
                                    'invoice_no' => $sales['invoice_no'],
                                    'invoice_dt' => date('Y-m-d',strtotime($sales['invoice_dt'])),
                                    'seg_id' => $sales['seg_id'],
                                    'cat_id' => $sales['cat_id'],
                                    'state' => $sales['state'],
                                    'pincode' => $sales['pincode'],
                                    'created_by' => $token_check->tokenable_id,
                                ]);
                            }
                        });
                        if (is_null($exception)) {
                            $token_check = DB::table('personal_access_tokens')
                                ->where('oem_code', $request->oem_code)
                                ->where('encrypted_token', $request->token)
                                ->orderBy('id', 'desc') // Order by id in descending order
                                ->limit(1)
                                ->update([
                                    'last_used_at' => Carbon::now()
                                ]);

                            return response()->json([
                                'messages' => 'Sales data processed successfully',
                                'status' => 'Success',
                                'code' => 200
                            ]);
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'error code' => '422',
                                'messages' => 'Validation failed',
                                'errors' => $exception->errors()
                            ], 422);
                        }

                    }
                    return response()->json([
                        'message' => 'Invalid token',
                        'status' => 'Error',
                        'code' => 401
                    ]);
                }
                return response()->json([
                    'messages' => 'Invalid OEM code',
                    'status' => 'Error',
                    'code' => 404
                ]);

            } else {
                return response()->json([
                    'messages' => 'No sales data to process',
                    'status' => 'Error',
                    'code' => 201
                ]);
            }

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'Error',
                'error code' => '422',
                'messages' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        }
    }

    // ###################### Data check with encryption Key ############################
     public function customEncryptDataCheck(Request $request)
     {
        $key = 'c5wkm8V1gXWNTKWAST8AsQgnFSpDoDQZ';
         $cipher = 'AES-256-CBC';
         $iv = random_bytes(openssl_cipher_iv_length($cipher));
         $encrypted = openssl_encrypt(json_encode($request->all()), $cipher, $key, 0, $iv);

         $data = base64_encode($encrypted . '::' . $iv);
         return response()->json(['EncryptedData' => $data]);
     }


    // Decrypt method
    private function customDecrypt($data, $oem_code)
    {
        // Fetch the key from the database
        $keyRecord = DB::table('encryption_keys')->where('oem_code', $oem_code)->first('key');


        if (!$keyRecord || !isset($keyRecord->key)) {
            throw new \Exception('Encryption key not found for the specified OEM code.');
        }

        $key = $keyRecord->key; // Extract the key as a string
      // $key = 'c5wkm8V1gXWNTKWAST8AsQgnFSpDoDQZ';
        $cipher = 'AES-256-CBC';

        $decodedData = base64_decode($data);


        if (strpos($decodedData, '::') === false) {
            throw new \Exception('Invalid encrypted data format. Delimiter "::" not found.');
        }

        $parts = explode('::', $decodedData, 2);

        if (count($parts) !== 2) {
            throw new \Exception('Invalid encrypted data format. Expected two parts after explode.');
        }

        [$encrypted, $iv] = $parts;

        $decrypted = openssl_decrypt($encrypted, $cipher, $key, 0, $iv);
//dd($data, $oem_code,$encrypted,$iv,$key, $parts,$decrypted);

        if ($decrypted === false) {
            throw new \Exception('Decryption failed.');
        }

        return $decrypted;
    }

    // ################################################ Encryption Key insert into table with OEM id #########################################3

    public function generateAndStoreEncryptionKey()
    {
        // Generate a random key using alphabets, numbers, and special characters
        $keyHex = Str::random(32); // Generates a random string of 32 characters;

        // Retrieve user details for those with a specific role and no parent_id
        $users = DB::table('users as u')
            ->join('model_has_roles as mhr', 'u.id', '=', 'mhr.model_id')
            ->where('mhr.role_id', 4)
            ->whereNull('u.parent_id')
            ->select('u.id')
            ->get();

        // Insert all OEM data with the generated encryption key
        foreach ($users as $user) {
            $keyHex = Str::random(32); // Generates a random string of 32 characters;
            DB::table('encryption_keys')->updateOrInsert(
                ['oem_code' => $user->id], // Using user ID as oem_code
                ['key' => $keyHex] // Store the generated encryption key in hexadecimal format
            );
        }

        // Return a response indicating that the data was inserted
        return response()->json([
            'status' => 'success',
            'message' => 'Encryption keys stored successfully.'
        ]);
    }

}
