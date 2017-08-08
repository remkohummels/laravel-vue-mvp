<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternationalLocationsHistoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::unprepared('CREATE TRIGGER international_locations_history_trigger AFTER UPDATE ON `international_locations` FOR EACH ROW
                BEGIN
            	    INSERT INTO `international_locations_history`
            	    (
                        `old_id`,
                        `Rest #`,
                        `Open Status`,
                        `Ownership`,
                        `International Restaurant Name`,
                        `Address`,
                        `City`,
                        `Country`,
                        `Zip`,
                        `Restaurant Phone`,
                        `Venue`,
                        `Venue: Other`,
                        `Franchise Entity`,
                        `Franchise Owner`,
                        `Franchise Owner Contact Address`,
                        `Franchise Owner Contact Address 2`,
                        `Franchise Owner Phone`,
                        `Franchise Owner Email`,
                        `Franchise Operations VP/Director`,
                        `Franchise Operations VP/Director Phone`,
                        `Franchise Operations VP/Director Email`,
                        `Franchise Market Leader`,
                        `Franchise Market Leader Phone`,
                        `Franchise Market Leader Email`,
                        `Regional Franchise Director`,
                        `Regional Franchise Director Email`,
                        `Regional Franchise Manager`,
                        `Regional Franchise Manager E-mail`,
                        `Regional Marketing`,
                        `Regional Marketing Email`,
                        `Regional Training`,
                        `Regional Training Email`,
                        `Open Date`,
                        `Brand`,
                        `SMG`,
                        `Asset Type`,
                        `Zone Director`,
                        `ZDO Phone`,
                        `ZDO Email`,
                        `Restaurant Email`,
                        `OPS Excellence Coach`,
                        `OPS Excellence Email`,
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
                        OLD.`International Restaurant Name`,
                        OLD.`Address`,
                        OLD.`City`,
                        OLD.`Country`,
                        OLD.`Zip`,
                        OLD.`Restaurant Phone`,
                        OLD.`Venue`,
                        OLD.`Venue: Other`,
                        OLD.`Franchise Entity`,
                        OLD.`Franchise Owner`,
                        OLD.`Franchise Owner Contact Address`,
                        OLD.`Franchise Owner Contact Address 2`,
                        OLD.`Franchise Owner Phone`,
                        OLD.`Franchise Owner Email`,
                        OLD.`Franchise Operations VP/Director`,
                        OLD.`Franchise Operations VP/Director Phone`,
                        OLD.`Franchise Operations VP/Director Email`,
                        OLD.`Franchise Market Leader`,
                        OLD.`Franchise Market Leader Phone`,
                        OLD.`Franchise Market Leader Email`,
                        OLD.`Regional Franchise Director`,
                        OLD.`Regional Franchise Director Email`,
                        OLD.`Regional Franchise Manager`,
                        OLD.`Regional Franchise Manager E-mail`,
                        OLD.`Regional Marketing`,
                        OLD.`Regional Marketing Email`,
                        OLD.`Regional Training`,
                        OLD.`Regional Training Email`,
                        OLD.`Open Date`,
                        OLD.`Brand`,
                        OLD.`SMG`,
                        OLD.`Asset Type`,
                        OLD.`Zone Director`,
                        OLD.`ZDO Phone`,
                        OLD.`ZDO Email`,
                        OLD.`Restaurant Email`,
                        OLD.`OPS Excellence Coach`,
                        OLD.`OPS Excellence Email`,
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
        //
        DB::unprepared('DROP TRIGGER `international_locations_history_trigger`');

    }
}
