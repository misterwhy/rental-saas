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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            Cancel
        </a>
    </div>
</div>

<div class="dashboard-card max-w-4xl">
    <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Property Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Property Title</label>
                    <input type="text" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('title') border-red-300 @enderror"
                           placeholder="Enter property title">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Property Type -->
                <div>
                    <label for="property_type" class="block text-sm font-medium text-gray-700 mb-2">Property Type</label>
                    <select id="property_type" 
                            name="property_type" 
                            required
                            class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('property_type') border-red-300 @enderror">
                        <option value="">Select property type</option>
                        <option value="apartment" {{ old('property_type') == 'apartment' ? 'selected' : '' }}>Apartment</option>
                        <option value="house" {{ old('property_type') == 'house' ? 'selected' : '' }}>House</option>
                        <option value="condo" {{ old('property_type') == 'condo' ? 'selected' : '' }}>Condo</option>
                        <option value="studio" {{ old('property_type') == 'studio' ? 'selected' : '' }}>Studio</option>
                        <option value="townhouse" {{ old('property_type') == 'townhouse' ? 'selected' : '' }}>Townhouse</option>
                    </select>
                    @error('property_type')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Property Details -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Property Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Bedrooms -->
                <div>
                    <label for="bedrooms" class="block text-sm font-medium text-gray-700 mb-2">Bedrooms</label>
                    <input type="number" 
                           id="bedrooms" 
                           name="bedrooms" 
                           value="{{ old('bedrooms') }}" 
                           min="0" 
                           required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('bedrooms') border-red-300 @enderror">
                    @error('bedrooms')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bathrooms -->
                <div>
                    <label for="bathrooms" class="block text-sm font-medium text-gray-700 mb-2">Bathrooms</label>
                    <input type="number" 
                           id="bathrooms" 
                           name="bathrooms" 
                           value="{{ old('bathrooms') }}" 
                           min="0" 
                           step="0.5"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('bathrooms') border-red-300 @enderror">
                    @error('bathrooms')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Max Guests -->
                <div>
                    <label for="max_guests" class="block text-sm font-medium text-gray-700 mb-2">Max Guests</label>
                    <input type="number" 
                           id="max_guests" 
                           name="max_guests" 
                           value="{{ old('max_guests') }}" 
                           min="1"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('max_guests') border-red-300 @enderror">
                    @error('max_guests')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Location -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Location</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Full Address</label>
                    <input type="text" 
                           id="address" 
                           name="address" 
                           value="{{ old('address') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('address') border-red-300 @enderror"
                           placeholder="Enter complete address">
                    @error('address')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <input type="text" 
                           id="city" 
                           name="city" 
                           value="{{ old('city') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('city') border-red-300 @enderror">
                    @error('city')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- State -->
                <div>
                    <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                    <input type="text" 
                           id="state" 
                           name="state" 
                           value="{{ old('state') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('state') border-red-300 @enderror">
                    @error('state')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Zip Code -->
                <div>
                    <label for="zip_code" class="block text-sm font-medium text-gray-700 mb-2">Zip Code</label>
                    <input type="text" 
                           id="zip_code" 
                           name="zip_code" 
                           value="{{ old('zip_code') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('zip_code') border-red-300 @enderror">
                    @error('zip_code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Country -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" 
                           id="country" 
                           name="country" 
                           value="{{ old('country', 'USA') }}" 
                           required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('country') border-red-300 @enderror">
                    @error('country')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Pricing -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Price per Night -->
                <div>
                    <label for="price_per_night" class="block text-sm font-medium text-gray-700 mb-2">Price per Night ($)</label>
                    <input type="number" 
                           id="price_per_night" 
                           name="price_per_night" 
                           value="{{ old('price_per_night') }}" 
                           min="0" 
                           step="0.01" 
                           required
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('price_per_night') border-red-300 @enderror">
                    @error('price_per_night')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Description -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Description</h3>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Property Description</label>
                <textarea id="description" 
                          name="description" 
                          rows="4" 
                          required
                          class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('description') border-red-300 @enderror"
                          placeholder="Describe your property...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Amenities -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Amenities</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="wifi" 
                           {{ is_array(old('amenities')) && in_array('wifi', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">WiFi</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="kitchen" 
                           {{ is_array(old('amenities')) && in_array('kitchen', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Kitchen</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="parking" 
                           {{ is_array(old('amenities')) && in_array('parking', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Parking</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="pool" 
                           {{ is_array(old('amenities')) && in_array('pool', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Pool</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="air_conditioning" 
                           {{ is_array(old('amenities')) && in_array('air_conditioning', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">AC</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="washer" 
                           {{ is_array(old('amenities')) && in_array('washer', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">Washer</span>
                </label>
                <label class="flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="amenities[]" value="tv" 
                           {{ is_array(old('amenities')) && in_array('tv', old('amenities')) ? 'checked' : '' }}
                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                    <span class="text-sm text-gray-700">TV</span>
                </label>
            </div>
        </div>

        <!-- Property Images -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Property Images</h3>
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Upload Images</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                <span>Upload files</span>
                                <input id="images" name="images[]" type="file" multiple accept="image/*" class="sr-only">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB each</p>
                    </div>
                </div>
                @error('images')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
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

                    <!-- State, Zip, Country Row -->
                    <div class="row mb-3" style="padding: 0 12px;">
                        <div class="col-md-4">
                            <label for="state" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">State</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror"
                                   id="state" name="state" value="{{ old('state') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('state')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="zip_code" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Zip Code</label>
                            <input type="text" class="form-control @error('zip_code') is-invalid @enderror"
                                   id="zip_code" name="zip_code" value="{{ old('zip_code') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('zip_code')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="country" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Country</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror"
                                   id="country" name="country" value="{{ old('country', 'USA') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('country')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Price, Bedrooms, Bathrooms, Guests Row -->
                    <div class="row mb-3" style="padding: 0 12px;">
                        <div class="col-md-3">
                            <label for="price_per_night" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Price/Night ($)</label>
                            <input type="number" class="form-control @error('price_per_night') is-invalid @enderror"
                                   id="price_per_night" name="price_per_night" value="{{ old('price_per_night') }}"
                                   step="0.01" min="0" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('price_per_night')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="bedrooms" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Bedrooms</label>
                            <input type="number" class="form-control @error('bedrooms') is-invalid @enderror"
                                   id="bedrooms" name="bedrooms" value="{{ old('bedrooms', 1) }}"
                                   min="0" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('bedrooms')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="bathrooms" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Bathrooms</label>
                            <input type="number" class="form-control @error('bathrooms') is-invalid @enderror"
                                   id="bathrooms" name="bathrooms" value="{{ old('bathrooms', 1) }}"
                                   min="0" step="0.5" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('bathrooms')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="max_guests" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Max Guests</label>
                            <input type="number" class="form-control @error('max_guests') is-invalid @enderror"
                                   id="max_guests" name="max_guests" value="{{ old('max_guests', 2) }}"
                                   min="1" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('max_guests')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="mb-3" style="padding: 0 12px;">
                        <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Amenities</label>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="wifi" id="wifi"
                                           {{ is_array(old('amenities')) && in_array('wifi', old('amenities')) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="wifi" style="font-size: 0.85rem;">WiFi</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="kitchen" id="kitchen"
                                           {{ is_array(old('amenities')) && in_array('kitchen', old('amenities')) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="kitchen" style="font-size: 0.85rem;">Kitchen</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="parking" id="parking"
                                           {{ is_array(old('amenities')) && in_array('parking', old('amenities')) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="parking" style="font-size: 0.85rem;">Parking</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="pool" id="pool"
                                           {{ is_array(old('amenities')) && in_array('pool', old('amenities')) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="pool" style="font-size: 0.85rem;">Pool</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="air_conditioning" id="air_conditioning"
                                           {{ is_array(old('amenities')) && in_array('air_conditioning', old('amenities')) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="air_conditioning" style="font-size: 0.85rem;">AC</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="washer" id="washer"
                                           {{ is_array(old('amenities')) && in_array('washer', old('amenities')) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="washer" style="font-size: 0.85rem;">Washer</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="tv" id="tv"
                                           {{ is_array(old('amenities')) && in_array('tv', old('amenities')) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="tv" style="font-size: 0.85rem;">TV</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload Section -->
                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="images" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Property Images</label>
                        <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                               id="images" name="images[]" multiple accept="image/*"
                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                        <div class="form-text" style="font-size: 0.75rem; color: var(--text-color-secondary); margin-top: 0.25rem;">You can select multiple images. First image will be the main image.</div>
                        @error('images.*')
                            <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                        @error('images')
                            <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-3" style="padding: 15px 12px 12px 12px; text-align: center;">
                        <button type="submit" class="save-btn">Create Property</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection