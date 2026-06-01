<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ProAuthController extends Controller
{
    public function showLogin()
    {
        if (session('pro_id')) return redirect('/pro/dashboard');
        return view('pro.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        try {
            $pro = Professional::where('email', $request->email)->first();

            if (!$pro || !Hash::check($request->password, $pro->password)) {
                return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
            }

            if (!$pro->is_verified) {
                $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $pro->update([
                    'verification_code'       => $code,
                    'verification_expires_at' => now()->addMinutes(10),
                ]);
                $this->sendCode($pro->email, $pro->first_name, $code);
                return redirect('/pro/verify?email=' . urlencode($pro->email))
                    ->with('info', 'Please verify your email first.');
            }

            session(['pro_id' => $pro->id, 'pro_name' => $pro->full_name]);
            $pro->update(['last_seen_at' => now()]);
            return redirect('/pro/dashboard');

        } catch (\Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }
    }

    public function showRegister()
    {
        return view('pro.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email',
            'specialty'  => 'required|string',
            'password'   => 'required|min:8|confirmed',
        ]);

        try {
            $exists = Professional::where('email', $request->email)->first();
            if ($exists && $exists->is_verified) {
                return back()->withErrors(['email' => 'Email already registered.'])->withInput();
            }

            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            if ($exists) {
                $exists->update([
                    'first_name'              => $request->first_name,
                    'last_name'               => $request->last_name,
                    'specialty'               => $request->specialty,
                    'password'                => Hash::make($request->password),
                    'verification_code'       => $code,
                    'verification_expires_at' => now()->addMinutes(10),
                ]);
                $pro = $exists;
            } else {
                $pro = Professional::create([
                    'first_name'              => $request->first_name,
                    'last_name'               => $request->last_name,
                    'email'                   => $request->email,
                    'specialty'               => $request->specialty,
                    'password'                => Hash::make($request->password),
                    'verification_code'       => $code,
                    'verification_expires_at' => now()->addMinutes(10),
                    'is_verified'             => false,
                    'badge'                   => 'VERIFIED',
                    'rating'                  => 5.00,
                    'jobs_count'              => 0,
                    'is_active'               => false, // Admin approves first
                ]);
            }

            $this->sendCode($pro->email, $pro->first_name, $code);

            // Notify admin
            Notification::send('admin', 0, 'new_professional',
                'New Professional Registered',
                $pro->full_name . ' registered as ' . $pro->specialty,
                '/admin/professionals'
            );

            return redirect('/pro/verify?email=' . urlencode($pro->email));

        } catch (\Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }
    }

    public function showVerify(Request $request)
    {
        $email = $request->query('email');
        if (!$email) return redirect('/pro/register');
        return view('pro.auth.verify', ['email' => $email]);
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        try {
            $email = $request->input('email') ?? $request->query('email');
            $pro   = Professional::where('email', $email)->first();

            if (!$pro) return back()->withErrors(['code' => 'Account not found.']);

            if ((string)$pro->verification_code !== (string)$request->code) {
                return back()->withErrors(['code' => 'Invalid verification code.'])->withInput();
            }

            if (now()->gt($pro->verification_expires_at)) {
                return back()->withErrors(['code' => 'Code expired. Click Resend.'])->withInput();
            }

            $pro->update([
                'is_verified'             => true,
                'verification_code'       => null,
                'verification_expires_at' => null,
            ]);

            session(['pro_id' => $pro->id, 'pro_name' => $pro->full_name]);
            return redirect('/pro/dashboard')->with('success', 'Email verified! Welcome to HomeFix.');

        } catch (\Exception $e) {
            return back()->withErrors(['code' => $e->getMessage()]);
        }
    }

    public function resendCode(Request $request)
    {
        $email = $request->input('email') ?? $request->query('email');
        $pro   = Professional::where('email', $email)->first();
        if (!$pro) return redirect('/pro/register');

        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $pro->update([
            'verification_code'       => $code,
            'verification_expires_at' => now()->addMinutes(10),
        ]);
        $this->sendCode($pro->email, $pro->first_name, $code);
        return redirect('/pro/verify?email=' . urlencode($email))->with('success', 'New code sent!');
    }

    public function logout()
    {
        session()->forget(['pro_id', 'pro_name']);
        return redirect('/pro/login');
    }

    private function sendCode(string $email, string $name, string $code): void
    {
        Mail::html("
            <div style='font-family:sans-serif;max-width:480px;margin:0 auto;padding:32px;'>
                <h2>Verify your email</h2>
                <p style='color:#6B7280'>Hi {$name}, use this code to verify your HomeFix Professional account:</p>
                <div style='background:#EFF6FF;border-radius:12px;padding:24px;text-align:center;margin:24px 0'>
                    <span style='font-size:2.5rem;font-weight:800;letter-spacing:12px;color:#2563EB'>{$code}</span>
                </div>
                <p style='color:#6B7280;font-size:.88rem'>Expires in <strong>10 minutes</strong>.</p>
            </div>
        ", fn($m) => $m->to($email)->subject('Your HomeFix verification code'));
    }
}