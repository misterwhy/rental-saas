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
            'owner_id' => User::factory(),
            'name' => $this->faker->company . ' Property',
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'property_type' => $this->faker->randomElement(['Residential', 'Commercial', 'HOA']),
            'number_of_units' => $this->faker->numberBetween(1, 20),
            'purchase_date' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'purchase_price' => $this->faker->randomFloat(2, 50000, 1000000),
            'description' => $this->faker->paragraph,
            'amenities' => $this->faker->randomElements(['Pool', 'Gym', 'Parking', 'Laundry', 'WiFi'], rand(1, 4)),
            'images' => [],
        ];
    }
}