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
        .sidebar { width:240px; background:#060D1A; border-right:1px solid #1E293B; display:flex; flex-direction:column; position:fixed; top:0; left:0; height:100vh; overflow-y:auto; }
        .sidebar-brand { padding:24px 20px; border-bottom:1px solid #1E293B; display:flex; align-items:center; gap:10px; }
        .brand-icon { width:36px; height:36px; background:var(--blue); border-radius:9px; display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:800; font-size:1.1rem; }
        .brand-text span { display:block; font-family:'Syne',sans-serif; font-weight:700; font-size:1rem; }
        .brand-text small { font-size:.68rem; color:#60A5FA; font-weight:600; letter-spacing:.06em; }
        .sidebar-nav { padding:16px 12px; flex:1; }
        .nav-section { font-size:.65rem; font-weight:700; letter-spacing:.1em; color:#334155; padding:14px 8px 6px; }
        .nav-item { display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:8px; color:#64748B; text-decoration:none; font-size:.88rem; font-weight:500; transition:all .2s; margin-bottom:2px; position:relative; }
        .nav-item:hover { background:#1E293B; color:#fff; }
        .nav-item.active { background:#1E293B; color:#60A5FA; }
        .nav-badge { position:absolute; right:10px; background:#EF4444; color:#fff; font-size:.65rem; font-weight:700; padding:2px 6px; border-radius:20px; }
        .sidebar-footer { padding:16px 12px; border-top:1px solid #1E293B; }
        .pro-info { display:flex; align-items:center; gap:10px; padding:10px 12px; background:#1E293B; border-radius:8px; margin-bottom:8px; }
        .pro-avatar-sm { width:36px; height:36px; background:var(--blue); border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:700; font-size:.85rem; overflow:hidden; flex-shrink:0; }
        .pro-avatar-sm img { width:100%; height:100%; object-fit:cover; }
        .pro-details span { display:block; font-size:.82rem; font-weight:600; }
        .pro-details small { font-size:.72rem; color:var(--muted); }
        .main { margin-left:240px; flex:1; background:#0A1628; min-height:100vh; }
        .topbar { background:#060D1A; border-bottom:1px solid #1E293B; padding:0 28px; height:60px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:50; }
        .topbar h1 { font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:700; }
        .status-badge { display:flex; align-items:center; gap:6px; font-size:.78rem; font-weight:600; color:#34D399; }
        .status-dot { width:7px; height:7px; background:#34D399; border-radius:50%; animation:pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1}50%{opacity:.5} }
        .content { padding:28px; }
        .stats-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(155px,1fr)); gap:14px; margin-bottom:28px; }
        .stat-card { background:#1E293B; border:1px solid #334155; border-radius:12px; padding:18px 20px; }
        .stat-label { font-size:.75rem; color:var(--muted); margin-bottom:6px; font-weight:500; }
        .stat-val { font-family:'Syne',sans-serif; font-size:1.8rem; font-weight:800; }
        .stat-val.blue { color:#60A5FA; } .stat-val.green { color:#34D399; } .stat-val.amber { color:#FCD34D; }
        .grid2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
        .card { background:#1E293B; border:1px solid #334155; border-radius:12px; padding:20px; }
        .card-title { font-family:'Syne',sans-serif; font-weight:700; font-size:.95rem; margin-bottom:16px; color:#E2E8F0; display:flex; justify-content:space-between; align-items:center; }
        table { width:100%; border-collapse:collapse; font-size:.84rem; }
        th { text-align:left; padding:8px 12px; font-size:.7rem; font-weight:700; letter-spacing:.05em; color:var(--muted); border-bottom:1px solid #334155; }
        td { padding:12px; border-bottom:1px solid #1E293B; vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        .badge { padding:3px 10px; border-radius:20px; font-size:.7rem; font-weight:700; display:inline-block; }
        .badge-pending   { background:rgba(252,211,77,.1); color:#FCD34D; }
        .badge-confirmed { background:rgba(96,165,250,.1); color:#60A5FA; }
        .badge-completed { background:rgba(52,211,153,.1); color:#34D399; }
        .badge-cancelled { background:rgba(252,165,165,.1); color:#FCA5A5; }
        .btn { padding:6px 14px; border-radius:7px; font-size:.8rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; display:inline-flex; align-items:center; gap:5px; transition:all .2s; font-family:'DM Sans',sans-serif; }
        .btn-blue { background:var(--blue); color:#fff; }
        .btn-ghost { background:#334155; color:#94A3B8; }
        select.status-select { background:#0F172A; border:1px solid #334155; color:#fff; border-radius:6px; padding:4px 8px; font-size:.78rem; cursor:pointer; }
        .notif-item { display:flex; gap:10px; padding:10px; background:#0F172A; border-radius:8px; border:1px solid #1E293B; margin-bottom:8px; }
        .notif-title { font-size:.83rem; font-weight:600; color:#E2E8F0; margin-bottom:2px; }
        .notif-body  { font-size:.75rem; color:var(--muted); }
        .not-active { background:rgba(217,119,6,.08); border:1px solid rgba(217,119,6,.2); color:#FDE68A; border-radius:10px; padding:12px 16px; font-size:.85rem; margin-bottom:20px; }
        .empty { text-align:center; color:var(--muted); padding:28px; font-size:.85rem; }
        .alert-success { background:rgba(52,211,153,.1); border:1px solid rgba(52,211,153,.2); color:#34D399; border-radius:8px; padding:10px 16px; margin-bottom:20px; font-size:.88rem; }
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
        <a href="/pro/dashboard" class="nav-item {{ request()->is('pro/dashboard') ? 'active' : '' }}">📊 Dashboard</a>
        <div class="nav-section">WORK</div>
        <a href="/pro/bookings" class="nav-item {{ request()->is('pro/bookings*') ? 'active' : '' }}">
            📅 Bookings
            @if($stats['pending'] > 0)<span class="nav-badge">{{ $stats['pending'] }}</span>@endif
        </a>
        <a href="/pro/messages" class="nav-item {{ request()->is('pro/messages*') ? 'active' : '' }}">
            💬 Messages
            @if($unreadMessages > 0)<span class="nav-badge">{{ $unreadMessages }}</span>@endif
        </a>
        <div class="nav-section">ACCOUNT</div>
        <a href="/pro/profile" class="nav-item {{ request()->is('pro/profile') ? 'active' : '' }}">👤 My Profile</a>
        <a href="/" target="_blank" class="nav-item">🌐 View Site</a>
    </nav>
    <div class="sidebar-footer">
        <div class="pro-info">
            <div class="pro-avatar-sm">
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
            <button type="submit" class="btn btn-ghost" style="width:100%;justify-content:center;margin-top:4px">Sign Out</button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <h1>Dashboard</h1>
        <div style="display:flex;align-items:center;gap:16px">
            @if($pro->is_active)
            <div class="status-badge"><span class="status-dot"></span>Active</div>
            @endif
            <span style="font-size:.78rem;color:var(--muted)">{{ date('M j, Y') }}</span>
        </div>
    </div>

    <div class="content">
        @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(!$pro->is_active)
        <div class="not-active">⏳ Your account is pending admin approval. You can set up your profile while waiting.</div>
        @endif

        {{-- STATS --}}
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Bookings</div>
                <div class="stat-val blue">{{ $stats['bookings'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pending</div>
                <div class="stat-val amber">{{ $stats['pending'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Confirmed</div>
                <div class="stat-val blue">{{ $stats['confirmed'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Completed</div>
                <div class="stat-val green">{{ $stats['completed'] }}</div>
            </div>
        </div>

        <div class="grid2">
            {{-- RECENT BOOKINGS --}}
            <div class="card" style="grid-column:1/-1">
                <div class="card-title">
                    Recent Bookings
                    <a href="/pro/bookings" class="btn btn-ghost" style="font-size:.75rem">View All →</a>
                </div>
                @if($recentBookings->isEmpty())
                <div class="empty">No bookings yet.</div>
                @else
                <table>
                    <thead>
                        <tr><th>Customer</th><th>Date</th><th>Address</th><th>Status</th><th>Update</th></tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $b)
                        <tr>
                            <td>
                                <div style="font-weight:600">{{ $b->user->name ?? '—' }}</div>
                                <div style="font-size:.75rem;color:var(--muted)">{{ $b->user->email ?? '' }}</div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($b->service_date)->format('M j') }}<br>
                                <span style="font-size:.75rem;color:var(--muted)">{{ \Carbon\Carbon::parse($b->service_time)->format('g:i A') }}</span>
                            </td>
                            <td style="font-size:.8rem;color:#94A3B8;max-width:140px">{{ $b->address }}</td>
                            <td><span class="badge badge-{{ $b->status }}">{{ ucfirst($b->status) }}</span></td>
                            <td>
                                <form method="POST" action="/pro/bookings/{{ $b->id }}">
                                    @csrf
                                    <select name="status" class="status-select" onchange="this.form.submit()">
                                        @foreach(['pending','confirmed','completed','cancelled'] as $s)
                                        <option value="{{ $s }}" {{ $b->status===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            {{-- NOTIFICATIONS --}}
            <div class="card">
                <div class="card-title">Notifications</div>
                @if($notifications->isEmpty())
                <div class="empty">No new notifications.</div>
                @else
                @foreach($notifications as $n)
                <div class="notif-item">
                    <div style="font-size:1.1rem">
                        {{ $n->type === 'new_message' ? '💬' : '📅' }}
                    </div>
                    <div>
                        <div class="notif-title">{{ $n->title }}</div>
                        <div class="notif-body">{{ $n->body }}</div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>

            {{-- QUICK LINKS --}}
            <div class="card">
                <div class="card-title">Quick Actions</div>
                <div style="display:flex;flex-direction:column;gap:10px">
                    <a href="/pro/messages" class="btn btn-blue" style="justify-content:center;padding:12px">
                        💬 View Messages
                        @if($unreadMessages > 0)
                        <span style="background:rgba(255,255,255,.2);padding:1px 8px;border-radius:20px;font-size:.75rem">{{ $unreadMessages }} new</span>
                        @endif
                    </a>
                    <a href="/pro/bookings" class="btn btn-ghost" style="justify-content:center;padding:12px">📅 Manage Bookings</a>
                    <a href="/pro/profile" class="btn btn-ghost" style="justify-content:center;padding:12px">👤 Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>