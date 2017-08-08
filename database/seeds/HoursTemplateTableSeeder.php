<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HoursTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hours_templates')->insert([
            'template_name'         => 'Standard',
            'sync_type_id'          => 1,
            'sync_date'             => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('hours_templates')->insert([
            'template_name'         => 'Specific',
            'sync_type_id'          => 1,
            'sync_date'             => Carbon::now()->format('Y-m-d H:i:s'),
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
