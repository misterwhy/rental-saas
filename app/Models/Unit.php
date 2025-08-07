<?php // Line 1 starts here with '<'

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'unit_number',
        'bedrooms',
        'bathrooms',
        'square_footage',
        'rent_amount',
        'status',
        'deposit_amount',
        'available_date',
        'images'
    ];

    protected $casts = [
        'images' => 'array',
        'rent_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'available_date' => 'date'
    ];

    protected $dates = [
        'available_date',
        'created_at',
        'updated_at'
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }

    public function currentLease()
    {
        return $this->hasOne(Lease::class)->where('status', 'Active');
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }
}