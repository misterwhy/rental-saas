<?php

namespace Database\Factories;

use App\Models\Unit;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'property_id' => Property::factory(),
            'unit_number' => $this->faker->bothify('Unit ##?'),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->randomElement([1, 1.5, 2, 2.5, 3]),
            'square_footage' => $this->faker->numberBetween(500, 3000),
            'rent_amount' => $this->faker->randomFloat(2, 800, 5000),
            'status' => $this->faker->randomElement(['Occupied', 'Vacant', 'Under Maintenance']),
            'deposit_amount' => $this->faker->randomFloat(2, 500, 2000),
            'available_date' => $this->faker->optional()->dateTimeBetween('now', '+6 months'),
            'images' => [],
        ];
    }
}