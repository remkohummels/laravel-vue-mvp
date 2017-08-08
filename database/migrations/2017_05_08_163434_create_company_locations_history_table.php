<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyLocationsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_locations_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id');
            $table->string('Rest #')->unique()->length(20);
            $table->string('Open Status');
            $table->string('Address');
            $table->string('City');
            $table->string('State');
            $table->integer('Zip');
            $table->string('Phone');
            $table->integer('DMA #');
            $table->string('DMA Name');
            $table->string('Zone Director');
            $table->string('ZDO Mobile Phone');
            $table->string('ZDO E-Mail');
            $table->integer('Zone');
            $table->integer('Zone/Region #');
            $table->string('Market Leader');
            $table->string('Market Leader Mobile Phone');
            $table->string('Market Leader E-mail');
            $table->integer('Market #');
            $table->string('NFT');
            $table->string('NFT E-mail');
            $table->string('FM')->nullable();
            $table->string('FM E-mail')->nullable();
            $table->string('President & CEO');
            $table->string('Restaurant Email');
            $table->string('Venue');
            $table->string('Venue: Other')->nullable();
            $table->date('Open Date')->nullable();
            $table->string('Drive Thru Information')->nullable();
            $table->string('Chicken Distribution Center');
            $table->string('Ops Excellence Coach')->nullable();
            $table->string('Ops Excellence Email')->nullable();
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
        Schema::dropIfExists('company_locations_history');
    }
}
