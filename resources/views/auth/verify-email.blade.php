@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card" style="text-align:center">
        <a href="/" class="brand auth-brand">
            <div class="brand-icon">H</div>
            <span>HomeFix</span>
        </a>

        <div style="font-size:3rem;margin-bottom:16px">📧</div>
        <h1 class="auth-title">Verify your email</h1>
        <p class="auth-sub">
            We sent a verification link to <strong>{{ Auth::user()->email }}</strong>.<br>
            Please check your inbox and click the link to activate your account.
        </p>

        @if(session('success'))
        <div class="alert-success" style="border-radius:10px;margin-bottom:20px">
            {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="/email/verification-notification">
            @csrf
            <button type="submit" class="btn-primary btn-full">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="/logout" style="margin-top:12px">
            @csrf
            <button type="submit" class="btn-ghost btn-full">Log Out</button>
        </form>
    </div>
</div>
@endsection
