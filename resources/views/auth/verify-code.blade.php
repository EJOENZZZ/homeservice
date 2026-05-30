@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <a href="/" class="brand auth-brand">
            <div class="brand-icon">H</div>
            <span>HomeService</span>
        </a>
        <h1 class="auth-title">Verify your email</h1>
        <p class="auth-sub">We sent a 6-digit code to <strong>{{ $email }}</strong></p>

        @if(session('info'))
        <div class="alert-info">{{ session('info') }}</div>
        @endif

        @if(session('success'))
        <div class="alert-success-box">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="form-error-box">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/verify-code?email={{ urlencode($email) }}" class="auth-form">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="form-group">
                <label>Enter verification code</label>
                <input type="text" name="code" maxlength="6"
                    value="{{ old('code') }}"
                    placeholder="000000"
                    style="text-align:center;font-size:2rem;font-weight:800;letter-spacing:12px;"
                    autocomplete="one-time-code" autofocus required>
            </div>
            <button type="submit" class="btn-primary btn-full">Verify Email</button>
        </form>

        <form method="POST" action="/resend-code?email={{ urlencode($email) }}" style="margin-top:16px">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="btn-ghost btn-full" style="width:100%;text-align:center;">
                Resend code
            </button>
        </form>

        <p class="auth-switch" style="margin-top:16px">
            <a href="/register">← Back to register</a>
        </p>
    </div>
</div>
@endsection