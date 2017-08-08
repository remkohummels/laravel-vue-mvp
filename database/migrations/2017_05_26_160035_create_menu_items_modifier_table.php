<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsModifierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items_modifier', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_item_id')->unsigned();
            $table->string('name');
            $table->tinyInteger('active');
            $table->timestamp('active_from');
            $table->timestamp('active_to');
            $table->integer('adjustment');

            $table->timestamps();

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
        Schema::table('menu_items_modifier', function (Blueprint $table) {
            $table->dropForeign('menu_items_modifier_menu_item_id_foreign');
        });
        Schema::dropIfExists('menu_items_modifier');
    }
}
