<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\VahanController;
use DB;
use Carbon\Carbon;


class mailtest extends Command
{
    protected $signature = 'get:Test-Mail';
    protected $description = 'test mail';

    public function handle()
    {



        $vahan  = DB::table('vahanvin')->get();

        foreach($vahan as $vin){
            $vin = vahanAPILoop($vin->vin);
        }

        
        //  $response=aadhaarMobileCheck('8910013485', '622274602713');
        // $response=aadhaarMobileCheck('7379498775', '501236891896');
         //$response=aadhaarMobileCheck('9838406575', '501236891896');
        //$response=aadhaarMobileCheck('9999685111', '978030737592');
        // dd($response);

        

        // $result=voucherSMS(1036009009);
        // $result=OTPSMS('7379498775', '12345','login');
        //      if ($result === true) {
        //         echo "MSG sent successfully.";
        //     } else {
        //         echo "Failed to send mail: " . $result;
        //     }

        //  $testing_agency_name = DB::table('users')->where('id',9)->first();

        // $details = DB::table('vw_model_details')
        // ->where('model_id',150)
        // ->first();
        // $body=view('emails.model_submitted_by_oem', ['dsUser' => $details, 'user' => $testing_agency_name])->render();
        // $subject='Test Email';
        // $userEmail='ajaharuddin.ansari@ifciltd.com';

        // $ccEmails = ['ajaharuddin.ansari@ifciltd.com'];
        // $bccEmails = ['ajaharuddin.ansari@ifciltd.com'];

        // $result = sendMail($userEmail, $subject ,$body,$ccEmails,$bccEmails);

        //     if ($result === true) {
        //         echo "Mail sent successfully.";
        //     } else {
        //         echo "Failed to send mail: " . $result;
        //     }



        // #####################################

        // $testing_agency_name = DB::table('users')->where('id', 9)->first();


        // $detailseom = DB::table('vw_model_details')
        // ->where('model_id', 522)
        // ->first();

        // // dd( $detailseom);

        // $details = DB::table('users')
        //     ->where('id', 201)
        //     ->first();

        // // $to = $details->email;
        // $to = 'rinki@ifciltd.com';
        // $cc = 'rankaj.kumar@ifciltd.com';
        // $bcc = 'ajaharuddin.ansari@ifciltd.com';
        // $subject = 'Model Successfully Submitted';
       
        // $body = view('emails.model_submitted_by_oem', ['dsUser' => $details,
        // 'user' => $testing_agency_name, 'detail'=>$detailseom])->render();

        // $response = sendMail($to,$subject,$body, $cc, $bcc);
    }
}
