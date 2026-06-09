<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'professional_id',
        'service_date',
        'service_time',
        'address',
        'notes',
        'status',
        'estimated_hours',
        'payment_method',
        'user_rating',
        'user_review',
        'rated_at',
    ];

    protected $casts = [
        'service_date'    => 'date',
        'estimated_hours' => 'integer',
        'user_rating'     => 'integer',
        'rated_at'        => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    /**
     * Estimated total based on hourly rate × estimated hours.
     */
    public function getEstimatedTotalAttribute(): float
    {
        $rate  = $this->professional?->hourly_rate ?? 0;
        $hours = $this->estimated_hours ?? 1;
        return $rate * $hours;
    }

    /**
     * Human-readable payment method label.
     */
    public function getPaymentLabelAttribute(): string
    {
        return match($this->payment_method) {
            'gcash'         => 'GCash',
            'after_service' => 'Cash After Service',
            default         => ucfirst($this->payment_method ?? '—'),
        };
    }
}