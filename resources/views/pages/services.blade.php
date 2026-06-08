@extends('layouts.app')

@section('content')
<div class="page-wrap" style="padding-top:40px">
    <div class="services-results-header">
        <span class="services-count">{{ count($professionals) }} professional{{ count($professionals) != 1 ? 's' : '' }} found</span>
    </div>

    @if(count($professionals) === 0)
    <div class="empty-state">
        <div style="font-size:3rem;margin-bottom:16px">🔍</div>
        <h3 style="font-family:'Syne',sans-serif;font-weight:700;margin-bottom:8px">No professionals found</h3>
        <p>Try a different service or location.</p>
        <a href="/services" class="btn-primary" style="display:inline-flex;margin-top:20px">View All Pros</a>
    </div>
    @else
    <div class="pros-list">
        @foreach($professionals as $pro)
        <div class="pro-list-card">
            <div class="pro-list-left">
                <div class="pro-list-avatar">
                    @if($pro->avatar_url)
                        <img src="{{ $pro->avatar_url }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%">
                    @else
                        {{ strtoupper(substr($pro->first_name,0,1).substr($pro->last_name,0,1)) }}
                    @endif
                </div>
            </div>
            <div class="pro-list-body">
                <div class="pro-list-top">
                    <div>
                        <span class="pro-badge-inline {{ strtolower(str_replace(' ','',$pro->badge)) }}">{{ $pro->badge }}</span>
                        <h3 class="pro-list-name">{{ $pro->first_name }} {{ $pro->last_name }}</h3>
                        <p class="pro-list-spec">{{ $pro->specialty }}</p>
                    </div>
                    <div class="pro-list-rating">
                        <span class="star">★</span>
                        <span class="pro-rating-num">{{ number_format($pro->rating,2) }}</span>
                        <span class="pro-jobs-count">{{ $pro->jobs_count }} jobs</span>
                    </div>
                </div>

                @if(!empty($pro->bio))
                <p class="pro-list-bio">{{ $pro->bio }}</p>
                @endif

                <div class="pro-list-meta">
                    @if(!empty($pro->location))
                    <span class="pro-meta-item">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                        {{ $pro->location }}
                    </span>
                    @endif
                    @if(!empty($pro->hourly_rate))
                    <span class="pro-meta-item">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                        ₱{{ number_format($pro->hourly_rate) }}/hr
                    </span>
                    @endif
                    <span class="pro-meta-item pro-available">
                        <span class="available-dot"></span> Available Now
                    </span>
                </div>
            </div>
            <div class="pro-list-actions">
                <a href="/pros/{{ $pro->id }}" class="btn-outline">View Profile</a>
                <a href="/book?professional_id={{ $pro->id }}" class="btn-primary">Book Now</a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
.services-hero {
    background: var(--gray-light);
    border-bottom: 1px solid var(--gray-border);
    padding: 64px 24px 48px;
    text-align: center;
}
.services-hero-inner { max-width: 800px; margin: 0 auto; }
.services-filter-bar {
    display: flex; align-items: center; flex-wrap: wrap; gap: 10px;
    margin-bottom: 24px;
}
.services-results-header {
    margin-bottom: 24px;
}
.services-count {
    font-size: .88rem; color: var(--gray-mid); font-weight: 500;
}
.pros-list { display: flex; flex-direction: column; gap: 16px; }
.pro-list-card {
    background: #fff;
    border: 1.5px solid var(--gray-border);
    border-radius: 16px;
    padding: 28px;
    display: flex;
    gap: 24px;
    align-items: flex-start;
    transition: box-shadow .2s, transform .2s;
}
.pro-list-card:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
.pro-list-avatar {
    width: 72px; height: 72px; background: var(--blue-light);
    border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.2rem;
    color: var(--blue); flex-shrink: 0; overflow: hidden;
}
.pro-list-body { flex: 1; min-width: 0; }
.pro-list-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 10px; flex-wrap: wrap; }
.pro-badge-inline {
    display: inline-block; font-size: .7rem; font-weight: 700;
    letter-spacing: .06em; padding: 3px 10px; border-radius: 20px; margin-bottom: 6px;
}
.pro-badge-inline.elite    { background: #FEF3C7; color: #D97706; }
.pro-badge-inline.toppro   { background: #EFF6FF; color: var(--blue); }
.pro-badge-inline.verified { background: #ECFDF5; color: #059669; }
.pro-list-name { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.15rem; margin-bottom: 2px; }
.pro-list-spec { color: var(--gray-mid); font-size: .88rem; }
.pro-list-rating { display: flex; align-items: center; gap: 6px; flex-shrink: 0; }
.pro-rating-num { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1.05rem; }
.pro-jobs-count { font-size: .82rem; color: var(--gray-mid); }
.pro-list-bio { font-size: .9rem; color: var(--gray-dark); line-height: 1.65; margin-bottom: 14px; }
.pro-list-meta { display: flex; align-items: center; flex-wrap: wrap; gap: 16px; }
.pro-meta-item { display: flex; align-items: center; gap: 5px; font-size: .82rem; color: var(--gray-mid); }
.pro-available { color: #059669; font-weight: 600; }
.available-dot { width: 7px; height: 7px; background: #059669; border-radius: 50%; display: inline-block; }
.pro-list-actions { display: flex; flex-direction: column; gap: 10px; flex-shrink: 0; }
@media (max-width: 640px) {
    .pro-list-card { flex-direction: column; }
    .pro-list-actions { flex-direction: row; }
    .pro-list-left { display: none; }
}
</style>
@endsection
