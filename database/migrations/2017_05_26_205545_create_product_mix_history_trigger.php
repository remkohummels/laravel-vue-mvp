<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductMixHistoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER product_mix_history_trigger AFTER UPDATE ON `product_mix` FOR EACH ROW
                BEGIN
            	    INSERT INTO `product_mix_history`
            	    (
            	        `old_id`,
                        `restaurant_id`,
                        `active`,
                        `menu_item_id`,
                        `unit`,
                        `monday`,
                        `tuesday`,
                        `wednesday`,
                        `thursday`,
                        `friday`,
                        `saturday`,
                        `sunday`,
                        `old_created_at`,
                        `old_updated_at`,
                        `created_at`,
                        `updated_at`
                    )
            	    VALUES (
            	        OLD.`id`,
                        OLD.`restaurant_id`,
                        OLD.`active`,
                        OLD.`menu_item_id`,
                        OLD.`unit`,
                        OLD.`monday`,
                        OLD.`tuesday`,
                        OLD.`wednesday`,
                        OLD.`thursday`,
                        OLD.`friday`,
                        OLD.`saturday`,
                        OLD.`sunday`,
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
        DB::unprepared('DROP TRIGGER `product_mix_history_trigger`');
    }
}
