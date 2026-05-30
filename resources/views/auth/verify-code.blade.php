@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card" style="text-align:center">
        <a href="/" class="brand auth-brand">
            <div class="brand-icon">H</div>
            <span>HomeService</span>
        </a>

        <div style="font-size:2.5rem;margin-bottom:12px">📧</div>
        <h1 class="auth-title">Check your email</h1>
        <p class="auth-sub">
            We sent a 6-digit code to<br>
            <strong>{{ $email }}</strong>
        </p>

        @if(session('success'))
        <div class="alert-success" style="border-radius:10px;margin-bottom:20px">
            {{ session('success') }}
        </div>
        @endif

        @if(session('info'))
        <div class="alert-success" style="border-radius:10px;margin-bottom:20px;background:#EFF6FF;border-color:#BFDBFE;color:#1D4ED8">
            {{ session('info') }}
        </div>
        @endif

        @if($errors->any())
        <div class="form-error-box" style="margin-bottom:20px">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/verify-code" class="auth-form">
            @csrf
            <div class="form-group">
                <label>Verification Code</label>
                <input
                    type="text"
                    name="code"
                    maxlength="6"
                    placeholder="000000"
                    style="text-align:center;font-size:1.8rem;font-weight:800;letter-spacing:10px;padding:16px;"
                    autofocus
                    required
                >
            </div>
            <button type="submit" class="btn-primary btn-full">Verify Email</button>
        </form>

        <p style="margin-top:20px;font-size:.88rem;color:var(--gray-mid)">
            Didn't receive the code?
        </p>
        <form method="POST" action="/verify-code/resend" style="margin-top:8px">
            @csrf
            <button type="submit" class="btn-ghost btn-full">Resend Code</button>
        </form>
    </div>
</div>
@endsection
