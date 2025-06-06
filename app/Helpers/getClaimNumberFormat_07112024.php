<?php

function getClaimNumberFormat($name,$id){
    $name = trim(substr($name,0,4));
    $month = now()->month;
    $year = now()->year;
    $claimNumberFormat = $name . '/' . $id . '/' . $month . '/' . $year;
    return($claimNumberFormat);
}
function JavedDemo(){
    return 1;
}

function indian_number_format($num) {
    $num = number_format($num, 2, '.', '');
    $num_parts = explode('.', $num);
    $integer_part = $num_parts[0];
    $decimal_part = isset($num_parts[1]) ? '.' . $num_parts[1] : '';
    
    $last_three = substr($integer_part, -3);
    $rest_units = substr($integer_part, 0, -3);

    if (strlen($rest_units) > 0) {
        $rest_units = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest_units);
        $formatted_number = $rest_units . ',' . $last_three . $decimal_part;
    } else {
        $formatted_number = $last_three . $decimal_part;
    }

    return $formatted_number;
}

function SendSMS($Mobile, $msg)
{
    try {
        $curl = curl_init();
 
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://fame2uat.heavyindustries.gov.in/Services/DidmService.asmx/SendSMSDetails',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "SMSDetails": {
                "MobileNumber":"' . $Mobile . '",
                "Msg":"' . $msg . '"
                }
        }
        ',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));
 
        $response = curl_exec($curl);
        return True;
        curl_close($curl);
 
    } catch (Exception $e) {
        return false;
    }
}

function indian_format($num) {
    // Convert the number to a string and format it without decimals
    $num = number_format($num, 0, '', '');
   
    // Separate the integer part
    $last_three = substr($num, -3);
    $rest_units = substr($num, 0, -3);
 
    if (strlen($rest_units) > 0) {
        $rest_units = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest_units);
        $formatted_number = $rest_units . ',' . $last_three;
    } else {
        $formatted_number = $last_three;
    }
 
    return $formatted_number;
}


function voucherSMS($buyer_id)
{

    // dd($buyer_id);
    // Define your parameters directly

    $portal_name = env('APP_NAME').'-2024'; // Subsidy name
    $downloadLink = "https://pmedrive.heavyindustries.gov.in/vcf"; // Actual download link
    $buyerDetail = DB::table('buyer_details_view')->where('buyer_id', $buyer_id)->first();
// dd($buyerDetail);
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

    $data = "username=pmedrive.sms&pin=DrvEPm%2334&mnumber=$buyerDetail->mobile&message=$buyerDetail->adhar_name,%20download%20your%20signed%20e-Voucher%20for%20$portal_name%20subsidy%20from%20MHI,%20Govt.%20of%20India,%20here:%20$downloadLink%20Team%20NAB&signature=PMEDRV&dlt_entity_id=1701159437160368772&dlt_template_id=1707172767922476030";
    // dd($data);
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
    // dd($resp);

    DB::table('msg_log')->insert([
        'related_type'=>'Evoucher',
        'related_id'=>$buyer_id,
        'prsn_name'=>$buyerDetail->adhar_name,
        'prsn_mobile'=>$buyerDetail->mobile,
        'msg'=> $data,
        'response'=> $resp,
        'store_at'=>now()
    ]);
    return true;
    // dd($resp);


    // // dd('sms');
    // $url = "https://smsgw.sms.gov.in/failsafe/MLink";

    // // Initialize cURL session
    // $curl = curl_init($url);

    // // Set the cURL options
    // curl_setopt($curl, CURLOPT_POST, true); // Set the request method to POST
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Return response as string
    // curl_setopt($curl, CURLOPT_HTTPHEADER, [
    //     "Accept: application/json",
    //     "Content-Type: application/x-www-form-urlencoded" // Set correct content type
    // ]);

    // // Prepare the POST data
    // $data = "username=pmedrive.sms&pin=DrvEPm%2334&mnumber=7379498775&message=Azhar,%20download%20your%20signed%20e-Voucher%20for%20PM%20E-DRIVE%20subsidy%20from%20MHI,%20Govt.%20of%20India,%20here:%20https://pmedrive.heavyindustries.gov.in/vcf%20Team%20NAB&signature=PMEDRV&dlt_entity_id=1701159437160368772&dlt_template_id=1707172767922476030";
    // // Set POST data
    // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    // // For debug only (skip SSL verification)
    // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    // // Execute the request
    // $resp = curl_exec($curl);

    // // Check for any errors in cURL
    // if (curl_errno($curl)) {
    //     dd('cURL Error: ' . curl_error($curl));
    // }

    // // Close the cURL session
    // curl_close($curl);

    // Output response
    // dd($resp);

   
}


