<?php

function getClaimNumberFormat($name, $id)
{
    $name = trim(substr($name, 0, 4));
    $month = now()->month;
    $year = now()->year;
    $claimNumberFormat = $name . '/' . $id . '/' . $month . '/' . $year;
    return ($claimNumberFormat);
}
function JavedDemo()
{
    return 1;
}

function indian_number_format($num)
{
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
            CURLOPT_POSTFIELDS => '{
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

function indian_format($num)
{
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

    $portal_name = env('APP_NAME') . '-2024'; // Subsidy name
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
        'related_type' => 'Evoucher',
        'related_id' => $buyer_id,
        'prsn_name' => $buyerDetail->adhar_name,
        'prsn_mobile' => $buyerDetail->mobile,
        'msg' => $data,
        'response' => $resp,
        'store_at' => now()
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
    

    
// dd($mobile,$OTP);
// 
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

    // $data = "username=pmedrive.sms&pin=DrvEPm%2334&mnumber=$mobile&message=One-time%20password%20(OTP)%20for%20Login%20is%20$OTP.%20Do%20not%20share%20this%20with%20anyone.%0A%0A$portal_name,$orgNAme,%20Team%20NAB.&signature=PMEDRV&dlt_entity_id=1701159437160368772&dlt_template_id=1707172830146181123";
    $data = "username=pmedrive.sms&pin=DrvEPm%2334&mnumber=$mobile&message=One-time%20password%20(OTP)%20for%20Login%20is%20$OTP.%20Do%20not%20share%20this%20with%20anyone.%0A%0A$portal_name,$orgNAme%20,Team%20NAB.&signature=PMEDRV&dlt_entity_id=1701159437160368772&dlt_template_id=1707172830146181123";

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
function vehicleSoldORNot($vin)
{

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


    $host = "host = 10.194.94.56";
    $port = "port = 1494";
    $dbname = "dbname = emps";
    $credentials = "user = emps password=emps123";
    $db = pg_connect("$host $port $dbname $credentials");
    $dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=emps';
    $username = 'emps';
    $password = 'emps123';
    $pdo = new PDO($dsn, $username, $password);
    // dd($pdo);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (!$db) {
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

        $pdo = Null;
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



    $host = "host = 10.194.94.56";
    $port = "port = 1494";
    $dbname = "dbname = emps";
    $credentials = "user = emps password=emps123";
    $db = pg_connect("$host $port $dbname $credentials");
    $dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=emps';
    $username = 'emps';
    $password = 'emps123';
    $pdo = new PDO($dsn, $username, $password);
    // dd($pdo);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (!$db) {
        //dd('Not Connected');
        echo "Error : Unable to open database\n";
    } else {
        // dd('ddd');
        $stmt = $pdo->prepare('SELECT * FROM check_buyer_details_match(:p_mobile, :p_cust_id, :p_segment_id)');

        $mobile = (int) $request->mobile_no; // Assuming this is the mobile number
        $cust_id = (int) $request->aadhar_no; // Assuming this is the Aadhaar number
        $aadhaarLast4 = substr((string) $cust_id, -4); // Get the last 4 digits of the Aadhaar number
        $segment_id = (int) $request->segment_id; // Assuming this is an integer ID

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

        $pdo = Null;
    }

    exit; // Stop further execution
}

function CheckVinExist($vinChassis)
{
    $host = "host = 10.194.94.56";
    $port = "port = 1494";
    $dbname = "dbname = emps";
    $credentials = "user = emps password=emps123";
    $db = pg_connect("$host $port $dbname $credentials");
    $dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=emps';
    $username = 'emps';
    $password = 'emps123';
    $pdo = new PDO($dsn, $username, $password);
    // dd($pdo);
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query to check if the VIN exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM buyer_details WHERE vin_chassis_no = :vinChassis");
        $stmt->bindParam(':vinChassis', $vinChassis, PDO::PARAM_STR);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        // Return true if VIN exists, otherwise false
        return $count > 0;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false; // In case of an error, return false
    }

    exit; // Stop further execution
}

function gernerateBuyerId()
{
    $sequenceValue = DB::select("SELECT NEXTVAL('sequence_buyer_id') AS next_value");
    $BuyerIdSeq = $sequenceValue[0]->next_value;
    $BuyerDB = $BuyerIdSeq * 10000;

    $Random = random_int(1000, 9999);
    $randid = $BuyerDB + $Random;
    $GenBuyerId = $randid + 1000000000;
    return $GenBuyerId;
}





