<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Building;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Building::factory(3)->create(['user_id' => 1]);
        Building::factory(3)->create(['user_id' => 2]);

        Asset::factory(1000)->create(['building_id' => 1]);
        Asset::factory(150)->create(['building_id' => 2]);
        Asset::factory(150)->create(['building_id' => 3]);
        Asset::factory(150)->create(['building_id' => 4]);
        Asset::factory(150)->create(['building_id' => 5]);
        Asset::factory(150)->create(['building_id' => 6]);
    }
}
