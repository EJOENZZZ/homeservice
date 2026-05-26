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

        @if($errors->any())
        <div class="form-error-box">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="/login" class="auth-form">
            @csrf
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required>
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
    </div>
</div>
@endsection