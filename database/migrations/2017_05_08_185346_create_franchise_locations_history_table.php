<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseLocationsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchise_locations_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('old_id');
            $table->string('Rest #')->unique()->length(20);
            $table->string('Open Status')->nullable();
            $table->string('Ownership');
            $table->string('Address');
            $table->string('City');
            $table->string('State');
            $table->integer('Zip');
            $table->string('Restaurant Phone')->nullable();
            $table->integer('DMA #');
            $table->string('DMA Name');
            $table->string('Venue');
            $table->string('Venue: Other')->nullable();
            $table->string('Franchise Entity')->nullable();
            $table->string('Franchise Owner Contact')->nullable();
            $table->string('Franchise Owner Contact Address')->nullable();
            $table->string('Franchise Owner Contact Address 2')->nullable();
            $table->string('Franchise Owner Contact Phone')->nullable();
            $table->string('Franchise Owner Contact E-mail')->nullable();
            $table->string('Franchise President')->nullable()->nullable();
            $table->string('Franchise President Phone')->nullable();
            $table->string('Franchise President E-mail')->nullable();
            $table->string('Franchise VP of Operations')->nullable();
            $table->string('Franchise VP of Operations Phone')->nullable();
            $table->string('Franchise VP of Operations E-mail')->nullable();
            $table->string('Franchise Zone Director')->nullable();
            $table->string('Franchise Zone Director Phone')->nullable();
            $table->string('Franchise Zone Director E-mail')->nullable();
            $table->string('Franchise Market Leader')->nullable();
            $table->string('Franchise Market Leader Phone')->nullable();
            $table->string('Franchise Market Leader E-mail')->nullable();
            $table->string("Sr Regional Franchise Director")->nullable();
            $table->string("Sr Regional Franchise Director E-mail")->nullable();
            $table->string("Regional Franchise Director E-mail")->nullable();
            $table->string('Field Marketing')->nullable()->nullable();
            $table->string('Field Marketing E-mail')->nullable();
            $table->string('National Field Trainer')->nullable();
            $table->string('National Field Trainer E-mail')->nullable();
            $table->string('NFT Region')->nullable()->nullable();
            $table->string('Ops Excellence Coaches')->nullable();
            $table->string('Ops Excellence email')->nullable();
            $table->string('FRN Restaurant email')->nullable();
            $table->string('POS System')->nullable();
            $table->string('Media/Non Media')->nullable();
            $table->string('Open Date')->nullable();
            $table->string('Drive Thru Information')->nullable();
            $table->string('Distribution Center')->nullable();
            $table->string('Owner Base of Operations DMA')->nullable();
            $table->string('Owner Base of Ops State')->nullable();
            $table->integer('Franchise Entity #')->nullable();
            $table->string("Add'l Email Addresses")->nullable();
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
        Schema::dropIfExists('franchise_locations_history');

    }
}
