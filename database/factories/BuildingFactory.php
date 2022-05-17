<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BuildingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Building::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->numerify('Building #');

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'team_id' => 1,
        ];
    }
}
