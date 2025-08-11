<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'tenant_id',
        'unit_id',
        'start_date',
        'end_date',
        'monthly_rent',
        'deposit_amount',
        'status',
        'payment_frequency',
        'late_fee_policy',
        'documents',
        'last_payment_date',
        'next_payment_due_date'
    ];

    protected $casts = [
        'documents' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'last_payment_date' => 'date',
        'next_payment_due_date' => 'date',
        'monthly_rent' => 'decimal:2',
        'deposit_amount' => 'decimal:2'
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'last_payment_date',
        'next_payment_due_date',
        'created_at',
        'updated_at'
    ];

    // Default values
    protected $attributes = [
        'status' => 'active',
        'payment_frequency' => 'monthly'
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function rentPayments()
    {
        return $this->hasMany(RentPayment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeByTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }

    public function scopeByProperty($query, $propertyId)
    {
        return $query->where('property_id', $propertyId);
    }

    // Accessors
    public function getDurationInDaysAttribute()
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->diffInDays($this->end_date);
        }
        return null;
    }

    public function getRemainingDaysAttribute()
    {
        if ($this->end_date) {
            $now = now();
            if ($now->lessThan($this->end_date)) {
                return $now->diffInDays($this->end_date);
            }
        }
        return 0;
    }

    public function getIsExpiredAttribute()
    {
        return $this->end_date && now()->greaterThan($this->end_date);
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active' && !$this->is_expired;
    }

    public function isMonthToMonth()
    {
        // If there's no end date or end date is far in the future, it's month-to-month
        return !$this->end_date || $this->end_date->diffInYears(now())->y > 10;
    }

    public function getTotalPaymentsReceived()
    {
        return $this->rentPayments()
            ->where('status', 'paid')
            ->sum('amount');
    }

    public function getOutstandingBalance()
    {
        $totalExpected = $this->monthly_rent * $this->getMonthsSinceStart();
        return max(0, $totalExpected - $this->getTotalPaymentsReceived());
    }

    // Private helper
    private function getMonthsSinceStart()
    {
        if (!$this->start_date) return 0;
        
        $endDate = $this->end_date ?? now();
        return $this->start_date->diffInMonths($endDate);
    }
}