<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CurrencyFormatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currency_formats')->insert([
            'name'                  => 'USD',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('currency_formats')->insert([
            'name'                  => 'GBP',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
