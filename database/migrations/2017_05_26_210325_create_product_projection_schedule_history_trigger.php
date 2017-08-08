<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProjectionScheduleHistoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER product_projection_schedule_history_trigger AFTER UPDATE ON `product_projection_schedule` FOR EACH ROW
                BEGIN
            	    INSERT INTO `product_projection_schedule_history`
            	    (
            	        `old_id`,
                        `product_projection_id`,
                        `active`,
                        `menu_item_id`,
                        `0100`,
                        `0200`,
                        `0300`,
                        `0400`,
                        `0500`,
                        `0600`,
                        `0700`,
                        `0800`,
                        `0900`,
                        `1000`,
                        `1100`,
                        `1200`,
                        `1300`,
                        `1400`,
                        `1500`,
                        `1600`,
                        `1700`,
                        `1800`,
                        `1900`,
                        `2000`,
                        `2100`,
                        `2200`,
                        `2300`,
                        `2400`,
                        `old_created_at`,
                        `old_updated_at`,
                        `created_at`,
                        `updated_at`
                    )
            	    VALUES (
            	        OLD.`id`,
            	        OLD.`product_projection_id`,
            	        OLD.`active`,
            	        OLD.`menu_item_id`,
            	        OLD.`0100`,
            	        OLD.`0200`,
            	        OLD.`0300`,
            	        OLD.`0400`,
            	        OLD.`0500`,
            	        OLD.`0600`,
            	        OLD.`0700`,
            	        OLD.`0800`,
            	        OLD.`0900`,
            	        OLD.`1000`,
            	        OLD.`1100`,
            	        OLD.`1200`,
            	        OLD.`1300`,
            	        OLD.`1400`,
            	        OLD.`1500`,
            	        OLD.`1600`,
            	        OLD.`1700`,
            	        OLD.`1800`,
            	        OLD.`1900`,
            	        OLD.`2000`,
            	        OLD.`2100`,
            	        OLD.`2200`,
            	        OLD.`2300`,
            	        OLD.`2400`,
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
        DB::unprepared('DROP TRIGGER `product_projection_schedule_history_trigger`');
    }
}
