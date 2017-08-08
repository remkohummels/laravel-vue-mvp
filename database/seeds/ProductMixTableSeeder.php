<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductMixTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_mix')->insert([
            'restaurant_id'         => 1,
            'active'                => 1,
            'menu_item_id'          => 1,
            'unit'                  => 'pieces',
            'monday'                => '970',
            'tuesday'               => '1061',
            'wednesday'             => '935',
            'thursday'              => '1082',
            'friday'                => '1265',
            'saturday'              => '1410',
            'sunday'                => '1337',
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        DB::table('product_mix')->insert([
            'restaurant_id'         => 1,
            'active'                => 1,
            'menu_item_id'          => 2,
            'unit'                  => 'pieces',
            'monday'                => '999',
            'tuesday'               => '1065',
            'wednesday'             => '945',
            'thursday'              => '1412',
            'friday'                => '1200',
            'saturday'              => '1500',
            'sunday'                => '2000',
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        DB::table('product_mix')->insert([
            'restaurant_id'         => 2,
            'active'                => 1,
            'menu_item_id'          => 1,
            'unit'                  => 'pieces',
            'monday'                => '890',
            'tuesday'               => '1099',
            'wednesday'             => '999',
            'thursday'              => '1100',
            'friday'                => '1300',
            'saturday'              => '1500',
            'sunday'                => '1400',
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);
    }
}
