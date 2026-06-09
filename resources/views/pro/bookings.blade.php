<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings — HomeFix Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --blue:#2563EB; --border:#1E293B; --muted:#64748B; }
        body { font-family:'DM Sans',sans-serif; background:#0A1628; color:#fff; display:flex; min-height:100vh; }
        .sidebar { width:240px; background:#060D1A; border-right:1px solid var(--border); display:flex; flex-direction:column; position:fixed; top:0; left:0; height:100vh; }
        .sidebar-brand { padding:24px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
        .brand-icon { width:36px; height:36px; background:var(--blue); border-radius:9px; display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:800; font-size:1.1rem; }
        .brand-text span { display:block; font-family:'Syne',sans-serif; font-weight:700; font-size:1rem; }
        .brand-text small { font-size:.68rem; color:#60A5FA; font-weight:600; letter-spacing:.06em; }
        .sidebar-nav { padding:16px 12px; flex:1; }
        .nav-section { font-size:.65rem; font-weight:700; letter-spacing:.1em; color:#334155; padding:14px 8px 6px; }
        .nav-item { display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:8px; color:#64748B; text-decoration:none; font-size:.88rem; font-weight:500; transition:all .2s; margin-bottom:2px; position:relative; }
        .nav-item:hover { background:#1E293B; color:#fff; }
        .nav-item.active { background:#1E293B; color:#60A5FA; }
        .sidebar-footer { padding:16px 12px; border-top:1px solid var(--border); }
        .pro-info { display:flex; align-items:center; gap:10px; padding:10px 12px; background:#1E293B; border-radius:8px; margin-bottom:8px; }
        .pro-av { width:36px; height:36px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:700; font-size:.85rem; overflow:hidden; flex-shrink:0; }
        .pro-av img { width:100%; height:100%; object-fit:cover; }
        .pro-det span { display:block; font-size:.82rem; font-weight:600; }
        .pro-det small { font-size:.72rem; color:var(--muted); }
        .main { margin-left:240px; flex:1; }
        .topbar { background:#060D1A; border-bottom:1px solid var(--border); padding:0 28px; height:60px; display:flex; align-items:center; justify-content:space-between; }
        .topbar h1 { font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:700; }
        .content { padding:28px; }
        .card { background:#1E293B; border:1px solid #334155; border-radius:12px; padding:20px; }
        .card-title { font-family:'Syne',sans-serif; font-weight:700; font-size:.95rem; margin-bottom:16px; color:#E2E8F0; }
        table { width:100%; border-collapse:collapse; font-size:.84rem; }
        th { text-align:left; padding:8px 12px; font-size:.7rem; font-weight:700; letter-spacing:.05em; color:var(--muted); border-bottom:1px solid #334155; }
        td { padding:12px; border-bottom:1px solid #1E293B; vertical-align:middle; }
        tr:last-child td { border-bottom:none; }
        .badge { padding:3px 10px; border-radius:20px; font-size:.7rem; font-weight:700; display:inline-block; }
        .badge-pending   { background:rgba(252,211,77,.1); color:#FCD34D; }
        .badge-confirmed { background:rgba(96,165,250,.1); color:#60A5FA; }
        .badge-completed { background:rgba(52,211,153,.1); color:#34D399; }
        .badge-cancelled { background:rgba(252,165,165,.1); color:#FCA5A5; }
        select.status-select { background:#0F172A; border:1px solid #334155; color:#fff; border-radius:6px; padding:5px 8px; font-size:.78rem; cursor:pointer; }
        .btn { padding:6px 14px; border-radius:7px; font-size:.8rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; font-family:'DM Sans',sans-serif; transition:all .2s; }
        .btn-ghost { background:#334155; color:#94A3B8; }
        .empty { text-align:center; color:var(--muted); padding:40px; }
        .alert-success { background:rgba(52,211,153,.1); border:1px solid rgba(52,211,153,.2); color:#34D399; border-radius:8px; padding:10px 16px; margin-bottom:20px; font-size:.88rem; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon">H</div>
        <div class="brand-text"><span>HomeFix</span><small>PRO PORTAL</small></div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">OVERVIEW</div>
        <a href="/pro/dashboard" class="nav-item">📊 Dashboard</a>
        <div class="nav-section">WORK</div>
        <a href="/pro/bookings" class="nav-item active">📅 Bookings</a>
        <a href="/pro/messages" class="nav-item">💬 Messages</a>
        <div class="nav-section">ACCOUNT</div>
        <a href="/pro/profile" class="nav-item">👤 My Profile</a>
        <a href="javascript:void(0)" class="nav-item" onclick="openContactAdminModal();return false;">✉️ Contact Admin</a>
        <a href="/" target="_blank" class="nav-item">🌐 View Site</a>
    </nav>
    <div class="sidebar-footer">
        <div class="pro-info">
            <div class="pro-av">
                @if($pro->avatar_url)<img src="{{ $pro->avatar_url }}" alt="">@else{{ $pro->initials }}@endif
            </div>
            <div class="pro-det">
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
        <h1>My Bookings</h1>
    </div>
    <div class="content">
        @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-title">All Bookings ({{ $bookings->total() }})</div>
            @if($bookings->isEmpty())
            <div class="empty">No bookings yet. Customers will appear here after they book you.</div>
            @else
            <div style="overflow-x:auto">
                <table>
                    <thead>
                        <tr><th>Customer</th><th>Date & Time</th><th>Address</th><th>Notes</th><th>Status</th><th>Update</th></tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $b)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:12px;">
                                    <div style="width:34px;height:34px;border-radius:50%;background:#1E293B;color:#60A5FA;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;overflow:hidden;flex-shrink:0;">
                                        @if($b->user?->avatar_url)
                                            <img src="{{ $b->user->avatar_url }}" alt="{{ $b->user->name ?? 'User' }}" style="width:100%;height:100%;object-fit:cover;">
                                        @else
                                            {{ $b->user?->initials ?? 'U' }}
                                        @endif
                                    </div>
                                    <div>
                                        <div style="font-weight:600;line-height:1.2">{{ $b->user->name ?? '—' }}</div>
                                        <div style="font-size:.75rem;color:#64748B;line-height:1.2">{{ $b->user->email ?? '' }}</div>
                                    </div>
                                </div>
                                @if($b->user)
                                <a href="/pro/messages" style="font-size:.75rem;color:#60A5FA;text-decoration:none">💬 Message</a>
                                @endif
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($b->service_date)->format('M j, Y') }}<br>
                                <span style="font-size:.75rem;color:#64748B">{{ \Carbon\Carbon::parse($b->service_time)->format('g:i A') }}</span>
                            </td>
                            <td style="font-size:.82rem;color:#94A3B8;max-width:150px">{{ $b->address }}</td>
                            <td style="font-size:.8rem;color:#64748B;max-width:150px">
                                <div>{{ $b->notes ?: '—' }}</div>
                                @if($b->user_rating)
                                <div style="margin-top:8px;font-size:.75rem;color:#34D399">
                                    <strong>Client rating:</strong> {{ str_repeat('⭐', (int) $b->user_rating) }}
                                    @if($b->user_review)
                                    <div style="margin-top:4px;color:#94A3B8;line-height:1.4">{{ $b->user_review }}</div>
                                    @endif
                                </div>
                                @endif
                            </td>
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
            </div>
            <div style="margin-top:16px">{{ $bookings->links() }}</div>
            @endif
        </div>
    </div>
</div>

<div id="contact-admin-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,.72);align-items:center;justify-content:center;padding:20px">
    <div style="background:#fff;color:#111827;max-width:620px;width:100%;border-radius:24px;padding:28px;box-shadow:0 24px 80px rgba(0,0,0,.28)">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:18px">
            <div>
                <div style="font-family:'Syne',sans-serif;font-size:1.2rem;font-weight:800;margin-bottom:4px">Contact Admin</div>
                <div style="font-size:.85rem;color:#64748B">Same page ra ni. Send a message to admin without leaving your bookings.</div>
            </div>
            <button type="button" onclick="closeContactAdminModal()" style="background:none;border:none;font-size:1.6rem;line-height:1;color:#64748B;cursor:pointer">&times;</button>
        </div>

        @if(session('success'))
        <div style="background:#ECFDF5;border:1px solid #A7F3D0;color:#065F46;border-radius:12px;padding:12px 14px;margin-bottom:16px">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div style="background:#FEF2F2;border:1px solid #FECACA;color:#991B1B;border-radius:12px;padding:12px 14px;margin-bottom:16px">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px">
                <div>
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#374151;margin-bottom:6px">Name</label>
                    <input type="text" value="{{ $pro->full_name }}" readonly style="width:100%;border:1.5px solid #E5E7EB;border-radius:12px;padding:12px 14px;background:#F9FAFB;color:#111827">
                </div>
                <div>
                    <label style="display:block;font-size:.82rem;font-weight:700;color:#374151;margin-bottom:6px">Email</label>
                    <input type="text" value="{{ $pro->email }}" readonly style="width:100%;border:1.5px solid #E5E7EB;border-radius:12px;padding:12px 14px;background:#F9FAFB;color:#111827">
                </div>
            </div>
            <div style="margin-bottom:14px">
                <label style="display:block;font-size:.82rem;font-weight:700;color:#374151;margin-bottom:6px">Subject</label>
                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="What do you need help with?" required style="width:100%;border:1.5px solid #E5E7EB;border-radius:12px;padding:12px 14px;outline:none">
            </div>
            <div style="margin-bottom:18px">
                <label style="display:block;font-size:.82rem;font-weight:700;color:#374151;margin-bottom:6px">Message</label>
                <textarea name="message" rows="6" placeholder="Write your message to the admin..." required style="width:100%;border:1.5px solid #E5E7EB;border-radius:12px;padding:12px 14px;outline:none;resize:vertical">{{ old('message') }}</textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap">
                <button type="button" onclick="closeContactAdminModal()" class="btn btn-ghost">Cancel</button>
                <button type="submit" class="btn btn-blue">Send to Admin</button>
            </div>
        </form>
    </div>
</div>

<script>
function openContactAdminModal() {
    const modal = document.getElementById('contact-admin-modal');
    if (modal) modal.style.display = 'flex';
}
function closeContactAdminModal() {
    const modal = document.getElementById('contact-admin-modal');
    if (modal) modal.style.display = 'none';
}
document.getElementById('contact-admin-modal')?.addEventListener('click', function(e) {
    if (e.target === this) closeContactAdminModal();
});
@if(session('success') || session('error') || $errors->any() || old('subject') || old('message'))
openContactAdminModal();
@endif
</script>

</body>
</html>