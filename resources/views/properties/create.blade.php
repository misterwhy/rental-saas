@extends('layouts.app')

@section('content')
<div class="content-wrap">
    <div class="content-head">
        <h1>Add New Property</h1>
        <div class="action">
            <a href="{{ route('dashboard') }}" class="edit-btn">Cancel</a>
        </div>
    </div>

    <div class="room-grid">
        <div class="card111">
            <div class="details111">
                <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Title and Type Row -->
                    <div class="row mb-3" style="padding: 0 12px;">
                        <div class="col-md-6">
                            <label for="title" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Property Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   id="title" name="title" value="{{ old('title') }}" required
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
                                <option value="Apartment" {{ old('property_type') == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                <option value="House" {{ old('property_type') == 'House' ? 'selected' : '' }}>House</option>
                                <option value="Condo" {{ old('property_type') == 'Condo' ? 'selected' : '' }}>Condo</option>
                                <option value="Townhouse" {{ old('property_type') == 'Townhouse' ? 'selected' : '' }}>Townhouse</option>
                                <option value="Cabin" {{ old('property_type') == 'Cabin' ? 'selected' : '' }}>Cabin</option>
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
                                  style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem; resize: vertical;">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address Row -->
                    <div class="row mb-3" style="padding: 0 12px;">
                        <div class="col-md-6">
                            <label for="address" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">Address</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror"
                                   id="address" name="address" value="{{ old('address') }}" required
                                   style="width: 100%; padding: 0.5rem; border: 1px solid var(--border-color); border-radius: 5px; background-color: var(--info-bg); color: var(--text-color); font-size: 0.9rem;">
                            @error('address')
                                <div class="invalid-feedback" style="font-size: 0.75rem; color: #ef4444; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="form-label" style="font-size: 0.85rem; font-weight: 600; color: var(--text-color); display: block; margin-bottom: 0.3rem;">City</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror"
                                   id="city" name="city" value="{{ old('city') }}" required
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