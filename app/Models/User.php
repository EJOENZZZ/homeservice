<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'is_verified', 'verification_code', 'verification_expires_at',
        'email_verified_at', 'remember_token',
        'phone', 'address', 'avatar_url',
    ];

    protected $hidden = [
        'password', 'remember_token', 'verification_code',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'       => 'datetime',
            'verification_expires_at' => 'datetime',
            'is_verified'             => 'boolean',
            'password'                => 'hashed',
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', $this->name);
        return strtoupper(substr($parts[0], 0, 1) . substr(end($parts), 0, 1));
    }
}