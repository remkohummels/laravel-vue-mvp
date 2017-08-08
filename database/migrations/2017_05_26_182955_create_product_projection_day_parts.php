<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProjectionDayParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_projection_day_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pp_hours_template_id')->unsigned();
            $table->string('day');
            $table->string('day_part');
            $table->integer('day_part_order');
            $table->integer('expected');
            $table->integer('actual');

            $table->timestamps();

            $table->foreign('pp_hours_template_id')
                  ->references('id')
                  ->on('product_projection_hours_template')
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
        Schema::table('product_projection_day_parts', function (Blueprint $table) {
            $table->dropForeign('product_projection_day_parts_pp_hours_template_id_foreign');
        });
        Schema::dropIfExists('product_projection_day_parts');
    }
}
