<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'HomeFix - Expert Home Services' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<nav class="navbar">
    <div class="nav-inner">
        <a href="/" class="brand">
            <div class="brand-icon">H</div>
            <span>HomeFix</span>
        </a>
        <ul class="nav-links" id="navLinks">
            <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
            <li><a href="/services" class="{{ request()->is('services*') ? 'active' : '' }}">Services</a></li>
            <li><a href="/how-it-works" class="{{ request()->is('how-it-works') ? 'active' : '' }}">How It Works</a></li>
            <li><a href="/contact" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
            @auth
            <li><a href="/my-bookings" class="{{ request()->is('my-bookings') ? 'active' : '' }}">My Bookings</a></li>
            @endauth
        </ul>
        <div class="nav-actions" id="navActions">
            @guest
                <a href="/login" class="btn-ghost">Log In</a>
                <a href="/register" class="btn-primary">Get Started</a>
            @else
                <span class="nav-user">{{ Auth::user()->name }}</span>
                <form method="POST" action="/logout" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-ghost">Log Out</button>
                </form>
            @endguest
        </div>
        <button class="hamburger" onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

@if(session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

<main>
    @yield('content')
</main>

<footer class="footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <a href="/" class="brand brand-white">
                <div class="brand-icon">H</div>
                <span>HomeFix</span>
            </a>
            <p>Your trusted home services marketplace.<br>Connecting homeowners with verified professionals.</p>
        </div>
        <div class="footer-cols">
            <div class="footer-col">
                <h4>SERVICES</h4>
                <ul>
                    <li><a href="/services?service=Plumbing">Plumbing</a></li>
                    <li><a href="/services?service=Electrical">Electrical</a></li>
                    <li><a href="/services?service=Carpentry">Carpentry</a></li>
                    <li><a href="/services?service=Cleaning">Cleaning</a></li>
                    <li><a href="/services?service=Painting">Painting</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>COMPANY</h4>
                <ul>
                    <li><a href="/how-it-works">How It Works</a></li>
                    <li><a href="/contact">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>ACCOUNT</h4>
                <ul>
                    @guest
                    <li><a href="/login">Log In</a></li>
                    <li><a href="/register">Register</a></li>
                    @else
                    <li><a href="/my-bookings">My Bookings</a></li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>&copy; {{ date('Y') }} HomeFix. All rights reserved.</span>
        <span>Built with Laravel</span>
    </div>
</footer>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>