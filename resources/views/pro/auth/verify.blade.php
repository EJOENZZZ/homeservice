<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email — HomeFix Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #0F172A; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { background: #1E293B; border-radius: 20px; padding: 48px 40px; width: 100%; max-width: 420px; border: 1px solid #334155; text-align: center; }
        .icon { font-size: 3rem; margin-bottom: 16px; }
        h1 { font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 8px; }
        p { color: #64748B; font-size: .9rem; margin-bottom: 28px; }
        p strong { color: #94A3B8; }
        .form-group { margin-bottom: 16px; text-align: left; }
        label { display: block; font-size: .82rem; font-weight: 600; color: #94A3B8; margin-bottom: 6px; }
        input { width: 100%; padding: 16px; background: #0F172A; border: 1.5px solid #334155; border-radius: 10px; color: #fff; font-size: 2rem; font-weight: 800; letter-spacing: 12px; text-align: center; font-family: 'Syne', sans-serif; outline: none; transition: border-color .2s; }
        input:focus { border-color: #2563EB; }
        input::placeholder { color: #334155; letter-spacing: 4px; font-size: 1.5rem; }
        .btn { width: 100%; padding: 13px; background: #2563EB; color: #fff; border: none; border-radius: 10px; font-size: .95rem; font-weight: 600; cursor: pointer; margin-top: 8px; font-family: 'DM Sans', sans-serif; transition: background .2s; }
        .btn:hover { background: #1D4ED8; }
        .btn-ghost { background: transparent; border: 1px solid #334155; color: #94A3B8; margin-top: 8px; }
        .btn-ghost:hover { background: #0F172A; }
        .error { background: rgba(220,38,38,.15); border: 1px solid rgba(220,38,38,.3); color: #FCA5A5; border-radius: 8px; padding: 10px 14px; font-size: .85rem; margin-bottom: 16px; text-align: left; }
        .success { background: rgba(5,150,105,.15); border: 1px solid rgba(5,150,105,.3); color: #6EE7B7; border-radius: 8px; padding: 10px 14px; font-size: .85rem; margin-bottom: 16px; text-align: left; }
        .back { margin-top: 16px; font-size: .85rem; color: #475569; }
        .back a { color: #60A5FA; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">📧</div>
        <h1>Check your email</h1>
        <p>We sent a 6-digit code to <strong>{{ $email }}</strong></p>

        @if($errors->any())
        <div class="error">{{ $errors->first() }}</div>
        @endif

        @if(session('success'))
        <div class="success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="/pro/verify?email={{ urlencode($email) }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <div class="form-group">
                <label>Verification code</label>
                <input type="text" name="code" maxlength="6" placeholder="000000"
                    autocomplete="one-time-code" autofocus required>
            </div>
            <button type="submit" class="btn">Verify Email</button>
        </form>

        <form method="POST" action="/pro/resend" style="margin-top:10px">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <button type="submit" class="btn btn-ghost">Resend code</button>
        </form>

        <div class="back"><a href="/pro/login">← Back to login</a></div>
    </div>
</body>
</html>