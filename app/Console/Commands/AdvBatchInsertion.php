<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdvConnectorController;
use Illuminate\Http\Request;



class AdvBatchInsertion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:adv-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert all aadhar details in ADV';

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
        
        // DB::transaction(function (){
            $tableName = "buyer_session as dst";
            // $total = DB::table($tableName)->distinct('aadhaar')->count();
                $total = DB::table($tableName)
                ->select(
                    'dst.aadhaar',
                    'dst.buyer_id',
                    'adt.buyer_id as adt_buyer_id',
                    'adt.rtoken'
                )->leftJoin('adv_data_token as adt', DB::raw('adt.buyer_id::int8'), '=', DB::raw('dst.buyer_id::int8'))
                ->distinct('dst.aadhaar')
                ->whereNull('adt.buyer_id')
                ->count();
                // ->toSql();

                $start = 1;
                // DB::table($tableName)
                //     ->select('aadhaar', 'buyer_id')
                //     ->distinct('aadhaar')
                //     ->orderBy('aadhaar')
                DB::table($tableName)
                ->select(
                    'dst.aadhaar',
                    'dst.buyer_id',
                    'adt.buyer_id as adt_buyer_id',
                    'adt.rtoken'
                )
                ->leftJoin('adv_data_token as adt', DB::raw('adt.buyer_id::int8'), '=', DB::raw('dst.buyer_id::int8'))
                ->whereNull('adt.buyer_id')
                ->distinct('dst.aadhaar')
                ->orderBy('dst.aadhaar')
                ->chunk(1000, function ($addhaars)  use (&$start, $total) {

                    $buyerIds = $addhaars->pluck('buyer_id');
    
                    $buyerDetails = DB::table('buyer_details')
                        ->whereIn('buyer_id', $buyerIds)
                        ->where('adh_verify', 'Y')
                        ->pluck('id', 'buyer_id');
                        // dd($buyerDetails);
    
                    foreach ($addhaars as $addhaar) {
                        print_r("processing record........".$addhaar->buyer_id."...............".$start."/".$total."\n");
    
                        if (isset($buyerDetails[$addhaar->buyer_id])) {
                            $advController = new AdvConnectorController();
                                $advRequest = new Request([
                                    "aadhar_number" => $addhaar->aadhaar,
                                    "buyer_id" => $addhaar->buyer_id
                                ]);
                             $rtoken = $advController->storeAadharNumber($advRequest);
    
                             if ($rtoken->original["status"] == "1") {
                                //token created
                                $token = $rtoken->original["message"]["token"];
    
                                DB::table('buyer_details')
                                ->where('id', $buyerDetails[$addhaar->buyer_id])
                                ->update(['rtoken' => $token]);
                            }else{
                                print_r("ERROR WHILE FETCHING ADV TOKEN FOR ".$addhaar."----".$rtoken->original['message']);
                            }
                        }else{
                            // print_r("Buyer Id not exist.......".$addhaar->buyer_id."..........".$addhaar->aadhaar."........\n");
                        }
                        // dd("record updated");
    
                        $start++;
                    }
                });

            print_r("processing completed :) \n");

            print_r("Updating existing records..........\n");

            $up = 1;

            $toUpdateRecord = DB::table('buyer_details as bd')
            ->select('bd.id', 'bd.buyer_id', 'adt.buyer_id as adt_buyer_id', 'adt.rtoken as adt_rtoken', 'bd.rtoken')
            ->join(DB::raw('(' . DB::table('adv_data_token')
                ->select('buyer_id', 'rtoken')
                ->distinct()
                ->toSql() . ') as adt'), 'adt.buyer_id', '=', 'bd.buyer_id')
            ->where('bd.adh_verify', 'Y')
            ->orderBy('bd.buyer_id')
            ->count();
            // dd($toUpdateRecord);

            DB::table('buyer_details as bd')
            ->select('bd.id', 'bd.buyer_id', 'adt.buyer_id as adt_buyer_id', 'adt.rtoken as adt_rtoken', 'bd.rtoken')
            ->join(DB::raw('(' . DB::table('adv_data_token')
                ->select('buyer_id', 'rtoken')
                ->distinct()
                ->toSql() . ') as adt'), 'adt.buyer_id', '=', 'bd.buyer_id')
            ->where('bd.adh_verify', 'Y')
            ->orderBy('bd.buyer_id')
            ->chunk(10000, function ($chunk) use(&$up, $toUpdateRecord) {
                // AdvBatchInsertJob::dispatch($chunk);
                
                foreach ($chunk as $row) {
                    print_r("update loop started-------".$up."/".$toUpdateRecord."\n");
                    // dd($row);
                    if(is_null($row->rtoken)) {
                        DB::table('buyer_details')
                            ->where('id', $row->id)
                            ->update(['rtoken' => $row->adt_rtoken]);
                    } 
                    $up++;
                }
            });
            print_r("Updating existing completed..........\n");
        // });
    }
}
