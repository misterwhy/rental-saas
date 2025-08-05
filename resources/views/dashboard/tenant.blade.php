@extends('layouts.app')

@section('content')
<div class="content-wrap">
    <div class="content-head">
        <h1>Tenant Dashboard</h1>
    </div>

    <div class="info-boxes">
        <div class="info-box">
            <div class="box-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.1 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg>
            </div>
            <div class="box-content">
                <div class="big">{{ $bookings->count() ?? 0 }}</div>
                <div class="small">Bookings</div>
            </div>
        </div>
        <div class="info-box">
            <div class="box-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            </div>
            <div class="box-content">
                <div class="big">0</div>
                <div class="small">Reviews</div>
            </div>
        </div>
        <div class="info-box">
            <div class="box-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
            </div>
            <div class="box-content">
                <div class="big">$0</div>
                <div class="small">Spent</div>
            </div>
        </div>
        <div class="info-box">
            <div class="box-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v2.16c-1.58.34-2.98 1.37-2.98 3.11 0 1.93 1.53 2.79 3.42 3.25 1.73.42 2.18.91 2.18 1.62 0 .81-.73 1.43-2.11 1.43-1.49 0-2.15-.72-2.2-1.64H8.5c.06 1.61 1.33 2.75 3.12 3.12V21h1.71v-2.19c1.74-.34 2.99-1.39 2.99-3.15 0-2.08-1.62-2.94-3.19-3.32z"/></svg>
            </div>
            <div class="box-content">
                <div class="big">0</div>
                <div class="small">Favorites</div>
            </div>
        </div>
    </div>

    <div class="room-grid">
        @if(isset($bookings) && $bookings->count() > 0)
            @foreach($bookings as $booking)
                <div class="card111">
                    <div class="header111">
                        <div class="header-text111">{{ $booking->property->property_type }}</div>
                    </div>
                    <div class="image-placeholder111">
                        @if($booking->property->main_image)
                            <img src="{{ asset('storage/' . $booking->property->main_image) }}" alt="{{ $booking->property->title }}">
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
                                {{ $booking->property->bedrooms }} beds
                            </div>
                            <div class="price1112">
                                <svg class="price11" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-1.72-1.12-3.3-3.21-3.81V3h-3v2.16c-1.94.42-3.5 1.68-3.5 3.61 0 2.31 1.91 3.46 4.7 4.13 2.5.6 3 1.48 3 2.41 0 .69-.49 1.79-2.7 1.79-2.06 0-2.87-.92-2.98-2.1h-2.2c.12 2.19 1.76 3.42 3.68 3.83V21h3v-2.15c1.95-.37 3.5-1.5 3.5-3.55 0-2.84-2.43-3.81-4.7-4.4z"/></svg>
                                <div class="price111">${{ number_format($booking->total_price, 2) }}</div>
                            </div>
                        </div>
                        <div class="card-Appaddress">
                            {{ $booking->property->title }}
                        </div>
                        <div class="user-info111">
                            <div class="user-name111">
                                <svg class="user-name11" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.1 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/></svg>
                                <div class="user-name1">{{ $booking->check_in_date->format('M d, Y') }} - {{ $booking->check_out_date->format('M d, Y') }}</div>
                            </div>
                            <div class="status111">
                                <div class="status1">{{ ucfirst($booking->status) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="editing-buttons">
                        <a href="{{ route('properties.show', $booking->property) }}" class="editing-buttons1">View Property</a>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card111">
                <div class="details111">
                    <p>You don't have any bookings yet. <a href="{{ route('properties.index') }}">Browse properties</a></p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection