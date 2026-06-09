<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} — HomeFix</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue: #2563EB; --blue-dark: #1D4ED8; --blue-light: #EFF6FF;
            --black: #0F0F0F; --sidebar: #0F172A; --sidebar-hover: #1E293B;
            --gray-mid: #6B7280; --gray-light: #F3F4F6; --gray-border: #E5E7EB;
            --green: #059669; --amber: #D97706; --red: #DC2626;
            --radius: 12px; --shadow: 0 1px 3px rgba(0,0,0,.07), 0 4px 16px rgba(0,0,0,.06);
        }
        body { font-family: 'DM Sans', sans-serif; background: #F8FAFC; color: var(--black); display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: 260px; background: var(--sidebar); color: #fff;
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; height: 100vh;
            z-index: 100; overflow-y: auto;
        }
        .sidebar-brand {
            padding: 24px 20px; border-bottom: 1px solid #1E293B;
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-brand .icon {
            width: 36px; height: 36px; background: var(--blue);
            border-radius: 10px; display: flex; align-items: center;
            justify-content: center; font-weight: 800; font-size: 1.1rem;
        }
        .sidebar-brand span { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.1rem; }
        .sidebar-brand small { display: block; font-size: .7rem; color: #64748B; margin-top: 1px; }
        .sidebar-nav { padding: 16px 12px; flex: 1; }
        .nav-section { font-size: .68rem; font-weight: 700; letter-spacing: .1em; color: #475569; padding: 16px 8px 8px; }
        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 8px; color: #94A3B8;
            text-decoration: none; font-size: .88rem; font-weight: 500;
            transition: all .2s; margin-bottom: 2px;
        }
        .nav-item:hover, .nav-item.active { background: var(--sidebar-hover); color: #fff; }
        .nav-item.active { color: #60A5FA; }
        .nav-icon { font-size: 1.1rem; width: 20px; text-align: center; }
        .sidebar-footer {
            padding: 16px 12px; border-top: 1px solid #1E293B;
        }
        .admin-badge {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 8px; background: #1E293B;
            margin-bottom: 8px;
        }
        .admin-avatar {
            width: 32px; height: 32px; background: var(--blue);
            border-radius: 50%; display: flex; align-items: center;
            justify-content: center; font-size: .75rem; font-weight: 700;
        }
        .admin-info { flex: 1; }
        .admin-info span { display: block; font-size: .82rem; color: #fff; font-weight: 500; }
        .admin-info small { font-size: .72rem; color: #64748B; }

        /* MAIN */
        .main { margin-left: 260px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar {
            background: #fff; border-bottom: 1px solid var(--gray-border);
            padding: 0 32px; height: 64px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar h1 { font-family: 'Syne', sans-serif; font-size: 1.2rem; font-weight: 700; }
        .content { padding: 32px; flex: 1; }

        /* CARDS */
        .card {
            background: #fff; border: 1px solid var(--gray-border);
            border-radius: var(--radius); padding: 24px;
            box-shadow: var(--shadow);
        }
        .card-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1rem; margin-bottom: 20px; }

        /* STAT CARDS */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px,1fr)); gap: 16px; margin-bottom: 32px; }
        .stat-card {
            background: #fff; border: 1px solid var(--gray-border);
            border-radius: var(--radius); padding: 20px 24px;
            box-shadow: var(--shadow);
        }
        .stat-card .label { font-size: .8rem; color: var(--gray-mid); margin-bottom: 8px; font-weight: 500; }
        .stat-card .value { font-family: 'Syne', sans-serif; font-size: 2rem; font-weight: 800; }
        .stat-card.blue .value { color: var(--blue); }
        .stat-card.green .value { color: var(--green); }
        .stat-card.amber .value { color: var(--amber); }
        .stat-card.red .value { color: var(--red); }

        /* TABLE */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: .88rem; }
        th { text-align: left; padding: 10px 16px; font-size: .75rem; font-weight: 700; letter-spacing: .05em; color: var(--gray-mid); border-bottom: 1px solid var(--gray-border); background: #F8FAFC; }
        td { padding: 14px 16px; border-bottom: 1px solid var(--gray-border); vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #F8FAFC; }

        /* BADGES */
        .badge { padding: 3px 10px; border-radius: 20px; font-size: .72rem; font-weight: 700; letter-spacing: .04em; display: inline-block; }
        .badge-pending   { background: #FEF3C7; color: var(--amber); }
        .badge-confirmed { background: var(--blue-light); color: var(--blue); }
        .badge-completed { background: #ECFDF5; color: var(--green); }
        .badge-cancelled { background: #FEF2F2; color: var(--red); }
        .badge-verified  { background: #ECFDF5; color: var(--green); }
        .badge-unverified{ background: #FEF3C7; color: var(--amber); }
        .badge-elite     { background: #FEF3C7; color: var(--amber); }
        .badge-toppro    { background: var(--blue-light); color: var(--blue); }

        /* BUTTONS */
        .btn { padding: 7px 16px; border-radius: 8px; font-size: .82rem; font-weight: 600; cursor: pointer; border: none; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: all .2s; }
        .btn-blue   { background: var(--blue); color: #fff; }
        .btn-blue:hover { background: var(--blue-dark); }
        .btn-green  { background: #ECFDF5; color: var(--green); border: 1px solid #A7F3D0; }
        .btn-green:hover { background: #D1FAE5; }
        .btn-red    { background: #FEF2F2; color: var(--red); border: 1px solid #FECACA; }
        .btn-red:hover { background: #FEE2E2; }
        .btn-amber  { background: #FEF3C7; color: var(--amber); border: 1px solid #FDE68A; }
        .btn-amber:hover { background: #FDE68A; }
        .btn-ghost  { background: var(--gray-light); color: var(--black); }
        .btn-ghost:hover { background: var(--gray-border); }

        /* FORM */
        .form-row { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px,1fr)); gap: 16px; margin-bottom: 16px; }
        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: .82rem; font-weight: 600; color: #374151; }
        .form-group input, .form-group select, .form-group textarea {
            border: 1.5px solid var(--gray-border); border-radius: 8px;
            padding: 9px 12px; font-size: .88rem; font-family: 'DM Sans', sans-serif;
            outline: none; transition: border-color .2s; background: #fff;
        }
        .form-group input:focus, .form-group select:focus { border-color: var(--blue); }

        /* ALERTS */
        .alert { padding: 12px 16px; border-radius: 8px; font-size: .88rem; margin-bottom: 20px; }
        .alert-success { background: #ECFDF5; border: 1px solid #A7F3D0; color: #065F46; }
        .alert-error   { background: #FEF2F2; border: 1px solid #FECACA; color: #991B1B; }

        /* MODAL */
        .modal-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 200; align-items: center; justify-content: center; }
        .modal-overlay.open { display: flex; }
        .modal { background: #fff; border-radius: 16px; padding: 32px; width: 100%; max-width: 560px; max-height: 90vh; overflow-y: auto; }
        .modal-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.15rem; margin-bottom: 24px; }

        /* PAGINATION */
        .pagination { display: flex; gap: 8px; margin-top: 20px; justify-content: flex-end; }
        .pagination a, .pagination span { padding: 6px 12px; border-radius: 8px; font-size: .85rem; border: 1px solid var(--gray-border); text-decoration: none; color: var(--black); }
        .pagination .active span { background: var(--blue); color: #fff; border-color: var(--blue); }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main { margin-left: 0; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="icon">H</div>
        <div>
            <span>HomeFix</span>
            <small>Admin Panel</small>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">OVERVIEW</div>
        <a href="/admin/dashboard" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span> Dashboard
        </a>

        <div class="nav-section">MANAGE</div>
        <a href="/admin/bookings" class="nav-item {{ request()->is('admin/bookings*') ? 'active' : '' }}">
            <span class="nav-icon">📅</span> Bookings
        </a>
        <a href="/admin/professionals" class="nav-item {{ request()->is('admin/professionals*') ? 'active' : '' }}">
            <span class="nav-icon">👷</span> Professionals
        </a>
        <a href="/admin/users" class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
            <span class="nav-icon">👥</span> Users
        </a>
        <a href="/admin/testimonials" class="nav-item {{ request()->is('admin/testimonials*') ? 'active' : '' }}">
            <span class="nav-icon">⭐</span> Testimonials
        </a>
        <a href="/admin/contact-messages" class="nav-item {{ request()->is('admin/contact-messages*') ? 'active' : '' }}">
            <span class="nav-icon">✉️</span> Contact Messages
            @php
                try {
                    $unread = \App\Models\ContactMessage::where('is_read', false)->count();
                } catch (\Exception $e) {
                    $unread = 0;
                }
            @endphp
            @if($unread > 0)
                <span style="margin-left:auto;background:#DC2626;color:#fff;font-size:.65rem;font-weight:700;padding:2px 7px;border-radius:20px">{{ $unread }}</span>
            @endif
        </a>

        <div class="nav-section">SITE</div>
        <a href="/" target="_blank" class="nav-item">
            <span class="nav-icon">🌐</span> View Site
        </a>
    </nav>
    <div class="sidebar-footer">
        <div class="admin-badge">
            <div class="admin-avatar">A</div>
            <div class="admin-info">
                <span>Administrator</span>
                <small>{{ session('admin_email') }}</small>
            </div>
        </div>
        <form method="POST" action="/admin/logout">
            @csrf
            <button type="submit" class="btn btn-ghost" style="width:100%;justify-content:center;">
                Sign Out
            </button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <h1>@yield('page-title', 'Dashboard')</h1>
        <div style="display:flex;align-items:center;gap:12px">
            <span style="font-size:.85rem;color:var(--gray-mid)">{{ date('F j, Y') }}</span>
        </div>
    </div>
    <div class="content">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
        @endif
        @yield('content')
    </div>
</div>

</body>
</html>