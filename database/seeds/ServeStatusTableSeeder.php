<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ServeStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('serve_status')->insert([
            'name'                  => 'serve all day',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('serve_status')->insert([
            'name'                  => 'serve between',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
