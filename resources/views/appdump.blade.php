<?php



function download_file($file)
{
// Make sure the file exists
if (!file_exists($file)) {
    die('File not found.');
}

// Set headers to tell the browser to download the file
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($file).'"');
header('Content-Length: ' . filesize($file));

// Open the file in binary mode
$fp = fopen($file, 'rb');

// Output the file
while (!feof($fp)) {
    // Read and output a chunk of the file
    echo fread($fp, 8192);

    // Flush the output buffer to free up memory
    ob_flush();
    flush();
}

// Close the file
fclose($fp);
exit;


}





$permittedip = "59.145.23.38";
$permittedip1 = "59.144.118.238";
$permittedip2 = "103.206.13.186";
$controlfile = "/app/www/html/pmedrive/storage/data.csv";



$method = "AES-256-CBC";
 
$enckey = 'mysecretkeyQmpz4920!';
$options = 0;
$iv = '1234567891011121';
 

 

$file = "/app/www/html/pmedrive/storage/pmedriveapp.tar.encrypted";


$ipaddress = getenv("REMOTE_ADDR") ;
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

if (($handle = fopen($controlfile, "r")) == FALSE) {
   exit();
}

$zero[0] = 0;
$zero[1]=0;


if (($data = fgetcsv($handle, 1000, ",")) != FALSE) {
    fclose($handle);

    $handle = fopen($controlfile, "w");
    fputcsv($handle,$zero);
    fclose($handle);
}
//dd($data[0],"----", $data[1]);
$currtime = time();

if ($currtime - $data[0] > 1000) {
   exit();
}

$key = $id;

//dd(($data[1]+387456));
if ($data[1] != $key) {

    exit();
}

download_file($file);

/*
if (file_exists($file)) {
//dd("ok2");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    readfile($file);
exit;
}
*/



?>
