<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'specialty',
        'badge', 'rating', 'jobs_count', 'bio',
        'is_active', 'hourly_rate', 'location', 'avatar',
    ];

    protected $casts = [
        'rating'    => 'float',
        'is_active' => 'boolean',
        'jobs_count'=> 'integer',
    ];

    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->first_name,0,1).substr($this->last_name,0,1));
    }

    public function scopeTopRated($query, int $limit = 4)
    {
        return $query->where('is_active', true)->orderByDesc('rating')->limit($limit);
    }
}