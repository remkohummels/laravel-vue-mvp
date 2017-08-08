<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDayPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_parts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hours_template_id')->unsigned();
            $table->string('dayofweek');
            $table->string('day_part');
            $table->integer('day_part_order');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('shift');

            $table->timestamps();

            $table->foreign('hours_template_id')
                  ->references('id')
                  ->on('hours_templates')
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
        Schema::table('day_parts', function (Blueprint $table) {
            $table->dropForeign('day_parts_hours_template_id_foreign');
        });
        Schema::dropIfExists('day_parts');
    }
}
