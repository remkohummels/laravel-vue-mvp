<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smg', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->unsigned();
            $table->integer('store');
            $table->double('count');
            $table->double('overall_satisfaction_score');
            $table->double('overall_satisfaction_n');
            $table->double('taste_of_food_score');
            $table->double('taste_of_food_n');
            $table->double('speed_of_service_score');
            $table->double('speed_of_service_n');
            $table->timestamps();

            $table->foreign('type_id')
                  ->references('id')
                  ->on('smg_types')
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
        Schema::table('smg', function (Blueprint $table) {
            $table->dropForeign('smg_type_id_foreign');
        });
        Schema::dropIfExists('smg');
    }
}
