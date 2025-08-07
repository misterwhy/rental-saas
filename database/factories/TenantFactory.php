<?php

namespace Database\Factories;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class TenantFactory extends Factory
{
    protected $model = Tenant::class;

    public function definition(): array
    {
        return [
            'user_id' => null,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'emergency_contact' => [
                'name' => $this->faker->name,
                'relationship' => $this->faker->randomElement(['Spouse', 'Parent', 'Sibling', 'Friend']),
                'phone' => $this->faker->phoneNumber,
                'email' => $this->faker->safeEmail,
            ],
            'background_check_status' => $this->faker->randomElement(['Pending', 'Approved', 'Denied']),
            'credit_score' => $this->faker->numberBetween(500, 850),
            'notes' => $this->faker->optional()->paragraph,
        ];
    }
}