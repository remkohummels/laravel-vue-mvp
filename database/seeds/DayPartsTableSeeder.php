<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\DayPart;

class DayPartsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $daysoftheweek = array(
            'monday',
            'tuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
            'sunday'
        );

        $template1 = array(
            array(
                'day_part'                  => 'lunch',
                'day_part_order'            => 1,
                'start_time'                => '10:00:00',
                'end_time'                  => '14:00:00',
                'shift'                     => 'opening',
            ),
            array(
                'day_part'                  => 'snack',
                'day_part_order'            => 2,
                'start_time'                => '14:00:00',
                'end_time'                  => '17:00:00',
                'shift'                     => 'opening',
            ),
            array(
                'day_part'                  => 'dinner',
                'day_part_order'            => 3,
                'start_time'                => '17:00:00',
                'end_time'                  => '20:00:00',
                'shift'                     => 'closing',
            ),
            array(
                'day_part'                  => 'late night',
                'day_part_order'            => 4,
                'start_time'                => '20:00:00',
                'end_time'                  => '22:00:00',
                'shift'                     => 'closing',
            )
        );

        $template2 = array(
            array(
                'day_part'                  => 'lunch',
                'day_part_order'            => 1,
                'start_time'                => '10:00:00',
                'end_time'                  => '14:00:00',
                'shift'                     => 'opening',
            ),
            array(
                'day_part'                  => 'snack',
                'day_part_order'            => 2,
                'start_time'                => '14:00:00',
                'end_time'                  => '17:00:00',
                'shift'                     => 'opening',
            ),
            array(
                'day_part'                  => 'dinner',
                'day_part_order'            => 3,
                'start_time'                => '17:00:00',
                'end_time'                  => '20:00:00',
                'shift'                     => 'closing',
            ),
            array(
                'day_part'                  => 'late night',
                'day_part_order'            => 4,
                'start_time'                => '20:00:00',
                'end_time'                  => '22:00:00',
                'shift'                     => 'closing',
            ),
            array(
                'day_part'                  => 'graveyard',
                'day_part_order'            => 5,
                'start_time'                => '22:00:00',
                'end_time'                  => '06:00:00',
                'shift'                     => 'closing',
            ),
            array(
                'day_part'                  => 'breakfast',
                'day_part_order'            => 6,
                'start_time'                => '06:00:00',
                'end_time'                  => '10:00:00',
                'shift'                     => 'closing',
            )
        );


        foreach($daysoftheweek as $weekday){

            foreach($template1 as $dayparts){

                $row = array(
                    'hours_template_id'         => 1,
                    'dayofweek'                 => $weekday,
                    'day_part'                  => $dayparts['day_part'],
                    'day_part_order'            => $dayparts['day_part_order'],
                    'start_time'                => $dayparts['start_time'],
                    'end_time'                  => $dayparts['end_time'],
                    'shift'                     => $dayparts['shift'],
                    'created_at'                => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'                => Carbon::now()->format('Y-m-d H:i:s'),
                );

                DayPart::updateOrCreate(['hours_template_id' => 1, 'dayofweek' => $weekday, 'day_part' => $dayparts['day_part'] ], $row);

            };

            foreach($template2 as $dayparts){
                $row = array(
                    'hours_template_id'         => 2,
                    'dayofweek'                 => $weekday,
                    'day_part'                  => $dayparts['day_part'],
                    'day_part_order'            => $dayparts['day_part_order'],
                    'start_time'                => $dayparts['start_time'],
                    'end_time'                  => $dayparts['end_time'],
                    'shift'                     => $dayparts['shift'],
                    'created_at'                => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at'                => Carbon::now()->format('Y-m-d H:i:s'),
                );

                DayPart::updateOrCreate(['hours_template_id' => 2, 'dayofweek' => $weekday, 'day_part' => $dayparts['day_part'] ], $row);

            };
        };

    }
}
