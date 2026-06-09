<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile — HomeFix Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --blue:#2563EB; --border:#1E293B; --muted:#64748B; --green:#059669; }
        body { font-family:'DM Sans',sans-serif; background:#0A1628; color:#fff; display:flex; min-height:100vh; }
        .sidebar { width:240px; background:#060D1A; border-right:1px solid var(--border); display:flex; flex-direction:column; position:fixed; top:0; left:0; height:100vh; }
        .sidebar-brand { padding:24px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; gap:10px; }
        .brand-icon { width:36px; height:36px; background:var(--blue); border-radius:9px; display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:800; font-size:1.1rem; }
        .brand-text span { display:block; font-family:'Syne',sans-serif; font-weight:700; font-size:1rem; }
        .brand-text small { font-size:.68rem; color:#60A5FA; font-weight:600; letter-spacing:.06em; }
        .sidebar-nav { padding:16px 12px; flex:1; }
        .nav-section { font-size:.65rem; font-weight:700; letter-spacing:.1em; color:#334155; padding:14px 8px 6px; }
        .nav-item { display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:8px; color:#64748B; text-decoration:none; font-size:.88rem; font-weight:500; transition:all .2s; margin-bottom:2px; }
        .nav-item:hover { background:#1E293B; color:#fff; }
        .nav-item.active { background:#1E293B; color:#60A5FA; }
        .sidebar-footer { padding:16px 12px; border-top:1px solid var(--border); }
        .pro-info { display:flex; align-items:center; gap:10px; padding:10px 12px; background:#1E293B; border-radius:8px; margin-bottom:8px; }
        .pro-av { width:36px; height:36px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:700; font-size:.85rem; overflow:hidden; flex-shrink:0; }
        .pro-av img { width:100%; height:100%; object-fit:cover; }
        .pro-det span { display:block; font-size:.82rem; font-weight:600; }
        .pro-det small { font-size:.72rem; color:var(--muted); }
        .main { margin-left:240px; flex:1; }
        .topbar { background:#060D1A; border-bottom:1px solid var(--border); padding:0 28px; height:60px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:50; }
        .topbar h1 { font-family:'Syne',sans-serif; font-size:1.1rem; font-weight:700; }
        .content { padding:28px; max-width:800px; }
        .section { background:#1E293B; border:1px solid #334155; border-radius:14px; padding:24px; margin-bottom:20px; }
        .section-title { font-family:'Syne',sans-serif; font-weight:700; font-size:1rem; margin-bottom:20px; color:#E2E8F0; border-bottom:1px solid #334155; padding-bottom:12px; }
        .avatar-wrap { display:flex; align-items:center; gap:20px; margin-bottom:24px; }
        .avatar-lg { width:80px; height:80px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-weight:700; font-size:1.4rem; overflow:hidden; flex-shrink:0; cursor:pointer; border:3px solid #334155; transition:border-color .2s; }
        .avatar-lg:hover { border-color:var(--blue); }
        .avatar-lg img { width:100%; height:100%; object-fit:cover; }
        .avatar-info span { display:block; font-size:.85rem; color:#94A3B8; margin-bottom:6px; }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px; }
        .form-group { margin-bottom:14px; }
        .form-group label { display:block; font-size:.8rem; font-weight:600; color:#94A3B8; margin-bottom:6px; }
        .form-group input, .form-group select, .form-group textarea { width:100%; padding:10px 14px; background:#0F172A; border:1.5px solid #334155; border-radius:9px; color:#fff; font-size:.9rem; font-family:'DM Sans',sans-serif; outline:none; transition:border-color .2s; }
        .form-group input:focus, .form-group textarea:focus { border-color:var(--blue); }
        .form-group input::placeholder, .form-group textarea::placeholder { color:#475569; }
        .form-group textarea { resize:vertical; min-height:100px; }
        .btn { padding:10px 24px; border-radius:9px; font-size:.88rem; font-weight:600; cursor:pointer; border:none; font-family:'DM Sans',sans-serif; transition:all .2s; }
        .btn-blue { background:var(--blue); color:#fff; }
        .btn-blue:hover { background:#1D4ED8; }
        .btn-ghost { background:#334155; color:#94A3B8; }
        .btn-ghost:hover { background:#475569; color:#fff; }
        .alert-success { background:rgba(52,211,153,.1); border:1px solid rgba(52,211,153,.2); color:#34D399; border-radius:8px; padding:10px 16px; margin-bottom:20px; font-size:.88rem; }
        .alert-error { background:rgba(252,165,165,.1); border:1px solid rgba(252,165,165,.2); color:#FCA5A5; border-radius:8px; padding:10px 16px; margin-bottom:20px; font-size:.88rem; }
        .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
        .info-item { background:#0F172A; border-radius:8px; padding:12px 14px; }
        .info-label { font-size:.72rem; font-weight:600; color:var(--muted); margin-bottom:4px; letter-spacing:.04em; }
        .info-val { font-size:.9rem; font-weight:500; }
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
        <a href="/pro/dashboard" class="nav-item">📊 Dashboard</a>
        <div class="nav-section">WORK</div>
        <a href="/pro/bookings" class="nav-item">📅 Bookings</a>
        <a href="/pro/messages" class="nav-item">💬 Messages</a>
        <div class="nav-section">ACCOUNT</div>
        <a href="/pro/profile" class="nav-item active">👤 My Profile</a>
        <a href="javascript:void(0)" class="nav-item" onclick="openContactAdminModal();return false;">✉️ Contact Admin</a>
        <a href="/" target="_blank" class="nav-item">🌐 View Site</a>
    </nav>
    <div class="sidebar-footer">
        <div class="pro-info">
            <div class="pro-av">
                @if($pro->avatar_url)
                    <img src="{{ $pro->avatar_url }}" alt="{{ $pro->first_name }}">
                @else
                    {{ $pro->initials }}
                @endif
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
        <h1>My Profile</h1>
        <span style="font-size:.78rem;color:var(--muted)">{{ date('M j, Y') }}</span>
    </div>
    <div class="content">
        @if(session('success'))
        <div class="alert-success">✓ {{ session('success') }}</div>
        @endif
        @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $e)
                <div>✕ {{ $e }}</div>
            @endforeach
        </div>
        @endif

        {{-- ACCOUNT INFO --}}
        <div class="section">
            <div class="section-title">Account Overview</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">STATUS</div>
                    <div class="info-val" style="color:{{ $pro->is_active ? '#34D399' : '#FCD34D' }}">
                        {{ $pro->is_active ? '● Active' : '● Pending Approval' }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">BADGE</div>
                    <div class="info-val">{{ $pro->badge }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">RATING</div>
                    <div class="info-val">⭐ {{ number_format($pro->rating, 2) }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">JOBS COMPLETED</div>
                    <div class="info-val">{{ number_format($pro->jobs_count) }}</div>
                </div>
                <div class="info-item" style="grid-column:1/-1">
                    <div class="info-label">EMAIL</div>
                    <div class="info-val">{{ $pro->email }}</div>
                </div>
            </div>
        </div>

        {{-- EDIT PROFILE --}}
        <div class="section">
            <div class="section-title">Edit Profile</div>

            <form method="POST" action="/pro/profile" enctype="multipart/form-data">
                @csrf

                {{-- PHOTO --}}
                <div class="avatar-wrap">
                    <div class="avatar-lg" id="avatar-preview" onclick="document.getElementById('photo-input').click()">
                        @if($pro->avatar_url)
                            <img src="{{ $pro->avatar_url }}" id="avatar-img" alt="{{ $pro->first_name }}">
                        @else
                            <span id="avatar-initials">{{ $pro->initials }}</span>
                        @endif
                    </div>
                    <div class="avatar-info">
                        <span>Profile Photo</span>
                        <button type="button" class="btn btn-ghost" style="font-size:.78rem;padding:7px 14px" onclick="document.getElementById('photo-input').click()">
                            Change Photo
                        </button>
                        <input type="file" name="photo" id="photo-input" accept="image/*" style="display:none"
                            onchange="previewAvatar(this)">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $pro->first_name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $pro->last_name) }}" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $pro->phone) }}" placeholder="+63 9XX XXX XXXX">
                    </div>
                    <div class="form-group">
                        <label>Location</label>
                        <input type="text" name="location" value="{{ old('location', $pro->location) }}" placeholder="e.g. Cebu City">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Hourly Rate (₱)</label>
                        <input type="number" name="hourly_rate" value="{{ old('hourly_rate', $pro->hourly_rate) }}" step="0.01" placeholder="0.00">
                    </div>
                    <div class="form-group">
                        <label>Years of Experience</label>
                        <input type="number" name="years_experience" value="{{ old('years_experience', $pro->years_experience) }}" min="0" placeholder="0">
                    </div>
                </div>
                <div class="form-group">
                    <label>Bio / About Me</label>
                    <textarea name="bio" placeholder="Tell clients about yourself...">{{ old('bio', $pro->bio) }}</textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Facebook URL</label>
                        <input type="url" name="facebook" value="{{ old('facebook', $pro->facebook) }}" placeholder="https://facebook.com/...">
                    </div>
                    <div class="form-group">
                        <label>Instagram URL</label>
                        <input type="url" name="instagram" value="{{ old('instagram', $pro->instagram) }}" placeholder="https://instagram.com/...">
                    </div>
                </div>
                <button type="submit" class="btn btn-blue">Save Changes</button>
            </form>
        </div>


    </div>
</div>

<div id="contact-admin-modal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,.72);align-items:center;justify-content:center;padding:20px">
    <div style="background:#fff;color:#111827;max-width:620px;width:100%;border-radius:24px;padding:28px;box-shadow:0 24px 80px rgba(0,0,0,.28)">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:12px;margin-bottom:18px">
            <div>
                <div style="font-family:'Syne',sans-serif;font-size:1.2rem;font-weight:800;margin-bottom:4px">Contact Admin</div>
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
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const preview = document.getElementById('avatar-preview');
            preview.innerHTML = '<img src="'+e.target.result+'" style="width:100%;height:100%;object-fit:cover;border-radius:50%">';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

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