<?php

namespace App\Http\Controllers\Truck\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Str;
use Http;

//use AshAllenDesign\ShortURL\Classes\Builder;


class ManageCertificateController extends Controller
{
    public function index($id)
    {
        // dd($id);
        $userId = decrypt($id);
        // dd($userId);
        $detail = DB::table('buyer_details_view')
            // ->select('custmr_name', 'addmi_inc_amt', 'vin_chassis_no', 'model_name', 'segment_name', 'oem_name', 'id', 'created_at', 'mobile', 'certificate_num','buyer_id')
            ->where('buyer_id', $userId)
            ->first();
        // dd($userId, $detail);


        if((int)$detail->addmi_inc_amt == 0) {
            alert()->warning("Incentive amount hasn't been updated yet", 'Kindly update it first.');
            return redirect()->back();
        }

        $buyerAuth=DB::table('buyer_authentication_details')->where('buyer_id', $detail->buyer_id)->first();

        // dd($buyerAuth);


        // $url = route("dealer.verify_certificate", ['dealerId' => encrypt($userId), 'certificateId' => encrypt($detail->certificate_num)]);
        // $shortURLObject = app(Builder::class)->destinationUrl($url)->make();
        // $shortURL = $shortURLObject->default_short_url;

        // $qRCode = QrCode::size(120)->generate($shortURL);


        $url = route("vcf");
        $qRCode = 'PM E-DRIVE Portal';
        $shortURL = 'TEst';

        $detail->formatedAmount = indian_format($detail->addmi_inc_amt);
        $detail->custmr_name = ucwords(strtolower($detail->custmr_name));

        // dd($detail, $shortURL);
       // $portal_name = 'PM E-Drive 2024';
       // $msg_mail = 'One-time password (OTP) for login is ' . $shortURL . ' %0A%0ADo not share this OTP with anyone.%0A%0A' . $portal_name . ', IFCI LIMITED';

        //$smsResponse = sendSMS($detail->mobile, $msg_mail);

        return view('truck.buyer.certificate', compact('qRCode', 'detail','buyerAuth'));
    }

    public function multiBuyerVoucher($id)
    {

        $rowId = decrypt($id);
        // dd($userId);
        $detail = DB::table('buyer_details_view')
            ->where('id', $rowId)
            ->first();

            if((int)$detail->addmi_inc_amt == 0) {
                alert()->warning("Incentive amount hasn't been updated yet", 'Kindly update it first.');
                return redirect()->back();
            }

        $buyerAuth=DB::table('buyer_authentication_details')->where('buyer_id', $detail->buyer_id)->first();

        // dd($buyerAuth);


        // $url = route("dealer.verify_certificate", ['dealerId' => encrypt($userId), 'certificateId' => encrypt($detail->certificate_num)]);
        // $shortURLObject = app(Builder::class)->destinationUrl($url)->make();
        // $shortURL = $shortURLObject->default_short_url;

        // $qRCode = QrCode::size(120)->generate($shortURL);


        $url = route("vcf");
        $qRCode = 'PM E-DRIVE Portal';
        $shortURL = 'TEst';

        $detail->formatedAmount = indian_format($detail->addmi_inc_amt);
        $detail->custmr_name = ucwords(strtolower($detail->custmr_name));

        // dd($detail, $shortURL);
       // $portal_name = 'PM E-Drive 2024';
       // $msg_mail = 'One-time password (OTP) for login is ' . $shortURL . ' %0A%0ADo not share this OTP with anyone.%0A%0A' . $portal_name . ', IFCI LIMITED';

        //$smsResponse = sendSMS($detail->mobile, $msg_mail);

        return view('truck.buyer.certificate', compact('qRCode', 'detail','buyerAuth'));
    }

    // public function verifyCertificateView($dealerId, $certificateId)
    // {
    //     $dlr_id = decrypt($dealerId);
    //     $crtf_id = decrypt($certificateId);
    //     // dd("verify it", $dlr_id, $crtf_id);

    //     $hid_dlr_id = $this->hideDigitsWithAsterisks($dlr_id);
    //     $hid_crtf_id = $this->hideDigitsWithAsterisks($crtf_id);


