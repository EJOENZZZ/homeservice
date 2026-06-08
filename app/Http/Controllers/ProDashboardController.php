<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\Booking;
use App\Models\Conversation;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProDashboardController extends Controller
{
    private function getPro(): ?Professional
    {
        $id = session('pro_id');
        if (!$id) return null;
        return Professional::find($id);
    }

    private function guard()
    {
        $pro = $this->getPro();
        if (!$pro) return redirect('/pro/login');
        if ($pro->must_change_password) return redirect('/pro/change-password');
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
            ->with('messages')
            ->get()
            ->sum(fn($c) => $c->messages->where('is_read', false)->where('sender_type', '!=', 'professional')->count());

        $notifications = Notification::where('recipient_type', 'professional')
            ->where('recipient_id', $pro->id)
            ->latest()->limit(5)->get();

        $pro->update(['last_seen_at' => now()]);

        return view('pro.dashboard', compact('pro', 'stats', 'recentBookings', 'unreadMessages', 'notifications'));
    }

    public function bookings()
    {
        if ($r = $this->guard()) return $r;
        $pro      = $this->getPro();
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
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'phone'            => 'nullable|string|max:20',
            'bio'              => 'nullable|string|max:1000',
            'hourly_rate'      => 'nullable|numeric',
            'location'         => 'nullable|string',
            'years_experience' => 'nullable|integer|min:0',
            'facebook'         => 'nullable|url',
            'instagram'        => 'nullable|url',
            'photo'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $file      = $request->file('photo');
            $mime      = $file->getMimeType();
            $imageData = file_get_contents($file->getRealPath());
            if (extension_loaded('gd')) {
                $src = imagecreatefromstring($imageData);
                if ($src) {
                    $origW = imagesx($src); $origH = imagesy($src); $max = 300;
                    if ($origW > $max || $origH > $max) {
                        $ratio = min($max/$origW, $max/$origH);
                        $dst   = imagecreatetruecolor((int)($origW*$ratio), (int)($origH*$ratio));
                        imagecopyresampled($dst, $src, 0, 0, 0, 0, (int)($origW*$ratio), (int)($origH*$ratio), $origW, $origH);
                        ob_start(); imagejpeg($dst, null, 80); $imageData = ob_get_clean();
                        $mime = 'image/jpeg';
                        imagedestroy($src); imagedestroy($dst);
                    }
                }
            }
            $data['avatar_url'] = 'data:' . $mime . ';base64,' . base64_encode($imageData);
        }

        unset($data['photo']);
        $pro->update($data);
        session(['pro_name' => $pro->fresh()->full_name]);
        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $pro = $this->getPro();
        if (!Hash::check($request->current_password, $pro->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $pro->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password changed successfully.');
    }
}