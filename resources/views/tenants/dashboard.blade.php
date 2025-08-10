{{-- resources/views/tenants/dashboard.blade.php --}}
@extends('layouts.app') {{-- Adjust layout as needed --}}

@section('title', 'My Property')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Property Information</h1>
            <p class="text-gray-600">Details about the property you are renting.</p>
        </div>

        @if ($property)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Property Details Card -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">{{ $property->name }}</h2>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Address</h3>
                                    <address class="mt-1 text-sm text-gray-900 not-italic">
                                        {{ $property->address }}<br>
                                        {{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}<br>
                                        {{ $property->country }}
                                    </address>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Property Type</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ $property->property_type }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Units</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ $property->number_of_units }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Monthly Rent</h3>
                                    <p class="mt-1 text-sm text-gray-900">${{ number_format($property->purchase_price, 2) }}</p> {{-- Assuming purchase_price is rent --}}
                                </div>
                                @if ($lease && $lease->start_date)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Lease Start Date</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($lease->start_date)->format('F j, Y') }}</p>
                                </div>
                                @endif
                                @if ($lease && $lease->end_date)
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Lease End Date</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($lease->end_date)->format('F j, Y') }}</p>
                                </div>
                                @endif
                            </div>

                            @if ($property->description)
                            <div class="mt-6">
                                <h3 class="text-sm font-medium text-gray-500">Description</h3>
                                <p class="mt-1 text-sm text-gray-900">{{ $property->description }}</p>
                            </div>
                            @endif

                            @if (!empty($property->amenities))
                            <div class="mt-6">
                                <h3 class="text-sm font-medium text-gray-500">Amenities</h3>
                                <div class="mt-2 flex flex-wrap gap-2">
                                    @foreach ($property->amenities as $amenity)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ ucfirst(str_replace('_', ' ', $amenity)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Landlord Information Card -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">Landlord Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-600 font-bold">{{ strtoupper(substr($property->owner->name ?? 'U', 0, 1)) }}</span>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-base font-medium text-gray-900">{{ $property->owner->name ?? 'N/A' }}</h3>
                                    @if ($property->owner->email ?? null)
                                        <p class="text-sm text-gray-500">{{ $property->owner->email }}</p>
                                    @endif
                                    <!-- Add phone number or other contact details if available -->
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('messages.create', ['recipient' => $property->owner->id ?? 0]) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Contact Landlord
                                </a>
                                <p class="mt-2 text-xs text-gray-500">You can send a message to your landlord.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Property Images and Actions Card -->
                <div class="space-y-6">
                     <!-- Property Images -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">Property Images</h2>
                        </div>
                        <div class="p-6">
                            @if ($property->images->isNotEmpty())
                                <div class="grid grid-cols-1 gap-4">
                                     @php
                                        $mainImage = $property->images->firstWhere('is_main', 1) ?? $property->images->first();
                                     @endphp
                                     @if($mainImage && ($mainImage->image_path || $mainImage->image_url))
                                        <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                            <img src="{{ $mainImage->image_path ? asset('storage/' . $mainImage->image_path) : $mainImage->image_url }}"
                                                 alt="Main image of {{ $property->name }}"
                                                 class="w-full h-full object-cover">
                                        </div>
                                     @endif

                                     @if($property->images->count() > 1)
                                        <div class="grid grid-cols-3 gap-2 mt-2">
                                            @foreach ($property->images as $image)
                                                @if ($image->id !== $mainImage->id)
                                                    <div class="aspect-square bg-gray-50 rounded overflow-hidden">
                                                        @if($image->image_path || $image->image_url)
                                                            <img src="{{ $image->image_path ? asset('storage/' . $image->image_path) : $image->image_url }}"
                                                                 alt="Image of {{ $property->name }}"
                                                                 class="w-full h-full object-cover">
                                                        @else
                                                            <div class="flex items-center justify-center h-full text-gray-400 text-xs">No Img</div>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No images</h3>
                                    <p class="mt-1 text-sm text-gray-500">This property doesn't have any images yet.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions Card (Optional) -->
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900">Quick Actions</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <a href="{{ route('rent-payments.index') }}" class="block w-full text-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                View Rent Payments
                            </a>
                            <a href="{{ route('maintenance-requests.index') }}" class="block w-full text-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                Submit Maintenance Request
                            </a>
                            <!-- Add more links to relevant tenant features -->
                        </div>
                    </div>
                </div>
            </div>
        @else
             <!-- This case should ideally be handled by the no_property view, but just in case -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Property Information Unavailable</h3>
                    <p class="mt-1 text-sm text-gray-500">We couldn't load your property details. Please contact your landlord.</p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection