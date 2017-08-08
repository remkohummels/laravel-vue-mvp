<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsHistoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER restaurants_history_trigger AFTER UPDATE ON `restaurants` FOR EACH ROW
                BEGIN
            	    INSERT INTO `restaurants_history`
            	    (
            	        `old_id`,
            	        `restaurant_id`,
                        `sync_type_id`,
                        `sync_date`,
                        `timezone`,
                        `hours_template_id`,
                        `currency_format_id`,
                        `country`,
                        `state`,
                        `dma`,
                        `restaurant_type_id`,
                        `password_required`,
                        `password`,
                        `password_reset`,
                        `notes`,
                        `old_created_at`,
                        `old_updated_at`,
                        `created_at`,
                        `updated_at`
                    )
            	    VALUES (
            	        OLD.`id`,
            	        OLD.`restaurant_id`,
                        OLD.`sync_type_id`,
                        OLD.`sync_date`,
                        OLD.`timezone`,
                        OLD.`hours_template_id`,
                        OLD.`currency_format_id`,
                        OLD.`country`,
                        OLD.`state`,
                        OLD.`dma`,
                        OLD.`restaurant_type_id`,
                        OLD.`password_required`,
                        OLD.`password`,
                        OLD.`password_reset`,
                        OLD.`notes`,
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
        DB::unprepared('DROP TRIGGER `restaurants_history_trigger`');
    }
}
