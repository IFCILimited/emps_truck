<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Http\Controllers\AdvConnectorController;

class APIVahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vahanapi');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $Chassis_Number=$request->Chassis_Number;
        if($Chassis_Number==Null){
            alert()->warning('Warning', 'Please Enter Chassis Number.')->persistent('Close');
            return redirect()->back();
        }
        $response= vahanAPI($Chassis_Number);

        if ($response === true) {
            alert()->success('success', 'Vahan data added successfully.')->persistent('Close');
            return redirect()->back();
        } else {
            alert()->warning('Warning', 'Data Not Found.')->persistent('Close');
            return redirect()->back();
        }
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

    public function nicpmedrive(){

        
        // dd('sms');
$url = "https://smsgw.sms.gov.in/failsafe/MLink";

// Initialize cURL session
$curl = curl_init($url);

// Set the cURL options
curl_setopt($curl, CURLOPT_POST, true); // Set the request method to POST
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return response as string
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    "Accept: application/json",
    "Content-Type: application/x-www-form-urlencoded" // Set correct content type
]);

// Prepare the POST data
$data = "username=pmedrive.sms&pin=DrvEPm%2334&mnumber=7379498775&message=Azhar,%20download%20your%20signed%20e-Voucher%20for%20PM%20E-DRIVE%20subsidy%20from%20MHI,%20Govt.%20of%20India,%20here:%20http://heavyindustries.gov.in%20Thanks%20Team%20NAB&signature=PMEDRV&dlt_entity_id=1701159437160368772&dlt_template_id=1707172737132932716";

// Set POST data
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

// For debug only (skip SSL verification)
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

// Execute the request
$resp = curl_exec($curl);

// Check for any errors in cURL
if (curl_errno($curl)) {
    dd('cURL Error: ' . curl_error($curl));
}

// Close the cURL session
curl_close($curl);

// Output response
dd($resp);

// $url = "https://smsgw.sms.gov.in/failsafe/MLink?username=pmedrive.sms&pin=DrvEPm%2334&mnumber=7379498775&message=Azhar,%20download%20your%20signed%20e-Voucher%20for%20PM%20E-DRIVE%20subsidy%20from%20MHI,%20Govt.%20of%20India,%20here:%20portal%20Thanks%20Team%20NAB&signature=PMEDRV&dlt_entity_id=1701159437160368772&dlt_template_id=1707172737132932716";


// // Initialize cURL
// $ch = curl_init();

// // Set options for cURL
// curl_setopt($ch, CURLOPT_URL, $url); // Set URL
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as string
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects if any
//  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// // Execute cURL request
// $response = curl_exec($ch);

// // Check for errors
// if (curl_errno($ch)) {
//     echo 'cURL Error: ' . curl_error($ch);
// } else {
//     // Process the response
//     echo 'Response: ' . $response;
// }

// // Close cURL
// curl_close($ch);
    }


    public function fetchADVView(){
        return view('advSearch');
    }

    public function fetchRefToken(){
        $result = DB::table('adv_data_token as adt')
        ->select('id','rtoken', 'buyer_id')
        ->orderBy('id', 'Desc')
        ->limit(5)
        ->get();
       
        return response()->json($result, 200);
    }

    public function fetchADVApi(Request $request) {
        // dd($request->all());
        $advController = new AdvConnectorController();
        $advRequest = new Request([
            "rtoken" => $request->get('rf_token')
        ]);
        // $rtoken = json_decode($advController->storeAadharNumber($advRequest), true);
        $aadharNumber = $advController->fetchAadharNumber($advRequest);
        // dd($request->all(), $aadharNumber->original);
        if($aadharNumber->original['status'] == 0) {
            alert()->error($aadharNumber->original['details']['error'], 'Error')->persistent('Close');
            
            return redirect()->back();
        }
        $aadharFetched = $aadharNumber->original['message']['aadhar_number'];
        // dd($request->all(), $aadharNumber->original, $aadharFetched);
        return view('advSearch', compact('aadharFetched'));
    }
}
