@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <a href="/" class="brand auth-brand">
            <div class="brand-icon">H</div>
            <span>HomeFix</span>
        </a>
        <h1 class="auth-title">Create an account</h1>
        <p class="auth-sub">Join thousands of happy homeowners</p>

        @if($errors->any())
        <div class="form-error-box">
            <ul style="margin:0;padding-left:16px">
                @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="/register" class="auth-form">
            @csrf
            <div class="form-group">
                <label>Full name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Juan dela Cruz" required>
            </div>
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="you@email.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Min. 8 characters" required>
            </div>
            <div class="form-group">
                <label>Confirm password</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-primary btn-full">Create Account</button>
        </form>

        <p class="auth-switch">Already have an account? <a href="/login">Log in</a></p>
    </div>
</div>
@endsection