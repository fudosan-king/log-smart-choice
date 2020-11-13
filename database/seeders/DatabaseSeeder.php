<?php

namespace Database\Seeders;

use Database\Seeds\RenovationSeeder;
use Database\Seeds\SaleSeeder;
use App\Models\GroupsEstate;
use Illuminate\Database\Seeder;
use Database\Seeds\EstateSeeder;
use Database\Seeds\GroupsSeeder;

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
            GroupsSeeder::class
        ]);
    }
}
