<?php

namespace Database\Seeders;

use App\Models\User;
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
        //Usuario demo@assethub.xyz
        User::factory(1)->create(['name' => 'demo', 'email' => 'demo@assethub.xyz']);
        Building::factory(3)->create(['user_id' => 1]);

        Asset::factory(500)->create(['building_id' => 1]);
        Asset::factory(500)->create(['building_id' => 1, 'status' => 0]);
        Asset::factory(150)->create(['building_id' => 2]);
    }
}
