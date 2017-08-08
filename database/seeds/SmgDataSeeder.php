<?php

use Illuminate\Database\Seeder;
use App\Http\Controllers\Admin\SMGController;

class SmgDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SMGController::download();
        SMGController::store();
    }
}
