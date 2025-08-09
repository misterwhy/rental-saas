<?php
// app/Models/Property.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name', // Assuming 'title' from form maps to 'name'
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
        // Check if the Unit model exists and is correctly linked.
        return $this->hasMany(Unit::class);
    }

    public function maintenanceRequests()
    {
         // Check if the MaintenanceRequest model exists and is correctly linked.
        return $this->hasMany(MaintenanceRequest::class);
    }

    public function images()
    {
        // Check if the Image model exists and is correctly linked.
        return $this->hasMany(Image::class);
    }

    /**
     * Accessor to get the main image for the property.
     * Assumes 'is_main' is stored as an integer (1/0).
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

    // --- Simplified Calculations Based ONLY on existing DB fields ---

    /**
     * Calculates the total potential units across all properties owned by the user.
     * This is essentially the sum of 'number_of_units' for all user's properties.
     * This specific calculation is better done in the controller by summing properties,
     * but having it as an accessor is fine if needed per property context elsewhere.
     */
    // public function getTotalPotentialUnitsAttribute() {
    //    return $this->number_of_units; // This is just the value itself for this property.
    // }

    /**
     * Calculates the total purchase value of all properties owned by the user.
     * This is the sum of 'purchase_price' for all user's properties.
     * Like above, summing in the controller is typical.
     */
    // public function getTotalPurchaseValueAttribute() {
    //    return $this->purchase_price; // This is just the value itself for this property.
    // }

     /**
     * Calculates the number of maintenance requests for this specific property.
     * This relies on the maintenanceRequests relationship.
     * This specific calculation is better done in the controller by counting related models,
     * but having it as an accessor is fine if needed per property context elsewhere.
     */
    // public function getMaintenanceRequestCountAttribute() {
    //    // Ensure relationship is loaded for efficiency if used in loops
    //    if ($this->relationLoaded('maintenanceRequests')) {
    //         return $this->maintenanceRequests->count();
    //    }
    //    return $this->maintenanceRequests()->count();
    // }


    // --- Placeholder Accessors (Cannot be calculated accurately without new data) ---
    // These represent metrics that are common in dashboards but require data not currently in the model/form.

    /**
     * Placeholder for Estimated Annual Gross Income.
     * Cannot be calculated accurately without rent data per unit or property.
     * Returns 0 or null to indicate missing data.
     */
    public function getEstimatedAnnualGrossIncomeAttribute()
    {
        // Cannot calculate without rent data.
        // Placeholder or return null/0.
        // Consider adding 'estimated_monthly_rent_per_unit' or linking to leases/units with rent info.
        return null; // Or 0
    }

    /**
     * Placeholder for Estimated Annual Expenses.
     * Cannot be calculated accurately without expense tracking.
     * Returns 0 or null to indicate missing data.
     */
    public function getEstimatedAnnualExpensesAttribute()
    {
        // Cannot calculate without expense data.
        // Placeholder or return null/0.
        // Consider adding 'annual_expense_estimate' or linking to an expenses table.
        return null; // Or 0
    }

    /**
     * Placeholder for Net Operating Income (NOI).
     * Depends on income and expenses.
     * Returns 0 or null to indicate missing data.
     */
    public function getEstimatedNoiAttribute()
    {
        // Depends on income and expenses.
        $income = $this->estimated_annual_gross_income ?? 0;
        $expenses = $this->estimated_annual_expenses ?? 0;
        // If either is null, the result is likely not meaningful.
        return $income - $expenses; // Could be 0 - 0 = 0
    }

    /**
     * Placeholder for Cap Rate.
     * (NOI / Purchase Price) * 100. If NOI is 0, Cap Rate is 0.
     * Returns 0 to indicate missing data or calculation based on placeholders.
     */
    public function getEstimatedCapRateAttribute()
    {
        $noi = $this->estimated_noi ?? 0;
        if ($this->purchase_price && $this->purchase_price > 0) {
            return ($noi / $this->purchase_price) * 100;
        }
        return 0; // Avoid division by zero, indicate data missing
    }


    /**
     * Automatically generates a slug when creating/updating a property.
     */
    protected static function booted()
    {
        static::creating(function ($property) {
            if (empty($property->slug) && !empty($property->name)) {
                $property->slug = Str::slug($property->name);
            }
        });

        static::updating(function ($property) {
            // Optional: Update slug if name changes
            // if ($property->isDirty('name') && !empty($property->name)) {
            //     $property->slug = Str::slug($property->name);
            // }
        });
    }
}