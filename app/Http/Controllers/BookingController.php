<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    private function staticPros(): array
    {
        return [
            [
                'id' => 1,
                'first_name' => 'Grace',
                'last_name' => 'Dela Cruz',
                'specialty' => 'Plumber',
                'badge' => 'ELITE',
                'rating' => 5.00,
                'jobs_count' => 451,
                'hourly_rate' => 350,
                'location' => 'Cebu City',
                'avatar_url' => null,
                'phone' => '09171234567'
            ],
            [
                'id' => 2,
                'first_name' => 'Marco',
                'last_name' => 'Reyes',
                'specialty' => 'Electrician',
                'badge' => 'TOP PRO',
                'rating' => 4.98,
                'jobs_count' => 312,
                'hourly_rate' => 400,
                'location' => 'Mandaue City',
                'avatar_url' => null,
                'phone' => '09281234567'
            ],
            [
                'id' => 3,
                'first_name' => 'Ana',
                'last_name' => 'Santos',
                'specialty' => 'Carpenter',
                'badge' => 'VERIFIED',
                'rating' => 4.97,
                'jobs_count' => 284,
                'hourly_rate' => 300,
                'location' => 'Lapu-Lapu City',
                'avatar_url' => null,
                'phone' => '09391234567'
            ],
            [
                'id' => 4,
                'first_name' => 'Luis',
                'last_name' => 'Bautista',
                'specialty' => 'Cleaner',
                'badge' => 'TOP PRO',
                'rating' => 4.95,
                'jobs_count' => 198,
                'hourly_rate' => 250,
                'location' => 'Talisay City',
                'avatar_url' => null,
                'phone' => '09401234567'
            ],
        ];
    }

    /**
     * Show My Bookings
     */
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.my-bookings', compact('bookings'));
    }

    /**
     * Show booking form
     */
    public function create(Request $request)
    {
        $professionalId = (int) $request->query('professional_id');

        try {
            $pro = Professional::findOrFail($professionalId);
        } catch (\Exception $e) {
            $data = collect($this->staticPros())
                ->firstWhere('id', $professionalId);

            abort_if(!$data, 404);

            $pro = (object) $data;
        }

        return view('pages.book', compact('pro'));
    }

    /**
     * Save booking
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'professional_id' => 'required',
            'service_date' => 'required|date',
            'service_time' => 'required',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
            'estimated_hours' => 'required|integer|min:1|max:8',
            'payment_method' => 'required|in:gcash,after_service',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'professional_id' => $validated['professional_id'],
            'service_date' => $validated['service_date'],
            'service_time' => $validated['service_time'],
            'address' => $validated['address'],
            'notes' => $validated['notes'] ?? null,
            'estimated_hours' => $validated['estimated_hours'],
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        $message = $validated['payment_method'] === 'gcash'
            ? 'Booking confirmed! Please complete your GCash payment.'
            : 'Booking confirmed! The professional will contact you shortly.';

        return redirect()
            ->route('booking.index')
            ->with('success', $message);
    }
}