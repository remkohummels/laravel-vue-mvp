<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserRolesHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id');
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('manage_users');
            $table->tinyInteger('manage_menu_items');
            $table->tinyInteger('manage_translations');

            $table->timestamp('old_created_at');
            $table->timestamp('old_updated_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles_history');
    }
}
