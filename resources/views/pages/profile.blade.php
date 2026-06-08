@extends('layouts.app')

@section('content')
<div style="max-width:900px;margin:0 auto;padding:40px 24px 80px">

    <h1 style="font-family:'Syne',sans-serif;font-weight:800;font-size:1.8rem;margin-bottom:32px">My Account</h1>

    @if(session('success'))
    <div class="alert-success-box" style="margin-bottom:24px">✓ {{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="form-error-box" style="margin-bottom:24px">{{ $errors->first() }}</div>
    @endif

    <div style="display:grid;grid-template-columns:280px 1fr;gap:24px;align-items:start">

        {{-- LEFT SIDEBAR --}}
        <div>
            {{-- PROFILE CARD --}}
            <div style="background:#fff;border:1.5px solid var(--gray-border);border-radius:20px;padding:28px 20px;text-align:center;margin-bottom:16px">
                <div id="avatar-display" style="width:80px;height:80px;border-radius:50%;background:var(--blue-light);margin:0 auto 14px;overflow:hidden;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:1.4rem;color:var(--blue);cursor:pointer;border:3px solid var(--gray-border)" onclick="document.getElementById('avatar-input').click()">
                    @if(Auth::user()->avatar_url)
                        <img src="{{ Auth::user()->avatar_url }}" style="width:100%;height:100%;object-fit:cover">
                    @else
                        {{ Auth::user()->initials }}
                    @endif
                </div>
                <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.1rem">{{ Auth::user()->name }}</div>
                <div style="font-size:.85rem;color:var(--gray-mid);margin-top:4px">{{ Auth::user()->email }}</div>
                <div style="margin-top:12px">
                    <span style="background:var(--blue-light);color:var(--blue);font-size:.75rem;font-weight:700;padding:4px 12px;border-radius:20px">
                        ✓ Verified Member
                    </span>
                </div>
            </div>

            {{-- QUICK STATS --}}
            <div style="background:#fff;border:1.5px solid var(--gray-border);border-radius:16px;padding:20px">
                <div style="font-family:'Syne',sans-serif;font-weight:700;font-size:.9rem;margin-bottom:14px">My Activity</div>
                <div style="display:flex;flex-direction:column;gap:10px">
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:.88rem">
                        <span style="color:var(--gray-mid)">Total Bookings</span>
                        <span style="font-weight:700">{{ Auth::user()->bookings()->count() }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:.88rem">
                        <span style="color:var(--gray-mid)">Completed</span>
                        <span style="font-weight:700;color:#059669">{{ Auth::user()->bookings()->where('status','completed')->count() }}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:center;font-size:.88rem">
                        <span style="color:var(--gray-mid)">Pending</span>
                        <span style="font-weight:700;color:#D97706">{{ Auth::user()->bookings()->where('status','pending')->count() }}</span>
                    </div>
                </div>
                <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--gray-border)">
                    <a href="/my-bookings" class="btn-outline" style="display:block;text-align:center;font-size:.85rem">View All Bookings</a>
                </div>
                <div style="margin-top:8px">
                    <a href="/messages" class="btn-primary" style="display:flex;justify-content:center;font-size:.85rem;padding:9px">💬 My Messages</a>
                </div>
            </div>
        </div>

        {{-- RIGHT CONTENT --}}
        <div>
            {{-- TABS --}}
            <div style="display:flex;gap:0;margin-bottom:20px;background:#fff;border:1.5px solid var(--gray-border);border-radius:14px;padding:5px;">
                <button onclick="showTab('edit-profile')" id="tab-edit" style="flex:1;padding:10px;border:none;border-radius:10px;font-family:'Syne',sans-serif;font-weight:700;font-size:.88rem;cursor:pointer;background:var(--blue);color:#fff;transition:all .2s">Edit Profile</button>
                <button onclick="showTab('change-password')" id="tab-password" style="flex:1;padding:10px;border:none;border-radius:10px;font-family:'Syne',sans-serif;font-weight:700;font-size:.88rem;cursor:pointer;background:transparent;color:var(--gray-mid);transition:all .2s">Change Password</button>
            </div>

            {{-- EDIT PROFILE --}}
            <div id="edit-profile" style="background:#fff;border:1.5px solid var(--gray-border);border-radius:20px;padding:28px;margin-bottom:20px">
                <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--gray-border)">
                    Edit Profile
                </h2>

                <form method="POST" action="/profile" enctype="multipart/form-data" class="auth-form">
                    @csrf
                    <input type="file" name="photo" id="avatar-input" accept="image/*" style="display:none"
                        onchange="previewUserAvatar(this)">

                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email address</label>
                        <input type="email" value="{{ Auth::user()->email }}" disabled style="background:var(--gray-light);color:var(--gray-mid);cursor:not-allowed">
                        <small style="font-size:.75rem;color:var(--gray-mid)">Email cannot be changed</small>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" value="{{ Auth::user()->phone }}" placeholder="+63 9XX XXX XXXX">
                    </div>
                    <div class="form-group">
                        <label>Address</label>
                        <textarea name="address" rows="2" placeholder="Your address..." style="border:1.5px solid var(--gray-border);border-radius:10px;padding:10px 14px;width:100%;font-family:'DM Sans',sans-serif;font-size:.92rem;outline:none;resize:vertical">{{ Auth::user()->address }}</textarea>
                    </div>
                    <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px">
                        <div id="avatar-display-sm" style="width:48px;height:48px;border-radius:50%;background:var(--blue-light);overflow:hidden;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:.9rem;color:var(--blue);cursor:pointer;flex-shrink:0" onclick="document.getElementById('avatar-input').click()">
                            @if(Auth::user()->avatar_url)
                                <img src="{{ Auth::user()->avatar_url }}" style="width:100%;height:100%;object-fit:cover">
                            @else
                                {{ Auth::user()->initials }}
                            @endif
                        </div>
                        <button type="button" onclick="document.getElementById('avatar-input').click()" class="btn-outline" style="font-size:.82rem">Change Profile Photo</button>
                    </div>
                    <button type="submit" class="btn-primary">Save Changes</button>
                </form>
            </div>

            {{-- CHANGE PASSWORD --}}
            <div id="change-password" style="display:none;background:#fff;border:1.5px solid var(--gray-border);border-radius:20px;padding:28px;margin-bottom:20px">
                <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--gray-border)">
                    Change Password
                </h2>
                <form method="POST" action="/profile/password" class="auth-form">
                    @csrf
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" placeholder="••••••••" required>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" placeholder="Min. 8 characters" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation" placeholder="••••••••" required>
                    </div>
                    <button type="submit" class="btn-outline">Update Password</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
function showTab(tab) {
    document.getElementById('edit-profile').style.display = tab === 'edit-profile' ? 'block' : 'none';
    document.getElementById('change-password').style.display = tab === 'change-password' ? 'block' : 'none';
    document.getElementById('tab-edit').style.background = tab === 'edit-profile' ? 'var(--blue)' : 'transparent';
    document.getElementById('tab-edit').style.color = tab === 'edit-profile' ? '#fff' : 'var(--gray-mid)';
    document.getElementById('tab-password').style.background = tab === 'change-password' ? 'var(--blue)' : 'transparent';
    document.getElementById('tab-password').style.color = tab === 'change-password' ? '#fff' : 'var(--gray-mid)';
}

// Auto-open change password tab if there are password errors
@if($errors->has('current_password') || $errors->has('password'))
document.addEventListener('DOMContentLoaded', () => showTab('change-password'));
@endif

function previewUserAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            ['avatar-display', 'avatar-display-sm'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.innerHTML = '<img src="'+e.target.result+'" style="width:100%;height:100%;object-fit:cover;border-radius:50%">';
            });
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection