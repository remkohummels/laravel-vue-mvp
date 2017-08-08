<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersHistoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER users_history_trigger AFTER UPDATE ON `users` FOR EACH ROW
                BEGIN
            	    INSERT INTO `users_history`
            	    (
            	        `old_id`,
                        `first_name`,
                        `middle_name`,
                        `last_name`,
                        `active`,
                        `user_type_id`,
                        `password`,
                        `password_reset`,
                        `email`,
                        `phone`,
                        `sync_type_id`,
                        `sync_date`,
                        `notes`,
                        `old_created_at`,
                        `old_updated_at`,
                        `created_at`,
                        `updated_at`
                    )
            	    VALUES (
            	        OLD.`id`,
                        OLD.`first_name`,
                        OLD.`middle_name`,
                        OLD.`last_name`,
                        OLD.`active`,
                        OLD.`user_type_id`,
                        OLD.`password`,
                        OLD.`password_reset`,
                        OLD.`email`,
                        OLD.`phone`,
                        OLD.`sync_type_id`,
                        OLD.`sync_date`,
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
        DB::unprepared('DROP TRIGGER `users_history_trigger`');
    }
}
