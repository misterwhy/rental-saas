@extends('layouts.app')

@section('content')
<div class="content-wrap">
    <div class="content-head">
        <h1>{{ $property->title }}</h1>
        <div class="action">
            @auth
                @if(auth()->user()->isLandlord() && auth()->id() === $property->landlord_id)
                    <a href="{{ route('properties.edit', $property) }}" class="edit-btn">Edit Property</a>
                    <form method="POST" action="{{ route('properties.destroy', $property) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this property?')">Delete Property</button>
                    </form>
                @elseif(auth()->user()->isTenant())
                    <a href="{{ route('properties.index') }}" class="edit-btn">Book Now</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="save-btn">Login to Book</a>
            @endauth
        </div>
    </div>

    <div class="room-grid">
        <div class="card111">
            <div class="image-placeholder111">
                @if($property->main_image)
                    <img src="{{ asset('storage/' . $property->main_image) }}" alt="{{ $property->title }}">
                @else
                    <div style="background-color: #e0e0e0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">
                        <span style="color: #999;">No Image</span>
                    </div>
                @endif
            </div>
            <div class="details111">
                <div class="room-info111">
                    <div class="room-type111">
                        <svg class="bed-icon111" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M20 10V7c0-1.1-.9-2-2-2H6c-1.1 0-2 .9-2 2v3c-1.1 0-2 .9-2 2v5h1.5c.3 1.5 1.6 2.5 3 2.5s2.7-1 3-2.5h6c.3 1.5 1.6 2.5 3 2.5s2.7-1 3-2.5H22v-5c0-1.1-.9-2-2-2zm-9-3h2v3h-2V7zm-8 5h2v3H3v-3zm18 3h-2v-3h2v3z"/></svg>
                        {{ $property->bedrooms }} beds
                    </div>
                    <div class="price1112">
                        <svg class="price11" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                        <div class="price111">${{ number_format($property->price_per_night, 2) }}/night</div>
                    </div>
                </div>
                <div class="card-Appaddress">
                    {{ $property->address }}, {{ $property->city }}, {{ $property->state }} {{ $property->zip_code }}
                </div>
                <div class="user-info111">
                    <div class="user-name111">
                        <svg class="user-name11" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <div class="user-name1">Hosted by {{ $property->landlord->name }}</div>
                    </div>
                    <div class="status111">
                        <div class="status1">Available</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card111">
            <div class="details111">
                <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem;">Description</h3>
                <p style="margin-bottom: 1.5rem;">{{ $property->description }}</p>

                <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 1rem;">Amenities</h3>
                @if($property->amenities && is_array($property->amenities) && count($property->amenities) > 0)
                    <ul style="list-style: none; padding: 0; margin: 0;">
                        @foreach($property->amenities as $amenity)
                            <li style="margin-bottom: 0.5rem;">
                                <svg style="width: 16px; height: 16px; margin-right: 0.5rem; fill: var(--primary-color);" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                                {{ ucfirst(str_replace('_', ' ', $amenity)) }}
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No amenities listed.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection