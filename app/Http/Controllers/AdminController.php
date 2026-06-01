<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Professional;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private function guard()
    {
        $token = request()->cookie('admin_token');
        $valid = hash('sha256', env('ADMIN_PASSWORD', 'Admin@12345') . env('APP_KEY'));
        if ($token !== $valid) {
            return redirect('/admin/login');
        }
        return null;
    }

    public function showLogin()
    {
        $token = request()->cookie('admin_token');
        $valid = hash('sha256', env('ADMIN_PASSWORD', 'Admin@12345') . env('APP_KEY'));
        if ($token === $valid) return redirect('/admin/dashboard');
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $adminEmail    = env('ADMIN_EMAIL', 'admin@homefix.app');
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@12345');

        if ($request->email === $adminEmail && $request->password === $adminPassword) {
            $token = hash('sha256', $adminPassword . env('APP_KEY'));
            return redirect('/admin/dashboard')
                ->withCookie(cookie()->forever('admin_token', $token));
        }

        return back()->withErrors(['email' => 'Invalid admin credentials.']);
    }

    public function logout()
    {
        return redirect('/admin/login')
            ->withCookie(\Cookie::forget('admin_token'));
    }

    // DASHBOARD
    public function dashboard()
    {
        if ($r = $this->guard()) return $r;

        $stats = [
            'users'         => User::where('is_verified', true)->count(),
            'professionals' => Professional::count(),
            'bookings'      => Booking::count(),
            'pending'       => Booking::where('status', 'pending')->count(),
            'confirmed'     => Booking::where('status', 'confirmed')->count(),
            'completed'     => Booking::where('status', 'completed')->count(),
        ];

        $recentBookings = Booking::with(['user', 'professional'])
            ->latest()->limit(8)->get();

        $recentUsers = User::where('is_verified', true)
            ->latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentUsers'));
    }

    // BOOKINGS
    public function bookings(Request $request)
    {
        if ($r = $this->guard()) return $r;

        $query = Booking::with(['user', 'professional'])->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $bookings = $query->paginate(15);
        return view('admin.bookings', compact('bookings'));
    }

    public function updateBooking(Request $request, $id)
    {
        if ($r = $this->guard()) return $r;
        Booking::findOrFail($id)->update(['status' => $request->status]);
        return back()->with('success', 'Booking status updated.');
    }

    // USERS
    public function users(Request $request)
    {
        if ($r = $this->guard()) return $r;

        $query = User::latest();
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        $users = $query->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function deleteUser($id)
    {
        if ($r = $this->guard()) return $r;
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted.');
    }

    // PROFESSIONALS
    public function professionals()
    {
        if ($r = $this->guard()) return $r;
        $professionals = Professional::latest()->paginate(15);
        return view('admin.professionals', compact('professionals'));
    }

    public function storeProfessional(Request $request)
    {
        if ($r = $this->guard()) return $r;

        $data = $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'specialty'   => 'required|string|max:255',
            'badge'       => 'required|in:ELITE,TOP PRO,VERIFIED',
            'rating'      => 'required|numeric|min:0|max:5',
            'jobs_count'  => 'required|integer|min:0',
            'hourly_rate' => 'nullable|numeric',
            'location'    => 'nullable|string',
            'bio'         => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['avatar_url'] = $this->uploadPhoto($request->file('photo'));
        }

        $data['is_active'] = true;
        unset($data['photo']);
        Professional::create($data);
        return back()->with('success', 'Professional added successfully.');
    }

    public function updateProfessional(Request $request, $id)
    {
        if ($r = $this->guard()) return $r;

        $pro  = Professional::findOrFail($id);
        $data = $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'specialty'   => 'required|string|max:255',
            'badge'       => 'required|in:ELITE,TOP PRO,VERIFIED',
            'rating'      => 'required|numeric|min:0|max:5',
            'jobs_count'  => 'required|integer|min:0',
            'hourly_rate' => 'nullable|numeric',
            'location'    => 'nullable|string',
            'bio'         => 'nullable|string',
            'is_active'   => 'nullable',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['avatar_url'] = $this->uploadPhoto($request->file('photo'));
        }

        $data['is_active'] = $request->has('is_active') ? (bool)$request->is_active : $pro->is_active;
        unset($data['photo']);
        $pro->update($data);
        return back()->with('success', 'Professional updated successfully.');
    }

    public function deleteProfessional($id)
    {
        if ($r = $this->guard()) return $r;
        Professional::findOrFail($id)->delete();
        return back()->with('success', 'Professional deleted.');
    }

    // TESTIMONIALS
    public function testimonials()
    {
        if ($r = $this->guard()) return $r;
        $testimonials = Testimonial::latest()->paginate(15);
        return view('admin.testimonials', compact('testimonials'));
    }

    public function approveTestimonial($id)
    {
        if ($r = $this->guard()) return $r;
        Testimonial::findOrFail($id)->update(['is_approved' => true]);
        return back()->with('success', 'Testimonial approved.');
    }

    public function deleteTestimonial($id)
    {
        if ($r = $this->guard()) return $r;
        Testimonial::findOrFail($id)->delete();
        return back()->with('success', 'Testimonial deleted.');
    }

    private function uploadPhoto($file): string
    {
        $mime      = $file->getMimeType();
        $imageData = file_get_contents($file->getRealPath());

        if (extension_loaded('gd')) {
            $src = imagecreatefromstring($imageData);
            if ($src) {
                $origW   = imagesx($src);
                $origH   = imagesy($src);
                $maxSize = 300;

                if ($origW > $maxSize || $origH > $maxSize) {
                    $ratio = min($maxSize / $origW, $maxSize / $origH);
                    $newW  = (int)($origW * $ratio);
                    $newH  = (int)($origH * $ratio);
                    $dst   = imagecreatetruecolor($newW, $newH);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

                    ob_start();
                    imagejpeg($dst, null, 75);
                    $imageData = ob_get_clean();
                    $mime      = 'image/jpeg';

                    imagedestroy($src);
                    imagedestroy($dst);
                }
            }
        }

        return 'data:' . $mime . ';base64,' . base64_encode($imageData);
    }
}