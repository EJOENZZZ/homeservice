<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superadmin Login — HomeFix</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #0F172A; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { background: #1E293B; border-radius: 20px; padding: 48px 40px; width: 100%; max-width: 420px; border: 1px solid #334155; }
        .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 32px; justify-content: center; }
        .brand-icon { width: 40px; height: 40px; background: #7C3AED; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; color: #fff; }
        .brand span { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.2rem; color: #fff; }
        h1 { font-family: 'Syne', sans-serif; font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 6px; text-align: center; }
        p { color: #64748B; font-size: .9rem; text-align: center; margin-bottom: 32px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-size: .82rem; font-weight: 600; color: #94A3B8; margin-bottom: 6px; }
        input { width: 100%; padding: 11px 14px; background: #0F172A; border: 1.5px solid #334155; border-radius: 10px; color: #fff; font-size: .92rem; font-family: 'DM Sans', sans-serif; outline: none; transition: border-color .2s; }
        input:focus { border-color: #7C3AED; }
        input::placeholder { color: #475569; }
        .btn { width: 100%; padding: 13px; background: #7C3AED; color: #fff; border: none; border-radius: 10px; font-size: .95rem; font-weight: 600; cursor: pointer; margin-top: 8px; font-family: 'DM Sans', sans-serif; transition: background .2s; }
        .btn:hover { background: #6D28D9; }
        .error { background: rgba(220,38,38,.15); border: 1px solid rgba(220,38,38,.3); color: #FCA5A5; border-radius: 8px; padding: 10px 14px; font-size: .85rem; margin-bottom: 16px; }
        .links { text-align: center; margin-top: 20px; font-size: .85rem; color: #475569; display: flex; justify-content: center; gap: 16px; }
        .links a { color: #A78BFA; text-decoration: none; }
        .links a:hover { text-decoration: underline; }
        .badge { display: inline-block; background: rgba(124,58,237,.2); color: #A78BFA; border: 1px solid rgba(124,58,237,.3); border-radius: 6px; font-size: .75rem; font-weight: 600; padding: 3px 10px; margin-bottom: 20px; text-align: center; width: 100%; }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">
            <div class="brand-icon">H</div>
            <span>HomeFix</span>
        </div>
        <div class="badge">⚡ Superadmin Panel</div>
        <h1>Superadmin Access</h1>
        <p>Sign in to the superadmin panel</p>

        @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
        @endif

        @if(session('warning'))
        <div class="error">{{ session('warning') }}</div>
        @endif

        <form method="POST" action="/superadmin/login">
            @csrf
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="superadmin@homefix.app" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn">Sign In</button>
        </form>
        <div class="links">
            <a href="/admin/login">Admin Panel</a>
            <a href="/">← Back to site</a>
        </div>
    </div>
</body>
</html>
