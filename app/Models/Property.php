<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'price_per_night',
        'bedrooms',
        'bathrooms',
        'max_guests',
        'property_type',
        'amenities',
        'landlord_id',
        'is_active',
    ];

    protected $casts = [
        'amenities' => 'array',
        'is_active' => 'boolean',
        'price_per_night' => 'decimal:2',
    ];

    public function landlord()
    {
        return $this->belongsTo(User::class, 'landlord_id');
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getMainImageAttribute()
    {
        $mainImage = $this->images()->where('is_main', true)->first();
        if (!$mainImage) {
            $mainImage = $this->images()->first();
        }
        return $mainImage ? $mainImage->image_path : null;
    }
}