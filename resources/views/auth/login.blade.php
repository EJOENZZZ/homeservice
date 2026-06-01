@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <a href="/" class="brand auth-brand">
            <div class="brand-icon">H</div>
            <span>HomeFix</span>
        </a>
        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-sub">Log in to your account</p>

        @if(session('info'))
        <div class="alert-info">{{ session('info') }}</div>
        @endif

        @if(session('success'))
        <div class="alert-success-box">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="form-error-box">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/login" class="auth-form">
            @csrf
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    placeholder="you@email.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <div class="form-check">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn-primary btn-full">Log In</button>
        </form>

        <p class="auth-switch">Don't have an account? <a href="/register">Sign up</a></p>

        <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--gray-border);text-align:center">
            <a href="/admin/login"
                style="font-size:.82rem;color:var(--gray-mid);text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:color .2s"
                onmouseover="this.style.color='#2563EB'"
                onmouseout="this.style.color=''">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Admin Panel
            </a>
        </div>
    </div>
</div>
@endsection