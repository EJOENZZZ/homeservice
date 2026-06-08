@extends('layouts.app')
@section('content')

<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:60px 20px;background:#F8FAFC">
    <div style="width:100%;max-width:680px">

        {{-- HEADER --}}
        <div style="text-align:center;margin-bottom:48px">
            <div style="display:inline-flex;align-items:center;justify-content:center;width:60px;height:60px;background:#EFF6FF;border-radius:18px;margin-bottom:18px">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#2563EB" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
            </div>
            <h1 style="font-family:'Syne',sans-serif;font-size:2.2rem;font-weight:800;margin-bottom:12px">Contact Us</h1>
            <p style="color:#6B7280;font-size:1rem;max-width:440px;margin:0 auto;line-height:1.6">
                Need help or have a question? Reach out to us directly — we're here to assist you.
            </p>
        </div>

        {{-- CONTACT CARDS --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px">

            {{-- PHONE --}}
            <a href="tel:+639123456789" style="text-decoration:none">
                <div style="background:#fff;border:1.5px solid #E5E7EB;border-radius:18px;padding:28px 24px;text-align:center;transition:all .2s;cursor:pointer"
                    onmouseover="this.style.borderColor='#2563EB';this.style.boxShadow='0 4px 20px rgba(37,99,235,.1)'"
                    onmouseout="this.style.borderColor='#E5E7EB';this.style.boxShadow='none'">
                    <div style="width:48px;height:48px;background:#EFF6FF;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#2563EB" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    </div>
                    <div style="font-size:.75rem;font-weight:700;letter-spacing:.08em;color:#9CA3AF;margin-bottom:6px">PHONE</div>
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem;color:#111827">+63 912 345 6789</div>
                    <div style="font-size:.8rem;color:#6B7280;margin-top:4px">Mon – Sat, 8AM – 6PM</div>
                </div>
            </a>

            {{-- EMAIL --}}
            <a href="mailto:admin@homefix.app" style="text-decoration:none">
                <div style="background:#fff;border:1.5px solid #E5E7EB;border-radius:18px;padding:28px 24px;text-align:center;transition:all .2s;cursor:pointer"
                    onmouseover="this.style.borderColor='#2563EB';this.style.boxShadow='0 4px 20px rgba(37,99,235,.1)'"
                    onmouseout="this.style.borderColor='#E5E7EB';this.style.boxShadow='none'">
                    <div style="width:48px;height:48px;background:#EFF6FF;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#2563EB" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0L12 13.5 2.25 6.75"/></svg>
                    </div>
                    <div style="font-size:.75rem;font-weight:700;letter-spacing:.08em;color:#9CA3AF;margin-bottom:6px">EMAIL</div>
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem;color:#111827">admin@homefix.app</div>
                    <div style="font-size:.8rem;color:#6B7280;margin-top:4px">We reply within 24 hours</div>
                </div>
            </a>

        </div>

        {{-- LOCATION + FACEBOOK --}}
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:32px">

            {{-- LOCATION --}}
            <div style="background:#fff;border:1.5px solid #E5E7EB;border-radius:18px;padding:28px 24px;text-align:center">
                <div style="width:48px;height:48px;background:#ECFDF5;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#059669" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                </div>
                <div style="font-size:.75rem;font-weight:700;letter-spacing:.08em;color:#9CA3AF;margin-bottom:6px">LOCATION</div>
                <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem;color:#111827">Cebu City</div>
                <div style="font-size:.8rem;color:#6B7280;margin-top:4px">Philippines</div>
            </div>

            {{-- FACEBOOK --}}
            <a href="https://facebook.com/homefix" target="_blank" style="text-decoration:none">
                <div style="background:#fff;border:1.5px solid #E5E7EB;border-radius:18px;padding:28px 24px;text-align:center;transition:all .2s;cursor:pointer"
                    onmouseover="this.style.borderColor='#2563EB';this.style.boxShadow='0 4px 20px rgba(37,99,235,.1)'"
                    onmouseout="this.style.borderColor='#E5E7EB';this.style.boxShadow='none'">
                    <div style="width:48px;height:48px;background:#EFF6FF;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="#2563EB"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </div>
                    <div style="font-size:.75rem;font-weight:700;letter-spacing:.08em;color:#9CA3AF;margin-bottom:6px">FACEBOOK</div>
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem;color:#111827">HomeFix PH</div>
                    <div style="font-size:.8rem;color:#6B7280;margin-top:4px">Message us on Facebook</div>
                </div>
            </a>

        </div>

        {{-- BOTTOM NOTE --}}
        <div style="background:#fff;border:1.5px solid #E5E7EB;border-radius:16px;padding:20px 24px;display:flex;align-items:center;gap:14px">
            <div style="width:40px;height:40px;background:#FEF3C7;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#D97706" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
            </div>
            <p style="font-size:.88rem;color:#6B7280;line-height:1.6;margin:0">
                For booking-related concerns, you can also message your professional directly through the
                <a href="/messages" style="color:#2563EB;font-weight:600;text-decoration:none">Messages</a> section after logging in.
            </p>
        </div>

    </div>
</div>

@endsection
