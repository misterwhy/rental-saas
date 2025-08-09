@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Add New Property</h1>
            <p class="text-gray-500 text-sm mt-1">Create a new property listing</p>
        </div>
        <a href="{{ route('properties.index') }}"
           class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Properties
        </a>
    </div>
</div>

<div class="dashboard-card max-w-4xl">
    <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Property Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('title') border-red-300 @enderror">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('description') border-red-300 @enderror">{{ old('description') }}</textarea>
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
                    <input type="text" id="address" name="address" value="{{ old('address') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('address') border-red-300 @enderror">
                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <input type="text" id="city" name="city" value="{{ old('city') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('city') border-red-300 @enderror">
                    @error('city')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                    <input type="text" id="state" name="state" value="{{ old('state') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('state') border-red-300 @enderror">
                    @error('state')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">ZIP Code</label>
                    <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('zip_code') border-red-300 @enderror">
                    @error('zip_code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" id="country" name="country" value="{{ old('country') }}" required
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
                        <option value="Apartment" {{ old('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="House" {{ old('property_type') == 'House' ? 'selected' : '' }}>House</option>
                        <option value="Condo" {{ old('property_type') == 'Condo' ? 'selected' : '' }}>Condo</option>
                        <option value="Townhouse" {{ old('property_type') == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                        <option value="Cabin" {{ old('property_type') == 'Cabin' ? 'selected' : '' }}>Cabin</option>
                    </select>
                    @error('property_type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="number_of_units" class="block text-sm font-medium text-gray-700 mb-2">Number of Units</label>
                    <input type="number" id="number_of_units" name="number_of_units" value="{{ old('number_of_units', 1) }}" min="1" required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('number_of_units') border-red-300 @enderror">
                    @error('number_of_units')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-2">Purchase Date</label>
                    <input type="date" id="purchase_date" name="purchase_date" value="{{ old('purchase_date') }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('purchase_date') border-red-300 @enderror">
                    @error('purchase_date')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-2">Purchase Price ($)</label>
                    <input type="number" id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}" step="0.01" min="0"
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
                    <input type="checkbox" name="amenities[]" value="wifi" {{ is_array(old('amenities')) && in_array('wifi', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">WiFi</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="kitchen" {{ is_array(old('amenities')) && in_array('kitchen', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Kitchen</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="parking" {{ is_array(old('amenities')) && in_array('parking', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Parking</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="pool" {{ is_array(old('amenities')) && in_array('pool', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Pool</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="air_conditioning" {{ is_array(old('amenities')) && in_array('air_conditioning', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">AC</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="washer" {{ is_array(old('amenities')) && in_array('washer', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Washer</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="tv" {{ is_array(old('amenities')) && in_array('tv', old('amenities')) ? 'checked' : '' }}
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

        <!-- Images -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Property Images</h2>
            <div class="mb-4">
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Upload Images</label>
                <input type="file" id="images" name="images[]" multiple accept="image/*"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('images') border-red-300 @enderror @error('images.*') border-red-300 @enderror">
                @error('images')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                     <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">You can select multiple images. Supported formats: JPG, JPEG, PNG, GIF, WebP. Max size: 2MB each.</p>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <a href="{{ route('properties.index') }}"
               class="px-6 py-3 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 rounded-lg font-medium transition-colors duration-200">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-3 bg-emerald-600 text-white hover:bg-emerald-700 rounded-lg font-medium transition-colors duration-200">
                Create Property
            </button>
        </div>
    </form>
</div>
@endsection