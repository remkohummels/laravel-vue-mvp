<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProjectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_projection', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurant_id')->length(20);
            $table->string('opening_mod');
            $table->string('closing_mod');
            $table->integer('day_projected');
            $table->integer('day_expected');
            $table->integer('day_difference');
            $table->integer('product_projection_hours_template_id')->unsigned();

            $table->timestamps();

            $table->foreign('restaurant_id')
                  ->references('restaurant_id')
                  ->on('restaurants')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('product_projection_hours_template_id')
                  ->references('id')
                  ->on('product_projection_hours_template')
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
        Schema::table('product_projection', function (Blueprint $table) {
            $table->dropForeign('product_projection_restaurant_id_foreign');
            $table->dropForeign('product_projection_product_projection_hours_template_id_foreign');
        });
        Schema::dropIfExists('product_projection');
    }
}
