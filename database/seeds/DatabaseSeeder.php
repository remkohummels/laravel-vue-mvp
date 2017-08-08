<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(HierarchyReportSeeder::class);
        $this->call(UomTypesTableSeeder::class);
        $this->call(ServeStatusTableSeeder::class);
        $this->call(CurrencyFormatsTableSeeder::class);
        $this->call(SmgTypesTableSeeder::class);
        $this->call(SyncTypesTableSeeder::class);
        $this->call(UserTypesTableSeeder::class);
        $this->call(HoursTemplateTableSeeder::class);
        $this->call(RestaurantTypesTableSeeder::class);
        $this->call(MenuItemsTableSeeder::class);
        $this->call(RestaurantsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(UserRolesTableSeeder::class);
        $this->call(DayPartsTableSeeder::class);
        $this->call(SalesInputTableSeeder::class);
        $this->call(ProductMixDefaultTableSeeder::class);
        $this->call(ProductMixTableSeeder::class);
        $this->call(MenuItemsMinMaxTableSeeder::class);
        $this->call(SmgDataSeeder::class);
        $this->call(ProductProjectionHoursTemplateTableSeeder::class);

    }
}
