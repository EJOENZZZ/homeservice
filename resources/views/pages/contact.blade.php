@extends('layouts.app')
@section('content')
<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:60px 20px;background:#F8FAFC">
    <div style="width:100%;max-width:620px">

        <div style="text-align:center;margin-bottom:40px">
            <div style="display:inline-flex;align-items:center;justify-content:center;width:56px;height:56px;background:#EFF6FF;border-radius:16px;margin-bottom:16px">
                <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="#2563EB" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0L12 13.5 2.25 6.75"/></svg>
            </div>
            <h1 style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:800;margin-bottom:10px">Get in Touch</h1>
            <p style="color:#6B7280;font-size:1rem;max-width:400px;margin:0 auto">Have a question, concern, or feedback? Send us a message and we'll get back to you shortly.</p>
        </div>

        <div style="background:#fff;border:1px solid #E5E7EB;border-radius:20px;padding:40px;box-shadow:0 4px 24px rgba(0,0,0,.06)">

            @if(session('success'))
            <div style="background:#ECFDF5;border:1px solid #A7F3D0;color:#065F46;border-radius:10px;padding:14px 18px;margin-bottom:24px;display:flex;align-items:center;gap:10px;font-size:.9rem">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#059669" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div style="background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;border-radius:10px;padding:14px 18px;margin-bottom:24px;font-size:.9rem">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="/contact">
                @csrf
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:18px">
                    <div>
                        <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:6px">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Juan dela Cruz" required
                            style="width:100%;border:1.5px solid #E5E7EB;border-radius:10px;padding:10px 14px;font-size:.9rem;outline:none;transition:border-color .2s;font-family:'DM Sans',sans-serif"
                            onfocus="this.style.borderColor='#2563EB'" onblur="this.style.borderColor='#E5E7EB'">
                    </div>
                    <div>
                        <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:6px">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required
                            style="width:100%;border:1.5px solid #E5E7EB;border-radius:10px;padding:10px 14px;font-size:.9rem;outline:none;transition:border-color .2s;font-family:'DM Sans',sans-serif"
                            onfocus="this.style.borderColor='#2563EB'" onblur="this.style.borderColor='#E5E7EB'">
                    </div>
                </div>

                <div style="margin-bottom:18px">
                    <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:6px">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" placeholder="How can we help you?" required
                        style="width:100%;border:1.5px solid #E5E7EB;border-radius:10px;padding:10px 14px;font-size:.9rem;outline:none;transition:border-color .2s;font-family:'DM Sans',sans-serif"
                        onfocus="this.style.borderColor='#2563EB'" onblur="this.style.borderColor='#E5E7EB'">
                </div>

                <div style="margin-bottom:28px">
                    <label style="display:block;font-size:.82rem;font-weight:600;color:#374151;margin-bottom:6px">Message</label>
                    <textarea name="message" rows="5" placeholder="Write your message here..." required
                        style="width:100%;border:1.5px solid #E5E7EB;border-radius:10px;padding:10px 14px;font-size:.9rem;outline:none;resize:vertical;transition:border-color .2s;font-family:'DM Sans',sans-serif"
                        onfocus="this.style.borderColor='#2563EB'" onblur="this.style.borderColor='#E5E7EB'">{{ old('message') }}</textarea>
                </div>

                <button type="submit"
                    style="width:100%;background:#2563EB;color:#fff;border:none;border-radius:10px;padding:13px;font-size:.95rem;font-weight:700;cursor:pointer;font-family:'DM Sans',sans-serif;transition:background .2s"
                    onmouseover="this.style.background='#1D4ED8'" onmouseout="this.style.background='#2563EB'">
                    Send Message
                </button>
            </form>
        </div>

        <div style="display:flex;justify-content:center;gap:40px;margin-top:32px;flex-wrap:wrap">
            <div style="text-align:center">
                <div style="font-size:.8rem;font-weight:600;color:#9CA3AF;margin-bottom:4px">EMAIL</div>
                <div style="font-size:.9rem;color:#374151">admin@homefix.app</div>
            </div>
            <div style="text-align:center">
                <div style="font-size:.8rem;font-weight:600;color:#9CA3AF;margin-bottom:4px">RESPONSE TIME</div>
                <div style="font-size:.9rem;color:#374151">Within 24 hours</div>
            </div>
        </div>

    </div>
</div>
@endsection