// function EmpsAuthCheck($vinChassisNo)
// {
//     $host = "host = 10.194.94.56";
//     $port = "port = 1494";
//     $dbname = "dbname = emps";
//     $credentials = "user = emps password=emps123";
//     $db = pg_connect("$host $port $dbname $credentials");
//     $dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=emps';
//     $username = 'emps';
//     $password = 'emps123';
//     $pdo = new PDO($dsn, $username, $password);
//     // dd($pdo);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//     // if(!$db) {
//     //  //dd('Not Connected');
//     //          echo "Error : Unable to open database\n";
//     // } else {
//         // dd('ddd');
//         $stmt = $pdo->prepare('SELECT * FROM buyer_details_view WHERE vin_chassis_no = :vin');


//         $stmt->bindParam(':vin', $vinChassisNo, PDO::PARAM_STR);
//         // $stmt->bindValue(':date', '2024-10-01', PDO::PARAM_STR);
//         // $stmt->bindValue(':dealer_status', 'A', PDO::PARAM_STR);

//         $stmt->execute();

//         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         // dd($result);
//         // Filter records where 'vihcle_dt' >= '2024-10-01' and 'status' = 'A'
//         $resultAfter = array_filter($result, function ($item) {
//             return $item['vihcle_dt'] >= '2024-10-01' && $item['status'] === 'A';
//         });

//         // Filter records where 'vihcle_dt' < '2024-10-01' and 'status' = 'A'
//         $resultBefore = array_filter($result, function ($item) {
//             return $item['vihcle_dt'] < '2024-10-01' && $item['status'] === 'A';
//         });

//         $resultfalse = array_filter($result, function ($item) {
//     return in_array($item['status'], ['D', 'S']);
// });

// // dd($resultfalse);



//         // Handle the response based on the filtered results
//         if (!empty($resultAfter)) {
//             return response()->json([
//                 'status' => 'SuccessE',
//                 'message' => $resultAfter
//             ]);
//         } elseif (!empty($resultBefore)) {
//             $vinChassisNo = $resultBefore[0]['vin_chassis_no'];
//             $vehicleDt =$resultBefore[0]['vihcle_dt'];
//             return response()->json([
//                 'status' => 'SuccessNE',
//                 'message' => "This {$vinChassisNo} has a Vehicle Registration Date of {$vehicleDt}, which is less than 1st Oct 2024. So, this VIN is not eligible for PM E-DRIVE."
//             ]);
//         } elseif(!empty($resultfalse)) {
//             return response()->json([
//                 'status' => 'Warning',
//                 'message' => "The VIN {$vinChassisNo} is in Draft mode."
//             ]);
//         }else{
//             return response()->json([
//                 'status' => 'Error',
//                 'message' => "No records found for the given VIN."
//                 ]);
//         }

//         $pdo=Null;
//     // }

//     exit; // Stop further execution
// }



