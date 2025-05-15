<?php

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Http;

function helperFunction1()
{

    return (1);
}
function vahanAPI($Chassis_Number)
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

    if (strlen($result) < 100) {
        return false;
    }

    $dataArray = fnDecrypt($result, $inputKey);

    $dataArray = [
        'vin_chasis_no' => $vinchasis,
        'rc_regn_no' => $dataArray['rc_regn_no'] ?? null,
        'rc_regn_dt' => $dataArray['rc_regn_dt'] ?? null,
        'rc_regn_upto' => $dataArray['rc_regn_upto'] ?? null,
        'rc_purchase_dt' => $dataArray['rc_purchase_dt'] ?? null,
        'rc_owner_name' => $dataArray['rc_owner_name'] ?? null,
        'rc_f_name' => $dataArray['rc_f_name'] ?? null,
        'rc_present_address' => $dataArray['rc_present_address'] ?? null,
        'rc_permanent_address' => $dataArray['rc_permanent_address'] ?? null,
        'rc_vch_catg' => $dataArray['rc_vch_catg'] ?? null,
        'rc_vh_class_desc' => $dataArray['rc_vh_class_desc'] ?? null,
        'rc_chasi_no' => $dataArray['rc_chasi_no'] ?? null,
        'rc_eng_no' => $dataArray['rc_eng_no'] ?? null,
        'rc_maker_desc' => $dataArray['rc_maker_desc'] ?? null,
        'rc_maker_model' => $dataArray['rc_maker_model'] ?? null,
        'rc_status' => $dataArray['rc_status'] ?? null,
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
        'claim_id' => $claimno,
        'created_by' => Auth::user()->id,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];

    try {
        DB::transaction(function () use ($dataArray) {

            DB::table('vahanapidata')->insert($dataArray);
        });
        return true;
    } catch (\Exception $e) {
        return false;
    }
}

function fnDecrypt($sValue, $sSecretKey)
{
    try {
        if (isset($sValue)) {
            $sValueS = $sValue;
        } else {
            $sValueS = "OPPS! Something went wrong. Data is does not exist.";
        }
        $decodeData = base64_decode($sValue);
        if ($decodeData === false) {
            alert()->warning('Something went wrong!', 'Error')->persistent(true)->autoClose(false);
            return redirect()->back();
        } else {
            $iv = substr($sValue, 0, 16);
            $decryptedData = openssl_decrypt($decodeData, 'aes-128-cbc', $sSecretKey, OPENSSL_RAW_DATA, $iv);
            $trimmedValue = rtrim($decryptedData, "\0");
            $apos = strpos($trimmedValue, "<VehicleDetails>");
            $data = substr($decryptedData, $apos);
            $xmlObject = simplexml_load_string($data);

            // Convert SimpleXMLElement object to JSON
            $jsonString = json_encode($xmlObject);
            $jsonString1 = json_decode($jsonString, true);
            return ($jsonString1);
        }
    } catch (\Exception $e) {
        alert()->success('OPPS! Something went wrong. An exception occurred:', 'error')->persistent(true);
        return redirect()->back();
    } catch (\Error $e) {
        alert()->success("OPPS! Something went wrong. An error occurred: " . $e->getMessage(), 'error')->persistent(true);
        return redirect()->back();
    }
}



