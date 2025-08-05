@extends('layouts.app')

@section('content')
<div class="content-wrap">
    <div class="content-head">
        <h1>Edit Property: {{ $property->title }}</h1>
        <div class="action">
            <a href="{{ route('properties.show', $property) }}" class="edit-btn">Cancel</a>
        </div>
    </div>

    <div class="room-grid">
        <div class="card111">
            <div class="details111">
                <form method="POST" action="{{ route('properties.update', $property) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Title and Type Row -->
                    <div class="row mb-3" style="padding: 0 12px;">
                        <div class="col-md-6">
                            <label for="title" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Property Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title', $property->title) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('title')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="property_type" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Property Type</label>
                            <select class="form-control @error('property_type') is-invalid @enderror"
                                    id="property_type" name="property_type" required
                                    style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                                <option value="">Select Type</option>
                                <option value="Apartment" {{ old('property_type', $property->property_type) == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="House" {{ old('property_type', $property->property_type) == 'House' ? 'selected' : '' }}>House</option>
                                <option value="Condo" {{ old('property_type', $property->property_type) == 'Condo' ? 'selected' : '' }}>Condo</option>
                                <option value="Townhouse" {{ old('property_type', $property->property_type) == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                                <option value="Cabin" {{ old('property_type', $property->property_type) == 'Cabin' ? 'selected' : '' }}>Cabin</option>
                            </select>
                            @error('property_type')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="description" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3" required
                                  style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem; resize: vertical;">{{ old('description', $property->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address Row -->
                    <div class="row mb-3" style="padding: 0 12px;">
                        <div class="col-md-6">
                            <label for="address" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                   id="address" name="address" value="{{ old('address', $property->address) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('address')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                   id="city" name="city" value="{{ old('city', $property->city) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('city')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- State, Zip, Country Row -->
                    <div class="row mb-3" style="padding: 0 12px;">
                        <div class="col-md-4">
                            <label for="state" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">State</label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror"
                                   id="state" name="state" value="{{ old('state', $property->state) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('state')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="zip_code" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Zip Code</label>
                            <input type="text" class="form-control @error('zip_code') is-invalid @enderror"
                                   id="zip_code" name="zip_code" value="{{ old('zip_code', $property->zip_code) }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('zip_code')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="country" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Country</label>
                            <input type="text" class="form-control @error('country') is-invalid @enderror"
                                   id="country" name="country" value="{{ old('country', $property->country) }}" required
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
                                   id="price_per_night" name="price_per_night" value="{{ old('price_per_night', $property->price_per_night) }}"
                                   step="0.01" min="0" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('price_per_night')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="bedrooms" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Bedrooms</label>
                            <input type="number" class="form-control @error('bedrooms') is-invalid @enderror"
                                   id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}"
                                   min="0" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('bedrooms')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="bathrooms" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Bathrooms</label>
                            <input type="number" class="form-control @error('bathrooms') is-invalid @enderror"
                                   id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}"
                                   min="0" step="0.5" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('bathrooms')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="max_guests" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Max Guests</label>
                            <input type="number" class="form-control @error('max_guests') is-invalid @enderror"
                                   id="max_guests" name="max_guests" value="{{ old('max_guests', $property->max_guests) }}"
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
                        @php
                            $propertyAmenities = is_array($property->amenities) ? $property->amenities : (is_string($property->amenities) ? json_decode($property->amenities, true) : []);
                            if (!is_array($propertyAmenities)) $propertyAmenities = [];
                        @endphp
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="wifi" id="wifi"
                                           {{ (is_array(old('amenities')) && in_array('wifi', old('amenities'))) || in_array('wifi', $propertyAmenities) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="wifi" style="font-size: 0.85rem;">WiFi</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="kitchen" id="kitchen"
                                           {{ (is_array(old('amenities')) && in_array('kitchen', old('amenities'))) || in_array('kitchen', $propertyAmenities) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="kitchen" style="font-size: 0.85rem;">Kitchen</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="parking" id="parking"
                                           {{ (is_array(old('amenities')) && in_array('parking', old('amenities'))) || in_array('parking', $propertyAmenities) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="parking" style="font-size: 0.85rem;">Parking</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="pool" id="pool"
                                           {{ (is_array(old('amenities')) && in_array('pool', old('amenities'))) || in_array('pool', $propertyAmenities) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="pool" style="font-size: 0.85rem;">Pool</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="air_conditioning" id="air_conditioning"
                                           {{ (is_array(old('amenities')) && in_array('air_conditioning', old('amenities'))) || in_array('air_conditioning', $propertyAmenities) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="air_conditioning" style="font-size: 0.85rem;">AC</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="washer" id="washer"
                                           {{ (is_array(old('amenities')) && in_array('washer', old('amenities'))) || in_array('washer', $propertyAmenities) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="washer" style="font-size: 0.85rem;">Washer</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check" style="margin-bottom: 0.5rem;">
                                    <input class="form-check-input" type="checkbox" name="amenities[]" value="tv" id="tv"
                                           {{ (is_array(old('amenities')) && in_array('tv', old('amenities'))) || in_array('tv', $propertyAmenities) ? 'checked' : '' }}
                                           style="margin-right: 0.5rem;">
                                    <label class="form-check-label" for="tv" style="font-size: 0.85rem;">TV</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Management Section -->
                    <div class="mb-3" style="padding: 0 12px;">
                        <label class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Current Images</label>
                        @if($property->images && $property->images->count() > 0)
                            <div class="row" style="margin-top: 10px;">
                                @foreach($property->images as $image)
                                    <div class="col-md-3 mb-3">
                                        <div class="card" style="border-radius: 10px; overflow: hidden; height: 180px; position: relative;">
                                            <img src="{{ asset('storage/' . $image->image_path) }}"
                                                 class="card-img-top" alt="Property image" style="width: 100%; height: 100%; object-fit: cover;">
                                            <div class="card-body p-2 text-center" style="position: absolute; bottom: 0; width: 100%; background: rgba(255, 255, 255, 0.8); display: flex; justify-content: center; gap: 5px; padding: 5px;">
                                                @if($image->is_main)
                                                    <span class="badge bg-primary" style="font-size: 0.6rem;">Main</span>
                                                @else
                                                    <form method="POST" action="{{ route('properties.images.set-main', $image) }}" class="d-inline">
                                                        @csrf
                                                        @method('POST')
                                                        <button type="submit" class="btn btn-sm btn-outline-primary" style="padding: 2px 5px; font-size: 0.6rem; border-radius: 3px;">Set Main</button>
                                                    </form>
                                                @endif
                                                <form method="POST" action="{{ route('properties.images.delete', $image) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            onclick="return confirm('Are you sure you want to delete this image?')"
                                                            style="padding: 2px 5px; font-size: 0.6rem; border-radius: 3px;">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted" style="font-size: 0.8rem;">No images uploaded yet.</p>
                        @endif
                    </div>

                    <div class="mb-3" style="padding: 0 12px;">
                        <label for="new_images" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Add New Images</label>
                        <input type="file" class="form-control" id="new_images" name="images[]" multiple accept="image/*"
                               style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                        <div class="form-text" style="font-size: 0.75rem; color: var(--text-color-secondary); margin-top: 0.25rem;">Select images to add to your property.</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mb-3" style="padding: 15px 12px 12px 12px; text-align: center;">
                        <button type="submit" class="save-btn">Update Property</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection