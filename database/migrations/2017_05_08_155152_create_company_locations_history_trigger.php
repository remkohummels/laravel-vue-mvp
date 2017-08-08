<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateCompanyLocationsHistoryTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::unprepared('CREATE TRIGGER company_locations_history_trigger AFTER UPDATE ON `company_locations` FOR EACH ROW
                BEGIN
            	    INSERT INTO `company_locations_history`
            	    (
            	        `old_id`,
            	        `Rest #`,
                        `Open Status`,
                        `Address`,
                        `City`,
                        `State`,
                        `Zip`,
                        `Phone`,
                        `DMA #`,
                        `DMA Name`,
                        `Zone Director`,
                        `ZDO Mobile Phone`,
                        `ZDO E-Mail`,
                        `Zone`,
                        `Zone/Region #`,
                        `Market Leader`,
                        `Market Leader Mobile Phone`,
                        `Market Leader E-mail`,
                        `Market #`,
                        `NFT`,
                        `NFT E-mail`,
                        `FM`,
                        `FM E-mail`,
                        `President & CEO`,
                        `Restaurant Email`,
                        `Venue`,
                        `Venue: Other`,
                        `Open Date`,
                        `Drive Thru Information`,
                        `Chicken Distribution Center`,
                        `Ops Excellence Coach`,
                        `Ops Excellence Email`,
                        `old_created_at`,
                        `old_updated_at`,
                        `created_at`,
                        `updated_at`
                    )
            	    VALUES (
            	        OLD.`id`,
            	        OLD.`Rest #`,
                        OLD.`Open Status`,
                        OLD.`Address`,
                        OLD.`City`,
                        OLD.`State`,
                        OLD.`Zip`,
                        OLD.`Phone`,
                        OLD.`DMA #`,
                        OLD.`DMA Name`,
                        OLD.`Zone Director`,
                        OLD.`ZDO Mobile Phone`,
                        OLD.`ZDO E-Mail`,
                        OLD.`Zone`,
                        OLD.`Zone/Region #`,
                        OLD.`Market Leader`,
                        OLD.`Market Leader Mobile Phone`,
                        OLD.`Market Leader E-mail`,
                        OLD.`Market #`,
                        OLD.`NFT`,
                        OLD.`NFT E-mail`,
                        OLD.`FM`,
                        OLD.`FM E-mail`,
                        OLD.`President & CEO`,
                        OLD.`Restaurant Email`,
                        OLD.`Venue`,
                        OLD.`Venue: Other`,
                        OLD.`Open Date`,
                        OLD.`Drive Thru Information`,
                        OLD.`Chicken Distribution Center`,
                        OLD.`Ops Excellence Coach`,
                        OLD.`Ops Excellence Email`,
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
        DB::unprepared('DROP TRIGGER `company_locations_history_trigger`');
    }
}
