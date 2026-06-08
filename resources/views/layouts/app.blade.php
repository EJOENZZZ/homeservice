<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'HomeService - Expert Home Services' }}</title>

    <link rel="stylesheet" href="/build/assets/app-Cy8pVWIW.css">
    <script src="/build/assets/app-DYkQ-fdl.js" defer></script>
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
            <li><a href="/contact" class="{{ request()->is('contact') ? 'active' : '' }}">Contact</a></li>
        </ul>

        <div class="nav-actions" id="navActions">
    @guest
        <a href="/login" class="btn-ghost">Log In</a>
        <a href="/register" class="btn-primary">Get Started</a>
    @else
        <div style="position:relative" id="account-menu-wrap">
            <button onclick="toggleAccountMenu()" style="display:flex;align-items:center;gap:8px;background:none;border:none;cursor:pointer;color:var(--black);padding:0">
                <div style="width:32px;height:32px;border-radius:50%;background:var(--blue-light);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:.75rem;color:var(--blue);overflow:hidden">
                    @if(Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" style="width:100%;height:100%;object-fit:cover">
                    @else
                        {{ Auth::user()->initials }}
                    @endif
                </div>
                <span class="nav-user" style="font-size:.85rem">{{ Auth::user()->name }}</span>
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"><path d="M2 4l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
            </button>
            <div id="account-dropdown" style="display:none;position:absolute;right:0;top:calc(100% + 10px);background:#fff;border:1.5px solid var(--gray-border);border-radius:14px;padding:8px;min-width:180px;box-shadow:0 8px 24px rgba(0,0,0,.1);z-index:999">
                <a href="/profile" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:9px;text-decoration:none;color:var(--black);font-size:.88rem;font-weight:500" onmouseover="this.style.background='var(--gray-light)'" onmouseout="this.style.background=''">👤 My Profile</a>
                <a href="/my-bookings" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:9px;text-decoration:none;color:var(--black);font-size:.88rem;font-weight:500" onmouseover="this.style.background='var(--gray-light)'" onmouseout="this.style.background=''">📅 My Bookings</a>
                <a href="/messages" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:9px;text-decoration:none;color:var(--black);font-size:.88rem;font-weight:500" onmouseover="this.style.background='var(--gray-light)'" onmouseout="this.style.background=''">💬 Messages</a>
                <div style="border-top:1px solid var(--gray-border);margin:6px 0"></div>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" style="display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:9px;width:100%;background:none;border:none;cursor:pointer;color:#DC2626;font-size:.88rem;font-weight:500;text-align:left" onmouseover="this.style.background='#FEF2F2'" onmouseout="this.style.background=''">🚪 Log Out</button>
                </form>
            </div>
        </div>
    @endguest
</div>

<script>
function toggleAccountMenu() {
    const d = document.getElementById('account-dropdown');
    d.style.display = d.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', function(e) {
    const wrap = document.getElementById('account-menu-wrap');
    if (wrap && !wrap.contains(e.target)) {
        document.getElementById('account-dropdown').style.display = 'none';
    }
});
</script>
</nav>

@if(session('success'))
<div class="alert-success">
    {{ session('success') }}
</div>
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

            <p>
                Your trusted home services marketplace.<br>
                Connecting homeowners with verified professionals.
            </p>
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

</body>
</html>
