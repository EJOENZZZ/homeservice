<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Professional;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function guard()
    {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }
        return null;
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

    // LOGIN
    public function showLogin()
    {
        if (session('admin_logged_in')) return redirect('/admin/dashboard');
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $adminEmail    = config('app.admin_email', env('ADMIN_EMAIL', 'admin@homefix.app'));
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@12345');

        if ($request->email === $adminEmail && $request->password === $adminPassword) {
            session(['admin_logged_in' => true, 'admin_email' => $request->email]);
            return redirect('/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid admin credentials.']);
    }

    public function logout()
    {
        session()->forget(['admin_logged_in', 'admin_email']);
        return redirect('/admin/login');
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

        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);
        return back()->with('success', 'Booking status updated.');
    }

    // USERS
    public function users(Request $request)
    {
        if ($r = $this->guard()) return $r;

        $query = User::latest();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
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
        ]);

        $data['is_active'] = true;
        Professional::create($data);
        return back()->with('success', 'Professional added.');
    }

    public function updateProfessional(Request $request, $id)
    {
        if ($r = $this->guard()) return $r;

        $pro = Professional::findOrFail($id);
        $pro->update($request->only([
            'first_name','last_name','specialty','badge',
            'rating','jobs_count','hourly_rate','location','bio','is_active'
        ]));
        return back()->with('success', 'Professional updated.');
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
}