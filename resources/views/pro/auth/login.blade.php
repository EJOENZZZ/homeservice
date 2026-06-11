<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Login — HomeFix</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #0F172A; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { background: #1E293B; border-radius: 20px; padding: 48px 40px; width: 100%; max-width: 420px; border: 1px solid #334155; }
        .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; justify-content: center; text-decoration: none; }
        .brand-icon { width: 40px; height: 40px; background: #2563EB; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; color: #fff; }
        .brand span { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.2rem; color: #fff; }
        .pro-badge { display: block; text-align: center; background: #172554; color: #60A5FA; font-size: .72rem; font-weight: 700; padding: 4px 14px; border-radius: 20px; letter-spacing: .08em; margin: 0 auto 28px; width: fit-content; }
        h1 { font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 6px; text-align: center; }
        p.sub { color: #64748B; font-size: .9rem; text-align: center; margin-bottom: 28px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: .82rem; font-weight: 600; color: #94A3B8; margin-bottom: 6px; }
        input { width: 100%; padding: 11px 14px; background: #0F172A; border: 1.5px solid #334155; border-radius: 10px; color: #fff; font-size: .92rem; font-family: 'DM Sans', sans-serif; outline: none; transition: border-color .2s; }
        input:focus { border-color: #2563EB; }
        input::placeholder { color: #475569; }
        .btn { width: 100%; padding: 13px; background: #2563EB; color: #fff; border: none; border-radius: 10px; font-size: .95rem; font-weight: 600; cursor: pointer; margin-top: 8px; font-family: 'DM Sans', sans-serif; transition: background .2s; }
        .btn:hover { background: #1D4ED8; }
        .error { background: rgba(220,38,38,.15); border: 1px solid rgba(220,38,38,.3); color: #FCA5A5; border-radius: 8px; padding: 10px 14px; font-size: .85rem; margin-bottom: 16px; }
        .info { background: rgba(37,99,235,.15); border: 1px solid rgba(37,99,235,.3); color: #93C5FD; border-radius: 8px; padding: 10px 14px; font-size: .85rem; margin-bottom: 16px; }
        .links { text-align: center; margin-top: 20px; font-size: .85rem; color: #475569; display: flex; flex-direction: column; gap: 10px; }
        .links a { color: #60A5FA; text-decoration: none; }
        .divider { border: none; border-top: 1px solid #1E293B; margin: 12px 0; }
    </style>
</head>
<body>
    <div class="card">
        <a href="/" class="brand">
            <div class="brand-icon">H</div>
            <span>HomeFix</span>
        </a>
        <span class="pro-badge">PROFESSIONAL PORTAL</span>
        <h1>Welcome back</h1>
        <p class="sub">Sign in to your professional account</p>

        @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
        @endif

        @if(session('info'))
        <div class="info">{{ session('info') }}</div>
        @endif

        <form method="POST" action="/pro/login">
            @csrf
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="pro@email.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>

        <div class="links">
            <a href="/login">← Back to user login</a>
        </div>
    </div>
</body>
</html>
