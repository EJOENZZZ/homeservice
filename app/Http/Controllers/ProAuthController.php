<?php

namespace App\Http\Controllers;

use App\Models\Professional;
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
                return back()->withErrors(['email' => 'Your account is not yet verified. Please contact admin.'])->withInput();
            }

            session(['pro_id' => $pro->id, 'pro_name' => $pro->full_name]);
            $pro->update(['last_seen_at' => now()]);

            // Force change password on first login
            if ($pro->must_change_password) {
                return redirect('/pro/change-password')->with('warning', 'Please change your password before continuing.');
            }

            return redirect('/pro/dashboard');

        } catch (\Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()])->withInput();
        }
    }

    public function showChangePassword()
    {
        if (!session('pro_id')) return redirect('/pro/login');
        return view('pro.auth.change-password');
    }

    public function changePassword(Request $request)
    {
        if (!session('pro_id')) return redirect('/pro/login');

        $request->validate([
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $pro = Professional::findOrFail(session('pro_id'));
        $pro->update([
            'password'             => Hash::make($request->password),
            'must_change_password' => false,
        ]);

        return redirect('/pro/dashboard')->with('success', 'Password changed successfully! Welcome to HomeFix.');
    }

    public function logout()
    {
        session()->forget(['pro_id', 'pro_name']);
        return redirect('/pro/login');
    }
}