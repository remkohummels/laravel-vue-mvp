<?php

namespace App\Console\Commands;

use App\Models\ProductMix;
use App\Models\ProductMixDefault;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetProductMixDefaultsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:productmixdefaults';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset the product_mix_defaults table every 1:00AM on Monday';

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
        // Delete all rows from 'product_mix_defaults' table
        DB::beginTransaction();
        DB::statement("SET foreign_key_checks=0");
        ProductMixDefault::truncate();
        DB::statement("SET foreign_key_checks=1");
        DB::commit();

        // Get all rows of 'product_mix' table
        $productMixList = ProductMix::all();

        // Insert all rows of 'product_mix' table into the 'product_mix_defaults' table
        foreach ($productMixList as $row) {
            ProductMixDefault::firstOrCreate(['restaurant_id' => $row->restaurant_id, 'menu_item_id' => $row->menu_item_id], $row->toArray() );
        }

        $this->info('Resetting the product_mix_defaults table is done!');
    }
}
