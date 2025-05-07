<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\VahanDailyUpdatedController;
use DB;

class GetDailyModelCountUpdated extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:model-daily-count-up {--status= : status to be fetched}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vahan api model count as per new format';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $status = $this->option('status');
        $toFetchApproved = true;
        $tableName = 'vahan_api_model_data_approved_temp';
        $tableMain = 'vahan_api_model_data_approved';
        if($status){
            $toFetchApproved = false;
            $tableName = 'vahan_api_model_data_unapproved_temp';
            $tableMain = 'vahan_api_model_data_unapproved';
        }
        $results = [];

            // dd($results); 
        $response = (new VahanDailyUpdatedController())->getModelCount($toFetchApproved);
        // dd($response);
        
        if ($response) {

            foreach(array('previous', 'latest') as $type){
                $table = $tableName;
                if($type == 'previous'){
                    $table = $tableMain;
                }
                $results[$type] = DB::table($table)
                ->select('portal_segemt_id', 'portal_category_id', 'portal_category_name')
                ->selectRaw('sum(vahan_numberofvehiclesregistered)')
                ->selectRaw('min(api_from_date)')
                ->selectRaw('max(api_from_date)')
                ->groupBy('portal_segemt_id', 'portal_category_id', 'portal_category_name')
                ->orderBy('portal_category_id')
                ->get();
            }
            // dd($results);

            // $data = json_decode($response->getContent(), true);
            
            $to = 'ajaharuddin.ansari@ifciltd.com';
            $cc= 'sahil.jassal@ifciltd.com';
            $bcc='';
            $subject='Model Count from Vahan Scheduler';
            $from = 'noreply.pmedrive@heavyindustry.gov.in';
            $msg=view('emails.model_count_report_updated', ['results' => $results, 'type' => $toFetchApproved])->render();

            $response = sendEmailNic($to,$cc,$bcc,$subject,$from,$msg);
        }
        return 0;
    }
}