function uploadFileWithCurl($file, $additionalHeaders = [])
{
    if ($file->isValid()) {

        // Get the path to the uploaded file
        $filePath = $file->path();
        //$host = "host = 10.194.94.56";
        $host = "host = 10.80.221.235";
        $port = "port = 1494";
        $dbname = "dbname = dms";
        $credentials = "user = dms password=dms";
        $db = pg_connect("$host $port $dbname $credentials");
        $dsn = 'pgsql:host=10.80.221.235;port=1494;dbname=dms';
        $username = 'dms';
        $password = 'dms';
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $filename = $file->getClientOriginalName();
        $filemime = $file->getMimeType();
        $filesize = $file->getSize();
        $uploadfile = file_get_contents($file->getRealPath());
        $escapefile = pg_escape_bytea($uploadfile);

        if (!$db) {
            return 0;
        } else {
            //$stmt = $pdo->prepare('select max(id)+1 as maxId  from document_uploads');
            $stmt = $pdo->prepare('select nextval(' . "'document_upload_auto_seq'" . ') as maxId  ');
            $stmt->execute();
            //dd($stmt );
            $doc_id = $stmt->fetch(PDO::FETCH_ASSOC);
            $maxID = $doc_id['maxid'];

            $sql = "INSERT INTO document_uploads(id,file_name, mime, file_size, uploaded_file, ip_address, created_at, updated_at)
VALUES(" . $maxID . ",'" . $filename . "','" . $filemime . "'," . $filesize . ",'" . $escapefile . "'," . "'10.80.220.88', now(), now());";
            $resource = pg_query($db, $sql);
            return $maxID;
            $pdo = Null;
        }
    } else {
        return 0;
    }
}

