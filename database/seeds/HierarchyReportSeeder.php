<?php

use Illuminate\Database\Seeder;
use App\Http\Controllers\Admin\HierarchyReportController;

class HierarchyReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Download Hierarchy Report from server and save file locally ( storage/app )
        HierarchyReportController::download();

        // Save data Hierarchy Report file to DB
        HierarchyReportController::store();
    }
}
