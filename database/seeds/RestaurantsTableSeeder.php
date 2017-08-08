<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\ErrorLogs as ErrorLogDB;
use App\Models\Restaurant;


class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restaurant::updateOrCreate(array('restaurant_id'=> 1), [
            'restaurant_id'         => '1',
            'sync_type_id'          => 1,
            'sync_date'             => Carbon::now()->format('Y-m-d H:i:s'),
            'timezone'              => 'GMT-4',
            'hours_template_id'     => 1,
            'currency_format_id'    => 1,
            'country'               => 'US',
            'state'                 => 'FL',
            'dma'                   => 999,
            'email'                 => 'steelbridge1020@gmail.com',
            'restaurant_type_id'    => 1,
            'password_required'     => 1,
            'password'              => Hash::make('chuchic'),
            'password_reset'        => 0,
            'notes'                 => '',
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $passwords = array(
            10776   => 'P.Francis',
            11021   => 'H.Mustafa',
            11019   => 'N.Sayed',
            4921    => 'O.Karla',
            3940    => 'P.Garcia',
            10388   => 'A.Perez',
            1830    => 'M.Bautista',
            10777   => 'J.Eduardo'
        );

        $restaurantData = array();
        $restaurantData[1] = DB::select('SELECT * FROM company_locations');
        $restaurantData[2] = DB::select('SELECT * FROM franchise_locations');
        $restaurantData[3] = DB::select('SELECT * FROM international_locations');

        foreach($restaurantData as $rest_type => $results) {
            foreach ($results as $row) {

                $row = (array)$row;

                try {

                    switch($rest_type){

                        case 1; // Company
                            $data = array(
                                'restaurant_id'         => $row['Rest #'],
                                'sync_type_id'          => 1,
                                'timezone'              => 'GMT-4',
                                'hours_template_id'     => 1,
                                'currency_format_id'    => 1,
                                'country'               => 'US',
                                'state'                 => $row['State'],
                                'city'                  => $row['City'],
                                'zip'                   => $row['Zip'],
                                'dma'                   => $row['DMA #'],
                                'email'                 => $row['Restaurant Email'],
                                'restaurant_type_id'    => $rest_type,
                                'password_required'     => 0,
                                'notes'                 => '',
                                'created_at'            => Carbon::now(),
                                'updated_at'            => Carbon::now()
                            );
                            break;
                        case 2; // Franchise
                            $data = array(
                                'restaurant_id'         => $row['Rest #'],
                                'sync_type_id'          => 1,
                                'timezone'              => 'GMT-4',
                                'hours_template_id'     => 1,
                                'currency_format_id'    => 1,
                                'country'               => 'US',
                                'state'                 => $row['State'],
                                'city'                  => $row['City'],
                                'zip'                   => $row['Zip'],
                                'dma'                   => $row['DMA #'],
                                'email'                 => $row['FRN Restaurant email'],
                                'restaurant_type_id'    => $rest_type,
                                'password_required'     => 0,
                                'notes'                 => '',
                                'created_at'            => Carbon::now(),
                                'updated_at'            => Carbon::now()
                            );
                            break;
                        case 3; // International
                            $data = array(
                                'restaurant_id'         => $row['Rest #'],
                                'sync_type_id'          => 1,
                                'timezone'              => 'GMT-4',
                                'hours_template_id'     => $row['Rest #'] == '11019' ? 2 : 1,
                                'currency_format_id'    => 1,
                                'country'               => $row['Country'],
                                'state'                 => 0,
                                'city'                  => $row['City'],
                                'zip'                   => $row['Zip'],
                                'dma'                   => 0,
                                'email'                 => $row['Restaurant Email'],
                                'restaurant_type_id'    => $rest_type,
                                'password_required'     => 0,
                                'notes'                 => '',
                                'created_at'            => Carbon::now(),
                                'updated_at'            => Carbon::now()
                            );
                            break;

                    }

                    if( array_key_exists($data['restaurant_id'], $passwords) ){
                        $data['password_required'] = 1;
                        $data['password'] =  Hash::make($passwords[$data['restaurant_id']]);
                        $data['password_reset'] = 0;
                    }



                    Restaurant::updateOrCreate(array('restaurant_id'=> $data['restaurant_id']), $data);


                    // If there is a Query Error which inserting, run the following
                } catch (\Illuminate\Database\QueryException $ex) {
                    // Add the query error to an errorlog table in the DB
                    ErrorLogDB::create(['function' => 'Restaurant Seeder', 'error' => 'MESSAGE: ' . $ex->getMessage() . '

                     TRACE: ' . $ex->getTraceAsString()]);
                }
            }
        }


        // RELATIONS relations_restaurant_to_menu_item

        DB::table('relations_restaurant_to_menu_item')->insert([
            'restaurant_id'         => 2,
            'menu_item_id'          => 1,
            'associate'             => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('relations_restaurant_to_menu_item')->insert([
            'restaurant_id'         => 2,
            'menu_item_id'          => 2,
            'associate'             => 1,
            'created_at'            => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'            => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
