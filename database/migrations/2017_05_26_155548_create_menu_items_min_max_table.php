<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsMinMaxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items_min_max', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_item_id')->unsigned();
            $table->time('time');
            $table->tinyInteger('min');
            $table->tinyInteger('max');

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
        Schema::table('menu_items_min_max', function (Blueprint $table) {
            $table->dropForeign('menu_items_min_max_menu_item_id_foreign');
        });
        Schema::dropIfExists('menu_items_min_max');
    }
}
