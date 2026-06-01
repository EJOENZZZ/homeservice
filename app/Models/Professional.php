<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Professional extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'specialty',
        'badge', 'rating', 'jobs_count', 'bio', 'is_active',
        'hourly_rate', 'location', 'avatar', 'avatar_url',
        'email', 'password', 'is_verified',
        'verification_code', 'verification_expires_at', 'last_seen_at',
    ];

    protected $hidden = ['password', 'verification_code'];

    protected $casts = [
        'rating'                  => 'float',
        'is_active'               => 'boolean',
        'is_verified'             => 'boolean',
        'jobs_count'              => 'integer',
        'verification_expires_at' => 'datetime',
        'last_seen_at'            => 'datetime',
        'password'                => 'hashed',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1));
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}