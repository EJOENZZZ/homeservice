<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('professional')
            ->latest()
            ->get();
        return view('pages.my-bookings', compact('bookings'));
    }

    public function create(Request $request)
    {
        $pro = Professional::findOrFail($request->query('professional_id'));
        return view('pages.book', compact('pro'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'service_date'    => 'required|date|after:today',
            'service_time'    => 'required',
            'address'         => 'required|string|max:500',
            'notes'           => 'nullable|string|max:1000',
        ]);

        Booking::create([
            'user_id'         => Auth::id(),
            'professional_id' => $data['professional_id'],
            'service_date'    => $data['service_date'],
            'service_time'    => $data['service_time'],
            'address'         => $data['address'],
            'notes'           => $data['notes'] ?? null,
            'status'          => 'pending',
        ]);

        return redirect('/my-bookings')->with('success', 'Booking confirmed! The professional will contact you shortly.');
    }
}