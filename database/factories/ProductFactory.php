<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => $this->faker->word,
            'image' => $this->faker->imageUrl(),
            'qty' => $this->faker->randomNumber(2),
            'sell_price' => $this->faker->randomFloat(2, 10, 100),
            'buy_price' => $this->faker->randomFloat(2, 10, 100),
            'categories' => $this->faker->word,
        ];
    }
}
