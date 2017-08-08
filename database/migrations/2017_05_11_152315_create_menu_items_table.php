<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->tinyInteger('active');
            $table->tinyInteger('required');
            $table->timestamp('active_from');
            $table->timestamp('active_to');
            $table->string('pos_name');
            $table->string('uom');
            $table->integer('uom_qty_per');
            $table->integer('uom_type_id')->unsigned();
            $table->integer('serve_status_id')->unsigned();
            $table->timestamp('serve_from');
            $table->timestamp('serve_to');

            $table->integer('sync_type_id')->unsigned();
            $table->timestamp('sync_date');

            $table->decimal('projected_unit_sold_mon', 13 ,2);
            $table->decimal('projected_unit_sold_tue', 13, 2);
            $table->decimal('projected_unit_sold_wed', 13, 2);
            $table->decimal('projected_unit_sold_thur', 13, 2);
            $table->decimal('projected_unit_sold_fri', 13 ,2);
            $table->decimal('projected_unit_sold_sat', 13, 2);
            $table->decimal('projected_unit_sold_sun', 13, 2);

            $table->timestamps();

            $table->foreign('uom_type_id')
                  ->references('id')
                  ->on('uom_types')
                  ->onUpdate('cascade');
            $table->foreign('serve_status_id')
                  ->references('id')
                  ->on('serve_status')
                  ->onUpdate('cascade');
            $table->foreign('sync_type_id')
                  ->references('id')
                  ->on('sync_types')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropForeign('menu_items_uom_type_id_foreign');
            $table->dropForeign('menu_items_serve_status_id_foreign');
            $table->dropForeign('menu_items_sync_type_id_foreign');
        });
        Schema::dropIfExists('menu_items');
    }
}
