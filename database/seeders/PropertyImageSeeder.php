<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Database\Seeder;

class PropertyImageSeeder extends Seeder
{
    public function run()
    {
        $properties = Property::all();
        
        foreach ($properties as $property) {
            // Add a main image for each property using the existing default image
            PropertyImage::create([
                'property_id' => $property->id,
                'image_path' => 'images/default-property.jpg', // Using existing default image
                'is_main' => true,
            ]);
        }
        
        $this->command->info('Added sample images to ' . $properties->count() . ' properties.');
    }
}
