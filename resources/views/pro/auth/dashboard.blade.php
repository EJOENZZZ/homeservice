    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — HomeFix Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --blue:#2563EB; --sidebar:#0F172A; --sidebar-hover:#1E293B; --border:#1E293B; --text:#fff; --muted:#64748B; --green:#059669; --amber:#D97706; --red:#DC2626; }
        body { font-family:'DM Sans',sans-serif; background:#0F172A; color:var(--text); display:flex; min-height:100vh; }
        .sidebar { width:240px; background:var(--sidebar); border-right:1px solid var(--border); display:flex; flex-direction:column; position:fixed; top:0; left:0; height:100vh; overflow-y:auto; }
        .sidebar-brand { padding:24px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
        .brand-icon { width:36px; height:36px; background:var(--blue); border-radius:9px; display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:800; font-size:1.1rem; }
        .brand-text span { display:block; font-family:'Syne',sans-serif; font-weight:700; font-size:1rem; }
        .brand-text small { font-size:.68rem; color:#60A5FA; font-weight:600; letter-spacing:.06em; }
        .sidebar-nav { padding:16px 12px; flex:1; }
        .nav-section { font-size:.65rem; font-weight:700; letter-spacing:.1em; color:#334155; padding:14px 8px 6px; }
        .nav-item { display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:8px; color:#64748B; text-decoration:none; font-size:.88rem; font-weight:500; transition:all .2s; margin-bottom:2px; position:relative; }
        .nav-item:hover, .nav-item.active { background:var(--sidebar-hover); color:#fff; }
        .nav-item.active { color:#60A5FA; }
        .nav-badge { position:absolute; right:10px; background:#EF4444; color:#fff; font-size:.65rem; font-weight:700; padding:2px 6px; border-radius:20px; }
        .sidebar-footer { padding:16px 12px; border-top:1px solid var(--border); }
        .pro-info { display:flex; align-items:center; gap:10px; padding:10px 12px; background:var(--sidebar-hover); border-radius:8px; margin-bottom:8px; }
        .pro-avatar { width:36px; height:36px; background:var(--blue); border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:700; font-size:.85rem; overflow:hidden; flex-shrink:0; }
        .pro-avatar img { width:100%; height:100%; object-fit:cover; }
        .pro-details span { display:block; font-size:.82rem; font-weight:600; }
        .pro-details small { font-size:.72rem; color:var(--muted); }
        .main { margin-left:240px; flex:1; background:#0F172A; min-height:100vh; }
        .topbar { background:#0F172A; border-bottom:1px solid var(--border); padding:0 28px; height:60px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:50; }
        .topbar h1 { font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:700; }
        .topbar-right { display:flex; align-items:center; gap:12px; }
        .status-badge { display:flex; align-items:center; gap:6px; font-size:.78rem; font-weight:600; color:var(--green); }
        .status-dot { width:7px; height:7px; background:var(--green); border-radius:50%; }
        .content { padding:28px; }
        .stats-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:14px; margin-bottom:28px; }
        .stat-card { background:#1E293B; border:1px solid #334155; border-radius:12px; padding:18px 20px; }
        .stat-label { font-size:.75rem; color:var(--muted); margin-bottom:6px; font-weight:500; }
        .stat-val { font-family:'Syne',sans-serif; font-size:1.8rem; font-weight:800; }
        .stat-val.blue { color:var(--blue); } .stat-val.green { color:var(--green); } .stat-val.amber { color:var(--amber); }
        .card { background:#1E293B; border:1px solid #334155; border-radius:12px; padding:20px; margin-bottom:20px; }
        .card-title { font-family:'Syne',sans-serif; font-weight:700; font-size:.95rem; margin-bottom:16px; color:#E2E8F0; }
        table { width:100%; border-collapse:collapse; font-size:.85rem; }
        th { text-align:left; padding:8px 12px; font-size:.72rem; font-weight:700; letter-spacing:.05em; color:var(--muted); border-bottom:1px solid #334155; }
        td { padding:12px; border-bottom:1px solid #1E293B; vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        .badge { padding:3px 10px; border-radius:20px; font-size:.7rem; font-weight:700; letter-spacing:.04em; display:inline-block; }
        .badge-pending   { background:rgba(217,119,6,.15); color:#FCD34D; }
        .badge-confirmed { background:rgba(37,99,235,.15); color:#60A5FA; }
        .badge-completed { background:rgba(5,150,105,.15); color:#6EE7B7; }
        .badge-cancelled { background:rgba(220,38,38,.15); color:#FCA5A5; }
        .btn { padding:6px 14px; border-radius:7px; font-size:.8rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; display:inline-flex; align-items:center; gap:5px; transition:all .2s; font-family:'DM Sans',sans-serif; }
        .btn-blue   { background:var(--blue); color:#fff; }
        .btn-ghost  { background:#334155; color:#94A3B8; }
        .btn-ghost:hover { background:#475569; color:#fff; }
        select.status-select { background:#0F172A; border:1px solid #334155; color:#fff; border-radius:6px; padding:4px 8px; font-size:.78rem; cursor:pointer; }
        .notif-list { display:flex; flex-direction:column; gap:8px; }
        .notif-item { display:flex; gap:12px; padding:10px 12px; background:#0F172A; border-radius:8px; border:1px solid #1E293B; }
        .notif-icon { font-size:1.1rem; flex-shrink:0; }
        .notif-title { font-size:.85rem; font-weight:600; color:#E2E8F0; margin-bottom:2px; }
        .notif-body  { font-size:.78rem; color:var(--muted); }
        .empty { text-align:center; color:var(--muted); padding:32px; font-size:.88rem; }
        .not-active { background:rgba(217,119,6,.1); border:1px solid rgba(217,119,6,.3); color:#FDE68A; border-radius:10px; padding:12px 16px; font-size:.85rem; margin-bottom:20px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">H</div>
        <div class="brand-text">
            <span>HomeFix</span>
            <small>PRO PORTAL</small>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">OVERVIEW</div>
        <a href="/pro/dashboard" class="nav-item {{ request()->is('pro/dashboard') ? 'active' : '' }}">
            📊 Dashboard
        </a>
        <div class="nav-section">WORK</div>
        <a href="/pro/bookings" class="nav-item {{ request()->is('pro/bookings*') ? 'active' : '' }}">
            📅 Bookings
            @if(isset($stats) && $stats['pending'] > 0)
            <span class="nav-badge">{{ $stats['pending'] }}</span>
            @endif
        </a>
        <a href="/pro/messages" class="nav-item {{ request()->is('pro/messages*') ? 'active' : '' }}">
            💬 Messages
            @if(isset($unreadMessages) && $unreadMessages > 0)
            <span class="nav-badge">{{ $unreadMessages }}</span>
            @endif
        </a>
        <div class="nav-section">ACCOUNT</div>
        <a href="/pro/profile" class="nav-item {{ request()->is('pro/profile') ? 'active' : '' }}">
            👤 My Profile
        </a>
        <a href="/" target="_blank" class="nav-item">🌐 View Site</a>
    </nav>
    <div class="sidebar-footer">
        <div class="pro-info">
            <div class="pro-avatar">
                @if($pro->avatar_url)
                    <img src="{{ $pro->avatar_url }}" alt="{{ $pro->first_name }}">
                @else
                    {{ $pro->initials }}
                @endif
            </div>
            <div class="pro-details">
                <span>{{ $pro->full_name }}</span>
                <small>{{ $pro->specialty }}</small>
            </div>
        </div>
        <form method="POST" action="/pro/logout">
            @csrf
            <button type="submit" class="btn btn-ghost" style="width:100%;justify-content:center">Sign Out</button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <h1>@yield('page-title', 'Dashboard')</h1>
        <div class="topbar-right">
            @if($pro->is_active)
            <div class="status-badge"><span class="status-dot"></span> Active</div>
            @endif
            <span style="font-size:.8rem;color:var(--muted)">{{ date('M j, Y') }}</span>
        </div>
    </div>
    <div class="content">
        @if(session('success'))
        <div style="background:rgba(5,150,105,.15);border:1px solid rgba(5,150,105,.3);color:#6EE7B7;border-radius:8px;padding:10px 16px;margin-bottom:20px;font-size:.88rem">
            {{ session('success') }}
        </div>
        @endif

        @if(!$pro->is_active)
        <div class="not-active">
            ⏳ Your account is pending admin approval. You can set up your profile while waiting.
        </div>
        @endif

        @yield('content')
    </div>
</div>

</body>
</html>