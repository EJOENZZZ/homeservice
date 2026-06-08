<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Professional;
use App\Models\Testimonial;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private string $adminEmail    = 'admin@homefix.app';
    private string $adminPassword = 'Admin@12345';
    private string $secretKey     = 'homefix-admin-2026';

    private function validToken(): string
    {
        return hash('sha256', $this->adminPassword . $this->secretKey);
    }

    private function guard()
    {
        if (request()->cookie('hf_admin') !== $this->validToken()) {
            return redirect('/admin/login');
        }
        return null;
    }

    public function showLogin()
    {
        if (request()->cookie('hf_admin') === $this->validToken()) {
            return redirect('/admin/dashboard');
        }
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
            return redirect('/admin/dashboard')
                ->withCookie(cookie('hf_admin', $this->validToken(), 60 * 24 * 30, '/', null, false, false));
        }

        return back()->withErrors(['email' => 'Invalid admin credentials.']);
    }

    public function logout()
    {
        return redirect('/admin/login')
            ->withCookie(cookie('hf_admin', '', -1));
    }

    // DASHBOARD
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
            $pendingPros    = Professional::where('is_active', false)->where('is_verified', true)->latest()->limit(5)->get();
        } catch (\Exception $e) {
            $stats          = ['users'=>0,'professionals'=>0,'bookings'=>0,'pending'=>0,'confirmed'=>0,'completed'=>0];
            $recentBookings = collect();
            $recentUsers    = collect();
            $pendingPros    = collect();
        }

        return view('admin.dashboard', compact('stats', 'recentBookings', 'recentUsers', 'pendingPros'));
    }

    // BOOKINGS
    public function bookings(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $query = Booking::with(['user', 'professional'])->latest();
        if ($request->filled('status')) $query->where('status', $request->status);
        $bookings = $query->paginate(15);
        return view('admin.bookings', compact('bookings'));
    }

    public function updateBooking(Request $request, $id)
    {
        if ($r = $this->guard()) return $r;
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);

        // Notify user
        Notification::send('user', $booking->user_id, 'booking_' . $request->status,
            'Booking ' . ucfirst($request->status),
            'Your booking has been ' . $request->status . '.',
            '/my-bookings'
        );

        return back()->with('success', 'Booking updated.');
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

    // PROFESSIONALS — Admin creates account
    public function professionals(Request $request)
    {
        if ($r = $this->guard()) return $r;
        $query = Professional::latest();
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->search.'%')
                  ->orWhere('last_name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
            });
        }
        $professionals = $query->paginate(15);
        return view('admin.professionals', compact('professionals'));
    }

    public function storeProfessional(Request $request)
    {
        if ($r = $this->guard()) return $r;

        $data = $request->validate([
            'first_name'  => 'required|string|max:255',
            'last_name'   => 'required|string|max:255',
            'email'       => 'required|email|unique:professionals,email',
            'specialty'   => 'required|string|max:255',
            'badge'       => 'required|in:ELITE,TOP PRO,VERIFIED',
            'rating'      => 'required|numeric|min:0|max:5',
            'jobs_count'  => 'required|integer|min:0',
            'hourly_rate' => 'nullable|numeric',
            'location'    => 'nullable|string',
            'bio'         => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Generate temp password
        $tempPassword = 'Pro@' . Str::random(8);

        if ($request->hasFile('photo')) {
            $data['avatar'] = $this->uploadPhoto($request->file('photo'));
        }

        $data['password']             = Hash::make($tempPassword);
        $data['is_active']            = true;
        $data['is_verified']          = true;
        $data['must_change_password'] = true;
        unset($data['photo']);

        $pro = Professional::create($data);

        // Send credentials via email
        $this->sendCredentials($pro->email, $pro->first_name, $tempPassword);

        return back()->with('success', "Account created for {$pro->full_name}. Credentials sent to {$pro->email}.");
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
            $data['avatar'] = $this->uploadPhoto($request->file('photo'));
        }

        $data['is_active'] = $request->has('is_active') ? (bool)$request->is_active : $pro->is_active;
        unset($data['photo']);
        $pro->update($data);
        return back()->with('success', 'Professional updated.');
    }

    public function resetProPassword($id)
    {
        if ($r = $this->guard()) return $r;

        $pro          = Professional::findOrFail($id);
        $tempPassword = 'Pro@' . Str::random(8);

        $pro->update([
            'password'             => Hash::make($tempPassword),
            'must_change_password' => true,
        ]);

        $this->sendCredentials($pro->email, $pro->first_name, $tempPassword);

        return back()->with('success', "Password reset. New credentials sent to {$pro->email}.");
    }

    public function toggleProActive($id)
    {
        if ($r = $this->guard()) return $r;
        $pro = Professional::findOrFail($id);
        $pro->update(['is_active' => !$pro->is_active]);
        return back()->with('success', 'Professional status updated.');
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

    // MESSAGES
    public function messages()
    {
        if ($r = $this->guard()) return $r;
        $conversations = Conversation::with(['user', 'professional', 'latestMessage'])
            ->latest('last_message_at')->paginate(20);
        return view('admin.messages', compact('conversations'));
    }

    private function sendCredentials(string $email, string $name, string $password): void
    {
        Mail::html("
            <div style='font-family:sans-serif;max-width:520px;margin:0 auto;padding:32px;'>
                <div style='text-align:center;margin-bottom:28px'>
                    <div style='width:48px;height:48px;background:#2563EB;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;font-weight:800;font-size:1.3rem;color:#fff'>H</div>
                    <div style='font-weight:700;font-size:1.1rem;margin-top:8px'>HomeFix</div>
                </div>
                <h2 style='font-size:1.4rem;margin-bottom:8px'>Welcome to HomeFix, {$name}! 👋</h2>
                <p style='color:#6B7280;margin-bottom:24px'>Your professional account has been created. Here are your login credentials:</p>
                <div style='background:#F8FAFC;border:1px solid #E5E7EB;border-radius:12px;padding:20px;margin-bottom:24px'>
                    <div style='margin-bottom:12px'>
                        <div style='font-size:.78rem;font-weight:600;color:#9CA3AF;margin-bottom:4px'>LOGIN URL</div>
                        <div><a href='https://homeservice-liart.vercel.app/pro/login' style='color:#2563EB'>homeservice-liart.vercel.app/pro/login</a></div>
                    </div>
                    <div style='margin-bottom:12px'>
                        <div style='font-size:.78rem;font-weight:600;color:#9CA3AF;margin-bottom:4px'>EMAIL</div>
                        <div style='font-weight:600'>{$email}</div>
                    </div>
                    <div>
                        <div style='font-size:.78rem;font-weight:600;color:#9CA3AF;margin-bottom:4px'>TEMPORARY PASSWORD</div>
                        <div style='font-size:1.2rem;font-weight:800;letter-spacing:2px;color:#2563EB;background:#EFF6FF;padding:8px 14px;border-radius:8px;display:inline-block'>{$password}</div>
                    </div>
                </div>
                <div style='background:#FEF3C7;border:1px solid #FDE68A;border-radius:8px;padding:12px 16px;font-size:.85rem;color:#92400E;margin-bottom:24px'>
                    ⚠️ You will be asked to change your password on first login.
                </div>
                <p style='color:#6B7280;font-size:.85rem'>If you have any questions, contact us at admin@homefix.app</p>
            </div>
        ", fn($m) => $m->to($email)->subject('Your HomeFix Professional Account Credentials'));
    }

    private function uploadPhoto($file): string
    {
        $mime      = $file->getMimeType();
        $imageData = file_get_contents($file->getRealPath());

        if (extension_loaded('gd')) {
            $src = imagecreatefromstring($imageData);
            if ($src) {
                $origW = imagesx($src); $origH = imagesy($src);
                $max   = 300;
                if ($origW > $max || $origH > $max) {
                    $ratio = min($max/$origW, $max/$origH);
                    $newW  = (int)($origW * $ratio);
                    $newH  = (int)($origH * $ratio);
                    $dst   = imagecreatetruecolor($newW, $newH);
                    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $origW, $origH);
                    ob_start(); imagejpeg($dst, null, 75); $imageData = ob_get_clean();
                    $mime = 'image/jpeg';
                    imagedestroy($src); imagedestroy($dst);
                }
            }
        }

        return 'data:' . $mime . ';base64,' . base64_encode($imageData);
    }
}