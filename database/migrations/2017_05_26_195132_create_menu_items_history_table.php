<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id');

            $table->string('name');
            $table->tinyInteger('active');
            $table->tinyInteger('required');
            $table->timestamp('active_from');
            $table->timestamp('active_to');
            $table->string('pos_name');
            $table->string('uom');
            $table->integer('uom_qty_per');
            $table->integer('uom_type_id');
            $table->integer('serve_status_id');
            $table->timestamp('serve_from');
            $table->timestamp('serve_to');

            $table->integer('sync_type_id');
            $table->timestamp('sync_date');

            $table->decimal('projected_unit_sold_mon', 13, 2);
            $table->decimal('projected_unit_sold_tue', 13, 2);
            $table->decimal('projected_unit_sold_wed', 13, 2);
            $table->decimal('projected_unit_sold_thur', 13, 2);
            $table->decimal('projected_unit_sold_fri', 13, 2);
            $table->decimal('projected_unit_sold_sat', 13, 2);
            $table->decimal('projected_unit_sold_sun', 13, 2);

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
        Schema::dropIfExists('menu_items_history');
    }
}
