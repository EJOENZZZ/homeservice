<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
            return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
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
            $exists = User::where('email', $request->email)->exists();
            if ($exists) {
                return back()->withErrors(['email' => 'Email already taken.'])->withInput();
            }
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);
            Auth::login($user);
            $user->sendEmailVerificationNotification();
            return redirect('/email/verify')->with('success', 'Account created! Please check your email to verify your account.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
