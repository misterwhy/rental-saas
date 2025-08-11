<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type', // This is your role field
        'phone',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user is a landlord.
     *
     * @return bool
     */
    public function isLandlord()
    {
        return $this->user_type === 'landlord';
    }

    /**
     * Check if the user is a tenant.
     *
     * @return bool
     */
    public function isTenant()
    {
        return $this->user_type === 'tenant';
    }

    /**
     * Properties owned by this landlord
     */
    public function properties()
    {
        // Make sure 'owner_id' matches the foreign key in your properties table
        return $this->hasMany(Property::class, 'owner_id');
    }

    /**
     * Leases for this tenant
     */
    public function leases()
    {
        return $this->hasMany(Lease::class, 'tenant_id');
    }

    /**
     * Rent payments made by this tenant
     */
    public function rentPayments()
    {
        return $this->hasMany(RentPayment::class, 'tenant_id');
    }

    /**
     * Maintenance requests submitted by this tenant
     */
    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class, 'tenant_id');
    }

    /**
     * Get profile photo URL
     */
    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path 
            ? asset('storage/' . $this->profile_photo_path) 
            : asset('images/default-profile.png');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class)->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }


}