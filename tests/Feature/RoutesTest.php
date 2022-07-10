<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\Building;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    use RefreshDatabase;

    public function testBuildingList()
    {
        Building::factory(3)->create(['user_id' => 1]);

        $response = $this->get('/buildings');
        $response->assertStatus(200);
    }

    public function testAssetsList()
    {
        Building::factory(1)->create(['id' => 1, 'user_id' => 1]);
        Asset::factory(2)->create(['building_id' => 1]);

        $response = $this->get('/buildings/1/assets');
        $response->assertStatus(200);
    }
}
