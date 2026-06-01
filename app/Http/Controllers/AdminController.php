<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Professional;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private string $adminEmail    = 'admin@homefix.app';
    private string $adminPassword = 'Admin@12345';
    private string $adminToken    = 'hf-admin-token-2026-secret';

    private function isLoggedIn(): bool
    {
        return request()->query('t') === $this->adminToken
            || request()->cookie('hf_admin') === $this->adminToken;
    }

    private function guard()
    {
        if (!$this->isLoggedIn()) {
            return redirect('/admin/login');
        }
        return null;
    }

    private function withToken($redirect)
    {
        return $redirect->withCookie(
            cookie('hf_admin', $this->adminToken, 60 * 24 * 30, '/', null, false, false)
        );
    }

    public function showLogin()
    {
        if ($this->isLoggedIn()) return redirect('/admin/dashboard');
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (
            trim($request->email)    === $this->adminEmail &&
            trim($request->password) === $this->adminPassword
        ) {
            return $this->withToken(redirect('/admin/dashboard?t=' . $this->adminToken));
        }

        return back()->withErrors([
            'email' => 'Invalid. Email: ' . trim($request->email) . ' | Pass: ' . trim($request->password)
        ]);
    }

    public function logout()
    {
        return redirect('/admin/login')
            ->withCookie(cookie('hf_admin', '', -1));
    }

    public function dashboard()
    {
        if ($r = $this->guard()) return $r;

        try {
            $stats = [
                'users'         => User::where('is_verified', true)->count(),
                'professionals' => Professional::count(),
                'bookings'      => Booking::count(),
                'pending'       => Booking::where('status', 'pending')->count(),
                'confirmed'     => Booking::where('status', 'confirmed')->count(),
                'completed'     => Booking::where('status', 'completed')->count(),
            ];
            $recentBookings = Booking::with(['user', 'professional'])->latest()->limit(8)->get();
            $recentUsers    = User::where('is_verified', true)->latest()->limit(5)->get();
        } catch (\Exception $e) {
            $stats          = ['users'=>0,'professionals'=>0,'bookings'=>0,'pending'=>0,'confirmed'=>0,'completed'=>0];
            $recentBookings = collect();
            $recentUsers    = collect();
        }

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentUsers'));
    }

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