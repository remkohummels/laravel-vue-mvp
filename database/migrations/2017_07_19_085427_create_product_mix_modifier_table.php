<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductMixModifierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_mix_modifier', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_mix_id')->unsigned();
            $table->string('restaurant_id')->length(20);
            $table->string('name');

            $table->timestamps();

            $table->foreign('product_mix_id')
                    ->references('id')
                    ->on('product_mix')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreign('restaurant_id')
                    ->references('restaurant_id')
                    ->on('restaurants')
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
        Schema::table('product_mix_modifier', function (Blueprint $table) {
            $table->dropForeign('product_mix_modifier_product_mix_id_foreign');
            $table->dropForeign('product_mix_modifier_restaurant_id_foreign');
        });
        Schema::dropIfExists('product_mix_modifier');
    }
}
