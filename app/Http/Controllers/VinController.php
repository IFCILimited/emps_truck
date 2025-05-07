<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class VinController extends Controller
{

    private $token;
    private $ip;

    public function __construct()
    {
        $this->token = 'aifufchjovizbycgdmnuetohal';
        $this->ip = ['59.145.23.38'];
    }

    public function fetchVin(Request $request)
    {

        $valid = Validator::make($request->all(), [
            'vin_number' => 'required'
        ], [
            'vin_number.required' => 'vin_number is required'
        ]);

        if ($valid->fails()) {
            return response()->json([
                'success' => false,
                'message' => $valid->errors()->first()
            ], 422);
        }

        try {

            $token =  $request->header('Authorization');
            $verifyToken = $this->verifyToken($token);
            if (!$verifyToken) {
                return response()->json([
                    'success' => false,
                    'message' => 'Token Mismatch'
                ], status: 401);
            }

            $verifyIp = $this->checkIp($request->ip());
            if(!$verifyIp) {
                return response()->json([
                    'success' => false,
                    'message' => 'IP not accepted'
                ], status: 401);
            }

            $data = fetchAutoVin($request->vin_number);
            if (!$data) {
                return response()->json([
                    'success' => false,
                    'message' => $data
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function verifyToken($token)
    {
        try {

            if ($token != $this->token) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    private function checkIp($ip)
    {
        try {

            if (!in_array($ip, $this->ip)) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
