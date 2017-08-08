<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id');

            $table->string('restaurant_id')->length(20);
            $table->integer('sync_type_id');
            $table->timestamp('sync_date');

            $table->string('timezone');
            $table->integer('hours_template_id');
            $table->integer('currency_format_id');
            $table->string('country');
            $table->string('state');
            $table->string('dma');
            $table->integer('restaurant_type_id');
            $table->tinyInteger('password_required');
            $table->string('password')->nullable();
            $table->tinyInteger('password_reset')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('restaurants_history');
    }
}
