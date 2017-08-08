<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmgHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smg_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id');
            $table->integer('type_id');
            $table->integer('store');
            $table->double('count');
            $table->double('overall_satisfaction_score');
            $table->double('overall_satisfaction_n');
            $table->double('taste_of_food_score');
            $table->double('taste_of_food_n');
            $table->double('speed_of_service_score');
            $table->double('speed_of_service_n');
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
        Schema::dropIfExists('smg_history');
    }
}
