<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolesHistoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('CREATE TRIGGER user_roles_history_trigger AFTER UPDATE ON `user_roles` FOR EACH ROW
                BEGIN
                  INSERT INTO `user_roles_history`
                  (
                        `old_id`,
                        `user_id`,
                        `manage_users`,
                        `manage_menu_items`,
                        `manage_translations`,
                        `old_created_at`,
                        `old_updated_at`,
                        `created_at`,
                        `updated_at`
                    )
                  VALUES (
                        OLD.`id`,
                        OLD.`user_id`,
                        OLD.`manage_users`,
                        OLD.`manage_menu_items`,
                        OLD.`manage_translations`,
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
        DB::unprepared('DROP TRIGGER `user_roles_history_trigger`');
    }
}
