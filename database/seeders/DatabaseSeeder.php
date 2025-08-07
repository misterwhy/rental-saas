<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks for clean seeding
        Schema::disableForeignKeyConstraints();

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create regular users
        $users = User::factory(5)->create();

        // Create property owners (some users will be property owners)
        $owners = User::factory(3)->create();

        // Create properties
        $properties = Property::factory(5)
            ->make([
                'owner_id' => $admin->id,
            ]);

        foreach ($properties as $property) {
            Property::create($property->toArray());
        }

        // Create additional properties with random owners
        $allOwners = $owners->merge([$admin]);
        Property::factory(3)->create([
            'owner_id' => $allOwners->random()->id,
        ]);

        // Create units for properties
        $allProperties = Property::all();
        $allProperties->each(function ($property) {
            Unit::factory(rand(2, 5))->create([
                'property_id' => $property->id,
            ]);
        });

        // Create tenants
        $tenants = Tenant::factory(15)->create();

        // Create leases
        $units = Unit::all();
        $units->each(function ($unit) use ($tenants) {
            if ($tenants->count() > 0) {
                $randomTenants = $tenants->random(rand(1, min(2, $tenants->count())))->pluck('id')->toArray();
                
                Lease::factory()->create([
                    'unit_id' => $unit->id,
                    'tenant_ids' => json_encode($randomTenants),
                    'start_date' => now()->subMonths(rand(1, 12)),
                    'end_date' => now()->addMonths(rand(6, 24)),
                    'status' => rand(0, 1) ? 'Active' : 'Expired',
                    'rent_amount' => rand(800, 3000),
                    'deposit_amount' => rand(500, 1500),
                    'payment_frequency' => 'Monthly',
                ]);
            }
        });

        // Create maintenance requests
        $units->each(function ($unit) use ($tenants) {
            if ($tenants->count() > 0 && rand(0, 1)) { // 50% chance to create maintenance request
                MaintenanceRequest::factory()->create([
                    'unit_id' => $unit->id,
                    'tenant_id' => $tenants->random()->id,
                    'title' => 'Maintenance Request ' . rand(1, 100),
                    'description' => 'This is a maintenance request description',
                    'status' => ['Open', 'In Progress', 'Completed'][rand(0, 2)],
                    'priority' => ['Low', 'Medium', 'High'][rand(0, 2)],
                ]);
            }
        });

        // Create payments for active leases
        $leases = Lease::all();
        $leases->each(function ($lease) use ($tenants) {
            if ($lease->status === 'Active' && $tenants->count() > 0) {
                // Create some payments for each lease
                $tenantId = null;
                $tenantIds = json_decode($lease->tenant_ids, true);
                if (is_array($tenantIds) && count($tenantIds) > 0) {
                    $tenantId = $tenantIds[0];
                } else {
                    $tenantId = $tenants->random()->id;
                }
                
                for ($i = 0; $i < rand(1, 6); $i++) {
                    Payment::factory()->create([
                        'lease_id' => $lease->id,
                        'tenant_id' => $tenantId,
                        'amount' => rand(500, 2000),
                        'payment_date' => now()->subMonths(rand(0, 6)),
                        'status' => 'Paid',
                        'type' => 'Rent',
                        'payment_method' => 'Credit Card',
                    ]);
                }
            }
        });

        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Re-enable foreign key checks
        Schema::enableForeignKeyConstraints();
    }
}