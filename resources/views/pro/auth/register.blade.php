<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as Professional — HomeFix</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', sans-serif; background: #0F172A; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px; }
        .card { background: #1E293B; border-radius: 20px; padding: 48px 40px; width: 100%; max-width: 480px; border: 1px solid #334155; }
        .brand { display: flex; align-items: center; gap: 10px; margin-bottom: 8px; justify-content: center; text-decoration: none; }
        .brand-icon { width: 40px; height: 40px; background: #2563EB; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.2rem; color: #fff; }
        .brand span { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.2rem; color: #fff; }
        .pro-badge { display: block; text-align: center; background: #172554; color: #60A5FA; font-size: .72rem; font-weight: 700; padding: 4px 14px; border-radius: 20px; letter-spacing: .08em; margin: 0 auto 28px; width: fit-content; }
        h1 { font-family: 'Syne', sans-serif; font-size: 1.5rem; font-weight: 800; color: #fff; margin-bottom: 6px; text-align: center; }
        p.sub { color: #64748B; font-size: .88rem; text-align: center; margin-bottom: 28px; }
        .row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .form-group { margin-bottom: 14px; }
        label { display: block; font-size: .82rem; font-weight: 600; color: #94A3B8; margin-bottom: 6px; }
        input, select { width: 100%; padding: 11px 14px; background: #0F172A; border: 1.5px solid #334155; border-radius: 10px; color: #fff; font-size: .9rem; font-family: 'DM Sans', sans-serif; outline: none; transition: border-color .2s; }
        input:focus, select:focus { border-color: #2563EB; }
        input::placeholder { color: #475569; }
        select option { background: #1E293B; }
        .btn { width: 100%; padding: 13px; background: #2563EB; color: #fff; border: none; border-radius: 10px; font-size: .95rem; font-weight: 600; cursor: pointer; margin-top: 8px; font-family: 'DM Sans', sans-serif; transition: background .2s; }
        .btn:hover { background: #1D4ED8; }
        .error { background: rgba(220,38,38,.15); border: 1px solid rgba(220,38,38,.3); color: #FCA5A5; border-radius: 8px; padding: 10px 14px; font-size: .85rem; margin-bottom: 16px; }
        .notice { background: rgba(234,179,8,.1); border: 1px solid rgba(234,179,8,.3); color: #FDE68A; border-radius: 8px; padding: 10px 14px; font-size: .82rem; margin-bottom: 16px; }
        .links { text-align: center; margin-top: 20px; font-size: .85rem; color: #475569; }
        .links a { color: #60A5FA; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <a href="/" class="brand">
            <div class="brand-icon">H</div>
            <span>HomeFix</span>
        </a>
        <span class="pro-badge">PROFESSIONAL PORTAL</span>
        <h1>Join as a Professional</h1>
        <p class="sub">Create your professional account</p>

        <div class="notice">
            ⚠️ Your account will be reviewed by our admin before going live.
        </div>

        @if($errors->any())
        <div class="error">
            <ul style="margin:0;padding-left:16px">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="/pro/register">
            @csrf
            <div class="row">
                <div class="form-group">
                    <label>First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="Juan" required>
                </div>
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="dela Cruz" required>
                </div>
            </div>
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="pro@email.com" required>
            </div>
            <div class="form-group">
                <label>Specialty</label>
                <select name="specialty" required>
                    <option value="">Select your specialty...</option>
                    @foreach(['Plumbing','Electrical','Carpentry','Cleaning','Painting'] as $s)
                    <option value="{{ $s }}" {{ old('specialty') === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Min. 8 characters" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn">Create Account</button>
        </form>

        <div class="links">
            <p>Already have an account? <a href="/pro/login">Sign in</a></p>
        </div>
    </div>
</body>
</html>