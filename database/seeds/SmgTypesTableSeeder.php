<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SmgTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('smg_types')->insert([
            'name'                  => 'cw',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('smg_types')->insert([
            'name'                  => 'pw',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('smg_types')->insert([
            'name'                  => 'system',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('smg_types')->insert([
            'name'                  => 'system_int',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
