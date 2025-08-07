<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'category_id' => $this->faker->numberBetween(1, 2),
            'price' => $this->faker->numberBetween(1000, 100000),
            'description' => $this->faker->text,
            'img' => fake()->randomElement([
                'https://images.unsplash.com/photo-1591325418441-ff678baf78ef', 
                'https://plus.unsplash.com/premium_photo-1668143358351-b20146dbcc02', 
                'https://images.unsplash.com/photo-1553621042-f6e147245754']),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
