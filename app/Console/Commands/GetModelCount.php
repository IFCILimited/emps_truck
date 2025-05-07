<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\VahanController;
use DB;
use Carbon\Carbon;


class GetModelCount extends Command
{
    protected $signature = 'get:model-count {--from-date= : The start date for the count} {--to-date= : The end date for the count}';
    protected $description = 'Get model count from API';

    public function handle()
    {
        // $response = Http::get('http://localhost:8000/api/get-model-count');
        
    $fromDate = DB::table("vahan_api_model_data")->max('api_to_date');
    $fromDate = Carbon::parse($fromDate)->addDay()->format('Y-m-d');
    $toDate = Carbon::parse(now())->addDays(-1)->format('Y-m-d');
//dd($fromDate,$toDate);
       // $fromDate = $this->option('from-date');
        // $toDate = $this->option('to-date');
        if($fromDate && $toDate) {
    
            $response = (new VahanController())->getModelCount($fromDate, $toDate);
	    //dd($response->getContent());

 $summary_proc1 = DB::select('call vahan_dashboard_table_updated()');

 $summary_proc2 = DB::select('call generate_dashboard_summary_dealer_wise()');

            // dd($response->getContent());
            if ($response) {
                // Handle successful response
                $data = json_decode($response->getContent(), true);
                // dd($data);
    
    
    
                $to = 'ajaharuddin.ansari@ifciltd.com';
                $cc= 'sahil.jassal@ifciltd.com';
                $bcc='';
                $subject='Model Count from Vahan Scheduler';
                $from = 'noreply.pmedrive@heavyindustry.gov.in';
                $msg=view('emails.model_count_report', ['results' => $data])->render();
    
                $response = sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);
    
    
                // You can log or process the data here
                \Log::info('Model count data retrieved', $data);
            } else {
                \Log::error('Failed to retrieve model count', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
	dd("inserted");
        }
        dd("no dates");
        
    }
}
