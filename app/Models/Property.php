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
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    /**
     * Accessor to get the main image for the property.
     */
    public function getMainImageAttribute()
    {
        if ($this->relationLoaded('images') && $this->images && $this->images->count() > 0) {
            $mainImage = $this->images->where('is_main', 1)->first();
            return $mainImage ?? $this->images->first();
        }

        $mainImage = $this->images()->where('is_main', 1)->first();
        return $mainImage ?? $this->images()->first();
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