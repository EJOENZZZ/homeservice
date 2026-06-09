<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BookingController extends Controller
{
    private function staticPros(): array
    {
        return [
            ['id'=>1,'first_name'=>'Grace', 'last_name'=>'Dela Cruz','specialty'=>'Plumber',     'badge'=>'ELITE',   'rating'=>5.00,'jobs_count'=>451,'hourly_rate'=>350,'location'=>'Cebu City','avatar_url'=>null,'phone'=>'09171234567'],
            ['id'=>2,'first_name'=>'Marco', 'last_name'=>'Reyes',    'specialty'=>'Electrician', 'badge'=>'TOP PRO', 'rating'=>4.98,'jobs_count'=>312,'hourly_rate'=>400,'location'=>'Mandaue City','avatar_url'=>null,'phone'=>'09281234567'],
            ['id'=>3,'first_name'=>'Ana',   'last_name'=>'Santos',   'specialty'=>'Carpenter',   'badge'=>'VERIFIED','rating'=>4.97,'jobs_count'=>284,'hourly_rate'=>300,'location'=>'Lapu-Lapu City','avatar_url'=>null,'phone'=>'09391234567'],
            ['id'=>4,'first_name'=>'Luis',  'last_name'=>'Bautista', 'specialty'=>'Cleaner',     'badge'=>'TOP PRO', 'rating'=>4.95,'jobs_count'=>198,'hourly_rate'=>250,'location'=>'Talisay City','avatar_url'=>null,'phone'=>'09401234567'],
        ];
    }

    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with(['professional' => function ($query) {
                $query->select('id', 'first_name', 'last_name', 'specialty');
            }])
            ->latest()
            ->get();

        return view('pages.my-bookings', compact('bookings'));
    }

    public function rate(Request $request, Booking $booking)
    {
        abort_unless($booking->user_id === Auth::id(), 403);
        abort_unless($booking->status === 'completed', 422, 'You can only rate a completed service.');

        $data = $request->validate([
            'user_rating' => 'required|integer|min:1|max:5',
            'user_review'  => 'nullable|string|max:1000',
        ]);

        $booking->update([
            'user_rating' => $data['user_rating'],
            'user_review'  => $data['user_review'] ?? null,
            'rated_at'     => now(),
        ]);

        return back()->with('success', 'Thanks for your rating.');
    }

    public function create(Request $request)
    {
        try {
            $pro = Professional::findOrFail($request->query('professional_id'));
        } catch (\Exception $e) {
            $data = collect($this->staticPros())->firstWhere('id', (int)$request->query('professional_id'));
            abort_if(!$data, 404);
            $pro = (object) $data;
        }
        return view('pages.book', compact('pro'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'professional_id' => 'required|integer',
            'service_date'    => 'required|date|after_or_equal:today',
            'service_time'    => 'required',
            'address'         => 'required|string|max:500',
            'notes'           => 'nullable|string|max:1000',
            'estimated_hours' => 'required|integer|min:1|max:8',
            'payment_method'  => 'required|in:gcash,after_service',
        ]);

        $bookingData = [
            'user_id'         => Auth::id(),
            'professional_id' => $data['professional_id'],
            'service_date'    => $data['service_date'],
            'service_time'    => $data['service_time'],
            'address'         => $data['address'],
            'notes'           => $data['notes'] ?? null,
            'status'          => 'pending',
        ];

        if (Schema::hasColumn('bookings', 'estimated_hours')) {
            $bookingData['estimated_hours'] = $data['estimated_hours'];
        }

        if (Schema::hasColumn('bookings', 'payment_method')) {
            $bookingData['payment_method'] = $data['payment_method'];
        }

        try {
            Booking::create($bookingData);
        } catch (\Throwable $e) {
            DB::table('bookings')->insert(array_merge($bookingData, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }

        $msg = $data['payment_method'] === 'gcash'
            ? 'Booking confirmed! Please complete your GCash payment to the professional.'
            : 'Booking confirmed! The professional will contact you shortly.';

        return redirect()->route('booking.index')->with('success', $msg);
    }
}