function OTPSMS($mobile,$OTP)
{
dd($mobile,$OTP);
    // dd($buyer_id);
    // Define your parameters directly

    $portal_name = env('APP_NAME').'-2024'; // Subsidy name
    $downloadLink = "https://pmedrive.heavyindustries.gov.in/vcf"; // Actual download link
    $orgNAme="IFCI Ltd.";

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

    $data = "username=pmedrive.sms&pin=DrvEPm%2334&mnumber=$mobile&message=One-time%20password%20(OTP)%20for%20Login%20is%20$OTP.%20Do%20not%20share%20this%20with%20anyone.%0A%0A$portal_name,%20$orgNAme.&signature=PMEDRV&dlt_entity_id=1701159437160368772&dlt_template_id=1707172768101107195";

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

    DB::table('msg_log')->insert([
        'related_type'=>'Login OTP',
        'related_id'=>Auth::user()->id,
        'prsn_name'=>Auth::user()->name,
        'prsn_mobile'=>Auth::user()->mobile,
        'msg'=> $data,
        'response'=> $resp,
        'store_at'=>now()
    ]);
    return true;
   
}
function vehicleSoldORNot($vin){
 
    // dd($vin);
    // $curl = curl_init();
   
    // curl_setopt_array($curl, array(
    //     // CURLOPT_URL => 'http://localhost:8000/api/checkvehiclesold',
    //   CURLOPT_URL => 'https://emps.heavyindustries.gov.in/api/checkvehiclesold',
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => '',
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 0,
    //   CURLOPT_FOLLOWLOCATION => true,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => 'GET',
    //   CURLOPT_POSTFIELDS =>json_encode([
    //     'vin' => $vin
    // ]),
    //   CURLOPT_HTTPHEADER => array(
    //     'Content-Type: application/json'
    //   ),
    // ));
   
    // $response = curl_exec($curl);
   
    // curl_close($curl);
    // dd( $response);
    // return $response;


    $host        = "host = 10.194.94.56";
   	$port        = "port = 1494";
   	$dbname      = "dbname = emps";
   	$credentials = "user = emps password=emps123";
	$db = pg_connect( "$host $port $dbname $credentials"  );
	$dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=emps';
	$username = 'emps';
	$password = 'emps123';
	$pdo = new PDO($dsn, $username, $password);
    // dd($pdo);
 	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if(!$db) {
		//dd('Not Connected');
      		echo "Error : Unable to open database\n";
   	} else {
        $stmt = $pdo->prepare('SELECT * FROM check_vehicle_sold(:id)');
        $id = $vin; // Replace 'your_id_value' with the actual value
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //    dd($result,$result[0]['check_vehicle_sold']);


        if (!empty($result) && isset($result[0]['check_vehicle_sold'])) {
            if ($result[0]['check_vehicle_sold'] == 'Sold') {
                // If a match is found, return the model name
                return response()->json([
                    'status' => 'warning',
                    'message' => $result[0]['check_vehicle_sold'] // return the match message
                ]);
            } else {
                // If no match is found, return "Not Matched"
                return response()->json([
                    'status' => 'success',
                    'message' => 'Not Sold'
                ]);
            }
        } else {
            // Handle the case where there's no result or the field is missing
            return response()->json([
                'status' => 'error',
                'message' => 'No data found or invalid response'
            ]);
        }
        
		$pdo=Null;
	}

    exit; // Stop further execution
   
}
 
