<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenuItemsMinMaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '06:00:00',
            'min'            => 0,
            'max'            => 10,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '06:30:00',
            'min'            => 0,
            'max'            => 90,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '07:00:00',
            'min'            => 0,
            'max'            => 120,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '07:30:00',
            'min'            => 0,
            'max'            => 120,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '08:00:00',
            'min'            => 4,
            'max'            => 120,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '08:30:00',
            'min'            => 10,
            'max'            => 300,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '09:00:00',
            'min'            => 10,
            'max'            => 340,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '09:30:00',
            'min'            => 10,
            'max'            => 150,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '10:00:00',
            'min'            => 10,
            'max'            => 80,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '10:30:00',
            'min'            => 10,
            'max'            => 160,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '11:00:00',
            'min'            => 30,
            'max'            => 225,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '11:30:00',
            'min'            => 40,
            'max'            => 500,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '12:00:00',
            'min'            => 10,
            'max'            => 300,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('menu_items_min_max')->insert([
            'menu_item_id'   => 1,
            'time'           => '12:30:00',
            'min'            => 5,
            'max'            => 10,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);






    }
}
