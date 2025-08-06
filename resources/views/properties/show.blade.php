@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-xl font-semibold text-gray-900">{{ $property->title }}</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $property->address }}, {{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}</p>
        </div>
        <div class="flex space-x-3">
            @auth
                @if(auth()->user()->isLandlord() && auth()->id() === $property->landlord_id)
                    <a href="{{ route('properties.edit', $property) }}" 
                       class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white hover:bg-emerald-700 rounded-lg font-medium transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Property
                    </a>
                    <form method="POST" action="{{ route('properties.destroy', $property) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-lg font-medium transition-colors duration-200"
                                onclick="return confirm('Are you sure you want to delete this property?')">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </form>
                @elseif(auth()->user()->isTenant())
                    <a href="{{ route('properties.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white hover:bg-emerald-700 rounded-lg font-medium transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Book Now
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white hover:bg-emerald-700 rounded-lg font-medium transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Login to Book
                </a>
            @endauth
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Property Image -->
    <div class="dashboard-card">
        <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
        @if($property->main_image)
            <img src="{{ asset('storage/' . $property->main_image) }}" 
                alt="{{ $property->title }}"
                class="w-full h-full object-cover">
        @else
            <img src="{{ asset('storage/images/default-property.jpg') }}" 
                alt="Default Property"
                class="w-full h-full object-cover">
        @endif
        </div>
    </div>

    <!-- Property Details -->
    <div class="dashboard-card">
        <div class="space-y-6">
            <!-- Property Type & Price -->
            <div class="flex justify-between items-start">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                        {{ ucfirst($property->property_type) }}
                    </span>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-gray-900">${{ number_format($property->price_per_night, 2) }}</div>
                    <div class="text-sm text-gray-500">per night</div>
                </div>
            </div>

            <!-- Property Features -->
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="flex justify-center mb-2">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        </svg>
                    </div>
                    <div class="text-lg font-semibold text-gray-900">{{ $property->bedrooms }}</div>
                    <div class="text-sm text-gray-500">Bedrooms</div>
                </div>
                <div class="text-center">
                    <div class="flex justify-center mb-2">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path>
                        </svg>
                    </div>
                    <div class="text-lg font-semibold text-gray-900">{{ $property->bathrooms }}</div>
                    <div class="text-sm text-gray-500">Bathrooms</div>
                </div>
                <div class="text-center">
                    <div class="flex justify-center mb-2">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="text-lg font-semibold text-gray-900">{{ $property->max_guests ?? 'N/A' }}</div>
                    <div class="text-sm text-gray-500">Max Guests</div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                <p class="text-gray-600 leading-relaxed">{{ $property->description }}</p>
            </div>

            <!-- Amenities -->
            @if($property->amenities && count($property->amenities) > 0)
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Amenities</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach($property->amenities as $amenity)
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-emerald-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $amenity)) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Landlord Information -->
@if($property->landlord)
<div class="mt-8">
    <div class="dashboard-card">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Hosted by {{ $property->landlord->name }}</h3>
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <div class="font-medium text-gray-900">{{ $property->landlord->name }}</div>
                <div class="text-sm text-gray-500">{{ $property->landlord->email }}</div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection