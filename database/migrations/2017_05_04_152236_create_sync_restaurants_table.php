<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyncRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sync_restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurant_id')->length(20);
            $table->string('hierarchy_report');
            $table->string('hierarchy_column');
            $table->string('hierarchy_value');

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
        Schema::table('sync_restaurants', function (Blueprint $table) {
            $table->dropForeign('sync_restaurants_restaurant_id_foreign');
        });
        Schema::dropIfExists('sync_restaurants');
    }
}
