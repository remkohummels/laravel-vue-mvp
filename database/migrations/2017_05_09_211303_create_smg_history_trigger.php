<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmgHistoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER smg_history_trigger AFTER UPDATE ON `smg` FOR EACH ROW

              BEGIN
            	    INSERT INTO `smg_history`
            	    (
                        `old_id`,
                        `type_id`,
                        `store`,
                        `count`,
                        `overall_satisfaction_score`,
                        `overall_satisfaction_n`,
                        `taste_of_food_score`,
                        `taste_of_food_n`,
                        `speed_of_service_score`,
                        `speed_of_service_n`,
                        `old_created_at`,
                        `old_updated_at`,
                        `created_at`,
                        `updated_at`
                    )
            	    VALUES (
                        OLD.`id`,
                        OLD.`type_id`,
                        OLD.`store`,
                        OLD.`count`,
                        OLD.`overall_satisfaction_score`,
                        OLD.`overall_satisfaction_n`,
                        OLD.`taste_of_food_score`,
                        OLD.`taste_of_food_n`,
                        OLD.`speed_of_service_score`,
                        OLD.`speed_of_service_n`,
                        OLD.`created_at`,
                        OLD.`updated_at`,
                        NOW(),
                        NOW()
                    );
                END'

        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `smg_history_trigger`');

    }
}
