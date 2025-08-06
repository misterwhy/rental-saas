<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Property Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration values for property management
    |
    */

    'types' => [
        'house' => 'House',
        'apartment' => 'Apartment',
        'condo' => 'Condominium',
        'villa' => 'Villa',
        'studio' => 'Studio',
        'loft' => 'Loft',
    ],

    'amenities' => [
        'wifi' => 'WiFi',
        'kitchen' => 'Kitchen',
        'washing_machine' => 'Washing Machine',
        'air_conditioning' => 'Air Conditioning',
        'heating' => 'Heating',
        'pool' => 'Swimming Pool',
        'gym' => 'Gym/Fitness Center',
        'parking' => 'Parking',
        'balcony' => 'Balcony/Terrace',
        'garden' => 'Garden',
        'fireplace' => 'Fireplace',
        'hot_tub' => 'Hot Tub',
        'bbq' => 'BBQ/Grill',
        'beach_access' => 'Beach Access',
        'ski_access' => 'Ski Access',
        'pet_friendly' => 'Pet Friendly',
        'smoking_allowed' => 'Smoking Allowed',
        'events_allowed' => 'Events Allowed',
    ],

    'validation' => [
        'max_images' => 10,
        'max_image_size' => 5120, // KB
        'max_description_length' => 2000,
        'min_description_length' => 10,
        'max_price_per_night' => 10000,
        'min_price_per_night' => 1,
        'max_guests' => 50,
        'max_bedrooms' => 20,
        'max_bathrooms' => 20,
    ],

    'defaults' => [
        'currency' => 'USD',
        'currency_symbol' => '$',
        'pagination_limit' => 12,
        'featured_limit' => 6,
    ],
];
