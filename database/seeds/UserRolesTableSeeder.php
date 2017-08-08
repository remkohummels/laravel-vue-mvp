<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([
            'user_id'               => 1,
            'manage_users'          => 1,
            'manage_menu_items'     => 1,
            'manage_translations'   => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('user_roles')->insert([
            'user_id'               => 2,
            'manage_users'          => 1,
            'manage_menu_items'     => 0,
            'manage_translations'   => 0,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
