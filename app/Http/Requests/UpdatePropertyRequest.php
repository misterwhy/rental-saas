<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        $user = Auth::user();
        $property = $this->route('property');
        
        return $user && $user->isLandlord() && $property->landlord_id === $user->id;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|min:10|max:2000',
            'address' => 'sometimes|required|string|max:255',
            'city' => 'sometimes|required|string|max:100',
            'state' => 'sometimes|required|string|max:100',
            'zip_code' => 'sometimes|required|string|max:20',
            'country' => 'sometimes|required|string|max:100',
            'price_per_night' => 'sometimes|required|numeric|min:1|max:10000',
            'bedrooms' => 'sometimes|required|integer|min:0|max:20',
            'bathrooms' => 'sometimes|required|integer|min:0|max:20',
            'max_guests' => 'sometimes|required|integer|min:1|max:50',
            'property_type' => 'sometimes|required|string|in:house,apartment,condo,villa,studio,loft',
            'amenities' => 'nullable|array',
            'amenities.*' => 'string|max:50',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'is_active' => 'sometimes|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Property title is required.',
            'description.min' => 'Description must be at least 10 characters.',
            'price_per_night.min' => 'Price must be at least $1 per night.',
            'price_per_night.max' => 'Price cannot exceed $10,000 per night.',
            'property_type.in' => 'Please select a valid property type.',
            'images.*.max' => 'Each image must be smaller than 5MB.',
            'images.*.mimes' => 'Images must be in JPEG, PNG, JPG, or WebP format.',
        ];
    }
}
