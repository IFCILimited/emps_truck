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