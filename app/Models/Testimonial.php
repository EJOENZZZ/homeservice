<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = ['author_name', 'content', 'rating', 'is_approved'];

    protected $casts = [
        'is_approved' => 'boolean',
        'rating'      => 'integer',
    ];
}