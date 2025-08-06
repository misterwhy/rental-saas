<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users
        $landlord = User::create([
            'name' => 'John Landlord',
            'email' => 'landlord@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'landlord',
            'phone' => '555-0101',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $tenant = User::create([
            'name' => 'Jane Tenant',
            'email' => 'tenant@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'tenant',
            'phone' => '555-0102',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create sample properties
        Property::create([
            'title' => 'Beautiful Beach House',
            'description' => 'A stunning 3-bedroom beach house with ocean views. Perfect for families and groups looking for a relaxing getaway.',
            'address' => '123 Ocean Drive',
            'city' => 'Miami',
            'state' => 'FL',
            'zip_code' => '33139',
            'country' => 'USA',
            'price_per_night' => 250.00,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'max_guests' => 6,
            'property_type' => 'house',
            'amenities' => ['wifi', 'pool', 'parking', 'beach_access', 'kitchen'],
            'landlord_id' => $landlord->id,
            'is_active' => true,
        ]);

        Property::create([
            'title' => 'Modern Downtown Apartment',
            'description' => 'Stylish 2-bedroom apartment in the heart of downtown. Walking distance to restaurants, shops, and entertainment.',
            'address' => '456 Main Street, Apt 5B',
            'city' => 'New York',
            'state' => 'NY',
            'zip_code' => '10001',
            'country' => 'USA',
            'price_per_night' => 180.00,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'max_guests' => 4,
            'property_type' => 'apartment',
            'amenities' => ['wifi', 'gym', 'laundry', 'doorman', 'kitchen'],
            'landlord_id' => $landlord->id,
            'is_active' => true,
        ]);

        Property::create([
            'title' => 'Cozy Mountain Cabin',
            'description' => 'Escape to this charming mountain cabin surrounded by nature. Features fireplace, hot tub, and hiking trails nearby.',
            'address' => '789 Pine Trail',
            'city' => 'Aspen',
            'state' => 'CO',
            'zip_code' => '81611',
            'country' => 'USA',
            'price_per_night' => 320.00,
            'bedrooms' => 4,
            'bathrooms' => 3,
            'max_guests' => 8,
            'property_type' => 'house',
            'amenities' => ['wifi', 'fireplace', 'hot_tub', 'parking', 'kitchen', 'hiking'],
            'landlord_id' => $landlord->id,
            'is_active' => true,
        ]);

        // Create additional landlords and properties
        User::factory()
            ->landlord()
            ->count(5)
            ->create()
            ->each(function ($landlord) {
                Property::factory()
                    ->count(rand(1, 3))
                    ->create(['landlord_id' => $landlord->id]);
            });

        // Create additional tenants
        User::factory()
            ->tenant()
            ->count(10)
            ->create();
    }
}