function EmpsAuthCheck($vinChassisNo)
{

    $host = "host = 10.194.94.56";
    $port = "port = 1494";
    $dbname = "dbname = emps";
    $credentials = "user = emps password=emps123";
    $db = pg_connect("$host $port $dbname $credentials");
    $dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=emps';
    $username = 'emps';
    $password = 'emps123';
    $pdo = new PDO($dsn, $username, $password);
    // dd($pdo);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // if(!$db) {
    //  //dd('Not Connected');
    //          echo "Error : Unable to open database\n";
    // } else {
    // dd('ddd');
    $stmt = $pdo->prepare('SELECT * FROM buyer_details_view WHERE vin_chassis_no = :vin');


    $stmt->bindParam(':vin', $vinChassisNo, PDO::PARAM_STR);

    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if($result==null){
        return response()->json([
            'status' => 'Warning',
            'message' => "The VIN {$vinChassisNo} does not exist in EMPS."
        ]);
    }

    $empsOemID = $result[0]['oem_id'];

    $stmtoem = $pdo->prepare('SELECT * FROM post_registration_detail WHERE user_id = :oemid');

    $stmtoem->bindParam(':oemid', $empsOemID, PDO::PARAM_STR);

    $stmtoem->execute();

    $resultoem = $stmtoem->fetchAll(PDO::FETCH_ASSOC);

    $resultpostgstn = $resultoem[0]['gstin_no'];

    // dd(auth::user()->oem_id);

    $pmdrivePost = DB::table('post_registration_detail')->where('user_id', auth::user()->oem_id)->first();

    $pmdriveGstn = $pmdrivePost->gstin_no;

    if ($resultpostgstn == $pmdriveGstn) {
        $resultAfter = array_filter($result, function ($item) {
            return $item['vihcle_dt'] >= '2024-10-01' && $item['status'] === 'A';
        });

        // Filter records where 'vihcle_dt' < '2024-10-01' and 'status' = 'A'
        $resultBefore = array_filter($result, function ($item) {
            return $item['vihcle_dt'] < '2024-10-01' && $item['status'] === 'A';
        });

        $resultfalse = array_filter($result, function ($item) {
            return $item['vihcle_dt'] < '2024-10-01' && in_array($item['status'], ['D', 'S']);
        });



        if (!empty($resultAfter)) {
            return response()->json([
                'status' => 'SuccessE',
                'message' => $resultAfter
            ]);
        } elseif (!empty($resultBefore)) {
            $vinChassisNo = $resultBefore[0]['vin_chassis_no'];
            $vehicleDt = $resultBefore[0]['vihcle_dt'];
            return response()->json([
                'status' => 'SuccessNE',
                'message' => "This {$vinChassisNo} has a Vehicle Registration Date of {$vehicleDt}, which is less than 1st Oct 2024. So, this VIN is not eligible for PM E-DRIVE."
            ]);
        } elseif (!empty($resultfalse)) {
            return response()->json([
                'status' => 'Warning',
                'message' => "The VIN {$vinChassisNo} is in Draft mode."
            ]);
        } else {
            return response()->json([
                'status' => 'Error',
                'message' => "No records found for the given VIN."
            ]);
        }
    } else {
        return response()->json([
            'status' => 'Error',
            'message' => "Mismatch detected: The provided VIN is not associated with the specified OEM. "
        ]);
    }

    $pdo = Null;


    exit; // Stop further execution
}

function EmpsdownloadFile($outputFilename)
{
    $host = "host = 10.194.94.56";
    $port = "port = 1494";
    $dbname = "dbname = dms";
    $credentials = "user = dms password=dms123";
    $db = pg_connect("$host $port $dbname $credentials");
    $dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=dms';
    $username = 'dms';
    $password = 'dms123';
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (!$db) {
        //dd('Not Connected');
        echo "Error : Unable to open database\n";
    } else {
        $fileId = $outputFilename; // The ID of the file you want to retrieve
        $stmt = $pdo->prepare('SELECT file_name, uploaded_file,file_size FROM document_uploads WHERE id = :id');
        $stmt->bindParam(':id', $fileId, PDO::PARAM_INT);
        $stmt->execute();

        $file = $stmt->fetch(PDO::FETCH_ASSOC);
        // dd($file);
        if ($file) {
            $fileName = $file['file_name'];
            // dd($fileName);
            //$fileData = $file['uploaded_file'];
            $fileData = stream_get_contents($file['uploaded_file']);
            $fileSize = $file['file_size'];
            // dd( strlen($fileData));
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . $fileSize);
            echo $fileData;
            $pdo = Null;

        } else {
            echo "File Not Found";
        }
    }
    echo "File Not Found";

    exit; // Stop further execution
}



