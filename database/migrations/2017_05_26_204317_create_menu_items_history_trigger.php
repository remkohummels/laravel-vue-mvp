<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsHistoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER menu_items_history_trigger AFTER UPDATE ON `menu_items` FOR EACH ROW
                BEGIN
            	    INSERT INTO `menu_items_history`
            	    (
            	        `old_id`,
                        `name`,
                        `active`,
                        `required`,
                        `active_from`,
                        `active_to`,
                        `pos_name`,
                        `uom`,
                        `uom_qty_per`,
                        `uom_type_id`,
                        `serve_status_id`,
                        `serve_from`,
                        `serve_to`,
                        `sync_type_id`,
                        `sync_date`,
                        `projected_unit_sold_mon`,
                        `projected_unit_sold_tue`,
                        `projected_unit_sold_wed`,
                        `projected_unit_sold_thur`,
                        `projected_unit_sold_fri`,
                        `projected_unit_sold_sat`,
                        `projected_unit_sold_sun`,
                        `old_created_at`,
                        `old_updated_at`,
                        `created_at`,
                        `updated_at`
                    )
            	    VALUES (
            	        OLD.`id`,
                        OLD.`name`,
                        OLD.`active`,
                        OLD.`required`,
                        OLD.`active_from`,
                        OLD.`active_to`,
                        OLD.`pos_name`,
                        OLD.`uom`,
                        OLD.`uom_qty_per`,
                        OLD.`uom_type_id`,
                        OLD.`serve_status_id`,
                        OLD.`serve_from`,
                        OLD.`serve_to`,
                        OLD.`sync_type_id`,
                        OLD.`sync_date`,
                        OLD.`projected_unit_sold_mon`,
                        OLD.`projected_unit_sold_tue`,
                        OLD.`projected_unit_sold_wed`,
                        OLD.`projected_unit_sold_thur`,
                        OLD.`projected_unit_sold_fri`,
                        OLD.`projected_unit_sold_sat`,
                        OLD.`projected_unit_sold_sun`,
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
        DB::unprepared('DROP TRIGGER `menu_items_history_trigger`');
    }
}
