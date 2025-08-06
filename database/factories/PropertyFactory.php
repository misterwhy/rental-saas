<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(4),
            'address' => $this->faker->streetAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->stateAbbr(),
            'zip_code' => $this->faker->postcode(),
            'country' => 'USA',
            'price_per_night' => $this->faker->randomFloat(2, 50, 500),
            'bedrooms' => $this->faker->numberBetween(1, 6),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'max_guests' => $this->faker->numberBetween(2, 12),
            'property_type' => $this->faker->randomElement(['house', 'apartment', 'condo', 'villa']),
            'amenities' => $this->faker->randomElements(
                ['wifi', 'pool', 'parking', 'gym', 'spa', 'kitchen', 'laundry', 'balcony'],
                $this->faker->numberBetween(1, 5)
            ),
            'landlord_id' => User::factory()->landlord(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }

    public function expensive(): static
    {
        return $this->state(fn (array $attributes) => [
            'price_per_night' => $this->faker->randomFloat(2, 400, 1000),
        ]);
    }

    public function cheap(): static
    {
        return $this->state(fn (array $attributes) => [
            'price_per_night' => $this->faker->randomFloat(2, 25, 100),
        ]);
    }
}
