<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoursTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('template_name');
            $table->integer('sync_type_id')->unsigned();
            $table->timestamp('sync_date');

            $table->timestamps();

            $table->foreign('sync_type_id')
                  ->references('id')
                  ->on('sync_types')
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
        Schema::table('hours_templates', function (Blueprint $table) {
            $table->dropForeign('hours_templates_sync_type_id_foreign');
        });
        Schema::dropIfExists('hours_templates');
    }
}
