<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Professional;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        if (!session('pro_id')) {
            return redirect('/pro/login');
        }

        $pro = Professional::findOrFail(session('pro_id'));

        return view('pages.contact', compact('pro'));
    }

    public function store(Request $request)
    {
        if (!session('pro_id')) {
            return redirect('/pro/login');
        }

        $pro = Professional::findOrFail(session('pro_id'));

        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create([
            'name' => $pro->full_name,
            'email' => $pro->email,
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);

        return back()->with('success', 'Message sent successfully. We will get back to you soon.');
    }
}