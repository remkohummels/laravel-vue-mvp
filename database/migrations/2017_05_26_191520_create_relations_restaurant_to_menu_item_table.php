<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationsRestaurantToMenuItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations_restaurant_to_menu_item', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurant_id')->length(20);
            $table->integer('menu_item_id')->unsigned();
            $table->tinyInteger('associate');

            $table->timestamps();

            $table->foreign('restaurant_id')
                  ->references('restaurant_id')
                  ->on('restaurants')
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
        Schema::table('relations_restaurant_to_menu_item', function (Blueprint $table) {
            $table->dropForeign('relations_restaurant_to_menu_item_restaurant_id_foreign');
            $table->dropForeign('relations_restaurant_to_menu_item_menu_item_id_foreign');
        });
        Schema::dropIfExists('relations_restaurant_to_menu_item');
    }
}
