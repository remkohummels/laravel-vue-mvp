<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('restaurant_id')->unique()->length(20);

            $table->integer('sync_type_id')->unsigned();
            $table->timestamp('sync_date');

            $table->string('timezone');
            $table->integer('hours_template_id')->unsigned();
            $table->integer('currency_format_id')->unsigned();
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('city');
            $table->string('zip')->nullable();;
            $table->string('dma')->nullable();
            $table->string('email')->nullable();;
            $table->integer('restaurant_type_id')->unsigned();
            $table->tinyInteger('password_required');
            $table->string('password')->nullable();
            $table->tinyInteger('password_reset')->nullable();
            $table->text('notes')->nullable();
            $table->string('remember_token')->nullable();

            $table->timestamps();

            $table->foreign('sync_type_id')
                  ->references('id')
                  ->on('sync_types')
                  ->onUpdate('cascade');
            $table->foreign('hours_template_id')
                  ->references('id')
                  ->on('hours_templates')
                  ->onUpdate('cascade');
            $table->foreign('currency_format_id')
                  ->references('id')
                  ->on('currency_formats')
                  ->onUpdate('cascade');
            $table->foreign('restaurant_type_id')
                  ->references('id')
                  ->on('restaurant_types')
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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropForeign('restaurants_sync_type_id_foreign');
            $table->dropForeign('restaurants_hours_template_id_foreign');
            $table->dropForeign('restaurants_currency_format_id_foreign');
            $table->dropForeign('restaurants_restaurant_type_id_foreign');
        });
        Schema::dropIfExists('restaurants');
    }
}
