<?php

namespace Database\Factories;

use App\Models\MaintenanceRequest;
use App\Models\Unit;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceRequestFactory extends Factory
{
    protected $model = MaintenanceRequest::class;

    public function definition(): array
    {
        return [
            'unit_id' => Unit::factory(),
            'tenant_id' => Tenant::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'priority' => $this->faker->randomElement(['Low', 'Medium', 'High']),
            'status' => $this->faker->randomElement(['Open', 'In Progress', 'Completed', 'Cancelled']),
            'assigned_to' => null,
            'images' => [],
        ];
    }
}