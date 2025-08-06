<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_view_property_listings()
    {
        Property::factory()->count(3)->create();

        $response = $this->get(route('properties.index'));

        $response->assertOk();
        $response->assertViewIs('properties.index');
    }

    /** @test */
    public function guests_can_view_individual_property()
    {
        $property = Property::factory()->create();

        $response = $this->get(route('properties.show', $property));

        $response->assertOk();
        $response->assertViewIs('properties.show');
        $response->assertSee($property->title);
    }

    /** @test */
    public function landlords_can_create_properties()
    {
        $landlord = User::factory()->landlord()->create();

        $propertyData = [
            'title' => 'Test Property',
            'description' => 'This is a test property description',
            'address' => '123 Test St',
            'city' => 'Test City',
            'state' => 'TS',
            'zip_code' => '12345',
            'country' => 'USA',
            'price_per_night' => 100,
            'bedrooms' => 2,
            'bathrooms' => 1,
            'max_guests' => 4,
            'property_type' => 'apartment',
        ];

        $response = $this->actingAs($landlord)
            ->post(route('properties.store'), $propertyData);

        $this->assertDatabaseHas('properties', [
            'title' => 'Test Property',
            'landlord_id' => $landlord->id
        ]);
    }

    /** @test */
    public function tenants_cannot_create_properties()
    {
        $tenant = User::factory()->tenant()->create();

        $propertyData = [
            'title' => 'Test Property',
            'description' => 'This is a test property description',
        ];

        $response = $this->actingAs($tenant)
            ->post(route('properties.store'), $propertyData);

        $response->assertForbidden();
    }

    /** @test */
    public function properties_can_be_filtered_by_location()
    {
        Property::factory()->create(['city' => 'Miami']);
        Property::factory()->create(['city' => 'Orlando']);

        $response = $this->get(route('properties.index', ['location' => 'Miami']));

        $response->assertOk();
    }
}
