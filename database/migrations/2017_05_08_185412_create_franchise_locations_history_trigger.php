<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseLocationsHistoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::unprepared('CREATE TRIGGER franchise_locations_history_trigger AFTER UPDATE ON `franchise_locations` FOR EACH ROW
                BEGIN
            	    INSERT INTO `franchise_locations_history`
            	    (
            	        `old_id`,
                        `Rest #`,
                        `Open Status`,
                        `Ownership`,
                        `Address`,
                        `City`,
                        `State`,
                        `Zip`,
                        `Restaurant Phone`,
                        `DMA #`,
                        `DMA Name`,
                        `Venue`,
                        `Venue: Other`,
                        `Franchise Entity`,
                        `Franchise Owner Contact`,
                        `Franchise Owner Contact Address`,
                        `Franchise Owner Contact Address 2`,
                        `Franchise Owner Contact Phone`,
                        `Franchise Owner Contact E-mail`,
                        `Franchise President`,
                        `Franchise President Phone`,
                        `Franchise President E-mail`,
                        `Franchise VP of Operations`,
                        `Franchise VP of Operations Phone`,
                        `Franchise VP of Operations E-mail`,
                        `Franchise Zone Director`,
                        `Franchise Zone Director Phone`,
                        `Franchise Zone Director E-mail`,
                        `Franchise Market Leader`,
                        `Franchise Market Leader Phone`,
                        `Franchise Market Leader E-mail`,
                        `Sr Regional Franchise Director`,
                        `Sr Regional Franchise Director E-mail`,
                        `Regional Franchise Director E-mail`,
                        `Field Marketing`,
                        `Field Marketing E-mail`,
                        `National Field Trainer`,
                        `National Field Trainer E-mail`,
                        `NFT Region`,
                        `Ops Excellence Coaches`,
                        `Ops Excellence email`,
                        `FRN Restaurant email`,
                        `POS System`,
                        `Media/Non Media`,
                        `Open Date`,
                        `Drive Thru Information`,
                        `Distribution Center`,
                        `Owner Base of Operations DMA`,
                        `Owner Base of Ops State`,
                        `Franchise Entity #`,
                        `Add\'l Email Addresses`,
                        `Franchise Agreement Expiration Date`,
                        `old_created_at`,
                        `old_updated_at`,
                        `created_at`,
                        `updated_at`
                    )
            	    VALUES (
                   	    OLD.`id`,
                        OLD.`Rest #`,
                        OLD.`Open Status`,
                        OLD.`Ownership`,
                        OLD.`Address`,
                        OLD.`City`,
                        OLD.`State`,
                        OLD.`Zip`,
                        OLD.`Restaurant Phone`,
                        OLD.`DMA #`,
                        OLD.`DMA Name`,
                        OLD.`Venue`,
                        OLD.`Venue: Other`,
                        OLD.`Franchise Entity`,
                        OLD.`Franchise Owner Contact`,
                        OLD.`Franchise Owner Contact Address`,
                        OLD.`Franchise Owner Contact Address 2`,
                        OLD.`Franchise Owner Contact Phone`,
                        OLD.`Franchise Owner Contact E-mail`,
                        OLD.`Franchise President`,
                        OLD.`Franchise President Phone`,
                        OLD.`Franchise President E-mail`,
                        OLD.`Franchise VP of Operations`,
                        OLD.`Franchise VP of Operations Phone`,
                        OLD.`Franchise VP of Operations E-mail`,
                        OLD.`Franchise Zone Director`,
                        OLD.`Franchise Zone Director Phone`,
                        OLD.`Franchise Zone Director E-mail`,
                        OLD.`Franchise Market Leader`,
                        OLD.`Franchise Market Leader Phone`,
                        OLD.`Franchise Market Leader E-mail`,
                        OLD.`Sr Regional Franchise Director`,
                        OLD.`Sr Regional Franchise Director E-mail`,
                        OLD.`Regional Franchise Director E-mail`,
                        OLD.`Field Marketing`,
                        OLD.`Field Marketing E-mail`,
                        OLD.`National Field Trainer`,
                        OLD.`National Field Trainer E-mail`,
                        OLD.`NFT Region`,
                        OLD.`Ops Excellence Coaches`,
                        OLD.`Ops Excellence email`,
                        OLD.`FRN Restaurant email`,
                        OLD.`POS System`,
                        OLD.`Media/Non Media`,
                        OLD.`Open Date`,
                        OLD.`Drive Thru Information`,
                        OLD.`Distribution Center`,
                        OLD.`Owner Base of Operations DMA`,
                        OLD.`Owner Base of Ops State`,
                        OLD.`Franchise Entity #`,
                        OLD.`Add\'l Email Addresses`,
                        OLD.`Franchise Agreement Expiration Date`,
                        OLD.`created_at`,
                        OLD.`updated_at`,
                        NOW(),
                        NOW()

            	    );
                END'

        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        DB::unprepared('DROP TRIGGER `franchise_locations_history_trigger`');

    }
}
