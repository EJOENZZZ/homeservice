<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $professionals = Professional::where('is_active', true)
            ->orderByDesc('rating')
            ->limit(4)
            ->get();

        $testimonials = Testimonial::where('is_approved', true)
            ->latest()
            ->limit(6)
            ->get();

        return view('pages.home', compact('professionals', 'testimonials'));
    }
}