<?php

namespace Database\Factories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AssetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Asset::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->numerify('Asset ###');

        return [
            'building_id' => 1,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->text(255),
        ];
    }
}
