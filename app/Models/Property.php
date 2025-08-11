<?php
// app/Models/Property.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'tenant_id',
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
        // Removed 'slug' since it's not in database
    ];

    protected $casts = [
        'amenities' => 'array',
        'purchase_date' => 'date',
        'purchase_price' => 'decimal:2'
    ];

    // Relationships
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * Get all leases for this property
     */
    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    /**
     * Get active leases for this property
     */
    public function activeLeases()
    {
        return $this->leases()->where('status', 'active');
    }

    /**
     * Get rent payments for this property
     */
    public function rentPayments()
    {
        return $this->hasMany(RentPayment::class);
    }

    /**
     * Accessor to get the main image for the property.
     */
    public function mainImage()
    {
        return $this->hasOne(Image::class)->where('is_main', 1);
    }
    
    public function getMainImageAttribute()
    {
        return $this->images()->where('is_main', 1)->first();
    }

    // Financial Calculations
    public function getEstimatedAnnualGrossIncomeAttribute()
    {
        return null;
    }

    public function getEstimatedAnnualExpensesAttribute()
    {
        return null;
    }

    public function getEstimatedNoiAttribute()
    {
        $income = $this->estimated_annual_gross_income ?? 0;
        $expenses = $this->estimated_annual_expenses ?? 0;
        return $income - $expenses;
    }

    public function getEstimatedCapRateAttribute()
    {
        $noi = $this->estimated_noi ?? 0;
        if ($this->purchase_price && $this->purchase_price > 0) {
            return ($noi / $this->purchase_price) * 100;
        }
        return 0;
    }
}