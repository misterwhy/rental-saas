{{-- resources/views/tenant/properties/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Properties</h1>
            <p class="text-gray-600 mt-1">Properties I'm renting</p>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-lg border border-red-200">
        {{ session('error') }}
    </div>
@endif

@if($properties->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($properties as $property)
            <div class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <!-- Property Image -->
                <div class="relative h-48 overflow-hidden">
                    @if($property->mainImage)
                        <img src="{{ asset('storage/' . $property->mainImage->image_path) }}" 
                            alt="{{ $property->name }}"
                            class="w-full h-full object-cover">
                    @else
                        <img src="{{ asset('images/default-property.jpg') }}" 
                            alt="Default Property"
                            class="w-full h-full object-cover">
                    @endif
                </div>

                <!-- Property Details -->
                <div class="p-4">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-gray-900 truncate">{{ $property->name }}</h3>
                        <span class="text-sm font-medium text-emerald-600">${{ number_format($property->purchase_price ?? 0) }}</span>
                    </div>

                    <p class="text-sm text-gray-600 mb-3 flex items-start">
                        <svg class="w-4 h-4 mr-1 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="truncate">{{ $property->city }}, {{ $property->state }}</span>
                    </p>

                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>{{ $property->number_of_units }} Units</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ $property->created_at->format('M Y') }}</span>
                        </div>
                    </div>

                    <!-- Landlord Info -->
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center">
                            @if($property->owner)
                                @if($property->owner->profile_photo_url)
                                    <img src="{{ $property->owner->profile_photo_url }}" 
                                        alt="{{ $property->owner->name }}" 
                                        class="w-6 h-6 rounded-full object-cover mr-2">
                                @else
                                    <div class="w-6 h-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-800 text-xs font-semibold mr-2">
                                        {{ substr($property->owner->name, 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-xs text-gray-600 truncate">{{ $property->owner->name }}</span>
                            @else
                                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-800 text-xs font-semibold mr-2">
                                    ?
                                </div>
                                <span class="text-xs text-gray-600">Unknown Owner</span>
                            @endif
                        </div>
                        <a href="{{ route('tenant.properties.show', $property) }}"
                        class="text-xs font-medium text-emerald-600 hover:text-emerald-800">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($properties->hasPages())
        <div class="mt-8">
            {{ $properties->links() }}
        </div>
    @endif
@else
    <div class="bg-white rounded-xl p-8 text-center shadow-sm border border-gray-100">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-1">No properties found</h3>
        <p class="text-gray-500">You don't have any properties assigned to you yet.</p>
    </div>
@endif
@endsection