    //     return view('truck.buyer.qrcodeLandingPage', compact('dlr_id', 'crtf_id', 'hid_dlr_id', 'hid_crtf_id'));
    // }

    // public function sendOtpAndVerify(Request $request)
    // {
    //     // dd($request->all(), $request->ctf_id);
    //     $certificateId = $request->ctf_id;
    //     // $certificateId = 26608245;
    //     $dealerId = $request->dlr_id;
    //     $phoneNumber = $request->mb_num;

    //     $isExist = DB::table('buyer_details')
    //         ->where('id', $dealerId)
    //         ->where('mobile', $phoneNumber)
    //         ->where('certificate_num', $certificateId)
    //         ->exists();

    //     if (!$isExist) {
    //         return response()->json(['message' => "records doesn't matched!", 'status' => false]);
    //     }

    //     //$otp = rand(100000, 999999);
    //    // $portal_name = 'PM E-DRIVE-2024';
    //    // $msg_mail = 'One-time password (OTP) for login is ' . $otp . '%0A%0ADo not share this OTP with anyone.%0A%0A' . $portal_name . ', IFCI LIMITED';
    //    // $smsResponse = sendSMS($phoneNumber, $msg_mail);

    //     if ($smsResponse === 'false') {
    //         return response()->json(['message' => "Something went wrong!", 'status' => false]);
    //     } else {
    //         Session::put('verifyOTP', $otp);
    //         return response()->json(['message' => "OTP sent", 'status' => true]);
    //     }

    // }

    // public function VerifyOtp(Request $request)
    // {
    //     $OTP = $request->session()->get('verifyOTP');
    //     $enteredOtp = (int) $request->input('otp');
    //     // dd($OTP, $enteredOtp);

    //     if ($OTP === $enteredOtp) {
    //         // Session::forget('verifyOTP');

    //         $doc_id = DB::table('buyer_details')
    //             ->select('sec_file_uploadeid')
    //             ->where('id', $request->dlr_id)
    //             ->first();

    //         $docUrl = route("doc.down", encrypt($doc_id->sec_file_uploadeid));

    //         // return redirect()->route("doc.down", encrypt($doc_id->sec_file_uploadeid));
    //         return response()->json(['message' => $docUrl, 'status' => true]);
    //     }

    //     return response()->json(['message' => "OTP entered is incorrect!", 'status' => false]);

    // }


    // 30-09-2024
    public function verifyCertificateView()
    {
        // $model_detail = DB::table('vw_model_details')
        // ->select(
        //     'vw_model_details.*', // Select all columns
        //     DB::raw('(CASE
        //         WHEN valid_from <= NOW() AND valid_upto >= NOW() THEN \'Active\'
        //         ELSE \'Expired\'
        //     END) AS acstatus')
        // )
        // ->where('mhi_flag', 'A')
        // // ->where('oem_id', $oem_id)
        // // ->where('segment_id', $segment)
        // ->orderBy('vw_model_details.model_name')
        // ->get();


        $model_detail = DB::table('vw_model_details')
    ->select(
        'vw_model_details.*',
        DB::raw("'Active' AS acstatus")
    )
    ->where('mhi_flag', 'A')
    ->whereRaw('valid_from <= NOW() AND valid_upto >= NOW()') // This filters only 'Active' records
    // ->where('oem_id', $oem_id)
    // ->where('segment_id', $segment)
    ->orderBy('vw_model_details.model_name')
    ->count();

        // dd($model_detail);

        $carbonData=DB::table('claim_fuel_co2_results')->first();


        return view('truck.buyer.qrcodeLandingPage',compact('model_detail','carbonData'));
    }

