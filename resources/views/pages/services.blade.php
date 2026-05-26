@extends('layouts.app')

@section('content')
<div class="page-wrap">
    <h1 class="page-title">Find a Professional</h1>

    <form class="search-bar" action="/services" method="GET" style="max-width:700px;margin:0 auto 48px">
        <div class="search-field">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
            </svg>
            <input type="text" name="service" value="{{ request('service') }}" placeholder="Service (e.g. Plumbing)">
        </div>
        <div class="search-divider"></div>
        <div class="search-field">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                <circle cx="12" cy="9" r="2.5"/>
            </svg>
            <input type="text" name="location" value="{{ request('location') }}" placeholder="Location">
        </div>
        <button type="submit" class="btn-primary search-btn">Search</button>
    </form>

    <div class="popular-tags" style="margin-bottom:40px">
        <span class="pop-label">Filter:</span>
        @foreach(['Plumbing','Electrical','Carpentry','Cleaning','Painting'] as $tag)
            <a href="/services?service={{ $tag }}" class="tag {{ request('service')==$tag ? 'tag-active' : '' }}">
                {{ $tag }}
            </a>
        @endforeach
    </div>

    @if($professionals->isEmpty())
    <div class="empty-state">
        <p>No professionals found. Try a different search.</p>
    </div>
    @else
    <div class="pros-grid">
        @foreach($professionals as $pro)
        <div class="pro-card">
            <span class="pro-badge {{ strtolower(str_replace(' ','',$pro->badge)) }}">{{ $pro->badge }}</span>
            <div class="pro-avatar">{{ strtoupper(substr($pro->first_name,0,1).substr($pro->last_name,0,1)) }}</div>
            <h3 class="pro-name">{{ $pro->first_name }} {{ $pro->last_name }}</h3>
            <p class="pro-specialty">{{ $pro->specialty }}</p>
            <div class="pro-rating">
                <span class="star">★</span>
                <span>{{ number_format($pro->rating,2) }}</span>
                <span class="dot">·</span>
                <span>{{ $pro->jobs_count }} jobs</span>
            </div>
            <div style="display:flex;gap:8px;justify-content:center">
                <a href="/pros/{{ $pro->id }}" class="btn-outline">View Profile</a>
                <a href="/book?professional_id={{ $pro->id }}" class="btn-primary" style="padding:9px 20px;font-size:.88rem">Book Now</a>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection