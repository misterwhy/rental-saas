<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'user_type',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class, 'landlord_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'tenant_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function isLandlord()
    {
        return $this->user_type === 'landlord';
    }

    public function isTenant()
    {
        return $this->user_type === 'tenant';
    }
}