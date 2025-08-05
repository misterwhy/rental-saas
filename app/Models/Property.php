<?php
// app/Models/Property.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name', 
        'slug',
        'description',
        'address',
        'city',
        'state',
        'country',
        'zipcode',
        'price',
        'bedrooms',
        'bathrooms',
        'area',
        'type',
        'status',
        'featured',
        'images'
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
        'featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($property) {
            $property->slug = Str::slug($property->name);
        });
        
        static::updating(function ($property) {
            $property->slug = Str::slug($property->name);
        });
    }

    // Proper relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Scopes for better querying
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeInCity($query, $city)
    {
        return $query->where('city', $city);
    }

    // Accessors
    public function getMainImageAttribute()
    {
        return $this->images && is_array($this->images) ? $this->images[0] : null;
    }

    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }
}