<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RestaurantTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('restaurant_types')->insert([
            'name'                  => 'company',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('restaurant_types')->insert([
            'name'                  => 'franchise',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('restaurant_types')->insert([
            'name'                  => 'international',
            'created_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            =>  Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
