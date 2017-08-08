<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductProjectionHoursTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('product_projection_hours_template')->insert([
            'template_name'             => 1,
            'created_at'                => Carbon::now(),
            'updated_at'                => Carbon::now()
        ]);
    }
}
