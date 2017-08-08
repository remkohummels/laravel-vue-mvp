<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProjectionScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_projection_schedule', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_projection_id')->unsigned();
            $table->tinyInteger('active');
            $table->integer('menu_item_id')->unsigned();
            $table->decimal('0100', 13, 2);
            $table->decimal('0130', 13, 2);
            $table->decimal('0200', 13, 2);
            $table->decimal('0230', 13, 2);
            $table->decimal('0300', 13, 2);
            $table->decimal('0330', 13, 2);
            $table->decimal('0400', 13, 2);
            $table->decimal('0430', 13, 2);
            $table->decimal('0500', 13, 2);
            $table->decimal('0530', 13, 2);
            $table->decimal('0600', 13, 2);
            $table->decimal('0630', 13, 2);
            $table->decimal('0700', 13, 2);
            $table->decimal('0730', 13, 2);
            $table->decimal('0800', 13, 2);
            $table->decimal('0830', 13, 2);
            $table->decimal('0900', 13, 2);
            $table->decimal('0930', 13, 2);
            $table->decimal('1000', 13, 2);
            $table->decimal('1030', 13, 2);
            $table->decimal('1100', 13, 2);
            $table->decimal('1130', 13, 2);
            $table->decimal('1200', 13, 2);
            $table->decimal('1230', 13, 2);
            $table->decimal('1300', 13, 2);
            $table->decimal('1330', 13, 2);
            $table->decimal('1400', 13, 2);
            $table->decimal('1430', 13, 2);
            $table->decimal('1500', 13, 2);
            $table->decimal('1530', 13, 2);
            $table->decimal('1600', 13, 2);
            $table->decimal('1630', 13, 2);
            $table->decimal('1700', 13, 2);
            $table->decimal('1730', 13, 2);
            $table->decimal('1800', 13, 2);
            $table->decimal('1830', 13, 2);
            $table->decimal('1900', 13, 2);
            $table->decimal('1930', 13, 2);
            $table->decimal('2000', 13, 2);
            $table->decimal('2030', 13, 2);
            $table->decimal('2100', 13, 2);
            $table->decimal('2130', 13, 2);
            $table->decimal('2200', 13, 2);
            $table->decimal('2230', 13, 2);
            $table->decimal('2300', 13, 2);
            $table->decimal('2330', 13, 2);
            $table->decimal('2400', 13, 2);
            $table->decimal('2430', 13, 2);

            $table->timestamps();

            $table->foreign('product_projection_id')
                  ->references('id')
                  ->on('product_projection')
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
        Schema::table('product_projection_schedule', function (Blueprint $table) {
            $table->dropForeign('product_projection_schedule_product_projection_id_foreign');
            $table->dropForeign('product_projection_schedule_menu_item_id_foreign');
        });
        Schema::dropIfExists('product_projection_schedule');
    }
}
