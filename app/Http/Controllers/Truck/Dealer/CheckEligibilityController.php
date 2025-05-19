<?php

namespace App\Http\Controllers\Truck\Dealer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helperFuntion1;

use DB;

class CheckEligibilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = session('results', []);

        $segmentCheck = DB::table("segment_master")->get();
        return view('truck.buyer.check_eligibility', compact('segmentCheck', 'results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $addhaar = $request->aadhar_no;
        $mobile = $request->mobile_no;
        $segment = $request->segment_id;


        $trimmedAadhaar = trim($addhaar);
        $lastFourDigits = substr($trimmedAadhaar, -4);
        $name = 'Ajaharuddin Ansari';

        // mobile linked or not check
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
                    'CustomerName' => 'dummy',
                    'Mobile' => $mobile
                )
            )),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        if (strlen(json_decode($response)->d) != 72) {
            alert()->warning("Mobile not linked with Aadhaar");

            // ############################## implemented by Azhar 04-02-2025  #####################
            //  $responseMobile=aadhaarMobileCheck($mobile, $addhaar);

            //  if ($responseMobile=='Failed') {
            //      alert()->warning("Mobile not linked with Aadhaar");
        } else {
            // in PM EDRIVE

            $mobile = (int)$request->mobile_no; // Assuming this is the mobile number
            $cust_id = (int)$request->aadhar_no; // Assuming this is the Aadhaar number
            $aadhaarLast4 = substr((string)$cust_id, -4); // Get the last 4 digits of the Aadhaar number
            $segment_id = (int)$request->segment_id; // Assuming this is an integer ID

            $dublicateCheck = DB::select("SELECT check_buyer_details_match(?, ?, ?) AS result", [$mobile, $aadhaarLast4, $segment_id]);
            $result = $dublicateCheck[0]->result;
            if ($result !== "Not Matched") {
                alert()->warning('<strong class="text-danger">Not Eligible,</strong><br> A vehicle model <br><strong class="text-primary">"' . $result . '"</strong> has already been bought by you.', "")->persistent('Close');
            } else {
                // in EMPS
                $dupliEMPS = DuplicateCheck($request);
                // $result1 = $dupliEMPS[0]->result;
                // dd($dupliEMPS);
                // $dupliArray = json_decode($dupliEMPS->original, true);
                // dd($dupliArray);

                // if ($dupliArray['status'] == 'warning') {
                //     alert()->warning('<strong class="text-danger">Not Eligible,</strong><br> A vehicle model <br><strong class="text-primary">"' . $dupliArray['message'] . '"</strong> has already been bought by you.', "")->persistent('Close');
                //     return redirect()->back();
                // } else {
                //     alert()->success("You are eligibile");
                // }

                if ($dupliEMPS->original['message']  != 'Not Matched') {
                    alert()->warning('<strong class="text-danger">Not Eligible,</strong><br> A vehicle model <br><strong class="text-primary">"' . $dupliEMPS->original['message'] . '"</strong> has already been bought by you.', "")->persistent('Close');
                    return redirect()->back();
                } else {
                    // alert()->success("You are eligibile");
                    $segmentData = DB::table('vw_veh_segment_category')->where('segment_id', $segment_id)->first();
                    $dublicateCheck1 = DB::select("SELECT check_buyer_details_match_fame2(?, ?, ?) AS result", [$mobile, $aadhaarLast4, $segmentData->segment_name]);
                    $result1 = $dublicateCheck1[0]->result;

                    if ($result1 !== "Not Matched") {
                        alert()->warning('<strong class="text-danger">Not Eligible,</strong><br> A vehicle model <br><strong class="text-primary">"' . $result1 . '"</strong> has already been bought by you.', "")->persistent('Close');
                        return redirect()->back();
                    } else {
                        alert()->success("You are eligibile");
                    }
                }
            }
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function checkCDNumber(Request $request)
    {
        $results = [];

        $cdNumbers = collect($request->data)
            ->pluck('cdnumber')       // Get all cdnumber values
            ->filter()                // Remove null/empty
            ->unique()                // Keep only unique values
            ->values();

        foreach ($cdNumbers as $cdNumber) {
            $response = cdNumber($cdNumber); // Call helper

            $results[] = [
                'cdnumber' => $cdNumber,
                'response' => $response
            ];
        }

        // foreach ($request->data as $val) {
        //     $cdNumber = $val['cdnumber'] ?? null;

        //     if ($cdNumber) {
        //         $response = cdNumber($cdNumber); // Call helper
        //         $results[] = [
        //             'cdnumber' => $cdNumber,
        //             'response' => $response
        //         ];
        //     }
        // }

        return redirect()->route('e-trucks.checkEligibility.index')->with('results', $results);
    }
}
