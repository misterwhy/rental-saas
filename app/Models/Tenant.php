<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'date_of_birth',
        'emergency_contact',
        'background_check_status',
        'credit_score',
        'notes'
    ];

    protected $casts = [
        'emergency_contact' => 'array',
        'date_of_birth' => 'date',
        'credit_score' => 'integer'
    ];

    protected $dates = [
        'date_of_birth',
        'created_at',
        'updated_at'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function leases()
    {
        return $this->belongsToMany(Lease::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function maintenanceRequests()
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

    // Accessors
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}