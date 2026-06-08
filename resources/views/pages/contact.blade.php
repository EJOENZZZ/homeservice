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
            <a href="tel:+639562779244" style="text-decoration:none">
                <div style="background:#fff;border:1.5px solid #E5E7EB;border-radius:18px;padding:28px 24px;text-align:center;transition:all .2s;cursor:pointer"
                    onmouseover="this.style.borderColor='#2563EB';this.style.boxShadow='0 4px 20px rgba(37,99,235,.1)'"
                    onmouseout="this.style.borderColor='#E5E7EB';this.style.boxShadow='none'">
                    <div style="width:48px;height:48px;background:#EFF6FF;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                        <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#2563EB" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                    </div>
                    <div style="font-size:.75rem;font-weight:700;letter-spacing:.08em;color:#9CA3AF;margin-bottom:6px">PHONE</div>
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem;color:#111827">+63 956 277 9244</div>
                    <div style="font-size:.8rem;color:#6B7280;margin-top:4px">Mon – Sat, 8AM – 6PM</div>
                </div>
            </a>

            {{-- EMAIL --}}
            <a href="https://m.me/homefix" target="_blank" style="text-decoration:none">
                <div style="background:#fff;border:1.5px solid #E5E7EB;border-radius:18px;padding:28px 24px;text-align:center;transition:all .2s;cursor:pointer"
                    onmouseover="this.style.borderColor='#2563EB';this.style.boxShadow='0 4px 20px rgba(37,99,235,.1)'"
                    onmouseout="this.style.borderColor='#E5E7EB';this.style.boxShadow='none'">
                    <div style="width:48px;height:48px;background:#EFF6FF;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="#2563EB"><path d="M12 2C6.477 2 2 6.145 2 11.243c0 2.908 1.438 5.504 3.687 7.205V22l3.37-1.85c.9.249 1.853.384 2.843.384 5.523 0 10-4.145 10-9.243S17.523 2 12 2zm1.007 12.435l-2.547-2.715-4.97 2.715 5.467-5.804 2.611 2.715 4.906-2.715-5.467 5.804z"/></svg>
                    </div>
                    <div style="font-size:.75rem;font-weight:700;letter-spacing:.08em;color:#9CA3AF;margin-bottom:6px">MESSAGE US</div>
                    <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem;color:#111827">Facebook Messenger</div>
                    <div style="font-size:.8rem;color:#6B7280;margin-top:4px">Click to message us directly</div>
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



    </div>
</div>

@endsection
