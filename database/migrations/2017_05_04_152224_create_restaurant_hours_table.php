<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurant_id')->length(20);
            $table->string('dayofweek');
            $table->string('day_part');
            $table->integer('day_part_order');
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();

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
        Schema::table('restaurant_hours', function (Blueprint $table) {
            $table->dropForeign('restaurant_hours_restaurant_id_foreign');
        });
        Schema::dropIfExists('restaurant_hours');
    }
}
