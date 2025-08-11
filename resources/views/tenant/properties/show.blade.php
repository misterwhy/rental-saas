{{-- resources/views/tenant/properties/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('tenant.properties.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Properties
            </a>
        </div>

        <!-- Property Header -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-6 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-3 mb-3">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $property->name }}</h1>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                {{ ucfirst(str_replace('_', ' ', $property->property_type)) }}
                            </span>
                            @if($property->number_of_units > 1)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    {{ $property->number_of_units }} Units
                                </span>
                            @endif
                        </div>
                        <p class="text-gray-600 text-lg flex items-center">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ $property->address }}, {{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}
                        </p>
                    </div>
                    
                    <div class="mt-4 lg:mt-0 lg:ml-6">
                        @if($property->purchase_price)
                            <div class="text-right">
                                <div class="text-3xl font-bold text-gray-900">${{ number_format($property->purchase_price, 2) }}</div>
                                <div class="text-sm text-gray-500">Monthly Rent</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Property Images Section -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Main Image -->
                    <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden mb-4">
                        @if($property->mainImage && $property->mainImage->image_path)
                            <img src="{{ asset('storage/' . $property->mainImage->image_path) }}" 
                                alt="{{ $property->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <img src="{{ asset('images/default-property.jpg') }}" 
                                alt="Default Property"
                                class="w-full h-full object-cover">
                        @endif
                    </div>

                    <!-- Image Gallery -->
                    @if($property->images && $property->images->count() > 1)
                        <div class="px-6 pb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Property Photos</h3>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                @foreach($property->images as $image)
                                    @if($image->image_path)
                                        <div class="relative group overflow-hidden rounded-lg cursor-pointer">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                alt="{{ $property->name }} - Image {{ $loop->iteration }}"
                                                class="w-full h-24 object-cover transition-transform duration-300 group-hover:scale-105">
                                            @if($image->is_main)
                                                <div class="absolute top-1 right-1 bg-blue-600 text-white text-xs px-1 py-0.5 rounded">
                                                    Main
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @elseif($property->images && $property->images->count() == 1)
                        <div class="px-6 pb-6 text-center py-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">This property has {{ $property->images->count() }} photo</p>
                        </div>
                    @else
                        <div class="px-6 pb-6 text-center py-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-500 text-sm">No additional photos available</p>
                        </div>
                    @endif
                </div>
                
                <!-- Property Description -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Description</h2>
                    </div>
                    <div class="p-6">
                        @if($property->description)
                            <div class="prose max-w-none text-gray-700">
                                <p class="leading-relaxed">{{ $property->description }}</p>
                            </div>
                        @else
                            <p class="text-gray-500 italic">No description provided for this property.</p>
                        @endif
                    </div>
                </div>

                <!-- Property Details -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Property Details</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Property Type</span>
                                    <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $property->property_type)) }}</span>
                                </div>
                                
                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Number of Units</span>
                                    <span class="font-medium text-gray-900">{{ $property->number_of_units }}</span>
                                </div>
                                
                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Country</span>
                                    <span class="font-medium text-gray-900">{{ $property->country }}</span>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                @if($property->purchase_date)
                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Purchase Date</span>
                                        <span class="font-medium text-gray-900">{{ $property->purchase_date->format('F d, Y') }}</span>
                                    </div>
                                @endif
                                
                                @if($property->purchase_price)
                                    <div class="flex justify-between py-2 border-b border-gray-100">
                                        <span class="text-gray-600">Monthly Rent</span>
                                        <span class="font-medium text-gray-900">${{ number_format($property->purchase_price, 2) }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex justify-between py-2 border-b border-gray-100">
                                    <span class="text-gray-600">Status</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Landlord Information -->
                @if($property->owner)
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">Property Owner</h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <img src="{{ $property->owner->profile_photo_url }}" 
                                        alt="{{ $property->owner->name }}" 
                                        class="w-16 h-16 rounded-xl object-cover border-2 border-gray-200">
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $property->owner->name }}</h3>
                                    <p class="text-gray-500">{{ $property->owner->email }}</p>
                                    @if($property->owner->phone)
                                        <p class="text-gray-500 mt-1">{{ $property->owner->phone }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Amenities -->
                @if($property->amenities)
                    @php
                        $amenities = is_string($property->amenities) ? json_decode($property->amenities, true) : $property->amenities;
                    @endphp
                    @if($amenities && is_array($amenities) && count($amenities) > 0)
                        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-xl font-semibold text-gray-900">Amenities</h2>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                    @foreach($amenities as $amenity)
                                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $amenity)) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Property Stats -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Property Stats</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-600">Created</span>
                                </div>
                                <span class="font-medium text-gray-900">{{ $property->created_at->format('M d, Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-gray-600">Last Updated</span>
                                </div>
                                <span class="font-medium text-gray-900">{{ $property->updated_at->format('M d, Y') }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center py-2">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-gray-600">Total Images</span>
                                </div>
                                <span class="font-medium text-gray-900">{{ $property->images ? $property->images->count() : 0 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-900">Quick Actions</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('tenant.payments.index') }}?property_id={{ $property->id }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-3 bg-emerald-50 text-emerald-700 hover:bg-emerald-100 rounded-lg font-medium transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            View Payments
                        </a>
                        
                        <a href="#" 
                           class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg font-medium transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                            Contact Owner
                        </a>
                        
                        <a href="#" 
                           class="w-full inline-flex items-center justify-center px-4 py-3 bg-purple-50 text-purple-700 hover:bg-purple-100 rounded-lg font-medium transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Request Maintenance
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection