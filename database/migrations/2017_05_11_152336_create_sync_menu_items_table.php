<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyncMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sync_menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_item_id')->unsigned();
            $table->string('hierarchy_report');
            $table->string('hierarchy_column');
            $table->string('hierarchy_value');

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
        Schema::table('sync_menu_items', function (Blueprint $table) {
            $table->dropForeign('sync_menu_items_menu_item_id_foreign');
        });
        Schema::dropIfExists('sync_menu_items');
    }
}
