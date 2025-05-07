<?php

$permittedip = "59.145.23.38";
$permittedip1 = "59.144.118.238";
$permittedip2 = "103.206.13.186";
$controlfile = "/app/www/html/pmedrive/storage/data.csv";

$ipaddress = getenv("REMOTE_ADDR") ;


//if ($ipaddress !== $permittedip) {
 //  exit();  
//}
//elseif ($ipaddress !== $permittedip1) {
//   exit(); 
//}
//elseif($ipaddress !== $permittedip2) {
 //  exit();  
//}

if ($ipaddress !== $permittedip2 )
{
if ($ipaddress !== $permittedip1 )
{
if ($ipaddress !== $permittedip )
{
   exit();
}
}
}

if (($handle = fopen($controlfile, "w")) == FALSE) {
   exit();
}

$data[0] = intval(time());
$data[1] = intval(rand(100000,999999));
fputcsv($handle,$data);
fclose($handle);

print $data[1];
?>
