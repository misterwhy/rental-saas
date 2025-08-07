<?php

namespace Database\Factories;

use App\Models\Lease;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaseFactory extends Factory
{
    protected $model = Lease::class;

    public function definition(): array
    {
        // --- Robust Date Generation ---
        // 1. Generate a start date that is not too far in the past or future.
        //    Using 'now' as a base reference point.
        $startDate = $this->faker->dateTimeBetween('-1 year', '+6 months'); // Start within a reasonable window

        // 2. Define a fixed lease duration in months to ensure consistency.
        $durationMonths = $this->faker->randomElement([6, 12, 18, 24, 36]); // Common lease terms

        // 3. Calculate the end date based on the start date and duration.
        //    This guarantees end_date > start_date.
        $endDate = clone $startDate;
        $endDate->modify("+{$durationMonths} months");

        // 4. Generate other optional dates *safely* within the lease period.
        //    Initialize as null.
        $lastPaymentDate = null;
        $nextPaymentDueDate = null;

        // Example logic for optional dates (you can adjust):
        // - There's a chance a last payment was made during the lease.
        if ($this->faker->boolean(70)) { // 70% chance
            // If a last payment exists, it must be between lease start and now (or lease end if lease is over).
            $lastPaymentUpperBound = (new \DateTime() < $endDate) ? new \DateTime() : $endDate;
            if ($lastPaymentUpperBound > $startDate) { // Ensure the range is valid
                 // Faker's dateTimeBetween needs a valid range, avoid edge case where start=end
                if ($lastPaymentUpperBound->format('Y-m-d H:i:s') !== $startDate->format('Y-m-d H:i:s')) {
                    $lastPaymentDate = $this->faker->dateTimeBetween($startDate, $lastPaymentUpperBound);
                }
            }
        }

        // - There's a chance a next payment is due (if the lease is active and payments are expected).
        //   Only set if the lease hasn't ended yet.
        if ($endDate > new \DateTime() && $this->faker->boolean(60)) { // 60% chance if lease is not expired
            // Next payment is due sometime between now and the lease end date.
            $nextPaymentLowerBound = new \DateTime(); // Should not be before 'now'
            // Ensure the range for next payment is valid and start < end
            if ($nextPaymentLowerBound < $endDate) {
                // Avoid edge case where start=end for dateTimeBetween
                if ($nextPaymentLowerBound->format('Y-m-d H:i:s') !== $endDate->format('Y-m-d H:i:s')) {
                     // Use optional to allow it to be null even if the range is valid
                    $nextPaymentDueDate = $this->faker->optional(0.8, null)->dateTimeBetween($nextPaymentLowerBound, $endDate);
                }
            }
        }


        return [
            'unit_id' => Unit::factory(), // This will create a Unit if needed, or can be overridden
            'tenant_ids' => json_encode([]), // Seed or state might populate this later, e.g., using ->afterCreating
            'start_date' => $startDate,      // Guaranteed earlier than $endDate
            'end_date' => $endDate,          // Guaranteed later than $startDate
            'rent_amount' => $this->faker->randomFloat(2, 800, 5000),
            'deposit_amount' => $this->faker->randomFloat(2, 500, 2000),
            'status' => $this->faker->randomElement(['Active', 'Expired', 'Pending Renewal']),
            'payment_frequency' => $this->faker->randomElement(['Monthly', 'Quarterly']),
            'late_fee_policy' => $this->faker->optional(0.3)->sentence, // 30% chance of having a policy
            'documents' => [], // Can be populated later if needed
            'last_payment_date' => $lastPaymentDate, // Nullable datetime
            'next_payment_due_date' => $nextPaymentDueDate, // Nullable datetime
        ];
    }
}