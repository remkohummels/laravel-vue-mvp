<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyncHoursTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sync_hours_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hours_template_id')->unsigned();
            $table->string('hierarchy_report');
            $table->string('hierarchy_column');
            $table->string('hierarchy_value');

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
        Schema::table('sync_hours_templates', function (Blueprint $table) {
            $table->dropForeign('sync_hours_templates_hours_template_id_foreign');
        });
        Schema::dropIfExists('sync_hours_templates');
    }
}
