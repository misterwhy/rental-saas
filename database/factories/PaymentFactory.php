<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Lease;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'lease_id' => Lease::factory(),
            'tenant_id' => Tenant::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'payment_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'type' => $this->faker->randomElement(['Rent', 'Late Fee', 'Deposit', 'Utility']),
            'status' => $this->faker->randomElement(['Paid', 'Pending', 'Failed', 'Refunded']),
            'payment_method' => $this->faker->randomElement(['Credit Card', 'ACH', 'Cash', 'Check']),
            'transaction_id' => $this->faker->optional()->uuid,
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}