    public function sendOtpAndVerify(Request $request)
    {
        $certificate = $request->c_id;
        $phoneNumber = $request->mb_num;

        $validated = $request->validate([
            'captcha' => 'required|captcha',
        ]);

        $isExist = DB::table('buyer_details')
            ->where('buyer_id', $certificate)
            ->where('mobile', $phoneNumber)
            ->exists();

        if (!$isExist) {
            return response()->json(['message' => "records doesn't matched!", 'status' => false]);
        }

        $otp = rand(100000, 999999);
        $portal_name = 'PM E-DRIVE-2024';
        $msg_mail = 'One-time password (OTP) for login is ' . $otp . '%0A%0ADo not share this OTP with anyone.%0A%0A' . $portal_name . ', IFCI LIMITED';
        $smsResponse = sendSMS($phoneNumber, $msg_mail);

        if ($smsResponse === 'false') {
            return response()->json(['message' => "Something went wrong!", 'status' => false]);
        } else {
            Session::put('verifyOTP', $otp);
            return response()->json(['message' => "OTP sent", 'status' => true]);
        }

    }

    public function VerifyOtp(Request $request)
    {
        $OTP = $request->session()->get('verifyOTP');
        $enteredOtp = (int) $request->input('otp');
        // dd($OTP, $enteredOtp);

        if ($OTP === $enteredOtp) {
            Session::forget('verifyOTP');

            $doc_id = DB::table('buyer_details')
                ->select('evoucher_copy_id')
                ->where('buyer_id', $request->dlr_id)
                ->first();

            $docUrl = route("doc.down", encrypt($doc_id->evoucher_copy_id));

            return response()->json(['message' => $docUrl, 'status' => true]);
        }

        return response()->json(['message' => "OTP entered is incorrect!", 'status' => false]);

    }
    private function hideDigitsWithAsterisks($number)
    {
        // Convert number to string
        $numStr = (string) $number;

        // Get the length of the number
        $length = strlen($numStr);

        // If length is less than or equal to 3, return the number as is
        if ($length <= 3) {
            return $numStr;
        }

        // Create a string of asterisks for the hidden digits
        $asterisks = str_repeat('*', $length - 3);

        // Get last 3 digits
        $lastThreeDigits = substr($numStr, -3);

        // Combine asterisks and last 3 digits
        return $asterisks . $lastThreeDigits;
    }

    public function datacheck($id, $addhaar, $mobile)
    {
        // dd('dd');

        $trimmedAadhaar = trim($addhaar); // Remove spaces
        $lastFourDigits = substr($trimmedAadhaar, -4);
        $name = 'Ajaharuddin Ansari';

        $data = DB::table('buyer_authentication_details')->where('id', $id)->first();
        // dd($data);
        if (is_null($data)) {
            return response()->json(['message' => "No data found!", 'status' => false]);
        }

        $dublicateCheck = DB::table('buyer_authentication_details')->where('custmr_mobile', $mobile)->where('aadhaar_number', $lastFourDigits)->first();
        // dd($dublicateCheck);
        if ($dublicateCheck) {
            return response()->json(['message' => "Already Vehicle Bought", 'status' => false]);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fame2uat.heavyindustries.gov.in/Services/DidmService.asmx/GetAadharDetailsMobile',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(array(
                'CustomerDetails2' => array(
                    'AadharNumber' => $addhaar,
                    // 'CustomerName' => $name,
                    'CustomerName' => 'dummy',
                    'Mobile' => $mobile
                )
            )),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            // Optional: Specify the path to the CA cert bundle (adjust the path as necessary)
            // CURLOPT_CAINFO => '/path/to/cacert.pem',
            // Optional: Disable SSL verification (use with caution, for debugging only)
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ));

        $response = curl_exec($curl);

        // Error checking
// if(curl_errno($curl)) {
//     echo 'cURL error: ' . curl_error($curl);
// } else {
//     echo 'Response: ' . $response;
// }

        curl_close($curl);

// dd($response);
        // dd(json_decode($response), curl_error($curl),strlen(json_decode($response)->d));

        // Check if response data is not 72 characters long
        if (strlen(json_decode($response)->d) != 72) {
            return response()->json(['message' => 'Mobile not linked with Aadhaar', 'status' => false]);
        } else {
            // Aadhaar and mobile linked
            return response()->json(['message' => 'Aadhaar and mobile are linked!', 'status' => true]);
        }



    }
}
