<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function show()
    {
        $user     = Auth::user();
        $bookings = $user->bookings()->with('professional')->latest()->limit(5)->get();
        return view('pages.profile', compact('user', 'bookings'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
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
        $user->update($data);
        return back()->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->password)]);
        return back()->with('success', 'Password changed successfully.');
    }
}