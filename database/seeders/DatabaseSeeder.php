<?php

namespace Database\Seeders;

use Database\Seeds\CitySeeder;
use Database\Seeds\CustomerSeeder;
use Database\Seeds\DistrictSeeder;
use Database\Seeds\EstateInformation;
use Database\Seeds\PagesSeoSeeder;
use Database\Seeds\RenovationSeeder;
use Database\Seeds\SaleSeeder;
use Database\Seeds\TabSearchSeeder;
use Database\Seeds\TagsSeeder;
use Database\Seeds\VoyagerDatabaseSeeder;
use Illuminate\Database\Seeder;
use Database\Seeds\EstateSeeder;
use Database\Seeds\GroupsSeeder;
use Database\Seeds\DefaultTagsSEO;
use Database\Seeds\StationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RenovationSeeder::class,
            SaleSeeder::class,
            EstateSeeder::class,
            GroupsSeeder::class,
            PagesSeoSeeder::class,
            TagsSeeder::class,
            VoyagerDatabaseSeeder::class,
            DefaultTagsSEO::class,
            TabSearchSeeder::class,
            EstateInformation::class,
            CustomerSeeder::class,
            StationSeeder::class,
            CitySeeder::class,
            DistrictSeeder::class,
        ]);
    }
}
