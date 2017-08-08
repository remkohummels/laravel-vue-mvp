<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternationalLocationsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('international_locations_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id');
            $table->string('Rest #')->unique()->length(20);
            $table->string('Open Status');
            $table->string('Ownership');
            $table->string('International Restaurant Name')->nullable();
            $table->string('Address');
            $table->string('City');
            $table->string('Country');
            $table->integer('Zip')->nullable();
            $table->string('Restaurant Phone')->nullable();
            $table->string('Venue')->nullable();
            $table->string('Venue: Other')->nullable();
            $table->string('Franchise Entity');
            $table->string('Franchise Owner')->nullable();
            $table->string('Franchise Owner Contact Address')->nullable();
            $table->string('Franchise Owner Contact Address 2')->nullable();
            $table->string('Franchise Owner Phone')->nullable();
            $table->string('Franchise Owner Email')->nullable();
            $table->string('Franchise Operations VP/Director')->nullable();
            $table->string('Franchise Operations VP/Director Phone')->nullable();
            $table->string('Franchise Operations VP/Director Email')->nullable();
            $table->string('Franchise Market Leader')->nullable();
            $table->string('Franchise Market Leader Phone')->nullable();
            $table->string('Franchise Market Leader Email')->nullable();
            $table->string('Regional Franchise Director')->nullable();
            $table->string('Regional Franchise Director Email')->nullable();
            $table->string('Regional Franchise Manager')->nullable();
            $table->string('Regional Franchise Manager E-mail')->nullable();
            $table->string('Regional Marketing')->nullable();
            $table->string('Regional Marketing Email')->nullable();
            $table->string('Regional Training')->nullable();
            $table->string('Regional Training Email')->nullable();
            $table->string('Open Date')->nullable();
            $table->string('Brand');
            $table->string('SMG');
            $table->string('Asset Type')->nullable();
            $table->string('Zone Director')->nullable();
            $table->string('ZDO Phone')->nullable();
            $table->string('ZDO Email')->nullable();
            $table->string('Restaurant Email')->nullable();
            $table->string('OPS Excellence Coach')->nullable();
            $table->string('OPS Excellence Email')->nullable();
            $table->string('Franchise Agreement Expiration Date')->nullable();
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
        Schema::dropIfExists('international_locations_history');
    }
}