function downloadFile($outputFilename)
{
    $host = "host = 10.80.221.235";
    $port = "port = 1494";
    $dbname = "dbname = dms";
    $credentials = "user = dms password=dms";
    $db = pg_connect("$host $port $dbname $credentials");
    $dsn = 'pgsql:host=10.80.221.235;port=1494;dbname=dms';
    $username = 'dms';
    $password = 'dms';
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
        if ($file) {
            $fileName = $file['file_name'];
            //$fileData = $file['uploaded_file'];
            $fileData = stream_get_contents($file['uploaded_file']);
            $fileSize = $file['file_size'];
            //dd( strlen($fileData));
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



function downloadFile_bkup($outputFilename)
{
    $url = 'http://localhost/api/getUploadedDocumentData/' . $outputFilename;

    $responseHeaders = get_headers($url, 1);
    $contentDisposition = isset($responseHeaders['Content-Disposition']) ? $responseHeaders['Content-Disposition'] : null;
    if (preg_match('/filename="(.*?)"/', $contentDisposition, $matches)) {
        $filename = $matches[1];
        
    } else {
        $filename = 'Error';
    }

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    $headers = curl_getinfo($curl);
    
    if (curl_errno($curl)) {
        $error_message = curl_error($curl);
        echo "Error: $error_message";
        return; // Stop further execution
    }

    curl_close($curl);

    // Check if the response is empty
    if (empty($response)) {
        echo "Error: Empty response received";
        return; // Stop further execution
    }

    if ($response === false) {
        echo "Error: Unable to download the file.";
        return;
    }
    // Set headers for file download
    header('Content-Description: File Transfer');
    header('Content-Type:' . $headers['content_type']);
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . strlen($response));

    // Output the file content
    echo $response;

    exit; // Stop further execution
}

function generateUsername($name, $mobile)
{
    // Convert first letter of name to uppercase and rest to lowercase
    $name = ucfirst(strtolower($name));

    // Extract the first letter of the name
    $firstLetter = substr($name, 0, 4);

    // // Define an array of special characters
    // $specialCharacters = ['$', '&', '#', '@']; // Add more if needed

    // // Get a random index from the array
    // $randomIndex = array_rand($specialCharacters);

    // // Get the random special character
    // $specialCharacter = $specialCharacters[$randomIndex];


    // Get last 2 digits of mobile number
    $lastTwoDigits = substr($mobile, -2);

    // Generate a random number between 1000 and 9999
    $randomNumber = rand(1000, 9999);

    // Concatenate the components to form the username
    // $username = $firstLetter . $specialCharacter . $lastTwoDigits . $randomNumber;
    $username = $firstLetter . $lastTwoDigits . $randomNumber;


    // Check if the username already exists in the database
    $existingUser = User::where('username', $username)->first();

    // If the username already exists, append the primary key to make it unique
    if ($existingUser) {
        $username .= User::max('id') + 1; // Append the primary key
    }

    return $username;
}

function generatePassword()
{
    // Define character sets
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $specialChars = '$&#@';

    // Combine all character sets
    $allChars = $uppercase . $lowercase . $numbers . $specialChars;

    // Initialize password variable
    $password = '';

    // Ensure at least one character from each set
    $password .= $uppercase[rand(0, strlen($uppercase) - 1)];
    $password .= $lowercase[rand(0, strlen($lowercase) - 1)];
    $password .= $numbers[rand(0, strlen($numbers) - 1)];
    $password .= $specialChars[rand(0, strlen($specialChars) - 1)];

    // Generate remaining characters randomly
    for ($i = 0; $i < 4; $i++) {
        $password .= $allChars[rand(0, strlen($allChars) - 1)];
    }

    // Shuffle the password to ensure randomness
    $password = str_shuffle($password);

    // Return the generated password
    return $password;
}


// function errorMail($e, $id)
// {
//     \Log::error($e->getMessage());
//     report($e);

//     $mail_details = DB::table('error_mail')->get();
//     $dev_data = $mail_details->where('email_type', 'to')->first();
//     // dd($dev_data);
//     $cc_details = $mail_details->where('email_type', 'cc');
//     $user_data = DB::table('users')->where('id', $id)->first();
//     // dd($cc_details);
//     foreach ($cc_details as $k => $val) {
//         $cc[] = $val->email;
//         $cc_per_name[] = $val->name;
//     }
//     // dd($cc);
//     $data = array(
//         'name' => $dev_data->name,
//         // 'to_email' => $dev_data->email,
//         'to_email' => 'ajaharuddin.ansari@ifciltd.com',
//         'error' => $e->getMessage(),
//         // 'cc_email' => $cc,
//         'cc_email' => 'ajaharuddin.ansari@ifciltd.com',
//         'cc_name' => $cc_per_name,
//         'app_name' => $user_data->name,
//         'mobile' => $user_data->mobile,
//         'contact_person' => $user_data->auth_name
//     );
//     $emailString = implode(',', $data['cc_email']);
//     // dd($emailString);
//     $ccemail = json_encode($data['cc_email']);
//     $to = $data['to_email'];
//     // $cc = $emailString;
//     $cc = '';
//     $bcc = '';
//     $subject = 'Error Log || EMPS';
//     $from = 'noreply.emps.heavyindustry@gov.in';
//     $msg = view('emails.exception', ['data' => $data])->render();

//     $response = sendEmailNic($to, $cc, $bcc, $subject, $from, $msg);

//     // dd($response);
//     // Mail::send('emails.exception', $data, function($message) use($data) {
//     // $message->to($data['to_email'],$data['name'])->subject
//     // ("Error Log || EMPS");
//     // $message->cc($data['cc_email'],$data['cc_name']);
//     // });
//     alert()->warning('Something went wrong,Please try again.', 'Warning')->persistent('Close');
// }


function sendEmailNic($to, $cc, $bcc, $subject, $from, $msg)
{
    try {

        $curl = curl_init();

        $emailDetails = array(
            "To" => $to,
            "Cc" => $cc,
            "Bcc" => "ajaharuddin.ansari@ifciltd.com",
            "Subject" => $subject,
            "From" => "noreply.pmedrive.heavyindustry@gov.in",
            "Msg" => $msg
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fame2uat.heavyindustries.gov.in/Services/DidmService.asmx/PostEmailDetails',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(array("EmailDetails" => $emailDetails)), // Use json_encode here
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        if ($response === false) {
            $errorMessage = 'Error: ' . curl_error($curl);
            curl_close($curl);
            return $errorMessage;
        } else {
            curl_close($curl);
            return $response;
        }
    } catch (Exception $ex) {
        // You can handle the exception here if needed
        return false;
    }
}
function sendSMSAPI($Mobile, $msg)
{

    try {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://stg.ifciltd.com/api/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
	"mobile_number": "' . $Mobile . '",
    	"message" :"' . $msg . '"
}',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        return True;
        curl_close($curl);
    } catch (Exception $ex) {
        // You can handle the exception here if needed
        return false;
    }
}

if (!function_exists('getParentId')) {
    function getParentId()
    {
        $parentUser = session('parent_user') != null ? session('parent_user') : null;

        if ($parentUser != null) {
            if (Auth::user()->parent_id == $parentUser->id) {
                return Auth::user()->parent_id;
            } else {
                return Auth::user()->id;
            }
        } else {
            return Auth::user()->id;
        }
    }
}
function FetchVahanAPI($claimno)
{
    ini_set('memory_limit', '4048M');
    ini_set('max_execution_time', 6600);

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


    //   $countSql = "SELECT COUNT(*) AS recordCount FROM buyur_vahanapi_vw WHERE claim_id = $claimno";
    //   $stmtCntsql = $conn->prepare($countSql);
    //   $stmtCntsql->execute();
    //   $buyurCnt = $stmtCntsql->fetch(PDO::FETCH_ASSOC);
    $buyurCnt = DB::table('buyer_details_view')->where('claim_id', $claimno)->count();
    
    //==========	Data Fetch for each vehicle =============
    
    if ($buyurCnt > 0) {
        $chess = DB::table('buyur_vahanapi_vw')->where('claim_id', $claimno)->get();
        foreach ($chess as $ches) {

            // dd($ches);exit;
            $vinchasis = $ches->vin_chassis_no;
            $postData = '{"chasisNo":"' . $vinchasis . '","clientId":"MHI_EMPS"}';
            $ch1 = curl_init();
            curl_setopt_array(
                $ch1,
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
            $response1 = curl_exec($ch1);
            curl_close($ch1);
            $inputKey = "MhI_EmPs@8300@";
            $result = $response1; // Replace with your encrypted data
            //echo $result;
            $dataArray = fnDecrypt($result, $inputKey);
            //echo ok1;

            // ----INSERT DATA ----
            $dataArray = [
                'vin_chasis_no' => $vinchasis,
                'rc_regn_no' => $dataArray['rc_regn_no'] ?? null,
                'rc_regn_dt' => $dataArray['rc_regn_dt'] ?? null,
                'rc_regn_upto' => $dataArray['rc_regn_upto'] ?? null,
                'rc_purchase_dt' => $dataArray['rc_purchase_dt'] ?? null,
                'rc_owner_name' => $dataArray['rc_owner_name'] ?? null,
                'rc_f_name' => $dataArray['rc_f_name'] ?? null,
                'rc_present_address' => $dataArray['rc_present_address'] ?? null,
                'rc_permanent_address' => $dataArray['rc_permanent_address'] ?? null,
                'rc_vch_catg' => $dataArray['rc_vch_catg'] ?? null,
                'rc_vh_class_desc' => $dataArray['rc_vh_class_desc'] ?? null,
                'rc_chasi_no' => $dataArray['rc_chasi_no'] ?? null,
                'rc_eng_no' => $dataArray['rc_eng_no'] ?? null,
                'rc_maker_desc' => $dataArray['rc_maker_desc'] ?? null,
                'rc_maker_model' => $dataArray['rc_maker_model'] ?? null,
                'rc_status' => $dataArray['rc_status'] ?? null,
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
                'claim_id' => $claimno,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            try {
                DB::transaction(function () use ($dataArray) {
                    DB::table('vahanapidata')->insert($dataArray);
                    
                });
            } catch (Exception $e) {
                echo "OPPS! Something went wrong. An exception occurred: " . $e->getMessage();
            }
        }
        return true;
    }
}

function VahanRCAPI($Chassis_Number)
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

    if (strlen($result) < 100) {
        return false;
    }

    $dataArray = fnDecrypt($result, $inputKey);
    // dd($dataArray['temporary_registration_date'],$dataArray);
    // $tmpdt=$dataArray['temporary_registration_date'] ?? Null;


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
        'created_by' => Auth::user()->id,
        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
    ];
    try {
        DB::transaction(function () use ($dataArray) {
            DB::table('vahanapidata')->insert($dataArray);
        });

        // dd('dd',$dataArray['temporary_registration_number'],$dataArray,$dataArray['rc_regn_no']);

        $response = array(
            // 'status' => true,
            'status' => !empty($dataArray['rc_regn_no']) ? true : false,
            'prcn' => $dataArray['rc_regn_no'] ?? null,
            'prcndt' => $dataArray['rc_regn_dt'] ?? null,
            'tmpcndt' => $dataArray['temporary_registration_date'] ?? null,
            'trcn' => $dataArray['temporary_registration_number'] ?? null,
        );
        
        return $response;
    } catch (\Exception $e) {
        dd($e);
        return false;
    }
}

if (!function_exists('getDealerParentId')) {
    function getDealerParentId($id)
    {
        $parentID = DB::table('users')->where('id', $id)->first();
        if (is_null($parentID->parent_id)) {
            return $parentID->id;
        } else {
            return $parentID->parent_id;
        }
    }
}

function getEmpsDataSummary()
{
    ini_set('memory_limit', '4048M');
    ini_set('max_execution_time', 6600);

    $host        = "host = 10.194.94.56";
    $port        = "port = 1494";
    $dbname      = "dbname = emps";
    $credentials = "user = emps password=emps123";
    $db = pg_connect("$host $port $dbname $credentials");
    $dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=emps';
    $username = 'emps';
    $password = 'emps123';

    $pdo = new PDO($dsn, $username, $password);
    if (!$db) {
        return 0;
    } else {
        $sql = "Select * from buyer_data_summary";
        $data_emps = pg_query($db, $sql);
        $results = pg_fetch_all($data_emps);
        return $results;
        $pdo = Null;
    }
}


function EmpsAuthUpdate($vin)
{

    $vinChassis  = $vin;
    $host        = "host = 10.194.94.56";
    $port        = "port = 1494";
    $dbname      = "dbname = emps";
    $credentials = "user = emps password=emps123";
    $db = pg_connect("$host $port $dbname $credentials");
    $dsn = 'pgsql:host=10.194.94.56;port=1494;dbname=emps';
    $username = 'emps';
    $password = 'emps123';
    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    $stmt = DB::table('emps_buyer_auth')->where('vin_chassis_no', $vinChassis)->first();

    $updateStmt = "UPDATE buyer_details
            SET buyer_id = :buyer_id,
                buyer_id_dt = :buyer_id_dt,
                pmedrive_dealer_id = :pmedrive_dealer_id,
                pmedrive_dealer_child_id = :pmedrive_dealer_child_id,
                pmedrive_dealer_status = :pmedrive_dealer_status,
                pmedrive_adh_verify = :pmedrive_adh_verify,
                pmedrive_adh_auth_dt = :pmedrive_adh_auth_dt,
                adhar_name = :adhar_name,
                pmedrive_adh_add = :pmedrive_adh_add,
                pmedrive_adh_landmark = :pmedrive_adh_landmark,
                pmedrive_adh_state = :pmedrive_adh_state,
                pmedrive_adh_district = :pmedrive_adh_district,
                pmedrive_adh_city = :pmedrive_adh_city,
                pmedrive_adh_pincode = :pmedrive_adh_pincode,
                pmedrive_adh_mobile = :pmedrive_adh_mobile,
                pmedrive_adh_gen = :pmedrive_adh_gen,
                pmedrive_adh_dob = :pmedrive_adh_dob,
                pmedrive_custmr_id_no = :pmedrive_custmr_id_no,
                pmedrive_evoucher_copy_id = :pmedrive_evoucher_copy_id,
                pmedrive_self_copy_id = :pmedrive_self_copy_id,
                pmedrive_dealer_submitted_oem = :pmedrive_dealer_submitted_oem,
                pmedrive_oem_status = :pmedrive_oem_status,
                pmedrive_oem_remarks = :pmedrive_oem_remarks,
                pmedrive_oem_id = :pmedrive_oem_id,
                pmedrive_oem_child_id = :pmedrive_oem_child_id,
                pmedrive_oem_status_at = :pmedrive_oem_status_at
            WHERE vin_chassis_no = :vin";

    $stmtup = $pdo->prepare($updateStmt);


    // Map $stmt fields to query parameters
    $bindings = [
        ':vin' => $vinChassis,
        ':buyer_id' => $stmt->buyer_id,
        ':buyer_id_dt' => $stmt->buyer_id_dt,
        ':pmedrive_dealer_id' => $stmt->pmedrive_dealer_id,
        ':pmedrive_dealer_child_id' => $stmt->pmedrive_dealer_child_id,
        ':pmedrive_dealer_status' => $stmt->pmedrive_dealer_status,
        ':pmedrive_adh_verify' => $stmt->pmedrive_adh_verify,
        ':pmedrive_adh_auth_dt' => $stmt->pmedrive_adh_auth_dt,
        ':adhar_name' => $stmt->adhar_name,
        ':pmedrive_adh_add' => $stmt->pmedrive_adh_add,
        ':pmedrive_adh_landmark' => $stmt->pmedrive_adh_landmark,
        ':pmedrive_adh_state' => $stmt->pmedrive_adh_state,
        ':pmedrive_adh_district' => $stmt->pmedrive_adh_district,
        ':pmedrive_adh_city' => $stmt->pmedrive_adh_city,
        ':pmedrive_adh_pincode' => $stmt->pmedrive_adh_pincode,
        ':pmedrive_adh_mobile' => $stmt->pmedrive_adh_mobile,
        ':pmedrive_adh_gen' => $stmt->pmedrive_adh_gen,
        ':pmedrive_adh_dob' => $stmt->pmedrive_adh_dob,
        ':pmedrive_custmr_id_no' => $stmt->pmedrive_custmr_id_no,
        ':pmedrive_evoucher_copy_id' => $stmt->pmedrive_evoucher_copy_id,
        ':pmedrive_self_copy_id' => $stmt->pmedrive_self_copy_id,
        ':pmedrive_dealer_submitted_oem' => $stmt->pmedrive_dealer_submitted_oem,
        ':pmedrive_oem_status' => $stmt->pmedrive_oem_status,
        ':pmedrive_oem_remarks' => $stmt->pmedrive_oem_remarks,
        ':pmedrive_oem_id' => $stmt->pmedrive_oem_id,
        ':pmedrive_oem_child_id' => Auth::user()->id ?? ($stmt->pmedrive_oem_id ?? null),
        ':pmedrive_oem_status_at' => now(),
    ];

    // Bind all parameters dynamically
    foreach ($bindings as $key => $value) {
        $stmtup->bindValue($key, $value);
    }

    // Execute the query
    $stmtup->execute();


    return response()->json([
        'status' => 'Success',
        'message' => 'Record updated successfully.',
    ]);

    $pdo = Null;

    exit;
}

function TimeLimit()
{
    ini_set('upload_max_filesize', '-1');
    ini_set('post_max_size', '-1');
    ini_set('max_execution_time', '0');  // 0 means unlimited execution time
    ini_set('max_input_time', '0');      // 0 means no time limit on parsing input
    ini_set('memory_limit', '-1');       // -1 means unlimited memory allocation
}


function fetchAutoVin($Chassis_Number)
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

    if (strlen($result) < 100) {
        return false;
    }

    $dataArray = fnDecrypt($result, $inputKey);
    return $dataArray;
}

function cdNumber($cd)
{

    return true;
    try {
        // Use raw value, not encoded
        $url = "http://pmedrivedev.com/api/vscrap/$cd";

        $response = Http::get($url);

        if ($response->successful()) {
            return $response->json(); // Return decoded JSON
        } else {
            return [
                'error' => 'API error',
                'status' => $response->status()
            ];
        }
    } catch (\Exception $e) {
        return [
            'error' => 'Request failed',
            'message' => $e->getMessage()
        ];
    }
}
