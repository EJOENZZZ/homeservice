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
            {{-- EDIT PROFILE --}}
            <div style="background:#fff;border:1.5px solid var(--gray-border);border-radius:20px;padding:28px;margin-bottom:20px">
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
            <div style="background:#fff;border:1.5px solid var(--gray-border);border-radius:20px;padding:28px;margin-bottom:20px">
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

            {{-- RECENT BOOKINGS --}}
            <div style="background:#fff;border:1.5px solid var(--gray-border);border-radius:20px;padding:28px">
                <h2 style="font-family:'Syne',sans-serif;font-weight:700;font-size:1.05rem;margin-bottom:20px;padding-bottom:14px;border-bottom:1px solid var(--gray-border)">
                    Recent Bookings
                </h2>
                @forelse($bookings as $b)
                <div style="display:flex;align-items:center;gap:14px;padding:12px 0;border-bottom:1px solid var(--gray-border)">
                    <div style="width:44px;height:44px;border-radius:50%;background:var(--blue-light);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:.85rem;color:var(--blue);overflow:hidden;flex-shrink:0">
                        @if($b->professional && $b->professional->avatar_url)
                            <img src="{{ $b->professional->avatar_url }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                            {{ $b->professional ? $b->professional->initials : '?' }}
                        @endif
                    </div>
                    <div style="flex:1">
                        <div style="font-weight:600;font-size:.9rem">{{ $b->professional ? $b->professional->full_name : 'Unknown' }}</div>
                        <div style="font-size:.78rem;color:var(--gray-mid)">{{ $b->professional->specialty ?? '' }} · {{ \Carbon\Carbon::parse($b->service_date)->format('M j, Y') }}</div>
                    </div>
                    <span style="padding:3px 10px;border-radius:20px;font-size:.72rem;font-weight:700;background:{{ $b->status==='completed'?'#ECFDF5':($b->status==='pending'?'#FEF3C7':'#EFF6FF') }};color:{{ $b->status==='completed'?'#059669':($b->status==='pending'?'#D97706':'#2563EB') }}">
                        {{ ucfirst($b->status) }}
                    </span>
                </div>
                @empty
                <div style="text-align:center;color:var(--gray-mid);padding:24px;font-size:.88rem">No bookings yet.</div>
                @endforelse
                @if($bookings->count() >= 5)
                <div style="margin-top:16px;text-align:center">
                    <a href="/my-bookings" class="btn-outline" style="font-size:.85rem">View All Bookings</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
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