<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProjectionOverride extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_projection_override', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurant_id')->length(20);
            $table->integer('menu_item_id')->unsigned();
            $table->integer('value');
            $table->string('frequency');
            $table->date('date');
            $table->time('time');

            $table->timestamps();

            $table->foreign('restaurant_id')
                  ->references('restaurant_id')
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
        Schema::table('product_projection_override', function (Blueprint $table) {
            $table->dropForeign('product_projection_override_restaurant_id_foreign');
            $table->dropForeign('product_projection_override_menu_item_id_foreign');
        });
        Schema::dropIfExists('product_projection_override');
    }
}
