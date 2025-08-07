<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lease extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'tenant_ids',
        'start_date',
        'end_date',
        'rent_amount',
        'deposit_amount',
        'status',
        'payment_frequency',
        'late_fee_policy',
        'documents',
        'last_payment_date',
        'next_payment_due_date'
    ];

    protected $casts = [
        'tenant_ids' => 'array',
        'documents' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'last_payment_date' => 'date',
        'next_payment_due_date' => 'date',
        'rent_amount' => 'decimal:2',
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

    // Relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function tenants()
    {
        return $this->belongsToMany(Tenant::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'Expired');
    }
}