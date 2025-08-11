<!-- In resources/views/properties/assign-tenant.blade.php -->
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('landlord.properties.show', $property) }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Property
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Assign Existing Tenant to Property</h2>
                <p class="mt-1 text-gray-600">Property: {{ $property->name }}</p>
            </div>

            <form method="POST" action="{{ route('landlord.properties.assign-tenant', $property) }}" class="p-6">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="tenant_email" class="block text-sm font-medium text-gray-700 mb-1">
                            Tenant Email
                        </label>
                        <input type="email" 
                               name="tenant_email" 
                               id="tenant_email"
                               value="{{ old('tenant_email') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                               required>
                        <p class="mt-1 text-sm text-gray-500">
                            Enter the email of an existing user. If they're not already a tenant, they will be converted to one.
                        </p>
                        @error('tenant_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('landlord.properties.show', $property) }}" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                            Assign Tenant
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection