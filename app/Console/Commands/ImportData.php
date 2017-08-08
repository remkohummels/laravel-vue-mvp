<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\ImportDataController;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:importdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        ImportDataController::type('sales');
        $this->info('sales input done!');

        ImportDataController::type('menumix');
        $this->info('menu mix done!');

        ImportDatacontroller::type('restaurant_hours');
        $this->info('hours of operation done');

        $this->info('DONE!');
    }
}
