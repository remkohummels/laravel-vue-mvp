<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationsUserToRestaurantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relations_user_to_restaurant', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('restaurant_id')->length(20);
            $table->tinyInteger('view');
            $table->tinyInteger('edit');
            $table->tinyInteger('make_inactive');

            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
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
        Schema::table('relations_user_to_restaurant', function (Blueprint $table) {
            $table->dropForeign('relations_user_to_restaurant_user_id_foreign');
            $table->dropForeign('relations_user_to_restaurant_restaurant_id_foreign');
        });
        Schema::dropIfExists('relations_user_to_restaurant');
    }
}
