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

                <!-- Square Footage -->
                <div>
                    <label for="square_footage" class="block text-sm font-medium text-gray-700 mb-2">Square Footage</label>
                    <input type="number" 
                           id="square_footage" 
                           name="square_footage" 
                           value="{{ old('square_footage') }}" 
                           min="0"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('square_footage') border-red-300 @enderror">
                    @error('square_footage')
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

                <!-- Security Deposit -->
                <div>
                    <label for="security_deposit" class="block text-sm font-medium text-gray-700 mb-2">Security Deposit ($)</label>
                    <input type="number" 
                           id="security_deposit" 
                           name="security_deposit" 
                           value="{{ old('security_deposit') }}" 
                           min="0" 
                           step="0.01"
                           class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('security_deposit') border-red-300 @enderror">
                    @error('security_deposit')
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
                          class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-colors @error('description') border-red-300 @enderror"
                          placeholder="Describe your property...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
