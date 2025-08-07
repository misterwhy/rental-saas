<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'property_type',
        'number_of_units',
        'purchase_date',
        'purchase_price',
        'description',
        'amenities',
        'images'
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2'
    ];

    protected $dates = [
        'purchase_date',
        'created_at',
        'updated_at'
    ];

    // Relationships
public function owner()
{
    // Make sure 'owner_id' matches the foreign key column name in your properties table
    return $this->belongsTo(User::class, 'owner_id');
    // If the method is named 'owner', use that instead of 'landlord' in your Blade file.
}

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}