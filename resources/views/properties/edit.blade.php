@extends('layouts.app')
@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Edit Property</h1>
            <p class="text-gray-500 text-sm mt-1">Update your property listing</p>
        </div>
        <a href="{{ route('properties.show', $property) }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Property
        </a>
    </div>
</div>

<div class="dashboard-card max-w-4xl">
    <form method="POST" action="{{ route('properties.update', $property) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Existing Images Display -->
        @if($property->images && $property->images->count() > 0)
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Current Images</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-4">
                @foreach($property->images as $image)
                <div class="relative group">
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                         alt="Property image" 
                         class="w-full h-32 object-cover rounded-lg">
                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                        <button type="button" 
                                onclick="removeImage({{ $image->id }})"
                                class="text-white bg-red-500 hover:bg-red-600 rounded-full p-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Hidden input to track images to remove -->
                    <input type="hidden" name="existing_images[]" value="{{ $image->id }}" id="image_{{ $image->id }}">
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Basic Information -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Property Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $property->name) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('title') border-red-300 @enderror">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('description') border-red-300 @enderror">{{ old('description', $property->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Location Details -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Location Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $property->address) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('address') border-red-300 @enderror">
                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $property->city) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('city') border-red-300 @enderror">
                    @error('city')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                    <input type="text" id="state" name="state" value="{{ old('state', $property->state) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('state') border-red-300 @enderror">
                    @error('state')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">ZIP Code</label>
                    <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code', $property->zip_code) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('zip_code') border-red-300 @enderror">
                    @error('zip_code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div class="md:col-span-2">
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" id="country" name="country" value="{{ old('country', $property->country) }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('country') border-red-300 @enderror">
                    @error('country')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Property Details -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Property Details</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                    <select id="property_type" name="property_type" required
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('property_type') border-red-300 @enderror">
                        <option value="">Select property type</option>
                        <option value="Apartment" {{ old('property_type', $property->property_type) == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="House" {{ old('property_type', $property->property_type) == 'House' ? 'selected' : '' }}>House</option>
                        <option value="Condo" {{ old('property_type', $property->property_type) == 'Condo' ? 'selected' : '' }}>Condo</option>
                        <option value="Townhouse" {{ old('property_type', $property->property_type) == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                        <option value="Cabin" {{ old('property_type', $property->property_type) == 'Cabin' ? 'selected' : '' }}>Cabin</option>
                    </select>
                    @error('property_type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="number_of_units" class="block text-sm font-medium text-gray-700 mb-2">Number of Units</label>
                    <input type="number" id="number_of_units" name="number_of_units" value="{{ old('number_of_units', $property->number_of_units) }}" min="1" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('number_of_units') border-red-300 @enderror">
                    @error('number_of_units')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-2">Purchase Date</label>
                    <input type="date" id="purchase_date" name="purchase_date" value="{{ old('purchase_date', $property->purchase_date ? $property->purchase_date->format('Y-m-d') : '') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('purchase_date') border-red-300 @enderror">
                    @error('purchase_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-2">Purchase Price ($)</label>
                    <input type="number" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $property->purchase_price) }}" step="0.01" min="0"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('purchase_price') border-red-300 @enderror">
                    @error('purchase_price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Amenities -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Amenities</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="wifi" {{ in_array('wifi', old('amenities', $property->amenities ?? [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">WiFi</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="kitchen" {{ in_array('kitchen', old('amenities', $property->amenities ?? [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Kitchen</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="parking" {{ in_array('parking', old('amenities', $property->amenities ?? [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Parking</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="pool" {{ in_array('pool', old('amenities', $property->amenities ?? [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Pool</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="air_conditioning" {{ in_array('air_conditioning', old('amenities', $property->amenities ?? [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">AC</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="washer" {{ in_array('washer', old('amenities', $property->amenities ?? [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Washer</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="tv" {{ in_array('tv', old('amenities', $property->amenities ?? [])) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">TV</span>
                </label>
            </div>
            @error('amenities')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('amenities.*')
                 <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Images - Add New Images -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Add New Images</h2>
            <div class="mb-4">
                <label for="new_images" class="block text-sm font-medium text-gray-700 mb-2">Upload New Images</label>
                <input type="file" id="new_images" name="new_images[]" multiple accept="image/*"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('new_images') border-red-300 @enderror @error('new_images.*') border-red-300 @enderror">
                @error('new_images')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('new_images.*')
                     <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">You can select multiple images. Supported formats: JPG, JPEG, PNG, GIF, WebP. Max size: 2MB each.</p>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('properties.show', $property) }}"
               class="px-6 py-3 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium transition-colors duration-200">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-emerald-600 text-white hover:bg-emerald-700 rounded-lg font-medium transition-colors duration-200">
                Update Property
            </button>
        </div>
    </form>
</div>

<script>
function removeImage(imageId) {
    if (confirm('Are you sure you want to remove this image?')) {
        // Hide the image container
        const imageElement = document.querySelector(`[id='image_${imageId}']`).closest('.relative');
        imageElement.style.display = 'none';
        
        // Mark the image for removal by changing the input name
        const input = document.querySelector(`[id='image_${imageId}']`);
        input.name = 'remove_images[]';
    }
}
</script>
@endsection