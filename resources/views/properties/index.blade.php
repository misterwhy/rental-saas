@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl font-regular text-gray-900">Properties </h1>
            <span class="text-gray-500 text-xs mt-1">Manage your property listings</span>
        </div>
        @auth
            @if(auth()->user()->isLandlord())
                <a href="{{ route('properties.create') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Property
                </a>
            @endif
        @endauth
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @if($properties->count() > 0)
        @foreach($properties as $property)
            <div class="dashboard-card group hover:shadow-lg transition-all duration-200">
                <!-- Property Image -->
                <div class="relative mb-4 overflow-hidden rounded-xl">
                    @if($property->main_image)
                        <img src="{{ asset('storage/' . $property->main_image) }}" 
                             alt="{{ $property->title }}" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-200">
                    @else
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center rounded-xl">
                            <div class="text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm">No Image</span>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Property Type Badge -->
                    <div class="absolute top-3 left-3">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-gray-800 shadow-sm">
                            {{ $property->property_type }}
                        </span>
                    </div>
                    
                    <!-- Favorite Button -->
                    <button class="absolute top-3 right-3 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                </div>

                <!-- Property Details -->
                <div class="space-y-3">
                    <!-- Title and Location -->
                    <div>
                        <h3 class="font-semibold text-gray-900 text-lg leading-tight">{{ $property->title }}</h3>
                        <p class="text-gray-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $property->address ?? 'Location not specified' }}
                        </p>
                    </div>

                    <!-- Property Features -->
                    <div class="flex items-center space-x-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2V7a2 2 0 002-2h14a2 2 0 012 2z"></path>
                            </svg>
                            {{ $property->bedrooms }} beds
                        </div>
                        @if($property->bathrooms)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10v11M20 10v11"></path>
                            </svg>
                            {{ $property->bathrooms }} baths
                        </div>
                        @endif
                        @if($property->square_footage)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                            </svg>
                            {{ number_format($property->square_footage) }} sqft
                        </div>
                        @endif
                    </div>

                    <!-- Landlord Info -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face&auto=format" 
                                 alt="{{ $property->landlord->name }}" 
                                 class="w-8 h-8 rounded-full">
                            <span class="text-sm text-gray-600 ml-2">{{ $property->landlord->name }}</span>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Available
                        </span>
                    </div>

                    <!-- Price and Action -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div>
                            <span class="text-2xl font-bold text-gray-900">${{ number_format($property->price_per_night, 0) }}</span>
                            <span class="text-gray-500 text-sm">/night</span>
                        </div>
                        <a href="{{ route('properties.show', $property) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-900 hover:bg-gray-800 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                            View Details
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="col-span-full">
            <div class="dashboard-card text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No properties found</h3>
                <p class="text-gray-500 mb-6">Get started by adding your first property listing.</p>
                @auth
                    @if(auth()->user()->isLandlord())
                        <a href="{{ route('properties.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Your First Property
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    @endif
</div>

@if($properties->hasPages())
<div class="mt-8 flex justify-center">
    {{ $properties->appends(request()->query())->links() }}
</div>
@endif
@endsection
