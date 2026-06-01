<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\Booking;
use App\Models\Conversation;
use App\Models\Notification;
use Illuminate\Http\Request;

class ProDashboardController extends Controller
{
    private function getPro()
    {
        $id = session('pro_id');
        if (!$id) return null;
        return Professional::find($id);
    }

    private function guard()
    {
        if (!session('pro_id')) return redirect('/pro/login');
        return null;
    }

    public function dashboard()
    {
        if ($r = $this->guard()) return $r;
        $pro = $this->getPro();

        $stats = [
            'bookings'  => Booking::where('professional_id', $pro->id)->count(),
            'pending'   => Booking::where('professional_id', $pro->id)->where('status', 'pending')->count(),
            'confirmed' => Booking::where('professional_id', $pro->id)->where('status', 'confirmed')->count(),
            'completed' => Booking::where('professional_id', $pro->id)->where('status', 'completed')->count(),
        ];

        $recentBookings = Booking::where('professional_id', $pro->id)
            ->with('user')->latest()->limit(5)->get();

        $unreadMessages = Conversation::where('professional_id', $pro->id)
            ->with('latestMessage')
            ->get()
            ->sum(fn($c) => $c->unreadCount('professional', $pro->id));

        $notifications = Notification::where('recipient_type', 'professional')
            ->where('recipient_id', $pro->id)
            ->where('is_read', false)
            ->latest()->limit(5)->get();

        $pro->update(['last_seen_at' => now()]);

        return view('pro.dashboard', compact('pro', 'stats', 'recentBookings', 'unreadMessages', 'notifications'));
    }

    public function bookings()
    {
        if ($r = $this->guard()) return $r;
        $pro = $this->getPro();
        $bookings = Booking::where('professional_id', $pro->id)
            ->with('user')->latest()->paginate(15);
        return view('pro.bookings', compact('pro', 'bookings'));
    }

    public function updateBooking(Request $request, $id)
    {
        if ($r = $this->guard()) return $r;
        $pro     = $this->getPro();
        $booking = Booking::where('id', $id)->where('professional_id', $pro->id)->firstOrFail();
        $booking->update(['status' => $request->status]);

        // Notify user
        Notification::send('user', $booking->user_id, 'booking_' . $request->status,
            'Booking ' . ucfirst($request->status),
            'Your booking with ' . $pro->full_name . ' has been ' . $request->status . '.',
            '/my-bookings'
        );

        return back()->with('success', 'Booking updated.');
    }

    public function profile()
    {
        if ($r = $this->guard()) return $r;
        $pro = $this->getPro();
        return view('pro.profile', compact('pro'));
    }

    public function updateProfile(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $pro  = $this->getPro();
        $data = $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'bio'         => 'nullable|string',
            'hourly_rate' => 'nullable|numeric',
            'location'    => 'nullable|string',
        ]);
        $pro->update($data);
        session(['pro_name' => $pro->fresh()->full_name]);
        return back()->with('success', 'Profile updated.');
    }
}