function aadhaarMobileCheck($mobile, $aadhaar_no)
{
    // dd($mobile, $aadhaar_no);
    define("PUBLIC_CERT_PATH", "/app/www/html/pmedrive/uidai_auth_pre_prod.txt");
    date_default_timezone_set('Asia/Calcutta');

    //For Getting Encrypted PID block value
    function encrypt_by_session_key($data, $session_key, $ts)
    {
        $cipher = "AES-256-GCM";
        $iv = substr($ts, -12);
        $aad = substr($ts, -16);
        $tag = NULL;
        $encryptpid = openssl_encrypt($data, $cipher, $session_key, OPENSSL_RAW_DATA, $iv, $tag, $aad, 16);
        $encryptedpid = base64_encode($ts . $encryptpid . $tag);
        return $encryptedpid;
    }

    //For Getting HMAC value(SHA-256 Hash of Pid block, encrypted and then encoded)
    function calculate_hmac($data, $session_key, $ts)
    {
        $iv = substr($ts, -12);
        $aad = substr($ts, -16);
        $cipher = "AES-256-GCM";
        $tag = NULL;
        $hmac_hash = hash('SHA256', $data, true);
        $encrypthmac = openssl_encrypt($hmac_hash, $cipher, $session_key, OPENSSL_RAW_DATA, $iv, $tag, $aad, 16);
        $encryptedhmac = base64_encode($encrypthmac . $tag);

        return $encryptedhmac;
    }

    //Getting value of ci attribute to be used in Skey element
    function certif_expire()
    {
        $certinfo = openssl_x509_parse(file_get_contents(PUBLIC_CERT_PATH));
        return date('Ymd', $certinfo['validTo_time_t']);
    }

    //Encrypted and Encoded Session Key
    function encrypt_session_key($session_key)
    {
        $pub_key = openssl_pkey_get_public(file_get_contents(PUBLIC_CERT_PATH));
        $keyData = openssl_pkey_get_details($pub_key);
        openssl_public_encrypt($session_key, $encrypted_session_key, $keyData['key'], OPENSSL_PKCS1_PADDING);
        return base64_encode($encrypted_session_key);
    }

    $txn = "AuthDemo" . "otp";
    $pidts = date('Y-m-d\TH:i:s', time());
    $ts = date('Y-m-d H:i:s', time());
    // $aadhaar_no = "501236891896";
    $session_key = openssl_random_pseudo_bytes(32);


    //pre production
    // $csckua_url = "http://10.247.252.95:8080/NicASAServer/ASAMain";

    //production
    $csckua_url = "http://10.247.252.93:8080/NicASAServer/ASAMain";



    $xurl = "http://www.uidai.gov.in/authentication/uid-auth-request/2.0";
    $ac = "public";
    $sa = "ZZ1094FAME";
    $lk = "FAME-7397AL1820Q467C";


    // $mobile='9838406575';
// dd($txn);

    $pid_block = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Pid ts="' . $pidts . '" ver="2.0" wadh=""><Demo><Pi phone="' . $mobile . '" /></Demo></Pid>';
   // dd($pid_block);
    $auth_xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Auth xmlns="http://www.uidai.gov.in/authentication/uid-auth-request/2.0" uid="' . $aadhaar_no . '" rc="Y" tid="" ver="2.5" txn="' . $txn . '" ac="" sa="' . $sa . '" lk="' . $lk . '">
<Uses pi="y" pa="n" pfa="n" bio="n" otp="n" pin="n" />
<Meta udc="" pip="" rdsId="" rdsVer="" dpId="" dc="" mi="" mc="" />
<Skey ci="' . certif_expire() . '">' . encrypt_session_key($session_key) . '</Skey>
<Data type="X">' . encrypt_by_session_key($pid_block, $session_key, $ts) . '</Data>
<Hmac>' . calculate_hmac($pid_block, $session_key, $ts) . '</Hmac></Auth>';
     //dd($auth_xml);

    $emcode_auth = base64_encode($auth_xml);






    $kycXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Kyc xmlns="http://www.uidai.gov.in/kyc/uid-kyc-request/1.0" ver="2.5" ra="O" rc="Y" lr="N" de="N" pfr="N"><Rad>' . $emcode_auth . ' </Rad></Kyc>';

    //dd($kycXml);

    $otpch = curl_init();
    curl_setopt($otpch, CURLOPT_URL, $csckua_url);
    curl_setopt($otpch, CURLOPT_POSTFIELDS, $auth_xml);
    curl_setopt($otpch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($otpch, CURLOPT_TIMEOUT, 20);
    $otpresult = curl_exec($otpch);

    $curl_errno = curl_errno($otpch);
    $curl_error = curl_error($otpch);
    curl_close($otpch);
    // echo $auth_xml.$otpresult;

    $oxml = simplexml_load_string($otpresult);
    // Final
    //  dd($oxml);
    dd($otpresult);
    dd($oxml['ret']);
    if ($oxml['ret'] == 'y') {
        $osuccess = 'Successful';
        $getresultdiv = 'true';
        return  $osuccess;
        //dd($osuccess);
    } else {
        // $ofail = 'Authentication Failed';
        $ofail = 'Failed';
        $getresultdiv = 'true';
        return  $ofail;
        // $err = $oxml['err'];
        // dd($err);
    }

}


function sendMail($recipientEmail,$ccEmail, $bccEmail,$subject, $body)
{
    // dd($ccEmail);

    // $recipientEmail='ajaharuddin.ansari@ifciltd.com';
    // Ensure PHPMailer is included
    require_once app_path('PHPMail/PHPMailerAutoload.php');

    $fromEmail = 'pm-edrive@gov.in';
    $fromName = 'PM E-DRIVE';

    try {
        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        // SMTP configuration
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtpsgwhyd.nic.in';
        $mail->SMTPAuth = true;
        $mail->Username = $fromEmail;
        $mail->Password = 'Y5#dN7@pT2';
        // $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        // Email settings
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($recipientEmail);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $body;


        if (!empty($ccEmail)) {
            if (is_array($ccEmail)) {
                foreach ($ccEmail as $cc) {
                    $mail->addCC($cc);
                }
            } else {
                $mail->addCC($ccEmail);
            }
        }

        if (!empty($bccEmail)) {
            if (is_array($bccEmail)) {
                foreach ($bccEmail as $bcc) {
                    $mail->addBCC($bcc);
                }
            } else {
                $mail->addBCC($bccEmail);
            }
        }

        // dd($mail);

        if ($mail->send()) {
            return "Email sent successfully!";
        } else {
            return "Mailer Error: " . $mail->ErrorInfo;
        }
    } catch (Exception $e) {
       
        return "Exception: " . $e->getMessage();
    }
}



function vahanAPILoop($Chassis_Number)
{
    $url = 'https://delhigw.napix.gov.in/nic/parivahan/oauth2/token';
    $postData = [
        'grant_type' => 'client_credentials',
        'scope' => 'napix',
    ];
    $username = '3196a9095aeb9ac74f18c6747cc4d105';
    $password = '38ab4d425593eac474b67c3b34279fa7';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type:
        application/x-www-form-urlencoded',
    ]);
    curl_setopt($ch, CURLOPT_USERPWD, $username . ':' . $password);
    $response = curl_exec($ch);
    curl_close($ch);
    $responseData = json_decode($response, true);
    $token = $responseData['access_token'];


    // $vinchasis = 'M75KAKUP22E000618';
    $vinchasis = $Chassis_Number;

    $postData = '{"chasisNo":"' . $vinchasis . '","clientId":"MHI_EMPS"}';
    // dd($postData);

    $ch = curl_init();
    curl_setopt_array(
        $ch,
        array(
            CURLOPT_URL => 'https://delhigw.napix.gov.in/nic/parivahan/vahanws/service/getChasisDetails',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token
            ),
        )
    );
    $response1 = curl_exec($ch);
    curl_close($ch);
    $inputKey = "MhI_EmPs@8300@";
    $result = $response1; // Replace with your encrypted data
    // dd(strlen($result));
    if (strlen($result) < 100) {
        return false;
    }

    $dataArray = fnDecrypt($result, $inputKey);
    // dd($dataArray);

    $dataArray = [
        'vin_chasis_no' => $vinchasis,
        //'rc_regn_no' => $dataArray['rc_regn_no'] ?? null,
	'rc_regn_no' => !empty($dataArray['rc_regn_no']) ? $dataArray['rc_regn_no'] : null,
        'rc_regn_dt' => $dataArray['rc_regn_dt'] ?? null,
        'temporary_registration_number' => $dataArray['temporary_registration_number'] ?? null,
        //'rc_regn_upto' => $dataArray['rc_regn_upto'] ?? null,
	'rc_regn_upto' => !empty($dataArray['rc_regn_upto']) ? $dataArray['rc_regn_upto'] : null,
        'rc_purchase_dt' => $dataArray['rc_purchase_dt'] ?? null,
        'rc_owner_name' => $dataArray['rc_owner_name'] ?? null,
        'rc_f_name' => $dataArray['rc_f_name'] ?? null,
        'rc_present_address' => $dataArray['rc_present_address'] ?? null,
        'rc_permanent_address' => $dataArray['rc_permanent_address'] ?? null,
        'rc_vch_catg' => $dataArray['rc_vch_catg'] ?? null,
        'rc_vh_class_desc' => $dataArray['rc_vh_class_desc'] ?? null,
        'rc_chasi_no' => $dataArray['rc_chasi_no'] ?? null,
        'rc_eng_no' => $dataArray['rc_eng_no'] ?? null,
        // 'rc_maker_desc' => $dataArray['rc_maker_desc'] ?? null,   
        'rc_maker_desc' => !empty($dataArray['rc_maker_desc']) ? $dataArray['rc_maker_desc'] : null,   
        'rc_maker_model' => $dataArray['rc_maker_model'] ?? null,
        //'rc_status' => $dataArray['rc_status'] ?? null,
	'rc_status' => !empty($dataArray['rc_status']) ? $dataArray['rc_status'] : null,
        'rc_vh_class' => $dataArray['rc_vh_class'] ?? null,
        'rc_fuel_cd' => $dataArray['rc_fuel_cd'] ?? null,
        'rc_maker_cd' => $dataArray['rc_maker_cd'] ?? null,
        'rc_sale_amt' => $dataArray['rc_sale_amt'] ?? null,
        'rc_vehicle_surrendered_to_dealer' => $dataArray['rc_vehicle_surrendered_to_dealer'] ?? null,
        'rc_currentadd_districtcode' => $dataArray['rc_currentadd_districtcode'] ?? null,
        'rc_non_use' => $dataArray['rc_non_use'] ?? null,
        'rc_vh_type' => $dataArray['rc_vh_type'] ?? null,
  			    'rc_currentadd_statename' => $dataArray['state_cd'] ?? null,
			    'rc_manu_month_yr' => $dataArray['rc_manu_month_yr'] ?? null,
			    'rc_registered_at' => $dataArray['rc_registered_at'] ?? null,
			    'rc_fuel_type' => $dataArray['rc_fuel_desc'] ?? null,
                            'rc_remark' => 'PERMANENT REGISTERED',
        // 'created_by' =>0,
        // 'created_at' => Carbon::now(),
        // 'updated_at' => Carbon::now(),
    ];

    try {
        DB::transaction(function () use ($dataArray) {

            DB::table('vahanapidata_auto')->insert($dataArray);
        });
        return true;
    } catch (\Exception $e) {
        dd($e);
        return false;
    }


}

