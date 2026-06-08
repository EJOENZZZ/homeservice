<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'rating'  => 'required|integer|min:1|max:5',
        ]);

        Testimonial::create([
            'author_name' => auth()->user()->name,
            'content'     => $request->content,
            'rating'      => $request->rating,
            'is_approved' => false,
        ]);

        return back()->with('review_success', 'Thank you! Your review has been submitted and is pending approval.');
    }
}
