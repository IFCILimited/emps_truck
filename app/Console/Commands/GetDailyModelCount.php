<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\VahanDailyController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class GetDailyModelCount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:model-daily-count';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get daily model counts';

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
        $response = (new VahanDailyController())->getModelCount();
dd($response->getContent());
        if ($response) {
            $data = json_decode($response->getContent(), true);
            // Log::channel('custom')->info('Model count data retrieved', $data);
            dd("inserted");
        }
        // Log::channel('custom')->error('Failed to retrieve model count', [
        //     'status' => $response->status(),
        //     'body' => $response->body(),
        // ]);

        dd("something went wrong !!");
    }
}
