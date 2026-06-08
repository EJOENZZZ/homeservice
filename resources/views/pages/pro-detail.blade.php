@extends('layouts.app')

@section('content')

<div class="pro-profile-wrap">

    {{-- BACK --}}
    <a href="/services" class="pro-back-link">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        Back to Professionals
    </a>

    <div class="pro-profile-grid">

        {{-- LEFT SIDEBAR --}}
        <aside class="pro-sidebar">
            <div class="pro-sidebar-card">
                <div class="pro-profile-avatar">
                    @if($pro->avatar_url)
                        <img src="{{ $pro->avatar_url }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                    @else
                        {{ $pro->initials }}
                    @endif
                </div>
                <span class="pro-badge-inline {{ strtolower(str_replace(' ','',$pro->badge)) }}">{{ $pro->badge }}</span>
                <h1 class="pro-profile-name">{{ $pro->first_name }} {{ $pro->last_name }}</h1>
                <p class="pro-profile-spec">{{ $pro->specialty }}</p>

                <div class="pro-profile-rating">
                    <span class="star">★</span>
                    <span class="pro-rating-num">{{ number_format($pro->rating, 2) }}</span>
                    <span style="color:var(--gray-mid);font-size:.85rem">· {{ $pro->jobs_count }} jobs</span>
                </div>

                <div class="pro-sidebar-meta">
                    @if(!empty($pro->location))
                    <div class="pro-meta-row">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                        {{ $pro->location }}
                    </div>
                    @endif
                    @if(!empty($pro->hourly_rate))
                    <div class="pro-meta-row">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        ₱{{ number_format($pro->hourly_rate) }} / hour
                    </div>
                    @endif
                    <div class="pro-meta-row pro-available">
                        <span class="available-dot"></span>
                        Available Now
                    </div>
                </div>

                @auth
    <a href="/book?professional_id={{ $pro->id }}" class="btn-primary" style="padding:14px 40px;font-size:1rem">
        Book Now
    </a>
    <a href="/messages/{{ $pro->id }}" class="btn-outline" style="padding:14px 40px;font-size:1rem">
        💬 Message
    </a>
@else
    <a href="/login" class="btn-primary" style="padding:14px 40px;font-size:1rem">
        Log in to Book
    </a>
@endauth

                <a href="/services" class="btn-outline btn-full" style="margin-top:10px;text-align:center">
                    Browse Other Pros
                </a>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="pro-main">

            {{-- ABOUT --}}
            @if(!empty($pro->bio))
            <div class="pro-section-card">
                <h2 class="pro-section-title">About</h2>
                <p class="pro-section-text">{{ $pro->bio }}</p>
            </div>
            @endif

            {{-- STATS --}}
            <div class="pro-section-card">
                <h2 class="pro-section-title">Overview</h2>
                <div class="pro-stats-grid">
                    <div class="pro-stat-box">
                        <div class="pro-stat-val">{{ number_format($pro->rating, 2) }} ★</div>
                        <div class="pro-stat-lbl">Rating</div>
                    </div>
                    <div class="pro-stat-box">
                        <div class="pro-stat-val">{{ $pro->jobs_count }}+</div>
                        <div class="pro-stat-lbl">Jobs Done</div>
                    </div>
                    <div class="pro-stat-box">
                        <div class="pro-stat-val">< 2 hrs</div>
                        <div class="pro-stat-lbl">Response Time</div>
                    </div>
                    <div class="pro-stat-box">
                        <div class="pro-stat-val">100%</div>
                        <div class="pro-stat-lbl">Satisfaction</div>
                    </div>
                </div>
            </div>

            {{-- SERVICES OFFERED --}}
            <div class="pro-section-card">
                <h2 class="pro-section-title">Services Offered</h2>
                <div class="pro-services-list">
                    @php
                        $services = [
                            'Plumber'     => ['Pipe Installation','Leak Repair','Bathroom Renovation','Water Heater Setup','Drain Cleaning'],
                            'Electrician' => ['Wiring Installation','Panel Upgrade','Lighting Setup','Smart Home Install','Safety Inspection'],
                            'Carpenter'   => ['Custom Furniture','Cabinet Making','Door & Window Frames','Flooring','Room Renovation'],
                            'Cleaner'     => ['Deep Cleaning','Office Cleaning','Post-Construction Cleanup','Carpet Cleaning','Move-in/out Cleaning'],
                        ];
                        $list = $services[$pro->specialty] ?? ['General '.$pro->specialty.' Services'];
                    @endphp
                    @foreach($list as $service)
                    <div class="pro-service-item">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        {{ $service }}
                    </div>
                    @endforeach
                </div>
            </div>

        </main>
    </div>
</div>

<style>
.pro-profile-wrap {
    max-width: 1100px; margin: 0 auto; padding: 40px 24px 80px;
}
.pro-back-link {
    display: inline-flex; align-items: center; gap: 8px;
    color: var(--gray-mid); font-size: .88rem; text-decoration: none;
    margin-bottom: 28px; transition: color .2s;
}
.pro-back-link:hover { color: var(--blue); }
.pro-profile-grid {
    display: grid; grid-template-columns: 300px 1fr; gap: 28px; align-items: start;
}
.pro-sidebar-card {
    background: #fff; border: 1.5px solid var(--gray-border);
    border-radius: 20px; padding: 32px 24px; text-align: center;
    position: sticky; top: 84px;
}
.pro-profile-avatar {
    width: 88px; height: 88px; background: var(--blue-light);
    border-radius: 50%; margin: 0 auto 14px;
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: 1.5rem; color: var(--blue); overflow: hidden;
}
.pro-profile-name {
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: 1.3rem; margin: 10px 0 4px;
}
.pro-profile-spec { color: var(--gray-mid); font-size: .9rem; margin-bottom: 12px; }
.pro-profile-rating {
    display: flex; align-items: center; justify-content: center;
    gap: 6px; margin-bottom: 20px;
}
.pro-sidebar-meta {
    border-top: 1px solid var(--gray-border);
    padding-top: 16px; display: flex; flex-direction: column; gap: 10px;
}
.pro-meta-row {
    display: flex; align-items: center; justify-content: center;
    gap: 7px; font-size: .85rem; color: var(--gray-mid);
}
.pro-section-card {
    background: #fff; border: 1.5px solid var(--gray-border);
    border-radius: 20px; padding: 32px; margin-bottom: 20px;
}
.pro-section-title {
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: 1.1rem; margin-bottom: 16px;
}
.pro-section-text { color: var(--gray-dark); font-size: .95rem; line-height: 1.75; }
.pro-stats-grid {
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;
}
.pro-stat-box {
    background: var(--gray-light); border-radius: 12px;
    padding: 20px 12px; text-align: center;
}
.pro-stat-val {
    font-family: 'Syne', sans-serif; font-weight: 800;
    font-size: 1.3rem; margin-bottom: 4px;
}
.pro-stat-lbl { font-size: .78rem; color: var(--gray-mid); }
.pro-services-list { display: flex; flex-direction: column; gap: 12px; }
.pro-service-item {
    display: flex; align-items: center; gap: 10px;
    font-size: .92rem; color: var(--gray-dark);
}
.pro-service-item svg { color: var(--blue); flex-shrink: 0; }
@media (max-width: 768px) {
    .pro-profile-grid { grid-template-columns: 1fr; }
    .pro-sidebar-card { position: static; }
    .pro-stats-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

@endsection
