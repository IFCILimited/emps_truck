<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;


class RunDashboardProcedure extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:generate-dashboard-summary';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate dashboard summary';

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
        // call procedure
        // $summary_proc1 = DB::select('call vahan_manage_table()');
        $summary_proc3 = DB::select('call vahan_dashboard_table_updated_new()');
        $summary_proc2 = DB::select('select calculateandinsertclaimfuelco2()');
        
        return 0;
    }
}
