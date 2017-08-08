<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationsUserToMenuItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations_user_to_menu_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('menu_item_id')->unsigned();
            $table->tinyInteger('view');
            $table->tinyInteger('edit');
            $table->tinyInteger('assign_rest');

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('menu_item_id')
                  ->references('id')
                  ->on('menu_items')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('relations_user_to_menu_item', function (Blueprint $table) {
            $table->dropForeign('relations_user_to_menu_item_user_id_foreign');
            $table->dropForeign('relations_user_to_menu_item_menu_item_id_foreign');
        });
        Schema::dropIfExists('relations_user_to_menu_item');
    }
}