function DuplicateCheck($request)
{
    // dd($request);
    // $mobile = $request->mobile_no;
    // $cust_id = $request->aadhar_no;
    // $segment_id = $request->segment_id;
 
//     $curl = curl_init();
 
//     curl_setopt_array($curl, array(
//         // CURLOPT_URL => 'http://localhost:8000/api/EMPSBuyerDetail',
//         CURLOPT_URL => 'https://emps.heavyindustries.gov.in/api/EMPSBuyerDetail',
//         CURLOPT_RETURNTRANSFER => true,
//         CURLOPT_ENCODING => '',
//         CURLOPT_MAXREDIRS => 10,
//         CURLOPT_TIMEOUT => 0,
//         CURLOPT_FOLLOWLOCATION => true,
//         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//         CURLOPT_CUSTOMREQUEST => 'POST',
//         CURLOPT_POSTFIELDS => json_encode([
//             'mobile' => $mobile,
//             'cust_id' => $cust_id,
//             'segment_id' => $segment_id,
//         ]),
//         CURLOPT_HTTPHEADER => array(
//             'Content-Type: application/json',
//         ),
//     ));
 
//     $response = curl_exec($curl);
// //  dd($response);
//     curl_close($curl);
//     return $response;  // Return the response



    $host        = "host = 10.194.94.56";
   	$port        = "port = 1494";
   	$dbname      = "dbname = emps";
   	$credentials = "user = emps password=emps123";
	$db = pg_connect( "$host $port $dbname $credentials"  );
	$dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=emps';
	$username = 'emps';
	$password = 'emps123';
	$pdo = new PDO($dsn, $username, $password);
    // dd($pdo);
 	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if(!$db) {
		//dd('Not Connected');
      		echo "Error : Unable to open database\n";
   	} else {
        // dd('ddd');
        $stmt = $pdo->prepare('SELECT * FROM check_buyer_details_match(:p_mobile, :p_cust_id, :p_segment_id)');

        $mobile = (int)$request->mobile_no; // Assuming this is the mobile number
        $cust_id = (int)$request->aadhar_no; // Assuming this is the Aadhaar number
        $aadhaarLast4 = substr((string)$cust_id, -4); // Get the last 4 digits of the Aadhaar number
        $segment_id = (int)$request->segment_id; // Assuming this is an integer ID
        
        // Bind parameters individually
        $stmt->bindParam(':p_mobile', $mobile, PDO::PARAM_INT); // Use PDO::PARAM_INT for integers
        $stmt->bindParam(':p_cust_id', $aadhaarLast4, PDO::PARAM_STR); // Aadhaar last 4 as string
        $stmt->bindParam(':p_segment_id', $segment_id, PDO::PARAM_INT); // Use PDO::PARAM_INT for integers
        
        // Execute the statement
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
       

        // dd($result,$result[0]['check_buyer_details_match'] !== 'Not Matched');


        if (!empty($result) && isset($result[0]['check_buyer_details_match'])) {
            if ($result[0]['check_buyer_details_match'] !== 'Not Matched') {
                // If a match is found, return the model name
                return response()->json([
                    'status' => 'warning',
                    'message' => $result[0]['check_buyer_details_match'] // return the match message
                ]);
            } else {
                // If no match is found, return "Not Matched"
                return response()->json([
                    'status' => 'success',
                    'message' => 'Not Matched'
                ]);
            }
        } else {
            // Handle the case where there's no result or the field is missing
            return response()->json([
                'status' => 'error',
                'message' => 'No data found or invalid response'
            ]);
        }
        
		$pdo=Null;
	}

    exit; // Stop further execution
}
 
