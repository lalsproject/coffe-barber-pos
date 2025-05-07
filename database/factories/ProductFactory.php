<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'image' => $this->faker->imageUrl(),
            'description' => $this->faker->sentence(),
            'brand_id' => 1,
            'category_id' => 1,
            'unit_id' => 1,
            'status' => 'active',
            'stock' => $this->faker->numberBetween(0, 50),
            'price' => $this->faker->numberBetween(1000, 10000),
            'user_id' => 1,
        ];
    }
}
