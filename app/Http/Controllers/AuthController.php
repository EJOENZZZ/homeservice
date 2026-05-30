<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        try {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
            }

            if (!$user->is_verified) {
                $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                $user->update([
                    'verification_code'       => $code,
                    'verification_expires_at' => now()->addMinutes(10),
                ]);
                $this->sendCode($user->email, $user->name, $code);
                return redirect('/verify-code?email=' . urlencode($user->email))
                    ->with('info', 'Please verify your email first. A new code has been sent.');
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();
            return redirect()->intended('/');

        } catch (\Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        try {
            $exists = User::where('email', $request->email)->first();

            if ($exists && $exists->is_verified) {
                return back()->withErrors(['email' => 'Email already taken.'])->withInput();
            }

            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            if ($exists) {
                $exists->update([
                    'name'                    => $request->name,
                    'password'                => Hash::make($request->password),
                    'verification_code'       => $code,
                    'verification_expires_at' => now()->addMinutes(10),
                ]);
                $user = $exists;
            } else {
                $user = User::create([
                    'name'                    => $request->name,
                    'email'                   => $request->email,
                    'password'                => Hash::make($request->password),
                    'verification_code'       => $code,
                    'verification_expires_at' => now()->addMinutes(10),
                    'is_verified'             => false,
                ]);
            }

            $this->sendCode($user->email, $user->name, $code);
            return redirect('/verify-code?email=' . urlencode($user->email));

        } catch (\Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }
    }

    public function showVerify(Request $request)
    {
        $email = $request->query('email') ?? session('verify_email');
        if (!$email) return redirect('/register');
        return view('auth.verify-code', ['email' => $email]);
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|digits:6']);

        try {
            $email = $request->input('email') ?? $request->query('email');
            $code  = $request->input('code');

            if (!$email) {
                return back()->withErrors(['code' => 'Session expired. Please register again.']);
            }

            $user = User::where('email', $email)->first();

            if (!$user) {
                return back()->withErrors(['code' => 'User not found.']);
            }

            if ((string)$user->verification_code !== (string)$code) {
                return back()->withErrors(['code' => 'Invalid verification code.'])->withInput();
            }

            if (now()->gt($user->verification_expires_at)) {
                return back()->withErrors(['code' => 'Code expired. Click Resend.'])->withInput();
            }

            $user->update([
                'is_verified'             => true,
                'verification_code'       => null,
                'verification_expires_at' => null,
                'email_verified_at'       => now(),
            ]);

            Auth::login($user);
            return redirect('/')->with('success', 'Email verified! Welcome to HomeFix.');

        } catch (\Exception $e) {
            return back()->withErrors(['code' => $e->getMessage()]);
        }
    }

    public function resendCode(Request $request)
    {
        try {
            $email = $request->input('email') ?? $request->query('email');
            $user  = User::where('email', $email)->first();
            if (!$user) return redirect('/register');

            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->update([
                'verification_code'       => $code,
                'verification_expires_at' => now()->addMinutes(10),
            ]);
            $this->sendCode($user->email, $user->name, $code);
            return redirect('/verify-code?email=' . urlencode($email))
                ->with('success', 'New code sent!');

        } catch (\Exception $e) {
            return back()->withErrors(['code' => $e->getMessage()]);
        }
    }

    private function sendCode(string $email, string $name, string $code): void
    {
        Mail::html("
            <div style='font-family:sans-serif;max-width:480px;margin:0 auto;padding:32px;'>
                <h2 style='font-size:1.5rem;margin-bottom:8px;'>Verify your email</h2>
                <p style='color:#6B7280;margin-bottom:24px;'>Hi {$name}, use this code to verify your HomeFix account:</p>
                <div style='background:#EFF6FF;border-radius:12px;padding:24px;text-align:center;margin-bottom:24px;'>
                    <span style='font-size:2.5rem;font-weight:800;letter-spacing:12px;color:#2563EB;'>{$code}</span>
                </div>
                <p style='color:#6B7280;font-size:.88rem;'>Expires in <strong>10 minutes</strong>.</p>
            </div>
        ", function ($m) use ($email) {
            $m->to($email)->subject('Your HomeFix verification code');
        });
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}