function CheckValidity($invoice_dt,$mid)  {

    // $Check_model = DB::table('oem_model_details')->where('model_id',$mid)
    // ->selectRaw('MIN(testing_approval_date) as min_approval_date, MAX(testing_expiry_date) as max_expiry_date')->first();
    
    
    // if($invoice_dt >= $Check_model->min_approval_date &&  $invoice_dt <= $Check_model->max_expiry_date){
    //     return true;

        
    // }
    // else{
    //     return false;
    // }

    
        // $model=DB::table('vw_model_details')->where('model_id',$mid->model_master_id)->where('mhi_flag','A')->first();
        $model=DB::table('vw_model_details')->where('model_id',$mid)->where('mhi_flag','A')->first();
       
            // Call the PostgreSQL function
            $result = DB::select("SELECT pmedrive.check_invoicecertificatevalidity_new(?, ?, ?) AS validity", [
                $mid,
                $invoice_dt,
                $model->model_name // Assuming this is the correct column
            ]);

            // Extract the validity result
            $fn = $result[0]->validity ?? 0; // Defaults to 0 if function fails

            // If the function returns 0, show a warning and redirect
            if ($fn > 0) {
                return true;
            }else{
                return false;
            }
}   
function EMPSCertificateDateFetch($modelName){
   

    $host = "host = 10.194.94.56";
    $port = "port = 1494";
    $dbname = "dbname = emps";
    $credentials = "user = emps password=emps123";
    $db = pg_connect("$host $port $dbname $credentials");
    $dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=emps';
    // $dsn = 'pgsql:host=172.16.10.255;port=1494;dbname=emps';
    // $password = 'emps';
    $username = 'emps';
    $password = 'emps123';
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "with inner_table as (
        select 
        min(omd.testing_approval_date) as testing_approval_date,
        max(omd.testing_expiry_date ) as testing_expiry_date
        from model_master mm 
        inner join oem_model_details omd on omd.model_id = mm.id
        where replace(upper(mm.model_name),' ', '') =  replace(upper('".$modelName."'),' ', '')
        and omd.mhi_flag = 'A') 
        select (select 
        max(omd.model_id)
        from model_master mm 
        inner join oem_model_details omd on omd.model_id = mm.id
        where replace(upper(mm.model_name),' ', '') =  replace(upper('".$modelName."'),' ', '')
        and omd.testing_expiry_date = inner_table.testing_expiry_date
        and omd.mhi_flag = 'A'), inner_table.* from inner_table";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($result)){
            return $result;
        }
        return null;

}
