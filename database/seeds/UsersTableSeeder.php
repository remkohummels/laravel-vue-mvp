<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name'            => 'Church',
            'middle_name'           => 'S',
            'last_name'             => 'Chicken',
            'active'                => 1,
            'user_type_id'          => 1,
            'password'              => Hash::make('chuchic'),
            'password_reset'        => 0,
            'email'                 => 'church@chicken.com',
            'phone'                 => '5555555555',
            'sync_type_id'          => 1,
            'sync_date'             => Carbon::now()->format('Y-m-d H:i:s'),
            'notes'                 => '',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'first_name'            => 'Church',
            'middle_name'           => 'S',
            'last_name'             => 'Chicken',
            'active'                => 1,
            'user_type_id'          => 2,
            'password'              => Hash::make('chuchic'),
            'password_reset'        => 0,
            'email'                 => 'steelbridge1020@outlook.com',
            'phone'                 => '5555555555',
            'sync_type_id'          => 2,
            'sync_date'             => Carbon::now()->format('Y-m-d H:i:s'),
            'notes'                 => '',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // RELATIONS USER to RESTAURANT
        DB::table('relations_user_to_restaurant')->insert([
            'user_id'          => 1,
            'restaurant_id'    => 1,
            'view'             => 1,
            'edit'             => 1,
            'make_inactive'    => 1,
            'created_at'       => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'       => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('relations_user_to_restaurant')->insert([
            'user_id'          => 1,
            'restaurant_id'    => 2,
            'view'             => 1,
            'edit'             => 1,
            'make_inactive'    => 1,
            'created_at'       => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'       => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('relations_user_to_restaurant')->insert([
            'user_id'          => 2,
            'restaurant_id'    => 2,
            'view'             => 1,
            'edit'             => 1,
            'make_inactive'    => 1,
            'created_at'       => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'       => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // RELATIONS USER to MENU ITEMS
        DB::table('relations_user_to_menu_item')->insert([
            'user_id'          => 1,
            'menu_item_id'     => 1,
            'view'             => 1,
            'edit'             => 1,
            'assign_rest'      => 1,
            'created_at'       => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'       => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('relations_user_to_menu_item')->insert([
            'user_id'          => 1,
            'menu_item_id'     => 2,
            'view'             => 1,
            'edit'             => 1,
            'assign_rest'      => 1,
            'created_at'       => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'       => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('relations_user_to_menu_item')->insert([
            'user_id'          => 2,
            'menu_item_id'     => 1,
            'view'             => 1,
            'edit'             => 1,
            'assign_rest'      => 1,
            'created_at'       => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'       => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
