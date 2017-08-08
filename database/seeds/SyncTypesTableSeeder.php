<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SyncTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sync_types')->insert([
            'name'                  => 'Sync with Hierarchy Report',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('sync_types')->insert([
            'name'                  => 'Never Sync with Hierarchy Report',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('sync_types')->insert([
            'name'                  => 'Start Sync on Date:',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
