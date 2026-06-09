@extends('layouts.app')
@section('content')

<div style="min-height:80vh;display:flex;align-items:center;justify-content:center;padding:60px 20px;background:#F8FAFC">
    <div style="width:100%;max-width:760px">
        <div style="background:#fff;border:1px solid #E5E7EB;border-radius:24px;padding:32px;box-shadow:0 10px 30px rgba(15,23,42,.06)">
            <div style="text-align:center;margin-bottom:28px">
                <div style="display:inline-flex;align-items:center;justify-content:center;width:60px;height:60px;background:#EFF6FF;border-radius:18px;margin-bottom:18px">
                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="#2563EB" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                </div>
                <h1 style="font-family:'Syne',sans-serif;font-size:2rem;font-weight:800;margin-bottom:10px">Contact Admin</h1>
                <p style="color:#6B7280;font-size:1rem;max-width:520px;margin:0 auto;line-height:1.6">
                    Professional accounts can send messages directly to the admin team here.
                </p>
            </div>

            @if(session('success'))
            <div style="background:#ECFDF5;border:1px solid #A7F3D0;color:#065F46;border-radius:12px;padding:12px 14px;margin-bottom:20px">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div style="background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;border-radius:12px;padding:12px 14px;margin-bottom:20px">
                <ul style="margin:0;padding-left:18px">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:18px">
                <div>
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#374151;margin-bottom:6px">Name</label>
                    <input type="text" value="{{ $pro->full_name }}" readonly style="width:100%;border:1.5px solid #E5E7EB;border-radius:12px;padding:12px 14px;background:#F9FAFB;color:#111827">
                </div>
                <div>
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#374151;margin-bottom:6px">Email</label>
                    <input type="text" value="{{ $pro->email }}" readonly style="width:100%;border:1.5px solid #E5E7EB;border-radius:12px;padding:12px 14px;background:#F9FAFB;color:#111827">
                </div>
            </div>

            <form method="POST" action="{{ route('contact.store') }}">
                @csrf
                <div style="margin-bottom:16px">
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#374151;margin-bottom:6px">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" placeholder="What do you need help with?" required style="width:100%;border:1.5px solid #E5E7EB;border-radius:12px;padding:12px 14px;outline:none">
                </div>
                <div style="margin-bottom:18px">
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#374151;margin-bottom:6px">Message</label>
                    <textarea name="message" rows="8" placeholder="Write your message to the admin..." required style="width:100%;border:1.5px solid #E5E7EB;border-radius:12px;padding:12px 14px;outline:none;resize:vertical">{{ old('message') }}</textarea>
                </div>
                <button type="submit" style="width:100%;background:#2563EB;color:#fff;border:none;border-radius:12px;padding:14px 16px;font-weight:700;font-family:'DM Sans',sans-serif;cursor:pointer">Send to Admin</button>
            </form>
        </div>
    </div>
</div>

@endsection
