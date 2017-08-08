<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductMixTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_mix', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurant_id')->length(20);
            $table->tinyInteger('active');
            $table->integer('menu_item_id')->unsigned();
            $table->string('unit');
            $table->string('monday');
            $table->string('tuesday');
            $table->string('wednesday');
            $table->string('thursday');
            $table->string('friday');
            $table->string('saturday');
            $table->string('sunday');

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
        Schema::table('product_mix', function (Blueprint $table) {
            $table->dropForeign('product_mix_restaurant_id_foreign');
            $table->dropForeign('product_mix_menu_item_id_foreign');
        });
        Schema::dropIfExists('product_mix');
    }
}
